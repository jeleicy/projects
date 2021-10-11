<?php

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

Route::get('/', function() {
	return view('dashboard.inicio');
});

Route::get('dashboardindex', function () {
    return view('dashboard.index');
});

Route::post('index_proceso_respsec', function () {
	if(Request::ajax()) {
		$datos = Input::all();

		$sql = "select respsec from observador where id_observador=".$datos["id_observador"];
		$data = DB::select($sql);
		$resultado="";
		foreach($data as $data)
			$respsec=$data->respsec;
		if ($respsec==$datos["respsec"]) {
			$resultado .= '<div class="form-group">
				<label class="control-label col-xs-3">Nueva Contrase&ntilde;a:</label>
					<div class="col-xs-9">
						<input name="contrasena1" type="password" class="form-control" placeholder="Nueva Contrasena" value="">
					</div>
				</div>
			';
			$resultado .= '<div class="form-group">
				<label class="control-label col-xs-3">Nuevamente su Contrase&ntilde;a:</label>
					<div class="col-xs-9">
						<input name="contrasena2" type="password" class="form-control" placeholder="Nuevamente su Contrasena" value="">
					</div>
				</div>
			';

			$resultado .= '<div class="form-group">
					<div class="col-xs-offset-3 col-xs-9">
						<input  class="btn btn-primary" type="button" name="Validar2" value="Validar Contrasena" onclick="validar_contrasena(this.form)" />
					</div>
				</div>
			';
		} else {
			$mensaje = "La respuesta introducida no es correcta, intente nuevamente...!!!";
			$resultado .= "<br /><br /><div class='error' align='center'>".$mensaje."</div><br /><br />";
		}

	return Response::json(array(
		'resultado' => $resultado,
	));
	die;
}
});

Route::post('index_proceso_buscar_observador', function () {
	if(Request::ajax()) {
		$datos = Input::all();
		$sql = "select o.nombres, o.apellidos, e.nombre as estado, o.id_estado, o.id_municipio, o.id_parroquia ";
		$sql .= "from observador o, estado e ";
		$sql .= "where o.cedula='".$datos["cedula"]."' and e.id_estado=o.id_estado";
		$data = DB::select($sql);
		$resultado="No existe esta Cedula";
		if (!empty($data)) {
			$municipio="";
			$parroquia="";
			foreach ($data as $data) {
				if ($data->id_municipio>0) {
					$sql = "select nombre from municipio where id_estado=" . $data->id_estado . " and id_municipio=" . $data->id_municipio;
					$data2 = DB::select($sql);
					foreach ($data2 as $data2)
						$municipio = $data2->nombre;
					if ($data->id_parroquia>0) {
						$sql = "select nombre from parroquia where id_estado=" . $data->id_estado . " and id_municipio=" . $data->id_municipio;
						$data2 = DB::select($sql);
						foreach ($data2 as $data2)
							$parroquia = $data2->nombre;
					}
				}
				$resultado = strtoupper($datos["tipo"]) . ": <strong>" . $data->nombres . " " . $data->apellidos . "</strong>";
				$resultado .= " / Estado: <strong>".$data->estado."</strong> / ";
				$resultado .= "Municipio: <strong>".$municipio."</strong> / Parroquia: <strong>".$parroquia."</strong>";
			}
		}

		return Response::json(array(
			'resultado' => $resultado,
		));
		die;
	}
});

Route::post('index_proceso_municipio', function () {
	if(Request::ajax()) {
		$datos = Input::all();

		$sql = "select * from municipio where id_estado=".$datos["estado"]." order by nombre";
		//echo $sql;
		$data = DB::select($sql);

		$resultado = '<select class="form-control" name="municipio" id="municipio" onchange="ver_parroquia_jquery(this.form)">';
		$resultado .= "<option value=0>Seleccione Municipio...</option>";
		foreach ($data as $data) {
			if ($datos["municipio"] == $data->id_municipio && $datos["municipio"] != 0)
				$resultado .= "<option value='" . $data->id_municipio . "' selected>" . $data->nombre . "</option>";
			else
				$resultado .= "<option value='" . $data->id_municipio . "'>" . $data->nombre . "</option>";
		}
		$resultado .= "</select>";

		return Response::json(array(
			'resultado' => $resultado,
		));
		die;
	}
});

Route::post('index_proceso_parroquia', function () {
	if(Request::ajax()) {
		$datos = Input::all();

		$sql = "select * from parroquia where id_municipio=".$datos["municipio"]." and id_estado=".$datos["estado"]." order by nombre";
		$data = DB::select($sql);

		$resultado = '<select class="form-control" name="parroquia" id="parroquia" onchange="ver_centro_jquery(this.form)">';
		$resultado .= "<option value=0>Seleccione Parroquia...</option>";
		foreach ($data as $data) {
			if ((isset($datos["parroquia"])) && $datos["parroquia"]==$data->id_parroquia)
				$resultado .= "<option value='".$data->id_parroquia."' selected>".$data->nombre."</option>";
			else
				$resultado .= "<option value='".$data->id_parroquia."'>".$data->nombre."</option>";
		}

		$resultado .= "</select>";

		return Response::json(array(
			'resultado' => $resultado,
		));
		die;
	}
});

Route::post('index_proceso_centro_mesas', function () {
	if(Request::ajax()) {
		$datos = Input::all();

		$sql = "select * from universo_mesa where codigo_centro='".$datos["centro"]."'";
		$data = DB::select($sql);
		$resultado = "<div class='radio'>";
		$i=1;
		foreach ($data as $data) {
			if ($i==1)
				$resultado .= '<div class="form-group"><label class="control-label col-xs-3">&nbsp;</label>';

			$resultado .= '
				<div class="col-xs-2">
					<label class="radio-inline">
						<input type="radio" name="nro_mesa" id="nro_mesa" value="'.$data->cod_mesa.'">Mesa Nro: '.$data->cod_mesa.' (Votantes:'.$data->nro_votantes.')
					</label>
				</div>
		  ';
			$i++;
			if ($i==5) {
				$resultado .= '</div>';
				$i=1;
			}
		}
		if ($i<4) $resultado .= "</div>";

		return Response::json(array(
			'resultado' => $resultado,
		));
		die;
	}
});

Route::post('index_proceso_centro', function () {
	if(Request::ajax()) {
		$datos = Input::all();

		$sql = "select * from centro where parroquia=".$datos["parroquia"]." and municipio=".$datos["municipio"]." and estado=".$datos["estado"]." order by nombre";
		$data = DB::select($sql);

		$resultado = '<select class="form-control" name="centro" id="centro" onchange="ver_centro_mesas_jquery(this.form)">';
		$resultado .= "<option value=0>Seleccione Centro...</option>";
		foreach ($data as $data) {
			if ((isset($datos["centro"])) && $datos["centro"]==$data->id_centro)
				$resultado .= "<option value='".$data->id_centro."' selected>".$data->nombre."</option>";
			else
				$resultado .= "<option value='".$data->id_centro."'>".$data->nombre."</option>";
		}

		$resultado .= "</select>";

		return Response::json(array(
			'resultado' => $resultado,
		));
		die;
	}
});

Route::post('index_proceso_desautorizar', function () {
	if(Request::ajax()) {
		$datos = Input::all();
		$sql = "update observador set autorizado=0 ";
		$sql .= "where id_observador=".$datos["id_observador"];
		DB::update($sql);

		echo "";
	}
	return Response::json(array(
		'resultado' => 'No (<a class=\'ver_mas\' href=\'javascript:;\' onclick=\'autorizar('.$datos["id_observador"].')\'>Autorizar</a>)',
	));
	die;
});

Route::post('index_proceso_autorizar', function () {
	if(Request::ajax()) {
		$datos = Input::all();
		$sql = "update observador set autorizado=1 ";
		$sql .= "where id_observador=".$datos["id_observador"];
		DB::update($sql);

		echo "";
	}
	return Response::json(array(
		'resultado' => 'Si (<a class=\'ver_mas\' href=\'javascript:;\' onclick=\'bloquear('.$datos["id_observador"].')\'>Bloquear</a>)',
	));
	die;
});


//index_proceso_centros_parroquias

/******************************************* USUARIOS ********************************/
Route::get('prueba', function () {
	return view('reportes.prueba');
});

Route::post('logueo', array(
	'as' => 'logueo',
	'uses' => 'UsuariosControllers@autenticacion'
));

Route::get('cerrar_session', array(
	'as' => 'cerrar_session',
	'uses' => 'UsuariosControllers@cerrar_session'
));

/***************************** OBSERVADORES **********************************/

Route::get('registro', array(
	'as' => 'registro',
	'uses' => 'ObservadoresController@registro'
));

Route::post('eliminar_observador', array(
	'as' => 'eliminar_observador',
	'uses' => 'ObservadoresController@eliminar_observador'
));

Route::post('registro_consulta/{id}', array(
	'as' => 'registro_consulta',
	'uses' => 'ObservadoresController@registro_consulta'
));

Route::post('guardar_registro', array(
	'as' => 'guardar_registro',
	'uses' => 'ObservadoresController@guardar_registro'
));

Route::get('observadores', array(
	'as' => 'observadores',
	'uses' => 'ObservadoresController@consulta'
));

Route::post('consultar_observadores', array(
	'as' => 'consultar_observadores',
	'uses' => 'ObservadoresController@consultar_observadores'
));

/************************************* ADMINISTRACION *********************************/

//3.1) Reportes	&numero=1
Route::get('reporte_planilla/{id}', array(
	'as' => 'reporte_planilla',
	'uses' => 'ReportesControllers@reportes_planillas'
));

Route::post('recuperar_reportes_planillas', array (
	'as' => 'recuperar_reportes_planillas',
	'uses' => 'ReportesControllers@reporte_planilla_recuperacion'
));

Route::get('imprimir_planilla_llena/{id}', array(
	'as' => 'imprimir_planilla_llena',
	'uses' => 'ReportesControllers@imprimir_planilla_llena'
));

Route::get('exportar_estadisticas_excel/{id}', array(
	'as' => 'exportar_estadisticas_excel',
	'uses' => 'ReportesControllers@exportar_estadisticas_excel'
));

Route::get('centros', array(
	'as' => 'centros',
	'uses' => 'ReportesControllers@consulta_centros'
));

Route::get('centros_asignados', array(
	'as' => 'centros_asignados',
	'uses' => 'ReportesControllers@consulta_centros_asignados'
));

Route::post('consulta_de_centros', array(
	'as' => 'consulta_de_centros',
	'uses' => 'ReportesControllers@consulta_de_centros'
));

Route::get('exportar_estadisticas_centros_procesados/{id}', array(
	'as' => 'exportar_estadisticas_centros_procesados',
	'uses' => 'ReportesControllers@exportar_estadisticas_centros_procesados'
));

Route::get('exportar_excel/{id}', array(
	'as' => 'exportar_excel',
	'uses' => 'ReportesControllers@exportar_excel'
));

Route::get('reporte_votos/{id}', array(
	'as' => 'reporte_votos',
	'uses' => 'ReportesControllers@reporte_votos'
));

Route::post('generar_reporte_estadistica', array (
	'as' => 'generar_reporte_estadistica',
	'uses' => 'ReportesControllers@estadisticas'
));

Route::post('reporte_planilla_guardar/{id}', array(
	'as' => 'reporte_planilla_guardar',
	'uses' => 'ReportesControllers@reportes_planillas'
));

Route::post('recuperacion/{id}', array(
	'as' => 'recuperacion',
	'uses' => 'ReportesControllers@recuperacion'
));

Route::get('imprimir_listado_asignacion/{id_operador}', array(
	'as' => 'imprimir_listado_asignacion',
	'uses' => 'ReportesControllers@imprimir_listado_asignacion'
));


Route::get('listado_observadores', array(
	'as' => 'listado_observadores',
	'uses' => 'ReportesControllers@buscar_listado_observadores'
));

Route::post('buscar_listado_observadores', array(
	'as' => 'buscar_listado_observadores',
	'uses' => 'ReportesControllers@buscar_listado_observadores'
));

//3.2) Estadisticas
//3.2.1) Estadisticas	
Route::get('estadisticas', array(
	'as' => 'estadisticas',
	'uses' => 'ReportesControllers@estadisticas'
));

//3.2.2) Listado de Recuperacion
Route::get('listado_recuperacion', array(
	'as' => 'listado_recuperacion',
	'uses' => 'ReportesControllers@listado_recuperacion'
));

Route::post('buscar_listado_recuperacion', array(
	'as' => 'buscar_listado_recuperacion',
	'uses' => 'ReportesControllers@listado_recuperacion'
));

Route::get('exportar_estadisticas_observadores_excel/{id}', array(
	'as' => 'exportar_estadisticas_observadores_excel',
	'uses' => 'ReportesControllers@exportar_estadisticas_observadores_excel'
));

Route::get('exportar_excel_recuperacion/{id}', array(
	'as' => 'exportar_excel_recuperacion',
	'uses' => 'ReportesControllers@exportar_excel_recuperacion'
));

//3.2.3) Mapa Georeferencial	
Route::post('mapa_geo', array(
	'as' => 'mapa_geo',
	'uses' => 'ReportesControllers@mapa_geo'
));

//3.2.4) Estadisticas votos
Route::get('estadisticas_votos', array(
	'as' => 'estadisticas_votos',
	'uses' => 'ReportesControllers@estadisticas_votos'
));

//3.2.5) Estadisticas de Cobertura
Route::get('estadistica_cobertura', array(
	'as' => 'estadistica_cobertura',
	'uses' => 'ReportesControllers@estadistica_cobertura'
));

Route::get('exportar_excel_cobertura/{id}', array(
	'as' => 'exportar_excel_cobertura',
	'uses' => 'ReportesControllers@exportar_excel_cobertura'
));

//3.2.6) Listado Planillas Procesadas
Route::get('listado_planillas', array(
	'as' => 'listado_planillas',
	'uses' => 'ReportesControllers@listado_planillas'
));

Route::post('buscar_listado_planillas', array(
	'as' => 'buscar_listado_planillas',
	'uses' => 'ReportesControllers@listado_planillas'
));

Route::get('imprimir_listado_planillas/{id}', array(
	'as' => 'imprimir_listado_planillas',
	'uses' => 'ReportesControllers@imprimir_listado_planillas'
));

//3.2.7) Reporte Planilla 2
Route::post('reporte_plan_2', array(
	'as' => 'reporte_plan_2',
	'uses' => 'ReportesControllers@reporte_plan_2'
));

//3.2.8) Reporte Planilla 3
Route::post('reporte_plan_3', array(
	'as' => 'reporte_plan_3',
	'uses' => 'ReportesControllers@reporte_plan_3'
));

/************************************ ASIGNACIONES *******************************/
//3.3.1) Asignar Observadores	
Route::get('asignacion', array(
	'as' => 'asignacion',
	'uses' => 'AsignacionesControllers@asignacion'
));

Route::post('asignacion_observadores', array(
	'as' => 'asignacion_observadores',
	'uses' => 'AsignacionesControllers@asignacion_observadores'
));

Route::post('eliminar_asignacion', array(
	'as' => 'eliminar_asignacion',
	'uses' => 'AsignacionesControllers@eliminar_asignacion'
));

/*************************************** OBSERVADORES *****************************/
//4) Observadores por Operador	
Route::get('observador_operador', array(
	'as' => 'observador_operador',
	'uses' => 'ObservadoresController@observador_operador'
));

Route::post('consultar_observadores_operadores', array(
	'as' => 'consultar_observadores_operadores',
	'uses' => 'ObservadoresController@consultar_observadores_operadores'
));

Route::get('imprimir_listado_asignacion_observadores/{id}', array(
	'as' => 'imprimir_listado_asignacion_observadores',
	'uses' => 'ReportesControllers@imprimir_listado_asignacion_observadores'
));

/*****************************CANDIDATOS************************/

Route::get('candidatos', array(
	'as' => 'candidatos',
	'uses' => 'CandidatosControllers@create'
));

Route::post('eliminar_candidato', array(
	'as' => 'eliminar_candidato',
	'uses' => 'CandidatosControllers@eliminar_candidato'
));

Route::post('eliminar_candidato', array(
	'as' => 'eliminar_candidato',
	'uses' => 'CandidatosControllers@eliminar_candidato'
));

Route::post('guardar_candidato', array(
	'as' => 'guardar_candidato',
	'uses' => 'CandidatosControllers@store'
));

Route::post('ver_candidato', array(
	'as' => 'ver_candidato',
	'uses' => 'CandidatosControllers@show'
));

Route::get('cambiar_contrasena', array(
	'as' => 'cambiar_contrasena',
	'uses' => 'UsuariosControllers@cambiar_contrasena'
));

Route::post('cambiar_contrasena_fuera', array(
	'as' => 'cambiar_contrasena_fuera',
	'uses' => 'UsuariosControllers@cambiar_contrasena_fuera'
));

Route::post('guardar_cambiar_contrasena', array(
	'as' => 'guardar_cambiar_contrasena',
	'uses' => 'UsuariosControllers@guardar_cambiar_contrasena'
));

Route::get('imprimir_tablero/{id}', array(
	'as' => 'imprimir_tablero',
	'uses' => 'ReportesControllers@imprimir_tablero'
));

Route::get('crear_universo_mesa', array(
	'as' => 'crear_universo_mesa',
	'uses' => 'FuncionesControllers@crear_universo_mesa'
));

Route::post('asignar_observadores', array(
	'as' => 'asignar_observadores',
	'uses' => 'ObservadoresController@asignar_observadores'
));

Route::post('borrar_planilla', array(
	'as' => 'borrar_planilla',
	'uses' => 'ReportesControllers@borrar_planilla'
));

Route::post('certificar_clave', array(
	'as' => 'certificar_clave',
	'uses' => 'ReportesControllers@certificar_clave'
));