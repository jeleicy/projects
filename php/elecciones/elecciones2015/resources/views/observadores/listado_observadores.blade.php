<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use Session;
use DB;
use Form;

?>

<?php
	$sql = "select * from encuesta where nroreporte>0 order by nroreporte";
	$data=DB::select($sql);
	foreach ($data as $data)
		$titulos_reportes[] = $data->descripcion;
?>

@include('layaout.header_admin')
<table width="100%" border="0" cellspacing="2" cellpadding="10" align="center">
<tr>
	<td>
		<br /><br />
{!! Form::open(array('url' => 'buscar_listado_observadores', 'method' => 'post', 'class' =>  "form-horizontal")) !!}

		<input type="hidden" name="id_estado" value="<?php echo $estado; ?>" />
		<input type="hidden" name="id_municipio" value="<?php echo $municipio; ?>" />
		<input type="hidden" name="id_parroquia" value="<?php echo $parroquia; ?>" />
		<input type="hidden" name="id_centro" value="<?php echo $centro; ?>" />

		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<div class="form-group">
		<label class="control-label col-xs-3">Buscar por Cedula Observador:</label>
		<div class="col-xs-9">
			<input name="cedula" type="text" class="form-control" placeholder="Cedula" value="<?php echo $cedula; ?>" <?php if ($cedula!="" && SessionusuarioControllers::show("privilegio")!="1") echo " readonly "; ?> onkeypress="return numeros(event)">
		</div>
	</div>
<br />

		<div class="form-group">
			<label class="control-label col-xs-3">Buscar por estatus:</label>
			<div class="col-xs-3">
				<select name="estatus_busqueda" class="form-control">
					<option value="0" <?php if ($estatus_busqueda==0) echo "selected"; ?>>Todos</option>
					<option value="1" <?php if ($estatus_busqueda==1) echo "selected"; ?>>No Procesadas</option>
					<option value="2" <?php if ($estatus_busqueda==2) echo "selected"; ?>>Procesadas</option>
					<option value="3" <?php if ($estatus_busqueda==3) echo "selected"; ?>>Recuperacion 1</option>
					<option value="4" <?php if ($estatus_busqueda==4) echo "selected"; ?>>Recuperacion 2</option>
				</select>
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
					<select name="parroquia" class="form-control" id="parroquia" onchange="ver_centro_jquery(this.form)">Seleccione Parroquia...</select>
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

		<div class="form-group">
			<label class="control-label col-xs-3">Reportes:</label>
			<div class="col-xs-3">
				<select name="reporte" class="form-control">
					<?php
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

		<div align="center"><input class="btn btn-primary" type="submit" id="buscar" name="Buscar" value="Buscar" /></div>

{!! Form::close() !!}
<br /><br />
<div align="center">
<strong>Leyenda:</strong>
<img src="assets/images/nollamada.gif" width="35" height="25" border=0 />Llamada no realizada /
<img src="assets/images/planllena.gif" width="35" height="25" border=0 />Procesado Satisfactoriamente /
<img src="assets/images/recup1.gif" width="35" height="25" border=0 />Recuperacion 1 /
<img src="assets/images/recup2.gif" width="35" height="25" border=0 />Recuperacion 2
</div>
<br /><br />
</td>
</tr>
<tr>
<td>
	<table id="example" class="display" cellspacing="0" width="100%">
		<thead>
		  <tr>
			<th align="center">C&eacute;dula</th>
			<th align="center">Nombre</th>
			<th align="center">Tlf Cel/Hab/Otro</th>
			<th align="center">Estado</th>
			<!--th>Email</th-->
			<th align="center">Estatus</th>
		  </tr>
		</thead>
		<tbody>
  <?php
		$sql = "select distinct(o.id_observador), o.*, a.id_asignacion, est.nombre as estado ";
		$sql .= "from observador o, asignacion a, asignacion_operador ao, estado est, centro c ";
		if ($estatus_busqueda>0 || $reporte>0)
			$sql .= ", estatus e ";
		$sql .= "where a.id_observador=o.id_observador and ";
		$sql .= "ao.id_observador=o.id_observador and ";
  		$sql .= "a.id_centro=c.id_centro and c.estado=est.id_estado ";
		if ($estatus_busqueda>0) {
			//$sql .= " and e.id_operador=ao.id_operador and ";
			$sql .= " and e.id_asignacion=a.id_asignacion ";
		}
		if (SessionusuarioControllers::show("id_observador")>1)
			$sql .= " and ao.id_operador=".SessionusuarioControllers::show("id_observador");

		if ($cedula!=0 && $cedula!="")
			$sql .= " and o.cedula=$cedula ";

  		if ($estado!=0 && $estado!="")
			$sql .= " and c.estado=$estado ";

		if ($municipio!=0 && $municipio!="")
			$sql .= " and c.municipio=$municipio ";

		if ($parroquia!=0 && $parroquia!="")
			$sql .= " and c.parroquia=$parroquia ";

  		if ($centro!=0 && $centro!="")
			$sql .= " and a.id_centro=$centro ";

		if ($reporte!=0 && $reporte!="") {
			if ($estatus_busqueda==1)
				$sql .= " and e.r".$reporte."_estatus='' ";
			elseif ($estatus_busqueda==2)
				$sql .= " and e.r".$reporte."_estatus='P' ";
			elseif ($estatus_busqueda==3)
				$sql .= " and e.r".$reporte."_estatus='RC1' ";
			elseif ($estatus_busqueda==4)
				$sql .= " and e.r".$reporte."_estatus='RC2' ";
		}
		/*	if ($reporte==2) {
				if ($estatus_busqueda==1)
					$sql .= " and e.r1_estatus='' ";
				elseif ($estatus_busqueda==2)
					$sql .= " and e.r1_estatus='P' ";
				elseif ($estatus_busqueda==3)
					$sql .= " and e.r1_estatus='RC1' ";
				elseif ($estatus_busqueda==4)
					$sql .= " and e.r1_estatus='RC2' ";
			}
			if ($reporte==3)
				$sql .= " and e.r3_estatus='P' ";
			if ($reporte==4)
				$sql .= " and e.r4_estatus='P' ";
			if ($reporte==5)
				$sql .= " and e.r5_estatus='P' ";*/
		//}

		/*if ($estatus_busqueda>0) {
			if ($estatus_busqueda==1)
				$sql .= " and (e.r1_estatus='' or e.r2_estatus='' or e.r3_estatus='' or e.r4_estatus='' or e.r5_estatus='')";
			elseif ($estatus_busqueda==2)
				$sql .= " and (e.r1_estatus='P' or e.r2_estatus='P' or e.r3_estatus='P' or e.r4_estatus='P' or e.r5_estatus='P')";
			elseif ($estatus_busqueda==3)
				$sql .= " and (e.r1_estatus='RC1' or e.r2_estatus='RC1' or e.r3_estatus='RC1' or e.r4_estatus='RC1' or e.r5_estatus='RC1')";
			elseif ($estatus_busqueda==4)
				$sql .= " and (e.r1_estatus='RC2' or e.r2_estatus='RC2' or e.r3_estatus='RC2' or e.r4_estatus='RC2' or e.r5_estatus='RC2')";
		}*/
		$sql .= " order by o.apellidos, o.nombres";
		//echo $sql;

		$data=DB::select($sql);
		$i=1;
		$j=1;
		foreach ($data as $data) {
			if ($i==1) $i=2;
			else $i=1;

			$nac = $data->nac;
			$cedula_observ = $data->cedula;
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
			//$centro = $data->centro;
			$codigo = $data->codigo;
			$id_asignacion = $data->id_asignacion;
  			$estado_observ = $data->estado;

			$estatus=FuncionesControllers::buscar_estatus($id_asignacion);
		?>
		<tr>
			<td><?php echo $nac."-".$cedula_observ; ?></td>
			<td><?php echo $apellidos." ".$nombres;; ?></td>
			<td><?php echo $tlfcel."/".$tlfhab."/".$tlfotro; ?></td>
			<td><?php echo $estado_observ; ?></td>
			<!--td><?php echo $email; ?></td-->
			<td>
				<?php
					$r1=substr($estatus,0,strpos($estatus,"/"));
					$estatus=substr($estatus,strpos($estatus,"/")+1);
					$r2=substr($estatus,0,strpos($estatus,"/"));
					$estatus=substr($estatus,strpos($estatus,"/")+1);
					$r3=substr($estatus,0,strpos($estatus,"/"));
					$estatus=substr($estatus,strpos($estatus,"/")+1);
					$r4=substr($estatus,0,strpos($estatus,"/"));
					$estatus=substr($estatus,strpos($estatus,"/")+1);
					$r5=$estatus;

					if ($r1=="") $imagen1="r1_nollamada";
					elseif ($r1=="P") $imagen1="r1_planllena";
					elseif ($r1=="RC1") $imagen1="r1_recup1";
					elseif ($r1=="RC2") $imagen1="r1_recup2";

					if ($r2=="") $imagen2="r2_nollamada";
					elseif ($r2=="P") $imagen2="r2_planllena";
					elseif ($r2=="RC1") $imagen2="r2_recup1";
					elseif ($r2=="RC2") $imagen2="r2_recup2";

					if ($r3=="") $imagen3="r3_nollamada";
					elseif ($r3=="P") $imagen3="r3_planllena";
					elseif ($r3=="RC1") $imagen3="r3_recup1";
					elseif ($r3=="RC2") $imagen3="r3_recup2";

					if ($r4=="") $imagen4="r4_nollamada";
					elseif ($r4=="P") $imagen4="r4_planllena";
					elseif ($r4=="RC1") $imagen4="r4_recup1";
					elseif ($r4=="RC2") $imagen4="r4_recup2";

					if ($r5=="") $imagen5="r5_nollamada";
					elseif ($r5=="P") $imagen5="r5_planllena";
					elseif ($r5=="RC1") $imagen5="r5_recup1";
					elseif ($r5=="RC2") $imagen5="r5_recup2";
				?>
				<a href="reporte_planilla/1,<?php echo $id_observador; ?>,0,<?=$cedula?>"><img src="assets/images/<?php echo $imagen1; ?>.gif" width="35" height="25" border=0></a>
				<a href="reporte_planilla/2,<?php echo $id_observador; ?>,0,<?=$cedula?>"><img src="assets/images/<?php echo $imagen2; ?>.gif" width="35" height="25" border=0></a>
				<a href="reporte_planilla/3,<?php echo $id_observador; ?>,0,<?=$cedula?>"><img src="assets/images/<?php echo $imagen3; ?>.gif" width="35" height="25" border=0></a>
				<a href="reporte_planilla/4,<?php echo $id_observador; ?>,0,<?=$cedula?>"><img src="assets/images/<?php echo $imagen4; ?>.gif" width="35" height="25" border=0></a>
				<a href="reporte_planilla/5,<?php echo $id_observador; ?>,0,<?=$cedula?>"><img src="assets/images/<?php echo $imagen5; ?>.gif" width="25" height="25" border=0></a>
			</td>
		  </tr>
		<?php
			$j++;
		}
  ?>
		</tbody>
</table>
</td>
</tr>
</table>
<br /><br />
<div align="center">
	<input class="btn btn-primary" type="button" name="Imprimir" value="Imprimir Listado" onclick="imprimir_listado_operador('<?=$cedula?>','<?=$estatus_busqueda?>','<?=$estado?>','<?=$municipio?>','<?=$parroquia?>','<?=$centro?>','<?=$reporte?>')" />
	<input class="btn btn-primary" type="button" name="Regresar" value="Regresar" onclick="history.back();" />
</div>
<br /><br />

<script>
	var f = eval("document.forms[0]");
	f.id_estado.value=<?php echo $estado; ?>;
	f.id_municipio.value=<?php if ($municipio=="") $municipio=0; echo $municipio; ?>;
	f.id_parroquia.value=<?php if ($parroquia=="") $parroquia=0;  echo $parroquia; ?>;
	f.id_centro.value=<?php if ($centro=="") $centro=0;  echo $centro; ?>;

	ver_municipio_jquery(f);
	ver_parroquia_jquery(f);
	ver_centro_jquery(f);
	ver_centro_mesas_jquery(f);
</script>
@include('layaout.footer_admin')