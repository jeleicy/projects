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

    {!! Form::open(array('url' => 'guardar_cambiar_contrasena', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
        <h2>Nueva usuario</h2> <hr />
<div class="row">
		<div align="left" class="alert alert-{{ $tipo }} alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>

        <div class="form-group" id="ver_pass">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Contraseña <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" name="password" type="password" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Password">
            </div>
        </div>
        <div class="form-group" id="ver_pass">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Repita su Contraseña <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password2" name="password2" type="password" data-validate-words="1" required="required" class="form-control" placeholder="Password">
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