<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Redirect;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\EncuestaControllers;
use URL;
use PDF;

?>

@include('layout.header')

    <!-- jQuery -->
    <script src="../bp/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../js/funciones_genericas.js"></script>

    {!! Form::open(array('url' => 'buscar_estadistica', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<!--
			tipo de prueba
			por empresa (campo adicional)
			fecha desde hasta (presentacion)
			pais (campo adicional)
			nivel organozacional (campo adicional)
			cargo aspira (campo adicional)
			rol (campo adicional)
			edad		
		-->
	
		<br /><br /><br />
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bateria <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">		
				<select id="id_bateria" name="id_bateria" class="form-control" >
					<option value="0">Seleccione...</option>
					{{ FuncionesControllers::crear_combo("bateria",$id_bateria) }}
				</select>
			</div>
		</div>
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Empresa <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">		
				<select id="id_empresa" name="id_empresa" class="form-control" >
					<option value="0">Seleccione...</option>
					{{ FuncionesControllers::crear_combo("empresas",$id_empresa) }}
				</select>
			</div>
		</div>	
		
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Pais:</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input id="pais" name="pais" type="pais" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Pais" value="{{ $pais }}">
			</div>
		</div>
		
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Nivel Organizacional:</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input id="nivelorganizacional" name="nivelorganizacional" type="nivelorganizacional" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Nivel Organizacional" value="{{ $nivelorganizacional }}">
			</div>
		</div>		
		
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Cargo Aspira:</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input id="cargoaspira" name="cargoaspira" type="cargoaspira" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Cargo Aspira" value="{{ $cargoaspira }}">
			</div>
		</div>	

		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Rol:</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input id="rol" name="rol" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Rol" value="{{ $rol }}">
			</div>
		</div>	

		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Edad:</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input onKeyPress="return soloNumeros(event)" id="edad" maxlength="2" name="edad" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Edad" value="{{ $edad }}">
			</div>
		</div>
		
		<div class="clearfix"></div>

		<div id="boton_2" align="center">
			<input type="button" onclick="guardar()" class="btn btn-primary" value="Buscar">
		</div>
		
	{!! Form::close() !!}
	
	<!--
	  --"id_bateria" => "6"
	  "id_empresa" => "7"
	  "pais" => "venezuela"
	  "nivelorganizacional" => "ninguno"
	  "cargoaspira" => "otro"
	  "rol" => "juan"
	  "edad" => "15"
	-->
	
	<?php
		$sql = "select u.nombres as asesor, date(a.fecha) as fechaaplicacion ,
				c.*
				from candidatos c, autorizaciones a, usuarios u ";
				
			if ($pais!="" || $nivelorganizacional!="" || $cargoaspira!="" || $rol!="")
				$sql .= ", campos_candidatos ccan, contenidos_campos ccamp ";				
				
			$sql .= "where c.id_autorizacion=a.id and a.id_invitador=u.id ";
			
			if ($id_bateria!="" && $id_bateria!=0)
				$sql .= " and a.id_tipo_prueba=$id_bateria ";
			
			if ($id_empresa!="" && $id_empresa!=0)
				$sql .= " and a.id_empresas=$id_empresa ";
			
			if ($pais!="")
				$sql .= " and lower(ccan.nombre) like '%pais%' and ccan.id=ccamp.id_campos_candidatos and ccamp.texto='$pais' and ccamp.id_autorizaciones=a.id ";
				
			if ($nivelorganizacional!="")
				$sql .= " and lower(ccan.nombre) like '%nivel organizacional%' and ccan.id=ccamp.id_campos_candidatos and ccamp.texto='$nivelorganizacional' and ccamp.id_autorizaciones=a.id ";
				
			if ($cargoaspira!="")
				$sql .= " and lower(ccan.nombre) like '%cargo%' and ccan.id=ccamp.id_campos_candidatos and ccamp.texto='$cargoaspira' and ccamp.id_autorizaciones=a.id ";
				
			if ($rol!="")
				$sql .= " and lower(ccan.nombre) like '%rol%' and ccan.id=ccamp.id_campos_candidatos and ccamp.texto='$rol' and ccamp.id_autorizaciones=a.id ";
				
			if ($edad!="")
				$sql .= " and c.edad=$edad ";
				
			
		//echo $sql;
		$data=DB::select($sql);
	?>
	
            <table id="tabla_reportes" class="display" cellspacing="0" width="95%" align="center">
                <thead>
                    <tr>
						<th>Asesor</th>
						<th>Cedula</th>	
						<th>Participante</th>
						<th>Edad</th>
						<th>Sexo</th>	
						<th>Correo</th>	
						<th>Fecha de Aplicación</th>
						<th>RAZONAMIENTO ABSTRACTO<br />PB / Pentil / Categoría</th>		
						<th>RAZONAMIENTO VERBAL<br />PB / Pentil / Categoría</th>			
						<th>HABILIDAD NUMERICA<br />PB / Pentil / Categoría</th>			
						<th>CAPACIDAD ORGANIZATIVA<br />PB / PB-E / Pentil / Categoría</th>				
						<th>IPD<br />Pentil / Categoría</th>		
						<th>ORIENTACION AL CLIENTE<br />PB / Pentil / Categoría</th>			
						<th>RELACIONES<br />PB / Pentil / Categoría</th>			
						<th>RESPONSABILIDAD<br />PB / Pentil / Categoría</th>			
						<th>LOGRO<br />PB / Pentil / Categoría</th>			
						<th>IOE<br />Pentil / Categoría</th>		
						<th>CONSOLIDADO<br />Pentil / Categoría</th>
                    </tr>
                </thead>
				<tbody>
				<?php
					foreach ($data as $data) {
						if ($data->sexo=="f")
							$sexo="Femenino";
						else
							$sexo="Masculino";
						
						$datos_epa=EncuestaControllers::generar_resultados_epa($data->id_autorizacion);
						
						//print_r ($datos_epa);
						
						//echo "cantidad=".count($datos_epa);
						
						?>
							<tr>
								<td>{{ $data->asesor }}</td>
								<td>{{ $data->cedula }}</td>	
								<td>{{ $data->nombres }} {{ $data->apellidos }}</td>
								<td>{{ $data->edad }}</td>
								<td>{{ $sexo }}</td>	
								<td>{{ $data->email }}</td>	
								<td>{{ FuncionesControllers::fecha_normal($data->fechaaplicacion) }}</td>
								<td><?php echo $datos_epa["ra"]["pb"] . "/" .  $datos_epa["ra"]["pentil"] . "/" .  $datos_epa["ra"]["categoria"] ?></td>			
								<td><?php echo $datos_epa["rv"]["pb"] . "/" .  $datos_epa["rv"]["pentil"] . "/" .  $datos_epa["rv"]["categoria"] ?></td>			
								<td><?php echo $datos_epa["hn"]["pb"] . "/" .  $datos_epa["hn"]["pentil"] . "/" .  $datos_epa["hn"]["categoria"] ?></td>			
								<td><?php echo $datos_epa["co"]["pb"] . "/" .  $datos_epa["co"]["pe"] . "/" .  $datos_epa["co"]["pentil"] . "/" .  $datos_epa["co"]["categoria"] ?></td>				
								<td><?php echo $datos_epa["ipd"]["pentil"] . "/" .  $datos_epa["ipd"]["categoria"] ?></td>		
								<td><?php echo $datos_epa["oac"]["pb"] . "/" .  $datos_epa["oac"]["pentil"] . "/" .  $datos_epa["oac"]["categoria"] ?></td>			
								<td><?php echo $datos_epa["rel"]["pb"] . "/" .  $datos_epa["rel"]["pentil"] . "/" .  $datos_epa["rel"]["categoria"] ?></td>			
								<td><?php echo $datos_epa["res"]["pb"] . "/" .  $datos_epa["res"]["pentil"] . "/" .  $datos_epa["res"]["categoria"] ?></td>			
								<td><?php echo $datos_epa["log"]["pb"] . "/" .  $datos_epa["log"]["pentil"] . "/" .  $datos_epa["log"]["categoria"] ?></td>			
								<td><?php echo $datos_epa["ioe"]["pentil"] . "/" .  $datos_epa["ioe"]["categoria"] ?></td>
								<td><?php echo $datos_epa["cons"]["pentil"] . "/" .  $datos_epa["cons"]["categoria"] ?></td>
							</tr>							
						<?php
					}
				?>
				</tbody>
			</table>
				
@include('layout.footer')