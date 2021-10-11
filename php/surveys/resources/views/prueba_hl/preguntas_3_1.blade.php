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

<script>
	nro_prueba=2; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; palabra=0;
</script>

<?php $i=0; ?>

			<?php
				$num=0;
			
				$i=1;
				$sql = "select id from idioma where tipo='".\App::getLocale()."'";
				$data = DB::select($sql);
				foreach ($data as $data)
					$idioma=$data->id;
				
				$sql = "select distinct(tp.id), tp.nombre
						from tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where btp.id_bateria=$id_bateria and btp.orden=1 and
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
							and a.id_empresas=i.id_empresa and tp.id=$id_btp and btp.orden=1";
		//echo $sql; return
		//$sql = "select i.texto, tp.nombre from instrucciones i, tipos_pruebas tp where tp.orden=1 and i.id_prueba=tp.id";
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
	//echo $sql; return;
	$data=DB::select($sql);
	$proxima_pagina="";
	foreach ($data as $data)
		$proxima_pagina=$data->url;
		
	$tabindex=1;
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
	<?php echo $instrucciones_despues; ?>
									</h3></strong>					
								<div align="center">
									<input name="boton_prueba" id="boton_prueba" <?php if ($i>2) echo "style='display:none'"; else echo "style='display:inline'"; ?>  onclick="ver_encuesta_hl_cc(<?php echo $tiempo; ?>, 2)" type="button" class="btn btn-primary" value="Comenzar">
								</div>
							</div>						
						<?php
					$i++;
				}
			?>

		<div align="center">
			<div id="encuesta" style="width: 100%; background: transparent; margin:0px; display: none; margin: auto; padding: 0px;">
				<strong><h1 style="color: #1abb9c; texty-align: center"></h1></strong>
		
<table border=0 width="80%">
	<tr>
		<td>
			<?php if ($vista_prueba==1) { ?>
			<div class="label label-primary" style="font-size: 12pt; float: right;">Tiempo restante para la prueba <span id="time">{{ $tiempo }}:00</span> minutos</div>
			<?php } ?>
			<h3><div align="center"><strong>&nbsp;</strong></div></h3>
			<table align="center" border='0' cellpadding='10' cellspacing='10' width="400">
				<tr align="center">
					<td colspan='3'>&nbsp;</td>
					<td colspan='5' style="background-color: yellow; font-size:15pt;" align="center"><strong>Columnas</strong></td>
				</tr>
				<tr align="center">
					<td colspan='3'>&nbsp;</td>
					<?php
						$sql = "select * from matriz_cc order by 1";
						$data=DB::select($sql);
						foreach ($data as $data)
							$matriz[$data->x][$data->y]=$data->letra;					
					
						foreach ($matriz as $key=>$value)
							echo "<td width='35px' height='35px' style='border:1px solid; background-color: #c8c8c8; font-size:15pt;'>".$key."</td>";
					?>
				<tr>
					<td colspan="8" style='font-size: 4pt; background-color: transparent'>&nbsp;</td>
				</tr>					
				</tr>
					<?php
						$filas=array("F","i","l","a","s");
						foreach ($matriz as $key_x=>$value_x) {		
							$i=0;
							foreach ($value_x as $key_y=>$value_y) {
								echo "<tr align='center' height='35px'>";
									echo "<td width='35px' height='35px' style='background-color: yellow; font-size:15pt;'><strong>".$filas[$i]."</strong></td>";
									echo "<td width='35px' height='35px' style='border:1px solid; background-color: #c8c8c8; font-size:15pt;'>".$key_y."</td>";
									echo "<td width='5px' style='background-color: transparent'>&nbsp;</td>";
									foreach ($matriz as $k=>$v) {
										if ($matriz[$k][$key_y]=="A" || 
											$matriz[$k][$key_y]=="E" || 
											$matriz[$k][$key_y]=="I" || 
											$matriz[$k][$key_y]=="O" || 
											$matriz[$k][$key_y]=="U")
											echo "<td width='35px' height='35px' style='border:1px solid; background-color: #c8c8c8; font-size:15pt;'><strong>".$matriz[$k][$key_y]."</strong></td>";
										else
											echo "<td style='border:1px solid; font-size:15pt;' width='35px' height='35px'>".$matriz[$k][$key_y]."</td>";
									}
									echo "</tr>";
									$i++;
								}							
							break;											
						}
					?>						
			</table>
		</td>
	</tr>
	<tr valign="top">
		<td align="center">
			<!--PREGUNTAS-->
				<!-- Smart Wizard -->
				<div id="wizard_2" align="center" class="form_wizard wizard_horizontal" style="top: 0px; margin: 0px; padding: 0px; text-align: center">
					<?php 
						$sql = "select * from preguntas_hl where id_pruebas=1 and id_preguntas>1 and id_preguntas<10";
						$data=DB::select($sql);
						$cantidad_1=1;
						//$primera="";
						foreach ($data as $data) {
							$pregunta=str_split($data->nombre);
							$valor="";
							?>
							<div id="step-<?php echo $cantidad_1; ?>" align="center" style="top: 0px; text-align: center;">
								<form name="forma<?php echo $cantidad_1; ?>" class="form-horizontal">
									<div align="center" style="top:0px; position: relative;">									
										<?php
										echo "<table border=0 style='padding:0px' align='center'><tr>";
										for ($i=0; $i<count($pregunta); $i++)
											echo "<td align='center'><p style='font-size:15pt;'><strong>".$pregunta[$i]."</strong></p></td>";
										echo "</tr><tr>";
																				
										for ($i=0; $i<count($pregunta); $i++) {
											if ($data->id_preguntas<10)
												$id_pregunta="0".$data->id_preguntas;
											else
												$id_pregunta=$data->id_preguntas;
											if ($i<10)
												$complemento="0".$i;
											else
												$complemento=$i;
											/**********************************/
											$sql = "select * from matriz_cc where letra='".$pregunta[$i]."'";
											$data_res=DB::select($sql);
											foreach ($data_res as $data_res)
												$valor=$data_res->y.$data_res->x;
												
											//if ($i>2 || $cantidad_1>1)
												$valor="";
											/**********************************/
											if ($tabindex==1) {
												$autofocus="autofocus";
											} else
												$autofocus="";											
											
											if ($i==0) {
												echo "<script>primera[".$num."]='".$tabindex."'; </script>";
												$num++;
												$id_campo="coord_".$id_pregunta."_".$complemento;
											} else {
												$id_campo="";
											}											

											echo "<td><input autocomplete='off' autofocus='".$autofocus."' tabindex=".$tabindex." width='35px' height='35px' class='clase' maxlength='2' style='width:50px; text-align: center' type='text' name='coord_".$id_pregunta."_".$complemento."' id='coord_".$id_pregunta."_".$complemento."' value='$valor'></td>";
											$tabindex++;
											if ($i==0) {
											?>
											  <script>
												if (("autofocus" in document.getElementById('<?php echo $id_campo; ?>'))) {
													//alert('<?php echo $id_campo; ?>');
													//alert("autofocus" in document.getElementById('<?php echo $id_campo; ?>'));													
													document.getElementById('<?php echo $id_campo; ?>').focus();
												}
											  </script>											
											<?php
											}
										}
										echo "</tr></table><br />";
										?>
									</div>									
								</form>
							</div>
							<?php
							$cantidad_1++;							
						}
					?>					
					<ul class="wizard_steps" style="top: 0px">
						<?php												
						for ($i=1; $i<($cantidad_1); $i++) { ?>
						<li>
							<a href="#step-<?php echo $i; ?>">
								<span class="step_no"><?php echo $i; ?></span>
							</a>
						</li>
						<?php } ?>
					</ul>							
				<!-- End SmartWizard Content -->						
			</div>
			<!--FIN PREGUNTAS-->								
		</td>
	</tr>
</table>
</div></div>

@include('layout.footer_encuesta')