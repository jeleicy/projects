<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\monedaControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\URL;

$sql = "select tabla_preguntas, tabla_opciones, nombre
		from tipos_pruebas 
		where id=$id";
$data = DB::select($sql);

foreach ($data as $data) {
	$tabla_preguntas=$data->tabla_preguntas;
	$tabla_opciones=$data->tabla_opciones;
	$nombre=$data->nombre;
}

?>

@include('layout.header')
    <!-- page content -->
		<br />
		<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>	
	
		<h2>Tipos de Pruebas: <strong>{{ $nombre }}</strong> </h2> <hr />
			
			<button style="width:200px; height: 50px; color:black; background:blue; font-size:25px; color:white; border-radius: 15px;" type="button" onclick="nueva_pregunta({{ $id }})" class="prueba1">Nueva Pregunta</button>
			<hr />
			<?php
					$sql = "select * from ".$tabla_preguntas." order by id_idioma, id";
					$data_preguntas = DB::select($sql);
					echo '<table class="table table-striped table-bordered table-hover" id="tabla_reportes">';
					echo '	<thead>
						<tr>
							<th align="center"><h4>Pregunta</h4></th>
							<th align="center"><h4>Idioma</h4></th>
							<th align="center">&nbsp;</th>
							<th align="center">&nbsp;</th>
						</tr>
						</thead><tbody>';
					foreach ($data_preguntas as $data_preguntas) {
						?>
						
						<tr>
							<td>{{ $data_preguntas->pregunta }}</td>
							<td>{{ FuncionesControllers::buscar_idioma($data_preguntas->id_idioma) }}</td>
							<td><a href="../editarpregunta/{{ $data_preguntas->id }}.{{ $id }}">Editar</a></td>
							<td><a href="../consultaropcion/{{ $data_preguntas->id }}.{{ $id }}">Ver opciones</a></td>
						</tr>
						
						<?php
					}
					echo '</tbody></table>';
				?>
    <!-- /page content -->
@include('layout.footer')