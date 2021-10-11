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

    {!! Form::open(array('url' => 'consultar_evaluadores2', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
        <h2>Consulta de Invitaciones</h2> <hr />
		
		<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>		
		
        <div class="row">
            <div class="col-lg-30 text-center">
                <h1>Reportes de Evaluadores</h1>
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
		
		{!! Form::open(array('url' => 'recordar', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<div class="form-group">
			<div class="dataTable_wrapper">
				<table width="100%" class="table table-striped table-bordered table-hover" id="tabla_reportes">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>Evaluador</th>
							<th>Correo Evaluador</th>					
							<th>Invitaciones</th>
							<th>Invitaciones Realizadas</th>
							<th>Invitaciones Pendientes</th>
							<!--th>&nbsp;</th-->
						</tr>
					</thead>
					<tbody>
					<?php
						$sql = "select count(a.id) as cantidad, 
						u.id, u.nombres, u.email 
						from usuarios u, autorizaciones a 
						where u.id=a.id_usuario and 
						date(a.fecha) between '".FuncionesControllers::fecha_mysql($fecha_reporte1)."' and '".FuncionesControllers::fecha_mysql($fecha_reporte2)."' ";
						if (Session::get("rol")!="A") {
							$sql .= " and a.id_invitador=".Session::get("id_usuario")." 
							and a.id_empresas=".Session::get("id_empresa");
						}
						$sql .= " group by u.id, u.nombres, u.email order by u.nombres";

						$data=DB::select($sql);
						$i=1;
						foreach ($data as $data) {
							$pendientes=FuncionesControllers::buscar_evaluaciones($data->id, $fecha_reporte1, $fecha_reporte2, 0);
							$listas=FuncionesControllers::buscar_evaluaciones($data->id, $fecha_reporte1, $fecha_reporte2, 1);
							?>
								<tr>
									<th><?php if ($pendientes>0) echo "<input type='checkbox' name='chk_".$data->id."' id='chk_".$data->id."' value='".$data->id."'>"; else echo "&nbsp;"; ?></th>
									<th><?php echo $data->nombres; ?></th>
									<th><?php echo $data->email; ?></th>
									<th><?php echo $data->cantidad; ?></th>
									<th><?php echo $listas; ?></th>
									<th><?php echo $pendientes; ?></th>
									<!--th>
										<?php
											$f1=str_replace("/", "-",$fecha_reporte1);
											$f2=str_replace("/", "-",$fecha_reporte2);
											if ($pendientes>0)
												echo '<a href="recordar/'.$data->id.'..'.$f1.'..'.$f2.'">Recordar Invitaciones Pendientes</a>';
											else
												echo "&nbsp;";
										?>
									</th-->
								</tr>				
							<?php
						}
					?>
					</tbody>	
				</table>
				<div class="col-md-7">
					<div class="form-group" align="center">
					{!! Form::submit('Recordar Invitaciones Pendientes', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
					</div>
				</div>				
			</div>
		</div>
		{!! Form::close() !!}		

@include ('layout.footer')