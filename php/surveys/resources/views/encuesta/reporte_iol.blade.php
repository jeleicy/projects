            <table id="tabla_reportes" class="display" cellspacing="0" width="75%" align="center">
                <thead>
                    <tr>
                        <th>Participante</th>
						<th>Cedula</th>
                        <th>Perfil</th>
                        <th>Fecha</th>
                        <th>Hora</th>
						<th>&nbsp;</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Participante</th>
						<th>Cedula</th>
                        <th>Perfil</th>
                        <th>Fecha</th>
                        <th>Hora</th>
						<th>&nbsp;</th>						
                    </tr>
                </tfoot>
                <tbody>	
				<?php
					$sql = "select distinct(c.id) as id_candidato, c.nombres, 
						c.apellidos, c.cedula, 
						r.fecha, r.perfil, r.nro_prueba
					from candidatos c, resultados_iol r 
					where r.id_candidato=c.id and 
						date(r.fecha) between '".FuncionesControllers::fecha_mysql($fecha_reporte1)."' and '".FuncionesControllers::fecha_mysql($fecha_reporte2)."' ";

					if ($cedula!="")
						$sql .= " and c.cedula='".$cedula."'";
					$data=DB::select($sql);

					$i=1;
					foreach ($data as $data) {
						$r="";
						$p="";
						$e="";
						$id_candidato=$data->id_candidato;
						$resultado="";
						$resultado=FuncionesControllers::consulta_resultado($data->id_candidato,FuncionesControllers::fecha_mysql($fecha_reporte1),FuncionesControllers::fecha_mysql($fecha_reporte2),2);
						/*echo "<pre>";
						print_r ($resultado);
						echo "</pre>";*/
						?>
							<tr>								
								<th><?php echo $data->nombres." ".$data->apellidos; ?></th>
								<th><?php echo number_format($data->cedula,0,"","."); ?></th>
								<th><?php echo  $data->perfil; ?></th>
								<th><?php echo FuncionesControllers::fecha_normal(substr($data->fecha,0,10)); ?></th>
								<th><?php echo substr($data->fecha,11); ?></th>
								<th>
									<div class="btn-group">
										<a href="generar_pdf/<?php echo $id_candidato.",".$data->fecha.",".$data->nro_prueba; ?>">
											<button class="btn btn-default" type="button">Imprimir Reporte</button>
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