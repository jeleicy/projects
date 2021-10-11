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

<script>nro_prueba=6; id_au=<?=$id_au?>;  palabra=0;primera=new Array(); </script>

<?php $i=0; ?>

			<?php
				$i=1;
				$sql = "select id from idioma where tipo='".\App::getLocale()."'";
				$data = DB::select($sql);
				foreach ($data as $data)
					$idioma=$data->id;
				
				$sql = "select distinct(tp.id), tp.nombre
						from tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where btp.id_bateria=$id_bateria and btp.orden=5 and
							btp.id_tipo_prueba=tp.id and a.id=".$id_au."
							order by btp.orden";
				$data = DB::select($sql);
				$i=1;
				$vista_prueba="";
				$tiempo="";
				foreach ($data as $data) {
						$tiempo=FuncionesControllers::buscarTiempo($data->id);
						$id_btp=$data->id;

						$vista_prueba=substr($tiempo,strpos($tiempo,"/")+1);
						$tiempo=substr($tiempo,0,strpos($tiempo,"/"));
						
						$sql = "select i.texto, tp.nombre, i.posicion
						from instrucciones i, tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where i.id_prueba=tp.id and btp.id_bateria=$id_bateria and
							btp.id_tipo_prueba=tp.id and i.id_idioma=1 and a.id=".$id_au."
							and a.id_empresas=i.id_empresa and tp.id=$id_btp and btp.orden=5";
							
		/*$sql = "select i.texto, tp.nombre 
				from instrucciones i, tipos_pruebas tp, bateria_tipo_prueba btp
				where tp.orden=5 and i.id_prueba=tp.id and btp.id_tipo_prueba=tp.id and btp.orden=5 and ";*/
		$data_i = DB::select($sql);
		$instrucciones_antes="";
		$instrucciones_despues="";		
		if (empty($data_i)) {
			$instrucciones_antes="";
			$instrucciones_despues="";
			$titulo="";
		} else {
			foreach ($data_i as $data_i) {
				if ($data_i->posicion==0)
					$instrucciones_antes=$data_i->texto;
				else
					$instrucciones_despues=$data_i->texto;	
				$titulo=$data_i->nombre;
			}
		}
		
	//$instrucciones=str_replace("<p>","",$instrucciones);
	//$instrucciones=str_replace("</p>","<br>",$instrucciones);
	
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

<div id="instrucciones" align="center" class="col-lg-10 text-left" style=" display:inline; margin:50px;font-size: 11pt; border-style: solid; border-color: #1abb9c; padding:10px; color: #1abb9c">
	<h2>{{ $titulo }}</h2>
	<br /><br />
	<strong><h3 style="color: #000; texty-align: center">
	<?php echo $instrucciones_antes; ?>
									</h3></strong>	
									<div align="center">									
									{{ FuncionesControllers::prueba_inter(5) }}									
									</div>
	<strong><h3 style="color: #000; texty-align: center"><?php echo $instrucciones_despues; ?></h3></strong>
								<div align="center">
									<input name="boton_prueba" id="boton_prueba" style='display:none' onclick="ver_encuesta_hl_cc(<?php echo $tiempo; ?>, 6)" type="button" class="btn btn-primary" value="Comenzar">
								</div>
							</div>						
						<?php
					$i++;
				}
			?>

		<div align="center">
			<div id="encuesta" style="width: 100%; background: transparent; margin:0px; display: none; margin: auto; padding: 0px;">
				<strong><h1 style="color: #1abb9c; texty-align: center"></h1></strong>

<?php $i=0; ?>





<?php
	$opciones=array(1=>'Completamente en Desacuerdo',
					2=>'Moderadamente en Desacuerdo',
					3=>'Ligeramente en Desacuerdo',
					
					4=>'Ligeramente de Acuerdo',
					5=>'Moderadamente de Acuerdo',
					6=>'Completamente de Acuerdo');
?>

<div class="" style="background-color: #fff">	
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-15 col-sm-12 col-xs-9">				
				<div class="x_panel" style="width: 90%;">
					<div style="color: red; font-size: 7pt;" id="error"></div>
					<div class="x_content">
						<!-- Smart Wizard -->
						<div class="label label-primary" style="font-size: 12pt; float: right;">Tiempo restante para la prueba <span id="time">{{ $tiempo }}:00</span> minutos</div>
						<div id="wizard_1" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px">
							<?php
								$sql = "select * from preguntas_hl where id_pruebas=5 order by orden";
								//echo $sql;
								$data=DB::select($sql);
								$cantidad_1=1;
								$i=1;
								
								foreach ($data as $data) {
									$pregunta=$data->nombre;
									$id_pregunta=$data->id_preguntas;
									?>
									<div id="step-<?php echo $cantidad_1; ?>" align= "center" style="z-index:1000; line-height: 150%;">
										<form name="forma<?php echo $cantidad_1; ?>" class="form-horizontal form-label-left">
											<div style="border-radius: 25px;background: #e4e4e4;padding: 5px;width: 80%;height: 290px;">
											<div align="center" style="z-index:1000; top:0px; position: relative;">									
												<?php
													echo "<div align='center' style='background: #fff;position: relative; border: solid 2px; border-color: red; height:270px; width: 700px; border-radius: 15px 50px 30px; margin: 5px; padding: 5px;'>";													echo "<table width='100%' cellpadding='5' cellspacing='5'>";
													echo "<tr><td><h4><strong>".$cantidad_1.")".$pregunta."</strong></h4><br /></td></tr>";
													$m=1;
													$color=1;
													$k=1;
													
													/**********************************/
													$respuesta=$data->respuesta;
													/**********************************/
													$paso=0;
													$selected="";
													foreach ($opciones as $key=>$value) {
														/*if ($key==$respuesta)
															$selected="checked";
														else
															$selected="";*/
														
														echo "<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
																<td width='80%'>
																	<table border=0 width='50%' align='center'><tr><td width='75%' align='right'>".$value."</td><td width='10%'>&nbsp;</td><td><input class='radio_iol' $selected type='radio' name='op_".$id_pregunta."' id='op_".$id_pregunta."' value='".$key."'></td></tr></table>
																</td>
															</tr>";														
														if ($paso==7) {
															$paso=0;
														} elseif ($paso==2) {
															echo "<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
																	<td width='80%'>&nbsp;</td>
																</tr>";
														}
														$paso++;
													}												
													$m++;
													$k++;
													
													echo "</table>";
													echo "</div>";
												?>
											</div>
											</div>
										</form>
									</div>
									<?php
									$cantidad_1++;
									$i++;
								}
							?>
							<script>preguntas=<?php echo $cantidad_1; ?></script>
							<br /><br />
							<ul class="wizard_steps" style="top: 160px">
								<?php
								$nro_preg=1;
								for ($i=1; $i<($cantidad_1); $i++) { ?>
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
	</div>
</div>

<div id="datos_prueba"></div>
@include('layout.footer_encuesta')