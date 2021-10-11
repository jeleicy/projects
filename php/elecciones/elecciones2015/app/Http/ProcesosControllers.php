<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;

class ProcesosControllers extends Controller {

	public static $clase = array ('fa fa-bullseye','fa fa-tasks','fa fa-globe','fa fa-list-ol','fa fa-font','fa fa-font','fa fa-list-ol','fa fa-font','fa fa-list-ul','fa fa-table');

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

	public function proceso_municipio (Request $request) {
		if(Request::ajax()) {
			//$sql = "select * from municipio where id_estado=$request->estado order by nombre";
			//$data=DB::select($sql);

			$resultado = '<select name="municipio" id="municipio" onchange="nuevaParroquia()">';
			$resultado .= "<option value=0>Seleccione Municipio...</option>";
			/*foreach ($data as $data) {
				if ((isset($request->municipio)) && $request->municipio==$data->id_municipio)
					$resultado .= "<option value='".$data->id_municipio."' selected>".$data->nombre."</option>";
				else
					$resultado .= "<option value='".$data->id_municipio."'>".$data->nombre."</option>";
			}*/
			$resultado .= "</select>";
			echo $resultado;

			/*return Response::json( array(
				'resultado' => $resultado,
			));*/
			die;
		}
	}

}