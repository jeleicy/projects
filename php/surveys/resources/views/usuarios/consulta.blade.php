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
		<div align="left" class="alert alert-{{ $tipo }} alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>	
	
		<h2>Usuarios</h2> <hr />
		<div class="form-group">
			<div class="dataTable_wrapper">
				<table width="100%" class="table table-striped table-bordered table-hover" id="tabla_reportes">
					<thead>
						<tr>
							<th>Nombres</th>
							<th>Empresa</th>
							<th>Rol</th>
							<th>Correo</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = "select * from usuarios ";
							if (Session::get("rol")=="EA")
								$sql .= " where id_empresas=".Session::get("id_empresa");
							$sql .= " order by 2";
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
										<th><?php echo $data->nombres; ?></th>
										<th><?php echo FuncionesControllers::buscar_empresa($data->id_empresas); ?></th>
										<th><?php echo $rol[$data->rol]; ?></th>
										<th><?php echo $data->email; ?></th>
										<th>
											<a href='consultarusuario/<?php echo $data->id; ?>'>
												<button type="button" class="btn btn-primary">Consultar</button>
											</a>
											<?php if (strpos($_SERVER["REQUEST_URI"],"setearpass") !== false)
													$ruta="../";
												  else
													$ruta="";
											?>
											<a href='{{ $ruta }}setearpass/<?php echo $data->id; ?>'>
												<button type="button" class="btn btn-primary">Setear Password</button>
											</a>
											
											<!--a href='eliminarusuario/<?php echo $data->id; ?>'>Eliminar</a-->
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

