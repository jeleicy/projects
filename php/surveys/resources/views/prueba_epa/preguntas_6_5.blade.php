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
<div id="datos_prueba"></div>
<script>nro_prueba=5; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1; var cantidad=0;</script>

<?php $i=0; ?>

			<?php
				$tabindex=1;
				$num=0;
			
				$i=1;
				$sql = "select id from idioma where tipo='".\App::getLocale()."'";
				$data = DB::select($sql);
				foreach ($data as $data)
					$idioma=$data->id;
				
				$sql = "select distinct(tp.id), tp.nombre
						from tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where btp.id_bateria=$id_bateria and btp.orden=6 and
							btp.id_tipo_prueba=tp.id and a.id=".$id_au."
							order by btp.orden";
				$data = DB::select($sql);
				$i=1;
				$vista_prueba="";
				$tiempo="";
				foreach ($data as $data) {
						$titulo=$data->nombre;
						$tiempo=FuncionesControllers::buscarTiempo($data->id);
						$id_btp=$data->id;

						$vista_prueba=substr($tiempo,strpos($tiempo,"/")+1);
						$tiempo=substr($tiempo,0,strpos($tiempo,"/"));
						
						$sql = "select i.texto, tp.nombre, i.posicion
						from instrucciones i, tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where i.id_prueba=tp.id and btp.id_bateria=$id_bateria and
							btp.id_tipo_prueba=tp.id and i.id_idioma=1 and a.id=".$id_au."
							and a.id_empresas=i.id_empresa and tp.id=$id_btp and btp.orden=6";
							//echo $sql; return;
		//$sql = "select i.texto, tp.nombre from instrucciones i, tipos_pruebas tp where tp.orden=6 and i.id_prueba=tp.id";
		$data_i = DB::select($sql);
		$instrucciones_antes="";
		$instrucciones_despues="";
		if (empty($data_i)) {
			$instrucciones_antes="";
			$instrucciones_despues="";
		} else {
			foreach ($data_i as $data_i) {
				if ($data_i->posicion==0)
					$instrucciones_antes=$data_i->texto;
				else
					$instrucciones_despues=$data_i->texto;
			}
		}
			
	$url=substr($_SERVER["REQUEST_URI"],strpos($_SERVER["REQUEST_URI"],"encuesta_")+9);
	$url=substr($url,strpos($url,"_")+1);
	$orden=substr($url,0,strpos($url,"-"));
	$orden++;
	
	$sql = "select tp.url 
			from tipos_pruebas tp, bateria_tipo_prueba btp
			where btp.id_tipo_prueba=tp.id and btp.id_bateria=".$id_bateria." and orden=".$orden;
	$data=DB::select($sql);
	$proxima_pagina="";
	foreach ($data as $data)
		$proxima_pagina=$data->url;
?>

<script>
	proxima_pagina='<?php echo $proxima_pagina; ?>';
</script>			

<form name="forma" method="post" onSubmit="JavaScript:guardar_encuesta_hl()">
	<input type="hidden" name="id_au" id="id_au" value="<?=$id_au?>" />
	<input type="hidden" name="bateria" id="bateria" value="<?=$id_bateria?>" />
</form>

<div id="instrucciones" align="center" class="col-lg-10 text-left" style=" display:inline; margin:50px;font-size: 11pt; border-style: solid; border-color: #1abb9c; padding:10px; color: #1abb9c">

	<h2>{{ $titulo }}</h2>
	<br /><br />
	<strong><h3 style="color: #000; texty-align: center">
	<?php echo $instrucciones_antes; ?>
	{{ FuncionesControllers::prueba_inter(8) }}
	<?php echo $instrucciones_despues; ?>
									</h3></strong>					
								<div align="center">
									<input name="boton_prueba" id="boton_prueba" style='display:none' onclick="ver_encuesta_epa(<?php echo $tiempo; ?>, 3)" type="button" class="btn btn-primary" value="Comenzar">
								</div>
												
						<?php
					$i++;
				}
			?>
</div>
		<div align="center" style="background: gray;">
			<div id="encuesta" style="width: 100%; background: transparent; margin:0px; display: none; margin: auto; padding: 0px;">
				<strong><h1 style="color: #1abb9c; texty-align: center"></h1></strong>

<?php $i=0; ?>


<div class="">	
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-15 col-sm-12 col-xs-9">				
				<div class="x_panel" style="width: 80%;">
					<div style="color: red; font-size: 7pt;" id="error"></div>
					<div class="x_content">
						<!-- Smart Wizard -->
						<?php if ($vista_prueba==1) { ?>
						<div class="label label-primary" style="font-size: 12pt; float: right;">Tiempo restante para la prueba <span id="time">{{ $tiempo }}:00</span> minutos</div>
						<?php } ?>
						<div id="wizard_4" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px;">
							<?php 
									
								$sql = "select * from preguntas_epa where id_pruebas=4 order by orden";
								$data=DB::select($sql);
								
								$i=1;
								$cantidad_2=1;
								foreach ($data as $data) {
									$pregunta=$data->nombre;
									?>
									<div id="step-<?php echo $cantidad_2; ?>" style="z-index:1000; line-height: 160%;" style="background-color: #b5b4b4">
										<form name="forma<?php echo $cantidad_2; ?>" class="form-horizontal form-label-left">
												<?php
													echo "<div align='center' style='background: #fff;position: relative; border: solid 2px; border-color: red; height:200px; width: 80%; border-radius: 15px 50px 30px; margin: 5px; padding: 5px;'>";
													echo "<table border=0 width='100%'>";
														$pregunta=$data->nombre;

													echo "<tr><td valign='top' width='50%'><strong>															
															<strong>
															<h4 id='respuesta_".$data->id_preguntas."' style='color: blue; style='line-height: 200%'>
																<table border=0 width='100%' height='150'>
																	<tr>
																		<td width=50%><img src='../imagenes/imagenesEPA/HN/".$data->imagen."'></td>																
																		<td style='border: solid 2px; border-color: red; width:100% height:100%'>
																			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																	</tr>
																</table>
															</h4>															</strong>
														</td>";
													
													$sql = "select * from opciones_epa where id_pregunta=".$data->id_preguntas;
													$data_opciones=DB::select($sql);
													echo "<td valign='middle'>";
													$k=1;
													foreach ($data_opciones as $data_opciones) {
														if (strpos($data_opciones->opcion,"imagenes") !== false)
															$opcion="<img src='../".$data_opciones->opcion."' height='35' width='35'>&nbsp;&nbsp;&nbsp;";
														else
															$opcion=$data_opciones->opcion;
														/**********************************/
														$selected="";
														/*if ($data_opciones->respuesta==1)
															$selected="checked";*/
														/**********************************/
														$opciones=explode("–",$opcion);														
														//print_r ($opciones);
														//echo "....";
														$antes="";
														$despues="";
														if (isset($opciones[0]))
															$antes=$opciones[0];
														if (isset($opciones[1]))
															$despues=$opciones[1];
														echo "<table border=0 width='250' align='center'>
																<tr>
																	<td width='50%' align='right'>".$opcion."</td>
																	<td>&nbsp;</td>
																	<td align='left'>
																		<input class='radio_iol' $selected type='radio' name='op_".$data->id_preguntas."' id='op_".$data->id_preguntas."' value='".$data_opciones->id_opciones."' onclick='colocar_respuesta(\"hn\", \"".$antes."\",\"".$despues."\",".$data->id_preguntas.", ".$data_opciones->id_opciones.", \"".$opcion."\", \"".$data->imagen."\")'>
																	</td>
																</tr>
															</table>";
														/*if (strpos($data_opciones->opcion,"imagenes") === false)
															echo "<br />";*/
														/*else
															echo "<br /><br />";*/
															//echo "";
														$k++;
													}
													echo "</td></tr>";
													echo "</table>";
													echo "</div>";
												?>
										</form>
									</div>
									<?php
									$cantidad_2++;
									$i++;
								}
							?>
							<br /><br />
							<script>preguntas=<?php echo $cantidad_2; ?></script>
							<ul class="wizard_steps" style="top: 220px">
								<?php
								$nro_preg=1;
								for ($i=1; $i<$cantidad_2; $i++) { ?>
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
</div></div>

@include('layout.footer_encuesta')