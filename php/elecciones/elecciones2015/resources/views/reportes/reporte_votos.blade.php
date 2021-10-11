<?php namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use DB;
    use App\Http\Controllers\FuncionesControllers;
	use Excel;
	
	Excel::create('reporte_votos', function($excel) use($eleccion)  {
		$excel->sheet('Votos', function($sheet) use($eleccion) {

			$titulos[]="Codigo Centro";
			$titulos[]="Mesa";
			$titulos[]="Nro. Electores";
			$titulos[]="Candidato";
			$titulos[]="Partido";
			$titulos[]="Nro. Votos";
			
			$sheet->row(1, $titulos);

			$sql = "select sum(v.cantidad) as cant_votos, c.codigo, a.nro_mesa, ";
			$sql .= "can.nombre as nombre_candidato, u.nro_votantes, can.partido ";
			$sql .= "from votos v, asignacion a, centro c, candidato can, universo_mesa u ";
			$sql .= "where v.id_candidato=can.id_candidato and v.id_eleccion=can.id_eleccion ";
			$sql .= "and v.id_asignacion=a.id_asignacion and v.id_eleccion=a.id_eleccion ";
			$sql .= "and v.id_eleccion=u.id_eleccion ";

			$sql .= "and a.id_eleccion=can.id_eleccion ";
			$sql .= "and a.id_centro=c.id_centro ";
			$sql .= "and a.id_eleccion=u.id_eleccion and a.id_centro=u.codigo_centro ";
			$sql .= "and a.nro_mesa=u.cod_mesa ";

			$sql .= "and c.id_centro=u.codigo_centro ";

			$sql .= "and u.id_eleccion=can.id_eleccion ";
			
			$sql .= "and u.id_eleccion=".$eleccion;

			$sql .= " group by c.codigo, a.nro_mesa, can.nombre, u.nro_votantes";

			$data=DB::select($sql);
			$filas=2;
			foreach ($data as $data) {
				$datos="";
				$datos[]=$data->codigo;
				$datos[]=$data->nro_mesa;
				$datos[]=$data->nro_votantes;
				$datos[]=$data->nombre_candidato;
				$datos[]=$data->partido;
				$datos[]=$data->cant_votos;

				$sheet->row($filas, $datos);
				$filas++;
			}
			
		});
	})->export('xls');
?>