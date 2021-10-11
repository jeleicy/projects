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

class ReportesControllers extends Controller {

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

	public function reporte_planilla_recuperacion (Request $request) {
		//echo "numero=".$request->numero."...id_observador=".$request->id_observador."...cedula=".$request->cedula;
		return view('reportes.reportes_planillas',["numero"=>$request->numero,"id_observador"=>$request->id_observador,"guardar_forma"=>0,"cedula"=>$request->cedula,"buscar_observ"=>1,"eliminar"=>0,"buscar_observ"=>0,"recuperacion"=>0]);
	}
	
	public function reportes_planillas($id, Request $request) {

		$numero = substr($id, 0, strpos($id, ","));
		$id = substr($id, strpos($id, ",") + 1);
		$id_observador = substr($id, 0, strpos($id, ","));
		$id = substr($id, strpos($id, ",") + 1);
		$guardar_forma = substr($id, 0, strpos($id, ","));
		$id = substr($id, strpos($id, ",") + 1);
		$cedula = $id;
		$guardar_forma = 0;
		if ($request->input('guardar_forma'))
			$guardar_forma = $request->input('guardar_forma');

		if ($cedula==0 && $id_observador==0) {
			$sql = "select a.id_asignacion, o.cedula from observador o, asignacion a where o.cedula='".$request->cedula."' and o.id_observador=a.id_observador";
			$data = DB::select($sql);
			foreach ($data as $data) {
				$id_asignacion = $data->id_asignacion;
				$cedula = $data->cedula;
			}
		}

		$id_observador_operador = FuncionesControllers::buscar_id_operador($cedula);
		$id_asignacion = FuncionesControllers::buscar_id_asignacion($cedula);

		//echo "..observador=$id_observador...";
		//echo "..asignacion=$id_asignacion...";

		//print_r ($request->input());
		/*GUARDANDO PLANILLA*/
		$observaciones=$request->input('observaciones');
		if ($guardar_forma==1) {
			$preguntas = "";
			foreach ($request->input() as $key => $value) {
				//echo "<br />preg=".$key;

				$sql = "select a.id_centro, a.nro_mesa, c.estado, ";
				$sql .= "c.municipio, c.parroquia, c.electores ";
				$sql .= "from asignacion a, centro c ";
				$sql .= "where a.id_asignacion=$id_asignacion and ";
				$sql .= "c.id_centro=a.id_centro";
				$data = DB::select($sql);
				foreach ($data as $data) {
					$centro = $data->id_centro;
					$mesa = $data->nro_mesa;
					$estado = $data->estado;
					$municipio = $data->municipio;
					$parroquia = $data->parroquia;
					$nro_votantes=$data->electores;
				}

				/********************************* RESPUESTAS AFIRMATIVAS ********************************/
				//echo $key."=".$value."<br>";
				if (strpos($key, "preg_") !== false) {
					$id_pregunta = substr($key, 5);
					$preguntas .= $id_pregunta . ",";

					if ($value == "on")
						$value = 1;

					/*$sql = "select eo.id_pregunta, eo.respuesta, o.id_observador ";
					$sql .= "from encuesta_observador eo, observador o ";
					$sql .= "where o.id_observador=eo.id_observador";
					$sql .= " and o.cedula='$cedula'";
					//$sql .= " and o.nac='$nac'";
					$sql .= " and eo.id_pregunta=$id_pregunta";
					$sql .= " and eo.id_eleccion=1";
					//$sql .= " and eo.id_estado=$estado and eo.id_municipio=$municipio";
					//$sql .= " and eo.id_parroquia=$parroquia";
					//$sql .= " and eo.id_centro=$centro and eo.mesa=$mesa";
					$sql .= " and eo.id_asignacion=$id_asignacion";
					$data = DB::select($sql);
echo "<br>sql=$sql";
					foreach ($data as $data) {
						$id_pregunta = $data->id_pregunta;
						$id_observador = $data->id_observador;
					}

					if ($id_pregunta) {
						//$id_observador=$data->id_observador;

						$sql = "update encuesta_observador set ";
						$sql .= "respuesta=$value, hora=now(), ";
						$sql .= "observacion='$observaciones' ";
						$sql .= "where id_pregunta=$id_pregunta and ";
						$sql .= "id_observador=$id_observador and ";
						$sql .= "id_eleccion=1";
					} else {*/
						$sql = "select id_observador ";
						$sql .= "from observador ";
						$sql .= "where cedula='$cedula'";
						//$sql .= " and nac='$nac'";
						$data = DB::select($sql);

						foreach ($data as $data)
							$id_observador = $data->id_observador;

/*******/
						if ($value=="") $value=0;
						if (FuncionesControllers::encuesta_duplicada($id_pregunta,$id_observador,$mesa)==false) {
							$sql = "insert into encuesta_observador values($id_pregunta, ";
							$sql .= "$id_observador, ";
							$sql .= "1, ".$value.", ";
							$sql .= "$mesa, $centro, $mesa, $nro_votantes, ";
							$sql .= "current_date, now(), '$observaciones', $id_asignacion)";
							DB::insert($sql);
						} else {
							$sql = "update encuesta_observador set ";
							$sql .= "respuesta=".$value.", hora=now(), ";
							$sql .= "observacion='$observaciones' ";
							$sql .= "where id_pregunta=$id_pregunta and ";
							$sql .= "id_observador=$id_observador and ";
							$sql .= "id_eleccion=1";
							DB::update($sql);
						}
					//}
				}
			}

			if (FuncionesControllers::buscar_asignacion_estatus($id_asignacion)==true) {
				$sql = "update estatus set ";
				if ($numero==1) $sql .= "r1_estatus='P' ";
				if ($numero==2) $sql .= "r2_estatus='P' ";
				if ($numero==3) $sql .= "r3_estatus='P' ";
				if ($numero==4) $sql .= "r4_estatus='P' ";
				if ($numero==5) $sql .= "r5_estatus='P' ";
				$sql .= "where id_asignacion=$id_asignacion";
			} else {
				$id_estatus = FuncionesControllers::ultimo_id("estatus");
				$sql = "insert into estatus values($id_estatus, $id_asignacion, ";
				$sql .= "1, ".SessionusuarioControllers::show("id_observador");
				$sql .= ", now(), ";
				if ($numero==1) $sql .= "'P', '', '', '', '')";
				if ($numero==2) $sql .= "'', 'P', '', '', '')";
				if ($numero==3) $sql .= "'', '', 'P', '', '')";
				if ($numero==4) $sql .= "'', '', '', 'P', '')";
				if ($numero==5) $sql .= "'', '', '', '', 'P')";
			}
			//echo "1)estatus=$sql";
			DB::insert($sql);

			/************************ RESPUESTAS NEGATIVAS ***************************/

			if ($preguntas!="") {
				$preguntas=substr($preguntas,0,strlen($preguntas)-1);
				$sql = "select id_pregunta from pregunta where id_pregunta not in ($preguntas) and id_encuesta=$numero";
				$data = DB::select($sql);
			} else {
				$sql = "select id_pregunta from pregunta where id_encuesta=$numero";
				$data = DB::select($sql);
			}
//echo "1)estatus=$sql";
			foreach ($data as $data) {
				/*$sql = "select a.id_centro, a.nro_mesa, c.estado, ";
				$sql .= "c.municipio, c.parroquia ";
				$sql .= "from asignacion a, centro c ";
				$sql .= "where a.id_asignacion=$id_asignacion and ";
				$sql .= "c.id_centro=a.id_centro";
				//echo "<br>2)$sql";
				$data2 = DB::select($sql);

				foreach ($data2 as $data2) {
					$id_pregunta = $data->id_pregunta;
					$centro = $data2->id_centro;
					$mesa = $data2->nro_mesa;
					$estado = $data2->estado;
					$municipio = $data2->municipio;
					$parroquia = $data2->parroquia;
				}*/
				//echo "<br>1)pregunta=$id_pregunta,observador=$id_observador,mesa=$mesa<br>";
				$id_pregunta=$data->id_pregunta;
				if (FuncionesControllers::encuesta_duplicada($id_pregunta,$id_observador,$mesa)==false) {
					//echo "<br>2)pregunta=$id_pregunta,observador=$id_observador,mesa=$mesa<br>";
					$sql = "insert into encuesta_observador values($id_pregunta, ";
					$sql .= "$id_observador, ";
					$sql .= "1, 1, ";
					$sql .= "$mesa, $centro, $mesa, 0, ";
					$sql .= "current_date, now(), '$observaciones', $id_asignacion)";
					//echo "<br>...reportes=$sql";
					DB::insert($sql);
				}
			}

			$id_eleccion=SessionusuarioControllers::show('id_eleccion');
			$id_observador=SessionusuarioControllers::show('id_observador');

			$sql = "select * from estatus where id_asignacion=$id_asignacion";
			$data = DB::select($sql);
			foreach ($data as $data) {
				if ($data->id_asignacion) {
					$sql = "update estatus set ";
					if ($numero == 1) $sql .= "r1_estatus='P' ";
					if ($numero == 2) $sql .= "r2_estatus='P' ";
					if ($numero == 3) $sql .= "r3_estatus='P' ";
					if ($numero == 4) $sql .= "r4_estatus='P' ";
					if ($numero == 5) $sql .= "r5_estatus='P' ";
					$sql .= "where id_asignacion=$id_asignacion";
				} else {
					$id_estatus = FuncionesControllers::ultimo_id("estatus");
					$sql = "insert into estatus values($id_estatus, $id_asignacion, ";
					$sql .= $id_eleccion . ", " . $id_observador;
					$sql .= ", now(), ";
					if ($numero == 1) $sql .= "'P', '', '', '', '')";
					if ($numero == 2) $sql .= "'', 'P', '', '', '')";
					if ($numero == 3) $sql .= "'', '', 'P', '', '')";
					if ($numero == 4) $sql .= "'', '', '', 'P', '')";
					if ($numero == 5) $sql .= "'', '', '', '', 'P')";
				}
				//echo "2)estatus=$sql";
				DB::insert($sql);
			}

			foreach ($request->input() as $key => $value) {
				if (strpos($key,"votos_") !== false) {
					$id_candidato=substr($key,6);
					$votos = $value;

					$sql = "select * from votos where id_candidato=$id_candidato ";
					$sql .= "and id_encuesta=$numero and id_observador=$id_observador ";
					$sql .= "and id_eleccion=".$id_eleccion." ";
					$sql .= "and id_asignacion=$id_asignacion ";
					$data = DB::select($sql);
					$id_votos=0;
					foreach ($data as $data)
						$id_votos=$data->id_votos;

					if ($id_votos>0) {
						$sql = "update votos set id_candidato=$id_candidato, ";
						$sql .= "id_encuesta=$numero, id_observador=$id_observador, ";
						$sql .= "id_eleccion=".$id_eleccion.", ";
						$sql .= "id_asignacion=$id_asignacion, cantidad=$votos ";
						$sql .= "where id_votos=".$id_votos;
						DB::update($sql);
					} else {
						if ($votos=="") $votos=0;
						$id_votos = FuncionesControllers::ultimo_id("votos");
						$sql = "insert into votos values($id_votos, $id_candidato, ";
						$sql .= "now(), $numero, $id_observador, ";
						$sql .= $id_eleccion.", $id_asignacion, $votos)";
						DB::insert($sql);
					}
					//echo "<br>".$sql;
				}
			}
			//if ($recuperacion==1) {
			$sql = "update recuperacion set recuperado=1, bloqueo=1 ";
			$sql .= "where id_asignacion=$id_asignacion and id_eleccion=1";
			//echo "<br>$sql";
			$result = DB::insert($sql);
			if ($result)
				$recuperacion=0;
			//}
		}
		/*PLANILLA GUARDADA*/
		return view('reportes.reportes_planillas', ["numero"=>$numero,"id_observador"=>$id_observador,"guardar_forma"=>$guardar_forma,"cedula"=>$cedula,"buscar_observ"=>1,"eliminar"=>0,"buscar_observ"=>0,"recuperacion"=>0]);
	}

	public function recuperacion($id, Request $request) {
		//echo "1111111111111111111";
		//$observ_rec1 = isset($request->observ_rec1) ? $request->observ_rec1 : "";
		//$observ_rec2 = isset($request->observ_rec2) ? $request->observ_rec2 : "";
		//$observ_rec3 = isset($request->observ_rec3) ? $request->observ_rec3 : "";
		$numero = $request->numero;
		$nro_recuperacion = $request->nro_recuperacion;
		$falla = $request->falla;
		$id_asignacion = FuncionesControllers::buscar_id_asignacion($request->cedula);

		$i=0;
		$sql = "select id_observador ";
		$sql .= "from observador ";
		$sql .= "where cedula='$request->cedula'";
		//$sql .= " and nac='$nac'";
		//echo "<br>$sql";
		$data=DB::select($sql);
		foreach ($data as $data)
			$id_observador=$data->id_observador;

		$sql = "select id_recuperacion from recuperacion ";
		$sql .= "where id_observador=$id_observador and ";
		$sql .= "id_eleccion=".SessionusuarioControllers::show('id_eleccion');
		//echo "<br>$sql";
		$data=DB::select($sql);
		$id_recuperacion="";
		foreach ($data as $data)
			$id_recuperacion=$data->id_recuperacion;

		if ($id_recuperacion!="") {
			$sql = "update recuperacion set bloqueo=1 ";
			$sql .= "where id_asignacion=$id_asignacion and ";
			$sql .= "id_eleccion=".SessionusuarioControllers::show('id_eleccion');
			DB::update($sql);
			//echo "<br>$sql";
		}

		if ($id_recuperacion!="")
			$num_recup_ant=$nro_recuperacion-1;
		else
			$num_recup_ant=0;
		$otra_falla_texto=$_REQUEST["otra_falla_texto"];
		//echo "falla=".$otra_falla_texto;
		if ($otra_falla_texto!="") {
			$id_fallas = FuncionesControllers::ultimo_id("fallas");
			$falla=$id_fallas;
			$sql = "insert into fallas values($id_fallas, '".$otra_falla_texto."', current_date)";
			DB::insert($sql);
		}
		$preguntas="";
		foreach ($_REQUEST as $key => $value) {
			if (strpos($key,"preg_") !== false) {
				$i=1;
				$id_pregunta=substr($key,5);
				$preguntas.= $id_pregunta.",";

				$id_recuperacion = FuncionesControllers::ultimo_id("recuperacion");
				if (FuncionesControllers::no_existe_recup($nro_recuperacion, $id_asignacion,$id_pregunta)==true) {
					if ($value=="") $value=0;
					$sql = "insert into recuperacion (";
					$sql .= "id_recuperacion,id_eleccion,id_observador,";
					if ($nro_recuperacion == 1) $sql .= "observ_rec1,";
					if ($nro_recuperacion == 2) $sql .= "observ_rec2,";
					if ($nro_recuperacion == 3) $sql .= "observ_rec3,";
					$sql .= "id_encuesta,";
					$sql .= "bloqueo,recuperado,id_recuperador,";
					$sql .= "nro_recuperacion,nro_llamada,fecha_ingreso,fecha_actualizacion, ";
					$sql .= "id_pregunta, respuesta, hora_ingreso, id_asignacion, ";
					$sql .= "falla) values (";
					$sql .= "$id_recuperacion," . SessionusuarioControllers::show('id_eleccion') . ",$id_observador,";
					if ($nro_recuperacion == 1) $sql .= "'$request->observ_rec1',";
					if ($nro_recuperacion == 2) $sql .= "'$request->observ_rec2',";
					if ($nro_recuperacion == 3) $sql .= "'$request->observ_rec3',";
					$sql .= "$numero,";
					$sql .= "0,0," . SessionusuarioControllers::show('id_observador') . ",";
					$sql .= "$nro_recuperacion,1,current_date,current_date, ";
					$sql .= "$id_pregunta, $value, now(), $id_asignacion, ";
					$sql .= "$falla)";
					//echo "<br><br>1)falla=$falla....$sql";
					DB::insert($sql);
				}
			}
		}

		$sql = "select * from estatus where id_asignacion=$id_asignacion";
		$data = DB::select($sql);
		$id_estatus=0;
		foreach ($data as $data)
			$id_estatus=$data->id_estatus;

		if ($id_estatus>0) {
			$sql = "update estatus set ";
			if ($nro_recuperacion==1) $sql .= "r$numero"."_estatus='RC1' ";
			if ($nro_recuperacion==2) $sql .= "r$numero"."_estatus='RC2' ";
			$sql .= "where id_estatus=$id_estatus";
			DB::update($sql);
		} else {
			$id_estatus = FuncionesControllers::ultimo_id("estatus");
			$sql = "insert into estatus values($id_estatus, $id_asignacion, ";
			$sql .= SessionusuarioControllers::show('id_eleccion').", ".SessionusuarioControllers::show('id_observador');
			$sql .= ", now(), ";
			if ($numero==1) $sql .= "'RC$nro_recuperacion', '', '', '', '')";
			if ($numero==2) $sql .= "'', 'RC$nro_recuperacion', '', '', '')";
			if ($numero==3) $sql .= "'', '', 'RC$nro_recuperacion', '', '')";
			if ($numero==4) $sql .= "'', '', '', 'RC$nro_recuperacion', '')";
			if ($numero==5) $sql .= "'', '', '', '', 'RC$nro_recuperacion')";
			DB::insert($sql);
		}
		//echo "<br><br>1)$sql";

		$sigue=0;
		if ($preguntas!="") {
			$preguntas=substr($preguntas,0,strlen($preguntas)-1);
			$sql = "select id_pregunta from pregunta where id_pregunta not in ($preguntas) ";
			$sql .= "and id_encuesta=$numero";
			$data = DB::select($sql);
			foreach ($data as $data)
				if ($data->id_pregunta)
					$sigue=1;

			$sql = "select id_pregunta from pregunta where id_pregunta not in ($preguntas) ";
			$sql .= "and id_encuesta=$numero";
		} else {
			$sql = "select id_pregunta from pregunta where id_encuesta=$numero";
			$sigue=1;
		}

		if ($sigue==1) {
			$data = DB::select($sql);
			foreach ($data as $data) {
				if (FuncionesControllers::no_existe_recup($nro_recuperacion, $id_asignacion,$data->id_pregunta)==true) {
					$id_recuperacion = FuncionesControllers::ultimo_id("recuperacion");

					$sql = "insert into recuperacion (";
					$sql .= "id_recuperacion,id_eleccion,id_observador,";
					if ($nro_recuperacion == 1) $sql .= "observ_rec1,";
					if ($nro_recuperacion == 2) $sql .= "observ_rec2,";
					if ($nro_recuperacion == 3) $sql .= "observ_rec3,";
					$sql .= "id_encuesta,";
					$sql .= "bloqueo,recuperado,id_recuperador,";
					$sql .= "nro_recuperacion,nro_llamada,fecha_ingreso,fecha_actualizacion, ";
					$sql .= "id_pregunta, respuesta, hora_ingreso, id_asignacion, ";
					$sql .= "falla) values (";
					$sql .= "$id_recuperacion," . SessionusuarioControllers::show('id_eleccion') . ",$id_observador,";
					if ($nro_recuperacion == 1) $sql .= "'$request->observ_rec1',";
					if ($nro_recuperacion == 2) $sql .= "'$request->observ_rec2',";
					if ($nro_recuperacion == 3) $sql .= "'$request->observ_rec3',";
					$sql .= "$numero,";
					$sql .= "0,0," . SessionusuarioControllers::show('id_observador') . ",";
					$sql .= "$nro_recuperacion,1,current_date,current_date, ";
					$sql .= $data->id_pregunta . ", 1, now(), $id_asignacion, ";
					$sql .= "$falla)";
					//echo "<br><br>2)$sql";
					DB::insert($sql);
				}
			}
		}

		$sql = "select * from estatus where id_asignacion=$id_asignacion";
		$data = DB::select($sql);
		$id_estatus=0;
		foreach ($data as $data)
			$id_estatus=$data->id_estatus;

		if ($id_estatus>0) {
			$sql = "update estatus set ";
			if ($nro_recuperacion==1) $sql .= "r$numero"."_estatus='RC1' ";
			if ($nro_recuperacion==2) $sql .= "r$numero"."_estatus='RC2' ";
			$sql .= "where id_asignacion=$id_asignacion";
			DB::update($sql);
		} else {
			$id_estatus = FuncionesControllers::ultimo_id("estatus");
			$sql = "insert into estatus values($id_estatus, $id_asignacion, ";
			$sql .= SessionusuarioControllers::show('id_eleccion').", ".SessionusuarioControllers::show('id_observador');
			$sql .= ", now(), ";
			if ($numero==1) $sql .= "'RC$nro_recuperacion', '', '', '', '')";
			if ($numero==2) $sql .= "'', 'RC$nro_recuperacion', '', '', '')";
			if ($numero==3) $sql .= "'', '', 'RC$nro_recuperacion', '', '')";
			if ($numero==4) $sql .= "'', '', '', 'RC$nro_recuperacion' '',)";
			if ($numero==5) $sql .= "'', '', '', '', 'RC$nro_recuperacion')";
			DB::insert($sql);
		}
		//echo "<br><br>2)$sql";

		$sql = "update recuperacion set bloqueo=0 ";
		$sql .= "where id_asignacion=$id_asignacion ";
		$sql .= "and id_eleccion=".SessionusuarioControllers::show('id_eleccion');
		//echo "<br>$sql";
		DB::update($sql);

		if (strpos($num_recup_ant, "0") === false) {
			for ($i=1; $i<($num_recup_ant+1); $i++) {
				$sql = "update recuperacion set bloqueo=1 ";
				$sql .= "where id_asignacion=$id_asignacion and ";
				$sql .= "nro_recuperacion=$i";
				DB::update($sql);
			}
			//echo $sql."<br>";
		}
		Session::put("mensaje","Información Incompleta almacenada satisfactoriamente");

		return view('reportes.reportes_planillas', ["numero"=>$numero,"id_observador"=>$id_observador,"guardar_forma"=>0,"cedula"=>$request->cedula,"buscar_observ"=>1,"eliminar"=>0,"buscar_observ"=>0,"recuperacion"=>0]);
		//$mod="reportes_recuperacion";
	}
	
	public function buscar_listado_observadores(Request $request) {
		$cedula=0;
		$estatus_busqueda=0;
		$estado=0;
		$municipio=0;
		$parroquia=0;
		$centro=0;
		$reporte=0;
		if ($request->input('cedula')) $cedula=$request->input('cedula');
		if ($request->input('estatus_busqueda')) $estatus_busqueda=$request->input('estatus_busqueda');

		if ($request->input('estado')) $estado=$request->input('estado');
		if ($request->input('municpio')) $municipio=$request->input('municpio');
		if ($request->input('parroquia')) $parroquia=$request->input('parroquia');
		if ($request->input('centro')) $centro=$request->input('centro');

		if ($request->input('reporte')) $reporte=$request->input('reporte');

		return view('observadores.listado_observadores', ["cedula"=>$cedula, "estatus_busqueda"=>$estatus_busqueda, "estado"=>$estado, "municipio"=>$municipio, "parroquia"=>$parroquia,"centro"=>$centro, "reporte"=>$reporte]);
	}
	
	public function imprimir_listado_asignacion($datos) {
		$cedula=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$estatus_busqueda=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$estado=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$municipio=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$parroquia=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$centro=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$reporte=$datos;
		//echo $estado."..".$municipio."...".$parroquia."...".$centro;

		return view('reportes.imprimir_listado_observadores', ["cedula"=>$cedula, "estatus_busqueda"=>$estatus_busqueda,"estado"=>$estado,"municipio"=>$municipio,"parroquia"=>$parroquia,"centro"=>$centro,"reporte"=>$reporte]);
	}

	public function imprimir_planilla_llena($datos) {
		/*$cedula=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$asignacion=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$reporte=$datos;*/
//echo "cedula=".$cedula;
		return view('reportes.imprimir_planilla_llena', ["datos"=>$datos]);
	}

	public function estadisticas(Request $request) {
		$estado=0;
		$municipio=0;
		$parroquia=0;
		$reporte="";
		$circuito=0;

		if ($request->estado) $estado=$request->estado;
		if ($request->municipio) $municipio=$request->municipio;
		if ($request->parroquia) $parroquia=$request->parroquia;
		if ($request->circuito) $circuito=$request->circuito;

		if ($request->reporte1) $reporte.="1,";
		if ($request->reporte2) $reporte.="2,";
		if ($request->reporte3) $reporte.="3,";
		if ($request->reporte4) $reporte.="4,";
		if ($request->reporte5) $reporte.="5,";

		if ($reporte=="")
			$reporte=0;
		else
			$reporte=substr($reporte,0,strlen($reporte)-1);

		return view('reportes.estadisticas', ["estado"=>$estado, "municipio"=>$municipio, "parroquia"=>$parroquia, "reporte"=>$reporte,"circuito"=>$circuito]);
	}

	public function exportar_estadisticas_excel($datos) {
		$eleccion=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$estado=substr($datos,strpos($datos,"estado=")+7);
		$estado=substr($estado,0,strpos($estado,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$municipio=substr($datos,strpos($datos,"municipio=")+10);
		$municipio=substr($municipio,0,strpos($municipio,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$parroquia=substr($datos,strpos($datos,"parroquia=")+10);
		$parroquia=substr($parroquia,0,strpos($parroquia,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$reporte=substr($datos,strpos($datos,"reporte=")+8);

		return view('reportes.exportar_estadisticas_excel', ["id_eleccion"=>$eleccion, "estado"=>$estado, "municipio"=>$municipio, "parroquia"=>$parroquia, "reporte"=>$reporte]);
	}

	public function exportar_estadisticas_centros_procesados($datos) {
		$eleccion=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$estado=substr($datos,strpos($datos,"estado=")+7);
		$estado=substr($estado,0,strpos($estado,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$municipio=substr($datos,strpos($datos,"municipio=")+10);
		$municipio=substr($municipio,0,strpos($municipio,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$parroquia=substr($datos,strpos($datos,"parroquia=")+10);
		$parroquia=substr($parroquia,0,strpos($parroquia,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$reporte=substr($datos,strpos($datos,"reporte=")+8);

		return view('reportes.exportar_estadisticas_centros_procesados', ["id_eleccion"=>$eleccion, "estado"=>$estado, "municipio"=>$municipio, "parroquia"=>$parroquia, "reporte"=>$reporte]);
	}

	public function exportar_excel_recuperacion($datos) {
		$datos=substr($datos,strpos($datos,"=")+1);
		$eleccion=substr($datos,0,strpos($datos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$recuperado=substr($datos,strpos($datos,"=")+1);
		return view('reportes.exportar_excel_recuperacion', ["id_eleccion"=>$eleccion, "recuperado"=>$recuperado]);
	}

	public function listado_recuperacion(Request $request) {
		if ($request->estado) $estado=$request->estado; else $estado=0;
		if ($request->recuperado) $recuperado=$request->recuperado; else $recuperado=0;
		if ($request->id_eleccion) $eleccion=$request->id_eleccion; else $eleccion=0;
		if ($request->cedula) $cedula=$request->cedula; else $cedula=0;

		return view('reportes.listado_recuperacion', ["eleccion"=>$eleccion, "estado"=>$estado, "recuperado"=>$recuperado, "cedula"=>$cedula]);
	}

	public function estadisticas_votos() {
		return view('estadisticas.estadisticas_votos');
	}

	public function estadistica_cobertura(Request $request) {
		$estado=0;
		$recuperado=0;
		$reporte="";
		if ($request->estado) $estado=$request->estado; else $estado=0;
		if ($request->circuito) $circuito=$request->circuito; else $circuito=0;
		if ($request->recuperado) $recuperado=$request->recuperado; else $recuperado=0;

		if ($request->reporte1) $reporte.="1,";
		if ($request->reporte2) $reporte.="2,";
		if ($request->reporte3) $reporte.="3,";
		if ($request->reporte4) $reporte.="4,";
		if ($request->reporte5) $reporte.="5,";

		if ($reporte=="")
			$reporte=0;
		else
			$reporte=substr($reporte,0,strlen($reporte)-1);

		return view('estadisticas.estadisticas_cobertura',["estado"=>$estado, "recuperado"=>$recuperado, "reporte"=>$reporte,"circuito"=>$circuito]);
	}

	public function exportar_excel($eleccion) {
		return view('reportes.exportar_excel', ["eleccion"=>$eleccion]);
	}

	public function reporte_votos($eleccion)
	{
		return view('reportes.reporte_votos', ["eleccion" => $eleccion]);
	}

	public function exportar_excel_cobertura($dato) {
		$eleccion=substr($dato,0,strpos($dato,","));
		$dato=substr($dato,strpos($dato,",")+1);
		$recuperado=substr($dato,0,strpos($dato,","));
		$dato=substr($dato,strpos($dato,",")+1);
		$estado=substr($dato,0,strpos($dato,","));
		$dato=substr($dato,strpos($dato,",")+1);
		$reporte=substr($dato,0,strpos($dato,","));
		$dato=substr($dato,strpos($dato,",")+1);
		$circuito=$dato;

		return view('reportes.exportar_excel_cobertura', ["eleccion" => $eleccion, "recuperado"=>$recuperado, "estado"=>$estado,"reporte"=>$reporte,"circuito"=>$circuito]);
	}

	public function listado_planillas(Request $request) {
		if (($request->estado)) $estado=$request->estado; else $estado=0;
		if (($request->municipio)) $municipio=$request->municipio; else $municipio=0;
		if (($request->parroquia)) $parroquia=$request->parroquia; else $parroquia=0;
		if (($request->reporte)) $reporte=$request->reporte; else $reporte=0;
		if (($request->verificadas)) $verificadas=$request->verificadas; else $verificadas=0;
		if (($request->circuito)) $circuito=$request->circuito; else $circuito=0;

		foreach ($request as $key=>$value) {
			/*echo "<h1>key</h1>";
			print_r ($key);
			echo "<h1>value</h1>";
			print_r ($value);*/
			foreach ($value as $key2=>$value2) {
				if (strpos($key2,"verificada_") !== false) {
					$key2 = substr($key2, 11);
					$id_observador = substr($key2, 0, strpos($key2, "_"));
					$key2 = substr($key2, strpos($key2, "_") + 1);
					$nro_mesa = substr($key2, 0, strpos($key2, "_"));
					$key2 = substr($key2, strpos($key2, "_") + 1);
					$id_centro = substr($key2, 0, strpos($key2, "_"));
					$key2 = substr($key2, strpos($key2, "_") + 1);
					$id_encuesta = $key2;

					$sql = "delete from planillas_verificadas ";
					$sql .= "where id_observador=$id_observador and mesa=$nro_mesa and id_centro=$id_centro";
					//echo "<br>$sql";
					DB::delete($sql);

					$id_planillas_verificadas = FuncionesControllers::ultimo_id("planillas_verificadas");
					$sql = "insert into planillas_verificadas values($id_planillas_verificadas, ";
					$sql .= "$id_observador, $nro_mesa, $id_centro, 1, now(),$id_encuesta)";
					//echo "<br>$sql";
					DB::insert($sql);
				}
			}
		}

		return view('reportes.listado_planillas',['estado'=>$estado,'municipio'=>$municipio,'parroquia'=>$parroquia,'reporte'=>$reporte,'verificadas'=>$verificadas, "circuito"=>$circuito]);
	}

	public function imprimir_listado_planillas ($datos) {
		//estado=9,municipio=10,parroquia=1,reporte=1,verificadas=
		$estado=substr($datos,strpos($datos,"estado=")+7);
		$estado=substr($estado,0,strpos($estado,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$municipio=substr($datos,strpos($datos,"municipio=")+10);
		$municipio=substr($municipio,0,strpos($municipio,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$parroquia=substr($datos,strpos($datos,"parroquia=")+10);
		$parroquia=substr($parroquia,0,strpos($parroquia,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$reporte=substr($datos,strpos($datos,"reporte=")+8);
		$reporte=substr($reporte,0,strpos($reporte,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$verificadas=substr($datos,strpos($datos,"verificadas=")+12);

		//echo $valor;
		return view('reportes.imprimir_listado_planillas',['estado'=>$estado,'municipio'=>$municipio,'parroquia'=>$parroquia,'reporte'=>$reporte,'verificadas'=>$verificadas]);
	}

	public function exportar_estadisticas_observadores_excel($datos) {
		//echo $datos;
		//cedula=0,nombres=,apellidos=,privilegio=0,estado=0,municipio=0,parroquia=
		$cedula=substr($datos,strpos($datos,"cedula=")+7);
		$cedula=substr($cedula,0,strpos($cedula,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$nombres=substr($datos,strpos($datos,"nombres=")+8);
		$nombres=substr($nombres,0,strpos($nombres,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$apellidos=substr($datos,strpos($datos,"apellidos=")+10);
		$apellidos=substr($apellidos,0,strpos($apellidos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$privilegio=substr($datos,strpos($datos,"privilegio=")+11);
		$privilegio=substr($privilegio,0,strpos($privilegio,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$estado=substr($datos,strpos($datos,"estado=")+7);
		$estado=substr($estado,0,strpos($estado,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$municipio=substr($datos,strpos($datos,"municipio=")+10);
		$municipio=substr($municipio,0,strpos($municipio,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$parroquia=substr($datos,strpos($datos,"parroquia=")+10);
		$parroquia=substr($parroquia,0,strpos($parroquia,","));

		//echo "cedula".$cedula."...nombres".$nombres."...apellidos".$apellidos."...privilegio".$privilegio."...estado".$estado."...municipio".$municipio."...parroquia".$parroquia;

		return view('estadisticas.exportar_estadisticas_observadores_excel',["cedula"=>$cedula,"nombres"=>$nombres,"apellidos"=>$apellidos,"privilegio"=>$privilegio,"estado"=>$estado,"municipio"=>$municipio,"parroquia"=>$parroquia]);
	}

	public function imprimir_listado_asignacion_observadores($datos) {
		//cod_operador=0,cedula=0,nombres=,apellidos=,estado=0,municipio=0,parroquia=
		//echo $datos;
		$cod_operador=substr($datos,strpos($datos,"cod_operador=")+13);
		$cod_operador=substr($cod_operador,0,strpos($cod_operador,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$cedula=substr($datos,strpos($datos,"cedula=")+7);
		$cedula=substr($cedula,0,strpos($cedula,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$nombres=substr($datos,strpos($datos,"nombres=")+8);
		$nombres=substr($nombres,0,strpos($nombres,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$apellidos=substr($datos,strpos($datos,"apellidos=")+10);
		$apellidos=substr($nombres,0,strpos($apellidos,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$estado=substr($datos,strpos($datos,"estado=")+7);
		$estado=substr($estado,0,strpos($estado,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$municipio=substr($datos,strpos($datos,"municipio=")+10);
		$municipio=substr($municipio,0,strpos($municipio,","));
		$datos=substr($datos,strpos($datos,",")+1);
		$parroquia=substr($datos,strpos($datos,"parroquia=")+10);
		//$parroquia=substr($parroquia,0,strpos($parroquia,","));
		return view('reportes.imprimir_listado_asignacion',["cod_operador"=>$cod_operador,"cedula"=>$cedula,"nombres"=>$nombres,"apellidos"=>$apellidos,"estado"=>$estado,"municipio"=>$municipio,"parroquia"=>$parroquia]);
	}

	public function consulta_centros() {
		return view('reportes.consulta_centros',["nombre"=>"","estado"=>0,"municipio"=>0,"parroquia"=>0, "mensaje"=>"", "codigo"=>0]);
	}

	public function consulta_centros_asignados() {
		return view('reportes.consulta_centros_asignados',["nombre"=>"","estado"=>0,"municipio"=>0,"parroquia"=>0, "mensaje"=>"", "codigo"=>0]);
	}

	public function consulta_de_centros(Request $request) {
		return view('reportes.consulta_centros',["nombre"=>$request->nombre,"estado"=>$request->estado,"municipio"=>$request->municipio,"parroquia"=>$request->parroquia, "mensaje"=>"", "codigo"=>0]);
	}

	public function imprimir_tablero($datos)
	{
		$nombre = substr($datos, 0, strpos($datos, ","));
		$datos = substr($datos, strpos($datos, ",") + 1);
		$estado = substr($datos, 0, strpos($datos, ","));
		$datos = substr($datos, strpos($datos, ",") + 1);
		$municipio = substr($datos, 0, strpos($datos, ","));
		$datos = substr($datos, strpos($datos, ",") + 1);
		$parroquia = substr($datos, 0, strpos($datos, ","));
		$datos = substr($datos, strpos($datos, ",") + 1);
		$tipo = $datos;

		return view('reportes.imprimir_tablero', ["nombre" => $nombre, "estado" => $estado, "municipio" => $municipio, "parroquia" => $parroquia, "tipo" => $tipo]);
	}

	public function certificar_clave (Request $request) {
		$sql = "select * from clave_admin where clave='".hash('ripemd160',$request->contrasena)."' and activo=1";
		//echo $sql;
		$data = DB::select($sql);

		$id_asignacion=$request->id_asignacion;
		$id_observador=$request->id_observador;
		$reporte=$request->reporte;

		if (empty($data)) {
			echo "<script>alert('La clave introducida es invalida');</script>";
			return view('observadores.certificar_clave',["id_asignacion"=>$id_asignacion, "id_observador"=>$id_observador, "reporte"=>$reporte]);
		} else {
			$sql = "delete from encuesta_observador where id_asignacion=$id_asignacion and id_observador=$id_observador";
			DB::delete($sql);
			$sql = "delete from recuperacion where id_asignacion=$id_asignacion and id_observador=$id_observador";
			DB::delete($sql);
			$sql = "update estatus set r" . $reporte . "_estatus='' where id_asignacion=$id_asignacion and id_eleccion=1";
			DB::update($sql);
			echo "<script>alert('Planilla revertida satisfactoriamente');</script>";
			return view('observadores.listado_observadores', ["cedula"=>'', "estatus_busqueda"=>0, "estado"=>0, "municipio"=>0, "parroquia"=>0,"centro"=>0, "reporte"=>1]);
		}
	}

	public function borrar_planilla(Request $request) {
		$id_asignacion=$request->id_asignacion;
		$id_observador=$request->id_observador;
		$reporte=$request->numero;
		return view('observadores.certificar_clave',["id_asignacion"=>$id_asignacion, "id_observador"=>$id_observador, "reporte"=>$reporte]);	}

}