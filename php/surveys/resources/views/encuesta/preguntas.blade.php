<div class="" style="background-color: #fff">	
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-15 col-sm-12 col-xs-12">				
				<div class="x_panel">
					<div class="x_content">
						<!-- Smart Wizard -->
						<br />
						<div class="label label-primary" style="font-size: 12pt; float: right;">Su prueba culminara en <span id="time">05:00</span> minutos!</div>
						<br />
						<div id="wizard" class="form_wizard wizard_horizontal" style="margin: 15px; padding: 10px">
							<div style="color: red; font-size: 7pt;" id="error"></div>
							<ul class="wizard_steps">
								<?php for ($i=1; $i<31; $i++) { ?>
								<li>
									<a href="#step-<?php echo $i; ?>">
										<span class="step_no"><?php echo $i; ?></span>
									</a>
								</li>
								<?php } ?>
							</ul>

							<?php for ($i=1; $i<31; $i++) { ?>
							<div id="step-<?php echo $i; ?>" align= "center">
								<form name="forma<?php echo $i; ?>" class="form-horizontal form-label-left">
									<div class="col-md-12">
										<table border=0>
											<?php
												$sql = "select * from opciones_iol where id_pregunta=".$i." and id_idioma=1 order by id";
												$data2 = DB::select($sql);
												foreach ($data2 as $data2) {
											?>								
													<tr>
														<td><?php echo $data2->opcion; ?></td>
														<td width="25%">
															<div class="radio">
																<label>
																	<input onclick="validar('menos',<?php echo $i; ?>,<?php echo $data2->id; ?>)" type="radio" value="<?php echo $data2->id; ?>" id="mas_<?php echo $data2->id; ?>" name="mas_<?php echo $i; ?>"> (+) &nbsp;&nbsp;
																</label>
															</div>
														</td>
														<td width="25%">
															<div class="radio">
																<label>
																	<input onclick="validar('mas',<?php echo $i; ?>,<?php echo $data2->id; ?>)" type="radio" value="<?php echo $data2->id; ?>" id="menos_<?php echo $data2->id; ?>" name="menos_<?php echo $i; ?>"> (-) &nbsp;&nbsp;
																</label>
															</div>												
														</td>
													</tr>
											<?php } ?>
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