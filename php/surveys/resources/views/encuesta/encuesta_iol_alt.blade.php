<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Form;
use URL;
use DB;

use trans;

$sql = "select * from autorizaciones_iol_alt where id=".$id_au;
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

@include('layout.header_encuesta')

    <div class="container">
    {!! Form::open(array('url' => 'guardar_encuesta_iol_alt', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="id" value="<?=$id_au?>">
		
		<input type="hidden" name="apellidos" value="-">
		<input type="hidden" name="nombres" value="-">
		<input type="hidden" name="email" value="-">
		<input type="hidden" name="cedula" value="-">
		<input type="hidden" name="edad" value="-">
		<input type="hidden" name="nivel_formacion" value="-">
		<input type="hidden" name="orientacion_area" value="-">
		<input type="hidden" name="orientacion_cargo" value="-">
		
        <div class="col-lg-15 text-center" id="participante_iol" style="display: inline;">
                <h1>{{ trans ('iol_test.iniciales_iol') }} ({{ trans ('iol_test.titulo_iol') }})</h1>
                <p class="lead">{{ trans('iol_test.Participante') }}:</p>
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Nombres') }} <span class="msj">(*)</span>:</label>
					<div class="col-md-1">
						<?=$nombre?>
					</div>
				</div>
				
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Apellidos') }} <span class="msj">(*)</span>:</label>
					<div class="col-md-1">
						<?=$apellido?>
					</div>
				</div>	

				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('iol_test.Cedula') }} <span class="msj">(*)</span>:</label>
					<div class="col-md-1">
						<?=$cedula?>
					</div>
				</div>

				<div align="center">
					<input onclick="ver_encuesta('iol_alt',<?php echo $tiempo; ?>,1)" type="button" class="btn btn-primary" value="{{ trans('iol_test.BotonComenzar') }}">
				</div>
		</div>
		
		<div id="instrucciones_iol" align="center" class="col-lg-10 text-left" style="display: none; margin:50px;font-size: 11pt; border-style: solid; border-color: #1abb9c; padding:10px; color: #1abb9c">
			<?php
				$sql = "select * from instrucciones where lower(nombre)='iol alt' and 
						id_prueba=".$id_tipo_prueba." and id_empresa=".$id_empresas." and id_idioma=".$id_idioma;

				$data=DB::select($sql);
				foreach ($data as $data) {
			?>
				<h2>Instrucciones {{ $data->nombre }}:</h2>
				<hr />
				<br /><br />
					{{ $data->texto }}
					
				{{ FuncionesControllers::prueba_inter(11) }}
					
			<?php 
				/*$tiempo=FuncionesControllers::buscarTiempo(1);
				
				$vista_prueba=substr($tiempo,strpos($tiempo,"/")+1);
				$tiempo=substr($tiempo,0,strpos($tiempo,"/"));*/				
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
				@include('encuesta.preguntas_iol_alt')
			</div>
		</div>
		
		{!! Form::close() !!}
	</div>
	
		<br /><br /><br />
		
        <!-- /.row -->
	
@include('layout.footer_encuesta')