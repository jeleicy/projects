var mas=0;
var menos=0;
		
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
			 document.forms[0].error.value=1;
		 else
			 document.forms[0].error.value=0;
		 document.forms[0].submit();
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
	
	/*function soloNumeros(e){
		var key = window.Event ? e.which : e.keyCode
		return (key >= 48 && key <= 57)
	}	*/
	
	function guardar() {
		var f=eval("document.forms[0]");
		f.submit();
	}
	
	  function soloNumeros(texto){
		var numero=texto.value;
		//alert(numero);
		if (numero.toString().indexOf(".")>-1) {
			var entero=numero.substring(0,numero.indexOf("."));
			var decimales=numero.substring(numero.indexOf(".")+1);
			//alert(entero);
			//alert(decimales);
			if (!/^([0-9])*$/.test(entero) || !/^([0-9])*$/.test(decimales)) {
				alert("El valor " + numero + " no es un número. Y si trata de colocar decimales colocole con separador de decimales punto (.)");
				texto.value="";
			}
		} else {
			if (!/^([0-9])*$/.test(numero)) {				
				alert("El valor " + numero + " no es un número. Y si trata de colocar decimales colocole con separador de decimales punto (.)");
				texto.value="";				
			}
		}
	  }
	  
	  function soloNumerosCC(texto){
		var numero=texto;
		//alert(numero.indexOf("."));
		if (numero!="") {
			if (numero.indexOf(".")>-1) {
				var entero=numero.substring(0,numero.indexOf("."));
				var decimales=numero.substring(numero.indexOf(".")+1);
				if (!/^([0-9])*$/.test(entero) || !/^([0-9])*$/.test(decimales)) {
					alert("El valor " + numero + " no es un número. Y si trata de colocar decimales colocole con separador de decimales punto (.)");
					texto.value="";
					return 0;
				} else
					return 1;
			} else {
				if (!/^([0-9])*$/.test(numero)) {				
					alert("El valor " + numero + " no es un número. Y si trata de colocar decimales colocole con separador de decimales punto (.)");
					texto.value="";				
					return 0;
				} else
					return 1;
			}
		} /*else {
			alert("El valor " + numero + " no es un número. Y si trata de colocar decimales colocole con separador de decimales punto (.)");
			texto.value="";				
			return 0;			
		}*/		
	  }	  
	  
	  function guardar_edit() {
		  document.forms[0].submit();
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
	
function startTimer(tiempo) {
	duration=900; // 15 minutos
    var timer = tiempo*60*1;
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
				alert("Ahora, preione <b>aceptar</b> para pasara a la siguiente actividad...");
				guardar_encuesta_co();
			}		
		}, 1000);
	}
	
	function startTimer_hl(tiempo, prueba) {
		//tiempo=1;
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
			$("#time").html(minutes + ":" + seconds);

			if (--timer < 0) {
				timer = duration;
			}
			//alert(timer);
			if (tiemposec==-1) {
				if (prueba==6) {
					alert("El tiempo para su prueba ha sido culminado. Gracias por presentar !!!");
					guardar_encuesta_hl();
					//break;
				} else if (prueba<6) {
					alert("Ahora, preione <b>aceptar</b> para pasara a la siguiente actividad...");
					guardar_encuesta_hl();
				}
			}			
		}, 1000);
	}
	
	function startTimer_epa(tiempo, prueba) {
		//tiempo=1;
		duration=tiempo*60*1; // 15 minutos
		var timer = duration, minutes, seconds;
		var milisegundos=duration*1000;
		var tiemposec=duration;
		tiempo_epa = setInterval(function () {
			tiemposec--;
			//alert(duration);
			minutes = parseInt(timer / 60, 10);
			seconds = parseInt(timer % 60, 10);			
			
			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;
			//alert(minutes + ":" + seconds);
			$("#time").html(minutes + ":" + seconds);

			if (--timer < 0) {
				timer = duration;
			}
			//alert(timer);
			if (tiemposec==-1) {
				if (prueba==6) {
					alert("El tiempo para su prueba ha sido culminado. Gracias por presentar !!!");
					guardar_encuesta_co();
					//break;
				} else if (prueba<6) {
					alert("Ahora, preione <b>aceptar</b> para pasara a la siguiente actividad...");
					guardar_encuesta_co();
				}
			}			
		}, 1000);
	}	
	
	function startTimer_op(tiempo, pruebas_presentadas,prueba) {
		//tiempo=1;
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
					alert("Ahora, preione <b>aceptar</b> para pasara a la siguiente actividad...");
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
	
	function ver_encuesta_hl_cc(tiempo, prueba) {
		//nro_prueba=prueba;		
		document.getElementById("instrucciones").style.display="none";
		document.getElementById("encuesta").style.display="inline";
		startTimer_hl(tiempo, prueba);
	}
	
	function ver_encuesta_epa(tiempo, prueba) {
		//nro_prueba=prueba;		
		document.getElementById("instrucciones").style.display="none";
		document.getElementById("encuesta").style.display="inline";
		startTimer_epa(tiempo, prueba);
	}		
	
	function ver_encuesta_sl_cc(tiempo, prueba) {
		//nro_prueba=prueba;		
		document.getElementById("instrucciones").style.display="none";
		document.getElementById("encuesta").style.display="inline";
		startTimer_hl(tiempo, prueba);
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
			document.getElementById("instrucciones").style.display="none";
			document.getElementById("encuesta").style.display="inline";
			startTimer_op(tiempo, pruebas_presentadas,prueba);
		} else
			location.href="../prueba_op/encuesta_5_1_1-"+id_au;
	}	
	
	function guardar_encuesta_hl_ejemplo() {
		id_bateria=document.forms[0].bateria.value;
		//alert(proxima_pagina);
		window.location.replace("../prueba_hi_resto/"+proxima_pagina+"-"+id_au_ejemplo+"-"+id_bateria);
		//location.href="../prueba_hi_resto/"+proxima_pagina+"-"+id_au_ejemplo+"-"+id_bateria;
	}

	function guardar_encuesta_hl() {
		clearInterval(tiempo_hi);
		id_bateria=document.forms[0].bateria.value;
		id_au=document.forms[0].id_au.value;
		if (nro_prueba<3) {
			location.href="../prueba_hi_resto/"+proxima_pagina+"-"+id_au+"-"+id_bateria;
		} else if (nro_prueba==3) {
			// GUARDANDO PRUEBA DE COORDINACION
			resultado="";
			for (i=1; i<preguntas; i++) {
				var f=eval("document.forma"+i);
				var id_pregunta=0;					
				for (j=0; j<f.length; j++) {					
					//alert(f.elements[1].name);
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
						//alert(resultado);
					}
				}
				resultado=resultado+"..";
			}
			location.href="../index_guardar_prueba_coordinacion_1?resultado="+resultado+"&id_au="+id_au+"&proxima_pagina="+proxima_pagina+"&id_bateria="+id_bateria;
		} else if (nro_prueba==4) {
			// GUARDANDO PRUEBA DE HABILIDADES INTELECTIVAS
			resultado=0;			
			for (i=1; i<preguntas; i++) {
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
			location.href="../index_guardar_prueba_intelectivas?resultado="+resultado+"&id_au="+id_au+"&proxima_pagina="+proxima_pagina+"&id_bateria="+id_bateria;	
		} else if (nro_prueba==5) {
			// GUARDANDO PRUEBA DE INVENTARIO PERSONAL
			resultado="";
			for (i=1; i<preguntas; i++) {
				var f=eval("document.forma"+i);
				for (j=0; j<f.length; j++) {
					if (f.elements[j].name.indexOf("op_3_3")>-1) {
						if (f.elements[j].name.indexOf("mas_")>-1 && f.elements[j].checked==true) {
							//alert("mas="+f.elements[j].value+"...checked="+f.elements[j].checked);
							opcion=f.elements[j].value.substr(4);
							resultado+=opcion+"1,";
						} else if (f.elements[j].name.indexOf("menos_")>-1 && f.elements[j].checked==true) {
							//alert("menos="+f.elements[j].value+"...checked="+f.elements[j].checked);
							opcion=f.elements[j].value.substr(6);
							resultado+=opcion+"0,";
						}
					}
				}
			}
			location.href="../index_guardar_prueba_personal?proxima_pagina="+proxima_pagina+"&id_bateria="+id_bateria+"&resultado="+resultado+"&id_au="+id_au;
		} else if (nro_prueba==6) {
			// GUARDANDO PRUEBA DE COMPETENCIAS			
			arreglo_resultado=new Array();
			var indice=0;
			for (i=1; i<preguntas; i++) {
				var f=eval("document.forma"+i);
				
				for (j=0; j<f.length; j++) {
					if (f.elements[j].name.indexOf("op_")>-1) {
						if (f.elements[j].checked==true) {
							valor=f.elements[j].value;
							opcion=f.elements[j].name.substr(3);
							arreglo_resultado[indice]=opcion+"."+valor;
							indice++;
						}
					}
				}
			}
			var j=1;
			var num=1;
			resultado="?resultado1=";
			for (var i=0; i < arreglo_resultado.length; i++) {
				if (j==11) {
					num++;
					j=1;
					resultado+="&resultado"+num+"=";
				} else {
					resultado+=arreglo_resultado[i]+",";
				}				
				j++;
			}

			//alert(resultado);
			location.href="../index_guardar_prueba_competencias"+resultado+"&id_au="+id_au+"&proxima_pagina="+proxima_pagina+"&id_bateria="+id_bateria;	
		}
	}
	
	function escribir(numero) {
		//alert(pregunta_actual_co);
		if (pregunta_actual_co==1 && URLactual.toString().indexOf("prueba_op/encuesta_5_1_1")>-1)
			pregunta_actual_co=81;
		else if (pregunta_actual_co==1 && URLactual.toString().indexOf("prueba_op/encuesta_5_1_2")>-1)
			pregunta_actual_co=84;	
		else if (pregunta_actual_co==1)
			pregunta_actual_co=93;
		$("#ap_"+pregunta_actual_co).val($("#ap_"+pregunta_actual_co).val()+numero);
		//$("#ap_"+pregunta_actual_co).append(numero);
		//alert("ap_"+pregunta_actual_co+"..."+$("#ap_"+pregunta_actual_co).val());
	}	
	
	function guardar_encuesta_op(prueba) {
		clearInterval(tiempo_op);
		var id_au;
		var ruta="";
		id_au=document.forms[0].id_au.value;
		if (prueba==3 && pregunta_actual_co>92) {
			// GUARDANDO AGUDEZA PERCEPTIVA
			preguntas=107;
			resultado="";
			/*for (i=93; i<preguntas; i++) {
				var f=eval("document.forma"+i);
				var id_pregunta=0;
				if (f.elements[0].name.indexOf("ap_")>-1)
					valor=f.elements[0].value;
				else
					valor=0;			
				id_pregunta=f.elements[0].name.substr(3);
				resultado+=id_pregunta+"."+valor+"..";
			}*/
			document.forms[0].submit();
		} else if (prueba==1 && pregunta_actual_co==83) {
			ruta="../prueba_op/encuesta_5_1_2-"+id_au;
			document.forms[0].submit();
		} else if (prueba==2 && pregunta_actual_co>83) {		
			ruta="../prueba_op/encuesta_5_1_3-"+id_au;
			document.forms[0].submit();
		} else if (prueba==4) {
			// GUARDANDO RAZONAMIENTO ANALOGICO
			document.forms[0].submit();
		} else if (prueba==5) {
			// GUARDANDO IEP
			document.forms[0].submit();
		}
		return;
	}
	
	function verificar_forma(prueba, pregunta, respuesta) {
		nro_prueba_co=prueba;
		pregunta_actual_co=pregunta;
	}
	
	function guardar_encuesta_co() {
		var id_au;
		id_au=document.forms[0].id_au.value;
		bateria=document.forms[0].bateria.value;
		preguntas=cantidad;
		resultado="";
		clearInterval(tiempo_epa);
		//alert(nro_prueba);
		if (nro_prueba==2) {
			// GUARDANDO PRUEBA DE TCO
			for (i=1; i<61; i++) {
				var f=eval("document.forma_1_"+i);
				for (j=0; j<f.length; j++) {
					valor=f.elements[j].value;
					id_pregunta=f.elements[j].name.substr(6);
					if (valor=="")
						valor=0;
					resultado+=id_pregunta+"-"+valor+",";
				}
			}
			location.href="../index_guardar_prueba_co?proxima_pagina="+proxima_pagina+"&id_bateria="+bateria+"&resultado="+resultado+"&id_au="+id_au;
		} else if (nro_prueba==3) {
			// GUARDANDO PRUEBA DE RA
			resultado="";
			for (i=1; i<respuesta_ra.length; i++) {
				if (typeof respuesta_ra[i] !== 'undefined')
					resultado+=i+"-"+respuesta_ra[i]+",";
			}
			location.href="../index_guardar_prueba_ra?proxima_pagina="+proxima_pagina+"&id_bateria="+bateria+"&resultado="+resultado+"&id_au="+id_au;
		} else if (nro_prueba==4) {
			// GUARDANDO PRUEBA DE RV
			resultado="";
			//alert(respuesta_rv.length);
			for (i=1; i<respuesta_rv.length; i++) {
				if (typeof respuesta_rv[i] !== 'undefined')
					resultado+=i+"-"+respuesta_rv[i]+",";
			}
			//alert(resultado);
			location.href="../index_guardar_prueba_rv?proxima_pagina="+proxima_pagina+"&id_bateria="+bateria+"&resultado="+resultado+"&id_au="+id_au;
		} else if (nro_prueba==5) {
			// GUARDANDO PRUEBA DE HN
			resultado="";
			for (i=1; i<respuesta_hn.length; i++) {
				if (typeof respuesta_hn[i] !== 'undefined')
					resultado+=i+"-"+respuesta_hn[i]+",";
			}
			//alert(resultado);
			location.href="../index_guardar_prueba_hn?proxima_pagina="+proxima_pagina+"&id_bateria="+bateria+"&resultado="+resultado+"&id_au="+id_au;
		} else if (nro_prueba==6) {
			// GUARDANDO PRUEBA DE IEP + y -
			var resultado_mas="";
			var resultado_menos="";
			for (i=1; i<respuesta_iep_mas.length; i++) {
				if (typeof respuesta_iep_mas[i] !== 'undefined')
					resultado_mas+=i+"-"+respuesta_iep_mas[i]+",";
			}
			resultado+="menos=";			
			for (i=1; i<respuesta_iep_menos.length; i++) {
				if (typeof respuesta_iep_menos[i] !== 'undefined')
					resultado_menos+=i+"-"+respuesta_iep_menos[i]+",";
			}			
			//alert(resultado);
			location.href="../index_guardar_prueba_iep?proxima_pagina="+proxima_pagina+"&id_bateria="+bateria+"&resultado_mas="+resultado_mas+"&resultado_menos="+resultado_menos+"&id_au="+id_au;
		} else {
			/*id_pregunta_co++;
			document.getElementById("encuesta_"+nro_prueba_co).style.display="none";
			nro_prueba_co++;
			document.getElementById("instrucciones_"+nro_prueba_co).style.display="inline";*/
			//alert(proxima_pagina);
			id_bateria=document.forms[0].bateria.value;
			location.href="../prueba_epa_resto/"+proxima_pagina+"-"+id_au+"-"+id_bateria;
			//startTimer_co(10, (nro_prueba_co-1), nro_prueba_co);
		}
	}
	
	function guardar_participante() {
		id_au=document.forms[0].id_au.value;
		id_bateria=document.forms[0].bateria.value;
		
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
				document.getElementById("datos_participante").style.display="none";
				var URLactual = window.location;
				//alert(URLactual);
				if (URLactual.toString().indexOf("prueba_hi")>-1)
					location.href="../prueba_hi_ejemplo/"+id_au+"-"+id_bateria;
				else if (URLactual.toString().indexOf("prueba_sl")>-1)
					location.href="../prueba_sl_ejemplo/"+id_au+"-"+id_bateria;
				else if (URLactual.toString().indexOf("prueba_epa")>-1)
					location.href="../prueba_epa_ejemplo/"+id_au+"-"+id_bateria;
				else
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
	
	function ver_encuesta(tipo, tiempo) {
		var f=eval("document.forms[0]")
		if ((f.apellidos.value=="" || f.nombres.value=="" || f.email.value=="" || f.cedula.value=="") && tipo=='iol')
			alert("Debe llenar todos los campos del candidato !!")
		else {
			document.getElementById("encuesta").style.display="inline";
			document.getElementById("instrucciones").style.display="none";
			document.getElementById("participante").style.display="none";
			startTimer(tiempo);
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
	
	function colocar_respuesta_ejemplo(tipo, antes, despues) {
		if (tipo=="rv") {
			if (antes=="relincho") {
				$("#boton_prueba").css("display","inline");
				$("#antes").html("<strong>"+antes+"</strong>");
				$("#despues").html("<strong>"+despues+" (<span style='color: blue;'>CORRECTO</span>)</strong>");
			} else {
				$("#boton_prueba").css("display","none");
				$("#antes").html("<strong>"+antes+"</strong>");
				$("#despues").html("<strong>"+despues+" (<span style='color: red;'>INCORRECTO</span>)</strong>");
			}
		} else if (tipo=="hn") {
			if (antes=="1,5300") {
				$("#boton_prueba").css("display","inline");
				var resp="<table border=0 width='100%'><tr><td width=50%><img src='../imagenes/imagenesEPA/HN/pregunta1.jpg'></td><td style='border: solid 2px; border-color: red;' width=50%'></td></tr></table>";
				$("#respuesta").html("<table border=0 width='100%'><tr><td width=50%><img src='../imagenes/imagenesEPA/HN/pregunta1.jpg'></td><td align='center' style='border: solid 2px; border-color: red;' width=50%'><strong>"+antes+" <br>(<span style='color: blue;'>CORRECTO</span>)</strong></td></tr></table>");
			} else {
				$("#boton_prueba").css("display","none");
				$("#respuesta").html("<table border=0 width='100%'><tr><td width=50%><img src='../imagenes/imagenesEPA/HN/pregunta1.jpg'></td><td align='center' style='border: solid 2px; border-color: red;' width=50%'><strong>"+antes+" <br>(<span style='color: red;'>INCORRECTO</span>)</strong></td></tr></table>");
			}
		} else if ((tipo=="iep_mas") || (tipo=="iep_menos")) {
			if (tipo=="iep_mas") {
				if (mas==0)
					mas=antes;
				if (menos!=antes)
					mas=antes;
				else {
					mas=0;
					alert("No puede seleccionar esta opcion");
					$('input[type="radio"]').prop('checked' , false);
				}
			} else {
				if (menos==0)
					menos=antes;
				if (mas!=antes)
					menos=antes;
				else {
					menos=0;
					alert("No puede seleccionar esta opcion");
					respuesta_iep_menos=new Array();
					$('input[type="radio"]').prop('checked' , false);
				}
			}
			
			if (menos>0 && menos>0)
				$("#boton_prueba").css("display","inline");
			else
				$("#boton_prueba").css("display","none");
		}
	}	
	
	function colocar_respuesta(tipo, antes, despues, preguntas, opciones, respuesta,imagen) {
		var texto=$("#respuesta_"+preguntas).html();
		if (tipo=="rv") {
			$("#antes_"+preguntas).html("<strong>"+antes+"</strong>");
			$("#despues_"+preguntas).html("<strong>"+despues+"</strong>");
			ver_respuesta(preguntas,opciones,0);
		} else if (tipo=="hn") {
			var resp="<table border=0 width='100%'><tr><td width=50%><img src='../imagenes/imagenesEPA/HN/"+imagen+"'></td><td style='border: solid 2px; border-color: red;' width=50%'></td></tr></table>";
			$("#respuesta_"+preguntas).html("<table border=0 width='100%'><tr><td width=50%><img src='../imagenes/imagenesEPA/HN/"+imagen+"'></td></tr><td><td align='center' style='border: solid 2px; border-color: red;' width=50%'><strong>"+antes+"</strong></td></tr></table>");
			ver_respuesta(preguntas,opciones,0);
		} else {
			if ((tipo=="iep_mas") || (tipo=="iep_menos")) {
				if (tipo=="iep_mas") {
					if (mas==0)
						mas=opciones;
					if (menos!=opciones)
						mas=opciones;
					else {
						mas=0;
						alert("No puede seleccionar esta opcion");
						$('input[type="radio"]').prop('checked' , false);
					}
				} else {
					if (menos==0)
						menos=opciones;
					if (mas!=opciones)
						menos=opciones;
					else {
						menos=0;
						alert("No puede seleccionar esta opcion");
						respuesta_iep_menos=new Array();
						$('input[type="radio"]').prop('checked' , false);
					}
				}
				ver_respuesta(preguntas,opciones,tipo);
			} else
				ver_respuesta(preguntas,opciones,0);
		}
	}
	
	function ver_respuesta(preguntas,opciones,tipo) {
		if (tipo==0) {
			respuesta_rv[preguntas]=opciones;
			respuesta_hn[preguntas]=opciones;
		} else {
			if (tipo=="iep_mas") {
				respuesta_iep_mas[preguntas]=opciones;
			} else if (tipo=="iep_menos") {
				respuesta_iep_menos[preguntas]=opciones;
			}
		}
	}
	
	function colocar(opcion,preguntas) {
		if (opcion.indexOf("imagenes")>-1)
			$("#respuesta_"+preguntas).html("<img src='../"+opcion+"' border=0 height='35' width='35'>");
		else
			$("#respuesta_"+preguntas).html("<strong>"+opcion+"</strong>");
	}
	
	function colocar_test_phi(solucion, opcion, valor, prueba, key) {
		tocar_ejemplo++;
		//res_".$key
		var opciones = new Array;

		opciones[1]='(Menos del 10%  de las veces)';
		opciones[2]='(Entre el 10%  y el 29% de las veces)';
		opciones[3]='(Entre el 30%  y el 49% de las veces)';
		opciones[4]='(Entre el 50 %  y el 69% de las veces)';
		opciones[5]='(Entre el 70%  y el 90% de las veces)';
		opciones[6]='(Más del 90%  de las veces)';
		
		if (tocar_ejemplo==1) {
			document.getElementById("boton_prueba").style.display = "inline";
			tocar_ejemplo=0;
			$("#res_"+key).html("<strong>"+opciones[key]+"</strong>");
		}	
	}
	
	function colocar_test(solucion, opcion, valor, prueba, nombre) {
		respuesta="";
		especificacion="";
		if (prueba==3) {
			if (solucion==1) {
				respuesta="<span style='color: blue'>Correcta</span>";
				especificacion="<span style='color: blue'>La alternativa correcta es “oler” dado que se plantea determinar la principal función sensorial de la nariz.</span>";
				document.getElementById("boton_prueba").style.display = "inline";
			} else {
				respuesta="<span style='color: red'>Incorrecta</span>";
				especificacion="";
				document.getElementById("boton_prueba").style.display = "none";
			}
			$("#respuesta").html("<h4><strong>"+opcion+" ("+respuesta+")</strong></h4>");
			$("#especificacion").html("<h4><strong>"+especificacion+"</strong></h4>");
		} else if (prueba==4) {
			tocar_ejemplo++;
			if (tocar_ejemplo==2) {
				document.getElementById("boton_prueba").style.display = "inline";
				tocar_ejemplo=0;
			}
		} else if (prueba==5) {
			tocar_ejemplo++;
			if (tocar_ejemplo==1) {
				document.getElementById("boton_prueba").style.display = "inline";
				tocar_ejemplo=0;
			}
		}		
		//
	}
	
	
	function mirar_texto () {
		var f=eval("document.forms[0]");		
		//f.texto.value=document.getElementById('noise').value;
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
		$("[tabindex='" + (tabindex) + "']").val(id);
		
		if (nro_prueba==0) {			
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
			return false;
		} else
			return false;
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
		//alert(pregunta_actual_co);
		if ($("#coord_"+pregunta_actual_co).val()==respuesta_actual_co[pregunta_actual_co]) {
			//alert(pregunta_actual_co);
			id_bateria=document.forms[0].bateria.value;
			location.href="../prueba_epa_resto/"+proxima_pagina+"-"+id_au_ejemplo+"-"+id_bateria;
		} else {
			alert("Para pasar a la siguiente debe colocar la opcion correcta");
			//break;
		}
	}
	
	function ver_imagen_ejemplo(cantidad,numero) {		
		$("#img_respuesta").html("<img src='../imagenes/imagenesEPA/RA/"+cantidad+"-"+numero+".jpg'>");
		if (numero==7)
			$("#boton_prueba").css("display","inline");
		else
			$("#boton_prueba").css("display","none");
	}	
	
	function ver_imagen(cantidad,numero) {
		$("#img_respuesta_"+cantidad).html("<img src='../imagenes/imagenesEPA/RA/"+cantidad+"-"+numero+".jpg'>");
		respuesta_ra[indice_ra]=numero;
	}
	
	function nada() {		
		var evt = evt || window.event;
		alert(evt.keyCode);
	}
	
	function prox_pagina() {
		var f=eval("document.forms[0]");
		f.submit();
	}