<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionbateriaControllers;
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
	
		<h2>Baterias</h2> <hr />
		<div class="form-group">
			<div class="dataTable_wrapper">
				<table width="100%" class="table table-striped table-bordered table-hover" id="tabla_reportes">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Pruebas</th>
							<th>Estatus</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = "select * from bateria order by 2";
							$data=DB::select($sql);
							$activo=array("Inactivo","Activo");
							foreach ($data as $data) {
								?>
									<tr>
										<th><?php echo $data->nombre; ?></th>
										<th>{{ FuncionesControllers::buscar_pruebas($data->id) }}</th>
										<th><?php echo $activo[$data->activa]; ?></th>
										<th>
											<a href='consultarbaterias/<?php echo $data->id; ?>'>Consultar</a>
											<!--a href='eliminarbateria/<?php echo $data->id; ?>'>Eliminar</a-->
										</th>
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

