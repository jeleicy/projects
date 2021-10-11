var nro_prueba=0;
var preguntas=0;
var preg_ant=0;
var opciones=0;
var resultado=0;			
var nombre_ant="";
var opciones_array=[];
var j=0;
var mas=0;
var menos=0;
var array_preguntas=[];
var indice_array=0;

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
		if (f.apellidos.value=="" || f.nombres.value=="" || f.email.value=="" || f.cedula.value=="" || f.edad.value=="" || f.nivel_formacion.value=="" || f.orientacion_area.value=="" || f.orientacion_cargo.value=="")
			alert("Debe llenar todos los campos del candidato !!")
		else {
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
		if (f.apellidos.value=="" || f.nombres.value=="" || f.email.value=="" || f.cedula.value=="" || f.edad.value=="" || f.nivel_formacion.value=="" || f.orientacion_area.value=="" || f.orientacion_cargo.value=="")
			alert("Debe llenar todos los campos del candidato !!")
		else {
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
	}	
	
	function startTimer() {
		var duration=1200 * 1;
		var timer = duration, minutes, seconds;
		var milisegundos=duration*1000;
		setTimeout(function () {
			minutes = parseInt(timer / 60, 10);
			seconds = parseInt(timer % 60, 10);

			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			$('#time').text(minutes + ":" + seconds);

			if (--timer < 0) {
				timer = duration;
			}
			
			if (timer==60) {
				alert("El tiempo para su prueba ha sido culminado. Gracias por presentar !!!");
				document.getElementById("encuesta").style.display="none";
				//document.getElementById("boton_2").style.display="inline";
				guardar_encuesta();
				return;
			}
		}, milisegundos);
	}	
	
	function startTimer_hl(tiempo, pruebas_presentadas) {
		//tiempo=0.1;
		var duration= tiempo*60*1;
		var timer = duration, minutes, seconds;
		var milisegundos=duration*1000;
		//alert(milisegundos);
		setTimeout(function () {
			/*minutes = parseInt(timer / 60, 10);
			seconds = parseInt(timer % 60, 10);

			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			$('#time').text(minutes + ":" + seconds);

			if (--timer < 0) {
				timer = duration;
			}*/
			
			if (nro_prueba==4) {
				alert("El tiempo para su prueba ha sido culminado. Gracias por presentar !!!");
				//$("#datos_prueba").html('<strong><h1 style="color: #1abb9c; texty-align: center">Gracias por presentar nuestras pruebas.</h1></strong>');
				pruebas_presentadas++;
				for (i=pruebas_presentadas; i<5; i++)
					document.getElementById("encuesta_"+i).style.display="none";
				guardar_encuesta_hl();
			} else if (nro_prueba<4) {
				alert("Detengase ahora pasara a la siguiente prueba...");
				guardar_encuesta_hl();
			}
		}, milisegundos);
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
		startTimer_hl(tiempo, pruebas_presentadas);
	}

	function guardar_encuesta_hl() {
		var id_au;
		id_au=document.forms[0].id_au.value;
		if (nro_prueba==1) {
			for (i=1; i<5; i++)
				document.getElementById("encuesta_"+i).style.display="none";
			for (i=1; i<5; i++)
				document.getElementById("instrucciones_"+i).style.display="none";				
			
			nro_prueba++;
			document.getElementById("instrucciones_"+nro_prueba).style.display="inline";		
		} else if (nro_prueba==2) {
			// GUARDANDO PRUEBA DE COORDINACION
			preguntas=18;
			resultado=0;
			for (i=1; i<preguntas; i++) {
				var f=eval("document.forma"+i);
				for (j=0; j<f.length; j++) {
					if (f.elements[j].name.indexOf("coord_")>-1) {
						//coord_01_01
						nombre=f.elements[j].name;
						id_pregunta=nombre.substr(6,2);
						nombre=nombre.substr(nombre.indexOf("_")+1);
						nombre=nombre.substr(nombre.indexOf("_")+1);
						posicion=nombre;
						if (f.elements[j].value!="")
							valor=f.elements[j].value;
						else
							valor=0;
						resultado+=id_pregunta+"."+posicion+"."+valor+"..";
					}
				}
			}

			// ************ AJAX ***************
			//alert("index_guardar_prueba_coordinacion?resultado="+resultado+"&id_au="+id_au);
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
			preg_ant=preguntas;
			preg_ant++;
			preguntas+=30;	
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
			//alert(resultado);
			//alert("index_guardar_prueba_coordinacion?resultado="+resultado+"&id_au="+id_au);
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
				
			if (nro_prueba==1)
				document.getElementById("instrucciones_"+(nro_prueba)).style.display="none";
			else
				for (i=1; i<5; i++)
					document.getElementById("instrucciones_"+i).style.display="none";			
						
			nro_prueba++;
			document.getElementById("instrucciones_"+nro_prueba).style.display="inline";			
		} else if (nro_prueba==4) {
			// GUARDANDO PRUEBA DE INVENTARIO PERSONAL
			preg_ant=preguntas;
			preg_ant++;
			preguntas+=48;
			resultado="";
			//alert("preg_ant="+preg_ant+"...preguntas="+preguntas);
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
			//alert(resultado);
			//$("#datos_prueba").html(resultado);
			//return;
			//$("#datos_prueba").html("index_guardar_prueba_personal?resultado="+resultado+"&id_au="+id_au);
			//return;
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
					//$("#datos_prueba").html('<strong><h1 style="color: #1abb9c; texty-align: center">Gracias por presentar nuestras pruebas.</h1></strong>');
					for (i=1; i<5; i++)
						document.getElementById("encuesta_"+i).style.display="none";
					//document.getElementById("boton_2").style.display="inline";				
				}
			});
			
			var parametros = {
				"id_au" : id_au,
				"_token": $('input[name=_token]').val()
			};
			$.ajax({
				data:  parametros,
				url:   '../index_generar_resultado',
				type:  'post',
				beforeSend: function () {
					$("#datos_prueba").html("....Procesando, espere por favor");
				},
				success:  function (data) {
					$("#datos_prueba").html('<strong><h1 style="color: #1abb9c; texty-align: center">Gracias por presentar nuestras pruebas.</h1></strong>'+"<br /><br />"+data.resultado);
				}
			});
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
	
	function ver_encuesta(tiempo) {
		document.getElementById("encuesta").style.display="inline";
		document.getElementById("instrucciones").style.display="none";
		startTimer();
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

$(document).ready(function(){
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
	 
	 $("#id_tipo_prueba_invitacion").change(function () {
		 alert($("#id_tipo_prueba_invitacion").val());
		 if (pruebas_disponibles_array[0]==0) {
			 $("#disponibles").html("* Ud. no posee pruebas para asignar");
			 $("#boton_invitar").css("display","none");
			 $("#invitaciones").css("display","none");
		 } else if (pruebas_disponibles_array[$(this).val()]==0) {
			 $("#disponibles").html("* Ud. no posee pruebas para asignar");
			 $("#boton_invitar").css("display","none");
			 $("#invitaciones").css("display","none");
		 } else {
			 var prueba_invitacion=0;
			 //alert($("#id_tipo_prueba_invitacion").val());
			 if ($("#id_tipo_prueba_invitacion").val()==2)
				 prueba_invitacion=2;
			 else
				 prueba_invitacion=1;
			$("#disponibles").html("* Ud. posee un maximo de: "+pruebas_disponibles_array[$(this).val()]+" pruebas a asignar");	 
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
	
	function mirar_texto () {
		var f=eval("document.forms[0]");		
		f.texto.value=document.getElementById('noise').value;
		f.submit();
	}