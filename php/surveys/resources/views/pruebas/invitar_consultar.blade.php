<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

	$today = @getdate();
	
	$dia = $today["mday"];
	$mes = $today["mon"];
	$ano = $today["year"];
	$fecha_act = $dia."/".$mes."/".$ano;

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
	}
	

?>

@include ('layout.header')

    {!! Form::open(array('url' => 'consultar_invitacion2', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
        <h2>Consulta de Invitaciones</h2> <hr />
		
		<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>			
		
        <div class="row">
            <div class="col-lg-30 text-center">
                <h1>Reportes de Potencial</h1>
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
			<div class="col-md-7">
				<div class="form-group" align="center">
				{!! Form::submit('Consultar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
				</div>
			</div>
		</div>		
		{!! Form::close() !!}
		
		{!! Form::open(array('url' => 'eliminar_evaluacion', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<div class="form-group">
			<div class="dataTable_wrapper">
				<table width="100%" class="table table-striped table-bordered table-hover" id="tabla_reportes">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>Evaluador</th>
							<th>Correo Evaluador</th>
							<th>Evaluado</th>
							<th>Correo Evaluado</th>							
							<th>Fecha Invitacion</th>
							<th>Evaluacion Realizada</th>
							<th>Fecha Evaluacion</th>							
						</tr>
					</thead>
					<tbody>
					<?php
						$sql = "select distinct(a.id) as id, 
						a.nombre_evaluado as evaluado, a.correo_evaluado,
						u.nombres as evaluador, u.email as correo_evaluador, a.fecha, a.presento
						from autorizaciones a, usuarios u, candidatos c
						where u.id=a.id_invitador and c.id=a.id_usuario and  
						date(a.fecha) between '".FuncionesControllers::fecha_mysql($fecha_reporte1)."' and '".FuncionesControllers::fecha_mysql($fecha_reporte2)."' ";
						if (Session::get("rol")!="A") {
							$sql .= " and a.id_empresas=".Session::get("id_empresa");
						}
						$sql .= " order by a.fecha";
						//echo $sql;
						$data=DB::select($sql);
						$i=1;
						foreach ($data as $data) {
							?>
								<tr>
									<th>
										<?php
											if ($data->presento==0)
												echo '<input type="checkbox" name="chk_'.$data->id.'" id="chk_'.$data->id.'" value="'.$data->id.'">';
											else
												echo '&nbsp;';										
										?>
									</th>
									<th><?php echo $data->evaluador; ?></th>
									<th><?php echo $data->correo_evaluador; ?></th>
									<th><?php echo $data->evaluado; ?></th>
									<th><?php echo $data->correo_evaluado; ?></th>									
									<th><?php echo FuncionesControllers::fecha_normal(substr($data->fecha,0,11)); ?></th>
									<?php
										if ($data->presento==1) {
											echo '<th>SI</th>';
											echo '<th>'.FuncionesControllers::fecha_normal(substr($data->fecha,0,11)).'</th>';
										} else {
											echo '<th align="center">NO</th>';
											echo '<th>&nbsp;</th>';
										}
									?>									
								</tr>				
							<?php
						}
					?>
					</tbody>	
				</table>
				<div class="col-md-7">
					<div class="form-group" align="center">
					{!! Form::submit('Eliminar Invitaciones', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
					</div>
				</div>				
			</div>
		</div>
		{!! Form::close() !!}		

@include ('layout.footer')