<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

@include ('layout.header')

    {!! Form::open(array('url' => 'guardar_prueba', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true, 'onSubmit' =>  "Javascript: guardar()")) !!}
        <h2>Nuevo Tipo de Prueba</h2> <hr />
<div class="row">
		<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombre" name="nombre" type="text" required="required" class="form-control" placeholder="Nombres" value="">
            </div>
        </div>
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">URL <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="url" name="url" type="text" required="required" class="form-control" placeholder="URL" value="">
            </div>
        </div>		
		
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Tiempo <span class="msj">(*)</span>:</label>
				<div class="col-md-1 col-sm-1 col-xs-1">
					<input onBlur="soloNumeros(this)" id="tiempo" name="tiempo" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Tiempo" value=""> Minutos
				</div>
			</div>				
		
		
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Activo <span class="msj">(*)</span>:</label>
			<div class="col-md-2">
				<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
					<input class="btn btn-success" type="radio" name="activo" value="1"> &nbsp; SI &nbsp;
					<input class="btn btn-info" type="radio" name="activo" value="0" checked=""> NO
				</label>
			</div>						
		</div>
	
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Muestra del tiempo:</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
					<input class="btn btn-success" type="radio" name="vista_tiempo" value="1"> &nbsp; Si &nbsp;
					<input class="btn btn-info" type="radio" name="vista_tiempo" value="0" checked=""> No
				</label>
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