<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use URL;
use App\Http\Controllers\FuncionesControllers;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Red de Observacion</title>


    <!--FUNCIONES DATATABLE-->
    <link rel="stylesheet" href="{{ URL::asset('assets/datatables/DataTables-1.10.9/css/jquery.dataTables.min.css') }}" />
    <style type="text/css" class="init">

    </style>
    <script type="text/javascript" src="{{ URL::asset('assets/datatables/jQuery-2.1.4/jquery-2.1.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/datatables/DataTables-1.10.9/js/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript" class="init">
        $(document).ready(function() {
            $('#example').DataTable( {
                columnDefs: [ {
                    targets: [ 0 ],
                    orderData: [ 0, 1 ]
                }, {
                    targets: [ 1 ],
                    orderData: [ 1, 0 ]
                }, {
                    targets: [ 4 ],
                    orderData: [ 4, 0 ]
                } ]
            } );
        } );

    </script>
<body>
    <table id="example" class="display" cellspacing="0" width="80%">
        <thead>
		<tr>
	<th>Estrato</th>
	<th>Reporte</th>
    <th>Estado</th>
    <th>Municipio</th>
    <th>Parroquia</th>
    <th>Observador</th>
    <th>Centro</th>
    <th>Mesa</th>
  </tr>
  </thead>
  <tbody>
  <?php
	$sql = "select distinct(pre.id_encuesta), o.nombres, o.apellidos, edo.nombre as estado, mun.nombre as municipio, ";
	$sql .= "par.nombre as parroquia, c.nombre as centro, c.codigo, a.nro_mesa, c.estrato ";
	$sql .= "from encuesta_observador eo, observador o, asignacion a, centro c, estado edo, municipio mun, parroquia par, pregunta pre, encuesta enc ";
	$sql .= "where eo.id_observador=o.id_observador and a.id_observador=o.id_observador and ";
	$sql .= "a.id_centro=c.id_centro and c.estado=edo.id_estado and c.municipio=mun.id_municipio and c.estado=mun.id_estado and mun.id_estado and ";
	$sql .= "c.parroquia=par.id_parroquia and par.id_estado=mun.id_estado and par.id_municipio=c.municipio and ";
	$sql .= "pre.id_pregunta=eo.id_pregunta and pre.id_encuesta=enc.id_encuesta and ";
	
	if ($estado>0)
		$sql .= "edo.id_estado=$estado and ";
		
	if ($municipio>0)
		$sql .= "mun.id_municipio=$municipio and ";
		
	if ($parroquia>0)
		$sql .= "par.id_parroquia=$parroquia and ";
	
	if ($reporte>0)
		$sql .= "pre.id_encuesta=$reporte and ";
	
	$sql = substr($sql,0,strlen($sql)-5);
	$sql .= " order by pre.id_encuesta, o.nombres, o.apellidos, estado, municipio, parroquia, centro, a.nro_mesa";	
	//echo $sql;
	$data=DB::select($sql);
	
	$i=1;
	foreach ($data as $data) {
	?>
	  <tr>
		<td><?php echo $data->estrato; ?></td>
		<td><?php echo "Reporte ".$data->id_encuesta; ?></td>
		<td><?php echo $data->estado; ?></td>
		<td><?php echo $data->municipio; ?></td>
		<td><?php echo $data->parroquia; ?></td>
		<td><?php echo $data->nombres." ".$data->apellidos; ?></td>
		<td><?php echo $data->centro." (".$data->codigo.")"; ?></td>
		<td><?php echo $data->nro_mesa; ?></td>
	  </tr>	
	<?php
	}
  ?>
  </tbody>
</table>
<br />
<div align="center"><input class="btn btn-primary" type="button" name="Imprimir" value="Imprimir Listado" onclick="window.print()" /></div>
<br />
</body>
</html>