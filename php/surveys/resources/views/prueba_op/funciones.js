
$(document).ready(function() {
	 $("#id_tipo_prueba").change(function () {
		 if (pruebas_disponibles_array[$(this).val()]==0) {
			 $("#disponibles").html("* Ud. no posee pruebas para asignar");
			 $("#asignar").css("display","none");
		 } else {
			$("#disponibles").html("* Ud. posee un maximo de: "+pruebas_disponibles_array[$(this).val()]+" pruebas a asignar");
			$("#asignar").css("display","inline");
		 }
		 $("input#cantidad_pruebas").val(pruebas_disponibles_array[$(this).val()]);
	 });
	 
	 $("#invitar_boton").click(function() {
		 if ($("#id_tipo_prueba_invitacion").val()==2) {
			 if (($("#nombres_2").val()=="") || ($("#cantidad_2").val()=="") || ($("#email_2").val()==""))
				 alert("Debe llenar todos los campos");
			 else
				 $("#forma_invitacion").submit();				 
		 } else {
			 if (($("#nombres_1").val()=="") || ($("#apellidos_1").val()=="") || ($("#email_1").val()==""))
				 alert("Debe llenar todos los campos");
			 else
				 $("#forma_invitacion").submit();				 
		 }
	 });
	 
	 $("#asignar").click(function() {
		 var cantidad_pruebas= $("#cantidad_pruebas").val();
		 var cantidad = $("#cantidad").val();
		 if (cantidad_pruebas<cantidad)
			 $("#error").val()=1;
		 else
			 $("#error").val()=0;
	 });
	 
	 $("#coach1").click(function() {
		$("#datos_coach").css("display","inline");
	 });
	 
	 $("#coach0").click(function() {
		$("#datos_coach").css("display","none");
	 });		 	 
});

var URLactual = window.location;

if (URLactual.toString().indexOf("prueba_co")>-1 && URLactual.toString().indexOf("-2")>-1)
	id_pregunta_co=4;
else
	id_pregunta_co=1;

	function numeros(evento) {
		patron_numeros=/[0-9]/;
		if(document.all)
			tecla_press=evento.keyCode;
		else
			tecla_press=evento.which;

		if(tecla_press==8 || tecla_press==0)
			return true;
			
		numero=String.fromCharCode(tecla_press);
		if(patron_numeros.test(numero)==true)
			return (patron_numeros.test(numero));
		else {
			alert('Solo se permiten numeros en este campo');
			return false;
		}
	}

	function caracteres(evento) {
		tecla=(document.all) ? evento.keyCode: evento.which;
		if(tecla==8 || tecla==0) {
			return true;
		}
		patron=/[A-Za-zñÑ]/;
		te=String.fromCharCode(tecla);
		te.toUpperCase();
		if(tecla==32) {
			return true;	
		} else if(patron.test(te)==true) {
			return true;
		} else {
			alert('Caracter no valido');
			return false;
		}
	}
	
	function soloNumeros(e){
		var key = window.Event ? e.which : e.keyCode
		return (key >= 48 && key <= 57)
	}	
	
	function validar(tipo,id,valor) {
		var tipo2="";
		if(tipo=="mas")
			tipo2="menos";
		else
			tipo2="mas";
		//alert ("tipo="+tipo+"...id="+id+"...valor="+valor);
		//alert("..."+tipo+"_"+id+"="+document.getElementById(tipo+"_"+valor).checked+"...valor="+document.getElementById(tipo+"_"+valor).value);
		if (document.getElementById(tipo+"_"+valor).checked==true) {
			alert("No puede seleccionar esta opcion");
			document.getElementById(tipo2+"_"+valor).checked=false;
		}
	}
	
	function guardar_encuesta() {
		var f=eval("document.forms[0]");
		var fop="";
		var mas=0;
		var menjos=0;

		var pasa=1;
		var texto="";
		document.getElementById("error").innerHTML="";
		for (i=1; i<31; i++) {
			fop=eval("document.forma"+i);
			mas=0;
			menos=0;
			for (j=0; j<fop.length; j++) {
				if (fop.elements[j].name.indexOf("mas_")>-1) {
					if (fop.elements[j].checked==true) {
						$(f).append('<input type="hidden" name="mas_'+i+'" value="'+fop.elements[j].value+'" />');				
						mas++;
					}
				}
				if (fop.elements[j].name.indexOf("menos_")>-1) {
					if (fop.elements[j].checked==true) {
						$(f).append('<input type="hidden" name="menos_'+i+'" value="'+fop.elements[j].value+'" />');				
						menos++;
					}
				}
			}
			if (mas==0 || menos==0) {
				texto+="Seleccionar en la pregunta "+i+" una opcion positiva (+) y otra opcion (-) / ";
				pasa=0;
				document.getElementById("error").innerHTML=texto;
			}
		}
		if (pasa==1) {				
			f.submit();
		}
	}
	
	function suma(valor, i, pregunta, cantidad) {
		var f=eval("document.forma"+i);
		var valor_suma=0;		
		valor=parseFloat(valor);
		if (valor>3 || valor=="" || valor==0 || isNaN(valor)) {
			//alert("pregunta_"+i+"_"+pregunta);
			$("#pregunta_"+i+"_"+pregunta).val("");
		} else {
			valor_suma=0;			
			for (l=0; l<f.length; l++) {				
				if (f.elements[l].name.indexOf("pregunta_") > -1)
					if (f.elements[l].checked==true) {
						valor_suma=parseFloat(valor_suma)+parseFloat(f.elements[l].value);
					}
			}
			valor_suma=(valor_suma/cantidad);
			$("#op_"+i).val(parseFloat(valor_suma));
			//$("#suma_op_"+i).html("<br>"+potencial[i]+" <div class='alert alert-danger alert-dismissible fade in'>Total Promedio = "+(valor_suma.toFixed(2))+"</div>");
		}
	}	
	
	function guardar_potencial() {
		var f=eval("document.forms[0]");
		var fop="";
		var pasa=1;
		var texto="";
		for (i=1; i<7; i++) {
			fop=eval("document.forma"+i);
			if ($("#op_"+i).val()==0 || $("#op_"+i).val()=="") {
				alert("Debe llenar el Potencial "+i);
				pasa=0;
			} else
				$(f).append('<input type="hidden" name="f_op_'+i+'" value="'+$("#op_"+i).val()+'" />');
		}
		if (pasa==1) {
			for (i=1; i<7; i++) {
				var f_op=eval("document.forma"+i);
				for (j=0; j<f_op.length; j++)
					if (f_op.elements[j].name.indexOf("pregunta_")>-1)
						$(f).append('<input type="hidden" name="'+f_op.elements[j].name+'" value="'+f_op.elements[j].value+'" />');
			}
			f.submit();
		}
	}	
	
	function guardar_iol() {
		var f=eval("document.forms[0]");
		var fop="";
		var mas=0;
		var menjos=0;
		var pasa=1;
		var texto="Seleccionar en las siguientes preguntas una opcion positiva (+) y otra opcion (-): <br><br> ";
		//document.getElementById("error").innerHTML="";
		var contador=0;
		for (i=1; i<31; i++) {
			fop=eval("document.forma"+i);
			mas=0;
			var pasa_mas=0;
			var menos=0;
			var pasa_menos=0;				
			for (j=0; j<fop.length; j++) {
				if (fop.elements[j].name.indexOf("mas_")>-1) {
					if (fop.elements[j].checked==true) {
						$(f).append('<input type="hidden" name="mas_'+i+'" value="'+fop.elements[j].value+'" />');				
						mas++;
						pasa_mas=1;
						contador++;
					}
				}
				if (fop.elements[j].name.indexOf("menos_")>-1) {
					if (fop.elements[j].checked==true) {
						$(f).append('<input type="hidden" name="menos_'+i+'" value="'+fop.elements[j].value+'" />');				
						menos++;
						pasa_menos=1;
						contador++;
					}
				}
			}
			if (pasa_mas==0 || pasa_menos==0) {
				texto+=i+", ";
				//document.getElementById("error").innerHTML=texto;
			}
		}
		if (contador==60) {				
			f.submit();
		} else {
			$('#modal_text').html(texto);
			$('#myModal').modal('show');
		}
	}	
	
function startTimer() {
	duration=900; // 15 minutos
    var timer = duration, minutes, seconds;
    setInterval(function () {		
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
		//alert(minutes + ":" + seconds);
        $("#time").html(minutes + ":" + seconds);

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}

	function startTimer_co(tiempo, pruebas_presentadas,prueba) {
		//tiempo=1;
		duration=tiempo*60*1; // 15 minutos
		var timer = duration, minutes, seconds;
		var milisegundos=duration*1000;
		var tiemposec=duration;
		tiempo_co = setInterval(function () {
			tiemposec--;
			//alert(duration);
			minutes = parseInt(timer / 60, 10);
			seconds = parseInt(timer % 60, 10);			
			
			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;
			//alert(minutes + ":" + seconds);
			$("#time_"+prueba).html(minutes + ":" + seconds);

			if (--timer < 0) {
				timer = duration;
			}
			//alert(timer);
			if (tiemposec==-1) {
				alert("Detengase ahora pasara a la siguiente prueba...");
				guardar_encuesta_co();
			}		
		}, 1000);
	}
	
	function startTimer_hl(tiempo, pruebas_presentadas,prueba) {
		tiempo=1;
		duration=tiempo*60*1; // 15 minutos
		var timer = duration, minutes, seconds;
		var milisegundos=duration*1000;
		var tiemposec=duration;
		tiempo_hi = setInterval(function () {
			tiemposec--;
			//alert(duration);
			minutes = parseInt(timer / 60, 10);
			seconds = parseInt(timer % 60, 10);			
			
			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;
			//alert(minutes + ":" + seconds);
			$("#time_"+prueba).html(minutes + ":" + seconds);

			if (--timer < 0) {
				timer = duration;
			}
			//alert(timer);
			if (tiemposec==-1) {
				if (nro_prueba==4) {
					alert("El tiempo para su prueba ha sido culminado. Gracias por presentar !!!");
					//$("#datos_prueba").html('<strong><h1 style="color: #1abb9c; texty-align: center">Gracias por presentar nuestras pruebas.</h1></strong>');
					pruebas_presentadas++;
					for (i=pruebas_presentadas; i<5; i++)
						document.getElementById("encuesta_"+i).style.display="none";
					guardar_encuesta_hl();
					//break;
				} else if (nro_prueba<4) {
					alert("Detengase ahora pasara a la siguiente prueba...");
					guardar_encuesta_hl();
				}
			}			
		}, 1000);
	}
	
	function startTimer_op(tiempo, pruebas_presentadas,prueba) {
		tiempo=1;
		duration=tiempo*60*1; // 15 minutos
		var timer = duration, minutes, seconds;
		var milisegundos=duration*1000;
		var tiemposec=duration;
		tiempo_op = setInterval(function () {
			tiemposec--;
			minutes = parseInt(timer / 60, 10);
			seconds = parseInt(timer % 60, 10);			
			
			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;
			$("#time_"+prueba).html(minutes + ":" + seconds);

			if (--timer < 0) {
				timer = duration;
			}

			if (tiemposec==-1) {
				if (nro_prueba==3) {
					alert("El tiempo para su prueba ha sido culminado. Gracias por presentar !!!");
					pruebas_presentadas++;
					for (i=pruebas_presentadas; i<5; i++)
						document.getElementById("encuesta_"+i).style.display="none";
					guardar_encuesta_hl();
					//break;
				} else if (nro_prueba<3) {
					alert("Detengase ahora pasara a la siguiente prueba...");
					guardar_encuesta_hl();
				}
			}			
		}, 1000);
	}
	
	
	function verificar_radio(nombre,m) {
		//op_3_3_mas_1
		var tipo="";
		tipo=nombre+"_"+m;
		//alert(tipo);
		if (tipo.indexOf("mas")>-1)
			tipo=tipo.replace("mas", "menos");
		else
			tipo=tipo.replace("menos", "mas");
		//alert(tipo);
		if (document.getElementById(tipo).checked==true) {
			alert("No puede seleccionar esta opcion");
			document.getElementById(nombre+"_"+m).checked=false;
		}
	}
	
	function ver_encuesta_hl_cc(tiempo, prueba, pruebas_presentadas) {
		nro_prueba=prueba;		
		if (prueba==1)
			document.getElementById("instrucciones_"+prueba).style.display="none";
		else {
			var x=1;
			pruebas_presentadas++;
			for (i=pruebas_presentadas; i<5; i++)
				document.getElementById("instrucciones_"+i).style.display="none";
			pruebas_presentadas--;
			if (pruebas_presentadas==0)
				document.getElementById("datos_participante").style.display="none";
		}
		document.getElementById("encuesta_"+nro_prueba).style.display="inline";
		startTimer_hl(tiempo, pruebas_presentadas,prueba);
		//startTimer();
	}
	
	function ver_encuesta_co(tiempo, prueba, pruebas_presentadas) {
		nro_prueba_co=prueba;		
		if (prueba==2)
			document.getElementById("instrucciones_"+prueba).style.display="none";
		else {
			var x=1;
			pruebas_presentadas++;
			for (i=pruebas_presentadas; i<4; i++)
				document.getElementById("instrucciones_"+i).style.display="none";
			pruebas_presentadas--;
			if (pruebas_presentadas==0)
				document.getElementById("datos_participante").style.display="none";
		}
		document.getElementById("encuesta_"+nro_prueba_co).style.display="inline";
		if (pruebas_presentadas>1)
			startTimer_co(tiempo, pruebas_presentadas,prueba);
		else {
			document.getElementById("instrucciones_1").style.display="none";
			document.getElementById("encuesta_1").style.display="inline";
		}		
	}
	
	function ver_encuesta_op(tiempo, prueba, pruebas_presentadas,id_au) {
		//alert(tiempo+"..."+prueba+"..."+pruebas_presentadas);
		if (prueba>1) {
			nro_prueba_co=prueba;		
			var x=1;
			pruebas_presentadas++;
			for (i=1; i<4; i++)
				document.getElementById("instrucciones_"+i).style.display="none";
			pruebas_presentadas--;
			if (pruebas_presentadas==0)
				document.getElementById("datos_participante").style.display="none";

			document.getElementById("encuesta_"+nro_prueba_co).style.display="inline";
			if (pruebas_presentadas>1)
				startTimer_op(tiempo, pruebas_presentadas,prueba);
			else {
				document.getElementById("instrucciones_1").style.display="none";
				document.getElementById("encuesta_1").style.display="inline";
			}
		} else
			location.href="../prueba_op/encuesta_5_1_1-"+id_au;
	}	

	function guardar_encuesta_hl() {
		var id_au;
		id_au=document.forms[0].id_au.value;
		
		clearInterval(tiempo_hi);
		if (nro_prueba==1) {
			for (i=1; i<5; i++)
				document.getElementById("encuesta_"+i).style.display="none";
			for (i=1; i<5; i++)
				document.getElementById("instrucciones_"+i).style.display="none";				
			
			nro_prueba++;
			document.getElementById("instrucciones_"+nro_prueba).style.display="inline";
		} else if (nro_prueba==2) {
			// GUARDANDO PRUEBA DE COORDINACION
			preguntas=19;
			resultado="";
			for (i=1; i<preguntas; i++) {
				var f=eval("document.forma"+i);
				var id_pregunta=0;
				for (j=0; j<f.length; j++) {
					if (f.elements[j].name.indexOf("coord_")>-1) {
						nombre=f.elements[j].name;
						if (f.elements[j].value!="")
							valor=f.elements[j].value;
						else
							valor=0;						
						if (id_pregunta==0 || nombre.substr(6,2)!=id_pregunta) {
							id_pregunta=nombre.substr(6,2);
							resultado+=id_pregunta+".";
						}
						resultado+=valor+",";
					}
				}
				resultado=resultado+"..";
			}
			// ************ AJAX ***************
			var parametros = {
				"resultado" : resultado,
				"id_au" : id_au,
				"_token": $('input[name=_token]').val()
			};
			$.ajax({
				data:  parametros,
				url:   '../index_guardar_prueba_coordinacion_1',
				type:  'post',
				beforeSend: function () {
					$("#datos_prueba").html("....Procesando, espere por favor");
				},
				success:  function (data) {
					$("#datos_prueba").html("");
				}
			});

			if (nro_prueba==1)
				document.getElementById("encuesta_"+(nro_prueba)).style.display="none";
			else
				for (i=1; i<5; i++)
					document.getElementById("encuesta_"+i).style.display="none";
				
			if (nro_prueba==1)
				document.getElementById("instrucciones_"+(nro_prueba)).style.display="none";
			else
				for (i=1; i<5; i++)
					document.getElementById("instrucciones_"+i).style.display="none";			
				
			nro_prueba++;
			document.getElementById("instrucciones_"+nro_prueba).style.display="inline";			
		} else if (nro_prueba==3) {
			// GUARDANDO PRUEBA DE HABILIDADES INTELECTIVAS
			preg_ant=19;
			preguntas=preg_ant+40;
			resultado=0;			
			for (i=preg_ant; i<preguntas; i++) {
				var f=eval("document.forma"+i);
				for (j=0; j<f.length; j++) {
					if (f.elements[j].name.indexOf("op_3_2")>-1) {
						if (f.elements[j].checked==true) {
							valor=f.elements[j].value;
							resultado+=valor+",";
						}
					}
				}
			}
			// ************ AJAX ***************
			var parametros = {
				"resultado" : resultado,
				"id_au" : id_au,
				"_token": $('input[name=_token]').val()
			};
			$.ajax({
				data:  parametros,
				url:   '../index_guardar_prueba_intelectivas',
				type:  'post',
				beforeSend: function () {
					$("#datos_prueba").html("....Procesando, espere por favor");
				},
				success:  function (data) {
					$("#datos_prueba").html("");
				}
			});		
			if (nro_prueba==1)
				document.getElementById("encuesta_"+(nro_prueba)).style.display="none";
			else
				for (i=1; i<5; i++)
					document.getElementById("encuesta_"+i).style.display="none";						
			nro_prueba++;
			document.getElementById("instrucciones_"+nro_prueba).style.display="inline";			
		} else if (nro_prueba==4) {
			// GUARDANDO PRUEBA DE INVENTARIO PERSONAL
			preg_ant=19+40;
			preguntas=preg_ant+48;
			resultado="";
			for (i=preg_ant; i<preguntas; i++) {
				var f=eval("document.forma"+i);
				for (j=0; j<f.length; j++) {
					if (f.elements[j].name.indexOf("op_3_3")>-1) {
						if (f.elements[j].name.indexOf("mas_")>-1 && f.elements[j].checked==true) {
							//alert("mas="+f.elements[j].value+"...checked="+f.elements[j].checked);
							opcion=f.elements[j].value.substr(4);
							resultado+=opcion+"=1,";
						} else if (f.elements[j].name.indexOf("menos_")>-1 && f.elements[j].checked==true) {
							//alert("menos="+f.elements[j].value+"...checked="+f.elements[j].checked);
							opcion=f.elements[j].value.substr(6);
							resultado+=opcion+"=-1,";
						}
					}
				}
			}
			// ************ AJAX ***************
			var parametros = {
				"resultado" : resultado,
				"id_au" : id_au,
				"_token": $('input[name=_token]').val()
			};
			$.ajax({
				data:  parametros,
				url:   '../index_guardar_prueba_personal',
				type:  'post',
				beforeSend: function () {
					$("#datos_prueba").html("....Procesando, espere por favor");
				},
				success:  function (data) {
					location.href="../generar_resultado_hi/"+id_au;
				}
			});
		}
	}
	
	function guardar_encuesta_op() {
		clearInterval(tiempo_op);
		var id_au;
		id_au=document.forms[0].id_au.value;
		alert(id_au);
		return;
		
		if (nro_prueba==1) {
			// GUARDANDO PRUEBA DE COORDINACION
			preguntas=81;
			resultado="";
			for (i=1; i<preguntas; i++) {
				var f=eval("document.forma"+i);
				var id_pregunta=0;
				if (f.elements[0].name.indexOf("op_1_")>-1) {
					//nombre=
					if (f.elements[j].checked==true)
						valor=f.elements[j].value;
					else
						valor=0;						
					id_pregunta=nombre.substr(6,2);
					resultado+=id_pregunta+"."+valor+"..";
				}
			}
		}
		alert(resultado);
	}
	
	function verificar_forma(prueba, pregunta, respuesta) {
		nro_prueba_co=prueba;
		pregunta_actual_co=pregunta;
		
		//alert(prueba+"..."+pregunta+"..."+respuesta);
	}
	
	function escribir(numero) {
		if (pregunta_actual_co==1 && URLactual.toString().indexOf("prueba_op/encuesta")>-1)
			pregunta_actual_co=81;
		$("#ap_"+pregunta_actual_co).val($("#ap_"+pregunta_actual_co).val()+numero);
		//$("#ap_"+pregunta_actual_co).append(numero);
		//alert("ap_"+pregunta_actual_co+"..."+$("#ap_"+pregunta_actual_co).val());
	}
	
	function guardar_encuesta_co() {
		var id_au;
		id_au=document.forms[0].id_au.value;
		preguntas=118;
		resultado="";
		clearInterval(tiempo_co);
		if (nro_prueba_co>2) {
			// GUARDANDO PRUEBA DE TCO	
			for (i=58; i<preguntas; i++) {
				var f=eval("document.forma_"+nro_prueba_co+"_"+i);
				for (j=0; j<f.length; j++) {
					valor=f.elements[j].value;
					id_pregunta=f.elements[j].name.substr(6);
					if (valor=="")
						valor=0;
					resultado+=id_pregunta+"-"+valor+",";
				}
			}
			//alert(resultado);
			//alert("index_guardar_prueba_co?resultado="+resultado+"&id_au="+id_au);
			// ************ AJAX ***************
			var parametros = {
				"resultado" : resultado,
				"id_au" : id_au,
				"_token": $('input[name=_token]').val()
			};
			$.ajax({
				data:  parametros,
				url:   '../index_guardar_prueba_co',
				type:  'post',
				beforeSend: function () {
					$("#datos_prueba").html("....Procesando, espere por favor");
				},
				success:  function (data) {
					location.href="../generar_resultado_co/"+id_au;
				}
			});
		} else {
			id_pregunta_co++;
			document.getElementById("encuesta_"+nro_prueba_co).style.display="none";
			nro_prueba_co++;
			document.getElementById("instrucciones_"+nro_prueba_co).style.display="inline";
			//startTimer_co(10, (nro_prueba_co-1), nro_prueba_co);
		}
	}	
	
	function guardar_participante() {
		id_au=document.forms[0].id_au.value;
		
		nombres=$("#nombres").val();
		apellidos=$("#apellidos").val();
		cedula=$("#cedula").val();
		sexo=$("#sexo").val();
		email=$("#email").val();
		nacionalidad=$("#nacionalidad").val();
		edad=$("#edad").val();
		nivel_formacion=$("#nivel_formacion").val();
		orientacion_area=$("#orientacion_area").val();
		orientacion_cargo=$("#orientacion_cargo").val();
	
		// ************ AJAX ***************
		//$("#datos_prueba").html("index_guardar_participante?nombres="+nombres+"&apellidos="+apellidos+"&cedula="+cedula+"&sexo="+sexo+"&email="+email+"&nacionalidad="+nacionalidad+"&edad="+edad+"&nivel_formacion="+nivel_formacion+"&orientacion_area="+orientacion_area+"&orientacion_cargo="+orientacion_cargo+"&id_au="+id_au);
		//return;
		var parametros = {
			"nombres" : nombres,
			"apellidos" : apellidos,
			"cedula" : cedula,
			"sexo" : sexo,
			"email" : email,
			"nacionalidad" : nacionalidad,
			"edad" : edad,
			"nivel_formacion" : nivel_formacion,
			"orientacion_area" : orientacion_area,
			"orientacion_cargo" : orientacion_cargo,
			"id_au" : id_au,
			"_token": $('input[name=_token]').val()
		};
		$.ajax({
			data:  parametros,
			url:   '../index_guardar_participante',
			type:  'post',
			beforeSend: function () {
				$("#datos_prueba").html();
			},
			success:  function (data) {
				/*for (i=1; i<4; i++)
					document.getElementById("encuesta_"+i).style.display="none";*/
				document.getElementById("datos_participante").style.display="none";
				document.getElementById("instrucciones_1").style.display="inline";
			}
		});
	}
	
	function ver_chek(chk) {
		var nombre=chk.name;
		var cantidad=0;
		var pregunta=chk.name.substr(12);		
		var valor=chk.value.substr(0,3);		
		
		alert("id="+chk.id+"...name="+chk.name+"...valur="+chk.value+"...pregunta="+pregunta+"....valor="+valor);
		alert("indice_array1="+indice_array);
		alert(pregunta+"_"+valor);
		array_preguntas[indice_array]=pregunta+"_"+valor;
		alert("array_preguntas="+array_preguntas[indice_array]);
		indice_array++;
		alert("indice_array2="+indice_array);
		
		//name= op_3_3_<nro_de_pregunta>
		//id= nro de opcion (1,2,3,4)
		//value= mas_<id_opcion>
		//for (i=0; i<)
	}
	
	function ver_encuesta(tipo) {
		var f=eval("document.forms[0]")
		if ((f.apellidos.value=="" || f.nombres.value=="" || f.email.value=="" || f.cedula.value=="") && tipo=='iol')
			alert("Debe llenar todos los campos del candidato !!")
		else {
			document.getElementById("encuesta").style.display="inline";
			document.getElementById("instrucciones").style.display="none";
			document.getElementById("participante").style.display="none";
			startTimer();
		}
	}
	
	function ver_evaluados(valor) {
		var texto="";
		$("#evaluados").html("");
		for (i=0; i<valor; i++) {
			texto='<div class="form-group">';
			texto+='<label class="control-label col-md-3 col-sm-3 col-xs-12">Evaluado '+(i+1)+': </label>';
			texto+='<div class="col-md-3"><input id="nombre_2_'+(i+1)+'" name="nombre_2_'+(i+1)+'" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre" value=""></div>';
			texto+='<div class="col-md-3"><input id="email_2_'+(i+1)+'" name="email_2_'+(i+1)+'" type="email" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Email" value=""></div>';
			texto+='</div>';
			$("#evaluados").append(texto);
		}
	}	
	
	var prueba_activa=0;

	function buscar_evaluador(valor) {
		var f=eval("document.forms[0]")
		var parametros = {
			"correo" : valor,
			"_token": $('input[name=_token]').val()
		};
		$.ajax({
			data:  parametros,
			url:   'index_buscar_evaluador',
			type:  'post',
			beforeSend: function () {
				$("#datos_paciente").html("....Procesando, espere por favor");
			},
			success:  function (data) {
				//alert("res="+data.resultado);
				//alert("id="+data.id);
				$("#nombres").val(data.resultado);				
				if (data.resultado!="") {
					$("#email").prop( "disabled", true );
					$(f).append("<input type='hidden' name='id_usuario' value="+data.id+">");
				}
			}
		});		
	}
	
	
	
	function colocar(opcion,preguntas) {
		if (opcion.indexOf("imagenes")>-1)
			$("#respuesta_"+preguntas).html("<img src='../"+opcion+"' border=0 height='35' width='35'>");
		else
			$("#respuesta_"+preguntas).html("<strong>"+opcion+"</strong>");
	}
	
	function colocar_test(solucion, opcion, valor, prueba, nombre) {
		respuesta="";
		if (prueba==3) {
			if (solucion==1) {
				respuesta="<span style='color: blue'>Correcta</span>";
				document.getElementById("boton_prueba_"+prueba).style.display = "inline";
			} else {
				respuesta="<span style='color: red'>Incorrecta</span>";
				document.getElementById("boton_prueba_"+prueba).style.display = "none";
			}
			
		} else if (prueba==4) {
			document.getElementById("boton_prueba_"+prueba).style.display = "inline";
		}		
		$("#respuesta_"+prueba).html("&nbsp;&nbsp;&nbsp;<strong>"+opcion+"</strong> ( "+respuesta+" )");			
	}
	
	
	function mirar_texto () {
		var f=eval("document.forms[0]");		
		f.texto.value=document.getElementById('noise').value;
		f.submit();
	}
	
	function ver_pruebas_disponibles () {		 
		if (typeof pruebas_disponibles_array[$("#id_tipo_prueba_invitacion").val()] === "undefined") {
			 $("#disponibles").html("* Ud. no posee pruebas para asignar");
			 $("#boton_invitar").css("display","none");
			 $("#invitaciones").css("display","none");
		 } else if (pruebas_disponibles_array[$("#id_tipo_prueba_invitacion").val()]==0) {
			$("#disponibles").html("* Ud. no posee pruebas para asignar");
			$("#boton_invitar").css("display","none");
			$("#invitaciones").css("display","none");
		 } else {
			 var prueba_invitacion=0;
			 if ($("#id_tipo_prueba_invitacion").val()==2)
				 prueba_invitacion=2;
			 else
				 prueba_invitacion=1;
			$("#disponibles").html("* Ud. posee un maximo de: "+pruebas_disponibles_array[$("#id_tipo_prueba_invitacion").val()]+" pruebas a asignar");	 
			 $("#prueba_"+prueba_activa).css("display","none");
			 $("#invitaciones").css("display","inline");
			 $("#prueba_"+prueba_invitacion).css("display","inline");			 
			 $("#boton_invitar").css("display","inline");
			 prueba_activa=$("#id_tipo_prueba_invitacion").val();
		 }
		 
		var parametros = {
			"id_prueba" : $("#id_tipo_prueba_invitacion").val(),
			"id_empresa" : $("#id_empresa").val(),
			"tipo":"E",
			"_token": $('input[name=_token]').val()
		};
		$.ajax({
			data:  parametros,
			url:   'index_llenar_correo',
			type:  'post',
			beforeSend: function () {
				$("#datos_paciente").html("....Procesando, espere por favor");
			},
			success:  function (data) {
				$("#ci").html('<select id="correo_invitacion" name="correo_invitacion" class="form-control">'+data.resultado+'</select>');
			}
		});
		
		var parametros = {
			"id_prueba" : $("#id_tipo_prueba_invitacion").val(),
			"id_empresa" : $("#id_empresa").val(),
			"tipo":"R",
			"_token": $('input[name=_token]').val()
		};		
		
		$.ajax({
			data:  parametros,
			url:   'index_llenar_correo',
			type:  'post',
			beforeSend: function () {
				$("#datos_paciente").html("....Procesando, espere por favor");
			},
			success:  function (data) {
				$("#cp").html('<select id="correo_presentacion" name="correo_presentacion" class="form-control">'+data.resultado+'</select>');
			}
		});		
	}
	
	function colocar_nro(id) {
		var valor="";
		var texto="";
		
		$("#coord_"+pregunta_actual_co).val(id);
		if (nro_prueba_co==1) {
			if ($("#coord_"+pregunta_actual_co).val()==respuesta_actual_co[pregunta_actual_co])
				valor="<span style='color: blue'>CORRECTA</span>";
			else
				valor="<span style='color: red'>INCORRECTA</span>";
		}
		if (pregunta_actual_co==1)
			texto=valor+": La primera letra del apellido Ettedgui nos orienta hacia las gavetas 11 y 12, las cuales contemplan los apellidos que comienzan con la letra “E”, pero sólo la gaveta 12 presenta el intervalo que contiene la combinación “ET” pues abarca desde “ES” hasta “EZ”; por lo tanto, corresponde ubicarlo en esa gaveta. Por ello, se ha colocado el número 12 al lado del apellido Ettedgui..";
		else if (pregunta_actual_co==2)
			texto=valor+": En este ejemplo, el apellido Tovar se ubica en la gaveta 37, ésta presenta el intervalo de letras entre la “TJ” y la “TZ”.En el siguiente ejemplo, ¿en cuál gaveta debe ser ubicado el apellido Brito?";
		else if (pregunta_actual_co==3)
			texto=valor+": En la gaveta 5, dado que las dos primeras letras del apellido, “BR”, se encuentran alfabéticamente entre las letras “BJ” y “BR”.  Observe que al presionar con el mouse la gaveta 5, este número aparece en la casilla al lado del apellido Brito, J.R.";
		
		$("#valor").html(texto);
	}
	
	function ver_pregunta() {
		id_pregunta_co++;
		$("#valor").html("");
	}
	
	function ver_pregunta_ejemplo() {
		if ((id_pregunta_co==1 && $("#coord_"+id_pregunta_co).val()==12) ||
			(id_pregunta_co==2 && $("#coord_"+id_pregunta_co).val()==37) ||
			(id_pregunta_co==3 && $("#coord_"+id_pregunta_co).val()==5)) {
			location.href="#";
			id_pregunta_co++;
		} else
			alert("Para pasar a la siguiente debe colocar la opcion correcta");
	}	
	
	function guardar_encuesta_co_ejemplo() {
		if ($("#coord_"+pregunta_actual_co).val()==respuesta_actual_co[pregunta_actual_co]) {
			location.href="../prueba_co/"+id_au+"-2";
			id_pregunta_co++;
		} else
			alert("Para pasar a la siguiente debe colocar la opcion correcta");
		
	}
	
