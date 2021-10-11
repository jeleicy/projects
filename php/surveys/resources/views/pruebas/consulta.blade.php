<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\monedaControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\URL;

?>

@include('layout.header')
    <!-- page content -->
    <div class="x_content">
		<br />
		<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>	
	
		<h2>Tipos de Pruebas</h2> <hr />
		<div class="form-group">
			<div class="dataTable_wrapper">
				<table width="80%" class="table table-striped table-bordered table-hover" id="tabla_reportes">
					<thead>
						<tr>
							<th width="35%">Nombre</th>
							<th width="35%">URL</th>
							<th width="35%">Tiempo</th>
							<th width="35%">Se muestra</th>
							<th width="35%">Activa</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$activo=array("Inactivo","Activo");
							$vista_tiempo=array("NO","SI");
						
							$sql = "select *
									from tipos_pruebas
									order by 2";
							$data=DB::select($sql);
							foreach ($data as $data) {
								?>
									<tr>
										<th><?php echo $data->nombre; ?></th>
										<th><?php echo $data->url; ?></th>
										<th><?php echo $data->tiempo; ?> Minutos</th>
										<th><?php echo $vista_tiempo[$data->vista_tiempo]; ?></th>
										<th><?php echo $activo[$data->activo]; ?></th>
										<th><a href='consultarprueba/<?php echo $data->id; ?>'>Consultar</a></th>
										<th><a href='consultarpreguntaopcion/<?php echo $data->id; ?>'>Preguntas/Opciones</a></th>
									</tr>								
								<?php
							}
						?>
					</tbody>	
				</table>
			</div>
		</div>
    </div>
    <!-- /page content -->
@include('layout.footer')