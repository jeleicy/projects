<?php namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use DB;
    use Session;
    use View;
    use Auth;
    use App\Http\Controllers\FuncionesControllers;
    use Illuminate\Support\Facades\URL;

?>

<?php
        /*
$cedula = isset($_REQUEST["cedula"]) ? $_REQUEST["cedula"] : 0;
$asignacion = isset($_REQUEST["asignacion"]) ? $_REQUEST["asignacion"] : 0;
$reporte = isset($_REQUEST["reporte"]) ? $_REQUEST["reporte"] : 0;
*/

    //cedula=11636273,asignacion=768,reporte=4
    //echo "<br>1)datos1=$datos";
    $cedula=substr($datos,strpos($datos,"cedula=")+7);
   // echo "<br>2)cedula2=$cedula";
    $cedula=substr($cedula,0,strpos($cedula,","));
    //echo "<br>3)cedula3=$cedula";
    $datos=substr($datos,strpos($datos,",")+1);
    $asignacion=substr($datos,strpos($datos,"asignacion=")+11);
    $asignacion=substr($cedula,0,strpos($cedula,","));
    $datos=substr($datos,strpos($datos,",")+1);
    $reporte=substr($datos,strpos($datos,"reporte=")+8);

    $asignacion=FuncionesControllers::buscar_id_asignacion($cedula);
    $id_observador=FuncionesControllers::buscar_id_operador($cedula);
    //echo "$asignacion...$id_observador";

    $sql = "select e.nombre as estado, m.nombre as municipio, c.codigo, c.nombre as centro, a.nro_mesa, o.nombres, o.apellidos, eo.hora ";
    $sql .= "from estado e, municipio m, centro c, observador o, asignacion a, encuesta_observador eo ";
    $sql .= "where e.id_estado=m.id_estado and c.estado=e.id_estado and c.municipio=m.id_municipio ";
   // $sql .= "and eo. ";
    $sql .= "and a.id_asignacion=$asignacion and a.id_centro=c.id_centro and o.id_observador=".$id_observador;
    $data=DB::select($sql);
    echo '<table border="1" width="100%">';
    foreach ($data as $data)
        ?>
        <tr><td>Estado:</td><td><?php echo $data->estado; ?></td></tr>
        <tr><td>Municipio:</td><td><?php echo $data->municipio; ?></td></tr>
        <tr><td>Centro:</td><td><?php if (strlen($data->codigo)==8) echo "0".$data->codigo; else echo $data->codigo; ?> (<?php echo $data->centro ?>)</td></tr>
        <tr><td>Mesa:</td><td><?php echo $data->nro_mesa; ?></td></tr>
        <tr><td>Reporte:</td><td><?php echo $reporte; ?></td></tr>
        <tr><td>Operador:</td><td><?php echo $data->nombres." ".$data->apellidos; ?></td></tr>
        <tr><td>Hora:</td><td><?php echo substr($data->hora,strpos($data->hora," ")+1); ?></td></tr>
</table>

<script>window.print(); window.close();</script>