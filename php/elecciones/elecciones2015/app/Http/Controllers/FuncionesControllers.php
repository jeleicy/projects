<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;

class FuncionesControllers extends Controller {

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
	
	public static function buscar_hijos_menu($id_menu) {
		$sql = "select * from menu where padre=$id_menu";
		$data = DB::select($sql);
		if (empty($data))
			return 0;
		else
			return 1;
	}
	
	public static function crear_menu($privilegio) {
		$sql = "select m.id_menu, m.padre, m.nombre, m.link, m.imagen ";
		$sql .= "from menu m, privilegio_menu pm ";
		$sql .= "where m.padre=0 and m.id_menu=pm.id_menu ";
		$sql .= "and pm.privilegio='$privilegio' and activo=1 ";
		$sql .= "order by m.posicion";
		
		$data = DB::select($sql);
		$j=0;
		
		$url=$_SERVER['REQUEST_URI'];
		$i=1;
		$ruta="";
		while ($i==1) {
			//$url=substr($url,strpos($url,"/")+1);
			if (strpos($url,"public") !== false) {
				$i=1;
				//echo "<br>1)url=$url";
				$url=substr($url,strpos($url,"public/")+7);
				//echo "<br>2)url=$url";
				if (strpos($url,"/") !== false) {
					$url_array = explode("/", $url);
					//echo "<br>3)cant=" . count($url);
					print_r($url);
					if (count($url_array) > 0) {
						$i = 0;
						$ruta = "../";
					}
				} else {
					$i = 0;
					$ruta = "";
				}
			} else
				$i=0;
		}
		
		foreach ($data as $data) {
			if (self::buscar_hijos_menu($data->id_menu) == 1) {
				echo '<li><a href="'.$ruta.$data->link.'"><i class="'.$data->imagen.'"></i> '.$data->nombre.'<span class="fa arrow"></span></a>';
				echo self::buscar_menu($data->id_menu, 0, $privilegio,$ruta);
			}
			$j++;
			echo "</li>";
		}
	}
	
	public static function buscar_menu($padre, $i, $privilegio,$ruta) {
		$sql = "select m.id_menu, m.padre, m.nombre, m.link, m.imagen ";
		$sql .= "from menu m, privilegio_menu pm ";
		$sql .= "where m.padre=$padre and m.id_menu=pm.id_menu ";
		$sql .= "and pm.privilegio=$privilegio and activo=1 ";
		$sql .= "order by m.posicion";
		
		$data = DB::select($sql);
		
		if (!empty($data)) {
				if ($i==0)
					echo '<ul class="nav nav-second-level collapse in">';
				else
					echo '<ul class="nav nav-third-level collapse in">';
			foreach ($data as $data) {
				$i++;
				if ($i==count(self::$clase))
					$i=0;
				echo '<li><a href="'.$ruta.$data->link.'"><i class="'.$data->imagen.'"></i> '.$data->nombre.'<span class="fa arrow"></span></a>';
				echo self::buscar_menu($data->id_menu, $i, $privilegio,$ruta);
				echo "</li>";
			}
			echo "</ul>";
		}			
	}
	
	public static function buscar_privilegio($id) {
		$sql = "select nombre from privilegio where id_privilegio=$id";
		$data = DB::select($sql);
		foreach ($data as $data)
			return $data->nombre;
	}
	
	public static function buscar_estatus($id_asignacion) {
		$sql = "select id_estatus, r1_estatus, r2_estatus, r3_estatus, ";
		$sql .= "r4_estatus, r5_estatus from estatus where id_asignacion=$id_asignacion";
		//echo $sql;
		$data = DB::select($sql);
		$estatus="";
		foreach ($data as $data) {			
			if ($data->id_estatus)
				$estatus=$data->r1_estatus."/".$data->r2_estatus."/".$data->r3_estatus."/".$data->r4_estatus."/".$data->r5_estatus;
		}
		return $estatus;	
	}
	
	public static function buscar_operador($id_observador) {
		$sql = "select o.nombres, o.apellidos from observador o ";
		$sql.= " where o.id_observador=$id_observador";
		//echo $sql;
		$data = DB::select($sql);
		foreach ($data as $data)
			return $data->nombres." ".$data->apellidos;
	}

	public static function buscar_asignacion_observador($id_asignacion, $codigo, $id_observador, $eleccion, $recuperacion)
	{
		$sql = "select distinct(a.id_asignacion), ";
		$sql .= "e.nombre as estado, m.nombre as municipio, p.nombre as parroquia, ";
		$sql .= "a.id_centro, a.nro_mesa, c.nombre as centro, c.codigo, c.id_centro ";
		$sql .= "from asignacion a, centro c, estado e, municipio m, parroquia p ";
		if ($recuperacion == 1)
			$sql .= ", recuperacion r ";
		$sql .= "where c.id_centro=a.id_centro and ";
		$sql .= "a.id_observador=$id_observador and a.id_eleccion=$eleccion and ";
		$sql .= "e.id_estado=c.estado and ";
		$sql .= "m.id_municipio=c.municipio and c.estado =m.id_estado and ";
		$sql .= "p.id_parroquia=c.parroquia and ";
		$sql .= "p.id_municipio=c.municipio and p.id_estado=c.estado and a.id_asignacion=".$id_asignacion;
		if ($recuperacion == 1)
			$sql .= " and r.id_asignacion=a.id_asignacion ";
		//echo "<br>".$sql."<br>";
		$data = DB::select($sql);
		$i = 1;
		foreach ($data as $data) {
			$resultado = "*A$i-*" . $data->id_asignacion . "*" . $data->estado . "*" . $data->municipio . "*" . $data->parroquia . "*" . $data->centro . " (<span class='resaltador'>" . $data->codigo . "</span>)" . "*" . $data->nro_mesa;

			$sql = "select nro_votantes from universo_mesa ";
			$sql .= "where id_eleccion=1 and ";
			$sql .= "codigo_centro='" . $data->id_centro . "' and cod_mesa=" . $data->nro_mesa;
			//$codigo.="****".$sql."*****";
			$data2 = DB::select($sql);
			foreach ($data2 as $data2) {
				if ($data2->nro_votantes)
					$resultado .= "*" . $data2->nro_votantes;
				else
					$resultado .= "*0";
			}

			$sql = "select distinct(nro_recuperacion) as cantidad from recuperacion ";
			$sql .= "where recuperado=0 and ";
			$sql .= "id_eleccion=$eleccion and id_observador=" . $id_observador;
			$data3 = DB::select($sql);
			foreach ($data3 as $data3) {
				if ($data3->cantidad)
					$resultado .= "*" . $data3->cantidad;
				else
					$resultado .= "*0";
			}

			$i++;
		}

		if ($resultado == 0 || $resultado == 1)
			$cantidad_asignaciones = 0;
		else if (strpos($resultado, '*') !== false)
			$cantidad_asignaciones = 0;
		else
			$cantidad_asignaciones = 1;

		if (strpos($resultado, '*') === false)
			$codigo = $resultado;
		else {
			$codigo = substr($resultado, 0, strpos($resultado, '*'));
			$resultado = substr($resultado, strpos($resultado, '*') + 1);
			$tabla = "<table border='0'>";
			$i = 1;
			$j = 1;
			//echo "1)resultado=$resultado...";
			//while ($resultado != '0' && $resultado != '1' && $resultado!='') {
				//echo "$i)resultado=$resultado<br>";
				$resultado = substr($resultado, strpos($resultado, '*') + 1);
				$id_asignacion = substr($resultado, 0, strpos($resultado, '*'));
				$resultado = substr($resultado, strpos($resultado, '*') + 1);
				$estado = substr($resultado, 0, strpos($resultado, '*'));
				$resultado = substr($resultado, strpos($resultado, '*') + 1);
				$municipio = substr($resultado, 0, strpos($resultado, '*'));
				$resultado = substr($resultado, strpos($resultado, '*') + 1);
				$parroquia = substr($resultado, 0, strpos($resultado, '*'));
				$resultado = substr($resultado, strpos($resultado, '*') + 1);
				$centro = substr($resultado, 0, strpos($resultado, '*'));
				$resultado = substr($resultado, strpos($resultado, '*') + 1);
				$mesa = substr($resultado, 0, strpos($resultado, '*'));
				$resultado = substr($resultado, strpos($resultado, '*') + 1);
				$nro_votantes = $resultado;
				/*$resultado = substr($resultado, strpos($resultado, '*') + 1);
				if ($recuperacion == 0)
					if (strpos($resultado, '*') > -1)
						$recuperacion = substr($resultado, 0, strpos($resultado, '*'));
					else
						$recuperacion = $resultado;
				else
					$resultado = substr($resultado, strpos($resultado, '*') + 1);

				$resultado = substr($resultado, strpos($resultado, '*') + 1);
				*/
				$tabla .= "<tr class='fondo" . $j . "'>";
				$tabla .= "<td>";
				//$tabla .= "<label><input class='chk' type='radio' name='id_asignacion' value='" . $id_asignacion . "'";

				/*if (asignacion_actual==id_asignacion && chequeado==0) {
					$tabla .= " checked";
					chequeado=1;
					//alert("2)"+f.id_asignacion.value+"..."+id_asignacion+"..."+chequeado);
				}*/

				//$tabla .= ">";
				$tabla .= "<strong>Asignaci&oacute;n nro. ".$i.":</strong> ";
				$tabla .= "Estado: <span class='error'>" . $estado . "</span>. ";
				$tabla .= "Municipio: <span class='error'>" . $municipio . "</span>. ";
				$tabla .= "Parroquia: <span class='error'>" . $parroquia . "</span>. ";
				$tabla .= "Centro: <span class='error'>" . $centro . "</span>. ";
				$tabla .= "Nro. de Mesa: <span class='error'>" . $mesa . "</span>. ";
				$tabla .= "Nro. de Electores: <span class='error'>" . $nro_votantes . "</span>";
				$tabla .= "</label><td>";
				$tabla .= "</tr>";
				$i++;
				if ($j == 1) $j = 2;
				else $j = 1;
			//}
			$tabla .= "</table>";

			return $tabla;
		}
	}

	public static function ultimo_id($tabla) {
		$sql = "select max(id_".$tabla.") as id from ".$tabla;
		$data=DB::select($sql);
		foreach ($data as $data) {
			if (is_null($data->id))
				return 1;
			else
				return ($data->id + 1);
		}
	}

	public static function buscar_id_operador($cedula)
	{
		$sql = "select id_observador from observador where cedula='$cedula'";
		$data = DB::select($sql);
		foreach ($data as $data)
			return $data->id_observador;
	}

	public static function buscar_id_asignacion($cedula)
	{
		$sql = "select a.id_asignacion from observador o, asignacion a where o.cedula='$cedula' and o.id_observador=a.id_observador";
		$data = DB::select($sql);
		foreach ($data as $data)
			return $data->id_asignacion;
	}

	public static function encuesta_duplicada($id_pregunta,$id_observador,$mesa) {
		//echo "<br>3)pregunta=$id_pregunta,observador=$id_observador,mesa=$mesa<br>";
		$sql = "select * from encuesta_observador where id_pregunta=$id_pregunta and ";
		$sql .= "id_observador=$id_observador and id_eleccion=1 and mesa=$mesa";
		//echo "<br>...funciones=$sql";
		$data = DB::select($sql);
		if (empty($data))
			return false;
		else
			return true;
	}

	public static function buscar_asignacion_estatus($id_asignacion) {
		$sql = "select * from estatus where id_asignacion=$id_asignacion";
		$data = DB::select($sql);
		if (empty($data))
			return false;
		else
			return true;
	}

	public static function buscar_votos($id_candidato, $id_encuesta, $id_observador, $id_eleccion, $id_asignacion) {
		$sql = "select cantidad ";
		$sql .= "from votos ";
		$sql .= "where id_candidato=$id_candidato and ";
		$sql .= "id_encuesta=$id_encuesta and ";
		//$sql .= "id_observador=$id_observador and ";
		$sql .= "id_eleccion=$id_eleccion and ";
		$sql .= "id_asignacion=$id_asignacion";
		//echo $sql;
		$data=DB::select($sql);
		foreach ($data as $data)
			echo $data->cantidad;
	}

	public static function no_existe_recup($nro_recuperacion,$id_asignacion,$id_pregunta) {
		$sql = "select * from recuperacion where nro_recuperacion=$nro_recuperacion and ";
		$sql .= "id_asignacion=$id_asignacion and id_eleccion=1 and id_pregunta=$id_pregunta";
		$data=DB::select($sql);
		$salida=true;
		foreach ($data as $data)
			$salida=false;

		return $salida;
	}

	public static function buscar_recuperacion($id_asignacion,$numero) {
		$sql = "select max(nro_recuperacion) as nro_recuperacion from recuperacion where id_asignacion=$id_asignacion and id_encuesta=$numero";
		$data=DB::select($sql);
		$salida=0;
		foreach ($data as $data)
			$salida=$data->nro_recuperacion;
		return $salida;
	}

	public static function buscar_operador_recup($id_asignacion) {
		$sql = "select o.nombres, o.apellidos ";
		$sql .= "from observador o, asignacion_operador ao ";
		$sql .= "where o.id_observador=ao.id_operador";

		$data=DB::select($sql);
		foreach ($data as $data)
			return $data->nombres." ".$data->apellidos;
	}

	public static function planilla_procesada($id_asignacion,$numero) {
		$sql = "select * from estatus where id_asignacion=$id_asignacion and r".$numero."_estatus='P'";
		//echo $sql;
		$data=DB::select($sql);
		$respuesta=false;
		foreach ($data as $data)
			$respuesta=true;
		return $respuesta;
	}

	public static function buscar_falla($falla) {
		$sql = "select nombre from fallas where id_fallas=$falla";
		$data=DB::select($sql);
		$nombre="";
		foreach ($data as $data)
			$nombre=$data->nombre;
		return $nombre;
	}

	public static function no_recuperado($id_asignacion, $reporte) {
		$sql = "select * from estatus where id_asignacion=$id_asignacion and r".$reporte."_estatus='P'";
		//echo "<br>$sql";
		$data=DB::select($sql);
		if (empty($data))
			return true;
		else
			return false;
	}

	public static function verificada_planilla($id_observador, $nro_mesa, $id_centro, $id_encuesta)
	{
		$sql = "select verificada ";
		$sql .= "from planillas_verificadas ";
		$sql .= "where id_observador=$id_observador and mesa=$nro_mesa and id_centro=$id_centro ";
		$sql .= "and id_encuesta=$id_encuesta";
		$data = DB::select($sql);

		foreach ($data as $data) {
			if ($data->verificada == 1)
				return true;
			else
				return false;
		}
	}

	public static function fecha_normal($fecha) {
		$ano=substr($fecha,0,strpos($fecha,'-'));
		$fecha=substr($fecha,strpos($fecha,'-')+1);
		$mes=substr($fecha,0,strpos($fecha,'-'));
		$fecha=substr($fecha,strpos($fecha,'-')+1);
		$dia=$fecha;
		if ($dia!="")
			$fecha=$dia."/".$mes."/".$ano;
		else
			$fecha="";
		return $fecha;
	}

	public static function fecha_mysql($fecha) {
		$dia=substr($fecha,0,strpos($fecha,'/'));
		$fecha=substr($fecha,strpos($fecha,'/')+1);
		$mes=substr($fecha,0,strpos($fecha,'/'));
		$fecha=substr($fecha,strpos($fecha,'/')+1);
		$ano=$fecha;
		if ($dia!="")
			$fecha=$ano."-".$mes."-".$dia;
		else
			$fecha="";
		return $fecha;
	}

	public static function verificar_usuario($email, $cedula, $nac, $id_observador) {
		if ($id_observador==0)
			$sql = "select * from observador where email='$email' or cedula='$cedula'";
		else
			$sql = "select * from observador where email='$email' and id_observador!=$id_observador";
		//echo $sql;
		$data = DB::select($sql);

		foreach ($data as $data) {
			if ($data->id_observador != "") return true;
			else return false;
		}
	}

	public static function buscar_estado_coordinador($id_observador) {
		$sql = "select e.nombre as estado from observador o, estado e where o.id_observador=$id_observador and e.id_estado=o.id_estado";
		$result = ejecutaQuery($sql);
		$data = DB::select($sql);

		foreach ($data as $data)
			return $data->estado;
	}

	public static function nro_planillas_procesadas () {
		$sql = "select count(distinct(eo.id_asignacion)) as cantidad ";

		$sql .= "from encuesta_observador eo, observador o, asignacion a, centro c, estado edo, ";
		$sql .= "municipio mun, parroquia par, pregunta pre, encuesta enc";

		$sql .= " where eo.id_observador=o.id_observador and a.id_observador=o.id_observador and ";
		$sql .= "a.id_centro=c.id_centro and c.estado=edo.id_estado and c.municipio=mun.id_municipio and ";
		$sql .= "c.estado=mun.id_estado and mun.id_estado and ";
		$sql .= "c.parroquia=par.id_parroquia and par.id_estado=mun.id_estado and ";
		$sql .= "par.id_municipio=c.municipio and ";
		$sql .= "pre.id_pregunta=eo.id_pregunta and pre.id_encuesta=enc.id_encuesta";
//echo $sql;
		$data=DB::select($sql);
		foreach ($data as $data)
			echo $data->cantidad;
	}

	public static function nro_estados_procesadas () {
		$sql = "select count(distinct(edo.id_estado)) as cantidad ";

		$sql .= "from encuesta_observador eo, observador o, asignacion a, centro c, estado edo, pregunta pre, encuesta enc";

		$sql .= " where eo.id_observador=o.id_observador and a.id_observador=o.id_observador and ";
		$sql .= "a.id_centro=c.id_centro and c.estado=edo.id_estado and ";
		$sql .= "pre.id_pregunta=eo.id_pregunta and pre.id_encuesta=enc.id_encuesta";

		$data=DB::select($sql);
		foreach ($data as $data)
			echo $data->cantidad;
	}

	public static function nro_planillas_cobertura () {
		$sql = "select count(distinct(r.id_asignacion)) as cantidad ";
		$sql .= "from observador o, estado e, recuperacion r, asignacion a, centro c ";
		$sql .= "where o.id_observador=r.id_observador and ";
		$sql .= "o.id_observador=a.id_observador and ";
		$sql .= "a.id_eleccion=1 and a.id_centro=c.id_centro and ";
		$sql .= "e.id_estado=c.estado and r.id_eleccion=a.id_eleccion and ";
		$sql .= "r.id_asignacion not in (select id_asignacion from encuesta_observador)";
		$data=DB::select($sql);

		foreach ($data as $data)
			echo $data->cantidad;
	}

	public static function buscar_dato($tabla, $campo, $id) {
		$sql = "select $campo as campo ";
		if ($tabla=="centro")
			$sql .= ", codigo ";
		$sql .= "from $tabla where id_$tabla=$id";
		$data=DB::select($sql);
		$dato="";
		foreach ($data as $data) {
			$dato = "";
			if ($tabla == "observador")
				$dato .= $data->nombres . " " . $data->campo;
			elseif ($tabla == "centro")
				$dato .= $data->campo . " (<strong>" . $data->codigo . "</strong>)";
			else
				$dato .= $data->campo;
		}
		return $dato;
	}

	public static function buscar_asignacion_reporte($id_asignacion) {
		$sql = "select * from encuesta_observador where id_asignacion=".$id_asignacion;
		$data=DB::select($sql);
		if (empty($data)) {
			$sql = "select * from recuperacion where id_asignacion=" . $id_asignacion;
			$data = DB::select($sql);
			if (empty($data))
				return 0;
			else
				return 1;
		} else
			return 1;
	}

	public static function buscar_votos_mesa_total($mesa,$asignacion) {
		$sql = "select sum(v.cantidad) as cant_votos ";
		$sql .= "from votos v, asignacion a ";
		$sql .= "where a.id_eleccion=v.id_eleccion ";
		$sql .= "and a.id_asignacion=v.id_asignacion ";
		$sql .= "and a.nro_mesa=$mesa and a.id_asignacion=$asignacion ";
		$sql .= "group by a.nro_mesa";

		$data=DB::select($sql);
		foreach ($data as $data)
			return $data->cant_votos;
	}

	public static function buscar_entidad($estado, $municipio, $parroquia, $tipo) {
		$sql = "select nombre from $tipo where ";
		if ($tipo=="municipio")
			$sql .= "id_estado=$estado and id_$tipo=$municipio and ";
		elseif ($tipo=="parroquia")
			$sql .= "id_estado=$estado and id_municipio=$municipio and id_$tipo=$parroquia and ";
		else
			$sql .= "id_$tipo=$estado and ";

		$sql = substr($sql,0,strlen($sql)-5);

		$data=DB::select($sql);
		foreach ($data as $data)
			return $data->nombre;
	}

	public static function porcentaje_reporte($reporte) {
		$porcentaje=0;
		$sql = "select count(id_asignacion) as cantidad_mesas from asignacion";
		$data=DB::select($sql);
		$cantidad_mesas=1;
		foreach ($data as $data) {
			if ($data->cantidad_mesas==0)
				$cantidad_mesas = 1;
			else
				$cantidad_mesas = $data->cantidad_mesas;
		}

		$sql = "select count(id_asignacion) as cantidad_planillas from estatus where r".$reporte."_estatus='P'";
		$data=DB::select($sql);
		$cantidad_planillas=0;
		foreach ($data as $data)
			$cantidad_planillas=$data->cantidad_planillas;

		$porcentaje=($cantidad_planillas*100)/$cantidad_mesas;
		return number_format($porcentaje,2,".",",");
	}

	public static function buscar_eleccion($id_eleccion) {
		$sql = "select * from eleccion where id_eleccion=$id_eleccion";
		$data=DB::select($sql);
		foreach ($data as $data)
			echo $data->nombre;
	}

	public function crear_universo_mesa () {
		$sql = "select * from centros_aux";
		$data=DB::select($sql);
		$id_universo_mesa=1;
		foreach ($data as $data) {
			$sql = "insert into universo_mesa values ";
			$electores_total=$data->nro_votantes;
			$electores=($electores_total/$data->cod_mesa);
			for ($i=1; $i<($data->cod_mesa+1); $i++) {
				$electores_mesa=ceil($electores);
				$sql .= "($id_universo_mesa,1,".$data->id_centro.",$i,$electores_mesa),";
				$electores_total=$electores_total-$electores_mesa;
				if ($electores_total<$electores_mesa)
					$electores=$electores_total;
				$id_universo_mesa++;
			}
			$sql = substr($sql,0,strlen($sql)-1);
			$sql .= ";";
			//echo "<br>".$sql;
			DB::insert($sql);
		}
	}

}