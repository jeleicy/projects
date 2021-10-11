<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Auth;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use Redirect;

class AsignacionesControllers extends Controller {

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

	public function asignacion() {
		return view('observadores.asignacion_observadores',["estado"=>0, "municipio"=>0, "parroquia"=>0, "centro"=>0, "id_asignacion"=>0,"id_observador"=>0,"id_operador"=>0,"mensaje"=>"","id_eleccion"=>1,"id_centro"=>0,"cedula_operador"=>0,"cedula_observador"=>0]);
	}

	public function asignacion_observadores(Request $request) {
		if ($request->nro_mesa>0)

		$mensaje="";
		if ($request->id_asignacion==0) {
			$id_asignacion = FuncionesControllers::ultimo_id("asignacion");
			$id_asignacion_operador = FuncionesControllers::ultimo_id("asignacion_operador");

			$id_operador=FuncionesControllers::buscar_id_operador($request->cedula_operador);
			$id_observador=FuncionesControllers::buscar_id_operador($request->cedula_observador);

			$sql = "insert into asignacion values($id_asignacion, 1, $id_observador, $request->centro, $request->nro_mesa)";
			DB::insert($sql);
			//$sql = "insert into asignacion_operador values($id_asignacion_operador, 1, $id_observador, $id_operador, $request->centro)";
			//DB::insert($sql);
			$mensaje = "Asignacion ingresada satisfactoriamente !!!";
		} else {
			$sql = "update asignacion set id_eleccion=1, id_observador=$request->id_observador, ";
			$sql .= "id_centro=$request->centro, nro_mesa=$request->nro_mesa where id_asignacion=$request->id_asignacion";
			//echo $sql;
			DB::update($sql);
			$mensaje = "Asignacion actualizada satisfactoriamente !!!";
			$id_asignacion=$request->id_asignacion;
			$id_operador=$request->id_operador;
			$id_observador=$request->id_observador;
		}
		return view('observadores.asignacion_observadores',["estado"=>$request->estado, "municipio"=>$request->municipio, "parroquia"=>$request->parroquia, "centro"=>$request->centro, "id_asignacion"=>$id_asignacion,"id_observador"=>$id_observador,"id_operador"=>$id_operador,"mensaje"=>$mensaje,"id_eleccion"=>1,"cedula_operador"=>$request->cedula_operador,"cedula_observador"=>$request->cedula_observador]);
	}

	public function eliminar_asignacion(Request $request) {
		$id_asignacion=$request->id_asignacion;
		$sql = "select * from asignacion where id_asignacion=".$request->id_asignacion;
		//echo "...".$sql;
		$data=DB::select($sql);
		foreach ($data as $data) {
			$id_centro=$data->id_centro;
			$id_observador=$data->id_observador;
			$id_eleccion=$data->id_eleccion;
		}
		$sql = "delete from asignacion_operador where id_centro=".$id_centro." and id_observador=".$id_observador." and id_eleccion=".$id_eleccion;
		DB::delete($sql);
		//$sql = "delete from asignacion where id_asignacion=".$request->id_asignacion;
		//DB::delete($sql);
		$mensaje = "Asignacion borrada satisfactoriamente !!!";
		return view('observadores.observador_operador',["mensaje"=>'',"estado"=>$request->estado,"municipio"=>$request->municipio,"parroquia"=>$request->parroquia,"id_observador"=>$request->id_observador,"cod_operador"=>$request->cod_operador,"cedula"=>$request->cedula,"nombres"=>$request->nombres,"apellidos"=>$request->apellidos,"id_asignacion"=>$id_asignacion]);
	}

}