<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

@include('layout.header')

<script>
	function ver_otro(valor,id) {
		if (valor=="OTRO")
			document.getElementById("div_otro_valor_"+id).style.display = "inline";
		else
			document.getElementById("div_otro_valor_"+id).style.display = "none";
	}
</script>

<?php
	$sql = "select * from candidatos where id_autorizacion=".$id_au;
	$data=DB::select($sql);
	
	$nombres="";
	$apellidos="";
	$email="";
	
	foreach ($data as $data) {
		$nombres=$data->nombres;
		$apellidos=$data->apellidos;
		$email=$data->email;
		$cedula=$data->cedula;
		$edad=$data->edad;
		$sexo=$data->sexo;
		$nivel_formacion=$data->nivel_formacion;
		$orientacion_area=$data->orientacion_area;
		$orientacion_cargo=$data->orientacion_cargo;
	}
?>

    {!! Form::open(array('url' => 'guardar_encuesta', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="id_au" value="<?=$id_au?>">
		
		<div id="datos_prueba" align="center"></div>
		<div id="datos_participante">
			<div class="row">
				<div class="col-lg-15 text-center">
					<p class="lead">PARTICIPANTE:</p>
					
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Nombres <span class="msj">(*)</span>:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="nombres" name="nombres" type="text" data-validate-length-range="2" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="{{ $nombres }}">
						</div>
					</div>				
					
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Apellidos <span class="msj">(*)</span>:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="apellidos" name="apellidos" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Apellidos" value="{{ $apellidos }}">
						</div>
					</div>	

					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Documento de Identidad:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input onKeyPress="return soloNumeros(event)" id="cedula" name="cedula" maxlength="8" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Cedula" value="{{ $cedula }}">
						</div>
					</div>					
					
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
								<input class="btn btn-success" type="radio" id="f" name="sexo" value="f" <?php if ($sexo=="f") echo "checked='checked'"; ?>> &nbsp; Femenino &nbsp;
								<input class="btn btn-info" type="radio" id="m" name="sexo" value="m" <?php if ($sexo=="m") echo "checked='checked'"; ?>> Masculino
							</label>
						</div>						
					</div>
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Email:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input readonly id="email" name="email" type="email" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Email" value="{{ $email }}">
						</div>
					</div>	
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Pais de Nacimiento:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="nacionalidad" name="nacionalidad" class="form-control" name="nacionalidad">
								<option value='Argentina'>Argentina</option>
								<option value='Bahamas'>Bahamas</option>
								<option value='Barbados'>Barbados</option>
								<option value='Belice'>Belice</option>
								<option value='Bolivia'>Bolivia</option>
								<option value='Brasil'>Brasil</option>
								<option value='Canada'>Canada</option>
								<option value='Colombia'>Colombia </option>
								<option value='Costa Rica'>Costa Rica</option>
								<option value='Cuba'>Cuba</option>
								<option value='Chile'>Chile</option>
								<option value='Dominica'>Dominica</option>
								<option value='Ecuador'>Ecuador</option>
								<option value='El Salvador'>El Salvador</option>
								<option value='Estados Unidos'>Estados Unidos</option>
								<option value='Granada'>Granada</option>
								<option value='Guatemala'>Guatemala</option>
								<option value='Guyana'>Guyana</option>
								<option value='Haiti'>Haiti</option>
								<option value='Honduras'>Honduras</option>
								<option value='Jamaica'>Jamaica</option>
								<option value='Mexico'>Mexico</option>
								<option value='Nicaragua'>Nicaragua</option>
								<option value='Panama'>Panama</option>
								<option value='Paraguay'>Paraguay</option>
								<option value='Peru'>Peru</option>
								<option value='Republica Dominicana'>Republica dominicana </option>
								<option value='San Cristabal y Nieves'>San Cristabal y Nieves</option>
								<option value='San Vicente y las Granadinas'>San Vicente y las Granadinas </option>
								<option value='Santa Lucia'>Santa Lucia </option>
								<option value='Surinam'>Surinam</option>
								<option value='Trinidad y Tobago'>Trinidad y Tobago </option>
								<option value='Uruguay'>Uruguay</option>
								<option value='Venezuela' selected>Venezuela</option>						
								<option value='Otro'>Otro</option>
							</select>
						</div>
					</div>	
									
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Edad:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input onKeyPress="return soloNumeros(event)" id="edad" maxlength="2" name="edad" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Edad" value="{{ $edad }}">
						</div>
					</div>		
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Nivel de Formacion Academica:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="nivel_formacion" name="nivel_formacion" class="form-control">
								<option value='Basica' <?php if ($nivel_formacion=="Basica") echo "selected='selected'"; ?> >Basica</option>
								<option value='Bachiller' <?php if ($nivel_formacion=="Bachiller") echo "selected='selected'"; ?>>Bachiller</option>
								<option value='TSU' <?php if ($nivel_formacion=="TSU") echo "selected='selected'"; ?>>TSU</option>
								<option value='Universitaria no Completa' <?php if ($nivel_formacion=="Universitaria no Completa") echo "selected='selected'"; ?>>Universitaria no Completa</option>
								<option value='Universitaria Completa' <?php if ($nivel_formacion=="Universitaria Completa") echo "selected='selected'"; ?>>Universitaria Completa</option>
								<option value='Postgrado' <?php if ($nivel_formacion=="Postgrado") echo "selected='selected'"; ?>>Postgrado</option>
								<option value='Master' <?php if ($nivel_formacion=="Master") echo "selected='selected'"; ?>>Master</option>
							</select>
						</div>
					</div>
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Area de Especialidad:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="orientacion_area" name="orientacion_area" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Area de Especialidad" value="{{ $orientacion_area }}">
						</div>
					</div>					

					<!--div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Cargo de ocupa / aspira:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="orientacion_cargo" name="orientacion_cargo" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Cargo de ocupa / aspira" value="{{ $orientacion_cargo }}">
						</div>
					</div-->
					
					<input type="hidden" name="orientacion_cargo" id="orientacion_cargo" value="" />

					<!--NUEVOS CAMPOS-->
					
					<?php
						$sql = "select * from autorizaciones where id=$id_au";
						$data=DB::select($sql);
						foreach ($data as $data)
							$id_empresas=$data->id_empresas;
							
						$sql = "select * from campos_candidatos where id_empresas=$id_empresas and activa=1";
						//echo $sql;
						$data=DB::select($sql);
						foreach ($data as $data) {
							$id_campo=$data->nombre;
							$id_campo=str_replace(" ","_",$data->nombre);
							$id_campo=strtolower($id_campo);
							
							$tipo_campo=$data->tipo_campo;
							
							$obligatorio=$data->obligatorio;
							$obligatorio=($obligatorio==1) ? $obligatorio=" (*) " : $obligatorio="";
							$obligatorio=($obligatorio==1) ? $required="required" : $required="";
							
							$nombre=strtoupper($data->nombre);
							
							$id=$data->id;
							$texto_otro="";
							//'SELECCION SIMPLE','SELECCION MULTIPLE','SELECCION SIMPLE CON COMENTARIO','ABIERTO'
							
							?>
								<div class="item form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ $data->nombre }}: {{ $obligatorio }}</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												$sql = "select texto from contenidos_campos 
														where id_campos_candidatos=$id and 
														id_autorizaciones=".$id_au;
												//echo $sql;
												$data_adicional=DB::select($sql);
												$texto="";
												$i=0;
												$texto_otro="";
												foreach ($data_adicional as $data_adicional) {
													if ($i==1)
														$texto_otro=$data_adicional->texto;
													else
														$texto=$data_adicional->texto;
													$i++;
												}
												
												if ($texto_otro!="")
													$display="inline";
												else
													$display="none";
											?>
									
										<?php if ($tipo_campo=="ABIERTO") {
											$nombre=$data->nombre;
											$nombre=strtolower($nombre);
											$nombre=str_replace("é","e",$nombre);
											//$tel=FuncionesControllers::buscar_valores('campos_candidatos', $id, $tipo_campo,$texto,0);
											//echo "tel=".$texto;
											if (strpos($nombre,"telefono") !== false) {
												$cod_int=substr($texto,0,3);
												$cod_area=substr($texto,3,3);
												$telefono=substr($texto,6);
												?>
													<div class="col-md-3 col-sm-3 col-xs-3">
														<input style="width:100px" class="form-control" type="text" id="cod_int_{{ $id }}" name="cod_int_{{ $id }}" value="{{ $cod_int }}" maxlength="3">
													</div>
													<div class="col-md-3 col-sm-3 col-xs-3">
														<input style="width:100px" class="form-control" type="text" id="cod_area_{{ $id }}" name="cod_area_{{ $id }}" value="{{ $cod_area }}" maxlength="3">
													</div>
													<div class="col-md-3 col-sm-3 col-xs-3">
														<input style="width:200px" class="form-control" type="text" id="telefono_{{ $id }}" name="telefono_{{ $id }}" value="{{ $telefono }}" maxlength="7">
													</div>
												<?php
											} else {
										?>
											<textarea id="valores_{{ $id }}" name="valores_{{ $id }}" required="{{ $required }}" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="{{ $nombre }}">{{ $texto }}</textarea>
										<?php }} elseif ($tipo_campo=="SELECCION SIMPLE") { ?>
											<select onchange="ver_otro(this.value, {{ $id }})" class="form-control" id="valores_{{ $id }}" name="valores_{{ $id }}">
												{{ FuncionesControllers::buscar_valores('campos_candidatos', $id, $tipo_campo,$texto,0) }}
											</select>
											<br />
											<div id="div_otro_valor_{{ $id }}" style="display:{{ $display }}">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Otro valor:</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input id="otro_valor_{{ $id }}" name="otro_valor_{{ $id }}" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Cargo de ocupa / aspira" value="{{ $texto_otro }}">
												</div>
											</div>											
										<?php } elseif ($tipo_campo=="SELECCION MULTIPLE") { ?>
											<!--select onchange="ver_otro(this.value, {{ $id }})" class="form-control" id="valores_{{ $id }}" name="valores_{{ $id }}" multiple-->
												{{ FuncionesControllers::buscar_valores('campos_candidatos', $id, $tipo_campo,$texto,0) }}
											<!--/select-->
											<br />
											<div id="div_otro_valor_{{ $id }}" style="display:{{ $display }}">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Otro valor:</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input id="otro_valor_{{ $id }}" name="otro_valor_{{ $id }}" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Cargo de ocupa / aspira" value="{{ $texto_otro }}">
												</div>
											</div>											
										<?php } elseif ($tipo_campo=="SELECCION SIMPLE CON COMENTARIO") { ?>
											<select onchange="ver_otro(this.value, {{ $id }})" class="form-control" id="valores_{{ $id }}" name="valores_{{ $id }}">
												{{ FuncionesControllers::buscar_valores('campos_candidatos', $id, $tipo_campo,$texto,0) }}
											</select>
											<br />
											<div id="div_otro_valor_{{ $id }}" style="display:{{ $display }}">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Otro valor:</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input id="otro_valor_{{ $id }}" name="otro_valor_{{ $id }}" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Cargo de ocupa / aspira" value="{{ $texto_otro }}">
												</div>
											</div>
										<?php } ?>
									</div>
								</div>							
							<?php
						}			
					?>
					<!--NUEVOS CAMPOS-->
					
					<div class="clearfix"></div>
					<div id="boton_2" align="center">
						<input onclick="guardar_participante_resto()" type="button" class="btn btn-primary" value="Guardar Datos">
					</div>
				</div>			
			</div>
		</div>
		<br /><br /><br />
		{!! Form::close() !!}
			
@include('layout.footer')