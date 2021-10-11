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
<script>nro_prueba=3; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1; var cantidad=0;</script>

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
						where btp.id_bateria=$id_bateria and btp.orden=4 and
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
							and a.id_empresas=i.id_empresa and tp.id=$id_btp and btp.orden=4";
							//echo $sql; return;
		//$sql = "select i.texto, tp.nombre from instrucciones i, tipos_pruebas tp where tp.orden=4 and i.id_prueba=tp.id";
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
	{{ FuncionesControllers::prueba_inter(6) }}
	<?php echo $instrucciones_despues; ?>
									</h3></strong>					
								<div align="center">
									<input name="boton_prueba" id="boton_prueba" style='display:none' onclick="ver_encuesta_epa(<?php echo $tiempo; ?>, 3)" type="button" class="btn btn-primary" value="Comenzar">
								</div>
							</div>						
						<?php
					$i++;
				}
			?>

		<div align="center" style="background: gray;">
			<div id="encuesta" style="width: 100%; background: red; margin:0px; display: none; margin: auto; padding: 0px;">
				<strong><h1 style="color: #1abb9c; texty-align: center"></h1></strong>

<?php $i=0; ?>

	<table border=0 width="100%">
		<tr height="10" valign="top">
			<td align="center">
				<!--PREGUNTAS-->
				<div align="center">
				<?php if ($vista_prueba==1) { ?>
				<div class="label label-primary" style="font-size:12pt;">Tiempo restante para la prueba <span id="time">{{ $tiempo }}:00</span> minutos</div>
				<?php } ?>
				<div class="" style="background-color: transparent">
					<!-- Smart Wizard -->
					<div id="wizard_1" align="center" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px; text-align: center">
						<?php 
							$sql = "select * from preguntas_epa where id_pruebas=2 order by orden";
							$data=DB::select($sql);
							$cantidad=1;
							$imagenes=array();
							foreach ($data as $data) {
								$id_pregunta = $data->id_preguntas;
								$orden_pregunta = $data->orden;
								$pregunta=$data->nombre;
								$respuesta=$data->respuesta;
								//$valor=$respuesta;
								$valor="";
								?>
								<div id="step-<?php echo $cantidad; ?>" align="center" style="line-height: 100%; text-align: center;">
									<form name="forma_<?php echo $cantidad; ?>" class="form-horizontal">
										<div align="center" style="top:0px; position: relative;">	
											<div align='center' style='background: #fff;position: relative; border: solid 2px; border-color: red; height:270px; width: 80%; border-radius: 15px 50px 30px; margin: 20px; padding: 20px;'>
												<?php
												
												$dir = opendir("imagenes/imagenesEPA/RA");
												$files = array();
												$imagenes=array();
												while ($file = readdir($dir)) {
													if( $file != "." && $file != "..") {
														
														/*if (strpos($file,"_0000_") !== false)
															$id_file_pregunta = substr($file,strpos($file,"_")+1);
														else
															$id_file_pregunta = substr($file,strpos($file,"__")+2);*/
														//ra_0092_157.jpg
														$id_file_pregunta = substr($file,strpos($file,"_")+1);
														//0092_157.jpg
														$id_file_pregunta = substr($id_file_pregunta,strpos($id_file_pregunta,"_")+1);
														//157.jpg
														$id_file_pregunta = substr($id_file_pregunta,0,strpos($id_file_pregunta,"."));
														//157
														
														//echo "file=$file...";
														
														if (strlen($id_file_pregunta)==2) {
															$pregunta=substr($id_file_pregunta,0,1);
															$orden=substr($id_file_pregunta,1);
														} else {
															$pregunta=substr($id_file_pregunta,0,2);
															$orden=substr($id_file_pregunta,2);
														}
														//echo "1)id_file_pregunta=$id_file_pregunta...len=".strlen($id_file_pregunta)."...orden_pregunta=".$orden_pregunta."....pregunta=$pregunta...orden=$orden<br>";
														if ($orden_pregunta==$pregunta) {
															$imagenes[$orden_pregunta][$orden]=$file;
															//echo "2)fila=$file...id_file_pregunta=$id_file_pregunta...orden_pregunta=".$orden_pregunta."....pregunta=$pregunta...orden=$orden<br>";
															//break;
														}
														//echo "file=".$file."....pregunta=$pregunta...<br>";
														
														//file=ra__0092_157.jpg....pregunta=157...
													}
												}
												/*echo "<pre>";
												print_r ($imagenes);
												echo "</pre>";*/
												/*if ($cantidad==1)
													break;*/
													
												echo "<table width='100%' border='0' cellpadding='5' cellspacing='5' align='center'><tr>";
													//OPCIONES 1
													echo "<td align='center'><img src='../imagenes/imagenesEPA/RA/".$imagenes[$orden_pregunta][1]."'>";
													echo "<td align='center'><img src='../imagenes/imagenesEPA/RA/".$imagenes[$orden_pregunta][2]."'></td>";
													echo "<td align='center'><img src='../imagenes/imagenesEPA/RA/".$imagenes[$orden_pregunta][3]."'></td>";
													echo "<td align='center'><img src='../imagenes/imagenesEPA/RA/".$imagenes[$orden_pregunta][4]."'></td>";
													//RESPUESTA												
													echo "<td align='center' width='100'><div id='img_respuesta_".$id_pregunta."' style='width=100px; height:100px; background: #ffff01; padding: 2px; margin: 5px; border-color: #c8c8c8; border: 2px solid'></div></td>";
													echo "<td align='center' width='100'>&nbsp;</td>";
													//OPCIONES 2
													echo "<td align='center'><a class='radio_iol' href='javascript:;' onclick='ver_imagen(".$id_pregunta.", 5, \"".$imagenes[$orden_pregunta][5]."\")'><img src='../imagenes/imagenesEPA/RA/".$imagenes[$orden_pregunta][5]."'></a></td>";
													echo "<td align='center'><a class='radio_iol' href='javascript:;' onclick='ver_imagen(".$id_pregunta.", 6, \"".$imagenes[$orden_pregunta][6]."\")'><img src='../imagenes/imagenesEPA/RA/".$imagenes[$orden_pregunta][6]."'></a></td>";
													echo "<td align='center'><a class='radio_iol' href='javascript:;' onclick='ver_imagen(".$id_pregunta.", 7, \"".$imagenes[$orden_pregunta][7]."\")'><img src='../imagenes/imagenesEPA/RA/".$imagenes[$orden_pregunta][7]."'></a></td>";
													echo "<td align='center'><a class='radio_iol' href='javascript:;' onclick='ver_imagen(".$id_pregunta.", 8, \"".$imagenes[$orden_pregunta][8]."\")'><img src='../imagenes/imagenesEPA/RA/".$imagenes[$orden_pregunta][8]."'></a></td>";
													echo "<td align='center'><a class='radio_iol' href='javascript:;' onclick='ver_imagen(".$id_pregunta.", 9, \"".$imagenes[$orden_pregunta][9]."\")'><img src='../imagenes/imagenesEPA/RA/".$imagenes[$orden_pregunta][9]."'></a></td>";
													echo "</tr>
															<tr>
																<td colspan='6'></td>
																<td align='center'>a</td>
																<td align='center'>b</td>
																<td align='center'>c</td>
																<td align='center'>d</td>
																<td align='center'>e</td>
															</tr>
													</table><br />";												
												
	
												$tabindex++;
												?>
											</div>
										</div>
									</form>
								</div>
								<?php
								$cantidad++;

							}
						?>
						<br /><br />
						<script>cantidad=<?php echo $cantidad; ?>;</script>
						<ul class="wizard_steps" style="top: 150px">
							<?php												
							for ($i=1; $i<($cantidad); $i++) { ?>
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
</div></div>

@include('layout.footer_encuesta')