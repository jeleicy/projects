<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

?>
@include('layaout.header_admin')
{!! Form::open(array('url' => 'consultar_observadores', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<input type="hidden" name="id_estado" value="<?php echo $estado; ?>" />
<input type="hidden" name="id_municipio" value="<?php echo $municipio; ?>" />
<input type="hidden" name="id_parroquia" value="<?php echo $parroquia; ?>" />
<input type="hidden" name="id_observador" value="<?php echo $id_observador; ?>" />
<input type="hidden" name="id_asignacion" value="<?php echo $id_asignacion; ?>" />
<?php
	if ($mensaje!="")
		echo '<div class="error" align="center">'.$mensaje.'</div><br /><br />';
		
	if (SessionusuarioControllers::show("privilegio")==8)
		$estado=buscar_id_estado_coordinador(SessionusuarioControllers::show("id_observador"));
?>
	<legend>Consulta de Observadores <?php if (SessionusuarioControllers::show("privilegio")==8) { echo "(Estado: ".FuncionesControllers::buscar_estado_coordinador(SessionusuarioControllers::show("id_observador")).")"; } ?></legend>
<br /><br />
<br />
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
	<label class="control-label col-xs-3">Privilegio:</label>
	<div class="col-xs-3">
		<select name="privilegio" class="form-control">
			<option value="0">Todos...</option>
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
</table>
<br /><br /><br />

<div class="form-group">
	<div class="col-xs-offset-3 col-xs-9">
		<input  class="btn btn-primary" type="submit" name="Buscar" value="Buscar" />
		<input type="reset" class="btn btn-default" value="Limpiar">
	</div>
</div>

<br />
	<br />
	<div align="center">
		<a class="ver_mas" href="javascript:;" onclick="ver_excel_estadistica_observadores('exportar_estadisticas_observadores_excel')">Exportar a Excel reporte de Observadores</a>
		<br /><br />
		<?php
			$path = "excel";
			$dir = opendir($path);
			$reporte_estadisticas=0;
			while ($elemento = readdir($dir)) {
				if (strpos($elemento,"reporte_estadisticas_observadores") !== false) {
					echo '<a class="ver_mas_resaltado" href="excel/'.$elemento.'">'.$elemento.'</a><br />';			
				}
			}
			closedir($dir);	
		?>
	</div>
	<br />

<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>&nbsp;</th>
		<th>C&eacute;dula</th>
		<th>Nombre</th>
		<th>Autorizados</th>
		<th>Privilegio</th>
		<th>Fecha Ingreso</th>
		<th>&nbsp;</th>
  	</tr>
	</thead>
	<tbody>
  <?php
		$sql = "select * from observador ";
		$sql .= "where ";

		if ($cedula!="" && $cedula!=0)
			$sql .= "cedula='$cedula' and ";
			
		if ($nombres!="")
			$sql .= "nombres like '".strtoupper($nombres)."%' and ";
	
		if ($apellidos!="")
			$sql .= "apellidos like '".strtoupper($apellidos)."%' and ";
		
		if ($privilegio!=0)
			$sql .= "privilegio = '$privilegio' and ";
			
		if ($estado!=0)
			$sql .= "id_estado = $estado and ";
			
		if ($municipio!=0)
			$sql .= "id_municipio = $municipio and ";
			
		if ($parroquia!=0)
			$sql .= "id_parroquia = $parroquia and ";
		
		$sql = substr($sql,0,strlen($sql)-5);
			
		$sql .= " order by privilegio, apellidos, nombres";
		  //
		  //echo $sql;
		  $data=DB::select($sql);
		  $i=1;
		  $j=1;
		  foreach ($data as $data) {
			if ($i==1) $i=2;
			else $i=1;
			
			$cedula = $data->cedula;
			$nombres = $data->nombres;
			$apellidos = $data->apellidos;
			$email = $data->email;
			$id_observador = $data->id_observador;
			$tlfcel = $data->tlfcel;
			$autorizado = $data->autorizado;
			$privilegio = $data->privilegio;
			$fecha_ing = $data->fecha_ing;
		?>
		  <tr>
			<td align="center"><?php echo $j; ?></td>
			<td onclick="ver_observador(<?php echo $id_observador; ?>)" style="cursor:pointer"><?php echo $cedula; ?></td>
			<td onclick="ver_observador(<?php echo $id_observador; ?>)" style="cursor:pointer"><?php echo $apellidos." ".$nombres;; ?></td>
			<td align="center" style="cursor:pointer">
				<?php if (SessionusuarioControllers::show("id_observador")==$id_observador) echo "Si"; else { ?>
				<div id="autorizado_<?php echo $id_observador; ?>"><?php if($autorizado==1) echo "Si (<a class='ver_mas' href='javascript:;' onclick='bloquear($id_observador)'>Bloquear</a>)"; else echo "No (<a class='ver_mas' href='javascript:;' onclick='autorizar($id_observador)'>Autorizar</a>)"; ?></div>
				<?php } ?>
			</td>
			<td align="center" style="cursor:pointer"><?php echo FuncionesControllers::buscar_privilegio($privilegio); ?></td>
			<td align="center" style="cursor:pointer"><?php echo FuncionesControllers::fecha_normal($fecha_ing); ?></td>
			<td><?php if (SessionusuarioControllers::show("id_observador")==$id_observador) echo "&nbsp;"; else { ?><img style="cursor:pointer" src="assets/images/cancel.gif" onclick="eliminar_observador(<?php echo $id_observador; ?>)" /><?php } ?></td>
		  </tr>		
		<?php
			$j++;
		}
  ?>
	</tbody>
</table>

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