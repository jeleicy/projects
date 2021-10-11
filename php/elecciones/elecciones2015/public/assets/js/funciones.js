	function ir_buscar(f, buscar_observ) {
		var entra=0;
		if (f.cedula.value==0 || f.cedula.value=="")
			alert("Debe indicar el numero de cedula del observador");
		else {
			for (i=0; i<f.length; i++) {
				if (f.elements[i].name.indexOf("id_asignacion")>-1 && f.elements[i].checked==true) {
					entra=1;
					i=f.length;
				}
				
			}		
			
			if (entra==0)
				alert("Debe seleccionar una de las asignaciones");
			else {
				f.buscar_observ.value=buscar_observ;
				f.guardar_forma.value=0;
				f.submit();
			}
		}
	}
	
	function imprimir_tablero(tipo, f) {
		window.open("imprimir_tablero/"+f.nombre.value+","+f.estado.value+","+f.municipio.value+","+f.parroquia.value+","+tipo, "Listado", "location=1,status=1,scrollbars=yes, width=900,height=700");
	}
	
	function imprimir_listado(f) {
		
	}

	function validar_cambio(f) {
		if (f.contrasena1.value=="" || f.contrasena2.value=="" || f.contrasena3.value=="")
			alert("Debe colocar su contraseña anterior y la nueva !!!");
		else if (f.contrasena2.value!=f.contrasena3.value)
			alert("La contraseña nueva debe ser igual !!!");
		else {			
			f.eliminar.value=0;
			f.guardar_forma.value=1;
			f.submit();		
		}
	}

	function validar_autenticacion(f) {
		if (f.pass.value=="" || f.email.value=="")
			alert("Debe indicar su email y contraseña !!!");
		else {			
			//f.eliminar.value=0;
			//f.guardar_forma.value=1;
			//f.mod.value="log";
			f.submit();		
		}
	}
	
	function validar_video(f) {
		if (f.titulo.value=="" || f.link.value=="")
			alert("Debe los datos obligatorios !!!");
		else {			
			f.eliminar.value=0;
			f.guardar_forma.value=1;
			f.submit();		
		}
	}
	
	function validar_link(f) {
		if (f.titulo.value=="" || f.link.value=="")
			alert("Debe los datos obligatorios !!!");
		else {			
			f.eliminar.value=0;
			f.guardar_forma.value=1;
			f.submit();		
		}
	}	

	function contar(valor) {
		if (valor.value.length>500) {
			valor.value=valor.value.substr(0,500);
			return false;
		}
	}

	function ver_pantalla (nombre) {
		if (nombre=="eleccion") {
			document.getElementById("buscar_eleccion").style.visibility='visible';
			document.getElementById("buscar_eleccion").style.position="relative";
			
			document.getElementById("buscar_centro").style.visibility='hidden';
			document.getElementById("buscar_centro").style.position='absolute';
			document.getElementById("buscar_observador").style.visibility="hidden";
			document.getElementById("buscar_observador").style.position='absolute';
		} else if (nombre=="centro") {
			document.getElementById("buscar_centro").style.visibility='visible';
			document.getElementById("buscar_centro").style.position="relative";
				
			document.getElementById("buscar_eleccion").style.visibility='hidden';
			document.getElementById("buscar_eleccion").style.position='absolute';
			document.getElementById("buscar_observador").style.visibility="hidden";
			document.getElementById("buscar_observador").style.position='absolute';
		} else if (nombre=="observador") {
			document.getElementById("buscar_observador").style.visibility='visible';
			document.getElementById("buscar_observador").style.position="relative";
							
			document.getElementById("buscar_centro").style.visibility='hidden';
			document.getElementById("buscar_centro").style.position='absolute';
			document.getElementById("buscar_eleccion").style.visibility="hidden";
			document.getElementById("buscar_eleccion").style.position='absolute';
		}
	}
	/*********************************************/
	
	function gradient(id, level) {
		var box = document.getElementById(id);
		box.style.opacity = level;
		box.style.MozOpacity = level;
		box.style.KhtmlOpacity = level;
		box.style.filter = "alpha(opacity=" + level * 100 + ")";
		box.style.display="block";
		return;
	}
	
	function fadein(id) {
		var level = 0;
		while(level <= 1) {
			setTimeout( "gradient('" + id + "'," + level + ")", (level* 1000) + 10);
			level += 0.01;
		}
	}
	
	// Open the lightbox
	
	function openbox(pagina, fadin) {
	  var box = document.getElementById('buscar_'+pagina); 
	  document.getElementById('filter').style.display='block';
	  
	  if(fadin)  {
		 gradient("buscar_"+pagina, 0);
		 fadein("buscar_"+pagina);
	  } else { 	
		box.style.display='block';
	  }  	
	}
	
	// Close the lightbox
	
	function closebox(pagina) {
	   document.getElementById('buscar_'+pagina).style.display='none';
	   document.getElementById('filter').style.display='none';
	}
	
	function closebox_data(pagina) {
		var f = eval("document.forms[0].nombre_"+pagina)
		document.getElementById('nombre_'+pagina).value=f.value;
		closebox(pagina);
	}
	
	/*********************************************/
	
	function enviar_comentario(f) {
		if (f.nombre.value=="" || f.email.value=="" || f.comentario.value=="")
			alert("Debe ingresar todos los campos obligatorios !!!");
		else {
			f.guardar_forma.value=1;
			f.submit();
		}
	}

	function validarEmail(email) {
		var filter=/@./;
		var hotmail=/hotmail/;
		var cuentasInvalidas=/notiene-no.tiene-no_tiene/;
		if(!filter.test(email.value))		
			{
				alert('El campo de correo electronico debe contener una direccion de correo v'+String.fromCharCode(225)+'lida');
				email.focus();
				return false;
			}
		if(cuentasInvalidas.test(email.value))
			{
				alert('El campo de correo electronico debe contener una direccion de correo v'+String.fromCharCode(225)+'lida');
				email.focus();
				return false;
			}
		return true;	
	}
	
	function caracteres(evento) {				
		tecla=(document.all) ? evento.keyCode: evento.which;

		if(tecla==8 || tecla==0) {
			return true; 
		}				
		patron=/[A-Za-zñÑ]/; //expresion regular que valida solo los caracteres alfabeticos				
		te=String.fromCharCode(tecla);	
		te.toUpperCase();
		if(patron.test(te)==true) {
			return true; 
		} else if (tecla==32) {
			return true; 
		} else {
			alert('Caracter no valido');
			return false;
		}
	}
	
	function numeros(evento) {
		patron_numeros=/[0-9]/; //expresion regular que valida solamente el rango de numeros de 0 a 9
		if(document.all)
			{
				tecla_press=evento.keyCode;
			} else {
				tecla_press=evento.which;
			}
		if(tecla_press==8 || tecla_press==0) {
			return true;
		}
		
		numero=String.fromCharCode(tecla_press);
		
		if(patron_numeros.test(numero)==true){
			return (patron_numeros.test(numero));
		} else {
			alert('Solo se permiten numeros en este campo');
			return false;
		}
	}	
	
	function validar_observador(f) {
		if (f.cedula.value=="" || f.nombres.value=="" || f.apellidos.value=="" || f.pregsec.value=="" || f.respsec.value=="" || f.tlfcel.value=="" || f.email.value=="")
			alert("Debe introducir los campos obligatorios !!!");
		else if ((f.contrasena1.value=="" || f.contrasena2.value=="") && f.id_observador.value==0)
			alert("Debe introducir las contraseñas solicitadas !!!");
		else if (f.contrasena1.value!=f.contrasena2.value)
			alert("Las contraseñas introducidas deben ser iguales !!!");
		else {
			f.submit();
		}
	}
	
	function validar_universo(f) {
		if (f.estado.value==0 || f.municipio.value==0 || f.parroquia.value==0 || f.cod_mesa.value=="" || f.cod_centro.value=="" || f.nro_votantes.value=="") {
			alert("Debe introducir los campos obligatorios !!!");
		} else {
			f.guardar_forma.value=1;
			f.submit();
		}	
	}
	
	function validar_noiticia(f) {
		if (f.titulo.value=="" || f.texto_ext.value=="" || f.texto_int.value=="" || f.fecha.value=="" || (f.activo[0].checked==false && f.activo[1].checked==false))
			alert("Debe introducir los campos obligatorios !!!");		
		else {
			f.eliminar.value=0;
			f.guardar_forma.value=1;
			f.submit();
		}
	}	
	
	function validar_olvido(f) {
		if (f.email.value=="")
			alert("Debe introducir los campos obligatorios !!!");		
		else {
			f.eliminar.value=0;
			f.guardar_forma.value=1;
			f.submit();
		}
	}		
	
	function eliminar_observador(id_observador) {
		if (confirm("¿Está seguro de querer eliminar a este observador?")) {
			var f = eval("document.forms[0]");
			f.id_observador.value=id_observador;
			f.action="eliminar_observador";
			f.submit();
		}
	}
	
	function eliminar_noticia(id_noticia) {
		if (confirm("¿Está seguro de querer eliminar a esta noticia?")) {
			var f = eval("document.forms[0]");
			f.id_noticia.value=id_noticia;
			f.eliminar.value=1;
			f.guardar_forma.value=1;
			f.submit();
		}
	}
	
	function eliminar_video(id_video) {
		if (confirm("¿Está seguro de querer eliminar a este video?")) {
			var f = eval("document.forms[0]");
			f.id_video.value=id_video;
			f.eliminar.value=1;
			f.guardar_forma.value=1;
			f.submit();
		}
	}
	
	function eliminar_link(id_link) {
		if (confirm("¿Está seguro de querer eliminar a este link?")) {
			var f = eval("document.forms[0]");
			f.id_link.value=id_link;
			f.eliminar.value=1;
			f.guardar_forma.value=1;
			f.submit();
		}
	}	
	
	function eliminar_eleccion(id_eleccion) {
		if (confirm("¿Está seguro de querer eliminar a esta eleccion?")) {
			var f = eval("document.forms[0]");
			f.id_eleccion.value=id_eleccion;
			f.eliminar.value=1;
			f.guardar_forma.value=1;
			f.submit();
		}
	}
	
	function eliminar_candidato(id_candidato) {
		if (confirm("¿Está seguro de querer eliminar a este candidato?")) {
			var f = eval("document.forms[0]");
			f.id_candidato.value=id_candidato;
			f.action="eliminar_candidato";
			f.submit();
		}
	}	
	
	function eliminar_centro(id_centro) {
		if (confirm("¿Está seguro de querer eliminar a este centro?")) {
			var f = eval("document.forms[0]");
			f.id_centro.value=id_centro;
			f.eliminar.value=1;
			f.guardar_forma.value=1;
			f.submit();
		}
	}
	
	function eliminar_asignacion(id_asignacion) {
		if (confirm("¿Está seguro de querer eliminar esta asignacion?")) {
			var f = eval("document.forms[0]");
			f.id_asignacion.value=id_asignacion;
			f.action="eliminar_asignacion";
			f.submit();
		}
	}			
	
	function ver_observador(id_observador) {
		var f = eval("document.forms[0]");
		f.id_observador.value=id_observador;
		//alert(f.id_observador.value);
		f.action="registro_consulta/"+id_observador;
		f.submit();
	}
	
	function ver_observador_reporte(id_observador) {
		var f = eval("document.forms[0]");
		f.id_observador.value=id_observador;
		f.guardar_forma.value=0;
		f.eliminar.value=0;
		f.mod.value="reportes_planillas";
		f.submit();	
	}
	
	function ver_noticia(id_noticia) {
		var f = eval("document.forms[0]");
		f.id_noticia.value=id_noticia;
		f.guardar_forma.value=0;
		f.eliminar.value=0;
		f.submit();	
	}
	
	function ver_video(id_video) {
		var f = eval("document.forms[0]");
		f.id_video.value=id_video;
		f.guardar_forma.value=0;
		f.eliminar.value=0;
		f.submit();	
	}

	function ver_link(id_link) {
		var f = eval("document.forms[0]");
		f.id_link.value=id_link;
		f.guardar_forma.value=0;
		f.eliminar.value=0;
		f.submit();	
	}	
	
	function ver_eleccion(id_eleccion) {
		var f = eval("document.forms[0]");
		f.id_eleccion.value=id_eleccion;
		f.guardar_forma.value=1;
		f.eliminar.value=0;
		f.submit();	
	}
	
	function ver_candidato(id_candidato) {
		var f = eval("document.forms[0]");
		f.id_candidato.value=id_candidato;
		f.action="ver_candidato";
		//alert(f.action);
		f.submit();	
	}

	function validar_contrasena	(f) {
		var con1=f.contrasena1.value;
		var con2=f.contrasena2.value;
		if (con1!=con2 || con1=="" || con2=="")
			alert("Las contraseñas deben coincidir y no deben estar vacias");
		else 
			f.submit();
	}
	
	function ver_centro(id_centro) {
		var f = eval("document.forms[0]");
		f.id_centro.value=id_centro;
		f.guardar_forma.value=1;
		f.eliminar.value=0;
		f.submit();	
	}
	
	function ver_asignacion(id_asignacion, id_observador) {
		var f = eval("document.forms[0]");
		f.id_asignacion.value=id_asignacion;
		f.id_observador.value=id_observador;
		f.guardar_forma.value=1;
		f.eliminar.value=0;
		f.submit();	
	}	
	
	function validar_elecciones(f) {
		if (f.nombre.value=="" || f.tipoelec.value==0 || f.fechaelec.value=="")
			alert("Debe introducir los campos obligatorios !!!");
		else {
			f.guardar_forma.value=1;
			f.submit();
		}	
	}
	
	function validar_candidato(f) {
		if (f.nombre.value=="" || f.partido.value=="" || f.estado.value==0 || f.municipio.value==0 || f.tendencia.value=="" || f.codm.value=="")
			alert("Debe introducir los campos obligatorios !!!");
		else {
			f.submit();
		}	
	}
	
	function validar_Centro(f) {
		if (f.nombre.value=="" || f.estado.value==0 || f.municipio.value==0 || f.codigo.value=="")
			alert("Debe introducir los campos obligatorios !!!");
		else {
			f.guardar_forma.value=1;
			f.submit();
		}	
	}
	
	function buscar_elecciones(f) {		
		f.mod.value="buscar_elecciones";
		f.guardar_forma.value=0;
		f.submit();
	}
	
	function buscar_centros(f) {

		f.submit();
	}
	
	function buscar_asignaciones(f) {
		f.mod.value="buscar_asignaciones";
		f.guardar_forma.value=0;		
		f.submit();	
	}
	
	function asignar_centro(id_centro, nombre, codigo, mesas) {
		var f = eval("document.forms[0]");
		f.id_centro.value=id_centro;
		document.getElementById('nombre_centro').innerHTML="Nombre Centro: <span class='error'> "+nombre+" ("+codigo+")</span>";

		var resultado_mesas="";
		var mesa_actual;
		while (mesas.indexOf("-")>-1) {
			mesa_actual=mesas.substr(0,mesas.indexOf("-"));
			resultado_mesas+="<label><input class='chk' type='radio' name='nro_mesa' value='"+mesa_actual+"'>"+mesa_actual+"</label>";
			mesas=mesas.substr(mesas.indexOf("-")+1);
		}
		
		document.getElementById('data_mesas').innerHTML=resultado_mesas;
	 	closebox('centro');
	}
	
	function asignar_eleccion(id_eleccion, nombre, fecha) {
		var f = eval("document.forms[0]");
		f.id_eleccion.value=id_eleccion;
		document.getElementById('nombre_eleccion').innerHTML="Nombre Elección: <span class='error'> "+nombre+"</span>";
		document.getElementById('fecha_eleccion').innerHTML="Fecha Elección: <span class='error'> "+fecha+"</span>";
	 	closebox('eleccion');
	}
	
	function asignar_observador(id_observador, nombre, apellido) {
		var f = eval("document.forms[0]");
		f.id_observador.value=id_observador;
		document.getElementById('nombre_observador').innerHTML="Nombre Observador: <span class='error'> "+nombre+" "+apellido+"</span>";
	 	closebox('observador');
	}
	
	function validar_asignacion(f) {
		if (f.centro.value==0 || f.centro.value==0 || f.cedula_observador.value==0 || f.cedula_observador.value=="")
			alert("Debe ingresar todos los campos obligatorios !!!");		
		else if (f.nro_mesa.value=="")
			alert("Debe seleccionar el Nro de mesa");
		else
			f.submit();
	}
	
	function ver_otra_cat(cat_descarga) {
		if (cat_descarga.value==-1)
			document.getElementById('otra_cat').style.visibility="visible";
		else {
			document.getElementById('otra_cat').style.visibility="hidden";
			document.forms[0].otra_cat_descarga.value="";
		}
	}
	
	function validar_descarga (f) {
		if (f.nombre.value=="" || f.archivo.value=="")
			alert("Debe ingresar todos los campos obligatorios !!!");
		else if (f.cat_descarga.value==0)
			alert("Debe ingresar la catgoria de la descarga !!!");
		else if (f.cat_descarga.value==-1 && f.otra_cat_descarga.value=="")
			alert("Debe ingresar la otra catgoria de la descarga !!!");
		else {
			f.eliminar.value=0;
			f.guardar_forma.value=1;
			f.submit();
		}			
	}
	
	function eliminar_descarga(id_descarga) {
		if (confirm("¿Está seguro de querer eliminar esta descarga?")) {
			var f = eval("document.forms[0]");
			f.id_descarga.value=id_descarga;
			f.eliminar.value=1;
			f.guardar_forma.value=1;
			f.submit();
		}
	}
	
	function activar_descarga(id_descarga, activo) {
		var f = eval("document.forms[0]");
		f.id_descarga.value=id_descarga;
		f.guardar_forma.value=0;
		f.eliminar.value=1;
		f.submit();
	}
	
	function seleccionar_todo(f){
		for (i=0;i<document.forms[0].elements.length;i++)
			if(document.forms[0].elements[i].type == "checkbox")
				document.forms[0].elements[i].checked=1;
	}
	
	function deseleccionar_todo(){
	   for (i=0;i<document.forms[0].elements.length;i++)
		  if(document.forms[0].elements[i].type == "checkbox")
			 document.forms[0].elements[i].checked=0;
	}
	
	function validar_email(f) {
		if (f.cuerpo.value=="" || f.asunto.value=="")
			alert("Debe introducir el cuerpo y el asunto del mensaje !!!");
		else {
			j=0;
			for (i=0;i<document.forms[0].elements.length;i++) {
				if (document.forms[0].elements[i].type == "checkbox" && document.forms[0].elements[i].checked==true)
					j=1;
			}
			
			if (j==0)
				alert("Debe seleccionar al menos un remitente !!!");
			else {
				f.guardar_forma.value=1;
				f.submit();
			}
		}	
	}
	
	function consultar_email(f) {
		f.mod.value="consultar_correo";
		f.submit();
	}
	
	function reenviar_correo(id_correo) {
		var f = eval("document.forms[0]");
		f.id_correo.value=id_correo;
		f.guardar_forma.value=0;
		f.mod.value="correos";
		f.submit();
	}
	
	function asignaciones_lotes() {
		var f = eval("document.forms[0]");		
		f.mod.value="asignacion_lotes";
		f.guardar_forma.value=0;
		f.submit();		
	}
	
	function replicar_asignaciones(f) {
		j=0;
		for (i=0;i<document.forms[0].elements.length;i++) {
			if (document.forms[0].elements[i].type == "checkbox" && document.forms[0].elements[i].checked==true)
				j=1;
		}
		
		if (j==0)
			alert("Debe seleccionar al menos un observador a replicar !!!");
		else {
			f.mod.value="replicar";
			f.guardar_forma.value=1;
			f.submit();
		}	
	}
	
	function procesar_preguntas(f) {
		var entra=0;
		var entra2=0;
		if (confirm("¿Esta seguro de enviar el reporte # "+f.numero.value+"?. Recuerde que luego este no podra ser modificado")) {
			f.guardar_forma.value=1;
			f.submit();
		}
	}
	
	function reportes(indice) {
		var f = eval("document.forms[0]");
		var estado = f.estado.value;
		var municipio = f.municipio.value;
		var parroquia = f.parroquia.value;
		var reporte = f.reporte.value;
		/*alert(estado);
		alert(municipio);
		alert(parroquia);
		alert(reporte);*/
		/*if (estado==0)
			alert("Debe indicar el estado");
		else {*/
			//window.open("graficos_estadisticas.php?estado="+estado+"&municipio="+municipio+"&parroquia="+parroquia+"&tipo="+indice+"&reporte="+reporte, "Estadisticas", "location=1,status=1,scrollbars=yes, width=900,height=700");
			f.numero.value=indice;
			f.submit();
		//}
	}
	
	function repositorio(f, nro_recuperacion) {
		if (f.cedula.value==0 || f.cedula.value=="")
			alert("Debe indicar el numero de cedula del observador");
		else {
			document.getElementById("razon_recuperacion").style.visibility='visible';
		}
	}
	
	function guardar_repositorio(f, nro_recuperacion) {
		//f.mod.value="recuperacion";
		f.guardar_forma.value=1;
		//alert(f.falla.value);
		f.nro_recuperacion.value=nro_recuperacion;
		f.action="../recuperacion/"+f.numero.value;
		f.submit();
	}
	
	function buscar_recuperacion(f) {
		var entra = 0;
		if (f.recuperado.length) {
			for (i=0; i<f.recuperado.length; i++) {
				if (f.recuperado[i].checked==true) {
					entra=1;
					break;
				}
			}
		} else {
			if (f.recuperado.checked==true)
				entra=1;
			else
				entra=0;
		}
		
		if (entra==0)
			alert("Debe seleccionar el nivel de recuperacion");
		else {
			//f.guardar_forma.value=0;
			f.submit();
		}
	}
	
	function imprimir_listado_recuperacion(f, recuperado, estado) {
		var eleccion = f.eleccion.value;		
		window.open("imprimir_listado_recuperacion_pdf.php?eleccion="+eleccion+"&estado="+estado+"&recuperado="+recuperado, "Listado", "location=1,status=1,scrollbars=yes, width=900,height=700");
	}
	
	function imprimir_planillas(f) {
		window.open("imprimir_listado_planillas/estado="+f.estado.value+",municipio="+f.municipio.value+",parroquia="+f.parroquia.value+",reporte="+f.reporte.value+",verificadas="+f.verificadas.value, "Listado", "location=1,status=1,scrollbars=yes, width=900,height=700");
	}
	
	function imprimir_listado_recuperacion_cobertura(f) {
		var estado = f.estado.value;
		var cant_recuperado = f.recuperado.length;
		if(cant_recuperado == undefined)
			if(f.recuperado.checked)
				var op_recuperado = 1;
			else
				var op_recuperado = 0;
		for(var i = 0; i < cant_recuperado; i++) {
			if(f.recuperado[i].checked) {
				var op_recuperado = f.recuperado.value;
			}
		}
		window.open("imprimir_listado_recuperacion_cobertura_pdf.php?eleccion=1&estado="+estado+"&recuperado="+op_recuperado, "Listado", "location=1,status=1,scrollbars=yes, width=900,height=700");
	}	
	
	function recuperar_dato(eleccion, id_observador, id_encuesta) {
		var f = eval("document.forms[0]");
		f.id_eleccion.value=eleccion;
		f.id_observador.value=id_observador;
		f.id_encuesta.value=id_encuesta;		
		f.buscar_observ.value=1;
		f.numero.value=id_encuesta;
		for(var i = 0; i < f.recuperado.length; i++) {
			if(f.recuperado[i].checked==true) {
				f.recuperacion.value = i+1;
			}
		}
		f.action="recuperar_reportes_planillas";
		f.submit();
	}
	
	function guardar_menu(f) {		
		if (f.nombre.value=="")			
			alert("Debe ingresar todos los campos obligatorios !!!");		
		else {			
			f.guardar_forma.value=1;			
			f.submit();
		}	
	}
	
	function consultar_menu(id_menu) {
		var f = eval("document.forms[0]");
		f.id_menu.value=id_menu;
		f.guardar_forma.value=0;
		f.submit();
	}
	
	function cambiar_eleccion() {
		var f = eval("document.forms[0]");
		f.mod.value="cambio_eleccion";
		f.submit();
	}
	
	function ver_porcentaje(porcentaje) {
		alert(porcentaje);
	}
	
	/********ONMOUSEVER********/
	
	var tipwidth='150px'
	var tipbgcolor='lightyellow'
	var disappeardelay=250
	var vertical_offset="0px"
	var horizontal_offset="-3px" 

	var ie4=document.all
	var ns6=document.getElementById&&!document.all

	if (ie4||ns6)
		document.write('<div id="fixedtipdiv" style="visibility:hidden;width:'+tipwidth+';background-color:'+tipbgcolor+'" ></div>')

	function getposOffset(what, offsettype){
		var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
		var parentEl=what.offsetParent;
		while (parentEl!=null){
			totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
			parentEl=parentEl.offsetParent;
		}
		return totaloffset;
	}


	function showhide(obj, e, visible, hidden, tipwidth){
		if (ie4||ns6)
			dropmenuobj.style.left=dropmenuobj.style.top=-500
		if (tipwidth!=""){
			dropmenuobj.widthobj=dropmenuobj.style
			dropmenuobj.widthobj.width=tipwidth
		}
		if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
			obj.visibility=visible
		else if (e.type=="click")
			obj.visibility=hidden
	}

	function iecompattest(){
		return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
	}

	function clearbrowseredge(obj, whichedge){
		var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1
		if (whichedge=="rightedge") {
			var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
			dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
			if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
				edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
		}
		else{
			var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
			dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
			if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure)
				edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
		}
		return edgeoffset
	}

	function fixedtooltip(menucontents, obj, e, tipwidth) {
		if (window.event) event.cancelBubble=true
		else if (e.stopPropagation) e.stopPropagation()
		clearhidetip()
		dropmenuobj=document.getElementById? document.getElementById("fixedtipdiv") : fixedtipdiv
		dropmenuobj.innerHTML=menucontents

		if (ie4||ns6){
			showhide(dropmenuobj.style, e, "visible", "hidden", tipwidth)
			dropmenuobj.x=getposOffset(obj, "left")
			dropmenuobj.y=getposOffset(obj, "top")			
			dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
			dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"
		}
	}

	function hidetip(e){
		if (typeof dropmenuobj!="undefined"){
			if (ie4||ns6)
				dropmenuobj.style.visibility="hidden"
		}
	}

	function delayhidetip(){
		if (ie4||ns6)
			delayhide=setTimeout("hidetip()",disappeardelay)
	}

	function clearhidetip() {
		if (typeof delayhide!="undefined")
			clearTimeout(delayhide)
	}

	/********ONMOUT********/
	
	function ver_excel(pagina) {
		window.open(pagina, "ListadoExcel", "location=1,status=1,scrollbars=yes, width=900,height=700");
	}
	
	function ver_excel_estadistica(pagina) {
		var f = eval("document.forms[0]");
		window.open(pagina+",estado="+f.estado.value+",municipio="+f.municipio.value+",parroquia="+f.parroquia.value+",reporte="+f.reportes.value, "ListadoExcel", "location=1,status=1,scrollbars=yes, width=900,height=700");
	}
	
	function ver_excel_estadistica_observadores(pagina) {
		var f = eval("document.forms[0]");
		//alert(pagina);
		window.open(pagina+"/cedula="+f.cedula.value+",nombres="+f.nombres.value+",apellidos="+f.apellidos.value+",privilegio="+f.privilegio.value+",estado="+f.estado.value+",municipio="+f.municipio.value+",parroquia="+f.parroquia.value, "ListadoExcel", "location=1,status=1,scrollbars=yes, width=900,height=700");
	}	
	
	function ver_reporte (valor) {
		if (valor>0) {
			var f = eval("document.forms[0]");
			f.submit();
		}
	}
	
	function imprimir_reporte(f) {
		window.open("imprimir_reporte_asignacion.php?cedula_observador="+f.cedula_observador.value+"&nac_observador="+f.nac_observador.value+"&nombres_observador="+f.nombres_observador.value+"&apellidos_observador="+f.apellidos_observador.value+"&nombres_eleccion="+f.nombres_eleccion.value+"&tipo_eleccion="+f.tipo_eleccion.value+"&fechas_eleccion="+f.fechas_eleccion.value+"&nombres_centro="+f.nombres_centro.value+"&estado="+f.estado.value+"&municipio="+f.municipio.value+"&parroquia="+f.parroquia.value, "ReporteAsignacion", "location=1,status=1,scrollbars=yes, width=900,height=700");
	}
	
	function buscar_asignaciones_operadores(f) {
		f.id_asignacion.value=0;
		f.submit();
	}
	
	function asignar_operador(f) {
		var entra=0;
		var dato="";
		for (i=0; i<f.length; i++) {
			if (f.elements[i].name.indexOf("chk_")>-1 && f.elements[i].checked==true) {
				entra=1;
				dato+=f.elements[i].name.substr(4)+",";
			}				
		}
				
		if (f.cod_operador.value=="" || f.cod_operador.value==0)
			entra=0;
		
		if (entra==0)
			alert("Debe seleccionar al menos un observador a asignar y colocar el numero de operador al que se le asignaran los operadores !!!");
		else {
			f.dato.value=dato;
			//alert(dato);
			f.action="asignar_observadores";
			f.submit();
		}
	}
	
	function imprimir_listado(f) {
		window.open("imprimir_listado_asignacion_observadores/cod_operador="+f.cod_operador.value+",cedula="+f.cedula.value+",nombres="+f.nombres.value+",apellidos="+f.apellidos.value+",estado="+f.estado.value+",municipio="+f.municipio.value+",parroquia="+f.parroquia.value, "Listado", "location=1,status=1,scrollbars=yes, width=900,height=700");
	}
	
	function imprimir_listado_operador (id_operador, estatus, estado, municipio, parroquia, centro, reporte) {
		var f=eval("document.forms[0]");
		if (f.action.indexOf("buscar_listado_observadores")> -1)
		//if (f.cedula.value!=0 && f.cedula.value!="")
			window.open("imprimir_listado_asignacion/"+id_operador+","+estatus+","+estado+","+municipio+","+parroquia+","+centro+","+reporte, "Listado", "location=1,status=1,scrollbars=yes, width=1100,height=700");
		else
			window.open("imprimir_listado_asignacion/0,"+estatus, "Listado", "location=1,status=1,scrollbars=yes, width=1100,height=700");			
	}
	
	function imprimir_reporte_encuestas(f, reporte) {
		window.open("imprimir_reporte_"+reporte+".php?estado="+f.estado.value+"&municipio="+f.municipio.value+"&parroquia="+f.parroquia.value+"&cod_centro="+f.cod_centro.value, "Listado", "location=1,status=1,scrollbars=yes, width=900,height=700");	
	}
	
	function otra_falla(valor) {
		var f=eval("document.forms[0]");
		if (valor==-1) {
			document.getElementById("label_otra_falla").style.visibility='visible';
		} else {
			document.getElementById("label_otra_falla").style.visibility='hidden';
			f.otra_falla_texto.value="";
		}
	}
	
	function buscar_cedula (f) {
		if (f.cedula.value=="")
			alert("Debe ingresar la cedula a buscar");
		else {
			f.guardar_forma.value=0;
			f.submit();
		}
	}
	
	function revertir_planilla(id_asignacion,id_observador, reporte, f) {
		if (confirm("Esta seguro de revertir esta planilla?. Recuerde que tambien se borraran los registros como recuperacion para esta planilla")) {
			f.id_asignacion.value=id_asignacion;
			f.id_observador.value=id_observador;
			f.action="../borrar_planilla";
			f.submit();
		}
	}