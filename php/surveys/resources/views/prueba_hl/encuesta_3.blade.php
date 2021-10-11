<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Redirect;
use Form;
use App\Http\Controllers\FuncionesControllers;

use PDF;

?>
@include('layout.header_encuesta')
    <div class="container">
<?php
/*
	$sql="delete from pruebas_presentadas where id_autorizacion=362;";
	DB::delete($sql);
	$sql="delete from respuestas_hl where id_autorizacion=362 and id_pruebas>1;";
	DB::delete($sql);
*/
	if ($mensaje!="") {
		echo "<h2>".$mensaje."</h2>";
	} else {

	//$sql = "delete from pruebas_presentadas where id_autorizacion=233";
	//DB::delete($sql);
	
	//$sql = "delete from respuestas_hl where id_autorizacion=233";
	//DB::delete($sql);	

	$sql = "select * from candidatos where id_autorizacion=".$id_au;
	$data=DB::select($sql);
	
	$nombres="";
	$apellidos="";
	$email="";
	
	foreach ($data as $data) {
		$nombres=$data->nombres;
		$apellidos=$data->apellidos;
		$email=$data->email;
	}
	
	$pruebas=0;
	//PRUEBA CC
	$sql = "select rhl.id from respuestas_hl rhl, preguntas_hl phl
		where rhl.id_autorizacion=".$id_au." and rhl.id_opcion=phl.id_preguntas and 
		rhl.id_pruebas=1";
	//echo "<br>$sql";
	$data=DB::select($sql);
	$cantidad_respuestas=count($data);
	if ($cantidad_respuestas>0) {
		$pruebas++;	
		$pruebas++;
	}
	
	//PRUEBA HI
	$sql = "select rhl.id from respuestas_hl rhl, opciones_hl ohl
		where rhl.id_autorizacion=".$id_au." and rhl.id_opcion=ohl.id_opciones and 
		rhl.id_pruebas=2";
	//echo "<br>$sql";
	$data=DB::select($sql);	
	$cantidad_respuestas=count($data);
	if ($cantidad_respuestas>0)
		$pruebas++;	
	
	//PRUEBA IEP
	$sql = "select rhl.id from respuestas_hl rhl, opciones_hl ohl
		where rhl.id_autorizacion=".$id_au." and rhl.id_opcion=ohl.id_opciones and 
		rhl.id_pruebas=3";
	//echo "<br>$sql";
	$data=DB::select($sql);	
	$cantidad_respuestas=count($data);
	if ($cantidad_respuestas>0)
		$pruebas++;
	
	$pruebas++;
	echo "<script>nro_prueba=".$pruebas.";</script>";
	$pruebas--;
	
?>

    {!! Form::open(array('url' => 'guardar_encuesta', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="id_au" value="<?=$id_au?>">
		<input type="hidden" name="bateria" id="bateria" value="<?=$id_bateria?>" />
		
		<div id="datos_prueba" align="center"></div>
		<?php if ($pruebas==0) { ?>
		<div id="datos_participante">
			<div class="row">
				<div class="col-lg-15 text-center">
					<h1>PRUEBA HI</h1>
					<p class="lead">PARTICIPANTE:</p>
					
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Nombres <span class="msj">(*)</span>:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="nombres" name="nombres" type="text" data-validate-length-range="2" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="{{ $nombres }}">
						</div>
					</div>				
					
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Apellidos <span class="msj">(*)</span>:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="apellidos" name="apellidos" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Apellidos" value="{{ $apellidos }}">
						</div>
					</div>	

					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Documento de Identidad:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input onKeyPress="return soloNumeros(event)" id="cedula" name="cedula" maxlength="8" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Cedula" value="">
						</div>
					</div>					
					
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
								<input class="btn btn-success" type="radio" name="sexo" value="f"> &nbsp; Femenino &nbsp;
								<input class="btn btn-info" type="radio" name="sexo" value="m" checked=""> Masculino
							</label>
						</div>						
					</div>
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Email:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input readonly id="email" name="email" type="email" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Email" value="{{ $email }}">
						</div>
					</div>	
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Pais de Nacimiento:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="nacionalidad" name="nacionalidad" class="form-control" name="nacionalidad">
								<option value='Argentina'>Argentina</option>
								<option value='Bahamas'>Bahamas</option>
								<option value='Barbados'>Barbados</option>
								<option value='Belice'>Belice</option>
								<option value='Bolivia'>Bolivia</option>
								<option value='Brasil'>Brasil</option>
								<option value='Canada'>Canada</option>
								<option value='Colombia'>Colombia </option>
								<option value='Costa Rica'>Costa Rica</option>
								<option value='Cuba'>Cuba</option>
								<option value='Chile'>Chile</option>
								<option value='Dominica'>Dominica</option>
								<option value='Ecuador'>Ecuador</option>
								<option value='El Salvador'>El Salvador</option>
								<option value='Estados Unidos'>Estados Unidos</option>
								<option value='Granada'>Granada</option>
								<option value='Guatemala'>Guatemala</option>
								<option value='Guyana'>Guyana</option>
								<option value='Haiti'>Haiti</option>
								<option value='Honduras'>Honduras</option>
								<option value='Jamaica'>Jamaica</option>
								<option value='Mexico'>Mexico</option>
								<option value='Nicaragua'>Nicaragua</option>
								<option value='Panama'>Panama</option>
								<option value='Paraguay'>Paraguay</option>
								<option value='Peru'>Peru</option>
								<option value='Republica Dominicana'>Republica dominicana </option>
								<option value='San Cristabal y Nieves'>San Cristabal y Nieves</option>
								<option value='San Vicente y las Granadinas'>San Vicente y las Granadinas </option>
								<option value='Santa Lucia'>Santa Lucia </option>
								<option value='Surinam'>Surinam</option>
								<option value='Trinidad y Tobago'>Trinidad y Tobago </option>
								<option value='Uruguay'>Uruguay</option>
								<option value='Venezuela' selected>Venezuela</option>						
								<option value='Otro'>Otro</option>
							</select>
						</div>
					</div>	
									
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Edad:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input onKeyPress="return soloNumeros(event)" id="edad" maxlength="2" name="edad" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Edad" value="">
						</div>
					</div>		
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Nivel de Formacion Academica:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="nivel_formacion" name="nivel_formacion" class="form-control" name="nacionalidad">
								<option value='Basica'>Basica</option>
								<option value='Bachiller'>Bachiller</option>
								<option value='TSU'>TSU</option>
								<option value='Universitaria no Completa'>Universitaria no Completa</option>
								<option value='Universitaria Completa'>Universitaria Completa</option>
								<option value='Postgrado'>Postgrado</option>
								<option value='Master'>Master</option>
							</select>
						</div>
					</div>
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Area de Especialidad:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="orientacion_area" name="orientacion_area" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Area de Especialidad" value="">
						</div>
					</div>					

					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Cargo de ocupa / aspira:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="orientacion_cargo" name="orientacion_cargo" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Cargo de ocupa / aspira" value="">
						</div>
					</div>			
					
					<div class="clearfix"></div>
					<div id="boton_2" align="center">
						<input onclick="guardar_participante()" type="button" class="btn btn-primary" value="Comenzar Prueba">
					</div>
				</div>			
			</div>
		</div>
		<?php } ?>
		
		{!! Form::close() !!}
<?php } ?>	
@include('layout.footer_encuesta')