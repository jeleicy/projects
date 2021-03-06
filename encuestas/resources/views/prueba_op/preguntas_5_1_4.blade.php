<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Redirect;
use Form;
use App\Http\Controllers\FuncionesControllers;

use PDF;

?>
@include('layout.header_encuesta')
	
	{!! Form::open(array('url' => 'prueba_op/encuesta_5_1_5-'.$id_au, 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
<input type="hidden" name="id_au" value="<?=$id_au?>">

			<?php
				$i=1;				
				$sql = "select id from idioma where tipo='".\App::getLocale()."'";
				$data = DB::select($sql);
				foreach ($data as $data)
					$idioma=$data->id;
				
				$sql = "select distinct(tp.id), tp.nombre,btp.orden
						from tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where btp.id_bateria=5 and
							btp.id_tipo_prueba=tp.id and a.id=".$id_au." and btp.orden=2
						order by orden";
				//echo $sql."<br>";
				$data = DB::select($sql);
				$i=1;
				foreach ($data as $data) {
					$tiempo=FuncionesControllers::buscarTiempo($data->id);
					$id_tp=$data->id;
					
					$sql = "select distinct(i.id_prueba), i.texto
						from instrucciones i, tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where i.id_prueba=tp.id and btp.id_bateria=5 and
							btp.id_tipo_prueba=tp.id and i.id_idioma=".$idioma." and a.id=".$id_au."
							and a.id_empresas=i.id_empresa and tp.id=$id_tp and btp.orden=2 order by 1";						
					//echo $sql."<br>";
					$data_i = DB::select($sql);
					if (empty($data_i))
						$instrucciones="";
					else
						foreach ($data_i as $data_i)
							$instrucciones=$data_i->texto;
					?>
						<div id="instrucciones" align="center" class="col-lg-10 text-left" style="margin:50px;font-size: 11pt; border-style: solid; border-color: #1abb9c; padding:10px; color: #1abb9c">
							<h2>{{ $data->nombre }}</h2>
								<br /><br />
								<strong><h3 style="color: #000; texty-align: center">
									<?php echo $instrucciones; ?>
								</h3></strong>
								<br /><br />
								<strong><h4 style="color: #ff2a00; texty-align: center">Espere la indicaci??n para dar inicio a la actividad.</h4></strong>
							<div align="center">
								<input name="boton_prueba_{{ $i }}" id="boton_prueba_{{ $i }}" <?php if ($i>3) echo "style='display:none'"; else echo "style='display:inline'"; ?>  onclick="ver_encuesta_op(<?php echo $tiempo; ?>, 4, 4,<?=$id_au?>)" type="button" class="btn btn-primary" value="Comenzar">
							</div>
						</div>
					<?php
					$i++;
				}
			?>

<div id="encuesta" align="center" style="width: 100%; display: none; background: transparent; margin:0px; margin: auto; padding: 0px;">
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-15 col-sm-12 col-xs-9">				
				<div class="x_panel" style="width: 80%;">
					<div style="color: red; font-size: 7pt;" id="error"></div>
					<div class="x_content">
						<!-- Smart Wizard -->
						<div id="wizard_2" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px">
							<?php 
								$sql = "select count(*) as cant from preguntas_op where id_pruebas=1";
								$data=DB::select($sql);
								foreach ($data as $data)
									$cantidad_1=$data->cant;
									
								$sql = "select * from preguntas_op where id_pruebas=2 order by orden";
								$data=DB::select($sql);
								
								$cantidad_1++;
								$i=1;
								$cantidad_2=$cantidad_1;
								foreach ($data as $data) {
									$pregunta=str_split($data->nombre);
									?>
									<div id="step-<?php echo $cantidad_2; ?>" style="z-index:1000; line-height: 160%;">
										<form name="forma<?php echo $cantidad_2; ?>" class="form-horizontal form-label-left">
											<div align="center" style="z-index:1000; top:-5px; position: relative;">									
												<?php
													echo "<div align='center' style='position: relative; border: solid 2px; border-color: red; height:170px; width: 750px; border-radius: 15px 50px 30px; margin: 5px; padding: 5px;'>";
													echo "<table border=0 width='100%'>";
													if (strpos($data->nombre,"imagenes") !== false) {
														$preg=explode(" ",$data->nombre);
														$pregunta="<table border=0 width='100%'>
																		<tr height='50px'>
																			<td align='right'><img src='../".$preg[0]."' height='35' width='35'></td>
																			<td align='center'>es a</td>
																			<td><img src='../".$preg[3]."' height='35' width='35'></td>
																			<td>como<br /><br /></td>
																		</tr>
																		<tr height='50px'>
																			<td align='right'><img src='../".$preg[5]."' height='35' width='35'></td>
																			<td align='center'>es a:</td>
																			<td colspan=2><span width='30px' id='respuesta_".$data->id_preguntas."'></span></td>
																		</tr>
																	</table>";
														//$pregunta.='';
													} else {
														//Perro es a ladrar como b??ho es a: ?? 
														$pregunta=$data->nombre;
														$pregunta1=substr($pregunta,0,strpos($pregunta," es a "));
														$pregunta=substr($pregunta,strpos($pregunta," es a ")+6);
														$pregunta2=substr($pregunta,0,strpos($pregunta," como "));
														$pregunta=substr($pregunta,strpos($pregunta," como ")+6);
														$pregunta3=$pregunta;
														
														$pregunta3=substr($pregunta3,0,strlen($pregunta3)-9);
														
														$pregunta="<table border=0 width='100%'>
																		<tr height='50px' valign='top'>
																			<td align='right'><strong>".$pregunta1."</strong></td>
																			<td align='center'>es a</td>
																			<td><strong>".$pregunta2."</strong></td>
																			<td>como<br /><br /></td>
																		</tr>
																		<tr height='50px'>
																			<td align='right'><strong>".$pregunta3."</strong></td>
																			<td align='center'>es a:</td>
																			<td colspan=2><span width='30px' id='respuesta_".$data->id_preguntas."'></span></td>
																		</tr>
																	</table>";
													}

													echo "<tr><td valign='top' width='50%'><strong><h5 style=' style='line-height: 200%''>".$pregunta."</h5></strong></td>";
													$sql = "select * from opciones_hl where id_pregunta=".$data->id_preguntas;
													$data_opciones=DB::select($sql);
													echo "<td valign='middle'>";
													$k=1;
													foreach ($data_opciones as $data_opciones) {
														if (strpos($data_opciones->opcion,"imagenes") !== false)
															$opcion="<img src='../".$data_opciones->opcion."' height='35' width='35'>&nbsp;&nbsp;&nbsp;";
														else
															$opcion=strtoupper($data_opciones->opcion);
														/**********************************/
														$selected="";														
														/*if ($data_opciones->respuesta==1)
															$selected="checked";*/
														/**********************************/
														echo "<input $selected type='radio' name='op_3_2' id='op_3_2' value='".$data_opciones->id_opciones."' onclick='colocar(\"".$data_opciones->opcion."\",".$data->id_preguntas.")'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$opcion;
														
														if (strpos($data_opciones->opcion,"imagenes") === false)
															echo "<br /><br />";
														$k++;
													}
													echo "</td></tr>";
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
							<ul class="wizard_steps" style="top: 220px">
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

		{!! Form::close() !!}
@include('layout.footer_encuesta')
