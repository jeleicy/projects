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

use PDF;

?>

@include('layout.header')

    <!-- jQuery -->
    <script src="../bp/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../js/funciones_genericas.js"></script>


    {!! Form::open(array('url' => 'buscar_candidato', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<br /><br /><br />
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Email:</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input id="email" name="email" type="email" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Email" value="">
			</div>
		</div>	
		
		<div class="clearfix"></div>

		<div id="boton_2" align="center">
			<input type="button" onclick="guardar()" class="btn btn-primary" value="Consultar Participante">
		</div>
		
	{!! Form::close() !!}
	
			<!--
				respuestas_epa
				respuestas_hl
				respuestas_ifh
				respuestas_iol
				respuestas_op
				respuestas_potencial	
			-->
			
			<?php
			if ($email!="") {
				$sql = "select * from candidatos where email='".$email."'";
				$data=DB::select($sql);
				$autorizacion="";
				$i=0;
				$cantidad=count($data);
				foreach ($data as $data) {
					$id_candidato=$data->id;
					if ($i==$cantidad) {
						?>
							<table>
								<tr><td>Nombre: <strong>{{ strtoupper($data->nombres) }} {{ strtoupper($data->apellidos) }}</strong></td></tr>
								<tr><td>Cedula: <strong>{{ $data->cedula }}</strong></td></tr>
								<tr><td>Eamil: <strong>{{ $data->email }}</strong></td></tr>
								<td><td>
									<a href="datos_participante/{{ $data->id_autorizacion }}">
										<button class="btn btn-default" type="button">Consultar Datos</button>
									</a>								
								</td></tr>
							</table>
							<br /><br />
							
						<?php
					}
					$i++;
					$autorizacion[]=$data->id_autorizacion;
				}
				$datos_pruebas="";
				if (!empty($autorizacion)) {
				foreach ($autorizacion as $key=>$value) {
					$sql = "select * from autorizaciones where id=".$value;
					$data=DB::select($sql);
					foreach ($data as $data) {
						$sql = "select * from bateria where id=".$data->id_tipo_prueba;
						$data2=DB::select($sql);
						foreach ($data2 as $data2) {
							$datos_pruebas[]=array(
								"id_autorizacion"=>$value, 
								"id_bateria"=>$data->id_tipo_prueba, 
								"fecha"=>$data->fecha, 
								"prueba"=>$data2->nombre,
								"empresa"=>$data->id_empresas
							);
						}
					}
				}
				
				//print_r ($datos_pruebas);
			?>			
	
			<table id="tabla_reportes" class="display" cellspacing="0" width="100%" align="center">
                <thead>
                    <tr>
                        <th>Fecha</th>
						<th>Prueba</th>
						<th>Empresa</th>
						<th>&nbsp;</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Fecha</th>
						<th>Prueba</th>
						<th>Empresa</th>
						<th>&nbsp;</th>
                    </tr>
                </tfoot>
                <tbody>
					<?php
						foreach ($datos_pruebas as $key=>$value) {
							if ($value["id_bateria"]==7 || $value["id_bateria"]==3  || $value["id_bateria"]==6|| $value["id_bateria"]==9) {
							$sql = "select * from link_resultados where id_bateria=".$value["id_bateria"];
							//echo $sql; return;
							$data3=DB::select($sql);
							$link="";
							foreach ($data3 as $data3)
								$link=$data3->link;
								
							if ($value["id_bateria"]>1)
								$resto_link=$value["id_autorizacion"]."-".$value["id_bateria"];
							elseif ($value["id_bateria"]==1)
								$resto_link=$id_candidato.",".$value["fecha"].",1";
							
							//959,2017-06-02 09:31:30,1
							
							echo "
								<tr>
									<th>".FuncionesControllers::fecha_normal(substr($value["fecha"],0,strpos($data->fecha," ")))."</td>
									<th>".$value["prueba"]."</td>
									<th>".FuncionesControllers::buscar_empresa($value["empresa"])."</td>
									<th>
										<a href='".$link."/".$resto_link."'>
											<button class='btn btn-default' type='button'>Consultar Prueba</button>
										</a>
									</th>
								</tr>
							";
						}}
					?>
				</tbody>
			</table>
			<?php }
			} ?>
@include('layout.footer')