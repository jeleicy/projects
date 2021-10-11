<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Autd;
use URL;

use App\Http\Controllers\FuncionesControllers;

	$operador = FuncionesControllers::buscar_operador($cod_operador);
?>

		<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">

	<!-- MetisMenu CSS -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/metisMenu.min.css') }}">

	<!-- Timeline CSS -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/timeline.css') }}">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/sb-admin-2.css') }}">

	<!-- Morris Charts CSS -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/morris.css') }}">

	<!-- Custom Fonts -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/css/estilos.css') }}">

<br /><br />
<legend>Listado de Operador: <strong><?php echo $operador; ?></strong></legend>
<br /><br /><br />
<table cellspacing="10" cellpadding="10" widtd="100%" border="1">
	<tr align="center">
	<td>&nbsp;</td>
	<td>C&eacute;dula</td>
	<td>Estado</td>
	<td>Nombre</td>
	<td>Tlf Cel</td>
	<td>Tlf Hab</td>
	<td>Tlf Otro</td>
	<td>Email</td>
	<td>Centro</td>
	<td>Operador Asignado</td>
  </tr>
	<?php
	
		$sql = "select distinct(c.codigo) as codigo, o.id_observador, o.*, c.nombre as centro, c.codigo, ";
		$sql .= "e.nombre as estado ";
		$sql .= "from observador o , asignacion a, centro c, estado e ";
		
		if ($cod_operador>0)
			$sql .= ", asignacion_operador ao ";
			
		$sql .= "where a.id_observador=o.id_observador and c.id_centro=a.id_centro and ";
		
		if ($cedula!="" && $cedula!=0)
			$sql .= "cedula='$cedula' and ";
			
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
			$estado = $data->estado;
		?>
		  <tr class="fondo<?php echo $i; ?>">
			<td align="center"><?php echo $j; ?></td>
			<td><?php echo $cedula; ?></td>
			<td><?php echo $estado; ?></td>
			<td><?php echo $apellidos." ".$nombres; ?></td>
			<td><?php echo $tlfcel; ?></td>
			<td><?php echo $tlfhab; ?></td>
			<td><?php echo $tlfotro; ?></td>
			<td><?php echo $email; ?></td>
			<td><?php echo $centro." (".$codigo.")"; ?></td>
			<?php
				if ($cod_operador==0) {
					$sql = "select id_operador from asignacion_operador where id_observador=$id_observador";
			  		$data2=DB::select($sql);
				  	foreach ($data2 as $data2) {
						if ($data2->id_operador)
							$cod_operador=$data2->id_operador;
						else
							$cod_operador=0;
					}
				}
			?>			
			<td><?php echo FuncionesControllers::buscar_operador($cod_operador); ?></td>
		  </tr>		
		<?php
			$j++;
		}
	?>
</table>
<br />
<div align="center"><input class="btn btn-primary" type="button" name="Imprimir" value="Imprimir Listado" onclick="window.print()" /></div>