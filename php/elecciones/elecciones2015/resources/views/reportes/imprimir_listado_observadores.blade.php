<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Auth;
use App\Http\Controllers\FuncionesControllers;
use Illuminate\Support\Facades\URL;

//$operador = FuncionesControllers::buscar_operador($id_operador);
?>
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">

<!-- MetisMenu CSS -->
<link rel="stylesheet" href="{{ URL::asset('assets/css/metisMenu.min.css') }}">

<!-- Timeline CSS -->
<link rel="stylesheet" href="{{ URL::asset('assets/css/timeline.css') }}">

<!-- Custom CSS -->
<link rel="stylesheet" href="{{ URL::asset('assets/css/sb-admin-2.css') }}">

Listado de Observadores con las condiciones:
<br /><br />
<?php
	if ($cedula!=0 && $cedula!="")
		echo "<br /><strong>Cedula</strong>: ".$cedula;
	if ($estatus_busqueda!=0 && $estatus_busqueda!="")
		echo "<br /><strong>Estatus de Busqueda</strong>: ".$estatus_busqueda;
	if ($estado!=0 && $estado!="")
		echo "<br /><strong>Estado</strong>: ".$estado;
	if ($municipio!=0 && $municipio!="")
		echo "<br /><strong>Municipio</strong>: ".$municipio;
	if ($parroquia!=0 && $parroquia!="")
		echo "<br /><strong>Parroquia</strong>: ".$parroquia;
	if ($centro!=0 && $centro!="")
		echo "<br /><strong>Centro</strong>: ".$centro;
	if ($reporte!=0 && $reporte!="")
		echo "<br /><strong>Reporte</strong>: ".$reporte;
?>
<br /><br /><br />
<table width="100%" border="1" cellspacing="10" cellpadding="10" class="tablas_int" align="center">
  <tr align="center">
	<td>&nbsp;</td>
	<td><strong>C&eacute;dula</strong></td>
	<td><strong>Nombre</strong></td>
	<td><strong>Tlf Cel</strong></td>
	<td><strong>Tlf Hab</strong></td>
	<td><strong>Tlf Otro</strong></td>
	<td><strong>Email</strong></td>
  </tr>
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
		$sql .= " order by o.apellidos, o.nombres";
		//echo $sql;

		$data=DB::select($sql);
		$i=1;
		$j=1;
		foreach ($data as $data) {
			if ($i==1) $i=2;
			else $i=1;
			
			$nac = $data->nac;
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
			//$centro = $data->centro;
			$codigo = $data->codigo;
			$id_asignacion = $data->id_asignacion;
			
			$estatus=FuncionesControllers::buscar_estatus($id_asignacion);
		?>
		  <tr>
			<td align="center"><br /><strong><?php echo $j; ?>.- </strong><br /></td>
			<td><br /><?php echo $cedula; ?><br /></td>
			<td><br /><?php echo $apellidos." ".$nombres; ?><br /></td>
			<td><br /><?php echo $tlfcel; ?><br /></td>
			<td><br /><?php echo $tlfhab; ?><br /></td>
			<td><br /><?php echo $tlfotro; ?><br /></td>
			<td><br /><?php echo $email; ?><br /></td>
			</td>
		  </tr>
		<?php
			$j++;
		}
  ?>
</table>
<br /><br />
<div align="center">
	<input class="btn btn-primary" type="button" name="Imprimir" value="Imprimir Listado" onclick="window.print()" />
</div>
<br /><br />