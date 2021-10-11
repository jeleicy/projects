<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\monedaControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\URL;

//echo "<br>id_pregunta=".$id_pregunta;
//echo "<br>id_tipo_prueba=".$id_tipo_prueba;

$sql = "select tabla_preguntas, tabla_opciones, nombre
		from tipos_pruebas 
		where id=$id_tipo_prueba";
$data = DB::select($sql);

foreach ($data as $data) {
	$nombre=$data->nombre;
}

?>

@include('layout.header')
{!! Form::open(array('url' => 'guardar_pregunta_editar', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true) !!}

	<input type="hidden" name="id_pregunta" value="{{ $id_pregunta }}">
	<input type="hidden" name="id_tipo_prueba" value="{{ $id_tipo_prueba }}">
        <h2>Pregunta de la prueba: <strong>{{ $nombre }} </strong></h2> <hr />
<div class="row">
		<div align="left" class="alert alert-success alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombre" name="nombre" type="text" required="required" class="form-control" placeholder="Nombres" value="">
            </div>
        </div>
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Idioma de la Pregunta <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">		
				<select id="id_idioma" name="id_idioma" class="form-control" >
					<option value="0">Seleccione...</option>
					{{ FuncionesControllers::crear_combo("idioma",0) }}
				</select>
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
		
        <br />
        <div class="ln_solid"></div>
        <div class="form-group" align="center">
            {!! Form::submit('Guardar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
        </div>
</div>
		
		{!! Form::close() !!}@include('layout.footer')