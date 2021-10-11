<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionempresaControllers;
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
	
		<h2>empresas</h2> <hr />
		<div class="form-group">
			<div class="dataTable_wrapper">
				<table width="100%" class="table table-striped table-bordered table-hover" id="tabla_reportes">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>Nombre</th>
							<th>Direccion</th>							
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = "select * from empresas order by 2";
							$data=DB::select($sql);
							foreach ($data as $data) {
								$imagen=$data->logo;
								if (!is_file('empresas/logos/'.$imagen))
									$imagen="no_camera.png";
								?>
									<tr>
										<th align="center"><img src="empresas/logos/<?php echo $imagen; ?>" border=0 width="50" height="50"></th>
										<th><?php echo $data->nombre; ?></th>
										<th><?php echo $data->direccion; ?></th>										
										<th>
											<a href='consultarempresa/<?php echo $data->id; ?>'>Consultar</a>
											<!--a href='eliminarempresa/<?php echo $data->id; ?>'>Eliminar</a-->
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

