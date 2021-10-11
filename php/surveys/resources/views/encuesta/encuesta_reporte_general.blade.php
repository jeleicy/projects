<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

@include('layout.header')
	<br /><br /><br />
	
	<?php
        $today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];
        $fecha_act = $dia."/".$mes."/".$ano;
		
		/*$sql = "select * from bateria where activa=1 and id=$id_tipo_prueba";
		$data=DB::select($sql);
		foreach ($data as $data)
			$nombre_prueba=strtoupper($data->nombre);
			
			if ($id_tipo_prueba>2)
				$id=3;
			else
				$id=$id_tipo_prueba;
			
		$reporte='encuesta.reporte_'.$id;
		
		if (!isset($fecha_reporte1)) {
			$fecha_reporte1=$fecha_act;
			$fecha_reporte2=$fecha_act;
		} else {
			$f1=explode(" ",$fecha_reporte1);
			$f2=explode(" ",$fecha_reporte2);
			
			$meses = array ("Enero"=>1, "Febrero"=>2, "Marzo"=>3, "Abril"=>4, "Mayo"=>5, 
			"Junio"=>6, "Julio"=>7, "Agosto"=>8, "Septiembre"=>9, "Octubre"=>10, 
			"Noviembre"=>11, "Diciembre"=>12);
			
			if (strpos($fecha_reporte1,"/") === false) $fecha_reporte1=$f1[0]."/".$meses[$f1[1]]."/".$f1[2];
			if (strpos($fecha_reporte2,"/") === false) $fecha_reporte2=$f2[0]."/".$meses[$f2[1]]."/".$f2[2];				
		}*/
	?>
	
    <div class="container">
    {!! Form::open(array('url' => 'consultar_encuesta_general', 'onsubmit'=>'Javascript: prox_pagina()', 'method' => 'get', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="id_tipo_prueba" value="<?=$id_tipo_prueba?>">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Reporte General</h1>
				<div class="col-lg-12 text-center">
					<div class="form-group">			
						<label for="dtp_input2" class="col-md-2 control-label"> Fecha Desde: </label>
						<div class="input-group date fecha_reporte1 col-md-2" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
							<input id="fecha_reporte1" name="fecha_reporte1" class="form-control" size="16" type="text" value="<?php echo $fecha_reporte1; ?>" readonly>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
						<label for="dtp_input2" class="col-md-2 control-label"> Fecha Hasta: </label>				
						<div class="input-group date fecha_reporte2 col-md-2" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
							<input id="fecha_reporte2" name="fecha_reporte2" class="form-control" size="16" type="text" value="<?php echo $fecha_reporte2; ?>" readonly>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
						<input type="hidden" id="dtp_input2" value="" /><br/>
					</div>		
				</div>
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Cedula <span class="msj">(*)</span>:</label>
					<div class="col-md-2">
						<input onKeyPress="return soloNumeros(event)" id="cedula" name="cedula" maxlength="8" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Cedula" value="">
					</div>
				</div>					
			</div>
			<div class="col-md-7">
				<div class="form-group" align="center">
				{!! Form::submit('Consultar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
				</div>
			</div>
		</div>
	<?php if (isset($fecha_reporte1)) { ?>
		<div class="form-group">
			@include('encuesta.general', ['id_tipo_prueba' => $id_tipo_prueba, 'nombre_prueba'=>'General'])
		</div>
	<?php } ?>
    <script type="text/javascript">
		$(document).ready(function() {
			$('#tabla_reportes').DataTable();
		} );
    </script>				
		
        <!-- /.row -->
{!! Form::close() !!}

	<script type="text/javascript">
	$(function() {
		$('input[name="fecha_reporte"]').daterangepicker();
	});
	</script>


			
@include('layout.footer')