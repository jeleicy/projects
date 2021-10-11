<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use Session;
use DB;
use Form;

?>

@include('layaout.header')

<?php
	if (Session::get('mensaje')!="")
		echo "<script>alert('".Session::get('mensaje')."');</script>";
?>

<div class="col-lg-4 col-lg-offset-4 mt centered">
	<h4>Ingresar al Sistema</h4>
	{!! Form::open(array('url' => 'logueo', 'method' => 'post')) !!}
	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	  <div class="form-group">
		<label class="sr-only" for="exampleInputEmail2">Email address</label>
		<input type="email" class="form-control" id="email" name="email" placeholder="Ingrese email">
		<input type="password" class="form-control" id="pass" name="pass" placeholder="Ingrese contraseña">
	  </div>
	  <br /><br />
	  <button type="button" class="btn btn-info" onclick="validar_autenticacion(this.form)">Ingresar</button>
	  <!--button type="button" class="btn btn-info" onclick="validar_olvido(this.form)">Olvido Contraseña</button-->
	{!! Form::close() !!}
</div>

@include('layaout.footer')