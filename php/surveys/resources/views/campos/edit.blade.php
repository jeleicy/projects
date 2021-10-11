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
     {!! Form::model($campos,array( 'name'=>"forma", 'onsubmit'=>"mirar_texto()", 'url' => 'guardar_campos_edicion', 'method' => 'put', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		
		<input type="hidden" name="id" value="<?=$campos->id?>" />
		
		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		<!--input type="hidden" name="texto" id="texto" value="" /-->
		
<div class="row">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre" value="<?=$campos->nombre?>">
            </div>
        </div>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Empresa</label>
			<div class="col-md-6 col-sm-6 col-xs-12">		
				<select class="form-control" id="id_empresas" name="id_empresas">
					{{ FuncionesControllers::crear_combo('empresas', $campos->id_empresas) }}
				</select>		
            </div>
        </div>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">¿Obligatorio?</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="radio" value="1" name="obligatorio" id="obligatorio" <?php if ($campos->obligatorio==1) echo "checked"; ?>>Si
				<input type="radio" value="0" name="obligatorio" id="obligatorio" <?php if ($campos->obligatorio==0) echo "checked"; ?>>No
            </div>
        </div>			
		
		<!--'SELECCION SIMPLE','SELECCION MULTIPLE','SELECCION SIMPLE CON COMENTARIO','ABIERTO'-->
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Tipo de Campo</label>
			<div class="col-md-6 col-sm-6 col-xs-12">		
				<select class="form-control" id="tipo_campo" name="tipo_campo">
					<option value="SELECCION SIMPLE" <?php if ($campos->tipo_campo=="SELECCION SIMPLE") echo "selected"; ?>>SELECCION SIMPLE</option>
					<option value="SELECCION MULTIPLE" <?php if ($campos->tipo_campo=="SELECCION MULTIPLE") echo "selected"; ?>>SELECCION MULTIPLE</option>
					<option value="SELECCION SIMPLE CON COMENTARIO" <?php if ($campos->tipo_campo=="SELECCION SIMPLE CON COMENTARIO") echo "selected"; ?>>SELECCION SIMPLE CON COMENTARIO</option>					
					<option value="ABIERTO" <?php if ($campos->tipo_campo=="ABIERTO") echo "selected"; ?>>ABIERTO</option>
				</select>		
            </div>
        </div>		
		
		<?php
			if ($campos->tipo_campo=="ABIERTO")
				$display="none";
			else
				$display="inline";			
		?>
		
		<div id="valores_tipo_campo" style="display:{{ $display }}">
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Valores tipo del campo<span class="msj">(*)</span>:</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="valores" name="valores" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Valores tipo del campo" value="<?=$campos->valores?>">
					<span style="color:red">Por favor los valores van separados por comas (,)</span>
				</div>
			</div>		
		</div>		
				
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Estatus <span class="msj">(*)</span>:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="radio">
					<input class="flat" type="checkbox" id="activa" name="activa" value="1" <?php if ($campos->activa==1) echo "checked"; ?>> Activo
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
