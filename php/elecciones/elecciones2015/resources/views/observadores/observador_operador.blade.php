<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

?>
@include('layaout.header_admin')
{!! Form::open(array('url' => 'consultar_observadores_operadores', 'method' => 'post', 'class' =>  "form-horizontal")) !!}

<input type="hidden" name="id_estado" value="<?php echo $estado; ?>" />
<input type="hidden" name="id_municipio" value="<?php echo $municipio; ?>" />
<input type="hidden" name="id_parroquia" value="<?php echo $parroquia; ?>" />
<input type="hidden" name="id_observador" value="<?php echo $id_observador; ?>" />
<input type="hidden" name="id_asignacion" value="<?php echo $id_asignacion; ?>" />

<input type="hidden" name="dato" value="" />

<?php
	if ($mensaje!="")
		echo '<div class="error" align="center">'.$mensaje.'</div><br /><br />';
?>
	<legend>Asignacion de Operador</legend>
<br /><br />

<div class="form-group">
	<label class="control-label col-xs-3">Operador:</label>
	<div class="col-xs-3">
		<select name="cod_operador" id="cod_operador" class="form-control">
			<option value=0>Todos los Operadores...</option>
			<?php
			$sql = "select distinct(id_observador), nombres, apellidos from observador ";
			$sql .= "where privilegio=2 order by nombres, apellidos";
			$data=DB::select($sql);
			foreach ($data as $data) {
				if ($cod_operador==$data->id_observador)
					echo "<option value='".$data->id_observador."' selected>".$data->nombres." ".$data->apellidos."</option>";
				else
					echo "<option value='".$data->id_observador."'>".$data->nombres." ".$data->apellidos."</option>";
			}
			?>
		</select>
	</div>
</div>


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
	<label class="control-label col-xs-3">Centro:</label>
	<div class="col-xs-3">
        <span id="ver_centro">
            <select name="centro" class="form-control" id="centro">Seleccione Centro...</select>
        </span>
	</div>
</div>

<br /><br /><br />
<div align="center">
	<input class="btn btn-primary" type="button" name="Buscar" value="Buscar" onclick="buscar_asignaciones_operadores(this.form)" />
</div>


<script>
	var f = eval("document.forms[0]");
	f.id_estado.value=<?php echo $estado; ?>;
	f.id_municipio.value=<?php if ($municipio=="") $municipio=0; echo $municipio; ?>;
	f.id_parroquia.value=<?php if ($parroquia=="") $parroquia=0;  echo $parroquia; ?>;
	ver_municipio_jquery(f);
	ver_parroquia_jquery(f);
</script>

<br /><br />
	<a class="ver_mas" href="javascript:;" onclick="seleccionar_todo()">Marcar Todo</a> |
	<a class="ver_mas" href="javascript:;" onclick="deseleccionar_todo()">Desmarcar Todo</a>
<br /><br />
<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>C&eacute;dula</th>
		<th>Estado</th>
		<th>Nombre</th>
		<th>Tlf Cel</th>
		<th>Tlf Hab</th>
		<th>Tlf Otro</th>
		<th>Centro</th>
		<th>Operador Asignado</th>
		<th>Email</th>
		<th>&nbsp;</th>
  </tr>
	</thead>
	<tbody>
  <?php
		$sql = "select distinct(c.codigo) as codigo, o.id_observador, o.*, c.nombre as centro, c.codigo, ";
		$sql .= "e.nombre as estado, a.id_asignacion ";
		$sql .= "from observador o , asignacion a, centro c, estado e ";
		
		if ($cod_operador>0)
			$sql .= ", asignacion_operador ao ";
			
		$sql .= "where a.id_observador=o.id_observador and c.id_centro=a.id_centro and ";
		
		if ($cedula!="" && $cedula!=0)
			$sql .= "o.cedula='$cedula' and ";
			
		if ($nombres!="")
			$sql .= "o.nombres like '".strtoupper($nombres)."%' and ";
	
		if ($apellidos!="")
			$sql .= "o.apellidos like '".strtoupper($apellidos)."%' and ";
			
		if ($estado!=0)
			$sql .= "c.estado = $estado and ";
			
		if ($municipio!=0)
			$sql .= "c.municipio = $municipio and ";
			
		if ($parroquia!=0)
			$sql .= "c.parroquia = $parroquia and ";

		if ($cod_operador>0)
			$sql .= "ao.id_operador=$cod_operador and ao.id_observador=o.id_observador and ";
			
		$sql .= "e.id_estado=o.id_estado ";

		$sql .= " order by o.apellidos, o.nombres";
		//echo $sql;
		$data=DB::select($sql);
		$i=1;
		$j=1;
  		foreach ($data as $data) {
  			if ($i==1) $i=2;
			else $i=1;

		  	$id_asignacion=$data->id_asignacion;
			$cedula = $data->cedula;
			$nombres = $data->nombres;
			$apellidos = $data->apellidos;
			$email = $data->email;
			$id_observador = $data->id_observador;
			$tlfcel = $data->tlfcel;
			$tlfhab = $data->tlfhab;
			$tlfotro = $data->tlfotro;
			$autorizado = $data->autorizado;
			$privilegio = $data->privilegio;
			$fecha_ing = $data->fecha_ing;
			$centro = $data->centro;
			$codigo = $data->codigo;
			//$id_operador = $data->id_operador;
			$estado = $data->estado;
		?>
		  <tr>
			<td align="center"><?php echo $j; ?></td>
			<td align="center"><input class='chk' type="checkbox" name="chk_<?php echo $id_observador; ?>"></td>
			<td><?php echo $cedula; ?></td>
			<td><?php echo $estado; ?></td>
			<td><?php echo $apellidos." ".$nombres; ?></td>
			<td><?php echo $tlfcel; ?></td>
			<td><?php echo $tlfhab; ?></td>
			<td><?php echo $tlfotro; ?></td>
			<td><?php echo $centro." (".$codigo.")"; ?></td>
			<?php
			    //echo "...1)cod=$cod_operador...";
				//if ($cod_operador==0) {
					$sql = "select id_operador from asignacion_operador where id_observador=$id_observador";
					//echo $sql;
					$data2=DB::select($sql);
					$cod_operador=0;
					foreach ($data2 as $data2) {
					if ($data2->id_operador)
						$cod_operador=$data2->id_operador;
					}
				//}
			  //echo "...2)cod=$cod_operador...";
			?>
			<td><?php echo FuncionesControllers::buscar_operador($cod_operador); ?></td>
			<td><?php echo $email; ?></td>
			<td><?php if (FuncionesControllers::buscar_asignacion_reporte($id_asignacion)==0) { ?><img style="cursor:pointer" src="assets/images/cancel.gif" onclick="eliminar_asignacion(<?php echo $id_asignacion; ?>)" /><?php } ?></td>
		  </tr>		
		<?php
			$j++;
		}
  ?>
	</tbody>
</table>
<?php if ($j>1) { ?>
<br /><br />
<div align="center"><input class="btn btn-primary" type="button" name="Imprimir" value="Imprimir Listado" onclick="imprimir_listado(this.form)" />
<input class="btn btn-primary" type="button" name="Asignar" value="Asignar Observadores a Operador" onclick="asignar_operador(this.form)" /></div>
<br /><br />
<?php } ?>
<script>
	var f = eval("document.forms[0]");
	//f.id_estado.value=<?php echo $estado; ?>;
	//f.id_municipio.value=<?php if ($municipio=="") $municipio=0; echo $municipio; ?>;
	//f.id_parroquia.value=<?php if ($parroquia=="") $parroquia=0;  echo $parroquia; ?>;
	ver_municipio_jquery(f);
	ver_parroquia_jquery(f);
</script>

<div id="filter"></div>
<div id="buscar_asignar">
	<table width="80%">
		<tr>
			<td align="right"><img style="cursor: pointer;" src="images/btn_cerrar.png" alt="Cerrar Ventana" onclick="closebox('asignar', 0)" width="53" height="14" /></td>
		</tr>
		<tr>
			<td>Operador:
				<select name="operador">
					<?php
					echo "<option value='0'>Seleccione...</option>";
					$sql = "select * from observador where privilegio=2 order by nombres, apellidos";
					$data2=DB::select($sql);
					foreach ($data2 as $data2)
						echo "<option value='".$data2->id_observador."'>".$data2->nombres." ".$data2->apellidos."</option>";
					?>
				</select>
			</td>
		</tr>
		<tr class="fondo2">
			<td align="left">
				Elección:
				<select name="eleccion">
					<?php
					$sql = "select * from eleccion where fecha>=current_date order by nombre";
					$data2=DB::select($sql);
					foreach ($data2 as $data2) {
						echo "<option value='".$data2->id_eleccion."'>".$data2->nombre."</option>";
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td align="center"><input class="btn btn-primary" type="button" name="Asignar" value="Asignar" onclick="asignar_operador(this.form)" /></td>
		</tr>
	</table>
</div>

{!! Form::close() !!}
@include('layaout.footer_admin')