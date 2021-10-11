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

class EncuestaControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /periodicos
     *
     * @return Response
     */
    public function index($id)
    {       
		return view('encuesta.encuesta_reporte',["id_tipo_prueba"=>$id,"cedula"=>0]);
    }
	
	public function consultar_encuesta(Request $request) {
		//dd($request->all());
		//16/7/2016 - 16/7/2016
		$fecha_reporte1=$request->fecha_reporte1;
		$fecha_reporte2=$request->fecha_reporte2;
		$id_tipo_prueba=$request->id_tipo_prueba;
				
		return view('encuesta.encuesta_reporte',["fecha_reporte1"=>$fecha_reporte1, "fecha_reporte2"=>$fecha_reporte2, "cedula"=>$request->cedula,"id_tipo_prueba"=>$id_tipo_prueba]);
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
		
		/************************* EMAIL A ENVIAR ***************************/
		if ($entro==0) {
			  Mail::send('correo.encuesta_respuesta', ["candidato"=>$candidato,"perfil"=>$perfil], function($message) use($email, $candidato, $id_candidato, $recibe)
				{
					if ($recibe==1) {
						$message->to($email, $candidato)->subject('Presentacion prueba IOL - Alternativa')
								->attach('pdf/'.$id_candidato.'.pdf');
					}
					$message->bcc("jeleicy@gmail.com", $candidato)->subject('Presentacion prueba IOL - Alternativa')
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
						id_usuario_asignado=".$id_invitador;

				$data = DB::select($sqlBusqueda);
				echo $sqlBusqueda; return;
				$i=0;
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
				$sqlBusqueda.= "id_empresa=".$id_empresas;
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
			echo $sql;
			DB::update($sql);
			
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
			//return Redirect::route('encuesta_respuesta');		
			
			$candidato=strtoupper($request->nombres." ".$request->apellidos);
			
			$this->generar_pdf($id_candidato.",".$fecha_act.",1");
			
			/************************* EMAIL A ENVIAR ***************************/
			if ($perfil!="Invalido") {
				if ($entro==0) {
					  Mail::send('correo.encuesta_respuesta', ["candidato"=>$candidato,"perfil"=>$perfil], function($message) use($email, $candidato, $id_candidato, $recibe)
						{
							if ($recibe==1) {
								$message->to($email, $candidato)->subject('Presentacion prueba IOL')
										->attach('pdf/'.$id_candidato.'.pdf');
							}
							$message->bcc("jeleicy@gmail.com", $candidato)->subject('Presentacion prueba IOL')
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
		}
    }
	
	public function reenviar_pdf($id, Request $request) {
		//dd($id);
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
			$message->to($email, $candidato)->subject('Reenvio prueba IOL')
					->attach('pdf/'.$id_candidato.'.pdf');
			$message->bcc("jeleicy@gmail.com", $candidato)->subject('Reenvio prueba IOL')
					->attach('pdf/'.$id_candidato.'.pdf');					
		});
		return view('encuesta.encuesta_reporte',["id_tipo_prueba"=>1,"cedula"=>0]);
	}
	
	public function generar_pdf($valores) {
		$id_candidato=substr($valores,0,strpos($valores,","));
		$valores=substr($valores,strpos($valores,",")+1);
		$fecha=substr($valores,0,strpos($valores,","));
		$valores=substr($valores,strpos($valores,",")+1);
		$nro_prueba=$valores;
		
        $data = $this->getData($id_candidato,$fecha,$nro_prueba);
        $date = date('Y-m-d');
        $invoice = "2222";
			
		if ($data["perfil"]=="")
			$data["perfil"]="invalido";
		
        $view =  \View::make('pdf.'.strtolower($data["perfil"]), compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		$pdf->save("pdf/".$id_candidato.".pdf");

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
		
		$sql = "select * from candidatos where id_autorizacion=".$id_au;
		$data=DB::select($sql);
		
		foreach ($data as $data) {
			$id_candidato=$data->id;
			$email=$data->email;
			$candidato=$data->nombres." ".$data->apellidos;
		}
		
		$data= ['tabla'=>$tabla];
					
        $view =  \View::make('pdf.reporte_hi', compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		$pdf->save("pdf/hi/".$id_candidato.".pdf");
		
		/*Mail::send('correo.encuesta_hi',["candidato"=>$candidato], function($message) use($email, $candidato, $id_candidato)
		{
			$message->to($email, $candidato)->subject('Presentacion prueba HI')
					->attach('pdf/hi/'.$id_candidato.'.pdf');
					
			$message->bcc("jeleicy@gmail.com", $candidato)->subject('Presentacion prueba HI')
					->attach('pdf/hi/'.$id_candidato.'.pdf');							
		});*/

        return $pdf->stream($id_candidato.".pdf");
	}
	
	public function aplicar_encuesta($id) {
		$sql = "select nombres, apellidos, email from candidatos where id_autorizacion=$id";

		$data=DB::select($sql);
		
		$nombre="";
		$apellido="";
		$email="";
		
		foreach ($data as $data) {
			$nombre=$data->nombres;
			$apellido=$data->apellidos;
			$email=$data->email;
		}
		
		$sql = "select * from autorizaciones where id=$id";
		//echo $sql; return;
		$data=DB::select($sql);
		if (empty($data))
			$prueba="encuesta.ya_presento_encuesta";
		else {
			foreach ($data as $data) {
				if ($data->presento==0) {
					$id_tipo_prueba=$data->id_tipo_prueba;
					if ($nombre=="") {
						if (strpos($data->nombre_evaluado," ") !== false) {
							$nombre=substr($data->nombre_evaluado,0,strpos($data->nombre_evaluado," "));
							$apellido=substr($data->nombre_evaluado,strpos($data->nombre_evaluado," ")+1);
						} else 
							$nombre=$data->nombre_evaluado;
						$email=$data->correo_evaluado;
					}
					$prueba="encuesta.encuesta_".$id_tipo_prueba;				
				} else {
					$prueba="encuesta.ya_presento_encuesta";
				}
			}
		}
		return view($prueba,["nombre"=>$nombre, "apellido"=>$apellido, "email"=>$email, "id_au"=>$id]);
	}
	
	public function aplicar_encuesta_iol_alt($id) {
		$sql = "select * from candidatos where id_autorizacion=$id";

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
		}
		
		$sql = "select * from autorizaciones where id=$id";
		$data=DB::select($sql);
		foreach ($data as $data) {
			$autorizaciones_iol_alt = new autorizaciones_iol_alt();
			
			$autorizaciones_iol_alt->id_empresas=$data->id_empresas;
			$autorizaciones_iol_alt->id_usuario=$data->id_usuario;
			$autorizaciones_iol_alt->id_invitador=$data->id_invitador;
			$autorizaciones_iol_alt->id_tipo_prueba=$data->id_tipo_prueba;
			$autorizaciones_iol_alt->nombre_evaluado=$data->nombre_evaluado;
			$autorizaciones_iol_alt->correo_evaluado=$data->correo_evaluado;
			$autorizaciones_iol_alt->fecha=$data->fecha;
			$autorizaciones_iol_alt->presento=0;
			$autorizaciones_iol_alt->id_candidato=$id_candidato;
			$autorizaciones_iol_alt->save();
		}
		return view("encuesta.encuesta_iol_alt",["nombre"=>$nombre, "apellido"=>$apellido, "cedula"=>$cedula, "email"=>$email, "id_au"=>$autorizaciones_iol_alt->id]);
	}
	
	public function prueba_hl ($id) {
		$sql = "select count(id) as cantidad from pruebas_presentadas where id_autorizacion=$id";
		$data=DB::select($sql);
		$cantidad=0;
		$mensaje="";
		
		/*$sql = "truncate respuestas_hl";
		DB::select($sql);
		$sql = "truncate pruebas_presentadas";
		DB::select($sql);*/
		
		if (empty($data)) {
			/*$sql = "truncate respuestas_hl";
			DB::select($sql);
			$sql = "truncate pruebas_presentadas";
			DB::select($sql);*/

			$sql = "insert into pruebas_presentadas (id_autorizacion) values($id)";
			DB::insert($sql);
		} else {
			foreach($data as $data)
				$cantidad=$data->cantidad;
			if ($cantidad==3)
				$mensaje="Ya ud presento esta prueba o ya supero el numero de ingresos a la misma";
			else {
				$sql = "insert into pruebas_presentadas (id_autorizacion) values($id)";
				DB::insert($sql);
			}
		}
		return view('prueba_hl.encuesta_3',["mensaje"=>$mensaje,"id_au"=>$id,"nombre"=>'', "apellido"=>'', "cedula"=>'', "email"=>'']);
	}

}