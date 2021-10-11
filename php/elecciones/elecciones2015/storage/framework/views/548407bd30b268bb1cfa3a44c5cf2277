<?php namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use DB;
    use App\Http\Controllers\FuncionesControllers;
	use Excel;
	
	if (!$municipio) $municipio=0;
	if (!$parroquia) $parroquia=0;
	
	Excel::create('estadisticas_centros_procesados', function($excel) use($reporte,$estado,$municipio,$parroquia)  {
		for ($rep=1;$rep<6;$rep++) {
			$reporte=$rep;
			$excel->sheet('Reporte'.$rep, function($sheet) use($reporte,$estado,$municipio,$parroquia) {
				$titulos=array("Centro","Circuito","Estrato","Estado","Tipo","Observ Recup 1","Observ Recup 2","Observ Recup 3","Falla","Estatus","Hora","Observador Asignado");
				
				$sheet->row(1, $titulos);
				
				$sql = "select c.estrato, c.codigo, c.nombre, c.tipo, e.nombre as estado, a.id_observador, c.circuito ";
				$sql .= "from centro c, estado e, asignacion a ";
				$sql .= "where c.id_centro=a.id_centro and e.id_estado=c.estado";
				$data=DB::select($sql);
				$fila=2;
				foreach ($data as $data) {
					$datos_excel="";
					$datos_excel=array($data->codigo,$data->circuito,$data->estrato,$data->estado,$data->tipo);
					
					$sql = "select max(nro_recuperacion) as numero, id_recuperacion, observ_rec1, observ_rec2,";
					$sql .= "observ_rec3, falla, hora_ingreso ";
					$sql .= "from recuperacion ";
					$sql .= "where id_encuesta in ($reporte) and id_observador=".$data->id_observador;
					$data2=DB::select($sql);
					if (empty($data2)) $rec=0;
					else {
						foreach ($data2 as $data2)
							$rec=$data2->numero;
					}
					
					$sql = "select distinct(id_observador) as id_observador, observ_rec1, observ_rec2,observ_rec3, falla, hora_ingreso ";
					$sql .= "from recuperacion ";
					$sql .= "where id_encuesta in ($reporte) and id_observador=".$data->id_observador;
					//if ($rec>0)
					//	$sql .= " and nro_recuperacion=$rec";
					//echo "<br>$sql";
					$data10=DB::select($sql);
					if (empty($data10)) {
						$datos_excel[]="";
						$datos_excel[]="";
						$datos_excel[]="";
						$falla=0;
					} else {
						foreach ($data10 as $data10) {
							if ($data10->observ_rec1) $datos_excel[]=$data10->observ_rec1;
							elseif ($data10->observ_rec2) $datos_excel[]=$data10->observ_rec2;
							elseif ($data10->observ_rec3) $datos_excel[]=$data10->observ_rec3;
							$falla=$data10->falla;
						}
					}
					if ($falla>0)
						$datos_excel[]=FuncionesControllers::buscar_falla($falla);
					else
						$datos_excel[]="";
						
					if ($data2->numero) {
						$datos_excel[]="Recuperacion ".$data2->numero;
						$datos_excel[]=substr($data2->hora_ingreso,strpos($data2->hora_ingreso," ")+1);
						$sql = "select o.nombres, o.apellidos from observador o, asignacion_operador ao ";
						$sql .= "where ao.id_observador=".$data->id_observador;
						$sql .= " and ao.id_operador=o.id_observador";
						$data4=DB::select($sql);
						if (empty($data4))
							$datos_excel[]="";
						else
							foreach ($data4 as $data4)
								$datos_excel[]=$data4->nombres." ".$data4->apellidos;
					} else {
						$sql = "select distinct(id_observador) as id_observador, hora ";
						$sql .= "from encuesta_observador eo, pregunta p ";
						$sql .= "where p.id_pregunta=eo.id_pregunta and p.id_encuesta in ($reporte) and ";
						$sql .= "id_observador=".$data->id_observador;
						//if ($fila==2) echo $sql;
						$data3=DB::select($sql);
						if (empty($data3)) {
							$datos_excel[]="";
							$datos_excel[]="";
						} else {
							foreach ($data3 as $data3) {
								if ($data3->id_observador) {
									$datos_excel[]="Procesada";
									$datos_excel[]=substr($data3->hora,strpos($data3->hora," ")+1);
									$sql = "select o.nombres, o.apellidos from observador o, asignacion_operador ao ";
									$sql .= "where ao.id_observador=".$data->id_observador;
									$sql .= " and ao.id_operador=o.id_observador";
									$data4=DB::select($sql);
									if (empty($data4))
										$datos_excel[]="";
									else
										foreach ($data4 as $data4)
											$datos_excel[]=$data4->nombres." ".$data4->apellidos;					
								} else {
									$datos_excel[]="";
									$datos_excel[]="";
								}
							}
						}
					}
					$sheet->row($fila, $datos_excel);
					$fila++;
				}
			});
		}
	})->export('xls');
?>

<script>alert("Archivo generado satisfactoriamente !!!"); window.opener.location.reload(); window.close();</script>