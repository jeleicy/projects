<script>
	var indice_botones=new Array();
	var indice_botones_mas=new Array();
	var indice_botones_menos=new Array();
	var indice=0;
</script>

	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-15 col-sm-12 col-xs-9">				
				<div class="x_panel" style="width: 75%;">
					<div style="color: red; font-size: 7pt;" id="error"></div>
					<div class="x_content">
						<!-- Smart Wizard -->
						<br />
						<?php if ($vista_prueba==1) { ?>
						<div class="label label-primary" style="font-size: 12pt; float: right;">{{ trans('iol_test.tiempo') }} <span id="time">{{ $tiempo }}</span> {{ trans('iol_test.minutos') }}!</div>
						<?php } ?>
						<div id="wizard" class="form_wizard wizard_horizontal" style="heigth: 500px; margin: 0px; padding: 0px">							
							<?php for ($i=1; $i<31; $i++) { ?>
								<div id="step-<?php echo $i; ?>" align= "center" style="z-index:1000; line-height: 150%;">
									<form name="forma<?php echo $i; ?>" class="form-horizontal form-label-left">
										<div align='center' style='background: #fff; position: relative; border: 2px solid red; height:230px; width: 98%; border-radius: 15px 50px 30px; margin: 5px; padding: 5px;'>
											<table border=0 align="center">
												<?php
													$sql = "select * from opciones_iol 
															where id_idioma=".Session::get("id_idioma")." and 
																id_pregunta=".$i." and id_idioma=".Session::get("id_idioma")." 
															order by id";
													$data2 = DB::select($sql);
													$indice=1;
													foreach ($data2 as $data2) {
												?>
														<tr>
															<script>
																indice_botones[indice]=<?php echo $data2->id; ?>;
																indice++;
															</script>
															<td>
																<div class="container">
																	<div class="row">																
																		<div class="form-group" align="center" style="border: 0x solid red;">
																			<label style="margin-left: 10%; position: relative; text-align: center; margin:0; border: 0px solid green; width:50%">
																				<label for="happy_<?php echo $data2->id; ?>_<?php echo $indice; ?>" class="col-sm-4 col-md-4 control-label text-right" style="font-size: 17pt;"><?php echo $data2->opcion; ?></label>
																				<div class="col-sm-7 col-md-7">
																					<!--div class="input-group">
																						<?php $datos_id[]=$data2->id; ?>
																						<div id="boton_<?php echo $data2->id; ?>_<?php echo $indice; ?>" class="btn-group">
																							<a href="javascript:;" onclick="validar_img('mas',<?php echo $i; ?>,<?php echo $data2->id; ?>,<?php echo $indice; ?>)" class="btn btn-primary btn-sm notActive" data-toggle="happy_<?php echo $data2->id; ?>_<?php echo $indice; ?>" data-title="mas"><img height="15" width="15" src="../imagenes/positivo.gif" border=0 /></a>
																							<a href="javascript:;" onclick="validar_img('menos',<?php echo $i; ?>,<?php echo $data2->id; ?>,<?php echo $indice; ?>)" class="btn btn-primary btn-sm notActive" data-toggle="happy_<?php echo $data2->id; ?>_<?php echo $indice; ?>" data-title="menos"><img height="15" width="15" src="../imagenes/negativo.gif" border=0 /></a>
																						</div>
																						<input type="hidden" name="happy_<?php echo $data2->id; ?>" id="happy_<?php echo $data2->id; ?>">
																					</div-->
																					<label id="label_mas_<?php echo $data2->id; ?>_<?php echo $i; ?>" style="margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
																						<input class="radio_iol" value="<?php echo $data2->id; ?>" type="radio" name="mas_<?php echo $i; ?>" id="mas_<?php echo $i; ?>" onclick="validar('mas',<?php echo $i; ?>,<?php echo $data2->id; ?>, this)" />&nbsp;&nbsp;&nbsp;<img height="25" width="25" src="../imagenes/positivo.gif" border=0 />
																						&nbsp;&nbsp;&nbsp;
																					</label>
																					<label id="label_menos_<?php echo $data2->id; ?>_<?php echo $i; ?>" style="border: 0px solid green; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: #c8c8c8">
																						<input class="radio_iol" value="<?php echo $data2->id; ?>" type="radio" name="menos_<?php echo $i; ?>" id="menos_<?php echo $i; ?>" onclick="validar('menos',<?php echo $i; ?>,<?php echo $data2->id; ?>, this)" />&nbsp;&nbsp;&nbsp;<img height="25" width="25" src="../imagenes/negativo.gif" border=0 />
																						&nbsp;&nbsp;&nbsp;
																					</label>
																				</div>
																			</label>
																		</div>
																	</div>
																</div>																
															</td>
														</tr>
												<?php 
														$indice++;
														if ($indice==5)
															$indice=1;
													} ?>
											</table>
											<br />
										</div>
									</form>
								</div>

							<?php } ?>	
							<ul class="wizard_steps" style="border-style: solid;border-width: 0px; top: 220px;">
								<?php for ($i=1; $i<31; $i++) { ?>
								<li>
									<a href="#step-<?php echo $i; ?>">
										<span class="step_no"><?php echo $i; ?></span>
									</a>
								</li>
								<?php } ?>
							</ul>					
						</div>
						<!-- End SmartWizard Content -->						
					</div>
				</div>
			</div>
		</div>

@include('layout.footer_encuesta',["datos_id"=>$datos_id])