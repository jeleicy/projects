<?php namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use DB;
    use App\Http\Controllers\FuncionesControllers;
	use Excel;
	/*
	Excel::create('cantidad_de_votos', function($excel) use($eleccion)  {
		$excel->sheet('Votos', function($sheet) use($eleccion) {

			$sql = "select distinct(v.fecha_hora) as cortes ";
			$sql .= "from votos v, candidato c ";
			$sql .= "where v.id_candidato=c.id_candidato and ";
			$sql .= "c.id_eleccion=".$eleccion;
			$sql .= " and v.id_eleccion=".$eleccion;
			$sql .= " and v.id_eleccion=c.id_eleccion";
			$data=DB::select($sql);
			$cortes=1;
			foreach ($data as $data)
				$cortes++;
			
			$cortes--;
			$titulos[]="Partido";
			for ($i=1; $i<($cortes+1); $i++) {
				$titulos[]="T$i (votos)";
				$titulos[]="Total Mesa";
			}
			$sheet->row(1, $titulos);*/

			$sql = "select distinct(c.id_candidato), c.nombre, c.partido ";
			$sql .= "from votos v, candidato c ";
			$sql .= "where v.id_candidato=c.id_candidato and ";
			$sql .= "c.id_eleccion=".$eleccion;
			$sql .= " and v.id_eleccion=".$eleccion;
			$sql .= " and v.id_eleccion=c.id_eleccion ";	
			$sql .= "order by 2";
			$data=DB::select($sql);
			$j=1;
			$fila=2;
			foreach ($data as $data) {
				if ($j==1) $j=2;
				else $j=1;
				$datos="";
				$datos[]=$data->partido;
				$sql = "select v.cantidad, v.id_votos, a.nro_mesa, a.id_asignacion ";
				$sql .= "from votos v, asignacion a ";
				$sql .= "where v.id_candidato=".$data->id_candidato;
				$sql .= " and v.id_eleccion=".$eleccion;
				$sql .= " and v.id_asignacion=a.id_asignacion";
				$data2=DB::select($sql);
				$i=1;
				foreach ($data2 as $data2) {
					//$datos[]=$data2->cantidad;
					$votos_mesa=FuncionesControllers::buscar_votos_mesa_total($data2->nro_mesa,$data2->id_asignacion);
					$datos[]=$votos_mesa;
					$suma[$data->partido][$i]=$data2->cantidad;
					$i++;
				}
				echo "<pre>";
				print_r ($datos);
				echo "</pre>";
				$sheet->row($fila, $datos);
				$fila++;
			}
		/*});
	})->export('xls');*/
?>