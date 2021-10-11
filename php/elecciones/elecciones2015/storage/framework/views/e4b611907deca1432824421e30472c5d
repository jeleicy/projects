<?php namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use DB;
    use App\Http\Controllers\FuncionesControllers;
	use Excel;
	
	if (!$municipio) $municipio=0;
	if (!$parroquia) $parroquia=0;
	
	Excel::create('estadisticas', function($excel) use($reporte,$estado,$municipio,$parroquia)  {
		for ($rep=1;$rep<6;$rep++) {
			$reporte=$rep;
			$excel->sheet('Reporte'.$rep, function($sheet) use($reporte,$estado,$municipio,$parroquia) {
				
				$sql = "select id_encuesta, pregunta, tipo from pregunta ";
				$sql .= "where id_encuesta=".$reporte;
				$sql .= " order by id_encuesta, id_pregunta";

				$data=DB::select($sql);
				$j=1;
				/*FILA 1*/
				$titulos=array('Centro', 'Circuito', 'Estado', 'Municipio', 'Parroquia', 'Mesa', 'Electores', 'Estrato', 'Tipo', 'Falla');
					 
				foreach ($data as $data) {
					if ($data->tipo=="s") {
						$titulos[]="Pregunta ".$j." (Reporte ".$data->id_encuesta." - NO)";
						$titulos[]="Pregunta ".$j." (Reporte ".$data->id_encuesta." - SI)";
					} else {
						if ($reporte==3 || $reporte==5) {
							$sql = "select * from candidato order by partido, id_candidato";
							
							$data11=DB::select($sql);
							foreach ($data11 as $data11) {
								$titulos[]="Candidato: ".$data11->nombre." (".$data11->partido.")";
								$j++;
							}
							$j--;
						} else {
							$titulos[]="Pregunta ".$j." (Reporte ".$data->id_encuesta." - Valor)";
						}
					}
					$j++;
				}

				$sheet->row(1, $titulos);
				
				/*FILAS DE DATOS*/
				
				$sql = "select distinct(c.codigo), c.nombre as centro, c.id_centro, ";
				$sql .= "eo.mesa, um.nro_votantes, c.estrato, e.nombre as estado, m.nombre as municipio, ";
				$sql .= "par.nombre as parroquia, c.tipo, a.id_asignacion, c.circuito ";
				$sql .= "from centro c, universo_mesa um, encuesta_observador eo, estado e, municipio m, ";
				$sql .= "parroquia par , pregunta p, asignacion a ";
				
				$sql .= "where ";
				if ($estado>0)
					$sql .= "c.estado=$estado and ";
				if ($municipio>0)
					$sql .= "c.municipio=$municipio and ";
				if ($parroquia>0)
					$sql .= "c.parroquia=$parroquia and ";
				$sql .= "p.id_encuesta in ($reporte) and ";
				$sql .= "p.id_pregunta=eo.id_pregunta and ";
				$sql .= "um.codigo_centro=c.id_centro and ";
				$sql .= "eo.id_centro=c.id_centro and um.cod_mesa=eo.cod_mesa and ";
				
				$sql .= "e.id_estado=m.id_estado and m.id_municipio=par.id_municipio and par.id_estado=e.id_estado and ";
				$sql .= "c.estado=e.id_estado and c.municipio=m.id_municipio and c.parroquia=par.id_parroquia ";
				$sql .= " and a.nro_mesa=eo.cod_mesa and a.id_centro=eo.id_centro and eo.id_observador=a.id_observador ";
				
				$sql .= "group by c.nombre, c.id_centro, ";
				$sql .= "eo.mesa, um.nro_votantes, c.estrato";

				$data=DB::select($sql);
				$j=1;
				$fila=2;
				foreach ($data as $data) {
					$datos_excel="";
					$datos_excel=array($data->codigo,$data->circuito,$data->estado,$data->municipio,$data->parroquia,$data->mesa,$data->nro_votantes,$data->estrato,$data->tipo);
					
					$sql = "select distinct(falla) as falla ";
					$sql .= "from recuperacion";
					$sql .= " where id_asignacion=".$data->id_asignacion;
					
					$data2=DB::select($sql);
					if (empty($data2))
						$datos_excel[]='';
					else {
						foreach ($data2 as $data2)
							$datos_excel[]=FuncionesControllers::buscar_falla($data2->falla);
					}

					$sql = "select id_pregunta, tipo from pregunta ";
					$sql .= "where id_encuesta in ($reporte) ";
					$sql .= "order by id_encuesta, id_pregunta";
					
					$data2=DB::select($sql);
					$j=1;
					foreach ($data2 as $data2) {
						if ($data2->tipo=="s") {
							$sql = "select count(eo.id_observador) as cantidad, eo.id_pregunta ";
							$sql .= "from encuesta_observador eo, pregunta p ";
							$sql .= "where eo.respuesta=1 and eo.id_centro=".$data->id_centro." and ";
							$sql .= "p.id_encuesta in ($reporte) and ";
							$sql .= "eo.cod_mesa=".$data->mesa." and p.id_pregunta=eo.id_pregunta and ";
							$sql .= "eo.id_pregunta=".$data2->id_pregunta;
							$sql .= " group by id_pregunta";
							
							$data3=DB::select($sql);
							if (empty($data3)) $datos_excel[]=0;
							else
								foreach ($data3 as $data3)
									$datos_excel[]=$data3->cantidad;
									
							$sql = "select count(eo.id_observador) as cantidad, eo.id_pregunta ";
							$sql .= "from encuesta_observador eo, pregunta p ";
							$sql .= "where eo.respuesta=0 and eo.id_centro=".$data->id_centro." and ";
							$sql .= "p.id_encuesta in ($reporte) and ";
							$sql .= "eo.cod_mesa=".$data->mesa." and p.tipo='s' and p.id_pregunta=eo.id_pregunta and eo.id_pregunta=".$data2->id_pregunta;
							$sql .= " group by id_pregunta";
							$data4=DB::select($sql);
							if (empty($data4)) $datos_excel[]=0;
							else
								foreach ($data4 as $data4)
									$datos_excel[]=$data4->cantidad;
						} else {
							$sql = "select eo.respuesta as respuesta ";
							$sql .= "from encuesta_observador eo, pregunta p ";
							$sql .= "where eo.id_centro=".$data->id_centro." and ";
							$sql .= "p.id_encuesta in ($reporte) and ";
							$sql .= "eo.cod_mesa=".$data->mesa." and p.tipo='a' and p.id_pregunta=eo.id_pregunta and ";
							$sql .= "eo.id_pregunta=".$data2->id_pregunta;
							$data3=DB::select($sql);
							if (empty($data3)) $datos_excel[]=0;
							else
								foreach ($data3 as $data3)
									$datos_excel[]=$data3->respuesta;
						}
						$j++;
					}
					
					if ($reporte==3 || $reporte==5) {
						$sql = "select id_candidato from candidato order by partido, id_candidato";			
						$data00=DB::select($sql);
						foreach ($data00 as $data00) {
							$sql = "select c.nombre, v.cantidad, c.id_candidato ";
							$sql .= "from votos v, candidato c, asignacion a ";
							$sql .= "where c.id_candidato=v.id_candidato ";
							$sql .= "and a.id_asignacion=v.id_asignacion and a.id_centro=".$data->id_centro;
							$sql .= " and v.id_encuesta in ($reporte) and c.id_candidato=".$data00->id_candidato;
							$sql .= " order by c.partido, c.id_candidato";
							$data11=DB::select($sql);
							$valor=0;
							if (empty($data11)) $datos_excel[]=0;
							else {
								foreach ($data11 as $data11)
									$datos_excel[]=$data11->cantidad;

								$j++;
								$valor++;
							}
							if ($valor==0)
								$datos_excel[]=0;
						}
					}
					$sheet->row($fila, $datos_excel);
					$fila++;
				}

			});
		}
	})->export('xls');

?>