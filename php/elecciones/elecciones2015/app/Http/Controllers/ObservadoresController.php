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

class ObservadoresController extends Controller {

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
	public function eliminar_observador(Request $request) {
		//
		$sql = "select * from asignacion where id_observador=".$request->id_observador;
		$data=DB::select($sql);
		if (empty($data)) {
			$sql = "delete from observador where id_observador=".$request->id_observador;
			DB::delete($sql);
			return view('observadores.observadores',["id_observador"=>0,"mensaje" => "", "cedula" => $request->cedula, "estado" => $request->estado, "municipio" => $request->municipio, "parroquia" => $request->parroquia, "nombres" => $request->nombres, "apellidos" => $request->apellidos, "privilegio" =>$request->privilegio]);
		} else {
			echo "<script>alert('Este observador no puede ser eliminado !!!');</script>";
			return view('observadores.observadores',["id_observador"=>0,"mensaje" => "", "cedula" => $request->cedula, "estado" => $request->estado, "municipio" => $request->municipio, "parroquia" => $request->parroquia, "nombres" => $request->nombres, "apellidos" => $request->apellidos, "privilegio" =>$request->privilegio, "id_asignacion" =>0]);
		}
	}

	public function consulta() {
		return view('observadores.observadores',["mensaje"=>"", "id_observador"=>0,"cedula"=>0,"estado"=>0,"municipio"=>0,"parroquia"=>0,"nombres"=>"","apellidos"=>"","privilegio"=>0,"id_asignacion"=>0]);
	}

	public function consultar_observadores(Request $request) {
		return view('observadores.observadores', ["id_observador"=>0,"mensaje" => "", "cedula" => $request->cedula, "estado" => $request->estado, "municipio" => $request->municipio, "parroquia" => $request->parroquia, "nombres" => $request->nombres, "apellidos" => $request->apellidos, "privilegio" =>$request->privilegio, "id_asignacion" =>$request->id_asignacion]);
	}

	public function registro() {
		return view('observadores.registro',["id_observador"=>0, "mensaje"=>"", "cedula"=>"","estado"=>0,"municipio"=>0,"parroquia"=>0]);
	}

	public function registro_consulta($id) {
		return view('observadores.registro',["mensaje"=>"", "id_observador"=>$id]);
	}

	public function guardar_registro(Request $request)
	{
		if ($request->id_observador==0) {
			if (FuncionesControllers::verificar_usuario($request->email, $request->cedula, 0, $request->id_observador) == false) {

				$request->id_observador = FuncionesControllers::ultimo_id("observador");

				if (trim($request->tlfcel) == "")
					$tlfcel = "";
				else
					$tlfcel = $request->cod_cel . "-" . $request->tlfcel;

				if (trim($request->tlfhab) == "")
					$tlfhab = "";
				else
					$tlfhab = $request->cod_hab . "-" . $request->tlfhab;

				$fechanac=$request->ano_nac."-".$request->mes_nac."-".$request->dia_nac;

				$sql = "insert into observador (id_observador, cedula, nombres,";
				$sql .= "apellidos,sexo,fechanac,";
				$sql .= "edocivil, profesion, ";
				$sql .= "tlfcel,tlfhab,tlfotro, ";
				$sql .= "email, email2, ";
				$sql .= "contrasena, ";
				$sql .= "pregsec, respsec, ";
				$sql .= "privilegio, autorizado,";
				$sql .= "ctabancaria, banco, tipocta, dirmrw, ";
				$sql .= "id_estado, id_municipio, id_parroquia, ";
				$sql .= "con_regional, codigo, observaciones, ";
				$sql .= "fecha_ing, fecha_act, acreditadocne, activo, capacitado) values(";

				$sql .= $request->id_observador.", '".$request->cedula."', '" . strtoupper($request->nombres) . "', ";
				$sql .= "'" . strtoupper($request->apellidos) . "', ";
				$sql .= "'".$request->sexo."', '" . $fechanac . "', ";
				$sql .= "'".$request->edocivil."', '" . strtoupper($request->profesion) . "', ";
				$sql .= "'" . $tlfcel . "', '" . $tlfhab . "', '".$request->tlfotro."', ";
				$sql .= "'" . strtolower($request->email) . "', '" . strtolower($request->email2) . "', ";
				$sql .= "'" . md5($request->contrasena) . "', ";
				$sql .= "'".$request->pregsec."', '".$request->respsec."', ";
				$sql .= $request->privilegio.", ";
				$sql .= "0, ";
				$sql .= "'".$request->ctabancaria."', '".$request->banco."', '".$request->tipocta."', '".$request->dirmrw."', ";
				if (SessionusuarioControllers::show("privilegio") == 8)
					$estado = SessionusuarioControllers::show("estado");
				$sql .= "$request->estado, $request->municipio, $request->parroquia, ";
				$sql .= "$request->con_regional, $request->cedula, '$request->observaciones', ";
				$sql .= "current_date, current_date, $request->acreditadocne, $request->activo, $request->capacitado)";
				//echo $sql;
				DB::insert($sql);
				$mensaje = "Gracias por suscribirse a nuestro portal, nuestros administradores revisaran su informaci&oacute;n, espere un nuevo email con la autorizaci&oacute;n para ingresar.. !!!";
				//enviar_nuevo_registro($email, $nombres, $apellidos);
			} else {
				$mensaje = "Ya existe un Observador con ese correo &oacute; c&eacute;dula asociado !!!";
			}
		} else {
			//echo "id=".$request->id_observador;
			if (FuncionesControllers::verificar_usuario($request->email, 0, 0, $request->id_observador) == false) {
				$fechanac=$request->ano_nac."-".$request->mes_nac."-".$request->dia_nac;

				if (trim($request->tlfcel) == "")
					$tlfcel = "";
				else
					$tlfcel = $request->cod_cel . "-" . $request->tlfcel;

				if (trim($request->tlfhab) == "")
					$tlfhab = "";
				else
					$tlfhab = $request->cod_hab . "-" . $request->tlfhab;

				$sql = "update observador set ";
				$sql .= "cedula='$request->cedula', ";
				$sql .= "nombres='" . strtoupper($request->nombres) . "', apellidos='" . strtoupper($request->apellidos) . "', ";
				$sql .= "sexo='$request->sexo', fechanac='" . $fechanac . "', ";
				$sql .= "tlfcel='$tlfcel', ";
				$sql .= "tlfhab='$tlfhab', ";
				$sql .= "tlfotro='$request->tlfotro', ";
				//$sql .= "ctabancaria='$request->ctabancaria', banco='$banco', tipocta='$tipocta',
				$sql .= "dirmrw='$request->dirmrw', ";
				$sql .= "edocivil='$request->edocivil', profesion='" . strtoupper($request->profesion) . "', ";
				$sql .= "email='" . strtolower($request->email) . "', email2='" . strtolower($request->email2) . "', ";
			$sql .= "pregsec='$request->pregsec', respsec='$request->respsec', ";
				$sql .= "privilegio='$request->privilegio', ";
				$sql .= "con_regional=$request->con_regional, codigo=$request->cedula, observaciones='$request->observaciones', ";
				if (SessionusuarioControllers::show("privilegio") == 8)
					$estado = SessionusuarioControllers::show("estado");
				$sql .= "id_estado='$request->estado', id_municipio='$request->municipio', id_parroquia='$request->parroquia', ";

				$sql .= "fecha_act=current_date, acreditadocne=$request->acreditadocne, ";
				$sql .= "activo=$request->activo, capacitado=$request->capacitado ";
				$sql .= "where id_observador=$request->id_observador";
				//echo $sql;
				DB::update($sql);
				$mensaje = "Observador actualizado satisfactoriamente !!!";
			} else {
				$mensaje = "Ya existe un Observador con ese correo &oacute; c&eacute;dula asociado !!!";
			}
		}
		//echo "id=".$request->id_observador;
		return view('observadores.registro',["mensaje"=>$mensaje, "dia_nac"=>$request->dia_nac,"mes_nac"=>$request->mes_nac,"ano_nac"=>$request->ano_nac,"id_observador"=>$request->id_observador,"id_observador"=>$request->id_observador,"cedula"=>$request->cedula,"nombres"=>$request->nombres,"apellidos"=>$request->apellidos,"sexo"=>$request->sexo,"dia"=>$request->dia,"mes"=>$request->mes,"ano"=>$request->ano,"edocivil"=>$request->edocivil,"profesion"=>$request->profesion,"estado"=>$request->estado,"municipio"=>$request->municipio,"parroquia"=>$request->parroquia,"cod_cel"=>$request->cod_cel,"tlfcel"=>$request->tlfcel,"cod_hab"=>$request->cod_hab,"tlfhab"=>$request->tlfhab,"tlfotro"=>$request->tlfotro,"email"=>$request->email,"email2"=>$request->email2,"dirmrw"=>$request->dirmrw,"privilegio"=>$request->privilegio,"con_regional"=>$request->con_regional,"con_regional"=>$request->con_regional,"observaciones"=>$request->observaciones,"acreditadocne"=>$request->acreditadocne,"acreditadocne"=>$request->acreditadocne,"activo"=>$request->activo,"activo"=>$request->activo,"capacitado"=>$request->capacitado,"capacitado"=>$request->capacitado,"pregsec"=>$request->pregsec,"respsec"=>$request->respsec]);
	}

	function observador_operador() {
		return view('observadores.observador_operador',["mensaje"=>'',"estado"=>0,"municipio"=>0,"parroquia"=>0,"id_observador"=>0,"cod_operador"=>0,"cedula"=>0,"nombres"=>"","apellidos"=>"","id_asignacion"=>0]);
	}

	function consultar_observadores_operadores(Request $request) {
		//echo "id_asignacion=".$request->id_asignacion;
		return view('observadores.observador_operador',["mensaje"=>'',"estado"=>$request->estado,"municipio"=>$request->municipio,"parroquia"=>$request->parroquia,"id_observador"=>$request->id_observador,"cod_operador"=>$request->cod_operador,"cedula"=>$request->cedula,"nombres"=>$request->nombres,"apellidos"=>$request->apellidos,"id_asignacion"=>$request->id_asignacion]);
	}

	public function asignar_observadores(Request $request) {
		$dato=$request->dato;
		$dato=substr($dato,0,strlen($dato)-1);
		$datos=explode(",",$dato);
		//print_r ($datos);
		$cod_operador=$request->cod_operador;

		foreach ($datos as $key=>$value) {
			$sql = "select * from asignacion_operador where id_observador=$value and id_operador=$cod_operador";
			$data=DB::select($sql);
			if (empty($data)) {
				$id_asignacion_operador = FuncionesControllers::ultimo_id("asignacion_operador");
				//id_asignacion_operador,id_eleccion,id_observador,id_operador,id_centro
				$sql = "select * from asignacion where id_observador=$value";
				$data=DB::select($sql);
				if (empty($data))
					$centro=0;
				else {
					foreach ($data as $data)
						$centro=$data->id_centro;
				}
				$sql = "insert into asignacion_operador values ($id_asignacion_operador,1,$value,$cod_operador,$centro)";
				//echo "<br>".$sql;
				DB::insert($sql);
			}
		}
		return view('observadores.observador_operador',["mensaje"=>'Observador asignado Satisfactoriamente',"estado"=>$request->estado,"municipio"=>$request->municipio,"parroquia"=>$request->parroquia,"id_observador"=>$request->id_observador,"cod_operador"=>$request->cod_operador,"cedula"=>$request->cedula,"nombres"=>$request->nombres,"apellidos"=>$request->apellidos,"id_asignacion"=>$request->id_asignacion]);
	}

}