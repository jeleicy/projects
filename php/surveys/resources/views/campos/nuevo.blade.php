<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use URL;
use App\Http\Controllers\FuncionesControllers;

?>

@include ('layout.header')

<style type="text/css" media="all">
	@import 'css/texto/info.css';
	<!--@import "css/texto/main.css";
	@import "css/texto/widgEditor.css";-->
</style>

<script type="text/javascript" src="{{ URL::asset('js/texto/scripts/widgEditor.js') }}"></script>

<form name="forma" action="guardar_campos_nuevo" method="post" class="form-horizontal" onsubmit="mirar_texto()">
		
		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		<!--input type="hidden" name="texto" id="texto" value="" /-->

        <h2>Nuevos Campos Adicionales Candidatos</h2> <hr />
	<div class="row">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre" value="">
            </div>
        </div>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Empresa</label>
			<div class="col-md-6 col-sm-6 col-xs-12">		
				<select class="form-control" id="id_empresas" name="id_empresas">
					{{ FuncionesControllers::crear_combo('empresas', 0) }}
				</select>		
            </div>
        </div>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">¿Obligatorio?</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="radio" value="1" name="obligatorio" id="obligatorio" checked> Si
				<input type="radio" value="0" name="obligatorio" id="obligatorio"> No
            </div>
        </div>		
		
		<!--'SELECCION SIMPLE','SELECCION MULTIPLE','SELECCION SIMPLE CON COMENTARIO','ABIERTO'-->
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Tipo de Campo</label>
			<div class="col-md-6 col-sm-6 col-xs-12">		
				<select class="form-control" id="tipo_campo" name="tipo_campo">
					<option value=0>.....</option>
					<option value="SELECCION SIMPLE">SELECCION SIMPLE</option>
					<option value="SELECCION MULTIPLE">SELECCION MULTIPLE</option>
					<option value="SELECCION SIMPLE CON COMENTARIO">SELECCION SIMPLE CON COMENTARIO</option>
					<option value="ABIERTO">ABIERTO</option>
				</select>		
            </div>
        </div>	

		<div id="valores_tipo_campo" style="display:none">
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Valores tipo del campo<span class="msj">(*)</span>:</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="valores_tipo_campo" name="valores_tipo_campo" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Valores tipo del campo" value="">
					<span style="color:red">Por favor los valores van separados por comas (,)</span>
				</div>
			</div>		
		</div>
				
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Estatus <span class="msj">(*)</span>:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="radio">
					<input class="flat" type="checkbox" id="activa" name="activa" value="1"> Activo
				</div>
			</div>
        </div>	

        <br />
        <div class="ln_solid"></div>
        <div class="form-group" align="center">
            {!! Form::submit('Guardar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
        </div>
</div>
		
		{!! Form::close() !!}

@include ('layout.footer')