<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

@include('layaout.header_admin')
<!-----------------------CONTENIDO---------------------------------->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Estadisticas / Reportes</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check-circle fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php FuncionesControllers::nro_planillas_procesadas(); ?></div>
                                    <div>Planillas Procesadas!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"><a href="listado_planillas">Mas detalle...</a></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-exclamation-triangle fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php FuncionesControllers::nro_planillas_cobertura(); ?></div>
                                    <div>Coberturas!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"><a href="estadistica_cobertura">Mas detalle...</a></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-area-chart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo FuncionesControllers::nro_estados_procesadas(); ?></div>
                                    <div>Estados Procesados!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"><a href="estadisticas">Mas detalle...</a></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <!-- /#page-wrapper -->

<?php
    $sql = "select sum(v.cantidad), c.nombre, c.partido, v.id_encuesta, e.nombre as estado ";
    $sql .= "from votos v, candidato c, asignacion a, observador o, estado e ";
    $sql .= " where v.id_candidato=c.id_candidato and c.id_estado=o.id_estado and ";
    $sql .= "a.id_asignacion=v.id_asignacion and a.id_observador=o.id_observador and e.id_estado=o.id_estado ";
    $sql .= "group by c.nombre, c.partido, v.id_encuesta, e.nombre";
    $data=DB::select($sql);
    $reporte="";

?>
    <?php
        $sql = "select distinct(id_encuesta) as encuesta ";
        $sql .= "from votos v, asignacion a, observador o ";
        $sql .= "where v.id_asignacion=a.id_asignacion and a.id_observador=o.id_observador and o.id_estado=12 ";
        $sql .= "order by 1";
        $data2=DB::select($sql);
        $encuesta=array();
        foreach ($data2 as $data2)
            $encuesta[]=$data2->encuesta;
    ?>

    <?php
        $sql = "select e.id_estado, e.nombre as estado ";
        $sql .= "from votos v, asignacion a, observador o, estado e ";
        $sql .= "where v.id_asignacion=a.id_asignacion and a.id_observador=o.id_observador and v.id_encuesta=3 and e.id_estado=o.id_estado ";
        $sql .= "order by 1";
        $data4=DB::select($sql);
        $estado=array();
        foreach ($data4 as $data4)
            $estado[$data4->id_estado]=$data4->estado;
    ?>

    <?php
        $sql = "select distinct(partido) as partido ";
        $sql .= "from votos v, asignacion a, observador o, candidato c ";
        $sql .= "where v.id_asignacion=a.id_asignacion and a.id_observador=o.id_observador and ";
        $sql .= "o.id_estado=12 and c.id_candidato=v.id_candidato order by 1";

        $data3=DB::select($sql);
        $partidos="";
        $partido=array();
        foreach ($data3 as $data3) {
            $partido[]=$data3->partido;
        }
        $partidos=substr($partidos,0,strlen($partidos)-1);
    ?>

<?php
    $i=1;
        if (!empty($estado)) {
    foreach ($estado as $key=>$value) {
?>
<h1>Estadisticas de Votos para: <?php echo $value; ?></h1>
<div id="graph<?php echo $i; ?>"></div>
<script>

// Use Morris.Bar
Morris.Bar({
  element: 'graph<?php echo $i; ?>',
  data: [
    <?php
        $sql = "select sum(v.cantidad) as cantidad, c.partido ";
        $sql .= "from votos v, candidato c, asignacion a, observador o, estado e ";
        $sql .= "where v.id_candidato=c.id_candidato and c.id_estado=o.id_estado and ";
        //$sql .= "v.id_encuesta=".$encuesta[$i];
        $sql .= " a.id_asignacion=v.id_asignacion and a.id_observador=o.id_observador and e.id_estado=o.id_estado and ";
        $sql .= " e.id_estado=".$key;
        $sql .= " group by c.partido order by 1 desc";
        //echo $sql;
        $data=DB::select($sql);
        foreach ($data as $data) {
            echo "{x: '".$data->partido."'";
            echo ", 'Votos':".$data->cantidad."},";
            $partidos=$data->partido;
        }
    ?>
  ],
  xkey: 'x',
  ykeys: ['Votos'],
  labels: ['Votos']
}).on('click', function(i, row) {
  console.log(i, row);
});
</script>
<?php
        $i++;
    }}
?>
<!-----------------------CONTENIDO---------------------------------->

@include('layaout.footer_admin')