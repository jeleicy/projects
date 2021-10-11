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
		
		$escala=array(
			1=>"Ligeramente",
			2=>"Parcialmente",
			3=>"Totalmente"
		);	
	?>
	
    <div class="container" style="padding:0px; margin:0px">
    {!! Form::open(array('url' => 'consultar_potencial', 'method' => 'get', 'class' =>  "form-horizontal", 'files'=>true)) !!}
        <div class="row">
            <div class="col-lg-12 text-center">
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
	<?php if (isset($fecha_reporte1)) { ?>
		<div class="form-group">
			<div class="dataTable_wrapper">
				<table id="tabla_reportes" class="display" cellspacing="0" width="150%">
				<!--table width="100%" class="table table-striped table-bordered table-hover" id="tabla_reportes"-->
					<thead>
						<tr>
							<th width="5%">Participante</th>
							<th width="5%">Evaluador</th>
							<th width="5%">Creador</th>
							<th width="5%">Empresa</th>
							<th width="5%">Solución de Problemas</th>
							<th width="5%">Conocimiento del Negocio</th>
							<th width="5%">Habilidades Sociales</th>
							<th width="5%">Liderazgo</th>
							<th width="5%">Autodesarrollo</th>
							<th width="5%">Automotivación</th>
							<th width="5%" align="center" class="alert alert-info alert-dismissible fade in">Total</th>
							<th>Pentil</th>
							<th width="5%">Fecha</th>
							<th width="5%">Hora</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$sql = "select distinct(a.id) as id, a.nombre_evaluado, 
						u.nombres as nombre_evaluador, e.nombre as empresa, a.id_invitador
						from autorizaciones a, resultados r, usuarios u, empresas e
						where r.id_candidato=a.id and u.id=a.id_usuario and 
						e.id=a.id_empresas and 
						date(r.fecha) between '".FuncionesControllers::fecha_mysql($fecha_reporte1)."' and '".FuncionesControllers::fecha_mysql($fecha_reporte2)."' ";
						if (Session::get("rol")!="A") {
							$sql .= " and a.id_invitador=".Session::get("id_usuario")." 
							and a.id_empresas=".Session::get("id_empresa");
						}
						$sql .= " order by r.id_opciones";
						$data=DB::select($sql);
						$i=1;
						foreach ($data as $data) {
							?>
								<tr>								
									<th><?php echo $data->nombre_evaluado; ?></th>
									<th><?php echo $data->nombre_evaluador; ?></th>
									<th><?php 
										$sql = "select * from usuarios where id=".$data->id_invitador;
										$invitador=DB::select($sql);
										foreach ($invitador as $invitador)
											echo $invitador->nombres;
									?></th>
									<th><?php echo $data->empresa; ?></th>
									<?php
										$valor=0;
										for ($i=1; $i<7; $i++) {
											$sql = "select fecha, valor, id_opciones
											from resultados
											where id_candidato=".$data->id." and id_opciones=".$i." and
											date(fecha) between '".FuncionesControllers::fecha_mysql($fecha_reporte1)."' and '".FuncionesControllers::fecha_mysql($fecha_reporte2)."' ";
											$sql .= " order by id_opciones";
											$data2=DB::select($sql);
											$j=1;
											foreach ($data2 as $data2) {
												if ($j==1) {
													echo '<th>'.number_format($data2->valor,2,",",".").' ('.$escala[round($data2->valor)].')</th>';
													$fecha=$data2->fecha;
													$valor+=$data2->valor;
												}
												$j++;
											}
										}
									?>
									<th align="center" class="alert alert-info alert-dismissible fade in"><?php echo number_format(($valor/6),2,",","."); ?></th>
									<th align="center" class="alert alert-info alert-dismissible fade in">
										<?php
											$valor_pentil=array(
												1=>"Bajo Potencial",
												2=>"Bajo Potencial",
												3=>"Potencial",
												4=>"Alto Potencial",
												5=>"Alto Potencial",
											);
											$pentil = number_format(($valor/6),2,",",".");
											
											$pentil = str_replace(",",".",$pentil);
											if ($pentil>0 && $pentil<1.85)
												$valor=1;
											elseif ($pentil>1.84 && $pentil<2.18)
												$valor=2;
											elseif ($pentil>2.17 && $pentil<2.67)
												$valor=3;	
											elseif ($pentil>2.66 && $pentil<2.91)
												$valor=4;	
											elseif ($pentil>2.90 && $pentil<3.1)
												$valor=5;												
											
											echo $valor." - ".$valor_pentil[$valor];
										?>
									</th>
									<th><?php echo FuncionesControllers::fecha_normal(substr($fecha,0,10)); ?></th>
									<th><?php echo substr($fecha,11); ?></th>
								</tr>						
							<?php
							$i++;
						}
					?>
					</tbody>	
				</table>
			</div>
		</div>
	<?php } ?>
			
		</div>
        <!-- /.row -->
{!! Form::close() !!}

	<!--script type="text/javascript">
	$(function() {
		$('input[name="fecha_reporte"]').daterangepicker();
	});
	</script-->
			
@include('layout.footer')