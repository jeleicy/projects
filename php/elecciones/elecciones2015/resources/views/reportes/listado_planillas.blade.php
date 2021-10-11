<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>
@include('layaout.header_admin')

{!! Form::open(array('url' => 'buscar_listado_planillas', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<input type="hidden" name="id_estado" value="<?php echo $estado; ?>" />
<input type="hidden" name="id_municipio" value="<?php echo $municipio; ?>" />
<input type="hidden" name="id_parroquia" value="<?php echo $parroquia; ?>" />
<?php
	$sql = "select * from encuesta where nroreporte>0 order by nroreporte";
	$data=DB::select($sql);
	
	foreach ($data as $data)
		$titulos_reportes[] = $data->descripcion;
?>

	<legend>listado de planillas procesadas</legend>
<br /><br />
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

<div class="form-group">
	<label class="control-label col-xs-3">Circuito del Centro de Votacion:</label>
	<div class="col-xs-3">
		<select name="circuito" class="form-control">
			<?php
				$sql = "select distinct(circuito) as circuito from centro order by 1";
				$data=DB::select($sql);
				echo "<option value=0>Todos</option>";
				foreach ($data as $data) {
					if ($data->circuito==$circuito)
						echo "<option value=".$data->circuito." selected>".$data->circuito."</option>";
					else
						echo "<option value=".$data->circuito.">".$data->circuito."</option>";
				}

			?>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Nro Reporte:</label>
	<div class="col-xs-3">
		<select name="reporte" class="form-control">
			<?php
			echo "<option value=0>Todos</option>";
			foreach ($titulos_reportes as $key => $value) {
				echo '<option value="'.($key+1).'" ';
				if ($reporte==($key+1))
					echo "selected";
				echo ">Reporte ".($key+1)."</option>";
			}
			?>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Planillas Verificadas:</label>
	<div class="col-xs-offset-3 col-xs-9">
		<label class="checkbox-inline">
			<input type="radio" class="chk" name="verificadas" value="1" <?php if($verificadas==1) echo "checked"; ?> />Si
			<input type="radio" class="chk" name="verificadas" value="-1" <?php if($verificadas==-1) echo "checked"; ?> />Todas
		</label>
	</div>
</div>

<br /><br /><br />
<div align="center">
	<input class="btn btn-primary" type="submit" name="Buscar" value="Buscar" />
	&nbsp;
	<!--input class="btn btn-primary" type="button" name="Asignar" value="Asignar Operador" onclick="openbox('asignar', 0)" /-->
</div>
<br /><br />
    <table id="example" class="display" cellspacing="0" width="80%">
        <thead>
		<tr>
			<th>Estrato</th>
			<th>Reporte</th>
			<th>Estado</th>
			<th>Municipio</th>
			<th>Observador</th>
			<th>Centro</th>
			<th>Cod centro</th>
			<th>Mesa</th>
			<th>Planilla<br />Verificada</th>
		</tr>
		</thead>
		<tbody>
  <?php
	$sql = "select distinct(pre.id_encuesta), o.nombres, o.apellidos, edo.nombre as estado, ";
	$sql .= "mun.nombre as municipio, o.id_observador, ";
	$sql .= "par.nombre as parroquia, c.nombre as centro, c.codigo, a.nro_mesa, c.estrato, c.id_centro ";
	
	$sql .= "from encuesta_observador eo, observador o, asignacion a, centro c, estado edo, ";
	$sql .= "municipio mun, parroquia par, pregunta pre, encuesta enc";
	if ($verificadas==1)
		$sql .= ", planillas_verificadas pv ";
	
	$sql .= " where eo.id_observador=o.id_observador and a.id_observador=o.id_observador and ";
	$sql .= "a.id_centro=c.id_centro and c.estado=edo.id_estado and c.municipio=mun.id_municipio and ";
	$sql .= "c.estado=mun.id_estado and mun.id_estado and ";
	$sql .= "c.parroquia=par.id_parroquia and par.id_estado=mun.id_estado and ";
	$sql .= "par.id_municipio=c.municipio and ";
	$sql .= "pre.id_pregunta=eo.id_pregunta and pre.id_encuesta=enc.id_encuesta and ";
	
	if ($estado>0)
		$sql .= "edo.id_estado=$estado and ";
		
	if ($municipio>0)
		$sql .= "mun.id_municipio=$municipio and ";
		
	if ($parroquia>0)
		$sql .= "par.id_parroquia=$parroquia and ";

  if ($circuito>0)
	  $sql .= "c.circuito=$circuito and ";
	/*
	if ($cod_centro>0)
		$sql .= "c.codigo=$cod_centro and ";
	*/
	if ($reporte>0)
		$sql .= "pre.id_encuesta=$reporte and ";
	
	$sql = substr($sql,0,strlen($sql)-5);
	
	if ($verificadas==1)
		$sql .= " and pv.id_encuesta=pre.id_encuesta and pv.verificada=1 and pv.id_observador=eo.id_observador and pv.mesa=a.nro_mesa and pv.id_centro=c.id_centro ";
	
	$sql .= " order by pre.id_encuesta, o.nombres, o.apellidos, estado, municipio, parroquia, centro, ";
	$sql .= "a.nro_mesa";	
	
	//echo $sql;
	
	$data=DB::select($sql);
	
	$i=1;
	foreach ($data as $data) {
	?>
	  <tr>
		<td><?php echo $data->estrato; ?></td>
		<td><?php echo "Reporte ".$data->id_encuesta; ?></td>
		<td><?php echo $data->estado; ?></td>
		<td><?php echo $data->municipio; ?></td>
		<td><?php echo $data->nombres." ".$data->apellidos; ?></td>
		<td><?php echo $data->centro; ?></td>
		  <td><?php echo $data->codigo; ?></td>
		<td><?php echo $data->nro_mesa; ?></td>
		<td align="center"><input type="checkbox" class="chk" name="verificada_<?php echo $data->id_observador."_".$data->nro_mesa."_".$data->id_centro."_".$data->id_encuesta; ?>" value="1" <?php if (FuncionesControllers::verificada_planilla($data->id_observador, $data->nro_mesa, $data->id_centro, $data->id_encuesta)) echo "checked"; ?> /></td>
	  </tr>	
	<?php
	}
  ?>
  </tbody>
</table>
<br /><br />
<div align="center">
	<input class="btn btn-primary" type="submit" name="Buscar" value="Guardar Verificaciones" />
	<input class="btn btn-primary" type="button" name="Buscar" value="Imprimir Reporte" onclick="imprimir_planillas(this.form)" />
</div>
<br /><br />
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