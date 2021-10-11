<?php namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use DB;
    use App\Http\Controllers\FuncionesControllers;
	use Excel;
	
	Excel::create('estadisticas_observadores', function($excel) use($cedula,$nombres,$apellidos,$privilegio,$estado,$municipio,$parroquia)  {
		$excel->sheet('estadisticas_observadores', function($sheet) use($cedula,$nombres,$apellidos,$privilegio,$estado,$municipio,$parroquia) {
			
			$titulos=array("Cedula","Nombre","Estado");
			$sheet->row(1, $titulos);

			$sql = "select o.cedula, o.nombres, o.apellidos, e.nombre as estado ";
			$sql .= "from observador o, estado e ";
			$sql .= "where o.activo=1 and ";
			
			if ($cedula!="" && $cedula!=0)
				$sql .= "cedula='$cedula' and ";
				
			if ($nombres!="")
				$sql .= "nombres like '".strtoupper($nombres)."%' and ";

			if ($apellidos!="")
				$sql .= "apellidos like '".strtoupper($apellidos)."%' and ";
			
			if ($privilegio!="T" && $privilegio!=0)
				$sql .= "privilegio = '$privilegio' and ";
				
			if ($estado!=0)
				$sql .= "o.id_estado = $estado and ";
				
			if ($municipio!=0)
				$sql .= "o.id_municipio = $municipio and ";
				
			if ($parroquia!=0)
				$sql .= "o.id_parroquia = $parroquia and ";
				
			$sql .= "o.id_estado=e.id_estado ";		
			
			//$sql = substr($sql,0,strlen($sql)-5);
				
			$sql .= " order by estado, apellidos, nombres";
			//echo $sql;
			$data=DB::select($sql);
			$fila=2;
			foreach ($data as $data) {				
				$cedula = $data->cedula;
				$nombres = $data->nombres;
				$apellidos = $data->apellidos;
				$valores=array($cedula, $nombres." ".$apellidos, $data->estado);
				$sheet->row($fila, $valores);
				$fila++;
			}
		});
	})->export('xls');
?>


<script>alert("Archivo generado satisfactoriamente !!!"); window.opener.location.reload(); window.close();</script>