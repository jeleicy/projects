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
	
	{!! Form::open(array('url' => 'guardar_encuesta_op', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
<input type="hidden" name="id_au" value="<?=$id_au?>">


<?php
	$opciones=array(1=>'Completamente en Desacuerdo',
					2=>'Moderadamente en Desacuerdo',
					3=>'Ligeramente en Desacuerdo',
					4=>'Ligeramente de Acuerdo',
					5=>'Moderadamente de Acuerdo',
					6=>'Completamente de Acuerdo');
?>

			<?php
				$i=1;				
				$sql = "select id from idioma where tipo='".\App::getLocale()."'";
				$data = DB::select($sql);
				foreach ($data as $data)
					$idioma=$data->id;
				
				$sql = "select distinct(tp.id), tp.nombre,btp.orden
						from tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where btp.id_bateria=5 and
							btp.id_tipo_prueba=tp.id and a.id=".$id_au." and btp.orden=3
						order by orden";
				//echo $sql;
				$data = DB::select($sql);
				$i=1;
				foreach ($data as $data) {
					$tiempo=FuncionesControllers::buscarTiempo($data->id);
					$id_tp=$data->id;
					
					$sql = "select distinct(i.id_prueba), i.texto
						from instrucciones i, tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where i.id_prueba=tp.id and btp.id_bateria=5 and
							btp.id_tipo_prueba=tp.id and i.id_idioma=".$idioma." and a.id=".$id_au."
							and a.id_empresas=i.id_empresa and tp.id=$id_tp and btp.orden=3 order by 1";						
					//echo $sql; return;
					$data_i = DB::select($sql);
					if (empty($data_i))
						$instrucciones="";
					else
						foreach ($data_i as $data_i)
							$instrucciones=$data_i->texto;
					?>
						<div id="instrucciones" align="center" class="col-lg-10 text-left" style="; margin:50px;font-size: 11pt; border-style: solid; border-color: #1abb9c; padding:10px; color: #1abb9c">
							<h2>{{ $data->nombre }}</h2>
								<br /><br />
								<strong><h3 style="color: #000; texty-align: center">
									<?php echo $instrucciones; ?>
								</h3></strong>
								<br /><br />
								<strong><h4 style="color: #ff2a00; texty-align: center">Espere la indicación para dar inicio a la actividad.</h4></strong>
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
				<div class="x_panel" style="width: 90%;">
					<div style="color: red; font-size: 7pt;" id="error"></div>
					<div class="x_content">
						<!-- Smart Wizard -->
						<div id="wizard_3" class="form_wizard wizard_horizontal" style="margin: 0px; padding: 0px">
							<?php
								$sql = "select count(*) as cant from preguntas_op where id_pruebas=1 or id_pruebas=2";
								$data=DB::select($sql);
								foreach ($data as $data)
									$cantidad_1=$data->cant;
									
								$cantidad_1++;
							
								$sql = "select * from preguntas_op where id_pruebas=3 order by orden";
								$data=DB::select($sql);
								$cantidad_2=$cantidad_1;
								$i=1;
								
								foreach ($data as $data) {
									$pregunta=$data->nombre;
									$id_pregunta=$data->id_preguntas;
									?>
									<div id="step-<?php echo $cantidad_2; ?>" align= "center" style="z-index:1000; line-height: 150%;">
										<form name="forma<?php echo $cantidad_2; ?>" class="form-horizontal form-label-left">
											<div align="center" style="z-index:1000; top:0px; position: relative;">									
												<?php
													echo "<div align='center' style='position: relative; height:200px; width: 550px; border-radius: 0px 0px 0px; margin-top: 5px;  margin-left: 25px; margin-right: 5px; padding-left: 5px; padding-right: 5px; '>";
													echo "<table width='100%' cellpadding='5' cellspacing='5'>";
													echo "<tr><td><strong><h5>".$pregunta."</h5></strong></td></tr>";
													$m=1;
													$color=1;
													$k=1;
													
													/**********************************/
													$selected1="";
													$selected2=""; 	
													/**********************************/

													foreach ($opciones as $key=>$value) {
														echo "<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"transparent\"'>
																<td width='80%'>&nbsp;&nbsp;&nbsp;
																	<label><input type='radio' name='op_1_".$id_pregunta."' id=''op_1_".$id_pregunta."'' value='".$key."'>
																		&nbsp;&nbsp;&nbsp;".$value."</label>
																</td>
															</tr>";
													}
												
													$m++;
													$k++;
													
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
							<ul class="wizard_steps" style="top: 270px">
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
