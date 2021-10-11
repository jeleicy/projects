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

    {!! Form::open(array('url' => 'consultar_asignacion2', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
        <div class="row">
            <div class="col-lg-30 text-center">
                <h1>Reportes de Asignaciones</h1>
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
							<th>Tipo Prueba</th>
							<th>Empresa</th>
							<th>Asignadas a</th>
							<th>Asignadas por</th>
							<th>Cantidad Asignada</th>
							<th>Cantidad Presentada</th>
							<th>Cantidad Restante</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$sql = "select pa.*, tp.nombre as nombre_prueba 
						from pruebas_asignadas pa, tipos_pruebas tp
						where date(pa.fecha_ingreso) between '".FuncionesControllers::fecha_mysql($fecha_reporte1)."' and '".FuncionesControllers::fecha_mysql($fecha_reporte2)."' ";
						if (Session::get("rol")=="EA") {
							$sql .= " and pa.id_empresa=".Session::get("id_empresa");
						} elseif (Session::get("rol")=="ERRHH") {
							$sql .= " and pa.id_usuario_asignado=".Session::get("id_usuario")." 
							 and pa.id_empresa=".Session::get("id_empresa");
						}
						$sql .= " and pa.id_tipo_prueba=tp.id group by pa.id_tipo_prueba";
						//echo $sql;
						$data=DB::select($sql);
						$i=1;
						foreach ($data as $data) {
							?>
								<tr>
									<th><input type="checkbox" name="tipo_prueba_<?php echo $data->id_tipo_prueba ?>" id="tipo_prueba_<?php echo $data->id_tipo_prueba ?>" value="<?php echo $data->id_tipo_prueba ?>" /></th>
									<th><?php echo $data->nombre_prueba; ?></th>
									<th><?php echo FuncionesControllers::buscar_empresa($data->id_empresa); ?></th>
									<th><?php echo FuncionesControllers::buscar_usuario($data->id_usuario_asignador); ?></th>
									<th><?php echo FuncionesControllers::buscar_usuario($data->id_usuario_asignado); ?></th>
									<th><?php echo $data->nro_asignadas; ?></th>
									<th><?php echo $data->nro_presentadas; ?></th>
									<th><?php echo $data->nro_asignadas-$data->nro_presentadas; ?></th>
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