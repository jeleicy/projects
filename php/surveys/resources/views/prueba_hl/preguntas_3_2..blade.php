<div class="" style="background-color: #fff">	
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-15 col-sm-12 col-xs-9">				
				<div class="x_panel" style="width: 75%;">
					<div style="color: red; font-size: 7pt;" id="error"></div>
					<div class="x_content">
						<!-- Smart Wizard -->
						<div class="label label-primary" style="font-size: 12pt; float: right;">Su prueba culminara en <span id="time"><?php echo $tiempo; ?>:00</span> minutos!</div>
						<div id="wizard" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px">
							<?php 
								$sql = "select * from preguntas_hl where id_pruebas=2 order by orden";
								$data=DB::select($sql);
								$cantidad=1;
								
							?>
								<div id="step-<?php echo $cantidad; ?>" align= "center" style="z-index:1000; line-height: 150%;">
									<form name="forma<?php echo $cantidad; ?>" class="form-horizontal form-label-left">
										<div align="center" style="z-index:1000; top:-5px; position: relative;" class="col-md-8">									
											<?php
												foreach ($data as $data) {
													echo "Pregunta ".$cantidad.") ".$data->nombre;
													$sql = "select * from opciones_hl where id_pregunta=".$data->id_preguntas;
													$data_opciones=DB::select($sql);
													foreach ($data_opciones as $data_opciones) {
														echo "* ".$data_opciones->opcion."<br>";
													}
												}
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