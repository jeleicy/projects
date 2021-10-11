<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

class CandidatosControllers extends Controller {

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
		return View::make('candidatos.candidatos',["id_candidato"=>0,"mensaje"=>"","nombre"=>"","id_eleccion"=>1,"partido"=>"","estado"=>0,"municipio"=>0,"parroquia"=>0,"codm"=>0,"tendencia"=>0]);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /periodicos
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
		if ($request->id_candidato==0) {
			$id_candidato = FuncionesControllers::ultimo_id("candidato");

			$sql = "insert into candidato values($id_candidato, ";
			$sql .= "'".$request->nombre."', '".$request->partido."', 1, ".$request->estado.", ".$request->municipio.", ".$request->codm.", ".$request->tendencia.")";
			DB::insert($sql);
			$mensaje = "Candidato insertado satisfactoriamente !!!";
		} else {
			$sql = "update candidato set nombre='$request->nombre', ";
			$sql .= "partido='$request->partido', ";
			$sql .= "id_eleccion=1, id_estado=".$request->estado.", id_municipio=".$request->municipio.", codm=".$request->codm." , tendencia=".$request->tendencia." where id_candidato=".$request->id_candidato;
			DB::update($sql);
			$mensaje = "Candidato actualizado satisfactoriamente !!!";
		}
		return View::make('candidatos.candidatos',["id_candidato"=>$request->id_candidato,"mensaje"=>$mensaje,"nombre"=>$request->nombre,"id_eleccion"=>1,"partido"=>$request->partido,"estado"=>$request->estado,"municipio"=>$request->municipio,"parroquia"=>$request->parroquia,"codm"=>$request->codm,"tendencia"=>$request->tendencia]);
	}

	/**
	 * Display the specified resource.
	 * GET /periodicos/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request)
	{
		//
		return View::make('candidatos.candidatos',["id_candidato"=>$request->id_candidato,"mensaje"=>"","nombre"=>$request->nombre,"id_eleccion"=>1,"partido"=>$request->partido,"estado"=>$request->estado,"municipio"=>$request->municipio,"parroquia"=>$request->parroquia,"codm"=>$request->codm,"tendencia"=>$request->tendencia]);
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
	public function eliminar_candidato(Request $request)
	{
		//
		$sql = "select * from votos where id_candidato=".$request->id_candidato;
		//echo $sql;
		$data=DB::select($sql);
		if (empty($data)) {
			$sql = "delete from candidato where id_candidato=" . $request->id_candidato;
			DB::delete($sql);
			$mensaje = "Candidato Eliminado Satisfactoriamente";
		} else {
			$mensaje = "Esta Candidato no puede ser Eliminado";
		}
		return View::make('candidatos.candidatos',["id_candidato"=>$request->id_candidato,"mensaje"=>$mensaje,"nombre"=>$request->nombre,"id_eleccion"=>1,"partido"=>$request->partido,"estado"=>$request->estado,"municipio"=>$request->municipio,"parroquia"=>$request->parroquia,"codm"=>$request->codm,"tendencia"=>$request->tendencia]);
	}
	
}