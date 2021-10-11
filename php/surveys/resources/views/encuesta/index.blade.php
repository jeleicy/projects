@include('layout.header')

    <div class="container">
    {!! Form::open(array('url' => 'guardar_encuesta', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="id_au" value="<?=$id_au?>"
        <div class="row">
            <div class="col-lg-15 text-center">
                <h1>IOL (Inventario de Orientacion Laboral)</h1>
                <p class="lead">PARTICIPANTE:</p>
				
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Nombres <span class="msj">(*)</span>:</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="nombres" name="nombres" type="text" data-validate-length-range="2" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="<?=$nombres?>">
					</div>
				</div>				
				
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Apellidos <span class="msj">(*)</span>:</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="apellidos" name="apellidos" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Apellidos" value="">
					</div>
				</div>	

				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Cedula <span class="msj">(*)</span>:</label>
					<div class="col-md-2">
						<input onKeyPress="return soloNumeros(event)" id="cedula" name="cedula" maxlength="8" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Cedula" value="">
					</div>
				</div>					
				
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo <span class="msj">(*)</span>:</label>
					<div class="col-md-2">
						<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
							<input class="btn btn-success" type="radio" name="sexo" value="f"> &nbsp; Femenino &nbsp;
							<input class="btn btn-info" type="radio" name="sexo" value="m" checked=""> Masculino
						</label>
					</div>						
				</div>
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="msj">(*)</span>:</label>
					<div class="col-md-2">
						<input readonly id="email" name="email" type="email" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Email" value="<?=$email?>">
					</div>
				</div>	
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Nacionalidad <span class="msj">(*)</span>:</label>
					<div class="col-md-2">
						<select id="nacionalidad" name="nacionalidad" class="form-control" name="nacionalidad">
							<option value='Argentina'>Argentina</option>
							<option value='Bahamas'>Bahamas</option>
							<option value='Barbados'>Barbados</option>
							<option value='Belice'>Belice</option>
							<option value='Bolivia'>Bolivia</option>
							<option value='Brasil'>Brasil</option>
							<option value='Canada'>Canada</option>
							<option value='Colombia'>Colombia </option>
							<option value='Costa Rica'>Costa Rica</option>
							<option value='Cuba'>Cuba</option>
							<option value='Chile'>Chile</option>
							<option value='Dominica'>Dominica</option>
							<option value='Ecuador'>Ecuador</option>
							<option value='El Salvador'>El Salvador</option>
							<option value='Estados Unidos'>Estados Unidos</option>
							<option value='Granada'>Granada</option>
							<option value='Guatemala'>Guatemala</option>
							<option value='Guyana'>Guyana</option>
							<option value='Haiti'>Haiti</option>
							<option value='Honduras'>Honduras</option>
							<option value='Jamaica'>Jamaica</option>
							<option value='Mexico'>Mexico</option>
							<option value='Nicaragua'>Nicaragua</option>
							<option value='Panama'>Panama</option>
							<option value='Paraguay'>Paraguay</option>
							<option value='Peru'>Peru</option>
							<option value='Republica Dominicana'>Republica dominicana </option>
							<option value='San Cristabal y Nieves'>San Cristabal y Nieves</option>
							<option value='San Vicente y las Granadinas'>San Vicente y las Granadinas </option>
							<option value='Santa Lucia'>Santa Lucia </option>
							<option value='Surinam'>Surinam</option>
							<option value='Trinidad y Tobago'>Trinidad y Tobago </option>
							<option value='Uruguay'>Uruguay</option>
							<option value='Venezuela'>Venezuela</option>						
							<option value='Otro'>Otro</option>
						</select>
					</div>
				</div>	
								
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Edad <span class="msj">(*)</span>:</label>
					<div class="col-md-2">
						<input onKeyPress="return soloNumeros(event)" id="edad" maxlength="2" name="edad" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Edad" value="">
					</div>
				</div>		
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Nivel de Formacion Academica:<span class="msj">(*)</span>:</label>
					<div class="col-md-2">
						<select id="nivel_formacion" name="nivel_formacion" class="form-control" name="nacionalidad">
							<option value='Basica'>Basica</option>
							<option value='Bachiller'>Bachiller</option>
							<option value='TSU'>TSU</option>
							<option value='Universitaria no Completa'>Universitaria no Completa</option>
							<option value='Universitaria Completa'>Universitaria Completa</option>
							<option value='Postgrado'>Postgrado</option>
							<option value='Master'>Master</option>
						</select>
					</div>
				</div>
				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Area de Especialidad: <span class="msj">(*)</span>:</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="orientacion_area" name="orientacion_area" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Area de Especialidad" value="">
					</div>
				</div>					

				<div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Cargo que ocupa / aspira: <span class="msj">(*)</span>:</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="orientacion_cargo" name="orientacion_cargo" type="text" data-validate-length-range="2" data-validate-words="1" class="form-control" placeholder="Cargo que ocupa / aspira" value="">
					</div>
				</div>	
				<div class="clearfix"></div>
				<div id="boton_2" align="center" style="display:none">
					<input onclick="guardar_encuesta_2()" type="button" class="btn btn-primary" value="Guardar Encuesta">
				</div>
            </div>
			
			<div id="instrucciones" align="center" class="col-lg-10 text-left" style=" margin:50px;font-size: 11pt; border-style: solid; border-color: #1abb9c; padding:10px; color: #1abb9c">
				<h2>INSTRUCCIONES:</h2><br />
				<hr />
				<ul>
					<li>A continuación encontrará 30 recuadros con 4 rasgos en cada uno de ellos.</li>
					<li>Identifique el rasgo en cada recuadro que más (mejor) lo describe y el que menos
					(peor) lo describe basado en su realidad  laboral cotidiana.</li>
					<li>Marque en cada recuadro, según el análisis efectuado, una “X” en la columna MÁS y 
					 otra “X” en la columna MENOS.         Vea el Caso Ilustrativo a su derecha.</li>
				</ul>
				<strong>En este Inventario NO hay respuestas buenas o malas. Responda todos los recuadros 
				con la mayor rapidez y cuidado que le sea posible. Si busca mostrarse como alguien</strong>
				
				<br /><br /><img src="{{ URL::asset('imagenes/demo.jpg') }}" border="2" align="center" /><br />
				Para presentar la prueba ud deberá:
				<ul>
					<li>Deberá esoger una opcion y para pasar a la siguiente, debera presionar la opcion <img src="{{ URL::asset('imagenes/proximo.jpg') }}">.</li>
					<li>Si desea regresar a una pregunta anterior solo presione el numero correspondiente a la pregunnta o <img src="{{ URL::asset('imagenes/anterior.jpg') }}">.</li>
					<li>Hasta no haber completado sus 30 preguntas no podra pasar a la siguiente.</li>
					<li>Al finalizar presione <img src="{{ URL::asset('imagenes/guardar.jpg') }}"></li>
				</ul>
				<div align="center">
					<input onclick="ver_encuesta()" type="button" class="btn btn-primary" value="Si ya leyo las instrucciones, y esta seguro de comenzar, por favor comience la prueba">
				</div>
			</div>			
		</div>

		{!! Form::close() !!}
	</div>	
		<div id="encuesta" class="col-md-11" style="background: #fff; margin:50px; display: none;">
			<strong><h1 style="color: #1abb9c; texty-align: center">Comienza Encuesta IOL</h1></strong>
			@include('encuesta.preguntas')
		</div>
		<br /><br /><br />
		
        <!-- /.row -->

	
@include('layout.footer')