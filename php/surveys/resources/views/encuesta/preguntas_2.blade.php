<?php
	$potencial[1]="Capacidad de ir más allá del planteamiento inicial de un problema y de generar soluciones radicales e integrales, bien fundamentadas.";
	$potencial[2]="Capacidad para desarrollar una visión amplia del negocio independiente del área o nivel en el que se encuentra. Habilidad para relacionar información externa e interna de forma relevante y de dimensionar el impacto que tales variables tiene en la estrategia del negocio y su área de responsabilidad.";
	$potencial[3]="Capacidad para establecer y mantener relaciones interpersonales fluidas y sólidas.Escucha y considera los puntos de vista de los demás para enriquecer su propia perspectiva.Habilidad de relacionarse con otros para obtener resultados efectivos en conjunto.Muestra interés y respeto genuino por el otro.";
	$potencial[4]="Capacidad para influir positiva y directamente en la conducta de los demás (superiores, proveedores, pares, clientes, etc) logrando resultados efectivos, alineados y contributorios con y a través de ellos.";
	$potencial[5]="Capacidad de evaluar y reflexionar sobre sus propios procesos, actuaciones e interacciones, aprender de ello y modificar su conducta. Encara las distintas situaciones con madurez, autonomía y conciencia de las consecuencias de sus actos.";
	$potencial[6]="Capacidad para hacer que las cosas sucedan. Usar los recursos y capacidades personales para asumir retos y fijarse metas desafiantes, manejar y modificar su entorno de acción. Decidido por alcanzar cada vez mayores y mejores estándares de logro.";
?>

<div class="">	
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-15 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<!-- Smart Wizard -->
						<!--div class="label label-primary" style="font-size: 12pt;" align="right">Su prueba culminara en <span id="time">05:00</span> minutos!</div-->
						<div id="wizard" class="form_wizard wizard_horizontal" style="margin: 15px; padding: 10px">
							<div style="color: red; font-size: 7pt;" id="error"></div>
							<ul class="wizard_steps">
							<?php
								$sql = "select id_opciones, nombre
								from opciones_potencial";
								$data = DB::select($sql);
								$j=1;
								foreach ($data as $data) {
									?>
									<li>
										<a href="#step-<?php echo $j; ?>">
											<span class="step_no"><?php echo $j; ?></span>                                            
                                            <small><?php echo $data->nombre; ?></small>											
										</a>
									</li>
									<input type="hidden" name="op_<?php echo $data->id_opciones; ?>" id="op_<?php echo $data->id_opciones; ?>" value="0" />
									<?php
									$j++;
								}
							?>
							</ul>

							<?php for ($i=1; $i<$j; $i++) { ?>
							<div id="step-<?php echo $i; ?>" align= "center">
								<form id="forma" name="forma<?php echo $i; ?>" class="form-horizontal form-label-left">
									<div class="col-md-12">
										<table border=0 cellpadding="5" cellspacing="5">
											<tr>
												<td colspan="2" align="right">
													<div align="left" class="alert alert-success alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;" id="suma_op_<?php echo $i; ?>">
														<?php echo $potencial[$i]; ?>
													</div>
												</td>
											</tr>
											<tr><td>&nbsp;</td><td align="center">Alcanzado</td></tr>
											<?php
												$sql = "select count(*) as cantidad 
												from preguntas_potencial
												where id_opciones=".$i;
												$data2 = DB::select($sql);
												foreach ($data2 as $data2)
													$cantidad=$data2->cantidad;
											
												$sql = "select p.id_preguntas, o.nombre as opciones, p.nombre as preguntas
												from opciones_potencial o, preguntas_potencial p
												where o.id_opciones=".$i." and o.id_opciones=p.id_opciones 
												order by id_preguntas";
												$data2 = DB::select($sql);
												$h=0;
												foreach ($data2 as $data2) {
													if (($h%2)==0) $color="cccccc";
													else $color="ffffff";
											?>								
													<tr style="background-color:#<?php echo $color; ?>; margin: 15px; padding: 15px;">
														<td><?php echo str_replace(". ",".<br />",$data2->preguntas); ?></td>
														<td width="30%">
														<div class="col-md-15">
															<div class="radio" style="font-size: 8pt;">
																<label><input type="radio" value="1" onClick="suma(this.value, <?php echo $i; ?>, <?php echo $data2->id_preguntas; ?>, <?php echo $cantidad; ?>)" align="center" id="pregunta_<?php echo $i."_".$data2->id_preguntas ?>" name="pregunta_<?php echo $i."_".$data2->id_preguntas ?>"> Ligeramente</label>
																<label><input type="radio" value="2" onClick="suma(this.value, <?php echo $i; ?>, <?php echo $data2->id_preguntas; ?>, <?php echo $cantidad; ?>)" align="center" id="pregunta_<?php echo $i."_".$data2->id_preguntas ?>" name="pregunta_<?php echo $i."_".$data2->id_preguntas ?>"> Parcialmente</label>
																<label><input type="radio" value="3" onClick="suma(this.value, <?php echo $i; ?>, <?php echo $data2->id_preguntas; ?>, <?php echo $cantidad; ?>)" align="center" id="pregunta_<?php echo $i."_".$data2->id_preguntas ?>" name="pregunta_<?php echo $i."_".$data2->id_preguntas ?>"> Totalmente</label>
															</div>														
															<!--input onBlur="suma(this.value, <?php echo $i; ?>, <?php echo $data2->id_preguntas; ?>, <?php echo $cantidad; ?>)" align="center" id="pregunta_<?php echo $i."_".$data2->id_preguntas ?>" name="pregunta_<?php echo $i."_".$data2->id_preguntas ?>" maxlength="1" type="number" required="required" class="form-control" value=""-->
														</div>														
														</td>
													</tr>
											<?php $h++; } ?>
										</table>
									</div>
								</form>
							</div>
							<?php } ?>
						</div>
						<!-- End SmartWizard Content -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	$(document).ready(function(){
		$("input").focus(function(){
			$(this).css("background-color", "#cccccc");
		});
		$("input").blur(function(){
			$(this).css("background-color", "#ffffff");
		});
	});	
	</script>