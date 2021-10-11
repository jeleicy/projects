function asignaVariables()
{
	// Funcion que asigna variables que se usan a lo largo de las funciones	
	v=1; nuevaBusqueda=1; busqueda=null; ultimaBusquedaNula=null;
	divLista=document.getElementById("lista");
	inputLista=document.getElementById("input_2");
	elementoSeleccionado=0;
	ultimoIdentificador=0;
}

function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objet AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!="undefined") { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}

function eliminaEspacios(cadena)
{
	var x=0, y=cadena.length-1;
	while(cadena.charAt(x)==" ") x++;	
	while(cadena.charAt(y)==" ") y--;	
	return cadena.substr(x, y-x+1);
}

function administrador(id_observador) {
	/* Funcion encargada del input de la izquierda. No interfiere para nada en la funcionalidad de
	la lista desplegable */

	var inputId=id_observador;
		
	var inputPrivilegio = document.getElementById("privilegio_"+id_observador);
	
	inputPrivilegio.innerHTML="";
	var ajax=nuevoAjax();
	ajax.open("POST", "procesos/index_proceso_administrador.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("id_observador="+inputId);
		
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			// Borro el contenido del input
			inputPrivilegio.innerHTML=ajax.responseText;
		}
	}
}

function observador(id_observador) {
	/* Funcion encargada del input de la izquierda. No interfiere para nada en la funcionalidad de
	la lista desplegable */

	var inputId=id_observador;
		
	var inputPrivilegio = document.getElementById("privilegio_"+id_observador);
	
	inputPrivilegio.innerHTML="";
	var ajax=nuevoAjax();
	ajax.open("POST", "procesos/index_proceso_observador.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("id_observador="+inputId);
		
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			// Borro el contenido del input
			inputPrivilegio.innerHTML=ajax.responseText;
		}
	}
}

function autorizar(id_observador) {
	var inputId=id_observador;
		
	var inputAutorizado = document.getElementById("autorizado_"+id_observador);
	
	inputAutorizado.innerHTML="";
	
	var parametros = {
		"id_observador" : id_observador,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   'index_proceso_autorizar',
		type:  'post',
		beforeSend: function () {
			$("#autorizado_"+id_observador).html("....Procesando, espere por favor");
		},
		success:  function (data) {
			$("#autorizado_"+id_observador).html(data.resultado);
		}
	});			
}

function bloquear(id_observador) {
	var inputId=id_observador;
		
	var inputAutorizado = document.getElementById("autorizado_"+id_observador);
	
	inputAutorizado.innerHTML="";

	var parametros = {
		"id_observador" : id_observador,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   'index_proceso_desautorizar',
		type:  'post',
		beforeSend: function () {
			$("#autorizado_"+id_observador).html("....Procesando, espere por favor");
		},
		success:  function (data) {
			$("#autorizado_"+id_observador).html(data.resultado);
		}
	});		
}

function ajax_buscar_observador (tipo) {
	var inputId=eval("document.forms[0].cedula_"+tipo+".value");
		
	var parametros = {
		"cedula" : inputId,
		"tipo" : tipo,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   'index_proceso_buscar_observador',
		type:  'post',
		beforeSend: function () {
			$("#nombre_"+tipo).html("....Procesando, espere por favor");
		},
		success:  function (data) {
			$("#nombre_"+tipo).html(data.resultado);
		}
	});		
}


function validar_buscar_pregunta() {
	/* Funcion encargada del input de la izquierda. No interfiere para nada en la funcionalidad de
	la lista desplegable */
	var f = eval("document.forms[0]");
	
	var inputEmail=f.email;
		
	var valorEmail=inputEmail.value;
		
	var inputPregunta1 = document.getElementById("pregunta1");
	var inputPregunta2 = document.getElementById("pregunta2");
	
	var inputRespuesta1 = document.getElementById("respuesta1");
	var inputRespuesta2 = document.getElementById("respuesta2");	
	
	inputPregunta1.innerHTML="";
	inputPregunta2.innerHTML="";
	
	inputRespuesta1.innerHTML="";
	inputRespuesta2.innerHTML="";	

	var ajax=nuevoAjax();
	ajax.open("POST", "procesos/index_proceso_olvidos.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("email="+valorEmail);
		
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			// Borro el contenido del input
			inputPregunta1.innerHTML="Pregunta Secreta:";
			inputPregunta2.innerHTML=ajax.responseText;
			
			inputRespuesta1.innerHTML="Respuesta Secreta:";
			inputRespuesta2.innerHTML="<input type='text' name='respsec' value=''>";			
		}
	}
}

function ajax_buscar_centros() {
	/* Funcion encargada del input de la izquierda. No interfiere para nada en la funcionalidad de
	la lista desplegable */
	var f = eval("document.forms[0]");
	
	var inputNombre=f.nombres_centro;
	var inputEstado=f.estado;
	var inputMunicipio=f.municipio;
	var inputParroquia=f.parroquia;
	var inputCodCentro=f.codigo_centro;
		
	var valorNombre=inputNombre.value;
	var valorEstado=inputEstado.value;	
	var valorMunicipio=inputMunicipio.value;
	var valorParroquia=inputParroquia.value;
	var valorCodCentro=inputCodCentro.value;
	
	var inputSalida = document.getElementById("resultado_centro");
	
	inputSalida.innerHTML="";
	
	var ajax=nuevoAjax();
	//alert("procesos/index_proceso_centros.php?nombre="+valorNombre+"&estado="+valorEstado+"&municipio="+valorMunicipio+"&parroquia="+valorParroquia+"&codigo_centro="+valorCodCentro+"&id_eleccion="+f.eleccion_actual.value);
	ajax.open("POST", "procesos/index_proceso_centros.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("nombre="+valorNombre+"&estado="+valorEstado+"&municipio="+valorMunicipio+"&parroquia="+valorParroquia+"&codigo_centro="+valorCodCentro+"&id_eleccion="+f.eleccion_actual.value);
	
		
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			// Borro el contenido del input
			inputSalida.disabled=false;
			inputSalida.innerHTML=ajax.responseText;
		}
	}
}

function ajax_buscar_observadores() {
	/* Funcion encargada del input de la izquierda. No interfiere para nada en la funcionalidad de
	la lista desplegable */
	var f = eval("document.forms[0]");
	
	var inputNac=f.nac_observador;
	var inputCedula=f.cedula_observador;
	var inputNombre=f.nombres_observador;
	var inputApellido=f.apellidos_observador;
	
	var valorNac=inputNac.value;
	var valorCedula=inputCedula.value;	
	var valorNombre=inputNombre.value;
	var valorApellido=inputApellido.value;
	
	var inputSalida = document.getElementById("resultado_observador");
	
	inputSalida.innerHTML="";
	
	var ajax=nuevoAjax();
	//alert("procesos/index_proceso_observadores.php?nombre="+valorNombre+"&apellido="+valorApellido+"&nac="+valorNac+"&cedula="+valorCedula);
	ajax.open("POST", "procesos/index_proceso_observadores.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("nombre="+valorNombre+"&apellido="+valorApellido+"&nac="+valorNac+"&cedula="+valorCedula);
		
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			// Borro el contenido del input
			inputSalida.disabled=false;
			inputSalida.innerHTML=ajax.responseText;
		}
	}
}

function ajax_buscar_elecciones() {
	/* Funcion encargada del input de la izquierda. No interfiere para nada en la funcionalidad de
	la lista desplegable */
	var f = eval("document.forms[0]");
	
	var inputNombre=f.nombres_eleccion;
	var inputTipo=f.tipo_eleccion;
	var inputFecha=f.fechas_eleccion;
		
	var valorNombre=inputNombre.value;
	var valorTipo=inputTipo.value;	
	var valorFecha=inputFecha.value;
	
	var inputSalida = document.getElementById("resultado_eleccion");
	
	inputSalida.innerHTML="";
	
	var ajax=nuevoAjax();
	
	ajax.open("POST", "procesos/index_proceso_elecciones.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("nombre="+valorNombre+"&tipo="+valorTipo+"&fecha="+valorFecha);
		
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			// Borro el contenido del input
			inputSalida.disabled=false;
			inputSalida.innerHTML=ajax.responseText;
		}
	}
}

function ver_votantes() {
	/* Funcion encargada del input de la izquierda. No interfiere para nada en la funcionalidad de
	la lista desplegable */
	var f = eval("document.forms[0]");
	
	var cod_centro=f.cod_centro;
	
	var ajax=nuevoAjax();
	//alert("procesos/index_proceso_centros_votantes.php?cod_centro="+f.cod_centro.value);
	ajax.open("POST", "procesos/index_proceso_centros_votantes.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("cod_centro="+f.cod_centro.value);
		
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//alert(ajax.responseText);
			// Borro el contenido del input
			//inputCentro.disabled=false;
			//f.nro_votantes.value=ajax.responseText;
		}
	}
}

function verMesaVot() {
	/* Funcion encargada del input de la izquierda. No interfiere para nada 
	en la funcionalidad de la lista desplegable */
	var f = eval("document.forms[0]");
	
	var centro=f.centro.value;
	var eleccion=f.eleccion.value;
	
	var ajax=nuevoAjax();
	ajax.open("POST", "procesos/index_proceso_MesaVot.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("centro="+centro+"&eleccion="+eleccion);
		
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {			
			var resultado = ajax.responseText;
			var cod_mesa = resultado.substr(0,resultado.indexOf("*"));
			resultado=resultado.substr(resultado.indexOf("*")+1);
			var nro_votantes = resultado.substr(0,resultado.indexOf("*"));
			resultado=resultado.substr(resultado.indexOf("*")+1);
			var id_universo = resultado;
			f.cod_mesa.value=cod_mesa;
			f.nro_votantes.value=nro_votantes;
			f.id_universo.value=id_universo;
		}
	}
}

function buscar_codigo(cedula, eleccion) {
	//alert(cedula);
	/* Funcion encargada del input de la izquierda. No interfiere para nada 
	en la funcionalidad de la lista desplegable */
	var f = eval("document.forms[0]");
	
	f.cedula.value=cedula;
	
	var id_asignacion;
	var estado;
	var municipio;
	var parroquia;
	var centro;
	var mesa;
	var nro_votantes;
	var recuperacion=0;
	var chequeado=0;
	var asignacion_actual=f.id_asignacion.value;
	
	if (cedula!=0 && cedula!="") {		
		var ajax=nuevoAjax();
		ajax.open("POST", "procesos/index_proceso_codigo_observador.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("cedula="+cedula+"&eleccion="+eleccion+"&recuperacion="+f.recuperacion.value);
		//alert("procesos/index_proceso_codigo_observador.php?"+"cedula="+cedula+"&eleccion="+eleccion+"&recuperacion="+f.recuperacion.value);
			
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				var resultado = ajax.responseText;
				
				//alert(resultado);
				
				if (resultado==0 || resultado==1)
					f.cantidad_asignaciones.value=0;
				else if (resultado.indexOf("*")==-1)
					f.cantidad_asignaciones.value=0;
				else
					f.cantidad_asignaciones.value=1;

				if (resultado.indexOf("*")==-1)
					var codigo=resultado;
				else {
					var codigo = resultado.substr(0,resultado.indexOf("*"));
					resultado=resultado.substr(resultado.indexOf("*")+1);
					var tabla = "<table border='0'>";
					var i=1;
					var j=1;
					//alert(resultado);
					while (resultado!=0 && resultado!=1) {
						resultado=resultado.substr(resultado.indexOf("*")+1);

						id_asignacion = resultado.substr(0,resultado.indexOf("*"));
						resultado=resultado.substr(resultado.indexOf("*")+1);					
						estado = resultado.substr(0,resultado.indexOf("*"));
						resultado=resultado.substr(resultado.indexOf("*")+1);
						municipio = resultado.substr(0,resultado.indexOf("*"));
						resultado=resultado.substr(resultado.indexOf("*")+1);
						parroquia = resultado.substr(0,resultado.indexOf("*"));
						resultado=resultado.substr(resultado.indexOf("*")+1);
						centro = resultado.substr(0,resultado.indexOf("*"));
						resultado=resultado.substr(resultado.indexOf("*")+1);
						mesa = resultado.substr(0, resultado.indexOf("*"));
						resultado=resultado.substr(resultado.indexOf("*")+1);
						nro_votantes = resultado.substr(0, resultado.indexOf("*"));
						resultado=resultado.substr(resultado.indexOf("*")+1);
						if (f.recuperacion.value==0)
							if (resultado.indexOf("*")>-1)
								recuperacion = resultado.substr(0, resultado.indexOf("*"));
							else
								recuperacion = resultado;
						else
							resultado=resultado.substr(resultado.indexOf("*")+1);
						
						resultado=resultado.substr(resultado.indexOf("*")+1);	

						tabla += "<tr class='fondo"+j+"'>";
						tabla += "<td>";
						tabla += "<label><input class='chk' type='radio' name='id_asignacion' value='"+id_asignacion+"'";
						
						if (asignacion_actual==id_asignacion && chequeado==0) {
							//alert("1)"+f.id_asignacion.value+"..."+id_asignacion+"..."+chequeado);
							tabla += " checked";
							chequeado=1;
							//alert("2)"+f.id_asignacion.value+"..."+id_asignacion+"..."+chequeado);
						}
							
						tabla += ">";
						tabla += "<strong>Asignación nro. "+i+":</strong> ";
						tabla += "Estado: <span class='error'>"+estado+"</span>. ";
						tabla += "Municipio: <span class='error'>"+municipio+"</span>. ";
						tabla += "Parroquia: <span class='error'>"+parroquia+"</span>. ";
						tabla += "Centro: <span class='error'>"+centro+"</span>. ";
						tabla += "Nro. de Mesa: <span class='error'>"+mesa+"</span>. ";
						tabla += "Nro. de Electores: <span class='error'>"+nro_votantes+"</span>";
						tabla += "</label><td>";
						tabla += "</tr>";
						i++;
						if (j==1) j=2;
						else j=1;
					}
					tabla += "</table>";

					document.getElementById('asignaciones').innerHTML = tabla;
					//alert("2)recuperacion="+recuperacion);
					if (recuperacion>0 && f.recuperacion.value==0 && recuperacion==f.numero.value) {
						//alert("Este observador esta en el area de recuperación para el centro "+centro+" y la mesa "+mesa+", por tanto deberá esperar a que algun recuperador solvente este caso");
						//document.getElementById("buscar").style.visibility='hidden';
						//document.getElementById("repositorio1").style.visibility='hidden';
						//document.getElementById("set_preguntas").style.visibility='hidden';
					} else {
						document.getElementById("buscar").style.visibility='visible';
						//document.getElementById("repositorio1").style.visibility='visible';
						document.getElementById("set_preguntas").style.visibility='visible';
						if (f.recuperacion.value==1 && f.buscar_observ==1) {
							ir_buscar(f, 2);
						}
					}				
				}	
					//f.codigo.value=codigo;
				
				/*f.estado.value=estado;
				f.id_municipio.value=municipio;
				nuevoMunicipio();
				f.id_parroquia.value=parroquia;
				nuevaParroquia();
				f.id_centro.value=centro;
				//f.mesa.value=mesa;
				f.nro_votantes.value=nro_votantes;
				nuevoCentro();*/
			}
		}
	}
}

function ver_centro_mesas_jquery(f) {

	var parroquia=0;
	var estado=0;
	var municipio=0;
	var centro=0;
	var listo=0;
	for (i=0; i<f.length; i++) {
		if (f.elements[i].name=="estado" && f.elements[i].value!=0) {
			estado=f.elements[i].value;
			listo=1;
		} else if (f.elements[i].name=="municipio" && f.elements[i].value!=0) {
			municipio=f.elements[i].value;
			listo=1;
		} else if (f.elements[i].name=="parroquia" && f.elements[i].value!=0) {
			parroquia=f.elements[i].value;
			listo=1;
		} else if (f.elements[i].name=="centro" && f.elements[i].value!=0) {
			centro=f.elements[i].value;
			listo=1;				
		} else if (listo==0) {
			if (f.elements[i].name=="id_estado")
				estado=f.id_estado.value;
			else if (f.elements[i].name=="id_municipio")
				municipio=f.id_municipio.value;
			else if (f.elements[i].name=="id_parroquia")
				parroquia=f.id_parroquia.value;
			else if (f.elements[i].name=="id_centro")
				centro=f.id_centro.value;			
		}
	}
		
	var parametros = {
		"estado" : estado,
		"municipio" : municipio,
		"parroquia" : parroquia,
		"centro" : centro,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
			data:  parametros,
			url:   'index_proceso_centro_mesas',
			type:  'post',
			beforeSend: function () {
					$("#ver_mesas").html("....Procesando, espere por favor");
			},
			success:  function (data) {
				$("#ver_mesas").html(data.resultado);
			}
	});	
}

function validar_respuesta(f) {
	var id_observador=f.id_observador.value;
	var respsec=f.respsec.value;
	
	var parametros = {
		"id_observador" : id_observador,
		"respsec" : respsec,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
			data:  parametros,
			url:   'index_proceso_respsec',
			type:  'post',
			beforeSend: function () {
					$("#textos_contrasenas").html("....Procesando, espere por favor");
			},
			success:  function (data) {
				$("#textos_contrasenas").html(data.resultado);
			}
	});
}

function ver_centro_jquery(f) {
	var parroquia=0;
	var estado=0;
	var municipio=0;
	var centro=0;
	var listo=0;
	for (i=0; i<f.length; i++) {
		if (f.elements[i].name=="estado" && f.elements[i].value!=0) {
			estado=f.elements[i].value;
			listo=1;
		} else if (f.elements[i].name=="municipio" && f.elements[i].value!=0) {
			municipio=f.elements[i].value;
			listo=1;
		} else if (f.elements[i].name=="parroquia" && f.elements[i].value!=0) {
			parroquia=f.elements[i].value;
			listo=1;
		} else if (f.elements[i].name=="centro" && f.elements[i].value!=0) {
			centro=f.elements[i].value;
			listo=1;				
		} else if (listo==0) {
			if (f.elements[i].name=="id_estado")
				estado=f.estado.value;
			else if (f.elements[i].name=="id_municipio")
				municipio=f.id_municipio.value;
			else if (f.elements[i].name=="id_parroquia")
				parroquia=f.id_parroquia.value;
			else if (f.elements[i].name=="id_centro")
				centro=f.id_centro.value;			
		}
	}
		
	var parametros = {
		"estado" : estado,
		"municipio" : municipio,
		"parroquia" : parroquia,
		"centro" : centro,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
			data:  parametros,
			url:   'index_proceso_centro',
			type:  'post',
			beforeSend: function () {
					$("#ver_centro").html("....Procesando, espere por favor");
			},
			success:  function (data) {
				$("#ver_centro").html(data.resultado);
			}
	});
}

function ver_parroquia_jquery(f) {
	var parroquia=0;
	var estado=0;
	var municipio=0;
	var listo=0;
	for (i=0; i<f.length; i++) {
		if (f.elements[i].name=="estado" && f.elements[i].value!=0) {
			estado=f.elements[i].value;
			listo=1;
		} else if (f.elements[i].name=="municipio" && f.elements[i].value!=0) {
			municipio=f.elements[i].value;
			listo=1;
		} else if (f.elements[i].name=="parroquia" && f.elements[i].value!=0) {
			parroquia=f.elements[i].value;
			listo=1;			
		} else if (listo==0) {
			if (f.elements[i].name=="id_estado")
				estado=f.id_estado.value;
			else if (f.elements[i].name=="id_municipio")
				municipio=f.id_municipio.value;
			else if (f.elements[i].name=="id_parroquia")
				parroquia=f.id_parroquia.value;
		}
	}
		
	var parametros = {
		"estado" : estado,
		"municipio" : municipio,
		"parroquia" : parroquia,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
			data:  parametros,
			url:   'index_proceso_parroquia',
			type:  'post',
			beforeSend: function () {
					$("#ver_parroquia").html("....Procesando, espere por favor");
			},
			success:  function (data) {
				$("#ver_parroquia").html(data.resultado);
			}
	});	
}

function ver_municipio_jquery(f) {
	var municipio=0;
	var variables="";
	var estado="";
	var listo=0;
	
	for (i=0; i<f.length; i++) {
		if (f.elements[i].name=="id_estado" && f.elements[i].value!=0) {
			estado=f.elements[i].value;
			listo=1;
		} if (f.elements[i].name=="id_municipio" && f.elements[i].value!=0) {
			municipio=f.elements[i].value;
			listo=1;
		} else if (listo==0) {
			if (f.elements[i].name=="estado")
				estado=f.estado.value;
			else if (f.elements[i].name=="municipio")
				municipio=f.municipio.value;
			else if (f.elements[i].name=="parroquia")
				parroquia=f.parroquia.value;
		}
	}
	//alert(estado);
	//alert(municipio);
	
	var parametros = {
		"estado" : estado,
		"municipio" : municipio,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
			data:  parametros,
			url:   'index_proceso_municipio',
			type:  'post',
			beforeSend: function () {
					$("#ver_municipio").html("....Procesando, espere por favor");
			},
			success:  function (data) {
				$("#ver_municipio").html(data.resultado);
			}
			
	});
}

function formateaLista(valor)
{
	// Funcion encargada de ir colocando en negrita las palabras y asignarle un ID a los elementos
	var x=0, verificaExpresion=new RegExp("^("+valor+")", "i");
	
	while(divLista.childNodes[x]!=null)
	{
		// Asigo el ID para reconocerlo cuando se navega con el teclado
		divLista.childNodes[x].id=x+1;
		// Coloco en cada elemento de la lista en negrita lo que se haya ingresado en el input
		divLista.childNodes[x].innerHTML=divLista.childNodes[x].innerHTML.replace(verificaExpresion, "<b>$1</b>");
		x++;
	}
}

function limpiaPalabra(palabra)
{
	// Funcion encargada de sacarle el codigo HTML de la negrita a las palabras
	palabra=palabra.replace(/<b>/i, "");
	palabra=palabra.replace(/<\/b>/i, "");
	return palabra;
}

function coincideBusqueda(palabraEntera, primerasLetras) {
	/* Funcion para verificar que las primeras letras de busquedaActual sean iguales al
	contenido de busquedaAnterior. Se devuelve 1 si la verificacion es afirmativa */
	if(primerasLetras==null) return 0;
	var verificaExpresion=new RegExp("^("+primerasLetras+")", "i");
	if(verificaExpresion.test(palabraEntera)) return 1;
	else return 0;
}

function nuevaCadenaNula(valor)
{
	/* Seteo cual fue la ultima busqueda que no arrojo resultados siempre y cuando la cadena
	nueva no comience con las letras de la ultima cadena que no arrojo resultados */
	if(coincideBusqueda(valor, ultimaBusquedaNula)==0) ultimaBusquedaNula=valor;
}

function busquedaEnBD()
{
	/* Funcion encargada de verificar si hay que buscar el nuevo valor ingresado en la base
	de datos en funcion de los resultados obtenidos en la ultima busqueda y en base a que
	la cadena bsucada anteriormente este dentro de la nueva cadena */
	var valor=inputLista.value;
	
	if((coincideBusqueda(valor, busqueda)==1 && nuevaBusqueda==0) || coincideBusqueda(valor, ultimaBusquedaNula)==1) return 0;
	else return 1;
}

function filtraLista(valor)
{
	// Funcion encargada de modificar la lista de nombres en base a la nueva busqueda
	var x=0;

	while(divLista.childNodes[x]!=null)
	{
		// Saco la negrita a los elementos del listado
		divLista.childNodes[x].innerHTML=limpiaPalabra(divLista.childNodes[x].innerHTML);
		if(coincideBusqueda(limpiaPalabra(divLista.childNodes[x].innerHTML), valor)==0)
		{
			/* Si remuevo el elemento x, el elemento posterior pasa a ocupar la posicion de
			x, entonces quedaria sin revisar. Por eso disminuyo 1 valor a x */
			divLista.removeChild(divLista.childNodes[x]);
			x--;
		}
		x++;
	}
}

function reiniciaSeleccion()
{
	mouseFuera(); 
	elementoSeleccionado=0;
}

function navegaTeclado(evento)
{
	var teclaPresionada=(document.all) ? evento.keyCode : evento.which;
	
	switch(teclaPresionada)
	{
		case 40:
		if(elementoSeleccionado<divLista.childNodes.length)
		{
			mouseDentro(document.getElementById(parseInt(elementoSeleccionado)+1));
		}
		return 0;
		
		case 38:
		if(elementoSeleccionado>1)
		{
			mouseDentro(document.getElementById(parseInt(elementoSeleccionado)-1));
		}
		return 0;
		
		case 13:
		if(divLista.style.display=="block" && elementoSeleccionado!=0)
		{
			clickLista(document.getElementById(elementoSeleccionado))
		}
		return 0;
		
		default: return 1;
	}
}	

function rellenaLista()
{
	var valor=inputLista.value;

	// Valido con una expresion regular el contenido de lo que el usuario ingresa
	var reg=/(^[a-zA-Z0-9.@ ]{2,40}$)/;
	if(!reg.test(valor)) divLista.style.display="none";
	else
	{
		if(busquedaEnBD()==0)
		{	
			// Si no hay que buscar el valor en la BD
			busqueda=valor;
	
			// Hago el filtrado de la nueva cadena ingresada
			filtraLista(valor);
			// Si no quedan elementos para mostrar en la lista
			if(divLista.childNodes[0]==null) { divLista.style.display="none"; nuevaCadenaNula(valor); }
			else { reiniciaSeleccion(); formateaLista(valor); }
		}
		else
		{	
			/* Si se necesita verificar la base de datos, guardo el patron de busqueda con el que se
			busco y luego recibo en una variable si existen mas resultados de los que se van a mostrar */
			busqueda=valor;

			var ajax=nuevoAjax();
			ajax.open("POST", "index_proceso.php?", true);
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("busqueda="+valor);
		
			ajax.onreadystatechange=function()
			{	
				if (ajax.readyState==4)
				{
					if(!ajax.responseText) { divLista.style.display="none"; }
					else 
					{
						var respuesta=new Array(2);
						respuesta=ajax.responseText.split("&");
				
						/* Obtengo un valor que representa si tengo que ir a BD en las proximas 
						busquedas con cadena similar */
						nuevaBusqueda=respuesta[0];
				
						// Si se obtuvieron datos los muestro
						if(respuesta[1]!="vacio") 
						{ 
							divLista.style.display="block"; divLista.innerHTML=respuesta[1]; 
							// Coloco en negrita las palabras
							reiniciaSeleccion();
							formateaLista(valor); 
						}
						// En caso contrario seteo la busqueda actual como una busqueda sin resultados
						else nuevaCadenaNula(valor);
					}
				}
			}
		}
	}
}

function clickLista(elemento)

{
	/* Se ejecuta cuando se hace clic en algun elemento de la lista. Se coloca en el input el
	valor del elemento clickeado */
	v=1;
	valor=limpiaPalabra(elemento.innerHTML); 
	busqueda=valor; inputLista.value=valor;
	divLista.style.display="none"; elemento.className="normal";
}

function mouseFuera()
{
	// Des-selecciono el elemento actualmente seleccionado, si es que hay alguno
	if(elementoSeleccionado!=0 && document.getElementById(elementoSeleccionado)) document.getElementById(elementoSeleccionado).className="normal"; 
}

function mouseDentro(elemento)
{
	mouseFuera();
	elemento.className="resaltado";
	// Establezco el nuevo elemento seleccionado
	elementoSeleccionado=elemento.id;
}