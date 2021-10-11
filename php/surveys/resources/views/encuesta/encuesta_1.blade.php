<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Form;
use URL;
use DB;

use trans;

$sql = "select * from autorizaciones where id=".$id_au;
$data=DB::select($sql);
foreach ($data as $data) {
	$id_empresas=$data->id_empresas;
	$id_tipo_prueba=$data->id_tipo_prueba;
	$id_idioma=$data->id_idioma;
}

$sql = "select tiempo from tipos_pruebas where id=".$id_tipo_prueba;
$data=DB::select($sql);
foreach ($data as $data)
	$tiempo=$data->tiempo;

?>
<?php $datos_id=""; ?>
@include('layout.header_encuesta')

    <div class="container">
    {!! Form::open(array('name' => 'forma1', 'url' => 'guardar_encuesta', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="id" value="<?=$id_au?>">
        <div class="row" id="participante_iol" style="display: inline;">
            <div class="col-lg-15 text-center">
                <h1>{{ trans ('iol_test.iniciales_iol') }} ({{ trans ('iol_test.titulo_iol') }})</h1>
                <p class="lead">{{ trans('iol_test.Participante') }}:</p>
				
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Nombres') }}<span class="msj">(*)</span>:</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="nombres" name="nombres" type="text" data-validate-length-range="2" data-validate-words="1" required="required" class="form-control" placeholder="{{ trans('iol_test.Nombres') }}" value="<?=$nombre?>">
					</div>
				</div>				
				
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Apellidos') }} <span class="msj">(*)</span>:</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="apellidos" name="apellidos" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="{{ trans('iol_test.Apellidos') }}" value="<?=$apellido?>">
					</div>
				</div>	

				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Cedula') }} <span class="msj">(*)</span>:</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input onKeyPress="return soloNumeros(event)" id="cedula" name="cedula" maxlength="8" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="{{ trans('iol_test.Cedula') }}" value="">
					</div>
				</div>					
				
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Sexo') }} :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
							<input class="btn btn-success" type="radio" name="sexo" value="f"> &nbsp; {{ trans('iol_test.Femenino') }} &nbsp;
							<input class="btn btn-info" type="radio" name="sexo" value="m" checked=""> {{ trans('iol_test.Masculino') }}
						</label>
					</div>						
				</div>
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Email') }} :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input readonly id="email" name="email" type="email" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="{{ trans('iol_test.Email') }}" value="<?=$email?>">
					</div>
				</div>	
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Nacionalidad') }} :</label>
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Edad') }} :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input onKeyPress="return soloNumeros(event)" id="edad" maxlength="2" name="edad" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="{{ trans('iol_test.Edad') }}" value="">
					</div>
				</div>		
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Nivel') }}:</label>
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Area') }}:</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="orientacion_area" name="orientacion_area" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="{{ trans('iol_test.Area') }}" value="">
					</div>
				</div>					

				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Cargo') }}:</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="orientacion_cargo" name="orientacion_cargo" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="{{ trans('iol_test.Cargo') }}" value="">
					</div>
				</div>
				<!--div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">¿Es usted Coach? :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
								<input class="btn btn-success" type="radio" id="coach1" name="coach" value="1"> &nbsp; Si &nbsp;
								<input class="btn btn-success" type="radio" id="coach0" name="coach" value="0"> No
							</label>
						</div>
					</div>
				</div-->

				<div id="datos_coach" style="display: none;">
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Escuela en la que se formo :</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="escuela_formo" name="escuela_formo" type="text" data-validate-length-range="2" data-validate-words="1" required="required" class="form-control" placeholder="Escuela en la que se formo" value="">
						</div>
					</div>
					
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Tiempo de la formacion :</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="tiempo_formo" name="tiempo_formo" type="text" data-validate-length-range="2" data-validate-words="1" required="required" class="form-control" placeholder="Tiempo de la formacion" value="">
						</div>
					</div>	

					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Año en que se certifico :</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input onKeyPress="return soloNumeros(event)" maxlength="4" id="ano_certificacion" name="ano_certificacion" type="text" data-validate-length-range="2" data-validate-words="1" required="required" class="form-control" placeholder="Año en que se certifico" value="">
						</div>
					</div>
				</div>	

				<div align="center">
					<input onclick="ver_encuesta('iol',<?php echo $tiempo; ?>,1)" type="button" class="btn btn-primary" value="{{ trans('iol_test.BotonComenzar') }}">
				</div>		
            </div>		
		</div>
		
	<div id="instrucciones_iol" align="center" class="col-lg-10 text-left" style="display:none;  margin:50px;font-size: 11pt; border-style: solid; border-color: #1abb9c; padding:10px; color: #1abb9c">
		<?php
			$sql = "select * from instrucciones where id_prueba=".$id_tipo_prueba." and
					id_empresa=".$id_empresas." and id_idioma=".$id_idioma." limit 1";
			//echo "sql=".$sql;
			$data=DB::select($sql);
			foreach ($data as $data) {
		?>
	
		<h2>Instrucciones {{ $data->nombre }}:</h2>
		<hr />
		<br /><br />
			<?php echo utf8_decode($data->texto); ?>			
			{{ FuncionesControllers::prueba_inter(10) }}

		<?php
			$tiempo=FuncionesControllers::buscarTiempo(1);
			
			$vista_prueba=substr($tiempo,strpos($tiempo,"/")+1);
			$tiempo=substr($tiempo,0,strpos($tiempo,"/"));
		}
		?>
		
		<br /><br />
		<div align="center">
			<input style="display:none;" id="comenzar_instrucciones_iol" onclick="ver_encuesta('iol',<?php echo $tiempo; ?>,2)" type="button" class="btn btn-primary" value="Comenzar Encuesta">
		</div>		
	</div>		
	
	<div id="encuesta_iol" align="center"  style="border: 0px solid red; width: 100%; background: gray; margin-top: 2%; margin-left: 50%; padding: 0; display: none">
		<div align="center" id="texto_dentro" style="width: 100%; background: gray; margin: 0; border-radius: 25px;">
			<strong><h1 style="color: #1abb9c; texty-align: center">{{ trans('iol_test.Comienza') }}</h1></strong>
			@include('encuesta.preguntas_1',["datos_id"=>$datos_id])
		</div>
	</div>
	
	{!! Form::close() !!}
	
	</div>
		
        <!-- /.row -->