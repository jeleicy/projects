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
	
		<h2>Participantes</h2> <hr />
		<div class="form-group">
			<div class="dataTable_wrapper">
				<table width="100%" class="table table-striped table-bordered table-hover" id="tabla_reportes">
					<thead>
						<tr>
							<th>Nombres</th>
							<th>Empresa</th>
							<th>Cedula</th>
							<th>Sexo</th>
							<th>Email</th>
							<th>Edad</th>
							<th>Formacion</th>
							<th>Orientacion</th>
							<th>Cargo</th>	
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = "select * from candidatos order by 3,2";
							$data=DB::select($sql);
							$rol = array(
								"A"=>"Administrador",
								"C"=>"Candidato",
								"EA"=>"Empresa (Administrador)",
								"ERRHH"=>"Empresa (RRHH)"
							);
							foreach ($data as $data) {
								?>
									<tr>
										<th><?php echo $data->nombres." ". $data->apellidos; ?></th>
										<th><?php echo FuncionesControllers::buscar_empresa($data->id_empresas); ?></th>
										<th><?php echo $data->nacionalidad."-".$data->cedula; ?></th>
										<th><?php echo $data->sexo; ?></th>
										<th><?php echo $data->email; ?></th>
										<th><?php echo $data->edad; ?></th>
										<th><?php echo $data->nivel_formacion; ?></th>
										<th><?php echo $data->orientacion_area; ?></th>
										<th><?php echo $data->orientacion_cargo; ?></th>										
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

