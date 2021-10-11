<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Mail;
use URL;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\SessionusuarioControllers;
use App\usuarios;
use App\candidato;
use App\autorizaciones;
use App\pruebas_asignadas;
use App\correo_autorizacion;
use App\otros_correos;
use App\tipos_pruebas;
use App\Http\Controllers\FuncionesControllers;

class PruebasControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('usuarios.consulta', ["mensaje" => ""]);
    }

    public function invitar() {
        return view('pruebas.invitar',["mensaje"=>""]);
    }  
	
    public function invitar_consultar() {
        return view('pruebas.invitar_consultar',["mensaje"=>""]);
    }
	
	public function consultar_invitacion2(Request $request) {		
		$fecha_reporte1=$request->fecha_reporte1;
		$fecha_reporte2=$request->fecha_reporte2;
		
		return view('pruebas.invitar_consultar',["fecha_reporte1"=>$fecha_reporte1, "fecha_reporte2"=>$fecha_reporte2, "cedula"=>$request->cedula, "mensaje"=>""]);	
	}	

	public function consultar_evaluadores2(Request $request) {
		$fecha_reporte1=$request->fecha_reporte1;
		$fecha_reporte2=$request->fecha_reporte2;
		
		return view('pruebas.consultar_evaluadores',["mensaje"=>"", "fecha_reporte1"=>$fecha_reporte1, "fecha_reporte2"=>$fecha_reporte2, "cedula"=>$request->cedula]);	
	}	
	
    public function eliminar_evaluacion(Request $request) {
		$data=$request->all();
		foreach ($data as $key=>$value) {
			if (strpos($key,"chk_") !== false) {
				$id_autorizacion=$value;
				$sql = "delete from autorizaciones where id=".$id_autorizacion;
				DB::delete($sql);
			}
		}

		return view('pruebas.invitar_consultar',["mensaje"=>"Invitaciones Eliminadas satisfactoriamente"]);
    }	
	
	public function consultar_asignacion2(Request $request) {
		$fecha_reporte1=$request->fecha_reporte1;
		$fecha_reporte2=$request->fecha_reporte2;
		
		return view('pruebas.consultar_asignacion',["fecha_reporte1"=>$fecha_reporte1, "fecha_reporte2"=>$fecha_reporte2, "cedula"=>$request->cedula, "mensaje"=>""]);	
	}
	
	public function guardar_prueba (Request $request) {
		$datos=$request->all();
		//dd($datos);	
		
		$tipos_pruebas = new tipos_pruebas($datos);
		$tipos_pruebas->save();
		return view('pruebas.consulta',["mensaje"=>"Tipo de Prueba creada satisfactoriamente"]);
	}
	
    public function guardar_prueba_edicion (Request $request) {
		//dd($request->all());
        $id=$request->id;
        $tipos_pruebas=tipos_pruebas::findOrFail($id);
        $tipos_pruebas->fill($request->all());		
        $tipos_pruebas->save();
        return view('pruebas.consulta',["mensaje"=>"Tipo de Prueba modificada satisfactoriamente"]);
    }

	public function consultarprueba	 ($id) {
		$tipos_pruebas=tipos_pruebas::findOrFail($id);
		return view::make('pruebas.edit', compact('tipos_pruebas'));
	}
	
	public function recordar(Request $request) {
		$datos=$request->all();
		//dd($datos);
		foreach ($datos as $key=>$value) {
			if (strpos($key,"tipo_prueba_") !== false) {
				$id_tipo_prueba=$value;
				
				$sql = "select a.*, c.email, tp.nombre as tipo_prueba, tp.id as id_tipo_prueba, 
							c.nombres, c.apellidos, u.email as email_invitador, u.nombres as nombre_invitador
						from autorizaciones a, tipos_pruebas tp, candidatos c, usuarios u
						where tp.id=$id_tipo_prueba and a.id_tipo_prueba=tp.id and 
							a.presento=0 and c.id=a.id_usuario and u.id=a.id_invitador group by email_invitador";
				//echo $sql; return;
				$data=DB::select($sql);
				$i=0;
				if ($id_tipo_prueba==2) {
					foreach ($data as $data) {
						if ($i==0) {
							$texto_email="<br />Las pruebas a aplicar seran:<br /><br />";
							$texto_email.="<ul>";
							$tipo_prueba=$data->tipo_prueba;
							$email=$data->email_invitador;
							$nombres=$data->nombre_invitador;
						} else {
							$link = "http://".$_SERVER["HTTP_HOST"]."/potencial/public/prueba_potencial/".$data->id;
							$texto_email.="<li>Evaluado: ".strtoupper($data->nombre_evaluado).". Link: <a href='".$link."'>".$link."</a></li>";
						}
						$i++;
					} 
				} else {
					foreach ($data as $data) {
						$email=$data->email;
						$id_autorizacion=$data->id;
						$nombres=$data->nombres." ".$data->apellidos;
						$tipo_prueba=$data->tipo_prueba;
					}
					$sql = "select * 
								from correo c, correo_autorizacion ca 
								where c.id=ca.id_correo and ca.tipo=c.tipo and 
									ca.id_autorizacion=".$data->id;
					$data_correo=DB::select($sql);
					foreach ($data_correo as $data_correo) {
						$texto_email=$data_correo->texto;
						$asunto_correo=$data_correo->asunto;
					}					
					if ($id_tipo_prueba==1)
						$link = "<a target='_blank' href='http://".$_SERVER["HTTP_HOST"]."/encuestas/public/aplicar_encuesta/".$id_autorizacion."'>talentskey.net</a>";
					else
						$link = "<a target='_blank' href='http://".$_SERVER["HTTP_HOST"]."/encuestas/public/prueba_hl/".$id_autorizacion."'>talentskey.net</a>";
					
					$texto_email=str_replace("LINKDEINVITACION",$link,$texto_email);					
				}
				if ($id_tipo_prueba==2)
					$texto_email.="</ul>";
				
				/************************* EMAIL A ENVIAR ***************************/
				  Mail::send('correo.invitacion', ["email"=>$email, "nombres"=>$nombres, "texto_email"=>$texto_email], function($message) use($email, $tipo_prueba, $nombres)
					{
						$message->to($email, $nombres)->subject('Recordatorio - Invitacion a prueba '.$tipo_prueba);
						$message->to("jeleicy@gmail.com", $nombres)->subject('Recordatorio - Invitacion a prueba '.$tipo_prueba);
						$message->to("feedback@talentskey.com", $nombres)->subject('Recordatorio - Invitacion a prueba '.$tipo_prueba);
				  });
				/************************* EMAIL A ENVIAR ***************************/				
			}
		}		
		
		return view('pruebas.consultar_evaluadores', ["mensaje"=>"Recordatorios enviados satisfactoriamente"]);	
	}
	
	public function guardar_asignacion (Request $request) {
		$datos=$request->all();
		//dd($datos);
		
		$cantidad=$datos["cantidad"];
		$cantidad_pruebas_disponibles=$datos["cantidad_pruebas"];
		
		$today = @getdate();
		
		$dia = $today["mday"];
		$mes = $today["mon"];
		$ano = $today["year"];
		$fecha_act = $ano."-".$mes."-".$dia;		
		
		if ($cantidad>$cantidad_pruebas_disponibles && Session::get("rol")!="A") {
			$mensaje="No puede asignar un numero de pruebas mayor al disponible";
			$tipo_mensaje="danger";
		} else {
			$pruebas_asignadas = new pruebas_asignadas($datos);

			$pruebas_asignadas->id_usuario_asignador=Session::get("id_usuario");
			if (Session::get("rol")=="A") {
				$pruebas_asignadas->id_usuario_asignado=0;
				$pruebas_asignadas->id_empresa=$datos["id_empresas"];
			} else {
				$pruebas_asignadas->id_usuario_asignado=$datos["id_usuario_asignado"];			
				$pruebas_asignadas->id_empresa=Session::get("id_empresa");
			}
			
			$pruebas_asignadas->nro_asignadas=$datos["cantidad"];
			$pruebas_asignadas->nro_presentadas=0;
			$pruebas_asignadas->fecha_actualizacion=$fecha_act;
			$pruebas_asignadas->fecha_ingreso=$fecha_act;
			
			$pruebas_asignadas->save();
			
			$mensaje="Pruebas asignadas satisfactoriamente";
			$tipo_mensaje="info";
			
			/*
			$sql = "update pruebas_asignadas 
						set id_pruebas_asignadas=".$pruebas_asignadas->id." 
						where id=".$pruebas_asignadas->id;
			DB::update($sql);
			*/
		}
		return view('pruebas.crear_asignacion',["mensaje"=>$mensaje, "tipo"=>$tipo_mensaje]);
	}

    public function guardar_invitacion (Request $request) {
		$datos=$request->all();
		//var_dump($datos);
		//return;
		
		//echo Session::get("id_empresa"); return;
		
		$empresa=FuncionesControllers::buscar_empresa(Session::get("id_empresa"));

		$nombre_prueba=$request->nombre_prueba;
		$today = @getdate();
		
		$nombre_prueba=strtoupper($nombre_prueba);	
		$resultado=1;
		if ($nombre_prueba=="TCGO")
			$resultado=self::guardar_seuc($request->nombres_1,$request->apellidos_1,$request->email_1,$empresa);
		
		if ($resultado==1) {
			$dia = $today["mday"];
			$mes = $today["mon"];
			$ano = $today["year"];
			$fecha_act = $ano."-".$mes."-".$dia;
			
			$id_tipo_prueba=$request->id_tipo_prueba;
			
			$array_tipos_pruebas=array();
			$sql = "select * from bateria order by 2";
			//echo $sql;
			$data=DB::select($sql);
			foreach ($data as $data) {
				if (strpos($data->nombre," "))
					$array_tipos_pruebas[$data->id]=substr($data->nombre,0,strpos($data->nombre," "));
				else
					$array_tipos_pruebas[$data->id]=$data->nombre;
				//echo $data->nombre."...".strpos($data->nombre," ")."<br>";
			}
				
			//print_r ($array_tipos_pruebas); return;
			
			$sql = "select * from bateria where id=".$id_tipo_prueba;
			//echo $sql; return;
			$data=DB::select($sql);
			foreach ($data as $data)
				$tipo_prueba=$data->nombre;		
			
			if ($request->id_tipo_prueba!=2) {
				$candidato = new candidato();

				Session::put("mensaje","");

				$sql = "select * from candidatos where email='".$request->email_1."'";
				//echo $sql;
				//$data=DB::select($sql);
				//if (empty($data)) {
					$candidato->nombres=$request->nombres_1;
					$candidato->apellidos=$request->apellidos_1;
					$candidato->email=$request->email_1;
					$candidato->recibe=$request->recibe;
					$candidato->save();
					
					$id_candidato=$candidato->id;
				/*} else {
					foreach ($data as $data)
						$id_candidato=$data->id;
				}*/
				
				$autorizaciones = new autorizaciones();
				$autorizaciones->id_empresas=Session::get("id_empresa");
				$autorizaciones->id_usuario=$id_candidato;
				$autorizaciones->id_invitador=Session::get("id_usuario");
				$autorizaciones->id_tipo_prueba=$request->id_tipo_prueba;
				$autorizaciones->nombre_evaluado=$request->nombres_1." ".$request->apellidos_1;
				$autorizaciones->correo_evaluado=$request->email_1;
				$autorizaciones->id_grupo_candidatos=$request->id_grupo_candidatos;
				$autorizaciones->fecha=$fecha_act;
				$autorizaciones->presento=0;
				
				if (!isset($request->id_idioma))
					$idioma=1;
				else
					$idioma=$request->id_idioma;
				
				$autorizaciones->id_idioma=$idioma;
				$autorizaciones->save();
				
				if ($request->otros_correos!="") {
					$otros_correos=new otros_correos($request->all());
					$otros_correos->id_autorizacion=$autorizaciones->id;;
					$otros_correos->correos=$request->otros_correos;
					$otros_correos->save();
				}					
					
				//'id_autorizacion','id_correo','tipo'
				$correo_autorizacion = new correo_autorizacion();
				$correo_autorizacion->id_autorizacion=$autorizaciones->id;
				$correo_autorizacion->id_correo=$request->correo_invitacion;
				$correo_autorizacion->tipo="E";
				$correo_autorizacion->save();	

				$correo_autorizacion = new correo_autorizacion();
				$correo_autorizacion->id_autorizacion=$autorizaciones->id;
				$correo_autorizacion->id_correo=$request->correo_presentacion;
				$correo_autorizacion->tipo="R";
				$correo_autorizacion->save();				
				
				$sql = "update candidatos set id_autorizacion=".$autorizaciones->id." where id=".$id_candidato;
				DB::update($sql);
				
				FuncionesControllers::actualizar_pruebas_asignadas($request->id_tipo_prueba,'invitacion', 0);
				
				$email=$request->email_1;
				$nombres=$request->nombres_1." ".$request->apellidos_1;
				
				$sql = "select * from correo c, correo_autorizacion ca 
							where c.id=ca.id_correo and ca.tipo=c.tipo and 
								c. id=".$request->correo_invitacion." and 
								ca.id_autorizacion=".$autorizaciones->id." and c.id_idioma=".$request->id_idioma;
				$data_correo=DB::select($sql);
				$texto_correo="";
				$asunto_correo="";
				foreach ($data_correo as $data_correo) {
					$texto_correo=$data_correo->texto;
					$asunto_correo=$data_correo->asunto;
				}
				
				$sql = "select tipo from idioma where id=".$request->id_idioma;
				//echo $sql;
				$data_idioma=DB::select($sql);
				foreach ($data_idioma as $data_idioma)
					\App::setLocale($data_idioma->tipo);
					
				$prueba=strtolower($array_tipos_pruebas[$request->id_tipo_prueba]);
				
				//echo "prueba=".$prueba;

				if (strpos($prueba,"hi") === false)
					$adic="-1";
				else
					$adic="";
					
				if ($id_tipo_prueba==1)
					$link = "<a target='_blank' href='http://".$_SERVER["HTTP_HOST"]."/encuestas/public/aplicar_encuesta/".$autorizaciones->id."'>Perfil de Competencia</a>";
				else
					$link = "<a target='_blank' href='http://".$_SERVER["HTTP_HOST"]."/encuestas/public/prueba_".$prueba."/".$autorizaciones->id.$adic."-".$id_tipo_prueba."'>Perfil de Competencia</a>";
				
				$texto_correo=str_replace("LINKDEINVITACION",$link,$texto_correo);
				
				$sql = "select * from otros_correos where id_autorizacion=".$autorizaciones->id;
				$data=DB::select($sql);
				foreach ($data as $data) {
					$correos=$data->correos;
					$cada_correo=explode(",",$correos);
					foreach ($cada_correo as $key=>$value) {
						/************************* EMAIL A ENVIAR ***************************/
						Mail::send('correo.invitacion_iol', ["email"=>$email, "nombres"=>$nombres, "texto_email"=>$texto_correo], function($message) use($datos, $email, $tipo_prueba, $nombres, $asunto_correo, $value)
							{
								$message->to($value, $nombres)->subject($asunto_correo);
							});
						/************************* EMAIL A ENVIAR ***************************/
					}
				}
								
				/************************* EMAIL A ENVIAR ***************************/
				//echo "envio de correo...".$email;
				// Mail::send('correo.invitacion_iol', ["email"=>$email, "nombres"=>$nombres, "texto_email"=>$texto_correo], function($message) use($datos, $email, $tipo_prueba, $nombres, $asunto_correo)
				// 	{
				// 		$message->to($email, $nombres)->subject($asunto_correo);
				// 		$message->to("jeleicy@gmail.com", $nombres)->subject($asunto_correo);
				// 		$message->to("feedback@talentskey.com", $nombres)->subject($asunto_correo);
				// 		$message->to("julio@red-talento", $nombres)->subject($asunto_correo);
				// 	});
				/************************* EMAIL A ENVIAR ***************************/				
			} elseif ($request->id_tipo_prueba==2) {
				$usuario = new usuarios($request->all());

				Session::put("mensaje","");
				
				$id_usuario=$request->id_usuario;
				$email=$request->email_2;

				$fileName = "";
				//if ($id_usuario=="")
					$sql = "select * from usuarios where email='".$request->email_2."'";
				//else
				//	$sql = "select * from usuarios where id=".$id_usuario;
				$data=DB::select($sql);
				if (empty($data)) {
					// 'nombres','id_empresas','email','rol','password'
					$usuario->nombres=$request->nombres_2;
					$usuario->email=$request->email_2;
					$usuario->id_empresas=Session::get("id_empresa");
					$usuario->rol="C";
					$clave=FuncionesControllers::generarClave();
					$usuario->password=hash('ripemd160', $clave);			
					$usuario->save();
					
					$id_usuario=$usuario->id;
				} else {
					foreach ($data as $data)
						$id_usuario=$data->id;
					$sql = "select email from usuarios where id=".$id_usuario;
					$data=DB::select($sql);
					foreach ($data as $data)
						$email=$data->email;
				}
				
				//'id_empresas','id_usuario','tipo_prueba','nombre_evaluado','correo_evaluado','fecha','presento'			
				$texto_email="<br />Las pruebas a aplicar seran:<br /><br />";
				$texto_email.="<ul>";
				foreach ($datos as $key=>$value) {
					if (strpos($key,"nombre_2_") !== false)
						$nombre=$value;
					elseif (strpos($key,"email_2_") !== false) {
						$autorizaciones = new autorizaciones();
						$autorizaciones->id_empresas=Session::get("id_empresa");
						$autorizaciones->id_usuario=$id_usuario;
						$autorizaciones->id_invitador=Session::get("id_usuario");
						$autorizaciones->id_tipo_prueba=$request->id_tipo_prueba;
						$autorizaciones->nombre_evaluado=$nombre;
						$autorizaciones->correo_evaluado=$value;
						$autorizaciones->fecha=$fecha_act;
						$autorizaciones->presento=0;
						$autorizaciones->save();
						
						//'id_autorizacion','id_correo','tipo'
						$correo_autorizacion = new correo_autorizacion();
						$correo_autorizacion->id_autorizacion=$autorizaciones->id;
						$correo_autorizacion->id_correo=$request->correo_invitacion;
						$correo_autorizacion->tipo="E";
						$correo_autorizacion->save();	

						$correo_autorizacion = new correo_autorizacion();
						$correo_autorizacion->id_autorizacion=$autorizaciones->id;
						$correo_autorizacion->id_correo=$request->correo_presentacion;
						$correo_autorizacion->tipo="R";
						$correo_autorizacion->save();					
						
						$link = "http://".$_SERVER["HTTP_HOST"]."/encuestas/public/aplicar_encuesta/".$autorizaciones->id;
						
						$texto_email.="<li>Evaluado: ".strtoupper($nombre).". Link: <a href='".$link."'>Perfil de Competencia</a></li>";
					}
				}
				$texto_email.="</ul>";
				
				$datos=$request->all();
				
				FuncionesControllers::actualizar_pruebas_asignadas($request->id_tipo_prueba,'invitacion', 0);
				
				$nombres=$request->nombres_2;
				$email=$request->email_2;
				$tipo_prueba=$request->tipo_prueba;
				
				//echo $texto_email;
				
				/************************* EMAIL A ENVIAR ***************************/
				// Mail::send('correo.invitacion', ["email"=>$email, "nombres"=>$nombres, "texto_email"=>$texto_email], function($message) use($datos, $email, $tipo_prueba, $nombres)
				// 	{
				// 		$message->to($email, $nombres)->subject('Invitacion a prueba '.$tipo_prueba);
				// 		$message->to("jeleicy@gmail.com", $nombres)->subject('Invitacion a prueba '.$tipo_prueba);
				// 		$message->to("feedback@talentskey.com", $nombres)->subject('Invitacion a prueba '.$tipo_prueba);
				// 	});
				/************************* EMAIL A ENVIAR ***************************/				
			}
			//echo "link=".$link;	
			return view('pruebas.enviar_prueba', ["nombres"=>$request->nombres, "apellidos"=>$request->apellidos, "usuario"=>$request->email_1, "mensaje" => "La invitacion a la prueba ".$array_tipos_pruebas[$request->id_tipo_prueba]." para ".$request->nombres." enviada satisfactoriamente."]);
		} else {
			$mensaje = "El email se encuentra duplicado. Haga su invitacion nuevamente";
			return view('pruebas.invitar',["mensaje"=>$mensaje]);
		}		
    }
	
	public function guardar_seuc($nombre,$apellido,$email,$empresa) {
		//echo "1111111111111";		
		$sql="select max(id_evaluado) as maximo from tb_evaluados";
		$data=DB::select ($sql);
		$maximo=0;
		foreach ($data as $data)
			$maximo=$data->maximo;
			
		$maximo++;
		
		$sql="select * from tb_evaluados where email_evaluado='$email'";
		$data=DB::select ($sql);
		if (!empty($data))
			$resultado=0;
		else {
			$reg_eval = "INSERT INTO tb_evaluados (id_evaluado,nombres_evaluado, apellidos_evaluado, 
							email_evaluado, telf_fijo_evaluado, telf_cel_evaluado, direccion_evaluado, 
							seccion_evaluado, id_tutor, nombre_com_cliente, status_evaluado) 
						VALUES ($maximo, '$nombre', '$apellido', '$email', 
							'', '', '', 'Cohorte I', 
							'10339892', 'Cliente Tester', 'Activo')";
			
			DB::insert($reg_eval);
			
			$cod_invitacion = uniqid();		
			$sql_invitacion = "INSERT INTO tb_evaluaciones (cod_evaluacion, id_evaluado, nombres_evaluado, 
								apellidos_evaluado, email_evaluado, seccion_evaluado, codigo_prueba, 
								status_evaluacion, fecha_evaluacion, vigencia_evaluacion, hora_ini_evaluacion, 
								hora_fin_evaluacion, ingresos_evaluacion, baremo_prueba, id_tutor, 
								nombres_tutor, apellidos_tutor, email_tutor, nombre_com_cliente, email_contacto_cliente) 
							VALUES('$cod_invitacion', '0', '$nombre', '$apellido', '$email', 
								'Cohorte I', '1003', 'En_Curso', '0000-00-00', '', 
								'00:00:00', '00:00:00', '0', 
								'C1', '10339892', 'Johann', 'Espejo Leon', 'jespejo@cantv.net', 'Cliente Tester', 
								'julio@red-talento.com')";
			DB::insert($sql_invitacion);
			//echo "<br>1)listo...";
			$resultado=1;
		}
		return $resultado;
	}
		
}