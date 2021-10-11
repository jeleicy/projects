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
     {!! Form::model($instrucciones,array( 'name'=>"forma", 'onsubmit'=>"mirar_texto()", 'url' => 'guardar_instrucciones_edicion', 'method' => 'put', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		
		<input type="hidden" name="id" value="<?=$instrucciones->id?>" />
		
		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		<!--input type="hidden" name="texto" id="texto" value="" /-->
		
<div class="row">
		<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ Session::get("mensaje") }}
		</div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre" value="<?=$instrucciones->nombre?>">
            </div>
        </div>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Empresa</label>
			<div class="col-md-6 col-sm-6 col-xs-12">		
				<select class="form-control" id="id_empresa" name="id_empresa">
					{{ FuncionesControllers::crear_combo('empresas', $instrucciones->id_empresa) }}
				</select>		
            </div>
        </div>		
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de Prueba <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="id_prueba" name="id_prueba" class="form-control">
				<?php
					$sql = "select * from tipos_pruebas order by nombre";
					$data = DB::select($sql);
					foreach ($data as $data)
						if ($data->id==$instrucciones->id_prueba)
							echo "<option value=".$data->id." selected>".$data->nombre."</option>";
						else
							echo "<option value=".$data->id.">".$data->nombre."</option>";
				?>
				</select>
            </div>
        </div>
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Idioma de la Prueba <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">		
				<select id="id_idioma" name="id_idioma" class="form-control" >
					<option value="0">Seleccione...</option>
					{{ FuncionesControllers::crear_combo("idioma",$instrucciones->id_idioma) }}
				</select>
			</div>
		</div>		
				
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Estatus <span class="msj">(*)</span>:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="radio">
					<input class="flat" type="checkbox" id="activa" name="activa" value="1" <?php if ($instrucciones->activa==1) echo "checked"; ?>> Activo
				</div>
			</div>
        </div>
		
       <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Posicion al Ejemplo <span class="msj">(*)</span>:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="radio">
					<input class="flat" type="radio" id="posicion" name="posicion" value="0" <?php if ($instrucciones->posicion==0) echo "checked"; ?>> Antes &nbsp;&nbsp;&nbsp;&nbsp;
					<input class="flat" type="radio" id="posicion" name="posicion" value="1" <?php if ($instrucciones->posicion==1) echo "checked"; ?>> Despues
				</div>
			</div>
        </div>			
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Instrucciones <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
				<fieldset>
				  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
				  <script>tinymce.init({ selector:'textarea' });</script>				  
				  <textarea id="texto" name="texto">{{ $instrucciones->texto }}</textarea>
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
