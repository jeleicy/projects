<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Redirect;
use Illuminate\Support\Facades\Input;

use App\candidato;

class FuncionesControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /periodicos
     *
     * @return Response
     */
    public function index() {
		//
    }
	
    public static function fecha_normal($fecha_nacimiento) {
        if (!is_null($fecha_nacimiento)) {
            $fecha=explode("-",$fecha_nacimiento);
            return $fecha[2]."/".$fecha[1]."/".$fecha[0];
        } else
            return "";
    }

    public static function fecha_mysql($valor) {
        if (!is_null($valor) && strpos($valor,"/") !== false) {
            $fecha=explode("/",$valor);
            return $fecha[2]."-".$fecha[1]."-".$fecha[0];
        } else
            return "";
    }
	
	public static function consulta_resultado($id_candidato,$fecha1,$fecha2,$tipo) {
		$array_mas=array("D"=>"0", "I"=>"0", "S"=>"0", "C"=>"0");
		$array_menos=array("D"=>"0", "I"=>"0", "S"=>"0", "C"=>"0");
		
		$array_respuestas=array("D", "I", "S", "C");
		
		$array_resultado="";
		
		$resultado="";
		$fecha="";
		
		$ids="";
		$sql = "select r.id, r.respuesta
				from respuestas_iol r, ";
		if ($tipo==1)
			$sql .= " opciones_iol o ";
		else
			$sql .= " opciones_iol_alt o ";
		
		$sql .= " where r.id_opcion=o.id and 
					r.id_candidato=$id_candidato ";
		//$sql .= " and date(r.fecha_creacion) between '$fecha1' and '$fecha2' ";		
		//$sql .= " and r.id_candidato=riol.id_candidato and riol.nro_prueba=$tipo
		$sql .= " group by r.id desc, o.respuesta limit 60";
		$data=DB::select($sql);
		//echo "<br><br>".$sql; return;
		foreach ($data as $data)
			$ids.=$data->id.",";
			
		$ids.=substr($ids,0,strlen($ids)-1);
		
		// OPCIONES DE MAS
		$sql = "select count(r.respuesta) as cantidad, o.respuesta, date(r.fecha_creacion) as fecha_creacion
		from respuestas_iol r, ";
		if ($tipo==1)
			$sql .= " opciones_iol o ";
		else
			$sql .= " opciones_iol_alt o ";
		
		$sql .= " where r.id_opcion=o.id and r.respuesta=1 and 
		r.id_candidato=$id_candidato ";
		//$sql .= " and date(r.fecha_creacion) between '$fecha1' and '$fecha2' ";
		$sql .= " and r.id in (".$ids.") 
		group by o.respuesta";
		$data=DB::select($sql);
		//echo "<br><br>".$sql;
		foreach ($data as $data) {
			$array_mas[$data->respuesta]=$data->cantidad;
			$fecha=$data->fecha_creacion;
		}
		
		// OPCIONES DE MENOS
		$sql = "select count(r.respuesta) as cantidad, o.respuesta 
		from respuestas_iol r, ";
		if ($tipo==1)
			$sql .= " opciones_iol o ";
		else
			$sql .= " opciones_iol_alt o ";	
		
		$sql .= " where r.id_opcion=o.id and r.respuesta=0 and
		r.id_candidato=$id_candidato ";
		//$sql .= " and date(r.fecha_creacion) between '$fecha1' and '$fecha2' ";
		$sql .= " and r.id in (".$ids.")
		group by o.respuesta";
		$data=DB::select($sql);
		foreach ($data as $data) {
			$array_menos[$data->respuesta]=$data->cantidad;
		}
		
		$resultado["fecha"]=$fecha;
		$resultado["mas"]=$array_mas;
		$resultado["menos"]=$array_menos;
		
		foreach ($array_respuestas as $key=>$value) {
			if (isset($array_mas[$value]) && isset($array_menos[$value]))
				$array_resultado[$value]=$array_mas[$value]-$array_menos[$value];
			elseif (isset($array_mas[$value]) && !isset($array_menos[$value]))
				$array_resultado[$value]=$array_mas[$value];
			elseif (!isset($array_mas[$value]) && isset($array_menos[$value]))
				$array_resultado[$value]=$array_menos[$value];				
		}
			
		$array_tipo=array("Deseada","Bajo Presion","Cotidiana");
		
		// DESEADA (+)
		foreach ($array_mas as $key=>$value) {
			$escala="";
			$sql = "select * from baremo where sigla='".$key."' and resultado='Deseada'";
			//echo "<br>".$sql."<br>";
			$data=DB::select($sql);
			foreach ($data as $data)
				$escala[]=$data->escala;
				
			//print_r ($escala);

			$i=0;
			$valor=0;
			if (!empty($escala)) {
				foreach ($escala as $key_escala=>$value_escala) {
					if ($i==0)
						$valor=self::buscar_valor_escala($value,$value_escala,"Deseada",$key);
					if ($valor!="")
						$i++;
				}
			}
			$resultado[$key]["Deseada"]=$valor;
		}
				
		// BAJO PRESION (-)
		foreach ($array_menos as $key=>$value) {
			$escala="";
			$sql = "select * from baremo where sigla='".$key."' and resultado='Bajo Presion'";
			//echo "<br>".$sql."<br>";
			$data=DB::select($sql);
			foreach ($data as $data)
				$escala[]=$data->escala;
				
			//print_r ($escala);

			$i=0;
			$valor=0;
			if (!empty($escala)) {
				foreach ($escala as $key_escala=>$value_escala) {
					if ($i==0)
						$valor=self::buscar_valor_escala($value,$value_escala,"Bajo Presion",$key);	
					if ($valor!="")
						$i++;				
				}
			}
			$resultado[$key]["Bajo Presion"]=$valor;			
		}

		// COTIDIANA (=)		
		foreach ($array_resultado as $key=>$value) {
			$escala="";
			$sql = "select * from baremo where sigla='".$key."' and resultado='Cotidiana'";
			//echo "<br>".$sql."<br>";
			$data=DB::select($sql);
			foreach ($data as $data)
				$escala[]=$data->escala;
				
			//print_r ($escala);
			$i=0;
			$valor=0;
			if (!empty($escala)) {
				foreach ($escala as $key_escala=>$value_escala) {
					if ($i==0)
						$valor=self::buscar_valor_escala($value,$value_escala,"Cotidiana",$key);
					if ($valor!="")
						$i++;				
				}
			}
			$resultado[$key]["Cotidiana"]=$valor;
		}
		return $resultado;
	}
	
	public static function buscar_valor_escala($value,$value_escala,$tipo,$sigla) {
		$resultado="";
		$escala="";
		$value_escala=str_replace("(","",$value_escala);
		$value_escala=str_replace(")","",$value_escala);
		//echo "<br>1)valor=$value...sigla=$sigla...tipo=$tipo...escala=$value_escala";
		if (strpos($value_escala,"between") !== false) {
			$t1=substr($value_escala,8,strpos($value_escala,"and")-8);			
			$t2=substr($value_escala,strpos($value_escala,"and")+4);
			$t1=trim($t1);
			$t2=trim($t2);
			
			if (($value>$t1 || $value==$t1) && ($value<$t2 || $value==$t2))
				$escala=$value_escala;
		} else {
			$t1=substr($value_escala,3);
			if ($value=$t1)
				$escala=$value_escala;
		}
		if ($escala!="") {
			if ($t1<0)
				$t1="(".trim($t1).")";
			if ($t2<0)
				$t2="(".trim($t2).")";
				
			$escala="between ".$t1." and ".$t2;
			$sql = "select * from baremo where escala='".$escala."' and sigla='".$sigla."' and resultado='".$tipo."'";
			//echo "<br>2)valor=$value...sigla=$sigla...tipo=$tipo...escala=$escala...$sql";
			$data=DB::select($sql);
			foreach ($data as $data)
				$resultado=$data->valor;
		}

		return $resultado;
	}
	
	public static function buscar_perfil($puntaje) {
		$sql = "select * from perfil where valor='".$puntaje."'";
		$data=DB::select($sql);
		if (empty($data))
			return "Invalido";
		else
			foreach ($data as $data)
				return strtolower($data->nombre);
	}
	
	public static function buscar_grupo_candidatos($id_grupo_candidatos) {
		$sql = "select * from grupo_candidatos where id=".$id_grupo_candidatos;
		$data=DB::select($sql);
		if (empty($data))
			return "-";
		else
			foreach ($data as $data)
				return strtolower($data->nombre);
	}
	
	public static function buscar_empresa($id) {
		$sql = "select * from empresas where id='".$id."'";
		$data=DB::select($sql);
		foreach ($data as $data)
			return strtoupper($data->nombre);
	}
	
	public static function buscar_grupo_candidato($id) {
		$sql = "select * from grupo_candidato where id='".$id."'";
		$data=DB::select($sql);
		foreach ($data as $data)
			return strtoupper($data->nombre);
	}	
	
	public static function buscar_prueba($id) {
		$sql = "select * from tipos_pruebas where id='".$id."'";
		$data=DB::select($sql);
		foreach ($data as $data)
			return strtoupper($data->nombre);
	}	
	
	public static function buscar_bateria($id) {
		$sql = "select * from bateria where id='".$id."'";
		$data=DB::select($sql);
		foreach ($data as $data)
			return strtoupper($data->nombre);
	}	
	
	public static function buscar_idioma($id) {
		$sql = "select * from idioma where id='".$id."'";
		$data=DB::select($sql);
		foreach ($data as $data)
			return ucfirst($data->nombre);
	}		
	
	public static function buscar_fecha_evaluacion($id_candidato) {
		$sql = "select * from resultados_iol where id_candidato=".$id_candidato;
		$data=DB::select($sql);
		if (empty($data))
			return "";
		else {
			foreach ($data as $data)
				return $data->fecha;
		}
	}		
	
	public static function buscar_usuario($id) {
		$sql = "select * from usuarios where id='".$id."'";
		$data=DB::select($sql);
		foreach ($data as $data)
			return strtoupper($data->nombres);
	}	

	public static function crear_combo($tabla, $valor) {
		$sql = "select * from ".$tabla." order by 2";
		//echo $sql;
		$data=DB::select($sql);
		$resultado="";
		$selected="";
		if (!empty($data)) {
			foreach ($data as $data) {
				$selected="";
				if ($data->id==$valor)
					$selected="selected";
				$resultado.="<option value='".$data->id."' $selected>".$data->nombre."</option>";
			}
		}
		echo $resultado;
	}
	
	public static function crear_combo_usuarios() {
		$sql = "select * from usuarios 
				where id_empresas=".Session::get("id_empresa")." 
				and rol='ERRHH' order by 2";
		//echo $sql; return;
		$data=DB::select($sql);
		$resultado="";
		$selected="";
		foreach ($data as $data)
			$resultado.="<option value='".$data->id."' ".$selected.">".$data->nombres."</option>";
		echo $resultado;
	}

	public static function cantidad_pruebas ()	{
		//echo "11111111111111";
		if (Session::get("rol")=="ERRHH") {
			$sql = "select sum(nro_asignadas) as nro_asignadas, 
					sum(nro_presentadas+nro_asignadas_no_presentadas) as nro_presentadas, id_tipo_prueba
				from pruebas_asignadas
				where id_usuario_asignado=".Session::get("id_usuario")."
				group by id_tipo_prueba";
		} else {
			$sql = "select * from ((select sum(nro_asignadas) as nro_asignadas, 
					sum(nro_presentadas+nro_asignadas_no_presentadas) as nro_presentadas, id_tipo_prueba
				from pruebas_asignadas
				where  id_empresa=".Session::get("id_empresa")." and id_usuario_asignado=0
				group by id_tipo_prueba)";
			$sql .= " union ";
			$sql .= "(select sum(nro_asignadas) as nro_asignadas, 
					sum(nro_presentadas+nro_asignadas_no_presentadas) as nro_presentadas, id_tipo_prueba
				from pruebas_asignadas
				where  id_empresa=".Session::get("id_empresa")." and id_usuario_asignado>0
				group by id_tipo_prueba)) as tabla order by nro_asignadas desc";
		}
		//echo $sql; return;
		
		$data=DB::select($sql);
		
		if (empty($data)) {
			$arreglo="";
		} else {
		$total_asignadas=0;
		$total_nro_presentadas=0;
		
		$asignadas=0;
		$nro_presentadas=0;
		
		$resultado=0;
		$i=0;
		$prueba=0;
		$arreglo="";
		
		$registros=count($data);
		$j=0;
		$pruebas="";
		foreach ($data as $data) {
			$pruebas[$data->id_tipo_prueba]["nro_asignadas"][]=$data->nro_asignadas;
			$pruebas[$data->id_tipo_prueba]["nro_presentadas"][]=$data->nro_presentadas;
			
			if ($data->id_tipo_prueba==$prueba || $prueba==0) {
				if ($i==0) {
					$total_asignadas=$data->nro_asignadas;
					$total_nro_presentadas=$data->nro_presentadas;
					$i++;
				} else {
					$asignadas=$data->nro_asignadas;
					$nro_presentadas=$data->nro_presentadas;
				}
				if ($j<$registros)
					$prueba=$data->id_tipo_prueba;
			} else {
				$asignadas=$total_asignadas-$asignadas;
				$nro_presentadas=$total_nro_presentadas-$nro_presentadas;
				
				$resultado=$asignadas-$nro_presentadas;
				$arreglo[$prueba]=$resultado;
				
				$total_asignadas=0;
				$total_nro_presentadas=0;
				
				$asignadas=0;
				$nro_presentadas=0;
				
				$resultado=0;				
				$i=0;
				
				if ($i==0) {
					$total_asignadas=$data->nro_asignadas;
					$total_nro_presentadas=$data->nro_presentadas;
					$i++;
				} else {
					$asignadas=$data->nro_asignadas;
					$nro_presentadas=$data->nro_presentadas;
				}
				if ($j<$registros)
					$prueba=$data->id_tipo_prueba;				
			}
			$j++;
		}
		//echo "<br>asignadas=$asignadas....";
		//echo "<br>nro_presentadas=$nro_presentadas....";
		$asignadas=$total_asignadas-$asignadas;
		$nro_presentadas=$total_nro_presentadas-$nro_presentadas;
		
		$resultado=$asignadas-$nro_presentadas;
		$arreglo[$prueba]=$resultado;
		
		$arreglo="";
			//print_r ($pruebas); return;
			foreach ($pruebas as $key=>$value) {
				$nro_asignadas=0;
				$nro_presentadas=0;
				for ($i=0; $i<count($value["nro_asignadas"]); $i++) {
					if ($value["nro_asignadas"][$i]>$nro_asignadas)
						$nro_asignadas=$value["nro_asignadas"][$i]-$nro_asignadas;
					else
						$nro_asignadas=$nro_asignadas-$value["nro_asignadas"][$i];
				}
				for ($i=0; $i<count($value["nro_presentadas"]); $i++)
					$nro_presentadas=$nro_presentadas+$value["nro_presentadas"][$i];
				$arreglo[$key]=$nro_asignadas-$nro_presentadas;
			}
		}
		return $arreglo;
	}
	
	public static function pruebas_disponibles() {
		if (Session::get("rol")=="ERRHH") {
			$sql = "select sum(nro_asignadas) as nro_asignadas, 
					sum(nro_asignadas_no_presentadas) as nro_presentadas, id_tipo_prueba
				from pruebas_asignadas
				where id_usuario_asignado=".Session::get("id_usuario");
				if (Session::get("rol")=="ERRHH")
					$sql .= " and id_usuario_asignado=".Session::get("id_usuario");
		} else {
			$sql = "select * from ((select sum(nro_asignadas) as nro_asignadas, 
					sum(nro_asignadas_no_presentadas) as nro_presentadas, id_tipo_prueba
				from pruebas_asignadas
				where  id_usuario_asignado=0 and id_empresa=".Session::get("id_empresa");
				if (Session::get("rol")=="ERRHH")
					$sql .= " and id_usuario_asignado=".Session::get("id_usuario");				
				$sql .= " group by id_tipo_prueba)
				UNION
				(select sum(nro_asignadas) as nro_asignadas, 
					sum(nro_asignadas_no_presentadas) as nro_presentadas, id_tipo_prueba
				from pruebas_asignadas
				where  id_usuario_asignado>0 and id_empresa=".Session::get("id_empresa");
				if (Session::get("rol")=="ERRHH")
					$sql .= " and id_usuario_asignado=".Session::get("id_usuario");					
				$sql .= " group by id_tipo_prueba))";
		}
		$sql .= " as tabla order by id_tipo_prueba";
		//echo $sql; return;
		$data=DB::select($sql);
		
		$total_asignadas=0;
		$total_nro_presentadas=0;
		
		$asignadas=0;
		$nro_presentadas=0;
		
		$resultado=0;
		$i=0;
		$id_tipo_prueba="";
		/*
		nro_asignadas	nro_presentadas	id_tipo_prueba
		11 					2 					1 
		15 					0 					1 
		10 					0 					2 
		2 					0 					2		
		*/
		foreach ($data as $data) {
			if ($i==0) {
				$total_asignadas=$data->nro_asignadas;
				$total_nro_presentadas=$data->nro_presentadas;
				$i++;
			} else {
				$asignadas=$data->nro_asignadas;
				$nro_presentadas=$data->nro_presentadas;				
			}
		}
		$asignadas=$total_asignadas-$asignadas;
		$nro_presentadas=$total_nro_presentadas-$nro_presentadas;
		
		$resultado=$asignadas-$nro_presentadas;
		
		return $resultado;
	}
	
	public static function cantidad_tipos_pruebas($valor) {
		$sql = "select count(*) as cantidad 
				from autorizaciones 
				where id_tipo_prueba=".$valor." and presento=1";
		//echo $sql; return;
		$data=DB::select($sql);
		if (empty($data))
			return 0;
		else {
			foreach ($data as $data)
				return $data->cantidad;
		}
	}
	
    public static function generarClave() {
        srand(self::crear_semilla());

        // Generamos la clave
        $clave="";
        $max_chars = round(rand(7,10));  // tendr&aacute; entre 7 y 10 caracteres
        $chars = array();
        for ($i="a"; $i<"z"; $i++) $chars[] = $i;  // creamos vector de letras
        $chars[] = "z";
        for ($i=0; $i<$max_chars; $i++) {
          $letra = round(rand(0, 1));  // primero escogemos entre letra y n&uacute;mero
          if ($letra) // es letra
             $clave .= $chars[round(rand(0, count($chars)-1))];
          else // es numero
             $clave .= round(rand(0, 9));
        }
        return $clave;
    }

    // Creamos la semilla para la funci&oacute;n rand()
    public static function crear_semilla() {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + ((float) $usec * 100000);
    }		
	
	public static function actualizar_pruebas_asignadas($id_tipo_prueba, $tipo, $id_autorizacion) {
		//echo $id_tipo_prueba."..".$tipo."..".$id_autorizacion; return;
		
		if ($id_autorizacion>0) {
			$sql = "select * from autorizaciones where id=".$id_autorizacion;
			$data=DB::select($sql);
			foreach ($data as $data) {
				$id_invitador=$data->id_invitador;
				$id_empresa=$data->id_empresas;
			}
			$sql="select rol from usuarios where id=".$id_invitador;
			$data=DB::select($sql);
			foreach ($data as $data)
				$rol=$data->rol;
		} else {
			$id_invitador=Session::get("id_usuario");
			$id_empresa=Session::get("id_empresa");
			$rol=Session::get("rol");
		}
		
		$sql = "update pruebas_asignadas set ";
		
		if ($tipo=="invitacion")
			$sql .= "nro_asignadas_no_presentadas=nro_asignadas_no_presentadas+1 ";
		else {
			$sql .= "nro_asignadas_no_presentadas=nro_asignadas_no_presentadas+1 ";
			$sql .= ", nro_asignadas_no_presentadas=nro_asignadas_no_presentadas-1 ";
		}
			
		$sql .= "where id_tipo_prueba=$id_tipo_prueba and ";
			//and (nro_asignadas_no_presentadas+nro_presentadas) < nro_asignadas and ";		
		
		if ($rol=="ERRHH") {
			$sqlBusqueda = "select * from pruebas_asignadas 
				where id_tipo_prueba=".$id_tipo_prueba." and
				id_usuario_asignado=".$id_invitador;
			//echo $sqlBusqueda; return;
			$data = DB::select($sqlBusqueda);
			$i=0;
			foreach ($data as $data) {
				if ($i==0) {
					$id_pruebas_asignadas=$data->id;
					$i++;
				}
			}		
			$sql .= " id_usuario_asignado=".$id_invitador." and id=".$id_pruebas_asignadas;
		} else {
			$sqlBusqueda = "select * from pruebas_asignadas 
				where id_empresa=".$id_empresa;
			$data = DB::select($sqlBusqueda);
			$i=0;
			foreach ($data as $data) {
				if ($i==0) {
					$id_pruebas_asignadas=$data->id;
					$i++;
				}
			}
			
			$sql .= "id_empresa=".$id_empresa." and id=".$id_pruebas_asignadas;
		}
		//echo $sql; return;
		DB::update($sql);		
	}
	
	public static function buscarTiempo($id) {
		$sql = "select * from tipos_pruebas where id=".$id;
		$data=DB::select($sql);
		$tiempo="";
		foreach ($data as $data)
			$tiempo = $data->tiempo."/".$data->vista_tiempo;
		return $tiempo;
	}
	
	public static function buscar_pruebas($id) {
		$sql = "select tp.* 
				from tipos_pruebas tp, bateria b, bateria_tipo_prueba btp
				where b.id=".$id." and btp.id_tipo_prueba=tp.id and btp.id_bateria=b.id";
		$data=DB::select($sql);
		$texto="<ul>";
		
		foreach ($data as $data) {
			$texto.="<li>".$data->nombre."</li>";
		}
		$texto.="</ul>";
		echo $texto;
	}
	
	public static function crear_check($tabla, $nombre_check, $id_bateria) {
		$sql = "select * from $tabla order by nombre";
		$data=DB::select($sql);
		$texto="";
		$checked="";
		$orden=0;
		foreach ($data as $data) {
			if ($id_bateria>0) {
				$sql = "select tp.*, btp.orden
						from tipos_pruebas tp, bateria b, bateria_tipo_prueba btp
						where b.id=".$id_bateria." and 
							btp.id_tipo_prueba=tp.id and btp.id_bateria=b.id and 
							tp.id=".$data->id." order by tp.id, btp.orden";
				$data_prueba=DB::select($sql);				
				if (empty($data_prueba)) {
					$checked="";
					$orden=0;
				} else {
					$checked="checked";
					foreach ($data_prueba as $data_prueba) 
						$orden=$data_prueba->orden;
				}
			}
			
			$texto .= '
				<div class="form-group">';
			$texto .= '<input type="checkbox" value="'.$data->id.'" '.$checked.' name="'.$nombre_check.'_'.$data->id.'" id="'.$nombre_check.'_'.$data->id.'">&nbsp;&nbsp;'.$data->nombre.'
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Orden: <span class="msj">(*)</span>:</label>
					<div class="col-md-2 col-sm-3 col-xs-3">
						<input maxlength="2" onKeyPress="return soloNumeros(event)" id="orden_'.$data->id.'" name="orden_'.$data->id.'" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Orden" value="'.$orden.'"></div></div>
			';
		}
		
		echo $texto;			
	}
	
	public static function crear_menu_pruebas($id_bateria, $bateria, $ruta) {
		$texto="";
		
		$sql = "select tp.nombre, tp.id
				from tipos_pruebas tp, bateria_tipo_prueba btp
				where btp.id_bateria=".$id_bateria." and btp.id_tipo_prueba=tp.id";		
		$data_pruebas=DB::select($sql);
		$texto = '<li><a href="#"><i class="fa fa-check"></i>'.$bateria.'
					<span class="fa arrow"></span></a>';
		if (!empty($data_pruebas)) {
			$texto .= '<ul class="nav nav-third-level">';
			foreach ($data_pruebas as $data_pruebas) {
				$id=isset($data_pruebas->id) ? $data_pruebas->id : 0;
				$nombre=isset($data_pruebas->nombre) ? $data_pruebas->nombre : 0;
				$texto .='
				<li>
					<a href="'.$ruta.'encuesta_reporte/'.$id.'">
						<i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;
							'.$nombre.'
					</a>
				</li>';
			}
			$texto .= "</ul>";
		}
		$texto .= "</li>";
		echo $texto;
	}
	
	public static function buscar_evaluaciones($id, $fecha_reporte1, $fecha_reporte2, $presento) {
		$sql = "select count(a.id) as cantidad
		from usuarios u, autorizaciones a 
		where u.id=a.id_usuario and 
		u.id=".$id." and a.presento=".$presento." and 
		date(a.fecha) between '".FuncionesControllers::fecha_mysql($fecha_reporte1)."' and '".FuncionesControllers::fecha_mysql($fecha_reporte2)."' ";
		$sql .= " group by u.id, u.nombres, u.email order by u.nombres";
		$data=DB::select($sql);
		if (empty($data))
			return 0;
		else {
			foreach ($data as $data)
				return $data->cantidad;
		}
	}	
	
	public static function buscar_instrucciones($tipo_prueba, $id_empresa) {
		$idioma=\App::getLocale();
		$sql = "select id from idioma where tipo='".$idioma."'";
		$data=DB::select($sql);
		foreach ($data as $data)
			$id_idioma=$data->id;
			
		$sql = "select * 
				from instrucciones 
				where id_empresa=$id_empresa and 
					id_idioma=$id_idioma and 
					id_prueba=".$tipo_prueba;
		$data=DB::select($sql);
		foreach ($data as $data)
			echo $data->texto;
	}
	
	public static function prueba_inter($i) {
		$resultado="";
		if ($i==2) {
				$resultado .= '
					<div id="encuesta" style="display:none;">
					<div id="cont3">
							

					<div id="prueba1_sl_cont">
					<br /><br /><br />
					<div align="center">
							<div align="center" style="display: inline" id="prueba1">
								<div class="prueba1_sl_txt">Ettedgui, J.
									<input tabindex=1 autofocus maxlength="2" class="clase_co" style="font-size: 28px; width:50px; height:30px; text-align: center" type="text" name="coord_1" id="coord_1" value="">
								</div>
							</div>		
							
								<script>
									respuesta_actual_co[1]=12;
									//tabindex=1;
								</script>		<div align="center" style="display: none" id="prueba2">
								<div class="prueba1_sl_txt">Tovar, Y.T.
									<input tabindex=2  maxlength="2" class="clase_co" style="font-size: 28px; width:50px; height:30px; text-align: center" type="text" name="coord_2" id="coord_2" value="">
								</div>
							</div>		
							
								<script>
									respuesta_actual_co[2]=37;
									//tabindex=2;
								</script>		<div align="center" style="display: none" id="prueba3">
								<div class="prueba1_sl_txt">Brito, J.R.
									<input tabindex=3  maxlength="2" class="clase_co" style="font-size: 28px; width:50px; height:30px; text-align: center" type="text" name="coord_3" id="coord_3" value="">
								</div>
							</div>		
							
								<script>
									respuesta_actual_co[3]=5;
									//tabindex=3;
								</script></div>
					<br /><br /><br />
					<div id="valor" style="text-align: center; font-size:14pt; width: 100%;"></div>

					<!-- BOTONES -->
					<br /><br /><br />
					<div id="cont_botones_pru1" align="left">
						<div align="center" class="botones_pru" style="width:100%; position:relative; border: 0px solid green;">
							<input type="button" style="display: none;" id="anterior" class="botones" onclick="anterior_op()" value="Anterior">
							<input type="button" style="display: inline;" id="siguiente" class="botones" onclick="siguiente_op()" value="Siguiente">
							<input type="button" style="display: none;" id="finalizar" class="botones" onclick="guardar_encuesta_co()" value="Continuar">
						</div>
					</div>
					<!-- CIERRE BOTONES -->
					</div>

					<!-- ARCHIVADOR -->
					<div id="cont_archivador" style="z-index:1000;">
					<a href="javascript:;"  onclick="colocar_nro(1)"><div id="texto_arch" class="texto_arch">1<br />Aa - Al</div></a>
					<a href="javascript:;"  onclick="colocar_nro(9)"><div id="texto_arch" class="texto_arch">9<br />Cp - Cz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(17)"><div id="texto_arch" class="texto_arch">17<br />Ha - Hz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(25)"><div id="texto_arch" class="texto_arch">25<br />Mj - Mo</div></a>
					<a href="javascript:;"  onclick="colocar_nro(33)"><div id="texto_arch" class="texto_arch">33<br />Sa - Si</div></a>

					<a href="javascript:;"  onclick="colocar_nro(2)"><div id="texto_arch" class="texto_arch">2<br />Am - Au</div></a>
					<a href="javascript:;"  onclick="colocar_nro(10)"><div id="texto_arch" class="texto_arch">10<br />Da - Dz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(18)"><div id="texto_arch" class="texto_arch">18<br />Ia - Iz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(26)"><div id="texto_arch" class="texto_arch">26<br />Mp - Mz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(34)"><div id="texto_arch" class="texto_arch">34<br />Sj - St</div></a>

					<a href="javascript:;"  onclick="colocar_nro(3)"><div id="texto_arch" class="texto_arch">3<br />Av - Az</div></a>
					<a href="javascript:;"  onclick="colocar_nro(11)"><div id="texto_arch" class="texto_arch">11<br />Ea - Er</div></a>
					<a href="javascript:;"  onclick="colocar_nro(19)"><div id="texto_arch" class="texto_arch">19<br />Ja - Jz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(27)"><div id="texto_arch" class="texto_arch">27<br />Na - Nz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(35)"><div id="texto_arch" class="texto_arch">35<br />Su - Sz</div></a>

					<a href="javascript:;"  onclick="colocar_nro(4)"><div id="texto_arch" class="texto_arch">4<br />Ba - Bi</div></a>
					<a href="javascript:;"  onclick="colocar_nro(12)"><div id="texto_arch" class="texto_arch">12<br />Es - Ez</div></a>
					<a href="javascript:;"  onclick="colocar_nro(20)"><div id="texto_arch" class="texto_arch">20<br />Ka - Ko</div></a>
					<a href="javascript:;"  onclick="colocar_nro(28)"><div id="texto_arch" class="texto_arch">28<br />Oa - Oz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(36)"><div id="texto_arch" class="texto_arch">36<br />Ta - Ti</div></a>

					<a href="javascript:;"  onclick="colocar_nro(5)"><div id="texto_arch" class="texto_arch">5<br />Bj - Br</div></a>
					<a href="javascript:;"  onclick="colocar_nro(13)"><div id="texto_arch" class="texto_arch">13<br />Fa - Fr</div></a>
					<a href="javascript:;"  onclick="colocar_nro(21)"><div id="texto_arch" class="texto_arch">21<br />Kp - Kz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(29)"><div id="texto_arch" class="texto_arch">29<br />Pa - Pr</div></a>
					<a href="javascript:;"  onclick="colocar_nro(37)"><div id="texto_arch" class="texto_arch">37<br />Tj - Tz</div></a>

					<a href="javascript:;"  onclick="colocar_nro(6)"><div id="texto_arch" class="texto_arch">6<br />Bs - Bz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(14)"><div id="texto_arch" class="texto_arch">14<br />Fs - Fz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(22)"><div id="texto_arch" class="texto_arch">22<br />La - Le</div></a>
					<a href="javascript:;"  onclick="colocar_nro(30)"><div id="texto_arch" class="texto_arch">30<br />Ps - Pz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(38)"><div id="texto_arch" class="texto_arch">38<br />U - V</div></a>

					<a href="javascript:;"  onclick="colocar_nro(7)"><div id="texto_arch" class="texto_arch">7<br />Ca - Ch</div></a>
					<a href="javascript:;"  onclick="colocar_nro(15)"><div id="texto_arch" class="texto_arch">15<br />Ga - Go</div></a>
					<a href="javascript:;"  onclick="colocar_nro(23)"><div id="texto_arch" class="texto_arch">23<br />Lf - Lz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(31)"><div id="texto_arch" class="texto_arch">31<br />Qa - Qz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(39)"><div id="texto_arch" class="texto_arch">39<br />Wa - Wz</div></a>

					<a href="javascript:;"  onclick="colocar_nro(8)"><div id="texto_arch" class="texto_arch">8<br />Ci - Co</div></a>
					<a href="javascript:;"  onclick="colocar_nro(16)"><div id="texto_arch" class="texto_arch">16<br />Gp - Gz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(24)"><div id="texto_arch" class="texto_arch">24<br />Ma - Mi</div></a>
					<a href="javascript:;"  onclick="colocar_nro(32)"><div id="texto_arch" class="texto_arch">32<br />Ra - Rz</div></a>
					<a href="javascript:;"  onclick="colocar_nro(40)"><div id="texto_arch" class="texto_arch">40<br />X - Y -Z</div></a>
					</div>
					<!-- CIERRE ARCHIVADOR -->

					</div>
					</div>				
			';
		} elseif ($i==3) {
			$resultado = "<div align='center' style='border: solid 2px; border-color: red; width: 750px; border-radius: 15px 50px 30px; margin: 5px; padding: 5px;'>";
			$resultado = "<table border=0 width='100%' align='center'><tr><td width='50%'>";
			$resultado.="
						<table border=0 width='100%'>
							<tr height='50px' valign='top'>
								<td width='30%' align='right'><strong><h4>lengua</h4></strong></td>
								<td width='15%' align='center'><span style='color: blue'><h4>es a</h4></span></td>
								<td width='30%'><strong><h4>gustar</h4></strong></td>
								<td width='15%' align='left'><span style='color: blue'><h4>como</h4></span><br /><br /></td>
							</tr>
							<tr height='50px'>
								<td align='right'><strong><h4>nariz</h4></strong></td>
								<td align='center'><span style='color: blue'><h4>es a</h4></span></td>
								<td colspan='3'><span width='30px' id='respuesta'></span></td>
							</tr>
						</table>
					";	
			//$i--;
			$resultado .= "</td><td>&nbsp;</td><td><table>";
			$resultado.="<tr><td align='right'><h4>sentir</h4></td><td>&nbsp;</td><td><input type='radio' name='op' id='op' value='1' onclick='colocar_test(0,\"sentir\", this.value, $i, this.name)'></td></tr>";
			$resultado.="<tr><td align='right'><h4>respirar</h4></td><td>&nbsp;</td><td><input type='radio' name='op' id='op' value='2' onclick='colocar_test(0,\"respirar\", this.value, $i, this.name)'></td></tr>";
			$resultado.="<tr><td align='right'><h4>exhalar</h4></td><td>&nbsp;</td><td><input type='radio' name='op' id='op' value='3' onclick='colocar_test(0,\"exhalar\", this.value, $i, this.name)'></td></tr>";
			$resultado.="<tr><td align='right'><h4>oler</h4></td><td>&nbsp;</td><td><input type='radio' name='op' id='op' value='4' onclick='colocar_test(1,\"oler\", this.value, $i, this.name)'></td></tr>";
			$resultado .= "</table></td></tr></table><div id='especificacion'><div id='texto_ejemplo' style='border: 2px solid red; width: 50%; float: left;'></div></div>";
		} elseif ($i==4) {
			$resultado = "
				<table width='95%' border='2' cellpadding='5' cellspacing='5'>
					<tr><td><td colspan=2 style='color:#000'><h4><strong>Al lanzar una pelota golpea accidentalmente a una anciana. Ud:</strong></h4></td><td colspan=2>&nbsp;</td></tr>
					<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
						<td>&nbsp;</td>
						<td width='80%' style='color:#000'>Huye corriendo del lugar.</td>
						<td width='10%'><input onclick='colocar_test(0,\"\",1, $i, this.name)' type='radio' name='mas' id='mas_1' value='1'> (+)</td>
						<td width='10%'><input onclick='colocar_test(0,\"\",1, $i, this.name)' type='radio' name='menos' id='menos_1' value='1'> (-)</td>
					</tr>
					<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
						<td>&nbsp;</td>
						<td width='80%' style='color:#000'>Se acerca y se disculpa.</td>
						<td width='10%'><input onclick='colocar_test(1,\"\",2, $i, this.name)' type='radio' name='mas' id='mas_2' value='2'> (+)</td>
						<td width='10%'><input onclick='colocar_test(0,\"\",2, $i, this.name)' type='radio' name='menos' id='menos_2' value='2'> (-)</td>
					</tr>
					<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
						<td>&nbsp;</td>
						<td width='80%' style='color:#000'>Se rie de lo sucedido.</td>
						<td width='10%'><input onclick='colocar_test(0,\"\",3, $i, this.name)' type='radio' name='mas' id='mas_3' value='3'> (+)</td>
						<td width='10%'><input onclick='colocar_test(1,\"\",3, $i, this.name)' type='radio' name='menos' id='menos_3' value='3'> (-)</td>
					</tr>
					<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
						<td>&nbsp;</td>
						<td width='80%' style='color:#000'>Espera a que alguien la ayude.</td>
						<td width='10%'><input onclick='colocar_test(0,\"\",4, $i, this.name)' type='radio' name='mas' id='mas_4' value='4'> (+)</td>
						<td width='10%'><input onclick='colocar_test(0,\"\",4, $i, this.name)' type='radio' name='menos' id='menos_4' value='4'> (-)</td>
					</tr>
					<tr><td colspan='4'><span id='respuesta'></span></td></tr>
				</table><div id='texto_ejemplo' style='border: 2px solid red; width: 50%; float: left;'></div>
			";
		} elseif ($i==5) {
			$resultado = "<div align='center' style='border: solid 2px; border-color: red; width: 750px; border-radius: 15px 50px 30px; margin: 5px; padding: 5px;'>";
			$opciones=array(1=>'Completamente en Desacuerdo',
				2=>'Moderadamente en Desacuerdo',
				3=>'Ligeramente en Desacuerdo',
				
				4=>'Ligeramente de Acuerdo',
				5=>'Moderadamente de Acuerdo',
				6=>'Completamente de Acuerdo');			
			
			$resultado = "
				<table width='95%' cellpadding='5' cellspacing='5' border=0 align='center'>
					<tr><td><h4><strong>Disfruta la comida con mucho picante.</strong></h4><br /></td></tr>
					";
			$xxx=1;
			foreach ($opciones as $key=>$value) {
				$resultado .= "<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
						<td width='100%'>
							<table border=0 width='100%' align='center'>
								<tr>
									<td width='30%' align='right'>".$value."</td>
									<td width='5%' align='right'>&nbsp;</td>
									<td width='5%' align='center'><input onclick='colocar_test_phi(0,\"\",5, $i, this.name, ".$key.")' type='radio' name='op_1' id='op_1' value='".$key."'></td>
									<td><div id='res_".$key."'>&nbsp;</div><div id='respuesta'>&nbsp;</div></td>
								</tr>
							</table>
						</td>
					</tr>";	
				//$resultado .= "<tr><td colspan='4'><span id='respuesta'></span></td></tr>";
				$xxx++;
			}
			$resultado .= "</table><div id='texto_ejemplo' style='border: 2px solid red; width: 50%; float: left;'></div>";
		} elseif ($i==6) {
			//RA
			$resultado = '
				<div id="prueba" style="border: solid 0px; border-color: red; width:70%; float:left;">
					<div id="prueba2_op_cont">
						<div id="prueba_num1">1.</div>
						<button type="button" class="prueba2"><br /><img src="../imagenes/RA/ejemplo1.jpg"  width="75" height="75"/></button>
						<button type="button" class="prueba2"><br /><img src="../imagenes/RA/ejemplo2.jpg"  width="75" height="75"/></button>
						<button type="button" class="prueba2"><br /><img src="../imagenes/RA/ejemplo3.jpg"  width="75" height="75"/></button>
						<button type="button" class="prueba2"><br /><img src="../imagenes/RA/ejemplo4.jpg"  width="75" height="75"/></button>
						<button type="button" class="prueba2"><br /><div id="img_respuesta" style="width=80px; height:75px; padding: 0px; margin: 0px; border-radius: 15px; border-color: #c8c8c8; border: 2px solid"><img width="60" height="75" src="../imagenes/interrogacion.png"></div></button>
					</div>
					<div align="left" style="margin-left:7%;"><strong>Seleccione una de las opciones...</strong></div>
					<div id="prueba2_op_cont" style="float: left; margin-left:3%; border:0px solid green;">								
						<button type="button" class="prueba2" href="javascript:;" onclick="ver_imagen_ejemplo(1, 5, \'ejemplo5.jpg\')"><br /><img width="75" height="75" src="../imagenes/RA/ejemplo5.jpg" /></button>
						<button type="button" class="prueba2" href="javascript:;" onclick="ver_imagen_ejemplo(1, 6, \'ejemplo6.jpg\')"><br /><img width="75" height="75" src="../imagenes/RA/ejemplo6.jpg" /></button>
						<button type="button" class="prueba2" href="javascript:;" onclick="ver_imagen_ejemplo(1, 7, \'ejemplo7.jpg\')"><br /><img width="75" height="75" src="../imagenes/RA/ejemplo7.jpg" /></button>
						<button type="button" class="prueba2" href="javascript:;" onclick="ver_imagen_ejemplo(1, 8, \'ejemplo8.jpg\')"><br /><img width="75" height="75" src="../imagenes/RA/ejemplo8.jpg" /></button>
						<button type="button" class="prueba2" href="javascript:;" onclick="ver_imagen_ejemplo(1, 9, \'ejemplo9.jpg\')"><br /><img width="75" height="75" src="../imagenes/RA/ejemplo9.jpg" /></button>
					</div>
					<div id="button_continuar" style="position:absolute; margin-left:5%; width:80%; text-align:center;  border: 0px solid red; top:70%;">
						<button style="display:none" name="boton_prueba" id="boton_prueba" onclick="ver_preguntas(\'15\',\'\')" type="button" class="botones" value="Continuar">Comenzar..
					</div>
					<div id="texto_ejemplo" style="border: 2px solid red; color: red;display:none; width: 70%; float: left; margin: 10px; padding:10px;"></div>
				</div>
			';
		} elseif ($i==7) {
			//RV
			$resultado = '
				<div id="prueba" style="display: inline;">
					<div id="prueba2_sl_cont1" align="left" style="margin-left:7%;">
						<div id="prueba2_sl_btn1cont" style="padding-bottom:50px;">
							<div id="prueba2_sl_btn1_grande" align="center">
								<div id="op" style="font-size: 25px;">.....es a agua como comer es a.....</div>
							</div>
						</div>
					</div>
					<div align="left" style="margin-left:7%;"><strong>Seleccione una de las opciones...</strong></div>
					<div id="prueba2_sl_cont1" style="padding-left:60px;">
						<div id="prueba2_sl_cont5">
							<br>
							<button type="button" onclick="colocar_respuesta_ejemplo(\'rv\',\'rio\',\'sopa\', this)" class="prueba1">rio &ndash; sopa</button>
							<br>
									<br>
							<button type="button" onclick="colocar_respuesta_ejemplo(\'rv\',\'sal\',\'carne\', this)" class="prueba1">sal &ndash; carne</button>
							<br>
									<br>
							<button type="button" onclick="colocar_respuesta_ejemplo(\'rv\',\'beber\',\'pan\', this)" class="prueba1">beber &ndash; pan</button>
							<br>
									<br>
							<button type="button" onclick="colocar_respuesta_ejemplo(\'rv\',\'tomar\',\'boca\', this)" class="prueba1">tomar &ndash; boca</button>
							<br>
									<br>
							<button type="button" onclick="colocar_respuesta_ejemplo(\'rv\',\'sed\',\'placer\', this)" class="prueba1">sed &ndash; placer</button>
							<br>
						</div>
					</div>
					<div id="button_continuar" style="position:absolute; margin-left:5%; width:80%; text-align:center;  border: 0px solid red; top:70%;">
						<button style="display:none" name="boton_prueba" id="boton_prueba" onclick="ver_preguntas(\'15\',\'\')" type="button" class="botones" value="Continuar">Comenzar..
					</div>	<div id="texto_ejemplo" style="border: 2px solid red; color: red;display:none; width: 70%; float: left; margin: 10px; padding:10px;"></div>			
				</div><br />
			';
		} elseif ($i==8) {
			$resultado = '
				<div id="prueba" style="top: 0; display:inline; border: 0px solid red;">
					<div id="prueba2_sl_cont1" style="width:40%; border: 0px solid red;">
						<div id="prueba_num"></div>
						<div id="prueba2_sl_btn1cont">
							<div id="prueba2_sl_btn1_mediano" align="center">
								<div id="op_56" style="font-size: 25px;"><img width="150" height="120" src="../imagenes/HN/ejemplo.jpg">
									<div class="prueba2_sl_btn1_respuesta" id=\'respuesta\' style=\'color: blue; line-height: 200%\'></div>
								</div>
							</div>
						</div>
					</div>
					<div id="prueba2_sl_cont4hn" style="width:50%; border: 0px solid yellow;">
						<div id="prueba2_sl_cont5">
							<br>
							<button type="button" onclick="colocar_respuesta_ejemplo(\'hn\', \'100\', \'\', this)" class="prueba1">100</button>
							<br>
									<br>
							<button type="button" onclick="colocar_respuesta_ejemplo(\'hn\', \'101\', \'\', this)" class="prueba1">101</button>
							<br>
									<br>
							<button type="button" onclick="colocar_respuesta_ejemplo(\'hn\', \'110\', \'\', this)" class="prueba1">110</button>
							<br>
									<br>
							<button type="button" onclick="colocar_respuesta_ejemplo(\'hn\', \'111\', \'\', this)" class="prueba1">111</button>
							<br>
									<br>
							<button type="button" onclick="colocar_respuesta_ejemplo(\'hn\', \'Ninguna\', \'\', this)" class="prueba1">Ninguna</button>
							<br>
						</div>
					</div>
					<div id="button_continuar" style="position:absolute; margin-left:5%; width:80%; text-align:center;  border: 0px solid red; top:75%;">
						<button style="display:none" name="boton_prueba" id="boton_prueba" onclick="ver_preguntas(\'15\',\'\')" type="button" class="botones" value="Continuar">Comenzar..
					</div>	<div id="texto_ejemplo" style="border: 2px solid red; color: red;display:none; width: 70%; float: left; margin: 10px; padding:10px;"></div>				
				</div>
			';
		} elseif ($i==9) {
			$resultado = '
			<div id="prueba3_sl_cont" style="margin-left:10%; width:60%; border: 0px solid green; text-align:left;">
				<div id="prueba3_sl_preg" style="width:100%;">Al lanzar una pelota, golpea accidentalmente a una anciana. Usted.</div>
				<br><br><br>
				<div id="prueba1_pc_cont">				
					<div id="prueba1_pc_resp">
						<div id="prueba1_pc_txt" class="clase_iep">Huye corriendop del lugar.
							<label id="label_menos_1" for="label_menos_1" style="float: right; position: relative; top:0px; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
								&nbsp;&nbsp;&nbsp;
								<input src="../imagenes/negativo.gif" class="radio_iol" name="menos" id="menos" value="1" onmousedown="colocar_respuesta_ejemplo(\'iep_menos\',\'1\',\'\', this)" type="image" width="30" height="30">
								&nbsp;&nbsp;&nbsp;
							</label>						
							<label id="label_mas_1" for="label_mas_1" style="float: right; position: relative; top:0px; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
								&nbsp;&nbsp;&nbsp;
								<input src="../imagenes/positivo.gif" class="radio_iol" name="mas" id="mas" value="1" onmousedown="colocar_respuesta_ejemplo(\'iep_mas\',\'1\',\'\', this)" type="image" width="30" height="30">
								&nbsp;&nbsp;&nbsp;
							</label>					
						</div>
					</div>
					<br><br>
					<div id="prueba1_pc_resp">
						<div id="prueba1_pc_txt" class="clase_iep">Se acerca y se disculpa.				
							<label id="label_menos_2" for="label_menos_1" style="float: right; position: relative; top:0px; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
								&nbsp;&nbsp;&nbsp;
								<input src="../imagenes/negativo.gif" class="radio_iol" name="menos" id="menos" value="2" onmousedown="colocar_respuesta_ejemplo(\'iep_menos\',\'2\',\'\', this)" type="image" width="30" height="30">
								&nbsp;&nbsp;&nbsp;
							</label>
							<label id="label_mas_2" for="label_mas_2" style="float: right; position: relative; top:0px; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
								&nbsp;&nbsp;&nbsp;
								<input src="../imagenes/positivo.gif" class="radio_iol" name="mas" id="mas" value="2" onmousedown="colocar_respuesta_ejemplo(\'iep_mas\',\'2\',\'\', this)" type="image" width="30" height="30">
								&nbsp;&nbsp;&nbsp;
							</label>								
						</div>
					</div>
					<br><br>
					<div id="prueba1_pc_resp">
						<div id="prueba1_pc_txt" class="clase_iep">Se rie de lo sucedido.
							<label id="label_menos_3" for="label_menos_3" style="float: right; position: relative; top:0px; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
								&nbsp;&nbsp;&nbsp;
								<input src="../imagenes/negativo.gif" class="radio_iol" name="menos" id="menos" value="3" onmousedown="colocar_respuesta_ejemplo(\'iep_menos\',\'3\',\'\', this)" type="image" width="30" height="30">
								&nbsp;&nbsp;&nbsp;
							</label>						
							<label id="label_mas_3" for="label_mas_3" style="float: right; position: relative; top:0px; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
								&nbsp;&nbsp;&nbsp;
								<input src="../imagenes/positivo.gif" class="radio_iol" name="mas" id="mas" value="3" onmousedown="colocar_respuesta_ejemplo(\'iep_mas\',\'3\',\'\', this)" type="image" width="30" height="30">
								&nbsp;&nbsp;&nbsp;
							</label>					
						</div>
					</div>
					<br><br>
					<div id="prueba1_pc_resp">
						<div id="prueba1_pc_txt" class="clase_iep">Espera a que alguien la ayude.
							<label id="label_menos_4" for="label_menos_4" style="float: right; position: relative; top:0px; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
								&nbsp;&nbsp;&nbsp;
								<input src="../imagenes/negativo.gif" class="radio_iol" name="menos" id="menos" value="4" onmousedown="colocar_respuesta_ejemplo(\'iep_menos\',\'4\',\'\', this)" type="image" width="30" height="30">
								&nbsp;&nbsp;&nbsp;
							</label>						
							<label id="label_mas_4" for="label_mas_4" style="float: right; position: relative; top:0px; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
								&nbsp;&nbsp;&nbsp;
								<input src="../imagenes/positivo.gif" class="radio_iol" name="mas" id="mas" value="4" onmousedown="colocar_respuesta_ejemplo(\'iep_mas\',\'4\',\'\', this)" type="image" width="30" height="30">
								&nbsp;&nbsp;&nbsp;
							</label>					
						</div>
					</div>
				</div>
				<div id="button_continuar" style="position:absolute; margin-left:5%; width:80%; text-align:center;  border: 0px solid red; top:65%;">
					<button style="display:none" name="boton_prueba" id="boton_prueba" onclick="ver_preguntas(\'15\',\'\')" type="button" class="botones" value="Continuar">Comenzar..
				</div><div id="texto_ejemplo" style="border: 2px solid red; color: red;display:none; width: 70%; float: left; margin: 10px; padding:10px;"></div>
		</div>
			';
		} elseif ($i==10) {
			$resultado = '
				<table border=0 align="center">
					<tr>
						<td>
							<div class="container">
								<div class="row">																
									<div class="form-group" align="center" style="border: 0x solid red;">
										<label style="margin-left: 10%; position: relative; text-align: center; margin:0; border: 0px solid green; width:50%">
											<label for="happy_1" class="col-sm-4 col-md-4 control-label text-right" style="font-size: 17pt;">Ecuánime</label>
											<div class="col-sm-7 col-md-7">
												<label id="label_mas_1_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="1" type="radio" name="mas_1" id="mas_1" onclick="validar_ejemplo_iol(\'iol\',\'mas\',1,1, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/positivo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
												<label id="label_menos_1_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="1" type="radio" name="menos_1" id="menos_1" onclick="validar_ejemplo_iol(\'iol\',\'menos\',1,1, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/negativo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
											</div>
										</label>
									</div>
								</div>
							</div>																
						</td>
					</tr>						
					<tr>
						<td>
							<div class="container">
								<div class="row">																
									<div class="form-group" align="center" style="border: 0x solid red;">
										<label style="margin-left: 10%; position: relative; text-align: center; margin:0; border: 0px solid green; width:50%">
											<label for="happy_1" class="col-sm-4 col-md-4 control-label text-right" style="font-size: 17pt;">Amargado</label>
											<div class="col-sm-7 col-md-7">
												<label id="label_mas_2_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="2" type="radio" name="mas_1" id="mas_1" onclick="validar_ejemplo_iol(\'iol\',\'mas\',1,2, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/positivo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
												<label id="label_menos_2_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="2" type="radio" name="menos_1" id="menos_1" onclick="validar_ejemplo_iol(\'iol\',\'menos\',1,2, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/negativo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
											</div>
										</label>
									</div>
								</div>
							</div>																
						</td>
					</tr>
					<tr>
						<td>
							<div class="container">
								<div class="row">																
									<div class="form-group" align="center" style="border: 0x solid red;">
										<label style="margin-left: 10%; position: relative; text-align: center; margin:0; border: 0px solid green; width:50%">
											<label for="happy_1" class="col-sm-4 col-md-4 control-label text-right" style="font-size: 17pt;">Descuidado</label>
											<div class="col-sm-7 col-md-7">
												<label id="label_mas_3_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="3" type="radio" name="mas_1" id="mas_1" onclick="validar_ejemplo_iol(\'iol\',\'mas\',1,3, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/positivo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
												<label id="label_menos_3_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="3" type="radio" name="menos_1" id="menos_1" onclick="validar_ejemplo_iol(\'iol\',\'menos\',1,3, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/negativo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
											</div>
										</label>
									</div>
								</div>
							</div>																
						</td>
					</tr>
					<tr>
						<td>
							<div class="container">
								<div class="row">																
									<div class="form-group" align="center" style="border: 0x solid red;">
										<label style="margin-left: 10%; position: relative; text-align: center; margin:0; border: 0px solid green; width:50%">
											<label for="happy_1" class="col-sm-4 col-md-4 control-label text-right" style="font-size: 17pt;">Confiado</label>
											<div class="col-sm-7 col-md-7">
												<label id="label_mas_4_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="4" type="radio" name="mas_1" id="mas_1" onclick="validar_ejemplo_iol(\'iol\',\'mas\',1,4, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/positivo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
												<label id="label_menos_4_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="4" type="radio" name="menos_1" id="menos_1" onclick="validar_ejemplo_iol(\'iol\',\'menos\',1,4, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/negativo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
											</div>
										</label>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table><div id="texto_ejemplo" style="border: 2px solid red; color: red;display:none; width: 70%; float: left; margin: 10px; padding:10px;"></div>
			';
		} elseif ($i==11) {
			$resultado = '
				<table border=0 align="center">
					<tr>
						<td>
							<div class="container">
								<div class="row">																
									<div class="form-group" align="center" style="border: 0x solid red;">
										<label style="margin-left: 10%; position: relative; text-align: center; margin:0; border: 0px solid green; width:50%">
											<label for="happy_1" class="col-sm-4 col-md-4 control-label text-right" style="font-size: 17pt;">Ecuánime</label>
											<div class="col-sm-7 col-md-7">
												<label id="label_mas_1_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="1" type="radio" name="mas_1" id="mas_1" onclick="validar_ejemplo_iol(\'iol_alt\',\'mas\',1,1, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/positivo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
												<label id="label_menos_1_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="1" type="radio" name="menos_1" id="menos_1" onclick="validar_ejemplo_iol(\'iol_alt\',\'menos\',1,1, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/negativo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
											</div>
										</label>
									</div>
								</div>
							</div>																
						</td>
					</tr>						
					<tr>
						<td>
							<div class="container">
								<div class="row">																
									<div class="form-group" align="center" style="border: 0x solid red;">
										<label style="margin-left: 10%; position: relative; text-align: center; margin:0; border: 0px solid green; width:50%">
											<label for="happy_1" class="col-sm-4 col-md-4 control-label text-right" style="font-size: 17pt;">Amargado</label>
											<div class="col-sm-7 col-md-7">
												<label id="label_mas_2_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="2" type="radio" name="mas_1" id="mas_1" onclick="validar_ejemplo_iol(\'iol_alt\',\'mas\',1,2, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/positivo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
												<label id="label_menos_2_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="2" type="radio" name="menos_1" id="menos_1" onclick="validar_ejemplo_iol(\'iol_alt\',\'menos\',1,2, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/negativo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
											</div>
										</label>
									</div>
								</div>
							</div>																
						</td>
					</tr>
					<tr>
						<td>
							<div class="container">
								<div class="row">																
									<div class="form-group" align="center" style="border: 0x solid red;">
										<label style="margin-left: 10%; position: relative; text-align: center; margin:0; border: 0px solid green; width:50%">
											<label for="happy_1" class="col-sm-4 col-md-4 control-label text-right" style="font-size: 17pt;">Descuidado</label>
											<div class="col-sm-7 col-md-7">
												<label id="label_mas_3_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="3" type="radio" name="mas_1" id="mas_1" onclick="validar_ejemplo_iol(\'iol_alt\',\'mas\',1,3, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/positivo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
												<label id="label_menos_3_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="3" type="radio" name="menos_1" id="menos_1" onclick="validar_ejemplo_iol(\'iol_alt\',\'menos\',1,3, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/negativo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
											</div>
										</label>
									</div>
								</div>
							</div>																
						</td>
					</tr>
					<tr>
						<td>
							<div class="container">
								<div class="row">																
									<div class="form-group" align="center" style="border: 0x solid red;">
										<label style="margin-left: 10%; position: relative; text-align: center; margin:0; border: 0px solid green; width:50%">
											<label for="happy_1" class="col-sm-4 col-md-4 control-label text-right" style="font-size: 17pt;">Confiado</label>
											<div class="col-sm-7 col-md-7">
												<label id="label_mas_4_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="4" type="radio" name="mas_1" id="mas_1" onclick="validar_ejemplo_iol(\'iol_alt\',\'mas\',1,4, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/positivo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
												<label id="label_menos_4_1" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
													<input value="4" type="radio" name="menos_1" id="menos_1" onclick="validar_ejemplo_iol(\'iol_alt\',\'menos\',1,4, this)" />&nbsp;&nbsp;&nbsp;<img height="15" width="15" src="../imagenes/negativo.gif" border=0 />
													&nbsp;&nbsp;&nbsp;
												</label>
											</div>
										</label>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
				<div id="texto_ejemplo" style="border: 2px solid red; color: red;display:none; width: 70%; float: left; margin: 10px; padding:10px;"></div>
			';
		}

		//$resultado .= "</div>";
		
		echo $resultado;
	}
	
	public static function buscar_indice($arreglo, $valor) {
		foreach ($arreglo as $key=>$value)
			if ($value==$valor)
				return $key;
	}
	
	public static function buscar_valores($tabla, $id, $tipo_campo, $valor, $activa) {
		$sql = "select * from ".$tabla." where id=".$id;
		
		if ($activa==1)
			$sql.=" and activa=".$activa;
		
		$data=DB::select($sql);
		$res="";
		
		if (strpos($tipo_campo,"MULTIPLE") === false)
			$res="<option value=0>.....</option>";
		
		foreach ($data as $data) {
			$valores=explode(",",$data->valores);
			$i=0;
			foreach ($valores as $key=>$value) {
				if (strpos($tipo_campo,"MULTIPLE") !== false) {
					$valor_multiple=explode(".",$value);
					//print_r($valor_multiple);
					foreach ($valor_multiple as $k=>$v) {
						//echo "value=$value...v=$v<br>";
						if ($value==$v)
							$checked[$i]="checked";
						else
							$checked[$i]="";
					}
					$res.="<div align='left'><input ".$checked[$i]." type='checkbox'id='valores_chk_".$id."_".$i."' name='valores_chk_".$id."_".$i."' value='".$value."'>&nbsp;&nbsp;&nbsp;".strtoupper($value)."</div>";
					$i++;
				} else {
					if ($valor==$value)
						$res.="<option value='".$value."' selected>".strtoupper($value)."</option>";
					else
						$res.="<option value='".$value."'>".strtoupper($value)."</option>";
				}
			}
		}
		
		if (strpos($tipo_campo,"COMENTARIO") !== false)
			if ($valor=="OTRO" && $valor!="")
				$res.="<option value='OTRO' selected>OTRO</option>";
			else
				$res.="<option value='OTRO'>OTRO</option>";
		
		echo $res;
	}
	
}