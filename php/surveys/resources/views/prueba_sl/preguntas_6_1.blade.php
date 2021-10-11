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
<script>nro_prueba=1; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1;</script>

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
						where btp.id_bateria=$id_bateria and btp.orden=2 and
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
							and a.id_empresas=i.id_empresa and tp.id=$id_btp and btp.orden=2";
							//echo $sql; return;
		//$sql = "select i.texto, tp.nombre from instrucciones i, tipos_pruebas tp where tp.orden=2 and i.id_prueba=tp.id";
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
	<?php echo $instrucciones_despues; ?>
									</h3></strong>					
								<div align="center">
									<input name="boton_prueba" id="boton_prueba" <?php if ($i>2) echo "style='display:none'"; else echo "style='display:inline'"; ?>  onclick="ver_encuesta_hl_cc(<?php echo $tiempo; ?>, 3)" type="button" class="btn btn-primary" value="Comenzar">
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

	<table border=0 width="80%">
		<tr height="10" valign="top">
			<td align="center">
				<!--PREGUNTAS-->
				<div align="center">
				<?php if ($vista_prueba==1) { ?>
				<div class="label label-primary" style="font-size:12pt;">Tiempo restante para la prueba <span id="time_1">{{ $tiempo }}:00</span> minutos</div>
				<?php } ?>
				<div class="" style="background-color: transparent">
					<!-- Smart Wizard -->
					<div id="wizard_1" align="center" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px; text-align: center">
						<?php 
							$sql = "select * from preguntas_co where id_pruebas=1 and 
										id_preguntas>3 and id_preguntas<5 order by orden";
							$data=DB::select($sql);
							$cantidad=1;
							foreach ($data as $data) {
								$id_pregunta=$data->id_preguntas;
								$pregunta=$data->nombre;
								$respuesta=$data->respuesta;
								$valor="";
								?>
								<div id="step-<?php echo $cantidad; ?>" align="center" style="line-height: 100%; text-align: center;">
									<form name="forma_<?php echo $cantidad; ?>" class="form-horizontal">
										<div align="center" style="top:0px; position: relative;">									
											<?php
											echo "<table border=0 style='padding:50px' align='center'><tr>";
											echo "<td align='center'>
													<h3><strong>".$pregunta."</strong>
													<input tabindex=$tabindex autofocus maxlength='2' class='clase' onblur='verificar_forma(1,".$id_pregunta.",\"".$respuesta."\")' onKeyPress='return soloNumeros(event)' style='width:50px; text-align: center' type='text' name='coord_".$id_pregunta."' id='coord_".$id_pregunta."' value='$valor'></h3>
												</td>";
											echo "</tr></table><br />";
											$tabindex++;
											?>
										</div>
									</form>
								</div>
								<?php
								$cantidad++;
							}
						?>
						<br /><br />
						<ul class="wizard_steps" style="top: 55px">
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
		<tr>
			<td>
				<table background-color="#989898" align="center" width="1100">
					<tr>
						<td width="1100" height="52" background="../imagenes/prueba_co/borde_sup.jpg">&nbsp;</td>
					</tr>
					<tr>
						<td background="../imagenes/prueba_co/fondo_medio_tabla.jpg">					
							<table align="center" border='0' cellpadding='10' cellspacing='10' style="width:902px;text-align:left;background-color:#989898;">
								<tr>
									<td align="center"><a href="javascript:;"><img onclick="colocar_nro(1)" src="../imagenes/prueba_co/1.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(5)"><img src="../imagenes/prueba_co/5.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(9)"><img src="../imagenes/prueba_co/9.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(13)"><img src="../imagenes/prueba_co/13.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(17)"><img src="../imagenes/prueba_co/17.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(21)"><img src="../imagenes/prueba_co/21.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(25)"><img src="../imagenes/prueba_co/25.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(29)"><img src="../imagenes/prueba_co/29.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(33)"><img src="../imagenes/prueba_co/33.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(37)"><img src="../imagenes/prueba_co/37.jpg"></a></td>
								</tr>
								<tr>
									<td align="center" colspan="10">&nbsp;</td>
								</tr>							
								<tr>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(2)"><img src="../imagenes/prueba_co/2.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(6)"><img src="../imagenes/prueba_co/6.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(10)"><img src="../imagenes/prueba_co/10.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(14)"><img src="../imagenes/prueba_co/14.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(18)"><img src="../imagenes/prueba_co/18.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(22)"><img src="../imagenes/prueba_co/22.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(26)"><img src="../imagenes/prueba_co/26.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(30)"><img src="../imagenes/prueba_co/30.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(34)"><img src="../imagenes/prueba_co/34.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(38)"><img src="../imagenes/prueba_co/38.jpg"></a></td>
								</tr>							
								<tr>
									<td align="center" colspan="10">&nbsp;</td>
								</tr>								
								<tr>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(3)"><img src="../imagenes/prueba_co/3.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(7)"><img src="../imagenes/prueba_co/7.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(11)"><img src="../imagenes/prueba_co/11.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(15)"><img src="../imagenes/prueba_co/15.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(19)"><img src="../imagenes/prueba_co/19.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(23)"><img src="../imagenes/prueba_co/23.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(27)"><img src="../imagenes/prueba_co/27.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(31)"><img src="../imagenes/prueba_co/31.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(35)"><img src="../imagenes/prueba_co/35.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(39)"><img src="../imagenes/prueba_co/39.jpg"></a></td>
								</tr>
								<tr>
									<td align="center" colspan="10">&nbsp;</td>
								</tr>								
								<tr>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(4)"><img src="../imagenes/prueba_co/4.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(8)"><img src="../imagenes/prueba_co/8.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(12)"><img src="../imagenes/prueba_co/12.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(16)"><img src="../imagenes/prueba_co/16.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(20)"><img src="../imagenes/prueba_co/20.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(24)"><img src="../imagenes/prueba_co/24.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(28)"><img src="../imagenes/prueba_co/28.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(32)"><img src="../imagenes/prueba_co/32.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(36)"><img src="../imagenes/prueba_co/36.jpg"></a></td>
									<td align="center"><a href="javascript:;" onclick="colocar_nro(40)"><img src="../imagenes/prueba_co/40.jpg"></a></td>
								</tr>			
							</table>
						</td>
					</tr>
					<tr>
						<td width="1100" height="56" background="../imagenes/prueba_co/borde_inf.jpg">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div></div>

@include('layout.footer_encuesta')