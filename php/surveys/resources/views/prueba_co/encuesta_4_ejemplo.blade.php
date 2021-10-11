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

    <div class="container">
<?php
	if ($mensaje!="") {
		echo "<h2>".$mensaje."</h2>";
	} else {

	//$sql = "delete from pruebas_presentadas where id_autorizacion=233";
	//DB::delete($sql);
	
	//$sql = "delete from respuestas_co where id_autorizacion=233";
	//DB::delete($sql);	

	$sql = "select * from candidatos where id_autorizacion=".$id_au;
	$data=DB::select($sql);
	foreach ($data as $data) {
		$nombres=$data->nombres;
		$apellidos=$data->apellidos;
		$email=$data->email;
	}
	
	$pruebas=0;
	//PRUEBA CO
	$sql = "select rco.id from respuestas_co rco, preguntas_co phl
		where rco.id_autorizacion=".$id_au." and rco.id_opcion=phl.id_preguntas and 
		rco.id_pruebas=1";
	//echo "<br>$sql";
	$data=DB::select($sql);
	$cantidad_respuestas=count($data);
	if ($cantidad_respuestas>0) {
		$pruebas++;	
	}
	
	//PRUEBA HI
	$sql = "select rco.id from respuestas_co rco, preguntas_co phl
		where rco.id_autorizacion=".$id_au." and rco.id_opcion=phl.id_preguntas and 
		rco.id_pruebas=2";
	//echo "<br>$sql";
	$data=DB::select($sql);	
	$cantidad_respuestas=count($data);
	if ($cantidad_respuestas>0)
		$pruebas++;	
	
	//PRUEBA IEP
	$sql = "select rco.id from respuestas_co rco, preguntas_co phl
		where rco.id_autorizacion=".$id_au." and rco.id_opcion=phl.id_preguntas and 
		rco.id_pruebas=3";
	//echo "<br>$sql";
	$data=DB::select($sql);	
	$cantidad_respuestas=count($data);
	if ($cantidad_respuestas>0)
		$pruebas++;
	
	$pruebas++;
	echo "<script>nro_prueba=".$pruebas.";</script>";
	$pruebas--;
?>

    {!! Form::open(array('url' => 'guardar_encuesta_ejemplo', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="id_au" value="<?=$id_au?>">
		<div id="datos_prueba" align="center"></div>
		<?php if ($pruebas==0) { ?>
		<div id="datos_participante">
			<div class="row">
				<div class="col-lg-15 text-center">
					<h1>PRUEBA TCO</h1>
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
							<input onKeyPress="return soloNumeros(event)" id="cedula" name="cedula" maxlength="8" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Cedula" value="">
						</div>
					</div>					
					
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
								<input class="btn btn-success" type="radio" name="sexo" value="f"> &nbsp; Femenino &nbsp;
								<input class="btn btn-info" type="radio" name="sexo" value="m" checked=""> Masculino
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
							<input onKeyPress="return soloNumeros(event)" id="edad" maxlength="2" name="edad" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Edad" value="">
						</div>
					</div>		
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Nivel de Formacion Academica:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="nivel_formacion" name="nivel_formacion" class="form-control" name="nacionalidad">
								<option value='Basica'>Basica</option>
								<option value='Bachiller'>Bachiller</option>
								<option value='TSU'>TSU</option>
								<option value='Universitaria no Completa'>Universitaria no Completa</option>
								<option value='Universitaria Completa'>Universitaria Completa</option>
								<option value='Postgrado'>Postgrado</option>
								<option value='Master'>Master</option>
							</select>
						</div>
					</div>
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Area de Especialidad:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="orientacion_area" name="orientacion_area" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Area de Especialidad" value="">
						</div>
					</div>					

					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Cargo de ocupa / aspira:</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="orientacion_cargo" name="orientacion_cargo" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Cargo de ocupa / aspira" value="">
						</div>
					</div>			
					
					<div class="clearfix"></div>
					<div id="boton_2" align="center">
						<input onclick="guardar_participante()" type="button" class="btn btn-primary" value="Comenzar Prueba">
					</div>
				</div>			
			</div>
		</div>
		<?php } ?>
		<?php
			$display="";
			if ($pruebas==0 || $pruebas==1) {
				$display[1]="none";
				$display[2]="none";
				$display[3]="none";
				$display[4]="none";
			} elseif ($pruebas==2) {
				$display[1]="none";
				$display[2]="none";				
				$display[3]="inline";
				$display[4]="none";
			} elseif ($pruebas==3) {
				$display[1]="none";
				$display[2]="none";
				$display[3]="none";
				$display[4]="inline";
			}
			$pruebas=1;
			$display[1]="none";
			$display[2]="none";
			$display[3]="none";
			$display[4]="none";			
		?>
			<?php
				$i=1;
				
				//echo "idioma=".\App::getLocale(); return;
				$sql = "select id from idioma where tipo='".\App::getLocale()."'";
				$data = DB::select($sql);
				foreach ($data as $data)
					$idioma=$data->id;
				
				$sql = "select distinct(tp.id), tp.nombre
						from tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where btp.id_bateria=4 and
							btp.id_tipo_prueba=tp.id and a.id=".$id_au."
						order by orden";
				//echo $sql; return;
				$data = DB::select($sql);
				$i=1;
				foreach ($data as $data) {
					$tiempo=FuncionesControllers::buscarTiempo($data->id);
					
					$vista_prueba=substr($tiempo,strpos($tiempo,"/")+1);
					$tiempo=substr($tiempo,0,strpos($tiempo,"/"));					
					
					$sql = "select distinct(i.id_prueba), i.texto, btp.orden
					from instrucciones i, tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
					where i.id_prueba=tp.id and btp.id_bateria=4 and
						btp.id_tipo_prueba=tp.id and i.id_idioma=".$idioma." and a.id=".$id_au."
						and a.id_empresas=i.id_empresa and btp.orden=1 order by 1";
					$data_i = DB::select($sql);
					if (empty($data_i))
						$instrucciones="";
					else
						foreach ($data_i as $data_i)
							$instrucciones=$data_i->texto;
					?>
						<div id="instrucciones_{{ $i }}" align="center" class="col-lg-10 text-left" style=" display:<?php echo $display[$i]; ?>; margin:50px;font-size: 11pt; border-style: solid; border-color: #1abb9c; padding:10px; color: #1abb9c">
							<h2>{{ $data->nombre }}</h2>
								<br /><br />
								<strong><h3 style="color: #000; texty-align: center">
									<?php echo $instrucciones; ?>
								</h3></strong>
								<br /><br />
								<strong><h4 style="color: #ff2a00; texty-align: center">Espere la indicación para dar inicio a la actividad.</h4></strong>
							<div align="center">
								<input name="boton_prueba_{{ $i }}" id="boton_prueba_{{ $i }}" <?php if ($i>3) echo "style='display:none'"; else echo "style='display:inline'"; ?>  onclick="ver_encuesta_co(<?php echo $tiempo; ?>, <?php echo $i; ?>, <?php echo $pruebas; ?>)" type="button" class="btn btn-primary" value="Comenzar">
							</div>
						</div>
					<?php
					$i++;
				}
			?>
		
		{!! Form::close() !!}
	</div>
		<div align="center">
		<?php
			$sql = "select * from bateria_tipo_prueba where id_bateria=4";
			$data=DB::select($sql);
			$prueba=1;
			foreach ($data as $data) {
				if ($prueba==1)
					$titulo="EJEMPLO DE PRUEBA CO";
				else
					$titulo="";
				?>
					<div id="encuesta_<?php echo $prueba; ?>" style="width: 100%; background: transparent; margin:0px; display: none; margin: auto; padding: 0px;">
						<strong><h1 style="color: #1abb9c; texty-align: center"><?php echo $titulo; ?></h1></strong>
						@include('prueba_co.preguntas_4_1', ['tiempo' => $tiempo])
					</div>					
				<?php
				$prueba++;				
			}
		?>

		</div>
		<br /><br /><br />
		
        <!-- /.row -->
<?php } ?>	
@include('layout.footer_encuesta')