<table border=0 width="100%" align="center">
	<tr>
		<td align="center">
			<div class="label label-primary" style="font-size:12pt;">Tiempo restante para la prueba <span id="time_1">{{ $tiempo }}:00</span> minutos</div>
			<!--PREGUNTAS-->
			<table background-color="#989898" align="center" border=0>
				<tr>
					<td>
						<img src="../imagenes/prueba_op/telefono.jpg" />
					</td>
				</tr>
			</table>				
			<div align="center">
				<div class="" style="background-color: transparent">									
					<!-- Smart Wizard -->
						<div id="wizard_1" align="center" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px; text-align: center">
							<?php 				
							
								$sql = "select * from preguntas_op where id_pruebas=1 order by orden";
								$data=DB::select($sql);
								
								$cantidad_1=1;
								
								foreach ($data as $data) {
									$id_pregunta=$data->id_preguntas;
									$pregunta=$data->nombre;
									$respuesta=$data->respuesta;												
									//$valor=$respuesta;
									$valor="";
									?>
									<div id="step-<?php echo $cantidad_1; ?>" align="center" style="line-height: 50%; text-align: center;">
										<form name="forma_<?php echo $cantidad_1; ?>" class="form-horizontal">
											<div align="center" style="top:0px; position: relative;">									
												<?php
												echo "<table border=0 style='padding:50px' align='center'><tr>";
												echo "<td align='center'>
														<h3><strong>".$pregunta."</strong>
														<input maxlength='10' class='clase' onblur='verificar_forma(".$prueba.",".$id_pregunta.",\"".$respuesta."\")' onKeyPress='return soloNumeros(event)' style='width:250px; text-align: center' type='text' name='coord_".$id_pregunta."' id='coord_".$id_pregunta."' value='".$valor."'></h3>
													</td>";
												echo "</tr></table><br />";
												?>
											</div>
										</form>
									</div>
									<?php
									$cantidad_1++;
								}
							?>
							<ul class="wizard_steps" style="top: 55px">
								<?php												
								for ($i=1; $i<($cantidad_1); $i++) { ?>
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
			<!--FIN PREGUNTAS-->								
		</td>
	</tr>
</table>
