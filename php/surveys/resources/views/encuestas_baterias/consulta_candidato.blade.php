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
use URL;
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
				<input id="email" name="email" type="email" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Email" value="{{ $email }}">
			</div>
		</div>	
		
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre:</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input id="nombre" name="nombre" type="nombre" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Nombre" value="{{ $nombre }}">
			</div>
		</div>	
		
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Cedula:</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input id="cedula" name="cedula" type="cedula" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Cedula" value="{{ $cedula }}">
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
			$cant_tablas=1;
			if ($email!="" || $cedula!="" || $nombre!="") {
				$sql = "select c.* 
					from candidatos c, autorizaciones a 
					where a.id=c.id_autorizacion and 
						a.id_empresas=".Session::get("id_empresa");
					if ($email!="")
						$sql .= " and c.email='".$email."'";
					if ($cedula!="")
						$sql .= " and c.cedula='".$cedula."'";
					if ($nombre!="")
						$sql .= " and (c.nombres like '%".$nombre."%' or c.apellidos like '%".$nombre."%')";
					$sql .= " order by c.email";
				//echo $sql;
				$data=DB::select($sql);
				$autorizacion="";
				
				$cantidad=count($data);
				$cantidad--;
				
				$email_act="";
				$email_old="";
				
				foreach ($data as $data) {
					$id_candidato=$data->id;
					$email_act=$data->email;
					//echo "email=$email_act..$email_old<br>";
					if ($email_old!=$email_act && $email_old!="") {
						
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
						
						$datos_pruebas="";
						if (!empty($autorizacion)) {
							foreach ($autorizacion as $key=>$value) {
								$sql = "select * from autorizaciones where id=".$value;
								$data_candidato=DB::select($sql);
								foreach ($data_candidato as $data_candidato) {
									$sql = "select * from bateria where id=".$data_candidato->id_tipo_prueba;
									$data2=DB::select($sql);
									foreach ($data2 as $data2) {
										$datos_pruebas[]=array(
											"id_autorizacion"=>$value, 
											"id_bateria"=>$data_candidato->id_tipo_prueba, 
											"fecha"=>$data_candidato->fecha, 
											"prueba"=>$data2->nombre,
											"empresa"=>$data_candidato->id_empresas
										);
									}
								}
							}
							
							//print_r ($datos_pruebas);
						?>	
						
						<table id="tabla_reportes_<?php echo $cant_tablas; ?>" class="display" cellspacing="0" width="100%" align="center">
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
										if ($value["id_bateria"]==7 || $value["id_bateria"]==3  || $value["id_bateria"]==6 || $value["id_bateria"]==9) {
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
													<th>".FuncionesControllers::fecha_normal(substr($value["fecha"],0,strpos($data_candidato->fecha," ")))."</td>
													<th>".$value["prueba"]."</td>
													<th>".FuncionesControllers::buscar_empresa($value["empresa"])."</td>
													<th>
														<a href='".$link."/".$resto_link."'>
															<button class='btn btn-default' type='button'>Consultar Prueba</button>
														</a>
													</th>
												</tr>
											";
										}
									}
									$cant_tablas++;
								?>
							</tbody>
						</table>
						<hr />
					<?php }
						
					}
					
					$autorizacion[]=$data->id_autorizacion;
					$email_old=$data->email;
					//print_r ($autorizacion);
					/*if ($cant_tablas==5)
						break;*/
				}
				
	?>
	
	<!---**************************************************************************************-->
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
						
						$datos_pruebas="";
						if (!empty($autorizacion)) {
							foreach ($autorizacion as $key=>$value) {
								$sql = "select * from autorizaciones where id=".$value;
								$data_candidato=DB::select($sql);
								foreach ($data_candidato as $data_candidato) {
									$sql = "select * from bateria where id=".$data_candidato->id_tipo_prueba;
									$data2=DB::select($sql);
									foreach ($data2 as $data2) {
										$datos_pruebas[]=array(
											"id_autorizacion"=>$value, 
											"id_bateria"=>$data_candidato->id_tipo_prueba, 
											"fecha"=>$data_candidato->fecha, 
											"prueba"=>$data2->nombre,
											"empresa"=>$data_candidato->id_empresas
										);
									}
								}
							}
							
							//print_r ($datos_pruebas);
						?>	
						
						<table id="tabla_reportes_<?php echo $cant_tablas; ?>" class="display" cellspacing="0" width="100%" align="center">
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
										if ($value["id_bateria"]==7 || $value["id_bateria"]==3  || $value["id_bateria"]==6 || $value["id_bateria"]==9) {
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
													<th>".FuncionesControllers::fecha_normal(substr($value["fecha"],0,strpos($data_candidato->fecha," ")))."</td>
													<th>".$value["prueba"]."</td>
													<th>".FuncionesControllers::buscar_empresa($value["empresa"])."</td>
													<th>
														<a href='".$link."/".$resto_link."'>
															<button class='btn btn-default' type='button'>Consultar Prueba</button>
														</a>
													</th>
												</tr>
											";
										}
									}
									$cant_tablas++;
								?>
							</tbody>
						</table>
						<hr />
					<?php }
										
				
			} ?>
			
			<script>var cant_tablas=<?php echo $cant_tablas; ?></script>
@include('layout.footer')