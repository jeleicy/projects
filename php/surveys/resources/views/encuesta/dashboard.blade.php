<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

@include('layout.header')
	<br /><br /><br />
	
	<div class="row">
		<?php 
			$sql = "select * from tipos_pruebas where activo=1 order by 2";
			$data = DB::select($sql);
			foreach ($data as $data) {
		?>
		<div class="col-lg-2 col-md-2">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-9">							
							<div>
								<span style="text-transform: uppercase;font-size: 11pt;font-weight: bold">{{ $data->nombre }}: {{ FuncionesControllers::cantidad_tipos_pruebas($data->id) }}</span>
							</div>
						</div>
					</div>
				</div>
				<a href="encuesta_reporte/<?php echo $data->id ?>">
					<div class="panel-footer">
						<span class="pull-left">Ver Reportes</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
			<?php } ?>
	</div>
	
@include('layout.footer')