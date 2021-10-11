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
use App\tipos_pruebas;
use App\Http\Controllers\FuncionesControllers;

class PagosControllers extends Controller {

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
	
	
	public function exitoso_iol($id) {
		return view('pagos.exitoso_iol',["id_idioma"=>$id]);
	}	

	public function guardar_pago_exitodo (Request $request) {
		$datos=$request->all();
		//dd($datos);
			
		$today = @getdate();
		
		$dia = $today["mday"];
		$mes = $today["mon"];
		$ano = $today["year"];
		$fecha_act = $ano."-".$mes."-".$dia;
		
		if ($request->id_tipo_prueba==1) {
			$candidato = new candidato($request->all());

			Session::put("mensaje","");

			$sql = "select * from candidatos where email='".$request->email."'";
			$data=DB::select($sql);
			if (empty($data)) {
				$candidato->nombres=$request->nombres_1;
				$candidato->apellidos=$request->apellidos_1;
				$candidato->email=$request->email_1;
				$candidato->recibe=1;
				$candidato->save();
				
				$id_candidato=$candidato->id;
			} else {
				foreach ($data as $data)
					$id_candidato=$data->id;
			}			
			
			$autorizaciones = new autorizaciones();
			$autorizaciones->id_empresas=7;
			$autorizaciones->id_usuario=$id_candidato;
			$autorizaciones->id_invitador=1;
			$autorizaciones->id_tipo_prueba=$request->id_tipo_prueba;
			$autorizaciones->nombre_evaluado=$request->nombres_1." ".$request->apellidos_1;
			$autorizaciones->correo_evaluado=$request->email_1;
			$autorizaciones->fecha=$fecha_act;
			$autorizaciones->id_idioma=$request->id_idioma;
			$autorizaciones->presento=0;
			$autorizaciones->save();
			
			$id_idioma=$request->id_idioma;
			
			$sql = "update candidatos set id_autorizacion=".$autorizaciones->id." where id=".$id_candidato;
			DB::update($sql);
			
			//FuncionesControllers::actualizar_pruebas_asignadas($request->id_tipo_prueba,'invitacion', 0);
			
			$email=$request->email_1;
			$nombres=$request->nombres_1." ".$request->apellidos_1;
			
			$tipo_prueba=$request->id_tipo_prueba;
			
			$texto_email="Usted se encuentra invitado para realizar el Inventario de Orientación 
					Laboral (IOL)
					<br /><br />
					Estamos agradecidos de antemano de contar con su participación en el mismo, 
					al finalizar el inventario, podrá contar con su Perfil de Orientación Laboral.
					<br /><br />
					Para acceder debe ingresar 
					<a target='_blank' href='http://".$_SERVER["HTTP_HOST"]."/encuestas/public/aplicar_encuesta/".$autorizaciones->id."'>Encuesta</a><br /><br />
				";
				
			$sql = "select * from correo c, correo_autorizacion ca 
						where c.id=ca.id_correo and ca.tipo=c.tipo and 
							c.id_empresa=7 and ca.tipo='E' and 
							ca.id_autorizacion=".$autorizaciones->id." and c.id_idioma=".$id_idioma;
			$data_correo=DB::select($sql);
			$texto_correo="";
			$asunto_correo="";
			foreach ($data_correo as $data_correo) {
				$texto_correo=$data_correo->texto;
				$asunto_correo=$data_correo->asunto;
			}				
				
			$sql = "select tipo from idioma where id=".$id_idioma;
			$data=DB::select($sql);
			foreach ($data as $data)
				\App::setLocale($data->tipo);
							
			/************************* EMAIL A ENVIAR ***************************/
			Mail::send('correo.invitacion_iol', ["email"=>$email, "nombres"=>$nombres, "texto_email"=>$texto_email], function($message) use($datos, $email, $tipo_prueba, $nombres)
				{
					$message->to($email, $nombres)->subject('Invitacion a prueba '.$tipo_prueba);
					$message->to("jeleicy@gmail.com", $nombres)->subject('Invitacion a prueba '.$tipo_prueba);
					$message->to("feedback@talentskey.com", $nombres)->subject('Invitacion a prueba '.$tipo_prueba);
				});
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
				$usuario->id_empresas=7;
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
					$autorizaciones->id_empresas=7;
					$autorizaciones->id_usuario=$id_usuario;
					$autorizaciones->id_invitador=1;
					$autorizaciones->id_tipo_prueba=$request->id_tipo_prueba;
					$autorizaciones->nombre_evaluado=$nombre;
					$autorizaciones->correo_evaluado=$value;
					$autorizaciones->fecha=$fecha_act;
					$autorizaciones->presento=0;
					$autorizaciones->save();
					
					$link = "http://".$_SERVER["HTTP_HOST"]."/encuestas/public/aplicar_encuesta/".$autorizaciones->id;
					
					$texto_email.="<li>Evaluado: ".strtoupper($nombre).". Link: <a href='".$link."'>Encuesta</a></li>";
				}
			}
			$texto_email.="</ul>";
			
			$datos=$request->all();	
			
			//FuncionesControllers::actualizar_pruebas_asignadas($request->id_tipo_prueba,'invitacion', 0);
			
			$nombres=$request->nombres_2;
			$email=$request->email_2;
			$tipo_prueba=$request->tipo_prueba;
			
			//echo $texto_email;
			
			/************************* EMAIL A ENVIAR ***************************/
			Mail::send('correo.invitacion', ["email"=>$email, "nombres"=>$nombres, "texto_email"=>$texto_email], function($message) use($datos, $email, $tipo_prueba, $nombres)
				{
					$message->to($email, $nombres)->subject('Invitacion a prueba '.$tipo_prueba);
					$message->to("jeleicy@gmail.com", $nombres)->subject('Invitacion a prueba '.$tipo_prueba);
					$message->to("feedback@talentskey.com", $nombres)->subject('Invitacion a prueba '.$tipo_prueba);
				});
			/************************* EMAIL A ENVIAR ***************************/				
		}
		
		$array_tipos_pruebas="";
		$sql = "select * from tipos_pruebas order by 2";
		$data=DB::select($sql);
		foreach ($data as $data)
			$array_tipos_pruebas[$data->id]=$data->nombre;
			
		//echo $texto_email;		
		return view('pruebas.enviar_prueba', ["nombres"=>$request->nombres, "apellidos"=>$request->apellidos, "usuario"=>$request->email, "mensaje" => "La invitacion a la prueba ".$array_tipos_pruebas[$request->id_tipo_prueba]." para ".$nombres.", ha sido enviada satisfactoriamente."]);		
	}
		
}