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

<script>nro_prueba=5; id_au=<?=$id_au?>;  palabra=0;primera=new Array(); </script>

<?php $i=0; ?>

			<?php
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
			
	//echo $sql;
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
									{{ FuncionesControllers::prueba_inter(4) }}									
									</div>		
<strong><h3 style="color: #000; texty-align: center"><?php echo $instrucciones_despues; ?></h3></strong>							
								<div align="center">
									<input name="boton_prueba" id="boton_prueba" style='display:none' onclick="ver_encuesta_hl_cc(<?php echo $tiempo; ?>, 5)" type="button" class="btn btn-primary" value="Comenzar">
								</div>												
						<?php
					$i++;
				}
			?>
</div>

		<div align="center">
			<div id="encuesta" style="width: 100%; background: transparent; margin:0px; display: none; margin: auto; padding: 0px;">
				<strong><h1 style="color: #1abb9c; texty-align: center"></h1></strong>

<?php $i=0; ?>


<div class="">	
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-15 col-sm-12 col-xs-9">				
				<div class="x_panel" style="width: 90%;">
					<div style="color: red; font-size: 7pt;" id="error"></div>
					<div class="x_content">
						<!-- Smart Wizard -->
						<?php if ($vista_prueba==1) { ?>
						<div class="label label-primary" style="font-size: 12pt; float: right;">Tiempo restante para la prueba <span id="time">{{ $tiempo }}:00</span> minutos</div>
						<?php } ?>
						<div id="wizard_5" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px">
							<?php 
								$sql = "select count(*) as cant from preguntas_hl where id_pruebas=2 or id_pruebas=1";
								$data=DB::select($sql);
								foreach ($data as $data)
									$cantidad_2=$data->cant;
							
								$sql = "select * from preguntas_hl where id_pruebas=3 order by orden";
								$data=DB::select($sql);
								$cantidad_2++;
								$cantidad_3=1;
								$i=1;
								
								foreach ($data as $data) {
									$pregunta=str_split($data->nombre);
									?>
									<div id="step-<?php echo $cantidad_3; ?>" align= "center" style="z-index:1000; line-height: 150%;">
										<form name="forma<?php echo $cantidad_3; ?>" class="form-horizontal form-label-left">
											<div style="border-radius: 25px;background: #e4e4e4;padding: 5px;width: 80%;height: 210px;">
											<div align="center" style="z-index:1000; top:-5px; position: relative;">									
												<?php
													echo "<div align='center' style='background: #fff;position: relative; border: solid 2px; border-color: red; height:200px; width: 750px; border-radius: 15px 50px 30px; margin: 5px; padding: 5px;'>";
													echo "<table width='100%' cellpadding='5' cellspacing='5'>";
													echo "<tr><td colspan=2><h4><strong>".$cantidad_3.")".$data->nombre."</strong></h4></td><td colspan=2>&nbsp;</td></tr>";
													$sql = "select * from opciones_hl where id_pregunta=".$data->id_preguntas;
													$data_opciones=DB::select($sql);
													$m=1;
													$color=1;
													$k=1;
													foreach ($data_opciones as $data_opciones) {
														if ($color==1) {
															$bgcolor="#c8c8c8";
															$color++;
														} else {
															$bgcolor="#ffffff";
															$color=1;
														}
														/**********************************/
														$selected1="";
														$selected2="";
														/*if ($data_opciones->respuesta==1)
															$selected1="checked";
														if ($data_opciones->respuesta==-1)
															$selected2="checked";*/
														/**********************************/
														echo "<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
																<td>&nbsp;</td>
																<td width='80%'>".$data_opciones->opcion."</td>																
																<td width='10%'>(+) <input class='radio_iol' $selected1 onclick='verificar_radio(this.name,".$m.")' type='radio' name='op_3_3_mas_".$i."' id='op_3_3_mas_".$i."_$m' value='mas_".$data_opciones->id_opciones."'></td>
																<td width='10%'>(-) <input class='radio_iol' $selected2 onclick='verificar_radio(this.name,".$m.")' type='radio' name='op_3_3_menos_".$i."' id='op_3_3_menos_".$i."_$m' value='menos_".$data_opciones->id_opciones."'></td>
															</tr>";
														$m++;
														$k++;
													}
													echo "</table>";
													echo "</div>";
												?>
											</div>
											</div>
										</form>
									</div>
									<?php
									$cantidad_3++;
									$i++;
								}
							?>
							<br /><br />
							<script>preguntas=<?php echo $cantidad_3; ?></script>
							<ul class="wizard_steps" style="top: 0px">
								<?php
								$nro_preg=1;
								for ($i=1; $i<$cantidad_3; $i++) { ?>
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

<div id="datos_prueba"></div>
@include('layout.footer_encuesta')