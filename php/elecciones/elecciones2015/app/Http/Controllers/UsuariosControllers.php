<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

class UsuariosControllers extends Controller {

	/**
	 * Display a listing of the resource.
	 * GET /periodicos
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /periodicos/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /periodicos
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /periodicos/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /periodicos/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /periodicos/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /periodicos/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
	public function cerrar_session() {
		//echo "entra en destroy";
		SessionusuarioControllers::destroy();
		return View::make('dashboard.inicio');
	}
	
	public function autenticacion(Request $request) {
		$email = $request->input('email');
		$pass = $request->input('pass');				
		
		$sql = "select * from observador ";
		$sql .= "where email='$email' and ";
		$sql .= "contrasena='".md5($pass)."' and autorizado=1";
		
		//echo  $sql;
		$data=DB::select($sql);
		if (empty($data)) {
			Session::put('mensaje', 'Usuario y/o contrase�a invalidos o usuario no esta autorizado');

			return View::make('dashboard.inicio');
		} else {
			if (SessionusuarioControllers::validar_session($email)==1) {
				SessionusuarioControllers::destroy($email);
				//Session::put("mensaje", "Usted tiene una sesion abierta en otra maquina, esta sera cerrada !!!");
				//return View::make('dashboard.inicio');
			} //else {
				foreach ($data as $data) {
					SessionusuarioControllers::store($data->nombres,$data->apellidos,$data->id_observador,$data->privilegio,1,$email);
					return View::make('dashboard.index');
				}
			//}
		}
	}

	public function cambiar_contrasena() {
		return View::make('dashboard.cambiar_contrasena',["mensaje"=>""]);
	}

	public function cambiar_contrasena_fuera(Request $request) {
		return View::make('dashboard.cambiar_contrasena_fuera',["mensaje"=>"", "email"=>$request->email]);
	}

	public function guardar_cambiar_contrasena(Request $request) {
		$sql = "update observador set contrasena='".md5($request->contrasena1)."' where id_observador=".$request->id_observador;
		DB::update($sql);
		//echo $sql;
		$mensaje="Su contrase&ntilde;a ha sido modificada satisfactoriamennte";

		return View::make('dashboard.cambiar_contrasena',["mensaje"=>$mensaje]);
	}
	
}