<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

?>
@include('layaout.header_admin')


	<legend>Estadistica de Cobertura</legend>	
<br />
{!! Form::open(array('url' => 'estadistica_cobertura', 'method' => 'get', 'class' =>  "form-horizontal")) !!}

<?php
	$sql = "select * from encuesta where nroreporte>0 order by nroreporte";
	$data=DB::select($sql);

	foreach ($data as $data)
		$titulos_reportes[] = $data->descripcion;
?>

<?php
	$eleccion=SessionusuarioControllers::show("id_eleccion");

	$sql = "select count(id_recuperacion) as cantidad from recuperacion";
	$data=DB::select($sql);
	$cantidad=0;
	foreach ($data as $data)
		$cantidad=$data->cantidad;
		
	if ($cantidad==0)
		echo "<div align='center' class='error'>No hay recuperaciones pendientes !!!</div><br>";
	else {
?>

<div class="form-group">
	<label class="control-label col-xs-3">Estado:</label>
	<div class="col-xs-3">
		<select name="estado" id="estado" class="form-control">
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
</div>
<div class="form-group">
	<label class="control-label col-xs-3">Tipo de Cobertura:</label>
	<?php
	$sql = "select distinct(nro_recuperacion) as recuperacion ";
	$sql .= "from recuperacion order by 1";
	$data=DB::select($sql);
	foreach ($data as $data) {
	?>
	<div class="col-xs-2">
		<label class="radio-inline">
			<input class="chk" type="radio" name="recuperado" id="recuperado" value="<?php echo $data->recuperacion; ?>" <?php if ($recuperado==$data->recuperacion) echo "checked"; ?>>Nivel <?php echo $data->recuperacion; ?>
		</label>
	</div>
	<?php } ?>
</div>

<div class="form-group">
	<label class="control-label col-xs-3">Reporte:</label>
	<div class="checkbox">
		<?php
		$array_reporte = explode(",", $reporte);
		foreach ($titulos_reportes as $key => $value) {
			$rep=($key+1);
			echo '<label><input type="checkbox" name="reporte'.$rep.'" value="1"';
			if (in_array($rep,$array_reporte))
				echo " checked";
			echo ">".$rep."</label>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		?>
	</div>
	</label>
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

<br />
<div align="center">
	<input class="btn btn-primary" type="button" id="buscar" name="Buscar" value="Buscar" onclick="buscar_recuperacion(this.form)" />
</div>

<br /><br />

    <table id="example" class="display" cellspacing="0" width="50%">
        <thead>
			<tr>
				<th>Observador</th>
				<th>Estado</th>
				<th>Nivel</th>
			</tr>
		</thead>
		<tbody>
	<?php
		$sql = "select distinct(r.id_encuesta), o.id_observador, ";
		$sql .= "o.nombres, o.apellidos, e.nombre as estado, r.nro_recuperacion as nivel, r.id_encuesta ";
		$sql .= "from observador o, estado e, recuperacion r, asignacion a, centro c ";
		$sql .= "where o.id_observador=r.id_observador and ";
		$sql .= "o.id_observador=a.id_observador and ";
		$sql .= "a.id_eleccion=$eleccion and a.id_centro=c.id_centro and ";
		if ($estado>0)
			$sql .= "c.estado=$estado and ";
		if ($circuito>0)
			$sql .= "c.circuito=$circuito and ";
		if ($reporte!='0')
			$sql .= "r.id_encuesta in ($reporte) and ";
		$sql .= "e.id_estado=c.estado and r.id_eleccion=a.id_eleccion and ";
		$sql .= "r.recuperado=0 and ";
		$sql .= "r.nro_recuperacion=$recuperado";
		$data=DB::select($sql);

		foreach ($data as $data) {
			?>
				<tr>
					<td><?php echo $data->nombres." ".$data->apellidos ?></td>
					<td><?php echo $data->estado ?></td>
					<td align="center"><?php echo $data->nivel ?></td>
				</tr>
			<?php
		}
	?>
	 </tbody>
</table>
<br />
<?php
	$reporte=str_replace(",",".",$reporte);
?>
<div align="center">
	<!--input class="btn btn-primary" type="button" id="buscar" name="Imprimir" value="Imprimir Listado Cobertura" onclick="imprimir_listado_recuperacion_cobertura(this.form)" /-->
	<a class="ver_mas" href="javascript:;" onclick="ver_excel('exportar_excel_cobertura/<?php echo $eleccion.",",$recuperado.",".$estado.",".$reporte.",".$circuito; ?>')">Exportar a Excel datos_cobertura</a>
</div>
<?php } ?>
{!! Form::close() !!}
@include('layaout.footer_admin')