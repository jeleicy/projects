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

<form name="forma" action="guardar_texto_aceptacion_nuevo" method="post" class="form-horizontal" onsubmit="mirar_texto()">
		
		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		<!--input type="hidden" name="texto" id="texto" value="" /-->

        <h2>Nuevo Texto de Aceptacion</h2> <hr />
<div class="row">

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre" value="">
            </div>
        </div>
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Texto <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea id="texto" name="texto" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Texto"></textarea>
            </div>
        </div>		
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Bateria</label>
			<div class="col-md-6 col-sm-6 col-xs-12">		
				<select class="form-control" id="id_bateria" name="id_bateria">
					{{ FuncionesControllers::crear_combo('bateria', 0) }}
				</select>		
            </div>
        </div>		
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Empresa</label>
			<div class="col-md-6 col-sm-6 col-xs-12">		
				<select class="form-control" id="id_empresa" name="id_empresa">
					{{ FuncionesControllers::crear_combo('empresas', 0) }}
				</select>		
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