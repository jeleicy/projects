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
use App\Http\Controllers\FuncionesControllers;

use Mail;

use App\candidato;
use App\coach;
use App\respuestas_iol;
use App\resultados_iol;
use App\autorizaciones_iol_alt;

use App\respuestas_potencial;
use App\resultados_potencial;

use PDF;

class BateriasPruebasControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /periodicos
     *
     * @return Response
     */
    public function index($id)
    {       
		//dd($id);
		$today = @getdate();
		
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];
        $fecha_act = $dia."/".$mes."/".$ano;
				
		if ($id=="general")
			$itp=0;
		else
			$itp=$id;
	
		$fecha_reporte1=$fecha_act;
		$fecha_reporte2=$fecha_act;	
		
		if ($itp==0)
			return view('encuesta.encuesta_reporte_general',["id_tipo_prueba"=>$itp,"cedula"=>0,'fecha_reporte1'=>$fecha_reporte1,'fecha_reporte2'=>$fecha_reporte2,'id_grupo_candidatos'=>0]);
		else
			return view('encuesta.encuesta_reporte',["id_tipo_prueba"=>$itp,"cedula"=>0,'fecha_reporte1'=>$fecha_reporte1,'fecha_reporte2'=>$fecha_reporte2,'id_grupo_candidatos'=>0]);
    }
	
	public function consultar_encuesta_general(Request $request) {
		//dd($request->all());
		//16/7/2016 - 16/7/2016
		$fecha_reporte1=$request->fecha_reporte1;
		$fecha_reporte2=$request->fecha_reporte2;
		$id_tipo_prueba=$request->id_tipo_prueba;
		$id_grupo=$request->id_tipo_prueba;
				
		return view('encuesta.encuesta_reporte_general',["fecha_reporte1"=>$fecha_reporte1, "fecha_reporte2"=>$fecha_reporte2, "cedula"=>$request->cedula,"id_tipo_prueba"=>0,'id_grupo_candidatos'=>0]);
	}	
	
	public function consultar_encuesta(Request $request) {
		//dd($request->all());
		//16/7/2016 - 16/7/2016
		$fecha_reporte1=$request->fecha_reporte1;
		$fecha_reporte2=$request->fecha_reporte2;
		$id_grupo_candidatos=$request->id_grupo_candidatos;
		$id_tipo_prueba=$request->id_tipo_prueba;
				
		return view('encuesta.encuesta_reporte',["fecha_reporte1"=>$fecha_reporte1, "fecha_reporte2"=>$fecha_reporte2, "cedula"=>$request->cedula,"id_tipo_prueba"=>$id_tipo_prueba, "id_grupo_candidatos"=>$id_grupo_candidatos]);
	}
	
	public function guardar_encuesta_iol_alt(Request $request) {
        $today = @getdate();
		$entro=0;
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];
        $fecha_act = $ano."-".$mes."-".$dia;	
		
		$sql = "select * from autorizaciones_iol_alt where id=".$request->id;
		$data=DB::select($sql);
		foreach ($data as $data) {
			$id_tipo_prueba=$data->id_tipo_prueba;
			$id_candidato=$data->id_candidato;
		}
			
		$sql = "select distinct(c.id) as id, c.email, c.recibe, a.id_invitador, c.nombres, c.apellidos
					from candidatos c, autorizaciones_iol_alt a
					where c.id=".$id_candidato." and c.id=a.id_candidato";
		
		$data=DB::select($sql);
		foreach ($data as $data) {
			$id=$data->id;
			$email=$data->email;
			$recibe=$data->recibe;
			$id_invitador=$data->id_invitador;
			$candidato=$data->nombres." ".$data->apellidos;
		}
		
		$sql = "select rol from usuarios where id=".$id_invitador;
		$data=DB::select($sql);
		foreach ($data as $data)
			$rol=$data->rol;
		
		$id_au=$request->id;
		
		$sql = "select id_empresas from autorizaciones where id=".$id_au;
		$data=DB::select($sql);
		foreach ($data as $data)
			$id_empresas=$data->id_empresas;		

		$sql = "update autorizaciones_iol_alt set presento=1 where id=".$request->id;
		DB::update($sql);
	
		 /*GUARDANDO RESPUESTA*/
		//'id_candidato','id_opcion','respuesta','fecha_creacion','fecha_actualizacion'
		$datos=$request->all();
		
		foreach ($datos as $key=>$value) {
			if (strpos($key,"mas_") !== false)
				$resp=1;

			if (strpos($key,"menos_") !== false)
				$resp=0;
			
			if (strpos($key,"mas_") !== false || strpos($key,"menos_") !== false ) {
				$respuestas = new respuestas_iol();
				//id_candidato,nro_prueba,id_opcion,respuesta	
				$respuestas->id_candidato=$id_candidato;
				$respuestas->id_opcion=$value;
				$respuestas->nro_prueba=2;
				$respuestas->respuesta=$resp;
				$respuestas->fecha_creacion=$fecha_act;
				$respuestas->fecha_actualizacion=$fecha_act;
				$respuestas->save();
			}
		}
		
		$resultado=FuncionesControllers::consulta_resultado($id_candidato, $fecha_act, $fecha_act,2);

		$perfil=FuncionesControllers::buscar_perfil($resultado["D"]["Cotidiana"].",".$resultado["I"]["Cotidiana"].",".$resultado["S"]["Cotidiana"].",".$resultado["C"]["Cotidiana"]);
		
		$mas_D=$resultado["mas"]["D"];
		$mas_I=$resultado["mas"]["I"];
		$mas_S=$resultado["mas"]["S"];
		$mas_C=$resultado["mas"]["C"];
		$menos_D=$resultado["menos"]["D"];
		$menos_I=$resultado["menos"]["I"];
		$menos_S=$resultado["menos"]["S"];
		$menos_C=$resultado["menos"]["C"];
		
		$res_D=($mas_D-$menos_D);
		$res_I=($mas_I-$menos_I);
		$res_S=($mas_S-$menos_S);
		$res_C=($mas_C-$menos_C);
		
		if ($request->coach==1) {
			$coach = new coach();
			//'id_autorizaciones','escuela_formo','tiempo_formo','ano_certificacion'
			$coach->id_autorizaciones=$request->id;
			$coach->escuela_formo=$request->escuela_formo;
			$coach->tiempo_formo=$request->tiempo_formo;
			$coach->ano_certificacion=$request->ano_certificacion;
			$coach->save();
		}
		
		//'id_candidato','mas','menos','resta','perfil','pentil_Deseada','pentil_Bajo_Presion','pentil_Cotidiana'
		
		/*GUARDANDO RESULTADOS*/
		
		$resultados = new resultados_iol();
		$resultados->id_candidato=$id_candidato;
		$resultados->mas=$mas_D.",".$mas_I.",".$mas_S.",".$mas_C;
		$resultados->menos=$menos_D.",".$menos_I.",".$menos_S.",".$menos_C;
		$resultados->resta=$res_D.",".$res_I.",".$res_S.",".$res_C;
		$resultados->perfil=$perfil;
		$resultados->nro_prueba=2;
		$resultados->pentil_Deseada=$resultado["D"]["Deseada"].",".$resultado["I"]["Deseada"].",".$resultado["S"]["Deseada"].",".$resultado["C"]["Deseada"];
		$resultados->pentil_Bajo_Presion=$resultado["D"]["Bajo Presion"].",".$resultado["I"]["Bajo Presion"].",".$resultado["S"]["Bajo Presion"].",".$resultado["C"]["Bajo Presion"];
		$resultados->pentil_Cotidiana=$resultado["D"]["Cotidiana"].",".$resultado["I"]["Cotidiana"].",".$resultado["S"]["Cotidiana"].",".$resultado["C"]["Cotidiana"];
		$resultados->save();
		//return Redirect::route('encuesta_respuesta');
			
		$this->generar_pdf($id_candidato.",".$fecha_act.",2");
		
			$idioma=\App::getLocale();
			$sql = "select id from idioma where tipo='".$idioma."'";
			$data=DB::select($sql);
			foreach ($data as $data)
				$id_idioma=$data->id;
			
			$sql = "select c.* from correo c, correo_autorizacion ca 
						where c.id=ca.id_correo and ca.tipo=c.tipo and							
							ca.id_autorizacion=".$id_au." and c.id_idioma=".$id_idioma;
			$data_correo=DB::select($sql);
			$texto_correo="";
			$asunto_correo="";
			foreach ($data_correo as $data_correo) {
				$texto_correo=$data_correo->texto;
				$asunto_correo=$data_correo->asunto;
			}
		
		
		/************************* EMAIL A ENVIAR ***************************/
		if ($entro==0) {
			  Mail::send('correo.encuesta_respuesta', ["candidato"=>$candidato,"perfil"=>$perfil,"texto_correo"=>$texto_correo], function($message) use($email, $candidato, $id_candidato, $recibe,$asunto_correo)
				{
					if ($recibe==1) {
						$message->to($email, $candidato)->subject($asunto_correo)
								->attach('pdf/'.$id_candidato.'.pdf');
					}
					$message->bcc("jeleicy@gmail.com", $candidato)->subject($asunto_correo)
							->attach('pdf/'.$id_candidato.'.pdf');					
			  });
			  $entro=1;
		}
		/************************* EMAIL A ENVIAR ***************************/	
		
		return view('encuesta.encuesta_respuesta_alt',["id_au"=>$request->id, "candidato"=>$candidato,'perfil'=>$perfil]);	
	}

    public function guardar_encuesta(Request $request) {
		//dd($request->all());
		
        $today = @getdate();
		$entro=0;
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];
        $fecha_act = $ano."-".$mes."-".$dia;
		
		$sql = "select * from autorizaciones where id=".$request->id;
		$data=DB::select($sql);
		foreach ($data as $data)
			$id_tipo_prueba=$data->id_tipo_prueba;
		
		if ($id_tipo_prueba==1) {
			 /*GUARDANDO CANDIDATO*/
			//'nombres','apellidos','nacionalidad','cedula','sexo','email','edad','nivel_formacion','orientacion_area','orientacion_cargo','fecha_creacion','fecha_actualizacion'		 
			
			$sql = "select c.id, c.email, c.recibe, a.id_invitador
						from candidatos c, autorizaciones a
						where c.id_autorizacion=a.id and 
							c.id_autorizacion=".$request->id;
			$data=DB::select($sql);
			//echo $sql."<br>";
			foreach ($data as $data) {
				$id=$data->id;
				$email=$data->email;
				$recibe=$data->recibe;
				$id_invitador=$data->id_invitador;
			}
			
			$sql = "select rol from usuarios where id=".$id_invitador;
			$data=DB::select($sql);
			foreach ($data as $data)
				$rol=$data->rol;
			
			$id_au=$request->id;
			
			$sql = "select id_empresas from autorizaciones where id=".$id_au;
			//echo $sql."<br /><br />";
			$data=DB::select($sql);
			foreach ($data as $data)
				$id_empresas=$data->id_empresas;		

			$sql = "update autorizaciones set presento=1 where id=".$request->id;
			DB::update($sql);
			
			/******************************/
			
			$sql = "update pruebas_asignadas 
				set nro_presentadas=nro_presentadas+1 ";
				
			$sql .= "where (nro_asignadas_no_presentadas+nro_presentadas) < nro_asignadas and ";		
			
			if ($rol=="ERRHH") {
				$sqlBusqueda = "select * from pruebas_asignadas 
					where (nro_asignadas_no_presentadas+nro_presentadas) < nro_asignadas and 
						id_usuario_asignado=".$id_invitador." and id_tipo_prueba=".$id_tipo_prueba;
				$data = DB::select($sqlBusqueda);
				$i=0;
				$id_pruebas_asignadas=0;
				foreach ($data as $data) {
					if ($i==0) {
						$id_pruebas_asignadas=$data->id;
						$i++;
					}
				}	
				$sql .= " id=".$id_pruebas_asignadas;
			} else {
				$sqlBusqueda = "select * from pruebas_asignadas 
					where (nro_asignadas_no_presentadas+nro_presentadas) < nro_asignadas and ";
				$sqlBusqueda.= "id_empresa=".$id_empresas." and id_tipo_prueba=".$id_tipo_prueba;
				//echo $id_empresas."<br /><br />"; 
				//echo $sqlBusqueda; return;
				$data = DB::select($sqlBusqueda);
				$i=0;
				$id_pruebas_asignadas=0;
				foreach ($data as $data) {
					if ($i==0) {
						$id_pruebas_asignadas=$data->id;
						$i++;
					}
				}
				
				if (Session::get("id_empresa"))
					$sql .= "id_empresa=".Session::get("id_empresa");
				else
					$sql.= "id_empresa=".$id_empresas;
				if ($id_pruebas_asignadas>0)
					$sql .= " and id=".$id_pruebas_asignadas;
			}
			//echo $sql;
			//DB::update($sql);
			
			/******************************/

			$candidato=candidato::findOrFail($id);
			$candidato->fill($request->all());
			$candidato->save();
			
			$id_candidato=$id;

			 /*GUARDANDO RESPUESTA*/
			//'id_candidato','id_opcion','respuesta','fecha_creacion','fecha_actualizacion'
			$datos=$request->all();
			
			foreach ($datos as $key=>$value) {
				if (strpos($key,"mas_") !== false)
					$resp=1;

				if (strpos($key,"menos_") !== false)
					$resp=0;
				
				if (strpos($key,"mas_") !== false || strpos($key,"menos_") !== false ) {
					$respuestas = new respuestas_iol();
					//id_candidato,nro_prueba,id_opcion,respuesta	
					$respuestas->id_candidato=$id_candidato;
					$respuestas->id_opcion=$value;
					$respuestas->nro_prueba=1;
					$respuestas->respuesta=$resp;
					$respuestas->fecha_creacion=$fecha_act;
					$respuestas->fecha_actualizacion=$fecha_act;
					$respuestas->save();
				}
			}
			
			if ($request->coach==1) {
				$coach = new coach();
				//'id_autorizaciones','escuela_formo','tiempo_formo','ano_certificacion'
				$coach->id_autorizaciones=$request->id;
				$coach->escuela_formo=$request->escuela_formo;
				$coach->tiempo_formo=$request->tiempo_formo;
				$coach->ano_certificacion=$request->ano_certificacion;
				$coach->save();
			}
			
			//'id_candidato','mas','menos','resta','perfil','pentil_Deseada','pentil_Bajo_Presion','pentil_Cotidiana'
			
			$resultado=FuncionesControllers::consulta_resultado($id_candidato, $fecha_act, $fecha_act,1);
			$perfil=FuncionesControllers::buscar_perfil($resultado["D"]["Cotidiana"].",".$resultado["I"]["Cotidiana"].",".$resultado["S"]["Cotidiana"].",".$resultado["C"]["Cotidiana"]);			
			$mas_D=$resultado["mas"]["D"];
			$mas_I=$resultado["mas"]["I"];
			$mas_S=$resultado["mas"]["S"];
			$mas_C=$resultado["mas"]["C"];
			$menos_D=$resultado["menos"]["D"];
			$menos_I=$resultado["menos"]["I"];
			$menos_S=$resultado["menos"]["S"];
			$menos_C=$resultado["menos"]["C"];
			
			$res_D=($mas_D-$menos_D);
			$res_I=($mas_I-$menos_I);
			$res_S=($mas_S-$menos_S);
			$res_C=($mas_C-$menos_C);				
			
			/*GUARDANDO RESULTADOS*/
			
			$resultados = new resultados_iol();
			$resultados->id_candidato=$id_candidato;
			$resultados->mas=$mas_D.",".$mas_I.",".$mas_S.",".$mas_C;
			$resultados->menos=$menos_D.",".$menos_I.",".$menos_S.",".$menos_C;
			$resultados->resta=$res_D.",".$res_I.",".$res_S.",".$res_C;
			$resultados->perfil=$perfil;
			$resultados->nro_prueba=1;
			$resultados->pentil_Deseada=$resultado["D"]["Deseada"].",".$resultado["I"]["Deseada"].",".$resultado["S"]["Deseada"].",".$resultado["C"]["Deseada"];
			$resultados->pentil_Bajo_Presion=$resultado["D"]["Bajo Presion"].",".$resultado["I"]["Bajo Presion"].",".$resultado["S"]["Bajo Presion"].",".$resultado["C"]["Bajo Presion"];
			$resultados->pentil_Cotidiana=$resultado["D"]["Cotidiana"].",".$resultado["I"]["Cotidiana"].",".$resultado["S"]["Cotidiana"].",".$resultado["C"]["Cotidiana"];
			$resultados->save();
			
			$candidato=strtoupper($request->nombres." ".$request->apellidos);
			
			$this->generar_pdf($id_candidato.",".$fecha_act.",1");
			
			$idioma=\App::getLocale();
			$sql = "select id from idioma where tipo='".$idioma."'";
			$data=DB::select($sql);
			foreach ($data as $data)
				$id_idioma=$data->id;
			
			$sql = "select c.* from correo c, correo_autorizacion ca 
						where c.id=ca.id_correo and ca.tipo=c.tipo and							
							ca.id_autorizacion=".$id_au." and c.id_idioma=".$id_idioma;
			$data_correo=DB::select($sql);
			foreach ($data_correo as $data_correo) {
				$texto_correo=$data_correo->texto;
				$asunto_correo=$data_correo->asunto;
			}			
			
			/************************* EMAIL A ENVIAR ***************************/
			if ($perfil!="Invalido") {
				if ($entro==0) {
					  Mail::send('correo.encuesta_respuesta', ["candidato"=>$candidato,"perfil"=>$perfil, "texto_correo"=>$texto_correo], function($message) use($email, $candidato, $id_candidato, $recibe, $asunto_correo)
						{
							if ($recibe==1) {
								$message->to($email, $candidato)->subject($asunto_correo)
										->attach('pdf/'.$id_candidato.'.pdf');
							}
							$message->bcc("jeleicy@gmail.com", $candidato)->subject($asunto_correo)
									->attach('pdf/'.$id_candidato.'.pdf');							
					  });
					  $entro=1;
				}
			}
			/************************* EMAIL A ENVIAR ***************************/	
			FuncionesControllers::actualizar_pruebas_asignadas($id_tipo_prueba,'encuesta', $request->id);
			
			return view('encuesta.encuesta_respuesta',["id_au"=>$request->id, "candidato"=>strtoupper($request->nombres." ".$request->apellidos),'perfil'=>$perfil]);
		} elseif ($id_tipo_prueba==2) {
			$id=$request->id;
			
			$sql = "select * from autorizaciones where id=".$request->id;
			$data=DB::select($sql);
			foreach ($data as $data)
				$id_tipo_prueba=$data->id_tipo_prueba;			
			
			$sql = "update autorizaciones set presento=1 where id=".$id;
			DB::update($sql);
			
			//$id_candidato=$candidato->id;
			
			 /*GUARDANDO RESPUESTA*/
			//'id_candidato','id_pregunta','respuesta','fecha_creacion','fecha_actualizacion'
			$datos=$request->all();
			
			foreach ($datos as $key=>$value) {
				if (strpos($key,"pregunta_") !== false) {
					$id_pregunta=substr($key,strpos($key,"_")+1);
					$id_pregunta=substr($id_pregunta,strpos($id_pregunta,"_")+1);
				
					$respuestas = new respuestas_potencial();
					
					$respuestas->id_candidato=$id;
					$respuestas->id_preguntas=$id_pregunta;
					$respuestas->respuesta=$value;
					$respuestas->id_autorizacion=$id;
					$respuestas->fecha_creacion=$fecha_act;
					$respuestas->fecha_actualizacion=$fecha_act;
					$respuestas->save();
				}
			}
			$res="";
			foreach ($datos as $key=>$value) {
				if (strpos($key,"f_op_") !== false) {
					$id_opciones=substr($key,strpos($key,"_")+1);
					$id_opciones=substr($id_opciones,strpos($id_opciones,"_")+1);
					
					$resultados = new resultados_potencial();
					$resultados->id_candidato=$id;
					$resultados->id_opciones=$id_opciones;
					$resultados->valor=$value;
					$resultados->id_autorizacion=$id;
					$resultados->save();
					
					$res[]=$resultados->id;
				}
			}
			FuncionesControllers::actualizar_pruebas_asignadas($id_tipo_prueba,'encuesta', $request->id);
        return view('potencial.potencial_respuesta',["candidato"=>strtoupper($request->nombres." ".$request->apellidos),"id_candidato"=>$id,"res"=>$res]);			
		} if ($id_tipo_prueba==4) {
			//dd($request-all());
		}
    }
	
	public function reenviar_pdf($id, Request $request) {
		$id=substr($id,0,strpos($id,","));
		$sql = "select id, email, nombres, apellidos from candidatos where id=".$id;
		$data=DB::select($sql);
		foreach ($data as $data) {
			$email=$data->email;
			$id_candidato=$data->id;
			$candidato=$data->nombres." ".$data->apellidos;
		}
			
		Mail::send('correo.reenvio_pdf', ["candidato"=>$candidato], function($message) use($email, $id_candidato, $candidato)
		{
			$fichero="";
			if (file_exists("pdf/".$id_candidato."_alt.pdf"))
				$fichero="pdf/".$id_candidato."_alt";
			else
				$fichero="pdf/".$id_candidato;
			
			$message->to($email, $candidato)->subject('Reenvio prueba IOL')
					->attach($fichero.'.pdf');
			$message->bcc("jeleicy@gmail.com", $candidato)->subject('Reenvio prueba IOL')
					->attach($fichero.'.pdf');
		});
		return view('encuesta.encuesta_reporte',["id_tipo_prueba"=>1,"cedula"=>0]);
	}
	
	public function generar_pdf($valores) {
		$id_candidato=substr($valores,0,strpos($valores,","));
		$valores=substr($valores,strpos($valores,",")+1);
		$fecha=substr($valores,0,strpos($valores,","));
		$valores=substr($valores,strpos($valores,",")+1);
		$nro_prueba=$valores;
		
		$sql = "select i.tipo from autorizaciones a, idioma i 
				where a.id_idioma=i.id and a.id_usuario=".$id_candidato;
		$data_au=DB::select($sql);
		foreach ($data_au as $data_au)
			$idioma=$data_au->tipo;
		
        $data = $this->getData($id_candidato,$fecha,$nro_prueba);
        $date = date('Y-m-d');
        $invoice = "2222";		
			
		if ($data["perfil"]=="")
			$data["perfil"]="invalido";
		
		$perfil_idioma = array (
			"es" => array (
				'administrativo' =>'administrativo',
				'auditor' =>'auditor',
				'consejero' =>'consejero',
				'cooperativo' =>'cooperativo',
				'coordinador' =>'coordinador',
				'emprendedor' =>'emprendedor',
				'especialista' =>'especialista',
				'experto' =>'experto',
				'implementador' =>'implementador',
				'iniciador' =>'iniciador',
				'intelectual' =>'intelectual',
				'invalido' =>'invalido',
				'organizador' =>'organizador',
				'perfeccionista' =>'perfeccionista',
				'recepcionista' =>'recepcionista',
				'relacionista' =>'relacionista',
				'reporte_hi' =>'reporte_hi',
				'servicial' =>'servicial',
				'supervisor' =>'supervisor'
			),
			"en" => array (
				'administrativo' =>'Administrative',
				'auditor' =>'auditor',
				'consejero' =>'adviser',
				'cooperativo' =>'cooperative',
				'coordinador' =>'coordinator',
				'emprendedor' =>'entrepreneur',
				'especialista' =>'specialist',
				'experto' =>'expert',
				'implementador' =>'implementer',
				'iniciador' =>'initiator',
				'intelectual' =>'intellectual',
				'invalido' =>'invalid',
				'organizador' =>'organizer',
				'perfeccionista' =>'perfectionist',
				'recepcionista' =>'receptionist',
				'relacionista' =>'relational',
				'servicial' =>'helpfull',
				'supervisor' =>'supervisor'
			)
		);	
		
		\App::setLocale($idioma);
		$perfil=$perfil_idioma[$idioma][strtolower($data["perfil"])];
		
        $view =  \View::make('pdf.'.strtolower($data["perfil"]), compact('data', 'date', 'invoice', 'perfil'))->render();
        $pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		$pruebas=array(1=>"", 2=>"_alt");
		$pdf->save("pdf/".$id_candidato.$pruebas[$nro_prueba].".pdf");

        return $pdf->stream($data["perfil"].'.pdf');
	}
	
	public function getData($id_candidato,$fecha,$nro_prueba) {
		$sql = "select c.nombres, c.apellidos, 
				r.mas,r.menos,r.resta,r.perfil,r.pentil_Deseada,r.pentil_Bajo_Presion,r.pentil_Cotidiana
				from resultados_iol r, candidatos c
				where c.id=$id_candidato and r.nro_prueba=$nro_prueba
					and r.id_candidato=c.id";
		//echo $sql; return;
		$data=DB::select($sql);
		foreach ($data as $data) {
			$mas=explode(",",$data->mas);
			$menos=explode(",",$data->menos);
			$resta=explode(",",$data->resta);
			
			$candidato=$data->nombres." ".$data->apellidos;
			$perfil=$data->perfil;
			$pentil_Deseada=explode(",",$data->pentil_Deseada);
			$pentil_Bajo_Presion=explode(",",$data->pentil_Bajo_Presion);
			$pentil_Cotidiana=explode(",",$data->pentil_Cotidiana);

			$masD=$mas[0];
			$masI=$mas[1];
			$masS=$mas[2];
			$masC=$mas[3];
			
			$menosD=$menos[0];
			$menosI=$menos[1];
			$menosS=$menos[2];
			$menosC=$menos[3];
		}
		
        $data =  [
            'candidato'	=> strtoupper($candidato),
            'fecha'   	=> FuncionesControllers::fecha_normal($fecha),
			'mas_D'		=> $masD,
			'mas_I'		=> $masI,
			'mas_S'		=> $masS,
			'mas_C'		=> $masC,
			'menos_D'	=> $menosD,
			'menos_I'	=> $menosI,
			'menos_S'	=> $menosS,
			'menos_C'	=> $menosC,
			'deseada_D' => $pentil_Deseada[0],
			'deseada_I' => $pentil_Deseada[1],
			'deseada_S' => $pentil_Deseada[2],
			'deseada_C' => $pentil_Deseada[3],
			'bajo_presion_D' => $pentil_Bajo_Presion[0],
			'bajo_presion_I' => $pentil_Bajo_Presion[1],
			'bajo_presion_S' => $pentil_Bajo_Presion[2],
			'bajo_presion_C' => $pentil_Bajo_Presion[3],
			'cotidiana_D' => $pentil_Cotidiana[0],
			'cotidiana_I' => $pentil_Cotidiana[1],
			'cotidiana_S' => $pentil_Cotidiana[2],
			'cotidiana_C' => $pentil_Cotidiana[3],
			'perfil'	=> $perfil
        ];
        return $data;
    }
	
	public function generar_pdf_hi_reporte ($id_au) {
		
		self::generar_pdf_hi ($tabla, $id_au);
	}
	
	public static function generar_pdf_hi ($tabla, $id_au) {
		// Generar PDF
        $date = date('Y-m-d');
        $invoice = "2222";
		
		//echo "pdf_pdf=".$tabla;
		
		$sql = "select * from candidatos where id_autorizacion=".$id_au;
		$data=DB::select($sql);
		
		foreach ($data as $data) {
			$id_candidato=$data->id;
			$email=$data->email;
			$candidato=$data->nombres." ".$data->apellidos;
		}
		
		//echo "id=".$id_candidato;
		
		//echo $tabla; return;
		
		$data= ['tabla'=>$tabla];
		//$data=['tabla'=>"123456"];
					
        /*$view =  \View::make('pdf.reporte_hi', compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		$pdf->save("pdf/hi/".$id_candidato.".pdf");*/
		
        $view = \View::make('pdf.reporte_hi', compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		$pdf->save("pdf/hi/".$id_candidato.".pdf");

        return $pdf->stream("pdf/hi/".$id_candidato.".pdf");		
		//return true;
		
		/*Mail::send('correo.encuesta_hi',["candidato"=>$candidato], function($message) use($email, $candidato, $id_candidato)
		{
			$message->to($email, $candidato)->subject('Presentacion prueba HI')
					->attach('pdf/hi/'.$id_candidato.'.pdf');
					
			$message->bcc("jeleicy@gmail.com", $candidato)->subject('Presentacion prueba HI')
					->attach('pdf/hi/'.$id_candidato.'.pdf');							
		});*/

        //return $pdf->stream($id_candidato.".pdf");
	}
	
	public function aplicar_encuesta($id) {
		$sql = "select c.nombres, c.apellidos, c.email, a.id_empresas 
					from candidatos c, autorizaciones a
					where a.id=$id and a.id=c.id_autorizacion";

		$data=DB::select($sql);
		
		$nombre="";
		$apellido="";
		$email="";
		
		foreach ($data as $data) {
			$nombre=$data->nombres;
			$apellido=$data->apellidos;
			$email=$data->email;
			$id_empresa=$data->id_empresas;
		}
		
		$sql = "select a.*, i.tipo from autorizaciones a, idioma i where a.id_idioma=i.id and a.id=$id";
		//echo $sql; return;
		$data=DB::select($sql);
		if (empty($data))
			$prueba="encuesta.ya_presento_encuesta";
		else {
			foreach ($data as $data) {
				if ($data->presento==0) {
					\App::setLocale($data->tipo);
					$id_tipo_prueba=$data->id_tipo_prueba;
					Session::put("id_idioma",$data->id_idioma);
					if ($nombre=="") {
						if (strpos($data->nombre_evaluado," ") !== false) {
							$nombre=substr($data->nombre_evaluado,0,strpos($data->nombre_evaluado," "));
							$apellido=substr($data->nombre_evaluado,strpos($data->nombre_evaluado," ")+1);
						} else 
							$nombre=$data->nombre_evaluado;
						$email=$data->correo_evaluado;						
					}
					$sql = "select * from idioma where id=".Session::get("id_idioma");
					$data=DB::select($sql);
					foreach ($data as $data)
						$idioma=$data->tipo;
					//echo "idioma=".$idioma;
					 ;
					
					$prueba="encuesta.encuesta_".$id_tipo_prueba;				
				} else {
					$prueba="encuesta.ya_presento_encuesta";
				}
			}
		}
		
		return view($prueba,["nombre"=>$nombre, "apellido"=>$apellido, "email"=>$email, "id_au"=>$id, "id_empresa"=>$id_empresa]);
	}
	
	public function aplicar_encuesta_iol_alt($id) {
		$sql = "select c.*, i.tipo 
				from candidatos c, idioma i, autorizaciones a
				where a.id=$id and a.id_idioma=i.id and 
					c.id_autorizacion=a.id";

		$data=DB::select($sql);
		
		$nombre="";
		$apellido="";
		$email="";
		
		foreach ($data as $data) {
			$nombre=$data->nombres;
			$apellido=$data->apellidos;
			$email=$data->email;
			$cedula=$data->cedula;
			$id_candidato=$data->id;
			\App::setLocale($data->tipo);
		}
		
		$sql = "select * from autorizaciones where id=$id";
		$data=DB::select($sql);
		foreach ($data as $data) {
			$autorizaciones_iol_alt = new autorizaciones_iol_alt();
			
			$id_empresa=$data->id_empresas;
			
			$autorizaciones_iol_alt->id_empresas=$data->id_empresas;
			$autorizaciones_iol_alt->id_usuario=$data->id_usuario;
			$autorizaciones_iol_alt->id_invitador=$data->id_invitador;
			$autorizaciones_iol_alt->id_tipo_prueba=$data->id_tipo_prueba;
			$autorizaciones_iol_alt->nombre_evaluado=$data->nombre_evaluado;
			$autorizaciones_iol_alt->correo_evaluado=$data->correo_evaluado;
			$autorizaciones_iol_alt->fecha=$data->fecha;
			$autorizaciones_iol_alt->presento=0;
			$autorizaciones_iol_alt->id_candidato=$id_candidato;
			$autorizaciones_iol_alt->id_idioma=Session::get("id_idioma");
			$autorizaciones_iol_alt->save();
		}
		return view("encuesta.encuesta_iol_alt",["nombre"=>$nombre, "apellido"=>$apellido, "cedula"=>$cedula, "email"=>$email, "id_au"=>$autorizaciones_iol_alt->id,"id_empresa"=>$id_empresa]);
	}
	
	public function prueba_hi_ejemplo($id) {
		//dd($id);
		$dato=$id;
		$id=substr($dato,0,strpos($dato,"-"));
		$id_bateria=substr($dato,strpos($dato,"-")+1);
		
		//echo "id_bateria=$id_bateria";
		
		return view('prueba_hl.preguntas_3_ejemplo',["id_bateria"=>$id_bateria, "mensaje"=>'',"id_au"=>$id,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);		
	}
	
	public function prueba_sl_ejemplo($id) {
		$dato=$id;
		$id=substr($dato,0,strpos($dato,"-"));
		$id_bateria=substr($dato,strpos($dato,"-")+1);
		//echo "id=$id...id_bateria=$id_bateria";
		return view('prueba_sl.preguntas_6_ejemplo',["id_bateria"=>$id_bateria, "mensaje"=>'',"id_au"=>$id,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);		
	}	
	
	public function prueba_sl_resto($id) {
		//encuesta_3_1-702-3
		//dd($id);
		//echo "1111111111111";
		$pagina=substr($id,strpos($id,"_")+1);
		$pagina=substr($pagina,0,strpos($pagina,"-"));
		$id=substr($id,strpos($id,"-")+1);
		$id_au=substr($id,0,strpos($id,"-"));
		$id=substr($id,strpos($id,"-")+1);
		$id_bateria=$id;
		//echo "pagina=$pagina...id_au=$id_au...id_bateria=$id_bateria"; return;
		return view('prueba_sl.preguntas_'.$pagina,["id_bateria"=>$id_bateria, "mensaje"=>'',"id_au"=>$id_au,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);		
	}
	
	public function prueba_epa ($id) {
		//dd($id);
		//701-3
		$dato=$id;
		$id=substr($dato,0,strpos($dato,"-"));
		$id_bateria=substr($dato,strpos($dato,"-")+1);
		//echo "pos=".strpos($dato,"-")."....$id...$id_bateria"; return;
		
		$sql = "select count(id) as cantidad from pruebas_presentadas where id_autorizacion=$id";
		$data=DB::select($sql);
		$cantidad=0;
		$mensaje="";
		
		\App::setLocale('es');
		
		if (empty($data)) {

			$sql = "insert into pruebas_presentadas (id_autorizacion) values($id)";
			DB::insert($sql);
		} else {
			foreach($data as $data)
				$cantidad=$data->cantidad;
			if ($cantidad==3)
				$mensaje="Ya ud presento esta prueba o ya supero el numero de ingresos a la misma";
			else {
				$sql = "select count(distinct(id_pruebas)) as cantidad from respuestas_hl where id_autorizacion=$id";
				$data2=DB::select($sql);
				if (empty($data2)) {
					$sql = "insert into pruebas_presentadas (id_autorizacion) values($id)";
					DB::insert($sql);
				} else {
					foreach($data2 as $data2)
						$cantidad=$data2->cantidad;
					if ($cantidad==3)
						$mensaje="Ya ud presento esta prueba o ya supero el numero de ingresos a la misma";
					else {
						$sql = "insert into pruebas_presentadas (id_autorizacion) values($id)";
						DB::insert($sql);						
					}
						
				}
			}
		}
		return view('prueba_epa.preguntas_6',["id_bateria"=>$id_bateria, "mensaje"=>$mensaje,"id_au"=>$id,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);
	}	

	public function prueba_epa_ejemplo($id) {
		//dd($id);
		$dato=$id;
		$id_au=substr($dato,0,strpos($dato,"-"));
		$dato=substr($dato,strpos($dato,"-")+1);
		$dato=substr($dato,strpos($dato,"-")+1);
		$id_bateria=substr($dato,strpos($dato,"-"));
		$sql = "select tp.url, btp.orden
				from bateria_tipo_prueba btp, tipos_pruebas tp
				where btp.id_bateria=".$id_bateria." and btp.id_tipo_prueba=tp.id 
					order by orden";
		$data = DB::select($sql);
		$url_prueba="";
		foreach ($data as $data) {
			$url_prueba=$data->url;
			$orden=$data->orden;			
			break;
		}
		return view('encuestas_baterias.'.$url_prueba,["id_bateria"=>$id_bateria, "mensaje"=>'',"id_au"=>$id_au,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'',"orden"=>$orden]);		
	}	
	
	public function prueba_aceptacion($id) {
		//dd($id);
		$cantidad=substr_count($id, '-');
		//return;
		$dato=$id;
		$id_au=substr($dato,0,strpos($dato,"-"));
		$dato=substr($dato,strpos($dato,"-")+1);
		if ($cantidad>1) $dato=substr($dato,strpos($dato,"-")+1);
		$id_bateria=substr($dato,strpos($dato,"-"));
		$id_bateria=substr($dato,strpos($dato,"-"));

		return view('encuestas_baterias.aceptacion',["id_bateria"=>$id_bateria, "mensaje"=>'',"id_au"=>$id_au,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);		
	}		
	
	public function prueba_epa_aceptacion($id) {
		//dd($id);
		$dato=$id;
		$id_au=substr($dato,0,strpos($dato,"-"));
		$dato=substr($dato,strpos($dato,"-")+1);
		$dato=substr($dato,strpos($dato,"-")+1);
		$id_bateria=substr($dato,strpos($dato,"-"));
		$id_bateria=substr($dato,strpos($dato,"-"));
		return view('encuestas_baterias.aceptacion',["id_bateria"=>$id_bateria, "mensaje"=>'',"id_au"=>$id_au,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);		
	}		
	
	public function prueba_epa_resto($id) {
		//dd($id);		
		//1066-7-1
		$valor=$id;
		$id_au=substr($valor,0,strpos($valor,"-"));		
		$valor=substr($valor,strpos($valor,"-")+1);
		$id_bateria=substr($valor,0,strpos($valor,"-"));
		$valor=substr($valor,strpos($valor,"-")+1);
		$orden=$valor;
		
		$orden++;
		
		$sql = "select count(*) as cantidad from bateria_tipo_prueba where id_bateria=".$id_bateria;
		$data=DB::select($sql);
		
		foreach ($data as $data)
			$cantidad=$data->cantidad;
			
		$sql = "select tp.url
				from tipos_pruebas tp, bateria_tipo_prueba btp
				where btp.id_tipo_prueba=tp.id and btp.id_bateria=".$id_bateria." 
					and btp.orden=".$orden;
		//echo $sql; return;
		$data=DB::select($sql);		
		foreach ($data as $data)
			$url_pagina=$data->url;					
		
		$cantidad++;
		//echo $orden."...".$cantidad; return;
		
		if ($orden==$cantidad)
			return view('encuestas_baterias.generar_resultado',["id_bateria"=>$id_bateria, "mensaje"=>'',"id_au"=>$id_au,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'',"orden"=>$orden]);
		else
			return view('encuestas_baterias.'.$url_pagina,["id_bateria"=>$id_bateria, "mensaje"=>'',"id_au"=>$id_au,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'',"orden"=>$orden]);
	}	
	
	public function prueba_hi_resto($id) {
		//encuesta_3_1-702-3
		//dd($id);
		//echo "1111111111111";
		$pagina=substr($id,strpos($id,"_")+1);
		$pagina=substr($pagina,0,strpos($pagina,"-"));
		$id=substr($id,strpos($id,"-")+1);
		$id_au=substr($id,0,strpos($id,"-"));
		$id=substr($id,strpos($id,"-")+1);
		$id_bateria=$id;
		//echo "pagina=$pagina...id_au=$id_au...id_bateria=$id_bateria"; return;
		return view('prueba_hl.preguntas_'.$pagina,["id_bateria"=>$id_bateria, "mensaje"=>'',"id_au"=>$id_au,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);		
	}	
	
	public function prueba_hi ($id) {
		//dd($id);
		//701-3
		$dato=$id;
		$id=substr($dato,0,strpos($dato,"-"));
		$id_bateria=substr($dato,strpos($dato,"-")+1);
		//echo "pos=".strpos($dato,"-")."....$id...$id_bateria"; return;
		
		$sql = "select count(id) as cantidad from pruebas_presentadas where id_autorizacion=$id";
		$data=DB::select($sql);
		$cantidad=0;
		$mensaje="";
		
		\App::setLocale('es');
		
		if (empty($data)) {

			$sql = "insert into pruebas_presentadas (id_autorizacion) values($id)";
			DB::insert($sql);
		} else {
			foreach($data as $data)
				$cantidad=$data->cantidad;
			if ($cantidad==3)
				$mensaje="Ya ud presento esta prueba o ya supero el numero de ingresos a la misma";
			else {
				$sql = "select count(distinct(id_pruebas)) as cantidad from respuestas_hl where id_autorizacion=$id";
				$data2=DB::select($sql);
				if (empty($data2)) {
					$sql = "insert into pruebas_presentadas (id_autorizacion) values($id)";
					DB::insert($sql);
				} else {
					foreach($data2 as $data2)
						$cantidad=$data2->cantidad;
					if ($cantidad==3)
						$mensaje="Ya ud presento esta prueba o ya supero el numero de ingresos a la misma";
					else {
						$sql = "insert into pruebas_presentadas (id_autorizacion) values($id)";
						DB::insert($sql);						
					}
						
				}
			}
		}
		return view('prueba_hl.encuesta_3',["id_bateria"=>$id_bateria, "mensaje"=>$mensaje,"id_au"=>$id,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);
	}
	
	public function prueba_sl ($id) {
		//dd($id);
		//782-1-4
		$id_au=substr($id,0,strpos($id,"-"));
		$id=substr($id,strpos($id,"-")+1);
		$nro_prueba=substr($id,0,strpos($id,"-"));
		$id_bateria=substr($id,strpos($id,"-")+1);
		
		$sql = "select count(id) as cantidad from pruebas_presentadas where id_autorizacion=$id_au";
		
		$data=DB::select($sql);
		$cantidad=0;
		$mensaje="";
		
		\App::setLocale('es');
		if ($nro_prueba==2) {
			if (empty($data)) {
				$sql = "insert into pruebas_presentadas (id_autorizacion) values($id_au)";
				DB::insert($sql);
			} else {
				
				foreach($data as $data)
					$cantidad=$data->cantidad;
				if ($cantidad>3)
					$mensaje="Ya ud presento esta prueba o ya supero el numero de ingresos a la misma";
				else {
					$sql = "select count(distinct(id_pruebas)) as cantidad from respuestas_co where id_autorizacion=$id_au";				
					$data2=DB::select($sql);
					if (empty($data2)) {				
						$sql = "insert into pruebas_presentadas (id_autorizacion) values($id_au)";
						DB::insert($sql);
					} else {
						foreach($data2 as $data2)
							$cantidad=$data2->cantidad;
						if ($cantidad>3)
							$mensaje="Ya ud presento esta prueba o ya supero el numero de ingresos a la misma";
						else {
							$sql = "insert into pruebas_presentadas (id_autorizacion) values($id_au)";
							DB::insert($sql);
						}
							
					}
				}
			}
		}
		/*if ($nro_prueba==1)
			$pagina="preguntas_6_ejemplo";
		else*/
			$pagina="preguntas_6";

		return view('prueba_sl.'.$pagina,["id_bateria"=>$id_bateria, "mensaje"=>$mensaje,"id_au"=>$id_au,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);
	}
	
	public function prueba_op ($id) {
		//dd($id);
		//encuesta_5-597
		if (strpos($id,"encuesta_5_") !== false) {
			//echo "entra1...";
			$pagina=substr($id,9);
			//echo $pagina."<br>";
			$pagina=substr($pagina,0,strpos($pagina,"-"));
			//echo $pagina."<br>";
			$id_au=substr($id,strpos($id,"-")+1);
			$nro_prueba=2;
		} else {
			$id_au=substr($id,0,strpos($id,"-"));
			$nro_prueba=substr($id,strpos($id,"-")+1);			
			//echo "$id_au...";
			//$pagina=substr($id,0,strpos($id,"-"));			
		}
		
		$sql = "select count(id) as cantidad from pruebas_presentadas where id_autorizacion=$id_au";
		
		$data=DB::select($sql);
		$cantidad=0;
		$mensaje="";
		
		\App::setLocale('es');
		if ($nro_prueba==2) {
			if (empty($data)) {
				$sql = "insert into pruebas_presentadas (id_autorizacion) values($id_au)";
				DB::insert($sql);
			} else {
				
				foreach($data as $data)
					$cantidad=$data->cantidad;
				if ($cantidad>3)
					$mensaje="Ya ud presento esta prueba o ya supero el numero de ingresos a la misma";
				else {
					$sql = "select count(distinct(id_pruebas)) as cantidad from respuestas_co where id_autorizacion=$id_au";				
					$data2=DB::select($sql);
					if (empty($data2)) {				
						$sql = "insert into pruebas_presentadas (id_autorizacion) values($id_au)";
						DB::insert($sql);
					} else {
						foreach($data2 as $data2)
							$cantidad=$data2->cantidad;
						if ($cantidad>3)
							$mensaje="Ya ud presento esta prueba o ya supero el numero de ingresos a la misma";
						else {
							$sql = "insert into pruebas_presentadas (id_autorizacion) values($id_au)";
							DB::insert($sql);
						}
							
					}
				}
			}
		}
		
		/*if (strpos($id,"encuesta_5_") !== false) {
			$tipo=substr($id);
			$pagina="preguntas_5_1_3";
		}
		elseif (strpos($id,"encuesta_5_1_1") !== false)
			$pagina="preguntas_5_1_1";
		elseif (strpos($id,"encuesta_5_1_2") !== false)
			$pagina="preguntas_5_1_2";
		else
			$pagina="encuesta_5";*/
		if (strpos($id,"encuesta_5_") !== false)
			$pagina="preguntas_".$pagina;
		else
			$pagina="encuesta_5";
		
		return view('prueba_op.'.$pagina,["mensaje"=>$mensaje,"id_au"=>$id_au,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);
	}	
	
	public function guardar_encuesta_ejemplo(Request $request) {
		//dd($request->all());
		
        $today = @getdate();
		$entro=0;
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];
        $fecha_act = $ano."-".$mes."-".$dia;
		
		$sql = "select * from autorizaciones where id=".$request->id;		
	}
	
	public function generar_resultado_co ($id) {
		//dd($id);
		
		$sql = "select c.*, date(rco.fecha_creacion) as fecha
				from candidatos c, respuestas_co as rco
				where c.id_autorizacion=rco.id_autorizacion and c.id_autorizacion=".$id;
		$data=DB::select($sql);
	
		$nombre="";
		$cedula="";
		$edad="";
		$sexo="";
		$fecha="";
		$sexo="";
		$tabla="";
		
		foreach ($data as $data) {
			$nombre=$data->nombres." ".$data->apellidos;
			if ($data->cedula!="") $cedula=$data->cedula; else $cedula=0;
			$edad=$data->edad;
			$sexo=$data->sexo;
			$fecha=FuncionesControllers::fecha_normal($data->fecha);
			if ($sexo=="F")
				$sexo="FEMENINO";
			else
				$sexo="MASCULINO";
			break;
		}
		
		$sql = "select rco.respuesta as rco_respuesta, pco.respuesta as pco_respuesta, 
					pco.nombre as pregunta, pco.id_preguntas
				from respuestas_co rco, preguntas_op pco
				where rco.id_opcion=pco.id_preguntas and 
					pco.id_preguntas>57 and
					rco.id_autorizacion=".$id;
		$data=DB::select($sql);
		$correcta=0;
		$incorrecta=0;
		foreach ($data as $data) {
			if ($data->rco_respuesta>0) {
				if ($data->rco_respuesta==$data->pco_respuesta)
					$correcta++;
				else
					$incorrecta++;
			}
		}
		
		$velocidad=0;
		$presicion=0;
		
		/**********************PRUEBA CO***************************/
		
		if ($correcta<16)
			$velocidad=1;
		elseif ($correcta>15 && $correcta<30)
			$velocidad=2;
		elseif ($correcta>29 && $correcta<45)
			$velocidad=3;
		elseif ($correcta>44 && $correcta<55)
			$velocidad=4;
		elseif ($correcta>54)
			$velocidad=5;
			
		if ($incorrecta>2)
			$presicion=1;
		elseif ($incorrecta==2)
			$presicion=2;
		elseif ($incorrecta==1)
			$presicion=3;
		elseif ($incorrecta==0)
			$presicion=4;
		elseif ($incorrecta==0)
			$presicion=5;
			
		$pentil_co=0;
		$promedio_co=0;
		
		$color="red";
		$color_co="red";
		//echo "corecta=$correcta...incorrecta=$incorrecta...velocidad=$velocidad...presicion=$presicion";
			
		if (($velocidad==1 && $presicion==1) || 
			($velocidad==1 && $presicion==2) ||
			($velocidad==1 && $presicion==3) || 
			($velocidad==1 && $presicion==4) || 
			($velocidad==1 && $presicion==5) || 
			($velocidad==2 && $presicion==1) || 
			($velocidad==3 && $presicion==1) || 
			($velocidad==2 && $presicion==2)) {
			$pentil_co=1;
			$promedio_co="Deficiente";
			$color_co="#ff0000";
		} elseif (($velocidad==2 && $presicion==3) || 
				($velocidad==2 && $presicion==4) || 
				($velocidad==2 && $presicion==5) || 
				($velocidad==3 && $presicion==2) || 
				($velocidad==4 && $presicion==1)) {
			$pentil_co=2;
			$promedio_co="Inferior";
			$color_co="#ff99cc";				
		} elseif (($velocidad==3 && $presicion==3) || 
				($velocidad==4 && $presicion==2) || 
				($velocidad==5 && $presicion==1)) {
			$pentil_co=3;
			$promedio_co="Promedio";				
			$color_co="yellow";
		} elseif (($velocidad==4 && $presicion==3) || 
				($velocidad==5 && $presicion==2) || 
				($velocidad==3 && $presicion==4) || 
				($velocidad==3 && $presicion==5) || 
				($velocidad==5 && $presicion==3)) {
			$pentil_co=4;
			$promedio_co="Superior";
			$color_co="#ffff00";
		} elseif (($velocidad==4 && $presicion==4) || 
				($velocidad==4 && $presicion==5) || 
				($velocidad==5 && $presicion==4) || 
				($velocidad==5 && $presicion==5)) {
			$pentil_co=5;
			$promedio_co="Excelente";
			$color_co="#008000";
		}
	
		/**********************PRUEBA CO***************************/
		
		$tabla .= '
			<table align="center" width="500">
				<tr><td colspan="3"><div align="center" style="font-family: arial; background-color:#ffcc00; border: 1px solid"><h3><strong>Perfil de Competencias Básicas</strong></h3></div></td></tr>
				<tr style="font-family: arial">
					<td height="50px" colspan="2">Nombre: <strong>'.strtoupper($nombre).'</strong></td><td>C.I.: <strong>'.number_format($cedula,0,"",".").'</strong></td>
				</tr>
				<tr style="font-family: arial">
					<td>Edad: <strong>'.$edad.'</strong></td><td>Sexo: <strong>'.$sexo.'</strong></td><td>Fecha: <strong>'.$fecha.'</strong></td>
				</tr>			
			</table>
			<br />
	<table width="500" style="font-family:arial; text-align: center;" align="center" cellpadding="10" cellspacing="0">
		<tr>
			<td colspan=2>&nbsp;</td>
			<td style="border: 2px solid black;" align="center" bgcolor="#95b3d7"><strong>Puntaje Bruto</td>
			<td style="border: 2px solid black;" align="center" bgcolor="#95b3d7"><strong>Pentil</td>
			<td style="border: 2px solid black;" align="center" bgcolor="#95b3d7"><strong>Categoria</td>
		</tr>
			';
			
			$tabla .= '
				<tr>
					<td>&nbsp;</td>
					<td style="border: 2px solid black;" bgcolor="#ffcc00">Razonamiento Abstracto</td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black; background-color:'.$color.'"></td>
				</tr>			
			';

			$tabla .= '
				<tr>
					<td>&nbsp;</td>
					<td style="border: 2px solid black;" bgcolor="#ffcc00">Razonamiento Verbal</td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black; background-color:'.$color.'"></td>
				</tr>			
			';

			$tabla .= '
				<tr>
					<td>&nbsp;</td>
					<td style="border: 2px solid black;" bgcolor="#ffcc00">Habilidar Numerica</td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black; background-color:'.$color.'"></td>
				</tr>
			';
			
			$tabla .= '
				<tr>
					<td>&nbsp;</td>
					<td style="border: 2px solid black;" bgcolor="#ffcc00">Capacidad Organizativa</td>
					<td style="border: 2px solid black;">'.$correcta .' -- '. $incorrecta.'</td>
					<td style="border: 2px solid black;">'.$pentil_co.'</td>
					<td style="border: 2px solid black; background-color:'.$color_co.'">'.$promedio_co.'</td>
				</tr>			
			';
			
			$tabla .= '
				<tr>
					<td>&nbsp;</td>
					<td style="border: 2px solid black;" bgcolor="#ff9900"><strong>Indice del Potencial de Desempeño</strong></td>
					<td style="border: 2px solid black;" bgcolor="#c0c0c0"></td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black; background-color:'.$color.'"></td>
				</tr>			
			';	
			$tabla .= '
				<tr>
					<td>&nbsp;</td>
					<td style="border: 2px solid black;" bgcolor="#ffcc00">Relaciones</td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black; background-color:'.$color.'"></td>
				</tr>			
			';

			$tabla .= '
				<tr>
					<td>&nbsp;</td>
					<td style="border: 2px solid black;" bgcolor="#ffcc00">Responsabilidad</td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black; background-color:'.$color.'"></td>
				</tr>			
			';

			$tabla .= '
				<tr>
					<td>&nbsp;</td>
					<td style="border: 2px solid black;" bgcolor="#ffcc00">Necesidad de Logro</td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black; background-color:'.$color.'"></td>
				</tr>			
			';
			
			$tabla .= '
				<tr>
					<td>&nbsp;</td>
					<td style="border: 2px solid black;" bgcolor="#ff9900"><strong>Indice de Orientacion al Exito</strong></td>
					<td style="border: 2px solid black;" bgcolor="#c0c0c0"></td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black; background-color:'.$color.'"></td>
				</tr>			
			';		

			$tabla .= '
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>			
			';	

			$tabla .= '
				<tr>
					<td>&nbsp;</td>
					<td style="border: 2px solid black;" bgcolor="#ff9900"><strong>PERFIL CONSOLIDADO</strong></td>
					<td style="border: 2px solid black;" bgcolor="#c0c0c0"></td>
					<td style="border: 2px solid black;"></td>
					<td style="border: 2px solid black; background-color:'.$color.'"></td>
				</tr>			
			';				
			
		$tabla .= '</table>
		<br />
		';

		$tabla .='
				<table align="center" width="500" style="border: 1px solid">
					<tr valign="middle"><td><h6 style="font-family:arial; text-align: center;" >BAREMO PROFESIONAL GENERAL 2016</h6></td></tr>
				</table>
				<br />		
		';		
		
		echo $tabla;
	}
	
	public function generar_resultado_hi ($id) {
		
		/*font css*/
		$font_css = "
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 400;
			  src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v16/ek4gzZ-GeXAPcSbHtCeQI_esZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
			  unicode-range: U+0460-052F, U+20B4, U+2DE0-2DFF, U+A640-A69F;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 400;
			  src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v16/mErvLBYg_cXG3rLvUsKT_fesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
			  unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 400;
			  src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v16/-2n2p-_Y08sg57CNWQfKNvesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
			  unicode-range: U+1F00-1FFF;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 400;
			  src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v16/u0TOpm082MNkS5K0Q4rhqvesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
			  unicode-range: U+0370-03FF;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 400;
			  src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v16/NdF9MtnOpLzo-noMoG0miPesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
			  unicode-range: U+0102-0103, U+1EA0-1EF9, U+20AB;
			}
			/* latin-ext */
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 400;
			  src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v16/Fcx7Wwv8OzT71A3E1XOAjvesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
			  unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 400;
			  src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v16/CWB0XYA8bzo0kSThX0UTuA.woff2) format('woff2');
			  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 700;
			  src: local('Roboto Bold'), local('Roboto-Bold'), url(https://fonts.gstatic.com/s/roboto/v16/77FXFjRbGzN4aCrSFhlh3hJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
			  unicode-range: U+0460-052F, U+20B4, U+2DE0-2DFF, U+A640-A69F;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 700;
			  src: local('Roboto Bold'), local('Roboto-Bold'), url(https://fonts.gstatic.com/s/roboto/v16/isZ-wbCXNKAbnjo6_TwHThJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
			  unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 700;
			  src: local('Roboto Bold'), local('Roboto-Bold'), url(https://fonts.gstatic.com/s/roboto/v16/UX6i4JxQDm3fVTc1CPuwqhJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
			  unicode-range: U+1F00-1FFF;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 700;
			  src: local('Roboto Bold'), local('Roboto-Bold'), url(https://fonts.gstatic.com/s/roboto/v16/jSN2CGVDbcVyCnfJfjSdfBJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
			  unicode-range: U+0370-03FF;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 700;
			  src: local('Roboto Bold'), local('Roboto-Bold'), url(https://fonts.gstatic.com/s/roboto/v16/PwZc-YbIL414wB9rB1IAPRJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
			  unicode-range: U+0102-0103, U+1EA0-1EF9, U+20AB;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 700;
			  src: local('Roboto Bold'), local('Roboto-Bold'), url(https://fonts.gstatic.com/s/roboto/v16/97uahxiqZRoncBaCEI3aWxJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
			  unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
			}
			@font-face {
			  font-family: 'Roboto';
			  font-style: normal;
			  font-weight: 700;
			  src: local('Roboto Bold'), local('Roboto-Bold'), url(https://fonts.gstatic.com/s/roboto/v16/d-6IYplOFocCacKzxwXSOFtXRa8TVwTICgirnJhmVJw.woff2) format('woff2');
			  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
			}
					
					";
		/*font css*/
		
		/*style reportes*/
		$style_reportes = "
			body, div, table, tbody, tfoot, thead, tr, th, td {
				margin: 0;
				padding: 0;
				border: 0;
				outline: 0;
				font-size: 100%;
				vertical-align: baseline;
			}
			body {
				margin: 0;
				padding: 0;
				font-family: 'Roboto', sans-serif;
				color: #4A4A4A;
				font-size: 14px;
				font-weight: normal;
				text-align:left; 
			}
			#content { 
				width: 800px;
				margin: 0 auto;}
				
			#header{ margin: 0 0 20px 0; width:800px;
				 }

			#logo { float:left; width:170px; margin-right:10px; }

			#titulo { 
				width: 600px;
				float:left;
				margin:60px 0 20px 10px; 
				}
				
			.titulo {
				color: #0060A8; 
				font-size: 18px;
				font-weight: bold; 
				text-align:left; 
				letter-spacing:1px; }

			#borde {
				width: 800px;
				border-bottom: 1px solid #B4B4B4;
				padding-top:90px;
				
			}

			#fecha { float:left; width:140px; margin-right:10px; }

			#texto { 
				width: 630px;
				float:left;
				margin:0px 0 20px 10px; 
				}
				
			.texto {
				line-height: 22px;
				font-size: 16px;
				 }
				
			table {	
				overflow: hidden;
				width: 800px;
				margin: 3% auto;
				border: 1px solid #FFF;
				border-collapse:collapse;
				border-radius:8px; 
			}

			th, td {
				padding-top:7px; 
				padding-left:10px; 
				height:23px; 
				}
				
			th {
				color: #FFFFFF;
				background:#E04000; 
				border: 1px solid #FFF;
				border-collapse:collapse;
				font-weight: normal;}
				
			td {
				border: 1px solid #FFF;  
				border-collapse:collapse; 
				background: #F3F3F3; }

			#indice{
				font-size: 16px;
				padding-top:7px; 
				padding-left:10px; 
				height:40px; 
				}

			#indice_1{ 
				font-size: 16px;
				padding-top:7px; 
				padding-left:10px; 
				height:40px; 
				background:#000000;
				border-radius:8px;}
				
			#ind_excelente { background: #007754; color:#000; }
			#ind_superior { background: #7DD439;  color:#000; }
			#ind_promedio { background: #FFB2009; color:#000; }
			#ind_inferior { background: #FFA2E2; color:#000; }
			#ind_deficiente { background: #D90000; color:#000; }


			#footer{  width:300px; margin:0px 0 30px 10px; color:#000000;
			font-size: 12px;
			font-weight: normal;
			}		
		";
		/*style reportes*/
		
		//dd($id);
		$id_au=substr($id,0,strpos($id,"-"));
		$id_bateria=substr($id,strpos($id,"-")+1);
		$color="";
		$sql = "select c.*, date(rhl.fecha_creacion) as fecha
				from candidatos c, respuestas_hl as rhl 
				where c.id_autorizacion=rhl.id_autorizacion and c.id_autorizacion=".$id_au;
		$data=DB::select($sql);
	
		$nombre="";
		$cedula="";
		$edad="";
		$sexo="";
		$fecha="";
		$sexo="";
		
		foreach ($data as $data) {
			$nombre=$data->nombres." ".$data->apellidos;
			$cedula=$data->cedula;
			$edad=$data->edad;
			$sexo=$data->sexo;
			$recibe=$data->recibe;
			$fecha=FuncionesControllers::fecha_normal($data->fecha);
			if ($sexo=="F")
				$sexo="FEMENINO";
			else
				$sexo="MASCULINO";
			break;
		}
		
		if ($cedula=="")
			$cedula=0;
					
		$tabla="";
		
		$tabla_pdf="";
		
		$sql = "select logo, nombre from empresas where id in (select id_empresas from autorizaciones where id=$id)";
		$data=DB::select($sql);
		$logo="";
		foreach ($data as $data) {
			$empresa=$data->nombre;
			if ($data->logo!="")
				$logo = "../empresas/logos/".$data->logo;
			else
				$logo="";
		}
				
		$cabecera='
		<tr>
			<td colspan=2>&nbsp;</td>
			<td style="border: 2px solid black;" align="center" bgcolor="#ff9900"><strong>Puntaje Bruto</td>
			<td style="border: 2px solid black;" align="center" bgcolor="#ff9900"><strong>Pentil</td>
			<td style="border: 2px solid black;" align="center" bgcolor="#ff9900"><strong>Categoria</td>
		</tr>
		';
			
		$cabecera = '
            <th align="center">Puntaje Bruto</th>
            <th align="center">Pentil</th>
            <th align="center">Categoría</th>		
		';
			
		$tabla = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>Perfil de Competencia Básicas - '.strtoupper($nombre).' - '.$cedula.'</title>
			
			<style>
			'.$font_css.'
			\n\n
			'.$style_reportes.'
			</style>

			</head>

			<body>
			<div id="content">

			<div id="header">
			<div id="titulo" class="titulo" >Perfil de Competencia Básicas</div>
			<div id="logo"><img src="'.$logo.'" alt="Logo MTH" /></div>
			<div id="borde">&nbsp;</div>
			</div>		
		';
		
		
		/*DATOS CANDIDATO*/
		$tabla .= '
			<div id="header">
			<div id="texto" class="texto" >
			Nombre: '.strtoupper($nombre).'<br />
			C.I.: '.number_format($cedula,0,"",".").'<br />
			Sexo: '.$sexo.'<br />
			Edad: '.$edad.' años<br />
			</div>
			<div id="fecha" class="texto" >Fecha: '.strtoupper($fecha).'</div>
			</div>		
		';
		
		//$tabla_pdf=$tabla;
		
		/*COMPETENCIAS INSTRUMENTALES*/
		
		$tabla .= '
			<table cellspacing="0">
				<tr>
					<th align="left">COMPETENCIAS INSTRUMENTALES</th>
					'.$cabecera.'
				</tr>
		';
		
		/*********HABILIDADES INTELECTIVAS**************/
			
			$sql = "select rhl.*, phl.id_preguntas, phl.nombre, phl.id_pruebas, ohl.respuesta as correcta
					from respuestas_hl rhl, preguntas_hl phl, opciones_hl ohl
					where rhl.id_autorizacion=".$id_au." 
						and ohl.id_opciones=rhl.id_opcion and phl.id_pruebas=2 and rhl.id_pruebas=2
						and ohl.id_pregunta=phl.id_preguntas
						and rhl.respuesta=ohl.respuesta";
			//echo "HI=".$sql."<br>";
			$data=DB::select($sql);
			$suma_hi=0;
			$pentil_hi=1;
			$promedio_hi="Deficiente";
			$color="#ff0000";
			
			if (!empty($data)) {
				$suma_hi=count($data);

				if ($suma_hi<8) {
					$pentil_hi=1;
					$promedio_hi="Deficiente";
					$color="#ff0000";
				} elseif ($suma_hi>7 && $suma_hi<15) {
					$pentil_hi=2;
					$promedio_hi="Inferior";
					$color="#ff99cc";
				} elseif ($suma_hi>14 && $suma_hi<26) {
					$pentil_hi=3;
					$promedio_hi="Promedio";
					$color="#ffff00";
				} elseif ($suma_hi>25 && $suma_hi<33) {
					$pentil_hi=4;
					$promedio_hi="Superior";
					$color="#99cc00";
				} elseif ($suma_hi>32) {
					$pentil_hi=5;
					$promedio_hi="Excelente";
					$color="#008000";
				}
			}
				
			$tabla .= '
				<tr>
					<td align="left">Habilidad Intelectiva</td>
					<td align="center">'.$suma_hi.'</td>
					<td align="center">'.$pentil_hi.'</td>
					<td  align="center" style="background-color:'.$color.'">'.$promedio_hi.'</td>
				</tr>			
			';				
			
			/*********HABILIDADES INTELECTIVAS**************/		
			
			/*********CAPACIDAD DE COORDINACION**************/
			
			$sql = "select rhl.*, phl.nombre
					from respuestas_hl rhl, preguntas_hl phl 
					where rhl.id_autorizacion=".$id_au." 
						and phl.id_preguntas=rhl.id_opcion 
						and phl.id_pruebas=1 and phl.id_preguntas>9
						and rhl.respuesta like '%,%'";
			//echo "CC=".$sql."<br>";
			$data=DB::select($sql);
			$i=0;
			$mas=0;
			$menos=0;
			$pentil_cc=0;
			$promedio_cc="";
			if (!empty($data)) {
				foreach ($data as $data) {
					$respuestas=explode(",",$data->respuesta);			
					$pregunta=str_split($data->nombre);				

					foreach ($pregunta as $key=>$value) {
						$sql = "select x,y from matriz_cc where letra='".$value."'";					
						$data_resp=DB::select($sql);
						foreach ($data_resp as $data_resp) {
							$yx=$data_resp->y.$data_resp->x;						
							if ($respuestas[$key]>0) {
								//echo "<br>1)".$sql."...$yx...".$respuestas[$key];
								if ($yx==$respuestas[$key])
									$mas++;
								else
									$menos++;
							}
						}
					}			
					$i++;			
				}

				$velocidad=0;
				$presicion=0;
				
				if ($mas<37)
					$velocidad=1;
				elseif ($mas>36 && $mas<50)
					$velocidad=2;
				elseif ($mas>49 && $mas<65)
					$velocidad=3;
				elseif ($mas>64 && $mas<75)
					$velocidad=4;
				elseif ($mas>74)
					$velocidad=5;
					
				if ($menos==4)
					$presicion=1;
				elseif ($menos==2)
					$presicion=2;
				elseif ($menos==1)
					$presicion=3;
				elseif ($menos==0)
					$presicion=4;
				elseif ($menos==0)
					$presicion=5;
					
				//echo "mas=$mas...menos=$menos...v=".$velocidad."...p=".$presicion;
					
				if (($velocidad==1 && $presicion==1) || 
					($velocidad==1 && $presicion==2) ||
					($velocidad==1 && $presicion==3) || 
					($velocidad==1 && $presicion==4) || 
					($velocidad==1 && $presicion==5) || 
					($velocidad==2 && $presicion==1) || 
					($velocidad==3 && $presicion==1) || 
					($velocidad==2 && $presicion==2)) {
					$pentil_cc=1;
					$promedio_cc="Deficiente";
					$color="#ff0000";
				} elseif (($velocidad==2 && $presicion==3) || 
						($velocidad==2 && $presicion==4) || 
						($velocidad==2 && $presicion==5) || 
						($velocidad==3 && $presicion==2) || 
						($velocidad==4 && $presicion==1)) {
					$pentil_cc=2;
					$promedio_cc="Inferior";
					$color="#ff99cc";				
				} elseif (($velocidad==3 && $presicion==3) || 
						($velocidad==4 && $presicion==2) || 
						($velocidad==5 && $presicion==1)) {
					$pentil_cc=3;
					$promedio_cc="Promedio";
					$color="#ffff00";
				} elseif (($velocidad==4 && $presicion==3) || 						
						($velocidad==5 && $presicion==2) || 
						($velocidad==3 && $presicion==4) || 
						($velocidad==3 && $presicion==5) || 
						($velocidad==5 && $presicion==3)) {
					if (($velocidad==3 && $presicion==4 && $mas>59 && $mas<65) ||
						($velocidad==3 && $presicion==5 && $mas>59 && $mas<65)) {
						$pentil_cc=4;
						$promedio_cc="Superior";
					} else {						
						$pentil_cc=3;
						$promedio_cc="Promedio";
					}
				} elseif (($velocidad==4 && $presicion==4) || 
						($velocidad==4 && $presicion==5) || 
						($velocidad==5 && $presicion==4) || 
						($velocidad==5 && $presicion==5)) {
					$pentil_cc=5;
					$promedio_cc="Excelente";
					$color="#008000";
				}
			}
			
			$tabla .= '
				<tr>
					<td align="left">Capacidad de Coordinacion</td>
					<td align="center">'.$pentil_cc.'</td>
					<td align="center">'.$mas.' - '.$menos.'</td>
					<td  align="center" style="background-color:'.$color.'">'.$promedio_cc.'</td>
				</tr>			
			';				
				
			/*********CAPACIDAD DE COORDINACION**************/
			
			/*Indice de Potencial de Desempeño*/
			
			$pentil_ipd=($pentil_hi+$pentil_cc)/2;
			if ($pentil_ipd<1.75) {
				$promedio_ipd="Deficiente";
				$color="#ff0000";
			} elseif ($pentil_ipd>1.74 && $pentil_ipd<2.75) {
				$promedio_ipd="Inferior";
				$color="#ff99cc";
			} elseif ($pentil_ipd>2.76 && $pentil_ipd<3.50) {
				$promedio_ipd="Promedio";
				$color="#ffff00";
			} elseif ($pentil_ipd>3.49 && $pentil_ipd<4.26) {
				$promedio_ipd="Superior";
				$color="#99cc00";
			} elseif ($pentil_ipd>4.25 && $pentil_ipd<5.1) {
				$promedio_ipd="Excelente";
				$color="#008000";
			}			

			$tabla .= '
					<tr id="indice">
						<td align="left">Indice de Potencial de Desempeño</td>
						<td></td>
						<td align="center">'.number_format($pentil_ipd,2,".",",").'</td>
						<td align="center" style="background-color:'.$color.'">'.$promedio_ipd.'</td>
					</tr>
				</table>
			';
			
			/*Indice de Potencial de Desempeño*/
			
			/*Competencias Potenciadoras*/
			
			/*********IEP**************/

			$sql = "select rhl.*, rhl.respuesta as resp_rhl, ohl.respuesta as resp_ohl,
					phl.nombre, phl.id_pruebas
					from respuestas_hl rhl, preguntas_hl phl, opciones_hl ohl
					where rhl.id_autorizacion=".$id_au." 
						and ohl.id_opciones=rhl.id_opcion and phl.id_pruebas=3
						and ohl.id_pregunta=phl.id_preguntas
						and rhl.id_pruebas=3 
					order by phl.id_preguntas, ohl.id_opciones";
			$data=DB::select($sql);
			//echo "IEP=".$sql."<br>";
			
			/*********IEP**************/
			
			$mas_oac=0;
			$pentil_oac=0;
			$promedio_oac=0;
			
			$mas_rel=0;
			$pentil_rel=0;
			$promedio_rel=0;
			
			$mas_res=0;
			$pentil_res=0;
			$promedio_res=0;
			
			$mas_log=0;
			$pentil_log=0;
			$promedio_log=0;
			
			$i=1;
			
			foreach ($data as $data) {
				if ($i<25) {
					//Orientacion al Cliente
					if ($data->resp_rhl==$data->resp_ohl)
						$mas_oac++;
					else {
						if ($data->resp_ohl==0)
							$mas_oac=$mas_oac;
						else if (($data->resp_rhl=1 && $data->resp_ohl=-1) || ($data->resp_rhl=-1 && $data->resp_ohl=1))
							$mas_oac--;
					}
					//echo "OAC=".$mas_oac."<br>";
				} elseif ($i>24 && $i<49) {
					//Relaciones
					//echo "respuesta=".$data->resp_rhl."...opcion=".$data->resp_ohl;
					if ($data->resp_rhl==$data->resp_ohl)
						$mas_rel++;
					else {
						if ($data->resp_ohl==0)
							$mas_rel=$mas_rel;
						else if (($data->resp_rhl=1 && $data->resp_ohl=-1) || ($data->resp_rhl=-1 && $data->resp_ohl=1))
							$mas_rel--;					
					}					
					//echo "...RELACIONES=".$mas_rel."<br>";
				} elseif ($i>48 && $i<73) {
					//Responsabilidas
					if ($data->resp_rhl==$data->resp_ohl)
						$mas_res++;
					else {
						if ($data->resp_ohl==0)
							$mas_res=$mas_res;
						else if (($data->resp_rhl=1 && $data->resp_ohl=-1) || ($data->resp_rhl=-1 && $data->resp_ohl=1))
							$mas_res--;					
					}
				} elseif ($i>72) {
					//Logro
					if ($data->resp_rhl==$data->resp_ohl)
						$mas_log++;
					else {
						if ($data->resp_ohl==0)
							$mas_log=$mas_log;
						else if (($data->resp_rhl=1 && $data->resp_ohl=-1) || ($data->resp_rhl=-1 && $data->resp_ohl=1))
							$mas_log--;					
					}
					//echo "$mas_log<br>";
				}
				$i++;
			}
			//echo "<h1>i=".$i."</h1>";
			//Deficiente	Inferior	Promedio	Superior	Excelente
			
			//mas_oac
			if ($mas_oac<4) {
				$pentil_oac=1; $promedio_oac="Deficiente"; $color_oac="#ff0000";
			} elseif (($mas_oac>3 && $mas_oac<11)) {
				$pentil_oac=2; $promedio_oac="Inferior"; $color_oac="#ff99cc";
			} elseif (($mas_oac>10 && $mas_oac<16)) {
				$pentil_oac=3; $promedio_oac="Promedio"; $color_oac="#ffff00";
			} elseif (($mas_oac>15 && $mas_oac<20)) {
				$pentil_oac=4; $promedio_oac="Superior"; $color_oac="#99cc00";
			} elseif (($mas_oac>19)) {
				$pentil_oac=5; $promedio_oac="Excelente"; $color_oac="#008000";
			}
			
			//mas_rel
			if ($mas_rel<3) {
				$pentil_rel=1; $promedio_rel="Deficiente"; $color_rel="#ff0000";
			} elseif (($mas_rel>2 && $mas_rel<11)) {
				$pentil_rel=2; $promedio_rel="Inferior"; $color_rel="#ff99cc";
			} elseif (($mas_rel>10 && $mas_rel<16)) {
				$pentil_rel=3; $promedio_rel="Promedio"; $color_rel="#ffff00";
			} elseif (($mas_rel>15 && $mas_rel<20)) {
				$pentil_rel=4; $promedio_rel="Superior"; $color_rel="#99cc00";
			} elseif (($mas_rel>19)) {
				$pentil_rel=5; $promedio_rel="Excelente"; $color_rel="#008000";
			}
			
			//mas_res
			if ($mas_res<6) {
				$pentil_res=1; $promedio_res="Deficiente"; $color_res="#ff0000";
			} elseif (($mas_res>5 && $mas_res<10)) {
				$pentil_res=2; $promedio_res="Inferior"; $color_res="#ff99cc";
			} elseif (($mas_res>9 && $mas_res<17)) {
				$pentil_res=3; $promedio_res="Promedio"; $color_res="#ffff00";
			} elseif (($mas_res>16 && $mas_res<20)) {
				$pentil_res=4; $promedio_res="Superior"; $color_res="#99cc00";
			} elseif (($mas_res>19)) {
				$pentil_res=5; $promedio_res="Excelente"; $color_res="#008000";
			}
			
			//mas_log
			if ($mas_log<5) {
				$pentil_log=1; $promedio_log="Deficiente"; $color_log="#ff0000";
			} elseif (($mas_log>4 && $mas_log<10)) {
				$pentil_log=2; $promedio_log="Inferior"; $color_log="#ff99cc";
			} elseif (($mas_log>9 && $mas_log<17)) {
				$pentil_log=3; $promedio_log="Promedio"; $color_log="#ffff00";
			} elseif (($mas_log>16 && $mas_log<20)) {
				$pentil_log=4; $promedio_log="Superior"; $color_log="#99cc00";
			} elseif (($mas_log>19)) {
				$pentil_log=5; $promedio_log="Excelente"; $color_log="#008000";
			}			

			$pentil_ioe=($pentil_oac+$pentil_rel+$pentil_res+$pentil_log)/4;
			$promedio_ioe="Deficiente";
			$color="#ff0000";
			if ($pentil_ioe<1.75) {
				$promedio_ioe="Deficiente";
				$color="#ff0000";
			} elseif ($pentil_ioe>1.74 && $pentil_ioe<2.75) {
				$promedio_ioe="Inferior";
				$color="#ff99cc";
			} elseif ($pentil_ioe>2.76 && $pentil_ioe<3.50) {
				$promedio_ioe="Promedio";
				$color="#ffff00";
			} elseif ($pentil_ioe>3.49 && $pentil_ioe<4.26) {
				$promedio_ioe="Superior";
				$color="#99cc00";
			} elseif ($pentil_ioe>4.25 && $pentil_ioe<5.1) {
				$promedio_ioe="Excelente";
				$color="#008000";
			}			
			
			$tabla .= '
				<table cellspacing="0">
					<tr>
						<th align="left">COMPETENCIAS POTENCIADORAS</th>
						'.$cabecera.'
					</tr>
					<tr>
						<td align="left">Orientación al Clientea</td>
						<td align="center">'.$mas_oac.'</td>
						<td align="center">'.$pentil_oac.'</td>
						<td align="center" style="background-color:'.$color_oac.'">'.$promedio_oac.'</td>
					</tr>
					<tr>
						<td align="left">Relaciones</td>
						<td align="center">'.$mas_rel.'6</td>
						<td align="center">'.$pentil_rel.'</td>
						<td align="center" style="background-color:'.$color_rel.'">'.$promedio_rel.'</td>
					</tr>
					<tr>
						<td align="left">Responsabilidad</td>
						<td align="center">'.$mas_res.'6</td>
						<td align="center">'.$pentil_res.'</td>
						<td align="center" style="background-color:'.$color_res.'">'.$promedio_res.'</td>
					</tr>
					<tr>
						<td align="left">Logro</td>
						<td align="center">'.$mas_log.'6</td>
						<td align="center">'.$pentil_log.'</td>
						<td align="center" style="background-color:'.$color_log.'">'.$promedio_log.'</td>
					</tr>
					<tr id="indice">
						<td align="left">Indice de Orientación al Éxito</td>
						<td></td>
						<td align="center">'.number_format($pentil_ioe,2,".",",").'</td>
						<td align="center" style="background-color:'.$color.'">'.$promedio_ioe.'</td>
					</tr>
				</table>			
			';
			
			/*Competencias Potenciadoras*/
			
			/*CONSOLIDADO*/
				
			$pentil_consolidado=($pentil_ioe+$pentil_ipd)/2;
			$promedio_consolidado="Deficiente";
			$color="#ff0000";
			if ($pentil_consolidado<1.89) {
				$promedio_consolidado="Deficiente";
				$color="#ff0000";
			} elseif ($pentil_consolidado>1.88 && $pentil_consolidado<2.64) {
				$promedio_consolidado="Inferior";
				$color="#ff99cc";
			} elseif ($pentil_consolidado>2.63 && $pentil_consolidado<3.37) {
				$promedio_consolidado="Promedio";
				$color="#ffff00";
			} elseif ($pentil_consolidado>3.38 && $pentil_consolidado<4.26) {
				$promedio_consolidado="Superior";
				$color="#99cc00";
			} elseif ($pentil_consolidado>4.25 && $pentil_consolidado<5.1) {
				$promedio_consolidado="Excelente";
				$color="#008000";
			}
			
			$tabla .= '
				<table cellspacing="0">
					<tr>
						<th align="left">COMPETENCIAS INSTRUMENTALES</th>
						'.$cabecera.'
					</tr>
					<tr id="indice">
						<td align="left">Perfil Consolidado</td>
						<td align="center"></td>
						<td align="center">'.number_format($pentil_consolidado,2,".",",").'</td>
						<td align="center" style="background-color:'.$color.'">'.$promedio_consolidado.'</td>
					</tr>
				</table>
			';
			
			/*CONSOLIDADO*/
			
			/*COMPETENCIAS DIREFERNCIADORAS*/
			
		/*1)Exc. Personal*/
		$sql = "select count(rhl.id) as cantidad, phl.nombre
				from respuestas_hl rhl, preguntas_hl phl 
				where rhl.id_autorizacion=".$id_au." 
					and phl.id_preguntas=rhl.id_opcion 
					and phl.id_pruebas=5 and rhl.id_pruebas=5
					and rhl.respuesta=phl.respuesta and 
					((phl.orden>15 and phl.orden<21) ||
					(phl.orden>35 and phl.orden<41) || 
					(phl.orden>55 and phl.orden<61) || 
					(phl.orden>75 and phl.orden<81) ||
					(phl.orden>95 and phl.orden<101) ||
					(phl.orden>115 and phl.orden<121))
					";
		//echo "".$sql."<br>";
		$data=DB::select($sql);
		
		$ep_pb=0;
		$ep_pentil=0;
		$ep_categoria=0;
		$ep_color="";
		
		if (!empty($data)) {
			foreach ($data as $data)
				$cantidad=$data->cantidad;
			$ep_pb=$cantidad;
			if ($cantidad>-1 && $cantidad<3) {
				$ep_pentil=1;
				$ep_categoria="Deficiente";
				$ep_color="#ff0000";
			} elseif ($cantidad>2 && $cantidad<8) {
				$ep_pentil=2;
				$ep_categoria="Inferior";
				$ep_color="#ff99cc";				
			} elseif ($cantidad>7 && $cantidad<17) {
				$ep_pentil=3;
				$ep_categoria="Promedio";
				$ep_color="#ffff00";				
			} elseif ($cantidad>16 && $cantidad<23) {
				$ep_pentil=4;
				$ep_categoria="Superior";
				$ep_color="#99cc00";				
			} elseif ($cantidad>22) {
				$ep_pentil=5;	
				$ep_categoria="Excelente";
				$ep_color="#008000";				
			}
		}			
			
	$tabla .= '	
	<table cellspacing="0">
        <tr>
            <th align="left">COMPETENCIAS DIFERENCIADORAS</th>
            '.$cabecera.'
        </tr>
        <tr>
            <td align="left">Excelencia Personal</td>
            <td align="center">'.$ep_pb.'</td>
            <td align="center">'.$ep_pentil.'</td>
            <td align="center" style="background-color:'.$ep_color.'">'.$ep_categoria.'</td>
        </tr>';
		
		/*2)Socio Estratégico del Negocio*/
		$sql = "select count(rhl.id) as cantidad, phl.nombre
				from respuestas_hl rhl, preguntas_hl phl 
				where rhl.id_autorizacion=".$id_au." 
					and phl.id_preguntas=rhl.id_opcion 
					and phl.id_pruebas=5 and rhl.id_pruebas=5
					and rhl.respuesta=phl.respuesta and
					((phl.orden>0 and phl.orden<6) || 
					(phl.orden>20 and phl.orden<26) ||
					(phl.orden>40 and phl.orden<46) ||
					(phl.orden>60 and phl.orden<66) || 
					(phl.orden>80 and phl.orden<86) || 
					(phl.orden>100 and phl.orden<106))
					";
		//echo "".$sql."<br>";
		$data=DB::select($sql);
		
		$ep_pb=0;
		$ep_pentil=0;
		$ep_categoria=0;
		$ep_color="";
		
		if (!empty($data)) {
			foreach ($data as $data)
				$cantidad=$data->cantidad;
			$ep_pb=$cantidad;
			if ($cantidad>-1 && $cantidad<2) {
				$ep_pentil=1;
				$ep_categoria="Deficiente";
				$ep_color="#ff0000";
			} elseif ($cantidad>1 && $cantidad<8) {
				$ep_pentil=2;
				$ep_categoria="Inferior";
				$ep_color="#ff99cc";				
			} elseif ($cantidad>7 && $cantidad<20) {
				$ep_pentil=3;
				$ep_categoria="Promedio";
				$ep_color="#ffff00";				
			} elseif ($cantidad>19 && $cantidad<28) {
				$ep_pentil=4;
				$ep_categoria="Superior";
				$ep_color="#99cc00";				
			} elseif ($cantidad>27) {
				$ep_pentil=5;	
				$ep_categoria="Excelente";
				$ep_color="#008000";				
			}
		}		
		
		$tabla .= '
        <tr>
            <td align="left">Socio Estratégico del Negocio</td>
            <td align="center">'.$ep_pb.'</td>
            <td align="center">'.$ep_pentil.'</td>
            <td align="center" style="background-color:'.$ep_color.'">'.$ep_categoria.'</td>
        </tr>';
		
		/*3)Excelencia Funcional*/
		$sql = "select count(rhl.id) as cantidad, phl.nombre
				from respuestas_hl rhl, preguntas_hl phl 
				where rhl.id_autorizacion=".$id_au." 
					and phl.id_preguntas=rhl.id_opcion 
					and phl.id_pruebas=5 and rhl.id_pruebas=5
					and rhl.respuesta=phl.respuesta and
					((phl.orden>10 and phl.orden<16) || 
					(phl.orden>30 and phl.orden<36) ||
					(phl.orden>50 and phl.orden<56) ||
					(phl.orden>70 and phl.orden<76) || 
					(phl.orden>90 and phl.orden<96) || 
					(phl.orden>110 and phl.orden<116))
					";				
					
		//echo "".$sql."<br>";
		$data=DB::select($sql);
		
		$ep_pb=0;
		$ep_pentil=0;
		$ep_categoria=0;
		$ep_color="";
		
		if (!empty($data)) {
			foreach ($data as $data)
				$cantidad=$data->cantidad;
			$ep_pb=$cantidad;
			if ($cantidad>-1 && $cantidad<3) {
				$ep_pentil=1;
				$ep_categoria="Deficiente";
				$ep_color="#ff0000";
			} elseif ($cantidad>1 && $cantidad<9) {
				$ep_pentil=2;
				$ep_categoria="Inferior";
				$ep_color="#ff99cc";				
			} elseif ($cantidad>8 && $cantidad<22) {
				$ep_pentil=3;
				$ep_categoria="Promedio";
				$ep_color="#ffff00";				
			} elseif ($cantidad>21 && $cantidad<28) {
				$ep_pentil=4;
				$ep_categoria="Superior";
				$ep_color="#99cc00";				
			} elseif ($cantidad>27) {
				$ep_pentil=5;	
				$ep_categoria="Excelente";
				$ep_color="#008000";				
			}
		}
		
		$tabla .= '
        <tr>
            <td align="left">Excelencia Funcional</td>
            <td align="center">'.$ep_pb.'</td>
            <td align="center">'.$ep_pentil.'</td>
            <td align="center" style="background-color:'.$ep_color.'">'.$ep_categoria.'</td>
        </tr>';
		
		/*4)Excelencia Operacional*/
		$sql = "select count(rhl.id) as cantidad, phl.nombre
				from respuestas_hl rhl, preguntas_hl phl 
				where rhl.id_autorizacion=".$id_au." 
					and phl.id_preguntas=rhl.id_opcion 
					and phl.id_pruebas=5 and rhl.id_pruebas=5
					and rhl.respuesta=phl.respuesta and
					((phl.orden>5 and phl.orden<11) || 
					(phl.orden>25 and phl.orden<31) ||
					(phl.orden>45 and phl.orden<51) ||
					(phl.orden>65 and phl.orden<71) || 
					(phl.orden>85 and phl.orden<91) || 
					(phl.orden>105 and phl.orden<111))
					";						
					
		//echo "".$sql."<br>";
		$data=DB::select($sql);
		
		$ep_pb=0;
		$ep_pentil=0;
		$ep_categoria=0;
		$ep_color="";
		
		if (!empty($data)) {
			foreach ($data as $data)
				$cantidad=$data->cantidad;
			$ep_pb=$cantidad;
			if ($cantidad>-1 && $cantidad<6) {
				$ep_pentil=1;
				$ep_categoria="Deficiente";
				$ep_color="#ff0000";
			} elseif ($cantidad>5 && $cantidad<11) {
				$ep_pentil=2;
				$ep_categoria="Inferior";
				$ep_color="#ff99cc";				
			} elseif ($cantidad>10 && $cantidad<19) {
				$ep_pentil=3;
				$ep_categoria="Promedio";
				$ep_color="#ffff00";				
			} elseif ($cantidad>18 && $cantidad<26) {
				$ep_pentil=4;
				$ep_categoria="Superior";
				$ep_color="#99cc00";				
			} elseif ($cantidad>25) {
				$ep_pentil=5;	
				$ep_categoria="Excelente";
				$ep_color="#008000";				
			}
		}		
		
		$tabla .= '
        <tr>
            <td align="left">Excelencia Operaional</td>
            <td align="center">'.$ep_pb.'</td>
            <td align="center">'.$ep_pentil.'</td>
            <td align="center" style="background-color:'.$ep_color.'">'.$ep_categoria.'</td>
        </tr>		
    </table>';
	/*COMPETENCIAS DIREFERNCIADORAS*/
		 /*FOOTER*/
		 
		 $tabla .= '
			<div id="footer"> Baremo General 2017</div>

			</div>

			</body>
			</html>		 
		 ';		 
		
		//EncuestaControllers::generar_pdf_hi($tabla, $id_au);		
		return view('prueba_hl.resultado_hi',["tabla"=>$tabla, "recibe"=>$recibe]);
	}
	
	public function generar_resultado_epa ($id) {
		//dd($id);
		$id_au=$id;
		$color="";
		$sql = "select c.*, date(rhl.fecha_creacion) as fecha
				from candidatos c, respuestas_epa as rhl 
				where c.id_autorizacion=rhl.id_autorizacion and c.id_autorizacion=".$id_au;
		$data=DB::select($sql);
	
		$nombre="";
		$cedula="";
		$edad="";
		$sexo="";
		$fecha="";
		$sexo="";
		
		foreach ($data as $data) {
			$nombre=$data->nombres." ".$data->apellidos;
			$cedula=$data->cedula;
			$edad=$data->edad;
			$sexo=$data->sexo;
			$fecha=FuncionesControllers::fecha_normal($data->fecha);
			if ($sexo=="F")
				$sexo="FEMENINO";
			else
				$sexo="MASCULINO";
			break;
		}
		
		if ($cedula=="")
			$cedula=0;
					
		$tabla="";
			
		$tabla = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>Encuestas EPA</title>
			<link href="../css/font_css.css" rel="stylesheet" type=\'text/css\'>
			<link href="../css/style_reportes.css" rel="stylesheet" type="text/css" />

			</head>

			<body>
			<div id="content">

			<div id="header">
				<div>
					<table border="1" width="100%" bgcolor="#00FF00">
						<tr bgcolor="#00FF00">
							<td align="left" bgcolor="#00FF00"><img src="../imagenes/mth.jpg" alt="Logo MTH"></td>
							<td align="right" bgcolor="#00FF00"><img src="../empresas/logos/3.jpg"width="120" height="120"></td>
						</tr>
					</table>
				</div>			
				<div id="titulo" class="titulo" >Perfil de Competencia Básicas</div>
			</div>

			<div id="header">
			<div id="texto" class="texto" >
			Nombre: '.strtoupper($nombre).'<br />
			C.I.: '.number_format($cedula,0,"",".").'<br />
			Sexo: '.$sexo.'<br />
			Edad: '.$edad.' años<br />
			</div>
			<div id="fecha" class="texto" >Fecha: '.$fecha.'</div>
			</div>		
		';
			
		/*******************************Razonamiento Abstracto**************************************/
			
		$sql = "select count(rhl.id) as cantidad
				from respuestas_epa rhl, preguntas_epa phl 
				where rhl.id_autorizacion=".$id_au." 
					and phl.id_preguntas=rhl.id_opcion 
					and phl.id_pruebas=2
					and rhl.respuesta=phl.respuesta";					
			$data=DB::select($sql);
			$pentil_ra=0;
			$categoria_ra="";
			$color_ra="#ff0000";
			foreach ($data as $data) {
				$buenas=$data->cantidad;
				//	  1		    2	         3	         4	         5 
				//0  --  6	7  -- 13	14  --  20	21  --  23	24  --  25
				//Deficiente	Inferior	Promedio	Superior	Excelente

				if ($buenas<7) {
					$pentil_ra=1;
					$categoria_ra="Deficiente";
					$color_ra="#ff0000";
				} elseif ($buenas>6 && $buenas<14) {
					$pentil_ra=2;
					$categoria_ra="Inferior";
					$color_ra="#ff99cc";				
				} elseif ($buenas>13 && $buenas<21) {
					$pentil_ra=3;
					$categoria_ra="Promedio";
					$color_ra="#ffff00";				
				} elseif ($buenas>20 && $buenas<24) {
					$pentil_ra=4;
					$categoria_ra="Superior";
					$color_ra="#99cc00";				
				} elseif ($buenas>23) {
					$pentil_ra=5;
					$categoria_ra="Excelente";
					$color_ra="#008000";				
				}
			}
			
			$tabla .= '
				<table cellspacing="0">
					<tr>
						<th align="left">&nbsp;</th>
						<th align="center">Puntaje Bruto</th>
						<th align="center">Pentil</th>
						<th align="center">Categoría</th>
					</tr>
					<tr>
						<td align="left">Razonamiento Abstracto</td>
						<td align="center">'.$buenas.'</td>
						<td align="center">'.$pentil_ra.'</td>
						<td align="center" style="background-color:'.$color_ra.'">'.$categoria_ra.'</td>
					</tr>';				
			
			
			
		/*******************************Razonamiento Verbal**************************************/
			
		$sql = "select count(rhl.id) as cantidad
				from respuestas_epa rhl, opciones_epa ohl 
				where rhl.id_autorizacion=".$id_au." 
					and ohl.id_pregunta=rhl.id_opcion 
					and rhl.respuesta=ohl.id_opciones 
					and ohl.respuesta=1 
					and rhl.id_pruebas=3";
			$data=DB::select($sql);
			$pentil_rv=0;
			$categoria_rv="";
			$color_rv="#ff0000";
			foreach ($data as $data) {
				$buenas=$data->cantidad;
				//	  1		    2	         3	         4	         5 
				//0  --  5	6  --  9	10  --  19	20  --  25	26  --  30
				//Deficiente	Inferior	Promedio	Superior	Excelente

				if ($buenas<6) {
					$pentil_rv=1;
					$categoria_rv="Deficiente";
					$color_rv="#ff0000";
				} elseif ($buenas>5 && $buenas<10) {
					$pentil_rv=2;
					$categoria_rv="Inferior";
					$color_rv="#ff99cc";				
				} elseif ($buenas>9 && $buenas<20) {
					$pentil_rv=3;
					$categoria_rv="Promedio";
					$color_rv="#ffff00";				
				} elseif ($buenas>19 && $buenas<26) {
					$pentil_rv=4;
					$categoria_rv="Superior";
					$color_rv="#99cc00";				
				} elseif ($buenas>25) {
					$pentil_rv=5;
					$categoria_rv="Excelente";
					$color_rv="#008000";				
				}
			}
			
			$tabla .= '
					<tr>
						<td align="left">Razonamiento Verbal</td>
						<td align="center">'.$buenas.'</td>
						<td align="center">'.$pentil_rv.'</td>
						<td align="center" style="background-color:'.$color_rv.'">'.$categoria_rv.'</td>
					</tr>';		
			
		/*******************************Habilidar Numerica**************************************/
		$sql = "select count(rhl.id) as cantidad
				from respuestas_epa rhl, opciones_epa ohl 
				where rhl.id_autorizacion=".$id_au." 
					and ohl.id_pregunta=rhl.id_opcion 
					and rhl.respuesta=ohl.id_opciones 
					and ohl.respuesta=1 
					and rhl.id_pruebas=3";
		//echo $sql;
			
			$data=DB::select($sql);
			$pentil_hn=0;
			$categoria_hn="";
			$color_hn="#ff0000";
			foreach ($data as $data) {
				$buenas=$data->cantidad;
				//	  1		    2	         3	         4	         5 
				//0  --  3	4  --  8	 9  --  17	18  --  22	23  --  25
				//Deficiente	Inferior	Promedio	Superior	Excelente

				if ($buenas<4) {
					$pentil_hn=1;
					$categoria_hn="Deficiente";
					$color_hn="#ff0000";
				} elseif ($buenas>3 && $buenas<9) {
					$pentil_hn=2;
					$categoria_hn="Inferior";
					$color_hn="#ff99cc";				
				} elseif ($buenas>10 && $buenas<18) {
					$pentil_hn=3;
					$categoria_hn="Promedio";
					$color_hn="#ffff00";				
				} elseif ($buenas>17 && $buenas<23) {
					$pentil_hn=4;
					$categoria_hn="Superior";
					$color_hn="#99cc00";				
				} elseif ($buenas>22) {
					$pentil_hn=5;
					$categoria_hn="Excelente";
					$color_hn="#008000";				
				}
			}
			
			$tabla .= '
					<tr id="indice">
						<td align="left">Habilidar Numerica</td>
						<td align="center">'.$buenas.'</td>
						<td align="center">'.$pentil_hn.'</td>
						<td align="center"style="background-color:'.$color_hn.'">'.$categoria_hn.'</td>
					</tr>
			';				
			
			/**********************PRUEBA CO***************************/		
			
			$sql = "select rco.respuesta as rco_respuesta, pco.respuesta as pco_respuesta, 
						pco.nombre as pregunta, pco.id_preguntas
					from respuestas_epa rco, preguntas_co pco
					where rco.id_opcion=pco.id_preguntas and 
						pco.id_preguntas>57 and
						rco.id_autorizacion=".$id;
			//echo $sql;
			$data=DB::select($sql);
			$correcta=0;
			$incorrecta=0;
			foreach ($data as $data) {
				if ($data->rco_respuesta>0) {
					if ($data->rco_respuesta==$data->pco_respuesta)
						$correcta++;
					else
						$incorrecta++;
				}/* else
					$incorrecta++;*/
			}
			
			echo "correcta=$correcta...incorrecta=$incorrecta..";
					
			$velocidad=0;
			$presicion=0;
			
			if ($correcta<13)
				$velocidad=1;
			elseif ($correcta>12 && $correcta<26)
				$velocidad=2;
			elseif ($correcta>25 && $correcta<43)
				$velocidad=3;
			elseif ($correcta>42 && $correcta<56)
				$velocidad=4;
			elseif ($correcta>55)
				$velocidad=5;
				
			if ($incorrecta>3)
				$presicion=1;
			elseif ($incorrecta>2 && $incorrecta<4)
				$presicion=2;
			elseif ($incorrecta==1)
				$presicion=3;
			elseif ($incorrecta==0)
				$presicion=4;
			elseif ($incorrecta==0)
				$presicion=5;
				
			$pentil_co=0;
			$promedio_co=0;
			
			$color="red";
			$color_co="red";
			//echo "corecta=$correcta...incorrecta=$incorrecta...velocidad=$velocidad...presicion=$presicion";
				
			if (($velocidad==1 && $presicion==1) || 
				($velocidad==1 && $presicion==2) ||
				($velocidad==1 && $presicion==3) || 
				($velocidad==1 && $presicion==4) || 
				($velocidad==1 && $presicion==5) || 
				($velocidad==2 && $presicion==1) || 
				($velocidad==3 && $presicion==1) || 
				($velocidad==2 && $presicion==2)) {
				$pentil_co=1;
				$promedio_co="Deficiente";
				$color_co="#ff0000";
			} elseif (($velocidad==2 && $presicion==3) || 
					($velocidad==2 && $presicion==4) || 
					($velocidad==2 && $presicion==5) || 
					($velocidad==3 && $presicion==2) || 
					($velocidad==4 && $presicion==1)) {
				$pentil_co=2;
				$promedio_co="Inferior";
				$color_co="#ff99cc";				
			} elseif (($velocidad==3 && $presicion==3) || 
					($velocidad==4 && $presicion==2) || 
					($velocidad==5 && $presicion==1)) {
				$pentil_co=3;
				$promedio_co="Promedio";				
				$color_co="yellow";
			} elseif (($velocidad==4 && $presicion==3) || 
					($velocidad==5 && $presicion==2) || 
					($velocidad==3 && $presicion==4) || 
					($velocidad==3 && $presicion==5) || 
					($velocidad==5 && $presicion==3)) {
					$pentil_co=4;
					$promedio_co="Superior";
					$color_co="#ffff00";
					if (($velocidad==3 && $presicion==4 && $mas<37) || 
						($velocidad==3 && $presicion==5 && $mas<37)) { 
						$pentil_co=3;
						$promedio_co="Pronedio";
						$color_co="yellow";
					}
			} elseif (($velocidad==4 && $presicion==4) || 
					($velocidad==4 && $presicion==5) || 
					($velocidad==5 && $presicion==4) || 
					($velocidad==5 && $presicion==5)) {
				$pentil_co=5;
				$promedio_co="Excelente";
				$color_co="#008000";
			}
			
			$tabla .= '
					<tr id="indice">
						<td align="left">Capacidad Organizativa</td>
						<td align="center">'.$correcta .' -- '. $incorrecta.'</td>
						<td align="center">'.$pentil_co.'</td>
						<td align="center"style="background-color:'.$color_co.'">'.$promedio_co.'</td>
					</tr>
			';		
			
			/***************************IEP****************************/
			
			$sql = "select rhl.respuesta as resp_rhl, ohl.respuesta as resp_ohl
					from respuestas_epa rhl, opciones_epa ohl 
					where rhl.id_autorizacion=".$id_au." 
						and ohl.id_opciones=rhl.id_opcion 
						and ohl.respuesta=rhl.respuesta
						and rhl.id_pruebas=5";
			$data=DB::select($sql);
			//echo $sql."<br>"; return;
			
			$mas_oac=0;
			$pentil_oac=0;
			$promedio_oac=0;
			
			$mas_rel=0;
			$pentil_rel=0;
			$promedio_rel=0;
			
			$mas_res=0;
			$pentil_res=0;
			$promedio_res=0;
			
			$mas_log=0;
			$pentil_log=0;
			$promedio_log=0;
			
			$i=1;
			
			foreach ($data as $data) {
				if ($i<25) {
					//Orientacion al Cliente
					if ($data->resp_rhl==$data->resp_ohl)
						$mas_oac++;
					else {
						if (($data->resp_rhl=1 && $data->resp_ohl=-1) || ($data->resp_rhl=-1 && $data->resp_ohl=1))
							$mas_oac--;
					}
				} elseif ($i>24 && $i<49) {
					//Relaciones
					if ($data->resp_rhl==$data->resp_ohl)
						$mas_rel++;
					else {
						if (($data->resp_rhl=1 && $data->resp_ohl=-1) || ($data->resp_rhl=-1 && $data->resp_ohl=1))
							$mas_rel--;					
					}					
				} elseif ($i>48 && $i<73) {
					//Responsabilidas
					if ($data->resp_rhl==$data->resp_ohl)
						$mas_res++;
					else {
						if (($data->resp_rhl=1 && $data->resp_ohl=-1) || ($data->resp_rhl=-1 && $data->resp_ohl=1))
							$mas_res--;					
					}							
				} elseif ($i>72) {
					//Logro
					if ($data->resp_rhl==$data->resp_ohl)
						$mas_log++;
					else {
						if (($data->resp_rhl=1 && $data->resp_ohl=-1) || ($data->resp_rhl=-1 && $data->resp_ohl=1))
							$mas_log--;					
					}							
				}			
				$i++;
			}			
			
			//Orientacion al exito
			//       1           2           3          4           5
			// < 0  --  6	 7  --  11	12  --  15	16  --  18	19  --  24
			//    Deficiente  Inferior	  Promedio	  Superior	  Excelente
			
			if ($mas_oac<7) {
				$pentil_oac=1; $promedio_oac="Deficiente"; $color_oac="#ff0000";
			} elseif (($mas_oac>6 && $mas_oac<12)) {
				$pentil_oac=2; $promedio_oac="Inferior"; $color_oac="#ff99cc";
			} elseif (($mas_oac>11 && $mas_oac<16)) {
				$pentil_oac=3; $promedio_oac="Promedio"; $color_oac="#ffff00";
			} elseif (($mas_oac>15 && $mas_oac<19)) {
				$pentil_oac=4; $promedio_oac="Superior"; $color_oac="#99cc00";
			} elseif (($mas_oac>18)) {
				$pentil_oac=5; $promedio_oac="Excelente"; $color_oac="#008000";
			}
			
			//Relaciones
			//       1           2           3          4           5
			//  < 0  --  5	 6  --  11	12  --  17	18  --  20	21  --  24
			//    Deficiente  Inferior	  Promedio	  Superior	  Excelente			
			if ($mas_rel<6) {
				$pentil_rel=1; $promedio_rel="Deficiente"; $color_rel="#ff0000";
			} elseif (($mas_rel>6 && $mas_rel<12)) {
				$pentil_rel=2; $promedio_rel="Inferior"; $color_rel="#ff99cc";
			} elseif (($mas_rel>11 && $mas_rel<18)) {
				$pentil_rel=3; $promedio_rel="Promedio"; $color_rel="#ffff00";
			} elseif (($mas_rel>17 && $mas_rel<21)) {
				$pentil_rel=4; $promedio_rel="Superior"; $color_rel="#99cc00";
			} elseif (($mas_rel>20)) {
				$pentil_rel=5; $promedio_rel="Excelente"; $color_rel="#008000";
			}
			
			//Responsabilidad
			//       1           2           3          4           5
			//   < 0  --  5	 6  --  11	12  --  17	18  --  19	20  --  24
			//    Deficiente  Inferior	  Promedio	  Superior	  Excelente					
			if ($mas_res<6) {
				$pentil_res=1; $promedio_res="Deficiente"; $color_res="#ff0000";
			} elseif (($mas_res>5 && $mas_res<12)) {
				$pentil_res=2; $promedio_res="Inferior"; $color_res="#ff99cc";
			} elseif (($mas_res>13 && $mas_res<18)) {
				$pentil_res=3; $promedio_res="Promedio"; $color_res="#ffff00";
			} elseif (($mas_res>17 && $mas_res<20)) {
				$pentil_res=4; $promedio_res="Superior"; $color_res="#99cc00";
			} elseif (($mas_res>19)) {
				$pentil_res=5; $promedio_res="Excelente"; $color_res="#008000";
			}
			
			//Logro
			//       1           2           3          4           5
			//    < 0  --  6	 7  --  13	14  --  18	19  --  21	22  --  24
			//    Deficiente  Inferior	  Promedio	  Superior	  Excelente					
			if ($mas_log<7) {
				$pentil_log=1; $promedio_log="Deficiente"; $color_log="#ff0000";
			} elseif (($mas_log>6 && $mas_log<14)) {
				$pentil_log=2; $promedio_log="Inferior"; $color_log="#ff99cc";
			} elseif (($mas_log>13 && $mas_log<19)) {
				$pentil_log=3; $promedio_log="Promedio"; $color_log="#ffff00";
			} elseif (($mas_log>18 && $mas_log<22)) {
				$pentil_log=4; $promedio_log="Superior"; $color_log="#99cc00";
			} elseif (($mas_log>21)) {
				$pentil_log=5; $promedio_log="Excelente"; $color_log="#008000";
			}			
			
			//1  -- 1,75	1,76  --  2,74	2,75  --  3,50	3,51  --  4,25	4,26  --  5
			$pentil_ipd=0;
			$pentil_ipd=($pentil_ra+$pentil_rv+$pentil_hn+$pentil_co)/4;
			if ($pentil_ipd<1.76) {
				$promedio_ipd="Deficiente";
				$color_ipd="#ff0000";
			} elseif ($pentil_ipd>1.75 && $pentil_ipd<2.75) {
				$promedio_ipd="Inferior";
				$color_ipd="#ff99cc";
			} elseif ($pentil_ipd>2.74 && $pentil_ipd<3.51) {
				$promedio_ipd="Promedio";
				$color_ipd="#ffff00";
			} elseif ($pentil_ipd>3.50 && $pentil_ipd<4.26) {
				$promedio_ipd="Superior";
				$color_ipd="#99cc00";
			} elseif ($pentil_ipd>4.25 && $pentil_ipd<5.1) {
				$promedio_ipd="Excelente";
				$color_ipd="#008000";
			}
			
			$tabla .= '
					<tr id="indice">
						<td align="left"><strong>Indice del Potencial de Desempeño</strong></td>
						<td>&nbsp;</td>
						<td align="center">'.$pentil_ipd.'</td>
						<td align="center"style="background-color:'.$color_ipd.'">'.$promedio_ipd.'</td>
					</tr>
				</table>
			';
			
			// 1  --  1,67	1,68  --  2,66	2,67  --  3,67	3,68  --  4,33	4,34  --  5			
			$color_ioe="#ff0000";
			$pentil_ioe=($pentil_oac+$pentil_rel+$pentil_rel+$pentil_log)/4;
			//echo "$pentil_oac+$pentil_rel+$pentil_rel+$pentil_log....$pentil_ioe"; return;
			if ($pentil_ioe<1.68) {
				$promedio_ioe="Deficiente";
				$color_ioe="#ff0000";
			} elseif ($pentil_ioe>1.67 && $pentil_ioe<2.68) {
				$promedio_ioe="Inferior";
				$color_ioe="#ff99cc";
			} elseif ($pentil_ioe>2.66 && $pentil_ioe<3.68) {
				$promedio_ioe="Promedio";
				$color_ioe="#ffff00";
			} elseif ($pentil_ioe>3.67 && $pentil_ioe<4.34) {
				$promedio_ioe="Superior";
				$color_ioe="#99cc00";
			} elseif ($pentil_ioe>4.33 && $pentil_ioe<5.1) {
				$promedio_ioe="Excelente";
				$color_ioe="#008000";
			}
			
			$tabla .= '
			<table>
				<tr>
					<th align="left">&nbsp;</th>
					<th align="center">Puntaje Bruto</th>
					<th align="center">Pentil</th>
					<th align="center">Categoría</th>
				</tr>
        <tr>
            <td align="left">Orientacion al Cliente</td>
            <td align="center">'.$mas_oac.'</td>
            <td align="center">'.$pentil_oac.'</td>
            <td align="center" style="background-color:'.$color_oac.'">'.$promedio_oac.'</td>
        </tr>
        <tr>
            <td align="left">Relaciones</td>
            <td align="center">'.$mas_rel.'</td>
            <td align="center">'.$pentil_rel.'</td>
            <td align="center" style="background-color:'.$color_rel.'">'.$promedio_rel.'</td>
        </tr>			
        <tr>
            <td align="left">Responsabilidad</td>
            <td align="center">'.$mas_res.'</td>
            <td align="center">'.$pentil_res.'</td>
            <td align="center" style="background-color:'.$color_res.'">'.$promedio_res.'</td>
        </tr>		
        <tr>
            <td align="left">Necesidad de Logro</td>
            <td align="center">'.$mas_log.'</td>
            <td align="center">'.$pentil_log.'</td>
            <td align="center" style="background-color:'.$color_log.'">'.$promedio_log.'</td>
        </tr>	
        <tr id="indice">
            <td align="left">Indice de Orientacion al Exito</td>
            <td align="center"></td>
            <td align="center">'.$pentil_ioe.'</td>
            <td align="center" style="background-color:'.$color_ioe.'">'.$promedio_ioe.'</td>
        </tr>		
</table>		
';
			
			// 1  --  1,90	1,91  --  2,70	2,71  --  3,39	3,40  --  4,05	4,06  --  5
			$pentil_cons=($pentil_ipd+$pentil_ioe)/2;
			
			if ($pentil_cons<1.91) {
				$promedio_cons="Deficiente";
				$color_cons="#ff0000";
			} elseif ($pentil_cons>1.90 && $pentil_cons<2.71) {
				$promedio_cons="Inferior";
				$color_cons="#ff99cc";
			} elseif ($pentil_cons>2.70 && $pentil_cons<3.40) {
				$promedio_cons="Promedio";
				$color_cons="#ffff00";
			} elseif ($pentil_cons>3.39 && $pentil_cons<4.06) {
				$promedio_cons="Superior";
				$color_cons="#99cc00";
			} elseif ($pentil_cons>4.05 && $pentil_cons<5.1) {
				$promedio_cons="Excelente";
				$color_cons="#008000";
			}
			
$tabla .= '		
	<table>
        <tr id="indice">
            <td align="left">PERFIL CONSOLIDADO</td>
            <td align="center">'.$pentil_cons.'</td>
            <td align="center" style="background-color:'.$color_cons.'">'.$promedio_cons.'</td>
        </tr>		
	</table>
	
	<div id="footer"> Baremo General 2017</div>';
		
		//EncuestaControllers::generar_pdf_hi($tabla_pdf, $id_au);
		return view('prueba_epa.resultado_epa',["tabla"=>$tabla]);
	}

}