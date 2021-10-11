<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

	<?php
        $today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];
        $fecha_act = $dia."/".$mes."/".$ano;

		if (!isset($fecha_reporte1)) {
			$fecha_reporte1=$fecha_act;
			$fecha_reporte2=$fecha_act;
		}
		
		$escala=array(
			1=>"Ligeramente alcanzado",
			2=>"Parcialmente alcanzado",
			3=>"Totalmente alcanzado"
		);
	?>
	
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
						from autorizaciones a, resultados_potencial r, 
						usuarios u, empresas e
						where r.id_candidato=a.id and u.id=a.id_usuario and 
						e.id=a.id_empresas and 
						date(r.fecha) between '".FuncionesControllers::fecha_mysql($fecha_reporte1)."' and '".FuncionesControllers::fecha_mysql($fecha_reporte2)."' ";
						if (Session::get("rol")!="A") {
							if (Session::get("rol")=="EA")
								$sql .= " and a.id_empresas=".Session::get("id_empresa");
							if (Session::get("rol")=="ERRHH") {
								$sql .= " and a.id_empresas=".Session::get("id_empresa");
								$sql .= " and a.id_invitador=".Session::get("id_usuario");
							}
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
											from resultados_potencial
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