<?php
	$letras= array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','ñ','o','p','q','r','s','t','u','v','w','x','y','z');
?>

<table border=0 width="60%">
	<tr>
		<td>			
			<table align="center" border='0' cellpadding='10' cellspacing='10'>
				<tr align="center">
					<td>
						<div class="label label-primary" style="font-size: 12pt;">Tiempo restante para la prueba <span id="time_1">{{ $tiempo }}:00</span> minutos</div>
						<br /><br />
						<img src="../imagenes/prueba_co/archivo.jpg" width="400" height="591">
					</td>
				</tr>
			</table>
		</td>
		<td align="center">
			<!--PREGUNTAS-->
			<div align="center">
			<br /><br />
			<div class="" style="background-color: transparent">	
				<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-15 col-sm-12 col-xs-9">				
							<div class="x_panel" style="width: 75%;">
								<div style="color: red; font-size: 7pt;" id="error"></div>
								<div class="x_content" style="text-align center;">
									<!-- Smart Wizard -->
									<div id="wizard_<?php echo $prueba; ?>" align="center" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px; text-align: center">
										<?php 
											$sql = "select * from preguntas_co where id_pruebas=1 and id_preguntas>57 order by orden";
											$data=DB::select($sql);
											$cantidad=58;
											foreach ($data as $data) {
												$pregunta=$data->nombre;
												$valor="";
												?>
												<div id="step-<?php echo $cantidad; ?>" align="center" style="line-height: 150%; text-align: center;">
													<form name="forma_<?php echo $prueba; ?>_<?php echo $cantidad; ?>" class="form-horizontal">
														<div align="center" style="top:0px; position: relative;">									
															<?php
															echo "<table border=0 style='padding:50px' align='center'><tr>";
															echo "<td align='center'>
																	<strong>".$pregunta."</strong>
																	<input maxlength='2' onblur='verificar_forma(".$prueba.")' onKeyPress='return soloNumeros(event)' style='width:50px; text-align: center' type='text' name='coord_".$data->id_preguntas."' id='coord_".$data->id_preguntas."' value='$valor'>
																</td>";
															echo "</tr></table><br />";
															?>
														</div>
													</form>
												</div>
												<?php
												$cantidad++;
											}
										?>
										<br /><br />
										<ul class="wizard_steps" style="top: 55px">
											<?php												
											for ($i=58; $i<($cantidad); $i++) { ?>
											<li>
												<a href="#step-<?php echo $i; ?>">
													<span class="step_no"><?php echo $i; ?></span>
												</a>
											</li>
											<?php } ?>
										</ul>							
									<!-- End SmartWizard Content -->						
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<!--FIN PREGUNTAS-->								
		</td>
	</tr>
</table>
