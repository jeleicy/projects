<?php

use App\candidato;
use App\Http\Controllers\EncuestaControllers;
use App\Http\Controllers\FuncionesControllers;

use App\contenidos_campos;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

	Route::get('/', function () {
		return view('encuesta.login',["mensaje"=>""]);
	});

	Route::get('encuesta/{id}', array(
        'as' => 'encuesta',
        'uses' => 'EncuestaControllers@encuesta'
	));

    Route::post('guardar_encuesta', array(
        'as' => 'guardar_encuesta',
        'uses' => 'EncuestaControllers@guardar_encuesta'
    ));	
	
    Route::post('guardar_encuesta_ejemplo', array(
        'as' => 'guardar_encuesta_ejemplo',
        'uses' => 'EncuestaControllers@guardar_encuesta_ejemplo'
    ));		
	
    Route::post('guardar_encuesta_iol_alt', array(
        'as' => 'guardar_encuesta_iol_alt',
        'uses' => 'EncuestaControllers@guardar_encuesta_iol_alt'
    ));		
	
    Route::get('aplicar_encuesta/{id}', array(
        'as' => 'aplicar_encuesta',
        'uses' => 'EncuestaControllers@aplicar_encuesta'
    ));
	
    Route::get('aplicar_encuesta_iol_alt/{id}', array(
        'as' => 'aplicar_encuesta_iol_alt',
        'uses' => 'EncuestaControllers@aplicar_encuesta_iol_alt'
    ));	
	
    Route::get('encuesta_reporte/{id}', array(
        'as' => 'encuesta_reporte',
        'uses' => 'EncuestaControllers@index'
    ));
	
    Route::get('consultar_encuesta_general', array(
        'as' => 'consultar_encuesta_general',
        'uses' => 'EncuestaControllers@consultar_encuesta_general'
    ));
	
    Route::get('consultar_encuesta', array(
        'as' => 'consultar_encuesta',
        'uses' => 'EncuestaControllers@consultar_encuesta'
    )); 	
	
    Route::get('datos_participante/{id}', array(
        'as' => 'datos_participante',
        'uses' => 'EncuestaControllers@datos_participante'
    ));
	
    Route::get('guardar_datos_participante', array(
        'as' => 'guardar_datos_participante',
        'uses' => 'EncuestaControllers@guardar_datos_participante'
    ));
	
    Route::get('generar_pdf/{id}', array(
        'as' => 'generar_pdf',
        'uses' => 'EncuestaControllers@generar_pdf'
    )); 	
	
	Route::get('reenviar_pdf/{id}', array(
        'as' => 'reenviar_pdf',
        'uses' => 'EncuestaControllers@reenviar_pdf'
    ));

	/*USUARIOS*/
	
    Route::post('verificar_usuario', array(
        'as' => 'verificar_usuario',
        'uses' => 'UsuariosControllers@verificar_usuario'
    ));	
	
    Route::get('salida', array(
        'as' => 'salida',
        'uses' => 'UsuariosControllers@salida'
    ));	
	
	Route::get('crear_usuario', function () {
		return view('usuarios.nuevo',["mensaje"=>""]);
	});
	
    Route::post('guardar_usuario_nuevo', array(
        'as' => 'guardar_usuario_nuevo',
        'uses' => 'UsuariosControllers@guardar_usuario_nuevo'
    ));	
	
    Route::put('guardar_usuario_edicion', array(
        'as' => 'guardar_usuario_edicion',
        'uses' => 'UsuariosControllers@guardar_usuario_edicion'
    ));
	
    Route::get('consultar_usuario', array(
        'as' => 'consultar_usuario',
        'uses' => 'UsuariosControllers@index'
    ));	
	
    Route::get('consultarusuario/{id}', array(
        'as' => 'consultarusuarios',
        'uses' => 'UsuariosControllers@consultarusuarios'
    )); 
	
    Route::get('cambiar_contrasena', array(
        'as' => 'cambiar_contrasena',
        'uses' => 'UsuariosControllers@cambiar_contrasena'
    ));	
	
    Route::post('guardar_cambiar_contrasena', array(
        'as' => 'guardar_cambiar_contrasena',
        'uses' => 'UsuariosControllers@guardar_cambiar_contrasena'
    ));	
	
    Route::get('setearpass/{id}', array(
        'as' => 'setearpass',
        'uses' => 'UsuariosControllers@setearpass'
    ));	
	
	/*CORREOS*/
	Route::get('crear_correo', function () {
		return view('correo.nuevo',["mensaje"=>""]);
	});
	
    Route::post('guardar_correo_nuevo', array(
        'as' => 'guardar_correo_nuevo',
        'uses' => 'CorreoControllers@guardar_correo_nuevo'
    ));	
	
    Route::put('guardar_correo_edicion', array(
        'as' => 'guardar_correo_edicion',
        'uses' => 'CorreoControllers@guardar_correo_edicion'
    ));
	
    Route::get('consultar_correo', array(
        'as' => 'consultar_correo',
        'uses' => 'CorreoControllers@index'
    ));	
	
    Route::get('consultarcorreos/{id}', array(
        'as' => 'consultarcorreos',
        'uses' => 'CorreoControllers@consultarcorreos'
    ));	
	
	/*BATERIAS*/
	Route::get('crear_bateria', function () {
		return view('bateria.nuevo',["mensaje"=>""]);
	});
	
    Route::post('guardar_bateria_nuevo', array(
        'as' => 'guardar_bateria_nuevo',
        'uses' => 'BateriaControllers@guardar_bateria_nuevo'
    ));	
	
    Route::put('guardar_bateria_edicion', array(
        'as' => 'guardar_bateria_edicion',
        'uses' => 'BateriaControllers@guardar_bateria_edicion'
    ));
	
    Route::get('consultar_bateria', array(
        'as' => 'consultar_bateria',
        'uses' => 'BateriaControllers@index'
    ));	
	
    Route::get('consultarbaterias/{id}', array(
        'as' => 'consultarbaterias',
        'uses' => 'BateriaControllers@consultarbaterias'
    ));	
	
	/*CAMPOS ADICIONALES CANDIDATOS*/
	Route::get('crear_campos', function () {
		return view('campos.nuevo',["mensaje"=>""]);
	});
	
    Route::post('guardar_campos_nuevo', array(
        'as' => 'guardar_campos_nuevo',
        'uses' => 'CamposControllers@guardar_campos_nuevo'
    ));	
	
    Route::put('guardar_campos_edicion', array(
        'as' => 'guardar_campos_edicion',
        'uses' => 'CamposControllers@guardar_campos_edicion'
    ));
	
    Route::get('consultar_campos', array(
        'as' => 'consultar_campos',
        'uses' => 'CamposControllers@index'
    ));	
	
    Route::get('consultarcampos/{id}', array(
        'as' => 'consultarcampos',
        'uses' => 'CamposControllers@consultarcampos'
    ));		
	
	/*TEXTO DE ACEPTACION*/
	Route::get('crear_texto_aceptacion', function () {
		return view('texto_aceptacion.nuevo',["mensaje"=>""]);
	});
	
    Route::post('guardar_texto_aceptacion_nuevo', array(
        'as' => 'guardar_texto_aceptacion_nuevo',
        'uses' => 'GrupoCandidatosControllers@guardar_texto_aceptacion_nuevo'
    ));	
	
    Route::put('guardar_texto_aceptacion_edicion', array(
        'as' => 'guardar_texto_aceptacion_edicion',
        'uses' => 'GrupoCandidatosControllers@guardar_texto_aceptacion_edicion'
    ));
	
    Route::get('consultar_texto_aceptacion', array(
        'as' => 'consultar_texto_aceptacion',
        'uses' => 'GrupoCandidatosControllers@index'
    ));	
	
    Route::get('consultartexto_aceptacion/{id}', array(
        'as' => 'consultartexto_aceptacion',
        'uses' => 'GrupoCandidatosControllers@consultartexto_aceptacion'
    ));		
	
	/*GRUPO DE CANDIDATOS*/
	Route::get('crear_grupo_candidatos', function () {
		return view('grupo_candidatos.nuevo',["mensaje"=>""]);
	});
	
    Route::post('guardar_grupo_candidatos_nuevo', array(
        'as' => 'guardar_grupo_candidatos_nuevo',
        'uses' => 'GrupoCandidatosControllers@guardar_grupo_candidatos_nuevo'
    ));	
	
    Route::put('guardar_grupo_candidatos_edicion', array(
        'as' => 'guardar_grupo_candidatos_edicion',
        'uses' => 'GrupoCandidatosControllers@guardar_grupo_candidatos_edicion'
    ));
	
    Route::get('consultar_grupo_candidatos', array(
        'as' => 'consultar_grupo_candidatos',
        'uses' => 'GrupoCandidatosControllers@index'
    ));	
	
    Route::get('consultargrupo_candidatos/{id}', array(
        'as' => 'consultargrupo_candidatos',
        'uses' => 'GrupoCandidatosControllers@consultargrupo_candidatos'
    ));	
	
	/*INSTRUCCIONES*/
	Route::get('crear_instrucciones', function () {
		return view('instrucciones.nuevo',["mensaje"=>""]);
	});
	
    Route::post('guardar_instrucciones_nuevo', array(
        'as' => 'guardar_instrucciones_nuevo',
        'uses' => 'InstruccionesControllers@guardar_instrucciones_nuevo'
    ));	
	
    Route::put('guardar_instrucciones_edicion', array(
        'as' => 'guardar_instrucciones_edicion',
        'uses' => 'InstruccionesControllers@guardar_instrucciones_edicion'
    ));
	
    Route::get('consultar_instrucciones', array(
        'as' => 'consultar_instrucciones',
        'uses' => 'InstruccionesControllers@index'
    ));	
	
    Route::get('consultarinstrucciones/{id}', array(
        'as' => 'consultarinstrucciones',
        'uses' => 'InstruccionesControllers@consultarinstrucciones'
    ));

	/*PREGUNTAS / OPCIONES*/
	Route::get('crear_preguntas_opciones', function () {
		return view('preguntas_opciones.nuevo',["mensaje"=>""]);
	});
	
    Route::post('guardar_preguntas_opciones_nuevo', array(
        'as' => 'guardar_preguntas_opciones_nuevo',
        'uses' => 'PreguntasOpcionesControllers@guardar_preguntas_opciones_nuevo'
    ));	
	
    Route::put('guardar_preguntas_opciones_edicion', array(
        'as' => 'guardar_preguntas_opciones_edicion',
        'uses' => 'PreguntasOpcionesControllers@guardar_preguntas_opciones_edicion'
    ));
	
    Route::get('consultar_preguntas_opciones', array(
        'as' => 'consultar_preguntas_opciones',
        'uses' => 'PreguntasOpcionesControllers@index'
    ));	
	
    Route::get('consultarpreguntasopciones/{id}', array(
        'as' => 'consultarpreguntasopciones',
        'uses' => 'PreguntasOpcionesControllers@consultarpreguntasopciones'
    ));			
	
	/*EMPRESAS*/
	Route::get('crear_empresa', function () {
		return view('empresa.nuevo',["mensaje"=>""]);
	});
	
    Route::post('guardar_empresa_nuevo', array(
        'as' => 'guardar_empresa_nuevo',
        'uses' => 'EmpresaControllers@guardar_empresa_nuevo'
    ));	
	
    Route::put('guardar_empresa_edicion', array(
        'as' => 'guardar_empresa_edicion',
        'uses' => 'EmpresaControllers@guardar_empresa_edicion'
    ));
	
    Route::get('consultar_empresa', array(
        'as' => 'consultar_empresa',
        'uses' => 'EmpresaControllers@index'
    ));	
	
    Route::get('consultarempresa/{id}', array(
        'as' => 'consultarempresas',
        'uses' => 'EmpresaControllers@consultarempresas'
    ));
	
	Route::get('consultar_candidato', array(
        'as' => 'consultar_candidato',
        'uses' => 'PotencialControllers@consultar_candidato'
    ));	
	
	/*PRUEBAS*/
	
	Route::get('invitar', array(
        'as' => 'invitar',
        'uses' => 'PruebasControllers@invitar'
    ));
	
	Route::post('recordar', array(
        'as' => 'recordar',
        'uses' => 'PruebasControllers@recordar'
    ));
	
	Route::post('guardar_invitacion', array(
        'as' => 'guardar_invitacion',
        'uses' => 'PruebasControllers@guardar_invitacion'
    ));
	
	Route::post('generar_pdf_hi_reporte/{id}', array(
        'as' => 'generar_pdf_hi_reporte',
        'uses' => 'EncuestaControllers@generar_pdf_hi_reporte'
    ));
	
	Route::get('crear_asignacion', function () {
		return view('pruebas.crear_asignacion',["mensaje"=>"", "tipo"=>""]);
	});
	
	Route::post('guardar_asignacion', array(
        'as' => 'guardar_asignacion',
        'uses' => 'PruebasControllers@guardar_asignacion'
    ));
	
	Route::get('consultar_asignacion', function () {
		return view('pruebas.consultar_asignacion', ["mensaje"=>""]);
	});
	
	Route::post('consultar_asignacion2', array (
        'as' => 'consultar_asignacion2',
        'uses' => 'PruebasControllers@consultar_asignacion2'
	));		
	
	Route::post('comprar_prueba', function () {
		return view('pagos.pagos', ["mensaje"=>""]);
	});	
	
	Route::get('invitar_consultar', array(
        'as' => 'invitar_consultar',
        'uses' => 'PruebasControllers@invitar_consultar'
    ));	
	
	/*PAGOS*/
	
	Route::get('pagos', function () {
		return view('pagos.pagos');
	});	
	
	Route::get('proceso', function () {
		return view('pagos.proceso');
	});
	
	Route::get('exitoso_iol/{id}', array(
        'as' => 'exitoso_iol',
        'uses' => 'PagosControllers@exitoso_iol'
    ));	
	
	Route::post('guardar_pago_exitodo', array(
        'as' => 'guardar_pago_exitodo',
        'uses' => 'PagosControllers@guardar_pago_exitodo'
    ));
	
	/*PRUEBAS*/
	
	Route::get('crear_pruebas', function () {
		return view('pruebas.crear', ["mensaje"=>""]);
	});	
	
	Route::post('guardar_prueba', array(
        'as' => 'guardar_prueba',
        'uses' => 'PruebasControllers@guardar_prueba'
    ));
	
	Route::post('guardar_prueba_edicion', array(
        'as' => 'guardar_prueba_edicion',
        'uses' => 'PruebasControllers@guardar_prueba_edicion'
    ));	
	
	Route::get('consultar_pruebas', function () {
		return view('pruebas.consulta', ["mensaje"=>""]);
	});
	
	Route::get('consultarprueba/{id}', array(
        'as' => 'consultarprueba',
        'uses' => 'PruebasControllers@consultarprueba'
    ));
	
    Route::post('consultar_invitacion2', array(
        'as' => 'consultar_invitacion2',
        'uses' => 'PruebasControllers@consultar_invitacion2'
    ));

	Route::post('consultar_evaluadores2', array(
        'as' => 'consultar_evaluadores2',
        'uses' => 'PruebasControllers@consultar_evaluadores2'
    ));
	
	Route::get('dashboard', function () {
		return view('encuesta.dashboard');
	});
	
	Route::get('consultar_evaluadores', function () {
		return view('pruebas.consultar_evaluadores', ["mensaje"=>""]);
	});	
	
	/********PRUEBA HL********/
	
	Route::get('prueba_hi/{id}', array(
       'as' => 'prueba_hi',
       'uses' => 'EncuestaControllers@prueba_hi'
	));
	
	Route::get('prueba_hic/{id}', array(
       'as' => 'prueba_hic',
       'uses' => 'EncuestaControllers@prueba_hi'
	));	
	
	Route::get('prueba_hi_resto/{id}', array(
       'as' => 'prueba_hi_resto',
       'uses' => 'EncuestaControllers@prueba_hi_resto'
	));	
	
	Route::get('prueba_hi_ejemplo/{id}', array(
       'as' => 'prueba_hi_ejemplo',
       'uses' => 'EncuestaControllers@prueba_hi_ejemplo'
	));
	
	Route::get('generar_resultado_hi/{id}', array(
       'as' => 'generar_resultado_hi',
       'uses' => 'EncuestaControllers@generar_resultado_hi'
	));
	
	/********PREGUNTA/OPCION***/
	
	Route::get('consultarpreguntaopcion/{id}', array(
       'as' => 'consultarpreguntaopcion',
       'uses' => 'PreguntasOpcionesControllers@consultarpreguntaopcion'
	));
	
	Route::get('editarpregunta/{id}', array(
       'as' => 'editarpregunta',
       'uses' => 'PreguntasOpcionesControllers@editarpregunta'
	));	
	
	Route::get('consultaropcion/{id}', array(
       'as' => 'consultaropcion',
       'uses' => 'PreguntasOpcionesControllers@consultaropcion'
	));
	
	Route::post('guardar_pregunta', array(
       'as' => 'guardar_pregunta',
       'uses' => 'PreguntasOpcionesControllers@guardar_pregunta'
	));
	
	Route::get('nuevapregunta/{id}', array(
       'as' => 'nuevapregunta',
       'uses' => 'PreguntasOpcionesControllers@nuevapregunta'
	));
	
	/********PRUEBA SL *******/
	
	Route::get('prueba_sl_ejemplo/{id}', array(
       'as' => 'prueba_sl_ejemplo',
       'uses' => 'EncuestaControllers@prueba_sl_ejemplo'
	));
	
	Route::get('prueba_sl/{id}', array(
       'as' => 'prueba_sl',
       'uses' => 'EncuestaControllers@prueba_sl'
	));		
	
	Route::get('prueba_sl_resto/{id}', array(
       'as' => 'prueba_sl_resto',
       'uses' => 'EncuestaControllers@prueba_sl_resto'
	));	
	
	/********PRUEBA EPA *******/
	
	Route::get('prueba_tcgo/{id}', array(
       'as' => 'prueba_seuc',
       'uses' => 'EncuestaControllers@prueba_seuc'
	));
	
	
	Route::get('reporte_tcgo/{id}', array(
       'as' => 'reporte_tcgo',
       'uses' => 'EncuestaControllers@reporte_tcgo'
	));	

	/********PRUEBA EPA *******/
	
	Route::get('prueba_epa/{id}', array(
       'as' => 'prueba_epa',
       'uses' => 'EncuestaControllers@prueba_epa'
	));	
	
	Route::get('prueba_epa_ejemplo/{id}', array(
       'as' => 'prueba_epa_ejemplo',
       'uses' => 'BateriasPruebasControllers@prueba_epa_ejemplo'
	));
	
	Route::get('prueba_epa_aceptacion/{id}', array(
       'as' => 'prueba_epa_aceptacion',
       'uses' => 'BateriasPruebasControllers@prueba_epa_aceptacion'
	));
	
	Route::get('prueba_epa_resto/{id}', array(
       'as' => 'prueba_epa_resto',
       'uses' => 'BateriasPruebasControllers@prueba_epa_resto'
	));			
	
	Route::get('generar_resultado_epa/{id}', array(
       'as' => 'generar_resultado_epa',
       'uses' => 'EncuestaControllers@generar_resultado_epa'
	));	
	
	/********PRUEBA CO********/
	
	Route::get('prueba_co/{id}', array(
       'as' => 'prueba_co',
       'uses' => 'EncuestaControllers@prueba_co'
	));
	
	Route::get('generar_resultado_co/{id}', array(
       'as' => 'generar_resultado_co',
       'uses' => 'EncuestaControllers@generar_resultado_co'
	));
	
	/********PRUEBA OP********/
	
	Route::get('prueba_op/{id}', array(
       'as' => 'prueba_op',
       'uses' => 'EncuestaControllers@prueba_op'
	));
	
	Route::get('generar_resultado_co/{id}', array(
       'as' => 'generar_resultado_co',
       'uses' => 'EncuestaControllers@generar_resultado_co'
	));	
	
/***************A  J  A  X************************/	

Route::get('index_guardar_prueba_co', function () {
    //if(Request::ajax()) {		
        $datos = Input::all();	
		//dd($datos);
		
		/*
		  "proxima_pagina" => "encuesta_6_3"
		  "id_bateria" => "0"
		  "resultado" => "101-13,102-0,103-0,104-0,105-0,106-0,107-0,108-0,109-0,110-0,111-0,112-0,113-0,114-0,115-0,116-0,117-9,"
		  "id_au" => "842"		
		*/
		
		$id_bateria=$datos["id_bateria"];
		$resultado=$datos["resultado"];
		$id_au=$datos["id_au"];
		$orden=$datos["orden"];
		
		if ($resultado!="") {
			$resultado=substr($resultado,0,strlen($resultado)-1);		
			
			$sql = "select * from autorizaciones where id=".$id_au;
			$data=DB::select($sql);
			foreach ($data as $data)
				$id_candidato=$data->id_usuario;
			
			$valores=explode(",",$resultado);
			
			$pasa=0;
			$ant=0;
			for ($i=0; $i<count($valores); $i++) {
				$pregunta=explode("-",$valores[$i]);
				$id_pregunta=$pregunta[0];
				$respuesta=$pregunta[1];
				$sql = "insert into respuestas_epa (id_autorizacion,id_candidato,id_pruebas,id_opcion,
								respuesta,fecha_creacion,fecha_actualizacion) 
							values ($id_au, $id_candidato, 1, $id_pregunta,'".$respuesta."',
								current_date,current_date)";
				//echo $sql."<br>"; 
				DB::insert($sql);
			}
		}
		//return;
		
		//echo $id_au.'-'.$id_bateria; return;
		
		//if ($proxima_pagina!="")
			echo '<script>location.href="prueba_epa_resto/'.$id_au.'-'.$id_bateria.'-'.$orden.'";</script>';
		/*else
			echo '<script>location.href="generar_resultado_epa/'.$id_au.'";</script>';		*/
		
    /*}

    return Response::json(array(
        'resultado' => 1,
    ));
    die;*/
});	

Route::get('index_guardar_prueba_ra', function () {
    //if(Request::ajax()) {		
        $datos = Input::all();	
		//dd($datos);
		
		$id_bateria=$datos["id_bateria"];
		$resultado=$datos["resultado"];
		$orden=$datos["orden"];
		$id_au=$datos["id_au"];
		if ($resultado!="") {
			$resultado=substr($resultado,0,strlen($resultado)-1);			
			
			$sql = "select * from autorizaciones where id=".$id_au;
			$data=DB::select($sql);
			foreach ($data as $data)
				$id_candidato=$data->id_usuario;
			
			$valores=explode(",",$resultado);
			
			$pasa=0;
			$ant=0;
			for ($i=0; $i<count($valores); $i++) {
				$pregunta=explode("-",$valores[$i]);
				$id_pregunta=$pregunta[0];
				$respuesta=$pregunta[1];
				$sql = "insert into respuestas_epa (id_autorizacion,id_candidato,id_pruebas,id_opcion,
								respuesta,fecha_creacion,fecha_actualizacion) 
							values ($id_au, $id_candidato, 2, $id_pregunta,'".$respuesta."',
								current_date,current_date)";
				DB::insert($sql);
			}
		}
		
		//if ($proxima_pagina!="")
			echo '<script>location.href="prueba_epa_resto/'.$id_au.'-'.$id_bateria.'-'.$orden.'";</script>';
		/*else
			echo '<script>location.href="generar_resultado_epa/'.$id_au.'";</script>';	*/	
		
    /*}

    return Response::json(array(
        'resultado' => 1,
    ));
    die;*/
});	

Route::get('index_guardar_prueba_rv', function () {
    //if(Request::ajax()) {		
        $datos = Input::all();	
		//dd($datos);
		
		$id_bateria=$datos["id_bateria"];
		$resultado=$datos["resultado"];
		$orden=$datos["orden"];
		$id_au=$datos["id_au"];
		if ($resultado!="") {
			$resultado=substr($resultado,0,strlen($resultado)-1);			
			
			$sql = "select * from autorizaciones where id=".$id_au;
			$data=DB::select($sql);
			foreach ($data as $data)
				$id_candidato=$data->id_usuario;
			
			$valores=explode(",",$resultado);
			
			$pasa=0;
			$ant=0;
			for ($i=0; $i<count($valores); $i++) {
				$pregunta=explode("-",$valores[$i]);
				$id_pregunta=$pregunta[0];
				$respuesta=$pregunta[1];
				$sql = "insert into respuestas_epa (id_autorizacion,id_candidato,id_pruebas,id_opcion,
								respuesta,fecha_creacion,fecha_actualizacion) 
							values ($id_au, $id_candidato, 3, $id_pregunta,'".$respuesta."',
								current_date,current_date)";
				DB::insert($sql);
			}
		}
		
		//if ($proxima_pagina!="")
			echo '<script>location.href="prueba_epa_resto/'.$id_au.'-'.$id_bateria.'-'.$orden.'";</script>';
		/*else
			echo '<script>location.href="generar_resultado_epa/'.$id_au.'";</script>';*/
		
    /*}

    return Response::json(array(
        'resultado' => 1,
    ));
    die;*/
});	

Route::get('index_guardar_prueba_hn', function () {
    //if(Request::ajax()) {		
        $datos = Input::all();	
		//dd($datos);
		
		$id_bateria=$datos["id_bateria"];
		$resultado=$datos["resultado"];
		$orden=$datos["orden"];
		$id_au=$datos["id_au"];
		if ($resultado!="") {
			$resultado=substr($resultado,0,strlen($resultado)-1);
			
			
			$sql = "select * from autorizaciones where id=".$id_au;
			$data=DB::select($sql);
			foreach ($data as $data)
				$id_candidato=$data->id_usuario;
			
			$valores=explode(",",$resultado);
			
			$pasa=0;
			$ant=0;
			for ($i=0; $i<count($valores); $i++) {
				$pregunta=explode("-",$valores[$i]);
				$id_pregunta=$pregunta[0];
				$respuesta=$pregunta[1];
				$sql = "insert into respuestas_epa (id_autorizacion,id_candidato,id_pruebas,id_opcion,
								respuesta,fecha_creacion,fecha_actualizacion) 
							values ($id_au, $id_candidato, 4, $id_pregunta,'".$respuesta."',
								current_date,current_date)";
				DB::insert($sql);
			}
		}
		
		//if ($proxima_pagina!="")
			echo '<script>location.href="prueba_epa_resto/'.$id_au.'-'.$id_bateria.'-'.$orden.'";</script>';
		/*else
			echo '<script>location.href="generar_resultado_epa/'.$id_au.'";</script>';*/
		
    /*}

    return Response::json(array(
        'resultado' => 1,
    ));
    die;*/
});	

Route::get('index_guardar_prueba_iep', function () {
    //if(Request::ajax()) {		
        $datos = Input::all();	
		//dd($datos);
		
		/*
		  "id_bateria" => "7"
		  "resultado_mas" => "81-277,82-282,83-286,84-290,85-294,86-298,87-302,88-306,89-311,128-466,"
		  "resultado_menos" => "81-276,82-283,83-287,84-289,85-293,86-297,87-301,88-305,89-310,128-467,"
		  "id_au" => "1066"
		  "orden" => "7"		
		*/
		
		$id_bateria=$datos["id_bateria"];
		$id_au=$datos["id_au"];
		$orden=$datos["orden"];
		
		$resultado_mas=$datos["resultado_mas"];
		$resultado_mas=substr($resultado_mas,0,strlen($resultado_mas)-1);
		$resultado_menos=$datos["resultado_menos"];
		$resultado_menos=substr($resultado_menos,0,strlen($resultado_menos)-1);		
		
		if ($resultado_mas!="") {
			$resultado_mas=explode(",",$resultado_mas);
			$resultado_menos=explode(",",$resultado_menos);
			
			/*print_r ($resultado_mas);
			print_r ($resultado_menos);
			return;*/
						
			$sql = "select * from autorizaciones where id=".$id_au;
			$data=DB::select($sql);
			foreach ($data as $data)
				$id_candidato=$data->id_usuario;
							
			$valores_mas=$resultado_mas;
			$valores_menos=$resultado_menos;
			
			for ($i=0; $i<count($valores_mas); $i++) {
				$pregunta=explode("-",$valores_mas[$i]);
				$id_pregunta=$pregunta[0];
				$respuesta=$pregunta[1];
				$sql = "insert into respuestas_epa (id_autorizacion,id_candidato,id_pruebas,id_opcion,
								respuesta,fecha_creacion,fecha_actualizacion) 
							values ($id_au, $id_candidato, 5, $respuesta,'1',
								current_date,current_date)";
				//echo $sql."<br>";
				DB::insert($sql);
			}		
		
			for ($i=0; $i<count($valores_menos); $i++) {
				$pregunta=explode("-",$valores_menos[$i]);
				$id_pregunta=$pregunta[0];
				$respuesta=$pregunta[1];
				$sql = "insert into respuestas_epa (id_autorizacion,id_candidato,id_pruebas,id_opcion,
								respuesta,fecha_creacion,fecha_actualizacion) 
							values ($id_au, $id_candidato, 5, $respuesta,'-1',
								current_date,current_date)";
				//echo $sql."<br>";
				DB::insert($sql);
			}
			//return;
		}
		
		//if ($proxima_pagina!="")
			echo '<script>location.href="prueba_epa_resto/'.$id_au.'-'.$id_bateria.'-'.$orden.'";</script>';
		/*else
			echo '<script>location.href="generar_resultado_epa/'.$id_au.'";</script>';*/
		
    /*}

    return Response::json(array(
        'resultado' => 1,
    ));
    die;*/
});	

Route::get('index_guardar_prueba_coordinacion_1', function () {
    //if(Request::ajax()) {		
        $datos = Input::all();
		//resultado="+resultado+"
		//id_au="+id_au+"&
		//proxima_pagina="+proxima_pagina+"&
		//id_bateria="+id_bateria;
		
		$resultado=$datos["resultado"];
		$resultado=substr($resultado,0,strlen($resultado)-3);
		$id_au=$datos["id_au"];
		$id_bateria=$datos["id_bateria"];
		
		$sql = "select * from autorizaciones where id=".$id_au;
		$data=DB::select($sql);
		foreach ($data as $data)
			$id_candidato=$data->id_usuario;
		
		//001.1,1,1,1,1,1,1,1,
		$valores=explode("..",$resultado);
		
		$pasa=0;
		$ant=0;
		for ($i=0; $i<count($valores); $i++) {
			//001 Pregunta
			//1,1,1,1,1,1,1,1, respuestas
			$preg_resp=explode(".",$valores[$i]);			
			
			$id_pregunta=$preg_resp[0];
			$respuesta=$preg_resp[1];
			$cada_respuesta=explode(",",$respuesta);
			//$respuesta=substr($respuesta,0,strlen($respuesta)-1);
			$sql = "insert into respuestas_hl (id_autorizacion,id_candidato,id_pruebas,id_opcion,
							respuesta,fecha_creacion,fecha_actualizacion) 
						values ($id_au, $id_candidato, 1, $id_pregunta,'";			
			foreach ($cada_respuesta as $key=>$value)
				$sql.=$value.",";			
			
			$sql = substr($sql,0,strlen($sql)-1);
			
			$ultimo=substr($sql,strlen($sql)-1);
			
			if ($ultimo==",")
				$sql = substr($sql,0,strlen($sql)-1);
			$sql .= "',current_date,current_date)";
			//echo $sql."<br>";
			DB::insert($sql);			
		}
		//if ($proxima_pagina!="")
			echo '<script>location.href="prueba_hi_resto/'.$proxima_pagina.'-'.$id_au.'-'.$id_bateria.'";</script>';
		/*else
			echo '<script>location.href="generar_resultado_hi/'.$id_au.'";</script>';*/
		//location.href="../prueba_hi_resto/encuesta_3_"+nro_prueba+"-"+id_au;
    /*}

    return Response::json(array(
        'resultado' => 1,
    ));
    die;*/
});	

Route::get('index_guardar_prueba_intelectivas', function () {
    //if(Request::ajax()) {		
        $datos = Input::all();		
		
		$resultado=$datos["resultado"];
		$resultado=substr($resultado,0,strlen($resultado)-1);
		$id_au=$datos["id_au"];
		$proxima_pagina=$datos["proxima_pagina"];
		$id_bateria=$datos["id_bateria"];		
		
		$sql = "select * from autorizaciones where id=".$id_au;
		$data=DB::select($sql);
		foreach ($data as $data)
			$id_candidato=$data->id_usuario;
		
		if ($resultado!=0) {
			$valores=explode(",",$resultado);
			for ($i=0; $i<count($valores); $i++) {	
				$sql = "insert into respuestas_hl (id_autorizacion,id_candidato,id_pruebas,id_opcion,respuesta,fecha_creacion,fecha_actualizacion) 
						values ($id_au, $id_candidato, 2, ".$valores[$i].",'1'";
				$sql .= ",current_date,current_date)";
				DB::insert($sql);
			}
		}
		if ($proxima_pagina!="")		
			echo '<script>location.href="prueba_hi_resto/'.$proxima_pagina.'-'.$id_au.'-'.$id_bateria.'";</script>';
		else
			echo '<script>location.href="generar_resultado_hi/'.$id_au.'";</script>';		
    /*}

    return Response::json(array(
        'resultado' => 1,
    ));
    die;*/
});	

Route::get('index_guardar_prueba_personal', function () {
    //if(Request::ajax()) {
        $datos = Input::all();
		//echo "holaaaaaaaaaaaaaaaa..";
		//dd($datos);
		$resultado=$datos["resultado"];
		$id_au=$datos["id_au"];
		$proxima_pagina=$datos["proxima_pagina"];
		$id_bateria=$datos["id_bateria"];		
		
		if ($resultado!="") {
			$resultado=substr($resultado,0,strlen($resultado)-1);
			
			$sql = "select * from autorizaciones where id=".$id_au;
			$data=DB::select($sql);
			foreach ($data as $data)
				$id_candidato=$data->id_usuario;
				
			//1610,1621,1660,1681,1690,1721,1730,1741,1780,1801,1810,1831,1850,1861,1891,
			//1910,1931,1940,1971,2000,2021,2030,2050,2071,2091,2120,2131,2160,2181,2200,2210,
			//2221,2261,2280,2291,2300,2341,2350,2370,2391,2421,2430,2460,2471,2490,2521,2540,
			//2551,2591,2600,2611,2620,2650,2671,2691,2720,2741,2750,2791,2800,2810,2831,2850,
			//2881,2900,2921,2941,2950,2991,3000,3011,3030,3050,3071,3100,3111,3130,3141,3171,
			//3190,3210,3231,3251,3260,3300,3321,3350,3361,3370,3521,3411,3430,3440,3471,3501,3510,
			if ($resultado!=0) {
				$valores=explode(",",$resultado);
				for ($i=0; $i<count($valores); $i++) {
					$opcion=substr($valores[$i],0,3);
					$respuesta=substr($valores[$i],3);
					//echo "opcuion=$opcion...resp=$respuesta"; return;
					if ($respuesta==0)
						$respuesta="-1";
					$sql = "insert into respuestas_hl (id_autorizacion,id_candidato,id_pruebas,id_opcion,respuesta,fecha_creacion,fecha_actualizacion) 
							values ($id_au, $id_candidato, 3, ".$opcion.",'".$respuesta."'";
					$sql .= ",current_date,current_date)";
					DB::insert($sql);
				}
			}
		}
		if ($proxima_pagina!="")
			echo '<script>location.href="prueba_hi_resto/'.$proxima_pagina.'-'.$id_au.'-'.$id_bateria.'";</script>';
		else
			echo '<script>location.href="generar_resultado_hi/'.$id_au.'";</script>';
    //}

    /*return Response::json(array(
        'resultado' => 1,
    ));
    die;*/
});

Route::get('index_guardar_prueba_seuc', function () {
	$datos = Input::all();	
	//dd($datos);
	
	$cod_evaluacion=$datos["cod_evaluacion"];
	
	/*
	  "id_bateria" => "8"
	  "id_au" => "1134"
	  "orden" => "1"
	  "cod_evaluacion" => "595be66a43a52"
	  "resultado_1" => "1-1,2-1,3-1,4-1,5-1,6-1,7-1,8-1,9-1,10-1,11-1,12-1,13-1,14-1,15-1,16-1,17-1,18-1,19-1,20-1,21-1,"
	  "resultado_2" => "22-1,23-1,24-1,25-1,26-1,27-1,28-1,29-1,30-1,31-1,32-1,33-1,34-1,35-1,36-1,37-1,38-1,39-1,40-1,41-1,42-1,"
	  "resultado_3" => "43-1,44-1,45-1,46-1,47-1,48-1,49-1,50-1,51-1,52-1,53-1,54-1,55-1,56-1,57-1,58-1,59-1,60-1,61-1,62-1,63-1,"
	  "resultado_4" => "64-1,65-1,66-1,67-1,68-1,69-1,70-1,71-1,72-1,73-1,74-1,75-1,76-1,77-1,78-1,79-1,80-1,81-1,82-1,83-1,84-1,"
	  "resultado_5" => "85-1,86-1,87-1,88-1,89-1,90-1,91-1,92-1,93-1,94-1,95-1,96-1,97-1,98-1,99-1,100-1,101-1,102-1,103-1,104-1,105-1,"
	  "resultado_6" => "106-1,107-1,108-1,109-1,110-1,111-1,112-1,113-1,114-1,115-1,116-1,117-1,118-1,119-1,120-1,121-1,122-1,123-1,124-1,125-1,126-1,"
	  "resultado_7" => "127-1,128-1,129-1,130-1,131-1,132-1,133-1,134-1,135-1,136-1,137-1,138-1,139-1,140-1,141-1,142-1,143-1,144-1,145-1,146-1,147-1,"
	"resultado_8" => "148-1,149-1,150-1,151-1,152-1,153-1,154-1,155-1,156-1,157-1,158-1,159-1,160-1,161-1,162-1,163-1,164-1,165-1,166-1,167-1,168-1,"
	*/
	
	foreach ($datos as $key=>$value) {
		if (strpos($key,"resultado_") !== false) {
			$resultado=$value;
			//echo $resultado."<br>";
			$valores=explode(",",$resultado);
			foreach ($valores as $key=>$value) {
				$valoresI=explode("-",$resultado);
				$sql="select * from tb_preguntas where codigo_prueba='1003' and numero_pregunta='".$valoresI[0]."'";
				$data = DB::select($sql);		
				foreach ($data as $data) {
					$peso_pregunta=$data->peso_pregunta;
					$dificultad_pregunta=$data->dificultad_pregunta;
					$numero_categoria=$data->numero_categoria;
					$nombre_categoria=$data->nombre_categoria;
					$numero_subcategoria=$data->numero_subcategoria;
					$nombre_subcategoria=$data->nombre_subcategoria;
					$numero_opciones=$data->numero_opciones;
					$usar_opciones_generales=$data->usar_opciones_generales;
					$imagen_pregunta=$data->imagen_pregunta;
					$status_pregunta=$data->status_pregunta;
				}
				
				$sql = "select valor_opcion from tb_opciones 
						where numero_pregunta='".$valoresI[0]."' and numero_opcion='".$valoresI[1]."'";
				$data = DB::select($sql);		
				foreach ($data as $data)
					$valor_opcion_pregunta=$data->valor_opcion;
				
				$sql_respuestas_evaluados = "INSERT INTO tb_respuestas_evaluados(cod_evaluacion, 
							codigo_prueba, numero_pregunta, peso_pregunta, opcion_respondida, 
							valor_opcion, numero_categoria_pregunta, nombre_categoria_pregunta, 
							numero_subcategoria_pregunta, nombre_subcategoria_pregunta, 
							respuesta_correcta) 
						VALUES('$cod_evaluacion', '1003', '".$valoresI[0]."', 
							'$peso_pregunta', '".$valoresI[1]."', '".$valor_opcion_pregunta."', 
							'$numero_categoria', '$nombre_categoria', 
							'$numero_subcategoria', '$nombre_subcategoria',
							'N/A')";
				//echo $sql_respuestas_evaluados."<br><br>";
				DB::insert($sql_respuestas_evaluados);
			}			
		}
	}
	
	echo '<script>location.href="reporte_tcgo/'.$cod_evaluacion.'";</script>';
});

Route::get('index_guardar_prueba_competencias', function () {
    //if(Request::ajax()) {
        $datos = Input::all();		
		
		//dd($datos);
		
		$resultado="";
		foreach ($datos as $key=>$value) {
			if (strpos($key,"resultado") !== false) {
				$resultado.=$value;
			}
		}
		
		//$resultado=$datos["resultado"];
		$resultado=substr($resultado,0,strlen($resultado)-1);
		
		$id_au=$datos["id_au"];
		$proxima_pagina=$datos["proxima_pagina"];
		$id_bateria=$datos["id_bateria"];		
		
		$sql = "select * from autorizaciones where id=".$id_au;
		$data=DB::select($sql);
		foreach ($data as $data)
			$id_candidato=$data->id_usuario;
		
		if ($resultado!=0) {
			$valores=explode(",",$resultado);
			//print_r ($valores);
			foreach ($valores as $key=>$value) {
				$valores2=explode(".",$value);
				
				$opcion=$valores2[0];
				$respuesta=$valores2[1];				
				
				$sql = "insert into respuestas_hl (id_autorizacion,id_candidato,id_pruebas,id_opcion,respuesta,
							fecha_creacion,fecha_actualizacion) 
						values ($id_au, $id_candidato, 5, ".$opcion.",'".$respuesta."'";
				$sql .= ",current_date,current_date)";
				//echo $sql."<br>"; 
				DB::insert($sql);
			}
		}
		//echo "proc=".$proxima_pagina; return;
		if ($proxima_pagina!="")		
			echo '<script>location.href="prueba_hi_resto/'.$proxima_pagina.'-'.$id_au.'-'.$id_bateria.'";</script>';
		else
			echo '<script>location.href="generar_resultado_hi/'.$id_au.'-'.$id_bateria.'";</script>';
    /*}

    return Response::json(array(
        'resultado' => 1,
    ));
    die;*/
});	


Route::post('index_guardar_participante', function () {
    if(Request::ajax()) {
        $datos = Input::all();
		//dd($datos);
		$id_au=$datos["id_au"];		
		$otros_valores=$datos["otros_valores"];
		$otros_valores=str_replace(",,",",",$otros_valores);
		$otros_valores=substr($otros_valores,0,strlen($otros_valores)-1);
		$valores=explode(",",$otros_valores);
		
		//valores_1- no,otro_valor_1-,
		//valores_2-campo 1.campo 2.campo 3.otro_valor_2-,
		//valores_3-2,otro_valor_3-,
		//valores_4-Av Sur 13 Residencias Candelaria Torre A Piso 11 Apto 111,
		
		/*echo "<pre>";
		print_r ($valores);
		echo "</pre>";
		return;*/
		
		/*
			[0] => valores_1- no
			[1] => otro_valor_1-
			[2] => valores_2-campo 1.campo 2.campo 3.
			[3] => valores_3-comentario
			[4] => otro_valor_3-
			[5] => valores_4-		
		*/
		
		/* "otros_valores" => "valores_3-OTRO,otro_valor_3-657657,valores_5-OTRO,otro_valor_5-65765,valores_6-65765,valores_7-val7,otro_valor_7-," */		
		$sql= "delete from contenidos_campos where id_autorizaciones=$id_au";
		DB::delete($sql);
		foreach ($valores as $key=>$value) {
			$valores_parametros=explode("-",$value);
			/*echo "<pre>";
			print_r ($valores_parametros);
			echo "</pre>";*/			
			$id=$valores_parametros[0];
			if (strpos($id,"valores_") !== false)			
				$id=substr($id,strpos($id,"_")+1);
			else {
				$id=substr($id,strpos($id,"_")+1);
				$id=substr($id,strpos($id,"_")+1);
			}
			
			if (isset($valores_parametros[1]))
				$valor=$valores_parametros[1];
			else
				$valor="";
			
			if (strpos($valor,".") !== false) {
				$valor=substr($valor,0,strlen($valor)-1);
				$valor=str_replace(",",".",$valor);
			}

			//echo "2)id=$id...valor=$valor...<br>";			
			//'id_campos_candidatos','texto','id_autorizaciones'
			
			if ($valor!="") {				
				$contenidos_campos = new contenidos_campos();
				$contenidos_campos->id_campos_candidatos=$id;
				$contenidos_campos->texto=$valor;
				$contenidos_campos->id_autorizaciones=$id_au;
				$contenidos_campos->save();
			}
		}
		//return;
				
		$sql = "select id from candidatos where id_autorizacion=".$id_au;
		//echo $sql;
		$data=DB::select($sql);
		foreach ($data as $data)
			$id=$data->id;
		
		$candidato=candidato::findOrFail($id);
		$candidato->fill(Input::all());
		$candidato->save();
	}

    return Response::json(array(
        'resultado' => 1,
    ));
    die;
});	
	
Route::post('index_buscar_evaluador', function () {
    if(Request::ajax()) {
        $datos = Input::all();
		
		$resultado="";
		$id="";
		
		$sql = "select * from usuarios where email='".$datos["correo"]."'";
		$data=DB::select($sql);
		if (empty($data))
			$resultado="";
		else {
			foreach ($data as $data) {
				$resultado=$data->nombres;
				$id=$data->id;
			}
		}
    }

    return Response::json(array(
        'resultado' => $resultado,
		'id'=>$id,
    ));
    die;
});	

Route::post('index_llenar_correo', function () {
    if(Request::ajax()) {
        $datos = Input::all();
		
		$resultado="";
		$idioma="";
		
		$sql = "select * from correo where tipo='".$datos["tipo"]."' and 
				id_prueba=".$datos["id_prueba"]." and 
				activa=1 and id_empresa=".$datos["id_empresa"]." order by nombre";
		$data = DB::select($sql);
		foreach ($data as $data) {
			$sql = "select * from idioma where id=".$data->id_idioma;
			$data_idioma=DB::select($sql);
			foreach ($data_idioma as $data_idioma)
				$idioma=$data_idioma->nombre;			
			$resultado.="<option value=".$data->id.">".$data->nombre." ( ".$idioma." ) </option>";
		}
    }

    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});	