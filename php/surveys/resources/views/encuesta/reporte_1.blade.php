<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

            <table id="tabla_reportes" class="display" cellspacing="0" width="100%" align="center">
                <thead>
                    <tr>
                        <th>Participante</th>
						<th>Cedula</th>
						<th>Idioma</th>                        
                        <th>Fecha</th>
                        <th>Hora</th>
						<th>Perfil</th>
						<th>Grupo</th>
						<th>&nbsp;</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Participante</th>
						<th>Cedula</th>
						<th>Idioma</th>                        
                        <th>Fecha</th>
                        <th>Hora</th>
						<th>Perfil</th>
						<th>Grupo</th>
						<th>&nbsp;</th>						
                    </tr>
                </tfoot>
                <tbody>	
				<?php
					$sql = "select distinct(c.id) as id_candidato, c.nombres, 
						c.apellidos, c.cedula, 
						r.fecha, r.perfil, r.nro_prueba, a.id_idioma, a.id as id_autorizacion, a.id_usuario
					from candidatos c, resultados_iol r, autorizaciones a
					where r.id_candidato=c.id and 
						a.id=c.id_autorizacion and 
						r.nro_prueba=1 and 
						date(r.fecha) between '".FuncionesControllers::fecha_mysql($fecha_reporte1)."' and '".FuncionesControllers::fecha_mysql($fecha_reporte2)."' ";

					if ($cedula!="")
						$sql .= " and c.cedula='".$cedula."'";

					if (Session::get("rol")!="A") {
						if (Session::get("rol")=="EA")					
							$sql .= " and a.id_empresas=".Session::get("id_empresa");
						if (Session::get("rol")=="ERRHH") {
							$sql .= " and a.id_empresas=".Session::get("id_empresa");
							$sql .= " and a.id_invitador=".Session::get("id_usuario");
						}
					}
					
					$data=DB::select($sql);

					$i=1;
					foreach ($data as $data) {
						$r="";
						$p="";
						$e="";
						$id_candidato=$data->id_candidato;
						$resultado="";
						$resultado=FuncionesControllers::consulta_resultado($data->id_candidato,FuncionesControllers::fecha_mysql($fecha_reporte1),FuncionesControllers::fecha_mysql($fecha_reporte2),1);
						/*echo "<pre>";
						print_r ($resultado);
						echo "</pre>";*/
						
						if (strpos($_SERVER["REQUEST_URI"],"consultar_encuesta") !== false)
							$ruta="";
						else
							$ruta="../";
						
						$path='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
						$path=substr($path,0,strpos($path,"public/")+7);
						//echo "path=".$path; 
						//return;
						$path = "http://iol.talentskey.net/encuestas/public/pdf/";
						//$path="public/pdf/";
						$archivo = $path.$id_candidato.".pdf";
						//echo var_dump(is_file($archivo))."<br />";
						//if (!file_exists($archivo))
							$ref=$ruta."generar_pdf/".$id_candidato.",".$data->fecha;
						/*else
							$ref=$archivo;*/
						
						//echo "ref=".$data->cedula; return;						
						$cedula=isset($data->cedula) ? number_format($data->cedula,0,".",".") : 0;
						?>
							<tr>								
								<th><?php echo $data->nombres." ".$data->apellidos; ?></th>
								<th><?php echo $cedula; ?></th>
								<th><?php echo  FuncionesControllers::buscar_idioma($data->id_idioma); ?></th>								
								<th><?php echo FuncionesControllers::fecha_normal(substr($data->fecha,0,10)); ?></th>
								<th><?php echo substr($data->fecha,11); ?></th>
								<?php
									$perfil=$data->perfil;
									
									if (strpos($perfil,"Invalido") !== false)
										$color="red";
									else
										$color="green";
								
									$perfil_alt="";
									$sql = "select * from resultados_iol where nro_prueba=2 and id_candidato=".$data->id_usuario;
									
									$data_alt=DB::select($sql);
									if (!empty($data_alt)) {											
										$sql = "select perfil from resultados_iol where nro_prueba=2 and id_candidato=".$data->id_usuario;
										//echo $sql;
										$data_alt_perfil=DB::select($sql);
										foreach ($data_alt_perfil as $data_alt_perfil)
											$perfil_alt=" / <span style='color:green'>".ucfirst($data_alt_perfil->perfil)."</span>";
									}
								?>
								<th><?php echo "<span style='color:$color'>".ucfirst($perfil).$perfil_alt."</span>"; ?></th>
								<th>
									<div class="btn-group">									
										<a href="<?php echo $ref.",1"; ?>">
											<button class="btn btn-default" type="button">Imprimir Reporte</button>
										</a>										
										<?php
											if (!empty($data_alt))
												echo '
													<a href="'.$ref.",2".'">
														<button class="btn btn-default" type="button">Imprimir Reporte IOL Alt</button>
													</a>
											';												
										?>
										
										<a href="<?php echo $ruta; ?>reenviar_pdf/<?php echo $id_candidato.",".$data->fecha.",".$data->nro_prueba; ?>">
											<button class="btn btn-default" type="button">Reenviar Reporte</button>
										</a>
										
									</div>
								</th>
							</tr>						
						<?php
						$i++;
					}
				?>
				</tbody>	
			</table>