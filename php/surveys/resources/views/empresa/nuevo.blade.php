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

    {!! Form::open(array('url' => 'guardar_empresa_nuevo', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true,'onSubmit'=>'guardar();')) !!}
        <h2>Nueva empresa</h2> <hr />
<div class="row">
		<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre" value="">
            </div>
        </div>
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Direccion <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea id="direccion" name="direccion" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Direccion"></textarea>
            </div>
        </div>		
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Logo <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="file" name="logo" accept="image/gif, image/jpeg, image/png">
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