<script>nro_prueba=2; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1; var cantidad=0;</script>

<?php	
/// Inicio de variables requeridas de valores 

	$nro_pregunta = 0;

///Muestra mensajes de error y envia al usuario al zipote
	function error_eval($err){
		/*switch($err){
			case "Cancelada":
				echo "<script languaje=javascript> alert('Lo sentimos, esta evaluación fue ¡Cancelada ! comuniquese con el administrador para mas detalles del caso.');</script>";
				break;
			case "Inactiva":
				echo "<script languaje=javascript> alert('ATENCION: Esta evaluación está ¡Inactiva! debido al numero de intentos, comuniquese con el administrador para mas detalles del caso. ');</script>";
				break;
			case "Expirada":
				echo "<script languaje=javascript> alert('Lo sentimos, esta evaluación expiró en su tiempo de vigencia, comuniquese con el administrador para mas detalles del caso. ');</script>";
				break;	
			case "En_Revision":
				echo "<script languaje=javascript> alert('Lo sentimos, esta evaluación esta ¡En Revision!. ');</script>";
				break;
			case "Finalizada":
				echo "<script languaje=javascript> alert('Lo sentimos, esta evaluación ya fue ¡Finalizada!. ');</script>";
				break;					
		}*/
		//echo ("<H4><CENTER> Lo sentimos, ha ocurrido un error de evaluación: <b>¡" . $err . "! </b><br>No se podrá continuar con la evaluación. <br>Gracias por intentarlo... <br>¡Hasta Luego!</CENTER></H4>");
	}

///Trae los datos del registro de la Evaluacion acorde al cod_evaluacion
	$sql_evaluacion = "SELECT * FROM tb_evaluaciones WHERE cod_evaluacion = '$cod_evaluacion'";
	//echo $sql_evaluacion; return;
	$data = DB::select($sql_evaluacion);
	foreach ($data as $data) {
		$id_evaluado = $data->id_evaluado;		
		$nombres_evaluado = $data->nombres_evaluado;
		$apellidos_evaluado = $data->apellidos_evaluado;
		$email_evaluado = $data->email_evaluado;
		$codigo_prueba = $data->codigo_prueba;
		$status_evaluacion = $data->status_evaluacion;
		$fecha_evaluacion = date('Y-m-d');
		$vigencia_evaluacion = $data->vigencia_evaluacion;
		$hora_ini_evaluacion = date('H:i:s', time());
		$hora_fin_evaluacion = $data->hora_fin_evaluacion;
		$ingresos_evaluacion = $data->ingresos_evaluacion;
		$id_tutor = $data->id_tutor;
		$nombres_tutor = $data->nombres_tutor;
		$apellidos_tutor = $data->apellidos_tutor;
		$email_tutor = $data->email_tutor;
		$nombre_com_cliente = $data->nombre_com_cliente;
		$email_contacto_cliente = $data->email_contacto_cliente;
	}
	
///Trae valores de la prueba
	$sql_prueba = "SELECT * FROM tb_pruebas WHERE codigo_prueba = '$codigo_prueba'";
	$data = DB::select($sql_prueba);
	foreach ($data as $data) {
		$nombre_prueba = $data->nombre_prueba;
		$tipo_prueba = $data->tipo_prueba;
		$categoria_prueba = $data->categoria_prueba;
		$cant_categorias_preguntas_prueba = $data->cant_categorias_preguntas_prueba;
		$cant_preguntas_prueba = $data->cant_preguntas_prueba;
		$cant_ingresos_prueba = $data->cant_ingresos_prueba;
		$tiempo_prueba = $data->tiempo_prueba;
		$porcentaje_min_aprobacion_prueba = $data->porcentaje_min_aprobacion_prueba;
		$mostrar_instrucciones_prueba = $data->mostrar_instrucciones_prueba;
		$instrucciones_prueba = $data->instrucciones_prueba;
		$pasos_prueba = $data->pasos_prueba;
	}

	if ($pasos_prueba == 'No'){
		//mysql_close($con);
		header("Location:evaluacion.php");	
		$urlredirect = "evaluacion.php?cod_evaluacion=" . $cod_evaluacion;
		redirect($urlredirect);
	}

///Trae las preguntas de la prueba

	$sql_preguntas = "SELECT * FROM tb_preguntas WHERE codigo_prueba = '$codigo_prueba' ORDER BY numero_pregunta";	
	//echo $sql_preguntas;
	$data = DB::select($sql_preguntas);
	foreach ($data as $data) {
		$pregunta[$data->numero_pregunta]["nro"] = $data->nro;
		$pregunta[$data->numero_pregunta]["enunciado_pregunta"] = $data->enunciado_pregunta;
		$pregunta[$data->numero_pregunta]["numero_opciones"] = $data->numero_opciones;
		$pregunta[$data->numero_pregunta]["dificultad_pregunta"] = $data->dificultad_pregunta;
		$pregunta[$data->numero_pregunta]["peso_pregunta"] = $data->peso_pregunta;
		$pregunta[$data->numero_pregunta]["status_pregunta"] = $data->status_pregunta;
		$pregunta[$data->numero_pregunta]["numero_categoria"] = $data->numero_categoria;
		$pregunta[$data->numero_pregunta]["nombre_categoria"] = $data->nombre_categoria;
		$pregunta[$data->numero_pregunta]["numero_subcategoria"]= $data->numero_subcategoria;
		$pregunta[$data->numero_pregunta]["nombre_subcategoria"] = $data->nombre_subcategoria;
		$pregunta[$data->numero_pregunta]["imagen_pregunta"] = $data->imagen_pregunta;
		$pregunta[$data->numero_pregunta]["usar_opciones_generales"] = $data->usar_opciones_generales;	
	}
/*
	echo "<pre>";
	print_r ($pregunta);
	echo "</pre>";	
	echo "cant=".count($pregunta);	
	return;
*/
///Trae las opciones de las preguntas
	$sql_opciones = "SELECT * FROM tb_opciones WHERE codigo_prueba = '$codigo_prueba' ORDER BY numero_pregunta";
	$data = DB::select($sql_opciones);
	foreach ($data as $data) {
		$opcion[$data->numero_pregunta][$data->numero_opcion]["enunciado_opcion"] = $data->enunciado_opcion;
		$opcion[$data->numero_pregunta][$data->numero_opcion]["valor_opcion"] = $data->valor_opcion;
		$opcion[$data->numero_pregunta][$data->numero_opcion]["correcta_opcion"] = $data->correcta_opcion;
		$opcion[$data->numero_pregunta][$data->numero_opcion]["imagen_opcion"] = $data->imagen_opcion;
	}

///-------------------------Finaliza Prueba, Comparacion y Resultados-------------------------------------------
///	Inicia proceso decomparacion y registro si el boton Finalizar es presionado
		
	if ( isset($_REQUEST['Finalizar']) || isset($_REQUEST['Siguiente']) || isset($_REQUEST['Anterior']) ){

		//	Registra las respuestas en la tabla respuestas evaluado	
		$nro_pregunta = ($_REQUEST["nro_pregunta"]);
		$respuesta_opcion_evaluado = ($_REQUEST["respuesta_evaluado"]);
		$valor_opcion_pregunta = $opcion[$nro_pregunta][$respuesta_opcion_evaluado]["valor_opcion"];
		$numero_categoria_pregunta = $pregunta[$nro_pregunta]["numero_categoria"];
		$nombre_categoria_pregunta = $pregunta[$nro_pregunta]["nombre_categoria"];
		$numero_subcategoria_pregunta = $pregunta[$nro_pregunta]["numero_subcategoria"];
		$nombre_subcategoria_pregunta = $pregunta[$nro_pregunta]["nombre_subcategoria"]; 
		$respuesta_correcta = $opcion[$nro_pregunta][$respuesta_opcion_evaluado]["correcta_opcion"];
		$peso_pregunta = $pregunta[$nro_pregunta]["peso_pregunta"];

		$sql_respuestas_evaluados = "SELECT * FROM tb_respuestas_evaluados WHERE cod_evaluacion = '$cod_evaluacion' AND numero_pregunta = '$nro_pregunta'";
		$respuestas_evaluados = DB::select($sql_respuestas_evaluados);			

		if (count($respuestas_evaluados) == 0 || count($respuestas_evaluados) == NULL) {
    		$sql_respuestas_evaluados = "INSERT INTO tb_respuestas_evaluados(cod_evaluacion, 
						codigo_prueba, numero_pregunta, peso_pregunta, opcion_respondida, 
						valor_opcion, numero_categoria_pregunta, nombre_categoria_pregunta, 
						numero_subcategoria_pregunta, nombre_subcategoria_pregunta, 
						respuesta_correcta) 
					VALUES('$cod_evaluacion', '$codigo_prueba', '$nro_pregunta', 
						'$peso_pregunta', '$respuesta_opcion_evaluado', '$valor_opcion_pregunta', 
						'$numero_categoria_pregunta', '$nombre_categoria_pregunta', 
						'$numero_subcategoria_pregunta', '$nombre_subcategoria_pregunta',
						'$respuesta_correcta')";
						
			DB::insert($sql_respuestas_evaluados);
		}
		else {
			$sql_respuestas_evaluados = "UPDATE tb_respuestas_evaluados SET opcion_respondida = '$respuesta_opcion_evaluado', valor_opcion = '$valor_opcion_pregunta', respuesta_correcta = '$respuesta_correcta' WHERE cod_evaluacion = '$cod_evaluacion' AND numero_pregunta = '$nro_pregunta'";	
			DB::update($sql_respuestas_evaluados);
		}
	
		if ( isset($_REQUEST['Siguiente']) ){
			$nro_pregunta++;
		}

		if ( isset($_REQUEST['Anterior']) ) {
			$nro_pregunta--;
		}

		if ( isset($_REQUEST['Finalizar']) ) {
			//	Registra hora de finalizacion
			$hora_fin_evaluacion = date('H:i:s', time());	
			
			// Actualiza registro de la evaluacion	
			$sql_finaleval = "UPDATE tb_evaluaciones SET status_evaluacion = 'En_Revision', hora_fin_evaluacion = '$hora_fin_evaluacion', puntaje_bruto_evaluacion = '$puntaje_bruto_evaluacion' WHERE cod_evaluacion = '$cod_evaluacion'";
			DB::update($sql_finaleval);
			
			/// Se cierra conexion con BD y va a fin	
			//mysql_close($con);
			header("Location:evaluacion.php?cod_evaluacion");	
			$urlredirect = "evaluacion_cierre.php?cod_evaluacion=" . $cod_evaluacion;
			redirect($urlredirect);
		}
	}
	
///-----------------------------------------------------------------------------------------------------///
	
/// -------- Verifica el numero de ingresos a la evaluacion y actualiza el registro de la evaluacion---------------
	//echo "$ingresos_evaluacion...$cant_ingresos_prueba...$status_evaluacion...$nro_pregunta"; return;
	/*if ($ingresos_evaluacion <= $cant_ingresos_prueba) {
		if ($status_evaluacion == "Activa" || $status_evaluacion == "En_Curso"){					
			if($vigencia_evaluacion >= $fecha_evaluacion){
				///Incrementa el valor del ingreso
				if ($nro_pregunta == 0) {
					$ingresos_evaluacion++;
				}	
				if ($status_evaluacion == "Activa"){
					$sql_evaluacion = "UPDATE tb_evaluaciones SET status_evaluacion = 'En_Curso', fecha_evaluacion = '$fecha_evaluacion', hora_ini_evaluacion = '$hora_ini_evaluacion', ingresos_evaluacion = '$ingresos_evaluacion' WHERE cod_evaluacion = '$cod_evaluacion'"; 	
					DB::update($sql_evaluacion);
				} else {
					$sql_evaluacion = "UPDATE tb_evaluaciones SET status_evaluacion = 'En_Curso', ingresos_evaluacion = '$ingresos_evaluacion' WHERE cod_evaluacion = '$cod_evaluacion'"; 	
					DB::update($sql_evaluacion);
				}
			} else {
				//este....
				$sql_evaluacion = "UPDATE tb_evaluaciones SET status_evaluacion = 'Expirada', ingresos_evaluacion = '$ingresos_evaluacion' WHERE cod_evaluacion = '$cod_evaluacion'"; 				
				//DB::update($sql_evaluacion);
				//error_eval("Expirada");
				////mysql_close($con);
				//goto fin;
			}			
		} else {
				if ($status_evaluacion == "Finalizada"){
					error_eval("Finalizada");
					//mysql_close($con);
					goto fin;
				}
				if ($status_evaluacion == "Inactiva"){
					error_eval("Inactiva");
					//mysql_close($con);
					goto fin;
				}
				if ($status_evaluacion == "Cancelada"){
					error_eval("Cancelada");
					//mysql_close($con);
					goto fin;
				}
				if ($status_evaluacion == "Expirada"){
					error_eval("Expirada");
					//mysql_close($con);
					//goto fin;
				}
				if ($status_evaluacion == "En_Revision"){
					error_eval("En_Revision");
					//mysql_close($con);
					goto fin;
				}				
		}
	} else {
		echo "<br>222)NROOO:".$nro_pregunta . ")  "; return;
		$sql_evaluacion = "UPDATE tb_evaluaciones SET status_evaluacion = 'Inactiva', ingresos_evaluacion = '$ingresos_evaluacion' WHERE cod_evaluacion = '$cod_evaluacion'"; 
		DB::update($sql_evaluacion);
		error_eval("Inactiva");
		////mysql_close($con);
		goto fin;
	}*/
	
///---------------------------------------------------------------------------------------------------

	$opcion_respondida = -1;

///-------------------------------------------- EVALUACION -------------------------------------------

	/// Instrucciones y retorno de valores respondidos
	if ( $nro_pregunta == 0 ){
		/*if( $mostrar_instrucciones_prueba == 'Si' ){
			echo "<div id='popup' class='popup panel panel-primary'>";
			echo "<br><br><br><center><img src='custom/instrucciones/$instrucciones_prueba' alt='popup'></center><br>";
			echo "<div class='panel-footer'><center><button id='close' class='botones' style='width:280px;'> Entiendo y Acepto las Indicaciones </button></center></div></div>";
		}*/
		$nro_pregunta = 1;

		/// Comienza Impresion de Datos
		/*echo "<table>";
		echo "<tr><td>Nombres del Evaluado: </td><td><b>" . $nombres_evaluado . "</b></td></tr>";
		echo "<tr><td>Apellidos del Evaluado: </td><td><b>" . $apellidos_evaluado . "</b></td></tr>";
		echo "<tr><td>ID del Evaluado: </td><td><b>" . $id_evaluado . "</b></td></tr>";
		echo "<tr><td>Nombres del Tutor: </td><td><b>" . $nombres_tutor . "</b></td></tr>";
		echo "<tr><td>Apellidos del Tutor: </td><td><b>" . $apellidos_tutor . "</b></td></tr>";
		echo "<tr><td>Nombre del Cliente: </td><td><b>" . $nombre_com_cliente . "</b></td></tr>";
		echo "<tr><td>Fecha de Evaluación: </td><td><b>" . $fecha_evaluacion . "</b></td></tr>";
		echo "<tr><td>Hora Inicio Evaluación: </td><td><b>" . $hora_ini_evaluacion . "</b></td></tr>";
		echo "<tr><td>Tiempo para Evaluación: </td><td><b>" . $tiempo_prueba . " minutos" . "</b></td></tr>";
		echo "<tr><td>Hora Fin de Evaluación: </td><td><b>" . $hora_fin_evaluacion . "</b></td></tr>";
		echo "</table><HR>";	*/

		if ($pasos_prueba == 'Ambas'){
			echo "<FORM action = 'evaluacion.php?cod_evaluacion=$cod_evaluacion' name = 'Corrida' method = 'POST'>&emsp;&emsp;&emsp;<input type = 'submit' class='botones' style = 'width:300px;' name='Corrida' value = '¿ Desea ver todas las preguntas de una vez ?'></FORM><br>"; 
		}
	} else {
		$sql_respuestas_evaluados = "SELECT * FROM tb_respuestas_evaluados WHERE cod_evaluacion = '$cod_evaluacion' AND numero_pregunta = '$nro_pregunta'";
		$data = DB::select($sql_respuestas_evaluados);
		foreach ($data as $data) {
			$opcion_respondida = $data->opcion_respondida;
			//echo "<script languaje=javascript> alert('$opcion_respondida');</script>";
		}
	}




	/// Imprime boton de cambio a paso a paso
	$opcion_invalida = "Debe seleccionar una de las opciones para continuar!";
	/*
	echo "<pre>";
	print_r ($opcion);
	echo "</pre>";
	return;
	*/
	/// Imprime Prueba (preguntas opciones y botón Finalizar)
	
	/*
	[enunciado_pregunta] => Tengo dificultad para identificar la importancia de muchos asuntos.
	[numero_opciones] => 3
	[dificultad_pregunta] => N/A
	[peso_pregunta] => 1
	[status_pregunta] => Activa
	[numero_categoria] => 1
	[nombre_categoria] => Gestión de la Realidad
	[numero_subcategoria] => 1
	[nombre_subcategoria] => Manejo de la Información
	[imagen_pregunta] => 
	[usar_opciones_generales] => No	
	*/
	
	echo "<CENTER><TABLE style='font-size:18px;' align = 'center' width = '60%'>";
		echo "<FORM action='' name='$codigo_prueba' method='POST' >";
			echo "<input type='hidden' name='cod_evaluacion' value='".$cod_evaluacion."'>";
			echo "<tr><td>";
				echo "<br>"; //$nro_pregunta . ")  " 
				/*******************************/
				for ($nro_pregunta=1; $nro_pregunta<count($pregunta); $nro_pregunta++) {
					if ($nro_pregunta==1) $display="inline"; else $display="none";
					
					echo '<div id="prueba'.$nro_pregunta.'" style="display: '.$display.';">';
					echo "&emsp;<span class = 'pregunta'>$nro_pregunta.) " . $pregunta[$nro_pregunta]["enunciado_pregunta"] . "</span><br>";
					
					echo "<br><div width='70%' style='text-align:right;padding-right:50;' align='center'>";
					
						for ( $nro_opcion = 1 ; $nro_opcion <= $pregunta[$nro_pregunta]["numero_opciones"] ; $nro_opcion++ ) {
							//*****************esta*********************
							/*if ($nro_opcion==1)
								$checked="checked";
							else*/
								$checked="";
							
							echo $opcion[$nro_pregunta][$nro_opcion]["enunciado_opcion"] . "  <input $checked class='prueba2' type = 'radio' name = 'respuesta_evaluado_$nro_pregunta' id = 'respuesta_evaluado_$nro_pregunta' value = '$nro_opcion' /><br>";
						}
					echo "</div><br><hr>";	
					echo "</div>
						<script>
							respuesta_actual_co[".$nro_pregunta."]=".$pregunta[$nro_pregunta]["nro"].";
						</script>";	
				}
			/*******************************/
			echo "</td></tr>";	
		echo "</FORM>";	
	echo "</TABLE></CENTER><br>";
	//echo "<center><progress value='$nro_pregunta' max='$cant_preguntas_prueba'></progress></center>";
	///-----------------------------------------------------------------------	

	fin:
	?>