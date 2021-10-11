<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

@include ('layout.header_encuesta')

<div class="row">
	<div align="left" class="alert alert-success alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
		Su pago ha sido procesado exitosamente...<br /><br />
		Ahora debera llenar nuestro formulario: <br /><br />
	</div>
	{!! Form::open(array('url' => 'guardar_pago_exitodo', 'id'=>'forma_invitacion', 'name'=>'forma_invitacion', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="id_tipo_prueba" value="1" />
		<input type="hidden" name="id_idioma" value="<?=$id_idioma?>" />
		
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
		<br /><br />
		<div id="boton_2" align="center">
			<input type="submit" class="btn btn-primary" value="Guardar Datos">
		</div>		
	{!! Form::close() !!}
</div>

@include ('layout.footer_encuesta')