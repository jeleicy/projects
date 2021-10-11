<?php
	//$valor=0;
	/*
	if ($id_observador>0) {
		$cedula=0;
		$cedula=buscar_cedula($id_observador);
	} elseif ($_SESSION["observador_reporte"]!="")
		$cedula=$_SESSION["observador_reporte"];
	*/
	if ($recuperacion>0) {
		/*$sql = "select max(nro_recuperacion) as nro_recuperacion ";
		$sql .= "from recuperacion where id_observador=$id_observador ";
		$sql .= "and id_eleccion=".SessionusuarioControllers::show("id_eleccion");
		$result = ejecutaQuery($sql);
		$data = mysql_fetch_array($result);
		if ($data->nro_recuperacion"])
			$recuperacion=$data->nro_recuperacion"];
		echo "<div align='center' class='error_recuperacion'>Este Observador se encuentra en Recuperación Nro. ".$recuperacion."</div><br>";*/	
		
		echo "<script>buscar_codigo(".$cedula.", ".SessionusuarioControllers::show("id_eleccion").")</script>";
		$sql = "update recuperacion set bloqueo=1 ";
		$sql .= "where id_observador=$id_observador and id_eleccion=$eleccion";
	}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr class="fondo1">
		<td align="right">C&eacute;dula:</td>
		<td>
			<select name="nac" class="sel_peq">
			<option value="V">V</option>
			<option value="E">E</option>
			</select>

			<input class="input_peq" value="<?php echo $cedula; ?>" onblur="buscar_codigo(this.value, <?php echo SessionusuarioControllers::show("id_eleccion"); ?>)" maxlength="8" type="text" name="cedula" onkeypress="<?php echo $valor=0; ?>; return numeros(event)" />
		</td>
	</tr>
	<!--tr class="fondo2">
		<td align="right">C&oacute;digo:</td>
		<td>
			<input class="input_peq" type="text" name="codigo" readonly value="<?php echo $codigo; ?>" />
		</td>
	</tr-->	
	<tr class="fondo1">
		<td align="right" colspan=2>
			<div id="asignaciones"></div>
		</td>
	</tr>		
</table>
<br />
<div align="center">
	<input class="btn btn-primary" type="button" id="buscar" name="Buscar" value="Buscar" onclick="ir_buscar(this.form, 1)" />
</div>

	<?php
	if ($recuperacion==0 || SessionusuarioControllers::show("privilegio")==4 || SessionusuarioControllers::show("privilegio")==1) {
		if ($cedula!="" || $id_observador>0) {
			$sql = "select max(e.id_encuesta) as encuesta ";
			$sql .= "from pregunta p, encuesta e, encuesta_observador eo, observador o ";
			$sql .= "where o.id_observador=eo.id_observador and eo.id_pregunta=p.id_pregunta and p.id_encuesta=e.id_encuesta and ";
			if ($id_observador>0)
				$sql .= "o.id_observador=$id_observador";
			else
				$sql .= "o.cedula='$cedula'";
			//echo $sql;
			$data = DB::select($sql);
			foreach ($data as $data) {
				$encuesta=$data->encuesta;
				$siguiente_encuesta=$encuesta+1;
				//echo "<br>id_observador=$id_observador...cedula=$cedula";
				//if ($numero>$siguiente_encuesta)
				//	echo "<br /><div align='center' class='error'>La encuesta que a usted le corresponde hacer es la nro. <strong>$siguiente_encuesta</strong>.</div>";
				//else {
			}
	?>

<div id="set_preguntas">
<?php
	if ($cedula>0 && $entro==1 && $cantidad_asignaciones>0) {
		$sql = "select * from observador where ";
		/*if ($id_observador>0)
			$sql .= "id_observador=$id_observador";
		else*/
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
		$data = DB::select($sql);
		$i=1;
		$h=1;
		
		$sql = "select eo.id_pregunta, eo.respuesta ";
		if ($recuperacion==0)
			$sql .= ", eo.fecha, eo.hora ";
		$sql .= "from observador o, pregunta p, encuesta e, asignacion a ";
		if ($recuperacion>0)
			$sql .= ", recuperacion eo ";
		else
			$sql .= ", encuesta_observador eo ";
		$sql .= "where o.id_observador=eo.id_observador and ";
		$sql .= "eo.id_observador=a.id_observador and ";
		$sql .= "o.cedula='".$cedula."' ";
		$sql .= " and o.nac='".$nac."' ";
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
		$respuestas="";
		
		$data2 = DB::select($sql);
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
					Observador: <span class='titulo_interno'><?php echo $observador." - ".number_format($cedula,"0",",","."); ?>
					<?php if ($recuperacion==0 && $hora!="") { ?>
						<span style="background:yellow;">
						<strong>(Planilla procesada en fecha y hora: <?php echo $hora; ?>)</strong></span>
					<?php 
						$procesada=1;
						} 
					?>
						</span>
					<table width="100%" border="0" cellspacing="0" cellpadding="5">
				<?php
			}
			?>
				<tr class="fondo<?php echo $h; ?>" valign="top" onmouseover="this.className='sobre_fila'" onmouseout="this.className='fondo<?php echo $h; ?>'">
					<?php 
					//echo "<h1>reporte=$numero</h1>";
					if ($numero!=3 && $numero!=4) { ?>
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
									<label><strong>(No)</strong><input class="chk" type="checkbox" name="preg_<?php echo $data->id_pregunta; ?>" <?php  if (empty($respuestas)!=1) {if ($respuestas[$data->id_pregunta]==0 || !$respuestas[$data->id_pregunta]) echo "checked"; } ?>  value="0" /></label>						
								<?php } elseif ($data->tipo=="a") { ?>
									<input class="input_peq" onkeypress="return numeros(event)" type="text" name="preg_<?php echo $data->id_pregunta; ?>" value="<?php if ($respuestas[$data->id_pregunta]!="") echo $respuestas[$data->id_pregunta]; else echo "0"; ?>" />
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
						if (strpos($data->pregunta,"Indique de dónde obtuvo la informaci") === false && strpos($data->pregunta,"Estuve presente") === false && strpos($data->pregunta,"De un testigo") === false && strpos($data->pregunta,"De un miembro de mesa") === false && strpos($data->pregunta,"De una persona del público presente") === false) {
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
									if (strpos($data->pregunta,"Indique de dónde obtuvo la informaci") === false && strpos($data->pregunta,"Estuve presente") === false && strpos($data->pregunta,"De un testigo") === false && strpos($data->pregunta,"De un miembro de mesa") === false && strpos($data->pregunta,"De una persona del público presente") === false)
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
		<!--tr class="fondo<?php echo $h; ?>" valign="top">
			<td colspan="3">Observaciones: <textarea name="observaciones"><?php echo $observaciones; ?></textarea></td>
		</tr-->
		<input type="hidden" name="observaciones" value="" />
		</table>
		
	<br /><br />
	<?php if ($numero>2 && $numero!=4) { ?>
	<?php
		$sql = "SELECT e.nombre AS estado ";
		$sql .= "FROM estado e, asignacion a, centro c ";
		$sql .= "WHERE c.id_centro = a.id_centro ";
		$sql .= "AND c.estado = e.id_estado ";
		$sql .= "AND a.id_asignacion=$id_asignacion";
		$data = DB::select($sql);
		foreach ($data as $data)
			$nombre_estado=$data->estado;
	
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
	<table width="70%" border="0" class="tablas_int" cellspacing="0" cellpadding="5" align="center">
		<tr class="fondo3">
			<td colspan="4">CANDIDATO</td>
		</tr>
		<?php		
			$sql = "select * from observador where ";
			$sql .= "cedula='$cedula'";
			$data = DB::select($sql);
			foreach ($data as $data)
				$id_observador = $data->id_observador;			
		
			$sql = "select * from candidato where id_eleccion=".SessionusuarioControllers::show("id_eleccion")." and (";
			$sql .= "partido='$nombre_estado' or partido='OTROS' or partido='NULOS') order by 1";
			$j=2;
			$data = DB::select($sql);
			foreach ($data as $data) {
				if ($j==1) $j=2;
				else $j=1;			
				?>
					<tr class="fondo<?php echo $j; ?>">
						<td align="center"><?php echo $i; ?></td>
						<td>&nbsp;</td>
						<td><?php echo $data->nombre; ?></td>
						<td><input maxlength="5" type="text" onkeypress="return numeros(event)" class="input_peq" name="votos_<?php echo $data->id_candidato; ?>" value="<?php echo buscar_votos($data->id_candidato, $numero, $id_observador, SessionusuarioControllers::show("id_eleccion"), $id_asignacion); ?>"></td>
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
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="5">';
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
			if ($numero==4) {
				$h=1;
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="5">';
				$sql = "select p.* ";
				$sql .= "from pregunta p, encuesta e ";
				$sql .= "where p.id_encuesta=e.id_encuesta ";
				$sql .= "and e.id_encuesta=$numero and ";
				$sql .= "(p.pregunta like 'Indique de dónde obtuvo la informaci%' or ";
				$sql .= "p.pregunta like '%Estuve presente%' or ";
				$sql .= "p.pregunta like '%De un testigo%' or ";
				$sql .= "p.pregunta like '%De un miembro de mesa%' or ";
				$sql .= "p.pregunta like '%De una persona del público presente%') ";
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
			if ((count($respuestas)==0 || SessionusuarioControllers::show("privilegio")==1 || SessionusuarioControllers::show("privilegio")==2 || SessionusuarioControllers::show("privilegio")==4) && $procesada==0) { ?>
				<div align="center">
					<input class="btn btn-primary" type="button" name="Procesar" value="Planilla Llena" onclick="procesar_preguntas(this.form)" />
				</div>
		
		<br />
</div>
<?php
	$sql = "select eo.id_observador ";
	$sql .= "from encuesta_observador eo, observador o ";
	$sql .= "where o.cedula='$cedula' and o.id_observador=eo.id_observador ";
	$sql .= "and eo.id_eleccion=".SessionusuarioControllers::show("id_eleccion");
	$sql .= " and eo.id_centro=$id_centro and eo.cod_mesa=$mesa";
	echo $sql;
	$data = DB::select($sql);
	foreach ($data as $data)
		$id_observador=$data->id_observador;
		
	if (!$id_observador) {
?>
<div align="center">
	<input class="btn btn-primary" type="button" id="repositorio1" name="Repositorio1" value="Pasar a Recup <?php echo $recuperacion+1; ?>" onclick="repositorio(this.form, <?php echo $recuperacion+1; ?>)" />
	<br />
	(Se abrira un cuadro de dialogo)
	<br />
	<div id="razon_recuperacion" class="tablas_int" style="visibility:<?php if ($recuperacion==1) echo "visible"; else echo "hidden"; ?>">
		<br />
		<?php
			if ($recuperacion>0) {
				$sql = "select max(nro_recuperacion) as nro_recuperacion, ";
				$sql .= "falla, observ_rec1, observ_rec2, observ_rec3, hora_ingreso ";
				$sql .= "from recuperacion where id_observador=$id_observador ";
				$sql .= "and nro_recuperacion=$recuperacion and id_eleccion=".SessionusuarioControllers::show("id_eleccion");
				$data = DB::select($sql);
				foreach ($data as $data) {
					$falla = $data->falla;
					$observ_rec1=$data->observ_rec1; 
					$observ_rec2=$data->observ_rec2; 
					$observ_rec3=$data->observ_rec3;
				}
				
				$sql = "select distinct(nro_recuperacion) as nro_rec, hora_ingreso from recuperacion where id_observador=$id_observador ";
				$sql .= "and id_eleccion=".SessionusuarioControllers::show("id_eleccion");
				$i=1;
				$data = DB::select($sql);
				foreach ($data as $data) {
					$hora[$i]=substr($data->hora_ingreso,strpos($data->hora_ingreso," ")+1);
					$i++;
				}				
			}
				
		?>
		<select id="falla" name="falla" onchange="otra_falla(this.value)">
			<option value="0">Seleccione falla...</option>
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
			<option value="-1">Otra falla...</option>
			<?php } ?>
		</select>
		<br /><br />
		<label id="label_otra_falla" style="visibility: hidden">Ingrese la descripcion de la Falla: <input type="text" name="otra_falla_texto" id="otra_falla_texto" value="" /></label>
		<br /><br /><br />
		<?php
			if ($recuperacion==0)
				$rec=1;
			else
				$rec=$recuperacion+1;

			for ($i=1; $i<$rec+1; $i++) {
			?>
				<?php if ($recuperacion+1>$i) { ?>
				<br /><br /><strong>Hora Recup <?php echo $i ?> (<span class='resaltador'><?php echo $hora[$i]; ?></span>) / Operador: (<span class='resaltador'><?php echo buscar_operador_recup($id_asignacion); ?></span>)</strong>
				<?php } ?>			
				<br /><span class="resaltador">(observacion es obligatoria)</span>Observacion del operador para la recup <?php echo $i; ?>: <textarea name="observ_rec<?php echo $i; ?>"><?php if ($i==1) echo $observ_rec1; elseif ($i==2) echo $observ_rec2; else echo $observ_rec3; ?></textarea>
			<?php
			}		
		?>
		<br /><br /><br />
		<input class="btn btn-primary" type="button" id="repositorio2" name="Repositorio2" value="Enviar a Recup <?php echo $recuperacion+1; ?>" onclick="guardar_repositorio(this.form, <?php echo $recuperacion+1; ?>)" />
		<br /><br />
	</div>
</div>
<?php } ?>
<?php } else { ?>
						<span style="background:yellow;">
						<strong>(Planilla procesada, Ya no puede ser modificada</strong></span>
<?php
}
	} else {
		echo "<br /><br /><div align='center' class='error'>La cédula introducida no es correcta</div><br>";
	}
} elseif ($cantidad_asignaciones==0 && $cedula!="") {
	echo "<br /><br /><div align='center' class='error'>Este observador no tiene asignaciones para estas elecciones</div><br>";
}
}
}