<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

<script>
	var pruebas_disponibles_array = new Array();
	<?php 
		$arreglo=FuncionesControllers::cantidad_pruebas();
				
		/*
		pruebas_disponibles_array[3]=15; 
		pruebas_disponibles_array[2]=0;					
		*/
		if (!empty($arreglo)) {
			foreach ($arreglo as $key=>$value)
				echo "pruebas_disponibles_array[".$key."]=".abs($value)."; \n";
		} else {
			$mensaje="Ud no puede asignar pruebas";
		}
	?>
	
</script>

@include ('layout.header')
    {!! Form::open(array('url' => 'guardar_invitacion', 'onsubmit'=>'Javascript: prox_pagina_invitacion()', 'id'=>'forma_invitacion', 'name'=>'forma_invitacion', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="cantidad_pruebas" id="cantidad_pruebas" value="" />
		<input type="hidden" name="nombre_prueba" id="nombre_prueba" value="" />
		<input type="hidden" name="id_empresa" id="id_empresa" value="{{ Session::get('id_empresa') }}" />
		
        <h2>Nueva Invitacion</h2> <hr />
		
		<div align="left" class="alert alert-info alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>
		<?php if (!empty($arreglo)) { ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bateria <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">		
				<select onchange="ver_pruebas_disponibles()" id="id_tipo_prueba_invitacion" name="id_tipo_prueba" class="form-control" >
					<option value="0">Seleccione...</option>
					{{ FuncionesControllers::crear_combo("bateria",0) }}
				</select>
			</div>
		</div>
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Idioma de la Prueba <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">		
				<select id="id_idioma" name="id_idioma" class="form-control" >
					<option value="0">Seleccione...</option>
					{{ FuncionesControllers::crear_combo("idioma",0) }}
				</select>
			</div>
		</div>
		
		<div align="center">
			<span id="disponibles" style="text-align: center; font-weight: bold; color: red"></span>
		</div>
		
	<div id="invitaciones">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Correo Invitacion: <span class="msj">(*)</span>:</label>
            <div class="col-md-3" id="ci"></div>
        </div>
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Correo Presentacion de Prueba: <span class="msj">(*)</span>:</label>
            <div class="col-md-3" id="cp"></div>
        </div>		

		<div class="row" id="prueba_1" style="display: none;">
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre Candidato <span class="msj">(*)</span>:</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="nombres_1" name="nombres_1" type="text" class="form-control" placeholder="Nombres" value="">
				</div>
			</div>	
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Apellido Candidato <span class="msj">(*)</span>:</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="apellidos_1" name="apellidos_1" type="text" class="form-control" placeholder="Apellidos" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Email Candidato <span class="msj">(*)</span>:</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="email_1" name="email_1" type="email" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Email" value="">
				</div>
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-122">Grupo de Candidatos</label>
				<div class="col-md-6 col-sm-6 col-xs-12">		
					<select class="form-control" id="id_grupo_candidatos" name="id_grupo_candidatos">
						<option value=0>Seleccione Grupo...</option>
						{{ FuncionesControllers::crear_combo('grupo_candidatos', 0) }}
					</select>		
				</div>
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-12 col-xs-12">Desea que el Candidato reciba su informe de resultado? <span class="msj">(*)</span>:</label>
				<div class="radio">
					<label>
						<input type="radio" class="flat" name="recibe" id="recibe" value="1" checked> Si
					</label>
					<label>
						<input type="radio" class="flat" name="recibe" id="recibe" value="0"> No
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Desea enviar su resultado a otro correo? Por favor colocarlo aca separados por comas :</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="otros_correos" name="otros_correos" type="text" class="form-control" placeholder="Otros Correos" value="">
				</div>
			</div>			
		</div>
		<div class="row" id="prueba_2" style="display:none;">
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Email Evaluador <span class="msj">(*)</span>:</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input onblur="buscar_evaluador(this.value)" id="email_2" name="email_2" type="email" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Email" value="">
				</div>
			</div>	

			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre Evaluador <span class="msj">(*)</span>:</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="nombres_2" name="nombres_2" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Nombres" value="">
				</div>
			</div>		
			
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-122">Empresa</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					{{ FuncionesControllers::buscar_empresa(Session::get("id_empresa")) }}
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Cantidad de Evaluados: <span class="msj">(*)</span>:</label>
				<div class="col-md-1">
					<input id="cantidad_2" onblur="ver_evaluados(this.value)" name="cantidad_2" type="number" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Cantidad Evaluados" value="">
				</div>
			</div>
			
			<div id="evaluados"></div>
		</div>
</div>
	
	<br />
	<div class="ln_solid"></div>
	<div align="center">
		<div class="form-group" align="center" id="boton_invitar" style="display: none;">
			<input class="send-btn btn btn-primary" type="submit" name="invitar" id="invitar_boton" value="Invitar">
		</div>
	</div>
		<?php } ?>
		{!! Form::close() !!}

@include ('layout.footer')