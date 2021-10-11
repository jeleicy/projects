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
<div>
<script>nro_prueba=4; id_au=<?=$id_au?>;palabra=0;primera=new Array(); </script>

<?php $i=0; ?>

			<?php
				$i=1;
				$sql = "select id from idioma where tipo='".\App::getLocale()."'";
				$data = DB::select($sql);
				foreach ($data as $data)
					$idioma=$data->id;
				
				$sql = "select distinct(tp.id), tp.nombre
						from tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where btp.id_bateria=$id_bateria and btp.orden=3 and
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
							and a.id_empresas=i.id_empresa and tp.id=$id_btp and btp.orden=3";
		//

//echo $sql;		
		//$sql = "select i.texto, tp.nombre from instrucciones i, tipos_pruebas tp where tp.orden=3 and i.id_prueba=tp.id";
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

<div id="instrucciones" align="center" class="col-lg-10 text-left" style="display:inline; margin:50px;font-size: 11pt; border-style: solid; border-color: #1abb9c; padding:10px; color: #1abb9c">
	
	<h2>{{ $titulo }}</h2>
	<br /><br />
	<strong><h3 style="color: #000; texty-align: center">
	<?php echo $instrucciones_antes; ?>
									</h3></strong>	
									<div align="center">									
									{{ FuncionesControllers::prueba_inter(3) }}
									<div id="respuesta"></div>
									</div>
	<strong><h3 style="color: #000; texty-align: center"><?php echo $instrucciones_despues; ?></h3></strong>
								<div align="center">
									<input name="boton_prueba" id="boton_prueba" style='display:none' onclick="ver_encuesta_hl_cc(<?php echo $tiempo; ?>, 4)" type="button" class="btn btn-primary" value="Comenzar">
								</div>
												
						<?php
					$i++;
				}
			?>
			
</div>				

		<div align="center">
			<div id="encuesta" style="width: 100%; background-color: #e4e4e4; margin:0px; display: none; margin: auto; padding: 0px;">
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
								$sql = "select count(*) as cant from preguntas_hl where id_pruebas=1";
								$data=DB::select($sql);
								foreach ($data as $data)
									$cantidad_1=$data->cant;
									
								$sql = "select * from preguntas_hl where id_pruebas=2 order by orden";
								$data=DB::select($sql);
								
								$cantidad_1++;
								$i=1;
								$cantidad_2=1;
								foreach ($data as $data) {
									$pregunta=str_split($data->nombre);
									?>
									<div id="step-<?php echo $cantidad_2; ?>" style="z-index:1000; line-height: 160%;">
										<form name="forma<?php echo $cantidad_2; ?>" class="form-horizontal form-label-left">
											<div style="border-radius: 25px; padding: 20px;width: 80%;height: 210px;">
											<div align="center" style="z-index:1000; top:0px; position: relative;">
												<?php
													echo "<div align='center' style='background: #fff;position: relative; border: solid 2px; border-color: red; height:170px; width: 750px; border-radius: 15px 50px 30px; margin: 5px; padding: 5px;'>";
													echo "<table border=0 width='100%'>";
													if (strpos($data->nombre,"imagenes") !== false) {
														$preg=explode(" ",$data->nombre);														
														$pregunta="<table border=0 width='100%'>
																		<tr height='50px'>
																			<td align='right'><img src='../".$preg[0]."' height='35' width='35'></td>
																			<td align='center'><span style='color: blue'><h4>es a</h4></span></td>
																			<td><img src='../".$preg[3]."' height='35' width='35'></td>
																			<td><span style='color: blue'><h4>como</h4></span><br /><br /></td>
																		</tr>
																		<tr height='50px'>
																			<td align='right'><img src='../".$preg[5]."' height='35' width='35'></td>
																			<td align='center'><span style='color: blue'><h4>es a</h4></span></td>
																			<td colspan=2><span width='30px' id='respuesta_".$data->id_preguntas."'></span></td>
																		</tr>
																	</table>";
														//$pregunta.='';
													} else {
														//perro es a ladrar como búho es a:											
														$pregunta=$data->nombre;
														$parte1=explode(" como ",$pregunta);//Array ( [0] => perro es a ladrar [1] =>  búho es a: )
														//print_r ($parte1);
														//$pregunta=str_replace("  "," ",trim($pregunta));
														//echo $pregunta."<br>";
														$pregunta1=substr($parte1[0],0,strpos($parte1[0]," es a ")); 	//perro 
														//$pregunta=substr($pregunta,strpos($pregunta," es a ")+6);	//ladrar como búho es a:
														$pregunta2=substr($parte1[0],strpos($parte1[0]," es a ")+6); 	// ladrar														
														//$pregunta=substr($pregunta,strpos($pregunta," como ")+6);
														$pregunta3=substr($parte1[1],0,strpos($parte1[1],"es "));
														
														//$pregunta3=substr($pregunta3,0,strlen($pregunta3)-9);
														
														$pregunta="<table border=0 width='100%'>
																		<tr height='50px' valign='top'>
																			<td align='right'><h4><strong>".$pregunta1."</strong></h4></td>
																			<td align='center'><span style='color: blue'><h4>es a</h4></span></td>
																			<td><h4><strong>".$pregunta2."</strong></h4></td>
																			<td><span style='color: blue'><h4>como</h4></span><br /><br /></td>
																		</tr>
																		<tr height='50px'>
																			<td align='right'><h4><strong>".$pregunta3."</strong></h4></td>
																			<td align='center'><span style='color: blue'><h4>es a</h4></span></td>
																			<td colspan=2><h4><span width='30px' id='respuesta_".$data->id_preguntas."'></span></h4></td>
																		</tr>
																	</table>";
													}

													echo "<tr><td valign='top' width='50%'><strong><h5 style=' style='line-height: 200%''>".$cantidad_2.") ".$pregunta."</h5></strong></td>";
													$sql = "select * from opciones_hl where id_pregunta=".$data->id_preguntas;
													$data_opciones=DB::select($sql);
													echo "<td valign='middle'>";
													$k=1;
													foreach ($data_opciones as $data_opciones) {
														if (strpos($data_opciones->opcion,"imagenes") !== false)
															$opcion="<img src='../".$data_opciones->opcion."' height='35' width='35'>&nbsp;&nbsp;&nbsp;";
														else
															$opcion=($data_opciones->opcion);
														/**********************************/
														$selected="";
														/*if ($data_opciones->respuesta==1)
															$selected="checked";*/
														/**********************************/
														if (strpos($data_opciones->opcion,"imagenes") === false) {
															echo "<table border=0 width='150' align='center'>
																	<tr>
																		<td width='50%' align='right'>".$opcion."</td>
																		<td>&nbsp;</td>
																		<td align='left'>
																			<input class='radio_iol' $selected type='radio' name='op_3_2' id='op_3_2' value='".$data_opciones->id_opciones."' onclick='colocar(\"".$data_opciones->opcion."\",".$data->id_preguntas.")'>
																		</td>
																	</tr>
																</table>";
														} else {
															echo "$opcion&nbsp;<input $selected type='radio' name='op_3_2' id='op_3_2' value='".$data_opciones->id_opciones."' onclick='colocar(\"".$data_opciones->opcion."\",".$data->id_preguntas.")'>&nbsp;&nbsp;&nbsp;&nbsp";
														}
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
											</div>
											</div>
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
</div>
@include('layout.footer_encuesta')