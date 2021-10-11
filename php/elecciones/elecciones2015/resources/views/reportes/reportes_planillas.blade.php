<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>
@include('layaout.header_admin')
{!! Form::open(array('url' => 'reporte_planilla_guardar/'.$numero.',0,0,'.$cedula.'/', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<?php

	if ($cedula>0) {
		$sql = "select id_observador from observador where cedula='$cedula'";
		$data = DB::select($sql);
		foreach ($data as $data)
			$id_observador=$data->id_observador;
	} else {
		$sql = "select cedula from observador where id_observador=".$id_observador;
		$data = DB::select($sql);
		foreach ($data as $data)
			$cedula=$data->cedula;
	}
?>

	<input type="hidden" name="guardar_forma" value="<?=$guardar_forma?>" />
	<input type="hidden" name="eliminar" value="<?=$eliminar?>" />
	<input type="hidden" name="buscar_observ" value="<?=$buscar_observ?>" />
	<input type="hidden" name="numero" value="<?=$numero?>" />
	<input type="hidden" name="cedula" value="<?=$cedula?>" />
	<input type="hidden" name="nro_recuperacion" value="0" />

	<input type="hidden" name="id_asignacion" value="0" />
	<input type="hidden" name="id_observador" value="0" />

<br /><br />
<div align="center">
	<a class='ver_mas' href="../listado_observadores">Listado de Observadores</a> |
	<a class='ver_mas' href="../reporte_planilla/1,0,0,<?=$cedula?>"><span class="<?php if ($numero==1) echo "sobre_menu"; ?>">Reporte 1</span></a> |
	<a class='ver_mas' href="../reporte_planilla/2,0,0,<?=$cedula?>"><span class="<?php if ($numero==2) echo "sobre_menu"; ?>">Reporte 2</span></a> |
	<a class='ver_mas' href="../reporte_planilla/3,0,0,<?=$cedula?>"><span class="<?php if ($numero==3) echo "sobre_menu"; ?>">Reporte 3</span></a> |
	<a class='ver_mas' href="../reporte_planilla/4,0,0,<?=$cedula?>"><span class="<?php if ($numero==4) echo "sobre_menu"; ?>">Reporte 4</span></a> |
	<a class='ver_mas' href="../reporte_planilla/5,0,0,<?=$cedula?>"><span class="<?php if ($numero==5) echo "sobre_menu"; ?>">Reporte 5</span></a>
</div>

<?php
	//$titulos_reportes[] = $data->descripcion;
	$sql = "select * from encuesta where nroreporte>0 order by nroreporte";
	$data = DB::select($sql);
	
	foreach ($data as $data)
		$titulos_reportes[] = $data->descripcion;
?>

<legend>Reporte <?=$numero?> - <?php echo $titulos_reportes[$numero-1]; ?></legend>
<?php

$sql = "select count(id_asignacion) as cant, id_asignacion from asignacion where id_observador=$id_observador";

$data = DB::select($sql);
foreach ($data as $data)
	if ($data->cant) {
		$cantidad_asignaciones=$data->cant;
		$id_asignacion=$data->id_asignacion;
	}

$recuperacion = FuncionesControllers::buscar_recuperacion($id_asignacion,$numero);
$entro=1;

if (SessionusuarioControllers::show("id_eleccion") && $guardar_forma==1) {
	echo "<div align='center' class='error'>Registro insertado satisfactoriamente !!!</div><br>";
	echo '<script>window.open("../imprimir_planilla_llena/cedula='.$cedula.',asignacion='.$id_asignacion.',reporte='.$numero.'", "Listado", "location=1,status=1,scrollbars=yes, width=900,height=700");</script>';
}

//if (SessionusuarioControllers::show("id_eleccion") && $guardar_forma==0) {
$sql = "select nombre from eleccion where id_eleccion=".SessionusuarioControllers::show("id_eleccion");
$data = DB::select($sql);
foreach ($data as $data)
	echo "Elecci&oacute;n: <span class='titulo_interno'>".$data->nombre."</span><br /><br />";

//if ($_SESSION["nac"]=="" && $_SESSION["cedula"]=="") {
if ($cedula=="") {
if ($cedula==0 || $cedula=="" || $estado==0 || $municipio==0 || $parroquia==0 || $mesa=="" || $mesa==0) {
	//echo "<div align='center' class='error'>Para la consulta debe colocar la cedula del observador, estado, municipio, parroquia y numero de mesa</div><br>";
	$entro=0;
} else {
$sql = "select * from observador where nac='$nac' and cedula='$cedula'";
$data = DB::select($sql);
foreach ($data as $data) {
if (!$data->id_observador) {
	echo "<div align='center' class='error'>La cedula del observador introducido, no existe</div><br>";
	$entro=0;
} else {
$observador = $data->nombres." ".$data->apellidos;
$id_observador = $data->id_observador;
?>
<script>document.forms[0].id_observador.value=<?php echo $id_observador; ?>;</script>
<?php
}
}
}
} else {
	//$cedula=$_SESSION["cedula"];
	$entro=1;
}

if ($cedula=="") {
	$sql = "select cedula from observador where id_observador=$id_observador";
	$data = DB::select($sql);
	foreach ($data as $data) {
		$id_observador=$data->id_observador;
		$cedula=$data->cedula;
	}
}

//$recuperacion=0;
if ($buscar_observ==1) {
	echo "<script>buscar_codigo(".$cedula.", ".SessionusuarioControllers::show("id_eleccion").")</script>";
	$sql = "select max(nro_recuperacion) as nro_recuperacion, a.id_centro, a.nro_mesa, c.nombre, c.codigo ";
	$sql .= "from recuperacion r, centro c, asignacion a ";
	$sql .= "where a.id_asignacion=r.id_asignacion and a.id_asignacion=$id_asignacion and ";
	$sql .= "a.id_centro=c.id_centro and id_encuesta=$numero";
	//echo $sql;
	$data = DB::select($sql);
	foreach ($data as $data) {
		$recuperacion=0;
		if ($data->nro_recuperacion) {
			echo "<div align='center' class='error'>Este reporte esta en recuperacion <span class='resaltador'>Nro: ".$data->nro_recuperacion."</span> en el <br />Centro: <span class='resaltador'>".$data->nombre." (".$data->codigo.")"."</span> , en la Mesa: <span class='resaltador'>".$data->nro_mesa."</span></div><br>";
			if ($data->nro_recuperacion) $recuperacion=$data->nro_recuperacion;
		}
	}
}

if ($recuperacion>0) {
	echo "<script>buscar_codigo(".$cedula.", ".SessionusuarioControllers::show("id_eleccion").")</script>";
	$sql = "update recuperacion set bloqueo=1 ";
	$sql .= "where id_observador=$id_observador and id_eleccion=".SessionusuarioControllers::show("id_eleccion");
}
?>
<?php
		//echo "2)cedula=".$cedula."...id_observador=".$id_observador;
if ($recuperacion==0 || (SessionusuarioControllers::show("privilegio")==4 || SessionusuarioControllers::show("privilegio")==1)) {
if ($cedula!="" || $id_observador>0) {
$sql = "select max(e.id_encuesta) as encuesta ";
$sql .= "from pregunta p, encuesta e, encuesta_observador eo, observador o ";
$sql .= "where o.id_observador=eo.id_observador and eo.id_pregunta=p.id_pregunta and p.id_encuesta=e.id_encuesta and ";
if ($id_observador>0)
	$sql .= "o.id_observador=$id_observador";
else
	$sql .= "o.cedula='$cedula'";

$data = DB::select($sql);
foreach ($data as $data) {
	$encuesta=$data->encuesta;
	$siguiente_encuesta=$encuesta+1;
}

?>

<div id="set_preguntas">
	<?php
	if ($cedula>0 && $entro==1) {
	$sql = "select * from observador where ";
	$sql .= "cedula='$cedula'";

	$data = DB::select($sql);
	foreach ($data as $data) {
		$observador = $data->nombres." ".$data->apellidos;
		$id_observador = $data->id_observador;
	}
	echo "<script>document.forms[0].id_observador.value=".$id_observador."</script>";
	if ($id_observador) {
	?>

	<br /><br />
	<?php
	$sql = "select p.* ";
	$sql .= "from pregunta p, encuesta e ";
	$sql .= "where p.id_encuesta=e.id_encuesta ";
	$sql .= "and e.id_encuesta=$numero ";
	$sql .= "order by id_pregunta";
	//echo $sql;
	$data = DB::select($sql);
	$i=1;
	$h=1;

	$sql = "select eo.id_pregunta, eo.respuesta ";
	if ($recuperacion==0)
		$sql .= ", eo.fecha, eo.hora ";
	else
		$sql .= ", eo.fecha_ingreso, eo.hora_ingreso as hora ";
	$sql .= "from observador o, pregunta p, encuesta e, asignacion a ";
	if ($recuperacion>0)
		$sql .= ", recuperacion eo ";
	else
		$sql .= ", encuesta_observador eo ";
	$sql .= "where o.id_observador=eo.id_observador and ";
	$sql .= "eo.id_observador=a.id_observador and ";
	$sql .= "o.cedula='".$cedula."' ";
	//$sql .= " and o.nac='".$nac."' ";
	$sql .= " and eo.id_eleccion=".SessionusuarioControllers::show("id_eleccion");
	$sql .= " and a.id_eleccion=".SessionusuarioControllers::show("id_eleccion");

	if ($recuperacion==0) {
		$sql .= " and eo.id_centro=a.id_centro";
		$sql .= " and eo.mesa=a.nro_mesa";
	}

	$sql .= " and p.id_encuesta=e.id_encuesta";
	$sql .= " and e.id_encuesta=$numero and p.id_pregunta=eo.id_pregunta";
	$sql .= " and eo.id_observador=a.id_observador";
	if ($recuperacion==0) {
		$sql .= " and eo.cod_mesa=a.nro_mesa";
		$sql .= " and eo.id_centro=a.id_centro and a.id_asignacion=$id_asignacion";
	}
	//echo $sql;
	$respuestas=array();

	$data2 = DB::select($sql);
	$hora="";
	foreach ($data2 as $data2) {
		$respuestas[$data2->id_pregunta]=$data2->respuesta;
		$hora=$data2->hora;
	}

	$procesada=0;
	foreach ($data as $data) {
	if ($h==2) $h=1;
	else $h=2;
	if ($i==1) {
	?>
	<br />
	<div align="center" width="900">
		Observador: <span class='titulo_interno'><?php echo $observador." - ".number_format($cedula,"0",",","."); ?>
			<br />
		<?php
		$sql = "select codigo, id_observador, cedula from observador where cedula='$cedula'";
		$data_observ = DB::select($sql);
		foreach($data_observ as $data_observ) {
			$codigo=$data_observ->codigo;
			$id_observador=$data_observ->id_observador;
		}
		$codigo=FuncionesControllers::buscar_asignacion_observador($id_asignacion, $codigo, $id_observador, 1, 0);
		echo $codigo;
		?>
	</div>
	<?php if ($recuperacion==0 && $hora!="") { ?>
	<span style="background:yellow;">
						<strong>(Planilla procesada en fecha y hora: <?php echo $hora; ?>)</strong></span>
	<?php
	$procesada=1;
	}
	?>
	</span>
	<table width="900" border="0" cellspacing="0" cellpadding="5" align="center">
		<?php
		}
		?>
		<tr class="fondo<?php echo $h; ?>" valign="top" onmouseover="this.className='sobre_fila'" onmouseout="this.className='fondo<?php echo $h; ?>'">
			<?php
			if ($numero!=3 && $numero!=4) { ?>
			<td><strong><?php echo $i; ?>) </strong></td>
			<td width="10%" align="center">
				<?php if ($data->tipo=="s") { ?>
				<label><strong>(No)</strong><input class="chk" type="checkbox" name="preg_<?php echo $data->id_pregunta; ?>" <?php  if (!empty($respuestas)) { if ($respuestas[$data->id_pregunta]==0) echo "checked"; } ?>  value="0" /></label>
				<?php } elseif ($data->tipo=="a") { ?>
				<input class="input_peq" onkeypress="return numeros(event)" type="text" name="preg_<?php echo $data->id_pregunta; ?>" value="<?php if (!empty($respuestas)) { if ($respuestas[$data->id_pregunta]!="") echo $respuestas[$data->id_pregunta]; else echo "0";} ?>" />
				<?php } ?>
			</td>
			<td>
				<?php echo $data->pregunta; ?>
			</td>
			<?php $i++;
			} elseif ($numero==3) {
			//echo "<br>encuesta=$numero....pregunta=".$data->pregunta"];
			if (strpos($data->pregunta,"Ya se hizo el soporte para la") === false && strpos($data->pregunta,"Su mesa fue seleccionada para la") === false) {

			?>
			<td><strong><?php echo $i; ?>) </strong></td>
			<td width="10%" align="center">
			<?php if ($data->tipo=="s") {
			?>
			<label><strong>(No)</strong><input class="chk" type="checkbox" name="preg_<?php echo $data->id_pregunta; ?>" <?php  if (!empty($respuestas)) {if ($respuestas[$data->id_pregunta]==0 || !$respuestas[$data->id_pregunta]) echo "checked"; } ?>  value="0" /></label>
			<?php } elseif ($data->tipo=="a") { ?>
			<input class="input_peq" onkeypress="return numeros(event)" type="text" name="preg_<?php echo $data->id_pregunta; ?>" value="<?php if (!empty($respuestas)) { if ($respuestas[$data->id_pregunta]!="") echo $respuestas[$data->id_pregunta]; else echo "0"; } ?>" />
			<?php } ?>
			</td>
			<td>
				<?php
				if (strpos($data->pregunta,"Ya se hizo el soporte para la") === false && strpos($data->pregunta,"Su mesa fue seleccionada para la") === false)
					echo $data->pregunta;
				?>
			</td>
			<?php
			$i++;
			}
			} elseif ($numero==4) {
			if (strpos($data->pregunta,"Indique de d�nde obtuvo la informaci") === false && strpos($data->pregunta,"Estuve presente") === false && strpos($data->pregunta,"De un testigo") === false && strpos($data->pregunta,"De un miembro de mesa") === false && strpos($data->pregunta,"De una persona del p�blico presente") === false) {
			//echo "<br>encuesta=$numero....pregunta=".$data->pregunta;
			?>
			<td><strong><?php echo $i; ?>) </strong></td>
			<td width="10%" align="center">
				<?php if ($data->tipo=="s") {
				?>
				<label><strong>(No)</strong><input class="chk" type="checkbox" name="preg_<?php echo $data->id_pregunta; ?>" <?php  if (empty($respuestas)!=1) {if ($respuestas[$data->id_pregunta]==0 || !$respuestas[$data->id_pregunta]) echo "checked"; } ?>  value="0" /></label>
				<?php } elseif ($data->tipo=="a") { ?>
				<input class="input_peq" onkeypress="return numeros(event)" type="text" name="preg_<?php echo $data->id_pregunta; ?>" value="<?php if ($respuestas[$data->id_pregunta]!="") echo $respuestas[$data->id_pregunta]; else echo "0"; ?>" />
				<?php } ?>
			</td>
			<td>
				<?php
				if (strpos($data->pregunta,"Indique de d�nde obtuvo la informaci") === false && strpos($data->pregunta,"Estuve presente") === false && strpos($data->pregunta,"De un testigo") === false && strpos($data->pregunta,"De un miembro de mesa") === false && strpos($data->pregunta,"De una persona del p�blico presente") === false)
					echo $data->pregunta;
				?>
			</td>
			<?php
			$i++;
			}
			}
			?>
		</tr>
		<?php
		}
		if ($h==2) $h=1;
		else $h=2;
		?>

		<input type="hidden" name="observaciones" value="" />
	</table>

	<br /><br />
	<?php if ($numero>2 && $numero!=4) { ?>
	<?php
	$sql = "SELECT e.nombre AS estado, e.id_estado as id_estado ";
	$sql .= "FROM estado e, asignacion a, centro c ";
	$sql .= "WHERE c.id_centro = a.id_centro ";
	$sql .= "AND c.estado = e.id_estado ";
	$sql .= "AND a.id_asignacion=$id_asignacion";
	$data = DB::select($sql);
	foreach ($data as $data) {
		$nombre_estado=$data->estado;
		$id_estado_asignacion=$data->id_estado;
	}

	$sql = "select sum(v.cantidad) as cant_votos, a.nro_mesa ";
	$sql .= "from votos v, asignacion a ";
	$sql .= "where a.id_eleccion=v.id_eleccion and v.id_encuesta=$numero ";
	$sql .= "and a.id_asignacion=v.id_asignacion ";
	$sql .= "and a.id_asignacion=$id_asignacion ";
	$sql .= "and a.id_eleccion=".SessionusuarioControllers::show("id_eleccion");
	$sql .= " group by a.nro_mesa";
	$data = DB::select($sql);
	//foreach ($data as $data)
	?>
	<table width="30%" border="0" class="tablas_int" cellspacing="5" cellpadding="15" align="center">
		<tr class="fondo3">
			<td colspan="4">CANDIDATOS</td>
		</tr>
		<?php
		$sql = "select * from observador where ";
		$sql .= "cedula='$cedula'";
		$data = DB::select($sql);
		foreach ($data as $data)
			$id_observador = $data->id_observador;

		$sql = "select * from candidato where id_eleccion=".SessionusuarioControllers::show("id_eleccion");
		//$sql .= " and (partido='$nombre_estado' or partido='OTROS' or partido='NULOS') ";
		$sql .= " and id_estado=".$id_estado_asignacion;
		$sql .= " order by 1";
		$j=2;
		$data = DB::select($sql);
		foreach ($data as $data) {
		if ($j==1) $j=2;
		else $j=1;
		?>
		<tr class="fondo<?php echo $j; ?>">
			<td align="center"><?php echo $i; ?>) </td>
			<td>&nbsp;</td>
			<td><?php echo $data->nombre; ?></td>
			<td><input maxlength="5" type="text" onkeypress="return numeros(event)" class="input_peq" name="votos_<?php echo $data->id_candidato; ?>" value="<?php echo FuncionesControllers::buscar_votos($data->id_candidato, $numero, $id_observador, SessionusuarioControllers::show("id_eleccion"), $id_asignacion); ?>"></td>
		</tr>
		<?php
		$i++;
		}
		?>
	</table>
	<br />
	<?php } ?>

	<?php
	if ($numero==3) {
	echo '<table width="900" border="0" cellspacing="0" cellpadding="5" align="center">';
	$sql = "select p.* ";
	$sql .= "from pregunta p, encuesta e ";
	$sql .= "where p.id_encuesta=e.id_encuesta ";
	$sql .= "and e.id_encuesta=$numero and ";
	$sql .= "(p.pregunta like 'Ya se hizo el soporte para la%' or ";
	$sql .= "p.pregunta like 'Su mesa fue seleccionada para la%') ";
	$sql .= "order by id_pregunta";

	$data = DB::select($sql);
	foreach ($data as $data) {
	if ($h==2) $h=1;
	else $h=2;
	?>
	<tr class="fondo<?php echo $h; ?>" valign="top" onmouseover="this.className='sobre_fila'" onmouseout="this.className='fondo<?php echo $h; ?>'">
		<td><strong><?php echo $i; ?>) </strong></td>
		<td width="10%" align="center">
			<?php if ($data->tipo=="s") { ?>..sss..
			<label><strong>(No)</strong><input class="chk" type="checkbox" name="preg_<?php echo $data->id_pregunta; ?>" <?php  if (empty($respuestas)!=1) {if ($respuestas[$data->id_pregunta]==0 || !$respuestas[$data->id_pregunta]) echo "checked"; } ?>  value="0" /></label>
			<?php } elseif ($data->tipo=="a") { ?>..aa..
			<input class="input_peq" onkeypress="return numeros(event)" type="text" name="preg_<?php echo $data->id_pregunta; ?>" value="<?php if ($respuestas[$data->id_pregunta]!="") echo $respuestas[$data->id_pregunta]; else echo "0"; ?>" />
			<?php } ?>
		</td>
		<td>
			<?php echo $data->pregunta; ?>
		</td>
		<?php $i++; ?>
	</tr>
	<?php
	}
	echo '</table>';
	}
	?>

	<?php
	if ($numero==4) {
	$h=1;
	echo '<table width="900" border="0" cellspacing="0" cellpadding="5" align="center">';
	$sql = "select p.* ";
	$sql .= "from pregunta p, encuesta e ";
	$sql .= "where p.id_encuesta=e.id_encuesta ";
	$sql .= "and e.id_encuesta=$numero and ";
	$sql .= "(p.pregunta like 'Indique de d�nde obtuvo la informaci%' or ";
	$sql .= "p.pregunta like '%Estuve presente%' or ";
	$sql .= "p.pregunta like '%De un testigo%' or ";
	$sql .= "p.pregunta like '%De un miembro de mesa%' or ";
	$sql .= "p.pregunta like '%De una persona del p�blico presente%') ";
	$sql .= "order by id_pregunta";
	$data = DB::select($sql);
	foreach ($data as $data) {
	if ($h==2) $h=1;
	else $h=2;
	?>
	<tr class="fondo<?php echo $h; ?>" valign="top" onmouseover="this.className='sobre_fila'" onmouseout="this.className='fondo<?php echo $h; ?>'">
		<td>
			<?php if ($i>14) echo "&nbsp;"; else { ?>
			<strong><?php echo $i; ?>) </strong>
			<?php } ?>
		</td>
		<td width="10%" align="center">
			<?php if ($data->tipo=="s") {
			?>
			<label><strong>(No)</strong><input class="chk" type="checkbox" name="preg_<?php echo $data->id_pregunta; ?>" <?php  if (empty($respuestas)!=1) {if ($respuestas[$data->id_pregunta]==0 || !$respuestas[$data->id_pregunta]) echo "checked"; } ?>  value="0" /></label>
			<?php } elseif ($data->tipo=="a") { ?>
			<input class="input_peq" onkeypress="return numeros(event)" type="text" name="preg_<?php echo $data->id_pregunta; ?>" value="<?php if ($respuestas[$data->id_pregunta]!="") echo $respuestas[$data->id_pregunta]; else echo "0"; ?>" />
			<?php } ?>
		</td>
		<td>
			<?php echo $data->pregunta; ?>
		</td>
		<?php $i++; ?>
	</tr>
	<?php
	}
	echo '</table>';
	}
	?>

	<?php
	if ((count($respuestas)==0 || SessionusuarioControllers::show("privilegio")==1 || SessionusuarioControllers::show("privilegio")==2 || SessionusuarioControllers::show("privilegio")==4) && FuncionesControllers::planilla_procesada($id_asignacion,$numero)==false) { ?>
	<div align="center">
		<input class="btn btn-primary" type="button" name="Procesar" value="Planilla Llena" onclick="procesar_preguntas(this.form)" />
	</div>
	<br />
</div>
<?php
$sql = "select eo.id_observador ";
$sql .= "from encuesta_observador eo, observador o, asignacion a ";
$sql .= "where o.cedula='$cedula' and o.id_observador=eo.id_observador ";
$sql .= "and eo.id_eleccion=".SessionusuarioControllers::show("id_eleccion");
$sql .= " and eo.id_centro=a.id_centro and a.id_observador=o.id_observador";
//$sql .=	" and eo.cod_mesa=$mesa";
//echo $sql;
$data = DB::select($sql);
foreach ($data as $data)
	$id_observador=$data->id_observador;

//if (!$id_observador) {
?>
<div align="center">
	<input class="btn btn-primary" type="button" id="repositorio1" name="Repositorio1" value="Pasar a Recuperacion <?php echo $recuperacion+1; ?>" onclick="repositorio(this.form, <?php echo $recuperacion+1; ?>)" />
	<br />
	(Se abrira un cuadro de dialogo)
	<br />
	<div id="razon_recuperacion" class="tablas_int" style="visibility:<?php if ($recuperacion>0) echo "visible"; else echo "hidden"; ?>">
		<br />
		<?php

		if ($recuperacion>0) {
			$sql = "select distinct(nro_recuperacion), ";
			$sql .= "falla, observ_rec1, observ_rec2, observ_rec3, hora_ingreso ";
			$sql .= "from recuperacion where id_observador=$id_observador ";
			//$sql .= "and nro_recuperacion=$recuperacion ";
			$sql .= " and id_eleccion=".SessionusuarioControllers::show("id_eleccion");
			$sql .= " group by observ_rec1, observ_rec2, observ_rec3 order by 1";
			$data = DB::select($sql);
			$falla="";
			$observaciones="";
			foreach ($data as $data) {
				$falla[] = $data->falla;
				if ($data->observ_rec1!="") $observaciones[1]=$data->observ_rec1;
				if ($data->observ_rec2!="") $observaciones[2]=$data->observ_rec2;
				if ($data->observ_rec3!="") $observaciones[3]=$data->observ_rec3;
			}

			$sql = "select distinct(nro_recuperacion) as nro_rec, hora_ingreso from recuperacion where id_observador=$id_observador ";
			$sql .= "and id_eleccion=".SessionusuarioControllers::show("id_eleccion");
			$i=1;
			$data = DB::select($sql);
			$hora="";
			foreach ($data as $data) {
				$hora[$i]=substr($data->hora_ingreso,strpos($data->hora_ingreso," ")+1,strlen($data->hora_ingreso));
				$i++;
			}
		} else {
			$falla = "";
			$observaciones="";
		}
		?>

		<div class="form-group">
			<label class="control-label col-xs-3">Falla:</label>
			<div class="col-xs-3">
				<select class="form-control" name="falla" onchange="otra_falla(this.value)">
					<option value="0">Seleccione falla...</option>
					<option value="-1">Otra falla...</option>
					<?php
					$sql = "select * from fallas order by nombre";
					$data = DB::select($sql);
					foreach ($data as $data) {
					?>
					<option value="<?php echo $data->id_fallas; ?>" <?php if ($data->id_fallas==$falla) echo "selected"; ?>><?php echo $data->nombre; ?></option>
					<?php
					}
					if (SessionusuarioControllers::show("privilegio")==4) {
						?>
			<?php } ?>
				</select>
			</div>
		</div>

		<br /><br />
		<div id="label_otra_falla" style="visibility: hidden">
			<div class="form-group">
				<label class="control-label col-xs-3">Ingrese la descripcion de la Falla:</label>
				<div class="col-xs-9">
					<input name="otra_falla_texto" id="otra_falla_texto" type="text" class="form-control" placeholder="Otra Falla" value="">
				</div>
			</div>
		</div>
		<br />
		<?php
		if ($recuperacion==0)
			$rec=1;
		else
			$rec=$recuperacion+1;

		for ($i=1; $i<$rec+1; $i++) {
		?>
		<div class="resaltador"">Recuperacion Nro. <?php echo $i; ?></div><br /><br />
	<?php if ($recuperacion+1>$i) { ?>
	<br /><br /><strong>Hora:<span class='resaltador'><?php echo $hora[$i]; ?></span> / Operador: <span class='resaltador'><?php echo FuncionesControllers::buscar_operador_recup($id_asignacion); ?></span></strong>
	<?php } ?>
	<div class="form-group">
		<label class="control-label col-xs-3">Observacion del operador:</label>
		<div class="col-xs-9">
			<textarea name="observ_rec<?php echo $i; ?>" class="form-control" placeholder="Falla">
				<?php if ($observaciones!="") { if ($i<count($observaciones)+1) echo $observaciones[$i]; } else echo ""; ?>
			</textarea>
		</div>
	</div>

	<br /><br />
	<?php
	}
	?>
	<br /><br /><br />
	<div align="center">
		<input class="btn btn-primary" type="button" id="repositorio2" name="Repositorio2" value="Enviar a Recuperacion <?php echo $recuperacion+1; ?>" onclick="guardar_repositorio(this.form, <?php echo $recuperacion+1; ?>)" />
	</div>
	<br /><br />
</div>
</div>
<?php
//}
?>
<?php } else { ?>
<span style="background:yellow;"><strong>(Planilla procesada, Ya no puede ser modificada)</strong></span>
<?php
	if (SessionusuarioControllers::show("privilegio")==1) { ?>
		<input type='button' class='btn btn-primary' id='Revertir' name='Revertir' value='Revertir Planilla' onclick='revertir_planilla(<?php echo $id_asignacion.", ".$id_observador.", ".$numero; ?>, this.form)'>
<?php } ?>
<?php
}
} else {
	echo "<br /><br /><div align='center' class='error'>La c�dula introducida no es correcta</div><br>";
}
} elseif ($cantidad_asignaciones==0 && $cedula!="") {
	echo "<br /><br /><div align='center' class='error'>Este observador no tiene asignaciones para estas elecciones</div><br>";
}
}
}

?>
<!--script>
	buscar_codigo(<?php echo $cedula; ?>, <?php echo SessionusuarioControllers::show("id_eleccion"); ?>);
</script-->

{!! Form::close() !!}
@include('layaout.footer_admin')