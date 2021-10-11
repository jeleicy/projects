<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

?>
@include('layaout.header_admin')

<?php
	$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre",);
?>

<?php
if ($mensaje=="") {
	$cedula="";
	$nombres = "";
	$apellidos = "";
	$email ="";
	$apellidos = "";
	$sexo = 0;
	$dia_nac = "";
	$mes_nac = "";
	$ano_nac = "";
	$edocivil = 0;
	$profesion = "";
	$email2 = "";
	$pregsec = "";
	$respsec = "";

	$tlfcel = "";
	$cod_cel="";

	$tlfhab = "";
	$cod_hab="";

	$tlfotro = 0;

	$ctabancaria=0;
	$banco=0;
	$tipocta=0;
	$dirmrw=0;

	$estado = 0;
	$municipio = 0;
	$parroquia = 0;

	$privilegio = 0;

	$codigo = 0;
	$con_regional = "";

	$observaciones = "";

	$acreditadocne = "";
	$activo = 0;
	$capacitado = "";
	$cod_centro = 0;
}
if ($id_observador>0) {
	$sql = "select * from observador where id_observador=$id_observador";
	$data=DB::select($sql);
	foreach($data as $data) {
		$cedula = $data->cedula;
		$nombres = $data->nombres;
		$apellidos = $data->apellidos;
		$email = $data->email;
		$id_observador = $data->id_observador;
		$sexo = $data->sexo;
		$edocivil = $data->edocivil;
		$profesion = $data->profesion;
		$email2 = $data->email2;
		$pregsec = $data->pregsec;
		$respsec = $data->respsec;

		$fechanac=$data->fechanac;
		$ano_nac=substr($fechanac,0,strpos($fechanac,"-"));
		$fechanac=substr($fechanac,strpos($fechanac,"-")+1);
		$mes_nac=substr($fechanac,0,strpos($fechanac,"-"));
		$fechanac=substr($fechanac,strpos($fechanac,"-")+1);
		$dia_nac=$fechanac;

		$tlfcel = $data->tlfcel;
		if (strpos($tlfcel,"-") !== false) {
			$cod_cel=substr($tlfcel,0,strpos($tlfcel,"-"));
			$tlfcel=substr($tlfcel,strpos($tlfcel,"-")+1);
		}

		$tlfhab = $data->tlfhab;
		if (strpos($tlfhab,"-") !== false) {
			$cod_hab=substr($tlfhab,0,strpos($tlfhab,"-"));
			$tlfhab=substr($tlfhab,strpos($tlfhab,"-")+1);
		}
		$tlfotro = $data->tlfotro;

		$ctabancaria=$data->ctabancaria;
		$banco=$data->banco;
		$tipocta=$data->tipocta;
		$dirmrw=$data->dirmrw;

		$estado = $data->id_estado;
		$municipio = $data->id_municipio;
		$parroquia = $data->id_parroquia;

		$privilegio = $data->privilegio;

		$codigo = $data->codigo;
		$con_regional = $data->con_regional;

		$observaciones = $data->observaciones;

		$acreditadocne = $data->acreditadocne;
		$activo = $data->activo;
		$capacitado = $data->capacitado;
		$cod_centro = $data->centrovotacion;
	}
}
?>

{!! Form::open(array('url' => 'guardar_registro', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<input type="hidden" name="id_estado" value="<?php echo $estado; ?>" />
<input type="hidden" name="id_municipio" value="<?php echo $municipio; ?>" />
<input type="hidden" name="id_parroquia" value="<?php echo $parroquia; ?>" />

<input type="hidden" name="id_observador" value="<?php echo $id_observador; ?>" />

	<legend>Registro de Observadores <?php if (SessionusuarioControllers::show("privilegio")==8) { echo "(Estado: ".buscar_estado_coordinador(SessionusuarioControllers::show("id_observador")).")"; } ?></legend>
		
<?php
	$error=0;
	if (strpos($mensaje,"suscribirse") !== false) {
		echo '<br /><div class="error" align="center">'.$mensaje.'</div>';
	} else {
		if ($mensaje != "") {
			echo '<br /><div class="error" align="center">'.$mensaje.'</div>';
			
			$error=1;
		}
?>
<br /><br />

<div class="form-group">
	<label class="control-label col-xs-3">Cedula:</label>
	<div class="col-xs-9">
		<input name="cedula" type="text" class="form-control" placeholder="Cedula" value="<?php echo $cedula; ?>" <?php if ($cedula!="" && SessionusuarioControllers::show("privilegio")!="1") echo " readonly "; ?> onkeypress="return numeros(event)">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Nombres:</label>
	<div class="col-xs-9">
		<input name="nombres" type="text" class="form-control" placeholder="Nombres" value="<?php echo $nombres; ?>" <?php if ($nombres!="" && SessionusuarioControllers::show("privilegio")!="1") echo " readonly "; ?> onkeypress="return caracteres(event)">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Apellidos:</label>
	<div class="col-xs-9">
		<input name="apellidos" type="text" class="form-control" placeholder="Apellidos" value="<?php echo $apellidos; ?>" <?php if ($apellidos!="" && SessionusuarioControllers::show("privilegio")!="1") echo " readonly "; ?> onkeypress="return caracteres(event)">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Sexo:</label>
	<div class="col-xs-3">
		<select name="sexo" class="form-control">
			<option value="0" selected="selected">Seleccione Sexo...</option>
			<option value="F" <?php if ($sexo=="F") echo "selected"; ?>>Femenino</option>
			<option value="M" <?php if ($sexo=="M") echo "selected"; ?>>Masculino</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Fecha de Nacimiento:</label>
	<div class="col-xs-3">
		<select name="dia_nac" class="form-control">
			<option>Dia...</option>
			<?php
				for($i=1; $i<32; $i++) {
					if ($i==$dia_nac)
						echo "<option value=$i selected>".$i."</option>";
					else
						echo "<option value=$i>".$i."</option>";
				}
			?>
		</select>
	</div>
	<div class="col-xs-3">
		<select name="mes_nac" class="form-control">
			<option>Mes...</option>
			<?php
				foreach($meses as $key=>$value) {
					if ($key==$mes_nac-1)
						echo "<option value=$key selected>$value</option>";
					else
						echo "<option value=$key>$value</option>";
				}
			?>
		</select>
	</div>
	<div class="col-xs-3">
		<select name="ano_nac" class="form-control">
			<option>Año...</option>
			<?php
			$today = getdate();

			$dia = $today["mday"];
			$mes = $today["mon"];
			$ano = $today["year"];
			$lista=$ano-17;
			for($i=1900; $i<$lista; $i++) {
				if ($i==$ano_nac)
					echo "<option value=$i selected>".$i."</option>";
				else
					echo "<option value=$i>".$i."</option>";
			}
			?>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Estado Civil:</label>
	<div class="col-xs-3">
		<select name="edocivil" class="form-control">
			<option value="0" selected="selected">Seleccione Estado Civil...</option>
			<option value="S" <?php if ($edocivil=="S") echo "selected"; ?>>Soltero (a)</option>
			<option value="C" <?php if ($edocivil=="C") echo "selected"; ?>>Casado (a)</option>
			<option value="D" <?php if ($edocivil=="D") echo "selected"; ?>>Divorciado (a)</option>
			<option value="V" <?php if ($edocivil=="V") echo "selected"; ?>>Viudo (a)</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Profesi&oacute;n:</label>
	<div class="col-xs-9">
		<input name="profesion" type="text" class="form-control" placeholder="Profesion" value="<?php echo $profesion; ?>">
	</div>
</div>

  <?php if (SessionusuarioControllers::show("privilegio")!=8) { ?>
	<div class="form-group">
		<label class="control-label col-xs-3">Estado:</label>
		<div class="col-xs-3">
			<select name="estado" id="estado" onchange="ver_municipio_jquery(this.form);" class="form-control">
				<option value=0>Todos los Estado...</option>
				<?php
				$sql = "select * from estado order by nombre";
				$data=DB::select($sql);
				foreach ($data as $data) {
				if (($estado>0) && ($estado==$data->id_estado)) {
				?>
				<option value="<?php echo $data->id_estado; ?>" selected><?php echo $data->nombre; ?></option>
				<?php
				} else {
				?>
				<option value="<?php echo $data->id_estado; ?>"><?php echo $data->nombre; ?></option>
				<?php
				}
				}
				?>
			</select>
		</div>

		<div class="col-xs-3">
            <span id="ver_municipio">
                <select name="municipio" id="municipio" class="form-control" onchange="ver_parroquia_jquery(this.form)">Seleccione Municipio...</select>
            </span>
		</div>
		<div class="col-xs-3">
            <span id="ver_parroquia">
                <select name="parroquia" class="form-control" id="parroquia">Seleccione Parroquia...</select>
            </span>
		</div>
	</div>
  <?php } ?>

<div class="form-group">
	<label class="control-label col-xs-3">Tel&eacute;fono Celular:</label>
	<div class="col-xs-3">
		<select name="cod_cel" class="form-control">
			<option value="412" <?php if ($cod_cel=="412") echo "selected"; ?>>412</option>
			<option value="414" <?php if ($cod_cel=="414") echo "selected"; ?>>414</option>
			<option value="424" <?php if ($cod_cel=="424") echo "selected"; ?>>424</option>
			<option value="416" <?php if ($cod_cel=="416") echo "selected"; ?>>416</option>
			<option value="426" <?php if ($cod_cel=="426") echo "selected"; ?>>426</option>
		</select>
		<input name="tlfcel" type="text" class="form-control" placeholder="Telefono Celular" value="<?php echo $tlfcel; ?>">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Tel&eacute;fono Habitacion:</label>
	<div class="col-xs-3">
		<select name="cod_hab" class="form-control">
			<option value='212' <?php if ($cod_hab=='212') echo "selected"; ?>>212</option>
			<option value='234' <?php if ($cod_hab=='234') echo "selected"; ?>>234</option>
			<option value='235' <?php if ($cod_hab=='235') echo "selected"; ?>>235</option>
			<option value='238' <?php if ($cod_hab=='238') echo "selected"; ?>>238</option>
			<option value='239' <?php if ($cod_hab=='239') echo "selected"; ?>>239</option>
			<option value='241' <?php if ($cod_hab=='241') echo "selected"; ?>>241</option>
			<option value='242' <?php if ($cod_hab=='242') echo "selected"; ?>>242</option>
			<option value='243' <?php if ($cod_hab=='243') echo "selected"; ?>>243</option>
			<option value='244' <?php if ($cod_hab=='244') echo "selected"; ?>>244</option>
			<option value='245' <?php if ($cod_hab=='245') echo "selected"; ?>>245</option>
			<option value='246' <?php if ($cod_hab=='246') echo "selected"; ?>>246</option>
			<option value='247' <?php if ($cod_hab=='247') echo "selected"; ?>>247</option>
			<option value='248' <?php if ($cod_hab=='248') echo "selected"; ?>>248</option>
			<option value='249' <?php if ($cod_hab=='249') echo "selected"; ?>>249</option>
			<option value='251' <?php if ($cod_hab=='251') echo "selected"; ?>>251</option>
			<option value='253' <?php if ($cod_hab=='253') echo "selected"; ?>>253</option>
			<option value='254' <?php if ($cod_hab=='254') echo "selected"; ?>>254</option>
			<option value='255' <?php if ($cod_hab=='255') echo "selected"; ?>>255</option>
			<option value='256' <?php if ($cod_hab=='256') echo "selected"; ?>>256</option>
			<option value='257' <?php if ($cod_hab=='257') echo "selected"; ?>>257</option>
			<option value='258' <?php if ($cod_hab=='258') echo "selected"; ?>>258</option>
			<option value='259' <?php if ($cod_hab=='259') echo "selected"; ?>>259</option>
			<option value='262' <?php if ($cod_hab=='262') echo "selected"; ?>>262</option>
			<option value='263' <?php if ($cod_hab=='263') echo "selected"; ?>>263</option>
			<option value='264' <?php if ($cod_hab=='264') echo "selected"; ?>>264</option>
			<option value='265' <?php if ($cod_hab=='265') echo "selected"; ?>>265</option>
			<option value='267' <?php if ($cod_hab=='267') echo "selected"; ?>>267</option>
			<option value='268' <?php if ($cod_hab=='268') echo "selected"; ?>>268</option>
			<option value='269' <?php if ($cod_hab=='269') echo "selected"; ?>>269</option>
			<option value='271' <?php if ($cod_hab=='271') echo "selected"; ?>>271</option>
			<option value='272' <?php if ($cod_hab=='272') echo "selected"; ?>>272</option>
			<option value='273' <?php if ($cod_hab=='273') echo "selected"; ?>>273</option>
			<option value='274' <?php if ($cod_hab=='274') echo "selected"; ?>>274</option>
			<option value='275' <?php if ($cod_hab=='275') echo "selected"; ?>>275</option>
			<option value='276' <?php if ($cod_hab=='276') echo "selected"; ?>>276</option>
			<option value='277' <?php if ($cod_hab=='277') echo "selected"; ?>>277</option>
			<option value='278' <?php if ($cod_hab=='278') echo "selected"; ?>>278</option>
			<option value='279' <?php if ($cod_hab=='279') echo "selected"; ?>>279</option>
			<option value='281' <?php if ($cod_hab=='281') echo "selected"; ?>>281</option>
			<option value='282' <?php if ($cod_hab=='282') echo "selected"; ?>>282</option>
			<option value='283' <?php if ($cod_hab=='283') echo "selected"; ?>>283</option>
			<option value='284' <?php if ($cod_hab=='284') echo "selected"; ?>>284</option>
			<option value='285' <?php if ($cod_hab=='285') echo "selected"; ?>>285</option>
			<option value='286' <?php if ($cod_hab=='286') echo "selected"; ?>>286</option>
			<option value='287' <?php if ($cod_hab=='287') echo "selected"; ?>>287</option>
			<option value='288' <?php if ($cod_hab=='288') echo "selected"; ?>>288</option>
			<option value='291' <?php if ($cod_hab=='291') echo "selected"; ?>>291</option>
			<option value='292' <?php if ($cod_hab=='292') echo "selected"; ?>>292</option>
			<option value='293' <?php if ($cod_hab=='293') echo "selected"; ?>>293</option>
			<option value='294' <?php if ($cod_hab=='294') echo "selected"; ?>>294</option>
			<option value='295' <?php if ($cod_hab=='295') echo "selected"; ?>>295</option>
		</select>
		<input name="tlfhab" type="text" class="form-control" placeholder="Telefono Habitacion" value="<?php echo $tlfhab; ?>">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Tel&eacute;fono Alternativo:</label>
	<div class="col-xs-9">
		<input name="tlfotro" type="text" class="form-control" placeholder="Otro Telefono" value="<?php echo $tlfotro; ?>">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Email:</label>
	<div class="col-xs-9">
		<input name="email" type="text" class="form-control" placeholder="Email" onblur="validarEmail(this)"  value="<?php echo $email; ?>">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Email Alternativo:</label>
	<div class="col-xs-9">
		<input name="email2" type="text" class="form-control" placeholder="Email" onblur="validarEmail(this)"  value="<?php echo $email2; ?>">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Dirección MRW más cercana:</label>
	<div class="col-xs-9">
		<textarea name="dirmrw" rows="3" class="form-control" placeholder="Direccion MRW"><?php echo $dirmrw; ?></textarea>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Privilegio:</label>
	<div class="col-xs-3">
		<select name="privilegio" class="form-control">
			<?php
			$sql = "select * from privilegio order by nombre";
			$data=DB::select($sql);
			foreach ($data as $data) {
			?>
			<option value="<?php echo $data->id_privilegio; ?>" <?php if ($privilegio==$data->id_privilegio) echo "selected"; ?>><?php echo $data->nombre; ?></option>
			<?php
			}
			?>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Contacto Regional:</label>
	<div class="col-xs-2">
		<label class="radio-inline">
			<input type="radio" <?php if ($con_regional==1) echo "checked"; ?> class="chk" name="con_regional" value="1" />Si
		</label>
	</div>
	<div class="col-xs-2">
		<label class="radio-inline">
			<input type="radio" <?php if ($con_regional==0) echo "checked"; ?> class="chk" name="con_regional" value="0" />No
		</label>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Observaciones:</label>
	<div class="col-xs-9">
		<textarea name="observaciones" rows="3" class="form-control" placeholder="Direccion MRW"><?php echo $observaciones; ?></textarea>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Acreditado por el CNE:</label>
	<div class="col-xs-2">
		<label class="radio-inline">
			<input class="chk" type="radio" name="acreditadocne" <?php if ($acreditadocne==1) echo "checked"; ?> value="1" />Si
		</label>
	</div>
	<div class="col-xs-2">
		<label class="radio-inline">
			<input class="chk" type="radio" name="acreditadocne" <?php if ($acreditadocne==0) echo "checked"; ?> value="0" />No
		</label>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Activo:</label>
	<div class="col-xs-2">
		<label class="radio-inline">
			<input class="chk" type="radio" name="activo" <?php if ($activo==1) echo "checked"; ?> value="1" />Si
		</label>
	</div>
	<div class="col-xs-2">
		<label class="radio-inline">
			<input class="chk" type="radio" name="activo" <?php if ($activo==0) echo "checked"; ?> value="0" />No
		</label>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Capacitado por Red de Observacion:</label>
	<div class="col-xs-2">
		<label class="radio-inline">
			<input class="chk" type="radio" name="capacitado" <?php if ($capacitado==1) echo "checked"; ?> value="1" />Si
		</label>
	</div>
	<div class="col-xs-2">
		<label class="radio-inline">
			<input class="chk" type="radio" name="capacitado" <?php if ($capacitado==0) echo "checked"; ?> value="0" />No
		</label>
	</div>
</div>


<div class="form-group">
	<label class="control-label col-xs-3">Pregunta Secreta:</label>
	<div class="col-xs-9">
		<input name="pregsec" type="text" class="form-control" placeholder="Pregunta Secreta" value="<?php echo $pregsec; ?>">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Respuesta Secreta:</label>
	<div class="col-xs-9">
		<input name="respsec" type="text" class="form-control" placeholder="Respuesta Secreta" value="<?php echo $respsec; ?>">
	</div>
</div>

	<?php
		if ($id_observador==0) {
	?>

<div class="form-group">
	<label class="control-label col-xs-3">Contrase&ntilde;a:</label>
	<div class="col-xs-9">
		<input name="contrasena1" type="password" class="form-control" placeholder="Contraseña"">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Repita su Contrase&ntilde;a:</label>
	<div class="col-xs-9">
		<input name="contrasena2" type="password" class="form-control" placeholder="Repita su Contrase&ntilde;a">
	</div>
</div>

  <?php } else { ?>
	<input type="hidden" name="contrasena1" value="*" />
	<input type="hidden" name="contrasena2" value="*" />
  <?php } ?>
</table>
<br /><br /><br />
<?php if (SessionusuarioControllers::show("privilegio")!=8 && SessionusuarioControllers::show("privilegio")!=9) { ?>

<div class="form-group">
	<div class="col-xs-offset-3 col-xs-9">
		<input  class="btn btn-primary" type="button" name="Guardar" value="Guardar" onclick="validar_observador(this.form)" />
		<input type="reset" class="btn btn-default" value="Limpiar">
	</div>
</div>

<?php } ?>

<?php if ($id_observador>0) { ?>
<br />
<!--div class="error" align="center">Nota: Ya su contraseña ha sido almacenada, si coloca otros datos en la  misma, esta será cambiada.</div-->
<?php } ?>

<br />
<div class="error" align="center">Todos los campos marcados con (*) son obligatorios</div>
<br /><br />
<?php } ?>
	
	<?php if (SessionusuarioControllers::show("privilegio")==8) { echo "<script>document.forms[0].id_estado.value=".buscar_id_estado_coordinador(SessionusuarioControllers::show("id_observador")).";</script>"; } ?>

<script>
	var f = eval("document.forms[0]");
	f.id_estado.value=<?php echo $estado; ?>;
	f.id_municipio.value=<?php if ($municipio=="") $municipio=0; echo $municipio; ?>;
	f.id_parroquia.value=<?php if ($parroquia=="") $parroquia=0;  echo $parroquia; ?>;
	ver_municipio_jquery(f);
	ver_parroquia_jquery(f);
</script>
{!! Form::close() !!}
@include('layaout.footer_admin')