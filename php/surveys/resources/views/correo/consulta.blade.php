<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessioncorreoControllers;
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
	
		<h2>Correos</h2> <hr />
		<div class="form-group">
			<div class="dataTable_wrapper">
				<table width="100%" class="table table-striped table-bordered table-hover" id="tabla_reportes">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Asunto</th>
							<th>Bateria</th>
							<th>Idioma</th>
							<th>Tipo</th>
							<th>Estatus</th>
							<th>Empresa</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = "select * from correo order by 2";
							$data=DB::select($sql);
							$tipo=array("E"=>"Envio", "R"=>"Recepcion");
							$activo=array("Inactivo","Activo");
							foreach ($data as $data) {
								?>
									<tr>
										<th><?php echo $data->nombre; ?></th>
										<th><?php echo $data->asunto; ?></th>
										<th><?php echo FuncionesControllers::buscar_bateria($data->id_prueba); ?></th>
										<th><?php echo FuncionesControllers::buscar_idioma($data->id_idioma); ?></th>
										<th><?php echo $tipo[$data->tipo]; ?></th>
										<th><?php echo $activo[$data->activa]; ?></th>
										<th><?php echo FuncionesControllers::buscar_empresa($data->id_empresa); ?></th>
										<th>
											<a href='consultarcorreos/<?php echo $data->id; ?>'>Consultar</a>
											<!--a href='eliminarcorreo/<?php echo $data->id; ?>'>Eliminar</a-->
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

