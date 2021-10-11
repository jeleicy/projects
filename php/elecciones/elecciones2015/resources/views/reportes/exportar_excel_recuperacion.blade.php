<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use App\Http\Controllers\FuncionesControllers;
use Excel;

Excel::create('datos_emergencia', function($excel) use($id_eleccion,$recuperado)  {
    $excel->sheet('datos_emergencia', function($sheet) use($id_eleccion,$recuperado) {

        $titulos=array("Cod. Centro","Nro. Mesa","Tipo de Emergencia", "Numero electores", "Estratos", "Nro Recuperacion");
        $sheet->row(1, $titulos);

        $sql = "select distinct(c.codigo) as codigo, a.nro_mesa, r.falla, um.nro_votantes, ";
        $sql .= "c.estrato, r.nro_recuperacion ";
        $sql .= "from recuperacion r, asignacion a, centro c, universo_mesa um  ";
        $sql .= "where a.id_eleccion=$id_eleccion and  ";
        $sql .= "a.id_centro=c.id_centro and  ";
        $sql .= "r.id_eleccion=a.id_eleccion and  ";
        $sql .= "r.recuperado=0 and r.id_asignacion=a.id_asignacion and ";
        $sql .= "r.nro_recuperacion=$recuperado and um.codigo_centro=c.id_centro and ";
        $sql .= "um.cod_mesa=a.nro_mesa";

        $data=DB::select($sql);
        $fila=2;
        foreach ($data as $data) {
            $datos="";
            $datos[]=$data->codigo;
            $datos[]=$data->nro_mesa;
            //$datos[]=FuncionesControllers::buscar_falla($data->falla);
            if ($data->falla==1)
                $falla="Emergencia";
            else
                $falla="Data Incompleta";
            $datos[]=$falla;
            $datos[]=$data->nro_votantes;
            $datos[]=$data->estrato;
            $datos[]=$data->nro_recuperacion;

            $sheet->row($fila, $datos);
            $fila++;
        }
    });
})->export('xls');
?>