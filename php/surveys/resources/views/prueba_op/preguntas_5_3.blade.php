<?php
	$opciones=array(1=>'Completamente en Desacuerdo',
					2=>'Moderadamente en Desacuerdo',
					3=>'Ligeramente en Desacuerdo',
					4=>'Ligeramente de Acuerdo',
					5=>'Moderadamente de Acuerdo',
					6=>'Completamente de Acuerdo');
?>

<div class="" style="background-color: #fff">	
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-15 col-sm-12 col-xs-9">				
				<div class="x_panel" style="width: 90%;">
					<div style="color: red; font-size: 7pt;" id="error"></div>
					<div class="x_content">
						<!-- Smart Wizard -->
						<div class="label label-primary" style="font-size: 12pt; float: right;">Tiempo restante para la prueba <span id="time_3">{{ $tiempo }}:00</span> minutos</div>
						<div id="wizard_3" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px">
							<?php
								$sql = "select count(*) as cant from preguntas_op where id_pruebas=1 or id_pruebas=2";
								$data=DB::select($sql);
								foreach ($data as $data)
									$cantidad_1=$data->cant;
									
								$cantidad_1++;
							
								$sql = "select * from preguntas_op where id_pruebas=3 order by orden";
								$data=DB::select($sql);
								$cantidad_2=$cantidad_1;
								$i=1;
								
								foreach ($data as $data) {
									$pregunta=$data->nombre;
									$id_pregunta=$data->id_preguntas;
									?>
									<div id="step-<?php echo $cantidad_2; ?>" align= "center" style="z-index:1000; line-height: 150%;">
										<form name="forma<?php echo $cantidad_2; ?>" class="form-horizontal form-label-left">
											<div align="center" style="z-index:1000; top:0px; position: relative;">									
												<?php
													echo "<div align='center' style='position: relative; height:200px; width: 550px; border-radius: 0px 0px 0px; margin-top: 5px;  margin-left: 25px; margin-right: 5px; padding-left: 5px; padding-right: 5px; '>";
													echo "<table width='100%' cellpadding='5' cellspacing='5'>";
													echo "<tr><td><strong><h5>".$i.". ".$pregunta."</h5></strong></td></tr>";
													$m=1;
													$color=1;
													$k=1;
													
													/**********************************/
													$selected1="";
													$selected2=""; 	
													/**********************************/

													foreach ($opciones as $key=>$value) {
														echo "<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
																<td width='80%'>&nbsp;&nbsp;&nbsp;
																	<label><input type='radio' name='op_1_".$id_pregunta."' id=''op_1_".$id_pregunta."'' value='".$key."'>
																		&nbsp;&nbsp;&nbsp;".$value."</label>
																</td>
															</tr>";
													}
												
													$m++;
													$k++;
													
													echo "</table>";
													echo "</div>";
												?>
											</div>
										</form>
									</div>
									<?php
									$cantidad_2++;
									$i++;
								}
							?>
							<br /><br />
							<ul class="wizard_steps" style="top: 160px">
								<?php
								$nro_preg=1;
								for ($i=$cantidad_1; $i<($cantidad_2); $i++) { ?>
								<li>
									<a href="#step-<?php echo $i; ?>">
										<span class="step_no"><?php echo $nro_preg; ?></span>
									</a>
								</li>
								<?php $nro_preg++; } ?>
							</ul>							
						<!-- End SmartWizard Content -->						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>