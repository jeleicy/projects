<div class="" style="background-color: #fff">	
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-15 col-sm-12 col-xs-9">				
				<div class="x_panel" style="width: 75%;">
					<div style="color: red; font-size: 7pt;" id="error"></div>
					<div class="x_content">
						<!-- Smart Wizard -->
						<?php if ($vista_prueba==1) { ?>
						<div class="label label-primary" style="font-size: 12pt; float: right;">Su prueba culminara en <span id="time"><?php echo $tiempo; ?>:00</span> minutos!</div>
						<?php } ?>
						<div id="wizard" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px">
							<?php 
								$sql = "select * from preguntas_hl where id_pruebas=1";
								$data=DB::select($sql);
								$cantidad=1;
								foreach ($data as $data) {
									$pregunta=str_split($data->nombre);
									?>
								<div id="step-<?php echo $cantidad; ?>" align= "center" style="z-index:1000; line-height: 150%;">
									<form name="forma<?php echo $cantidad; ?>" class="form-horizontal form-label-left">
										<div align="center" style="z-index:1000; top:-5px; position: relative;" class="col-md-8">									
											<?php
											echo "<table border=0 style='padding:50px'><tr>";
											for ($i=0; $i<count($pregunta); $i++)
												echo "<td align='center'><strong>".$pregunta[$i]."</strong></td>";
											echo "</tr><tr>";
											for ($i=0; $i<count($pregunta); $i++)
												echo "<td><input maxlength='2' onKeyPress='return soloNumeros(event)' style='width:50px; text-align: center' type='text' name='".$data->id_preguntas."_".$i."' id='".$data->id_preguntas."_".$i."' value=''></td>";									
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
							<ul class="wizard_steps">
								<?php 
								$sql = "select count(*) as cant from preguntas_hl where id_pruebas=1";
								$data=DB::select($sql);								
								foreach ($data as $data)
									$cantidad=$data->cant;
									
								for ($i=1; $i<$cantidad; $i++) { ?>
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