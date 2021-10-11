<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use App\Http\Controllers\FuncionesControllers;
use Excel;

    if ($nombre=="") $nombre=0;

    Excel::create('tablero', function($excel) use ($nombre,$estado,$municipio,$parroquia,$tipo) {
        $excel->sheet('Tablero', function($sheet) use ($nombre,$estado,$municipio,$parroquia,$tipo) {
            $sql = "select c.*, edo.nombre as estado, mun.nombre as municipio ";
            $sql .= "from centro c, estado edo, municipio mun";

            if ($tipo=="A")
                $sql .= ", asignacion a";

            $sql .= " where ";

            if ($nombre!="" && $nombre!=0)
                $sql .= "c.nombre like '".strtoupper($nombre)."%' and ";

            if ($estado!=0)
                $sql .= "c.estado=$estado and ";

            if ($municipio!=0)
                $sql .= "c.municipio=$municipio and ";

            if ($parroquia!=0)
                $sql .= "c.parroquia=$parroquia and ";

            /*if ($nombre!="" || $estado!=0 || $municipio!=0 || $parroquia!=0)
                $sql = substr($sql,0,strlen($sql)-4);*/

            $sql .= " edo.id_estado=mun.id_estado and c.estado=edo.id_estado";
            $sql .= " and c.municipio=mun.id_municipio";

            if ($tipo=="A")
                $sql .= " and a.id_centro=c.id_centro ";

            $sql .= " order by edo.nombre, mun.nombre, c.nombre, c.codigo ";
            $data = DB::select($sql);

            $fila=7;
            foreach ($data as $data) {
                $nombre = $data->nombre;
                $estado_data = $data->estado;
                $municipio_data = $data->municipio;
                $codigo = $data->codigo;

                // A - 1- estado - municipio
                $datos_excel="";
                $datos_excel[]=$estado_data." - ".$municipio_data;
                $sheet->row($fila, $datos_excel);
                $sheet->cells('A'.$fila, function($cells) {
                    $cells->setFontSize(16);
                    $cells->setAlignment('left');
                });
                $sheet->setBorder('A'.$fila, 'thin');
                $fila=$fila+1;

                // B,C,D,E,F - 2- reportes
                $datos_excel="";
                $datos_excel[]="";
                $datos_excel[]="R1";
                $datos_excel[]="R2";
                $datos_excel[]="R3";
                $datos_excel[]="R4";
                $datos_excel[]="R5";
                $sheet->row($fila, $datos_excel);
                $sheet->cells('B'.$fila.':F'.$fila, function($cells) {
                    $cells->setFontSize(30);
                    $cells->setAlignment('middle');
                });
                $sheet->setMergeColumn(array(
                        'columns' => array('B','C','D','E','F'),
                        'rows' => array(
                                array(2,6),
                                array($fila,$fila+5),
                        )
                ));
                $sheet->setColumnFormat(array(
                        'B' => '30%',
                        'C' => '30%',
                        'D' => '30%',
                        'E' => '30%',
                        'F' => '30%',
                ));
                $sheet->setBorder('B'.$fila.":F".($fila+5), 'thin');
                //$fila++;

                // A - 3 - codigo centro
                $datos_excel="";
                $datos_excel[]=$codigo;
                $sheet->row($fila, $datos_excel);

                $sheet->cells('A'.$fila, function($cells) {
                    $cells->setFontSize(30);
                    $cells->setAlignment('left');
                    $cells->setFontWeight('bold');
                });
                $sheet->setBorder('A'.$fila.":A".($fila+5), 'thin');
                $sheet->setMergeColumn(array(
                        'columns' => array('A'),
                        'rows' => array(
                                array(1,1),
                                array($fila,$fila+5),
                        )
                ));
                $fila=$fila+6;

                // A - 4 - centro
                $datos_excel="";
                $datos_excel[]=$nombre;
                $sheet->row($fila, $datos_excel);
                $sheet->cells('A'.$fila, function($cells) {
                    $cells->setFontSize(16);
                    $cells->setAlignment('left');
                });
                $sheet->setBorder('A'.$fila, 'thin');
                $fila=$fila+12;
            }
        });
    })->export('xlsx');
?>
