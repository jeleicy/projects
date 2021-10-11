<?php namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use DB;
    use App\Http\Controllers\FuncionesControllers;
	use Excel;
	
	Excel::create('estadisticas', function($excel) use($eleccion,$recuperado,$estado,$reporte,$circuito)  {
		$excel->sheet('listado_de_cobertura', function($sheet) use($eleccion,$recuperado,$estado,$reporte,$circuito) {
	
			$titulos=array("Cod. Centro","Nro. Mesa","Falla de Cobertura","Nivel Cobertura");
			$sheet->row(1, $titulos);

			$reporte=str_replace(".",",",$reporte);
		
			$sql = "select distinct(r.id_encuesta), o.id_observador, ";
			$sql .= "o.nombres, o.apellidos, e.nombre as estado, r.nro_recuperacion as nivel, ";
			$sql .= "r.id_encuesta, c.codigo, a.nro_mesa, r.falla ";
			$sql .= "from observador o, estado e, recuperacion r, asignacion a, centro c ";
			$sql .= "where o.id_observador=r.id_observador and ";
			$sql .= "o.id_observador=a.id_observador and ";
			$sql .= "a.id_centro=c.id_centro and ";
			if ($estado>0)
				$sql .= "c.estado=$estado and ";
			if ($circuito>0)
				$sql .= "c.circuito=$circuito and ";
			if ($reporte!='0')
				$sql .= "r.id_encuesta in ($reporte) and ";
			$sql .= "e.id_estado=c.estado and r.id_eleccion=a.id_eleccion and ";
			$sql .= "r.recuperado=0 and ";
			$sql .= "r.nro_recuperacion=$recuperado";
			
			$data=DB::select($sql);
			$fila=2;			
			foreach ($data as $data) {
				$datos="";
				$datos[]=$data->codigo;
				$datos[]=$data->nro_mesa;
				$datos[]=FuncionesControllers::buscar_falla($data->falla);
				$datos[]=$data->nivel;
				$sheet->row($fila, $datos);
				$fila++;
			}
		});
	})->export('xls');
?>