<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>
@include('layaout.header_admin')

{!! Form::open(array('url' => 'buscar_listado_recuperacion', 'method' => 'post', 'class' =>  "form-horizontal")) !!}

<input type="hidden" name="id_eleccion" value="1" />
<input type="hidden" name="id_observador" value="" />
<input type="hidden" name="id_encuesta" value="" />
<input type="hidden" name="numero" value="" />
<input type="hidden" name="recuperacion" value="" />
<input type="hidden" name="buscar_observ" value="" />
<input type="hidden" name="cedula" value="<?=$cedula?>" />

    <legend>Listado de Recuperaci&oacute;n</legend>
    <br />
    <?php
    $sql = "select count(id_recuperacion) as cantidad from recuperacion";
    $data=DB::select($sql);
    foreach ($data as $data);
        $cantidad=$data->cantidad;
    if ($cantidad==0)
        echo "<div align='center' class='error'>No hay recuperaciones pendientes !!!</div><br>";
    else {
    ?>

<div class="form-group">
    <label class="control-label col-xs-3">Estado:</label>
    <div class="col-xs-3">
        <select name="estado" id="estado" class="form-control">
            <option value=0>Todos los Estado...</option>
            <?php
            $sql = "select * from estado order by nombre";
            $data=DB::select($sql);
            foreach ($data as $data) {
            if (($estado>0) && ($estado==$data->id_estado)) {
            ?>
            <option value="<?php echo $data->id_estado; ?>" selected><?php echo $data->nombre; ?></option>
            <?php
            } else {
            ?>
            <option value="<?php echo $data->id_estado; ?>"><?php echo $data->nombre; ?></option>
            <?php
            }
            }
            ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-3">Tipo de Recuperacion:</label>
    <?php
        $sql = "select distinct(nro_recuperacion) as recuperacion ";
        $sql .= "from recuperacion order by 1";
        $data=DB::select($sql);
        foreach ($data as $data) {
    ?>
    <div class="col-xs-2">
        <label class="radio-inline">
            <input class="chk" type="radio" name="recuperado" id="recuperado" value="<?php echo $data->recuperacion; ?>" <?php if ($recuperado==$data->recuperacion) echo "checked"; ?>>Nivel <?php echo $data->recuperacion; ?>
        </label>
    </div>
<?php } ?>
</div>

<div class="form-group">
    <label class="control-label col-xs-3">Buscar por Cedula:</label>
    <div class="col-xs-9">
        <input name="cedula" type="text" class="form-control" placeholder="Cedula" value="<?php echo $cedula; ?>" <?php if ($cedula!="" && SessionusuarioControllers::show("privilegio")!="1") echo " readonly "; ?> onkeypress="return numeros(event)">
    </div>
</div>

    <br />
    <div align="center">
        <input class="btn btn-primary" type="button" id="buscar" name="Buscar" value="Buscar" onclick="buscar_recuperacion(this.form)" />
    </div>

    <br /><br />

    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>

        <tr class="fondo3">
            <th>Cedula</th>
            <th>Observador</th>
            <th>Estado</th>
            <th>Nro. Recuperacion</th>
            <th>Tel&eacute;fonos</th>
            <th>Reporte</th>
            <th>Falla</th>
            <th>Operador</th>
            <th>Observaciones</th>
            <th>Hora</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "select distinct(r.id_encuesta), o.id_observador, ";
        $sql .= "o.nombres, o.apellidos, e.nombre as estado, ";
        $sql .= "r.nro_recuperacion as nivel, r.id_encuesta, o.tlfcel, o.tlfhab, o.tlfotro, ";
        $sql .= "en.nroreporte, r.falla, r.observ_rec1, observ_rec2, ";
        $sql .= "observ_rec3, max(r.hora_ingreso) as hora_ingreso, o.cedula, a.id_asignacion ";
        $sql .= "from observador o, estado e, recuperacion r, asignacion a, centro c, encuesta en ";
        $sql .= "where o.id_observador=r.id_observador and ";
        $sql .= "o.id_observador=a.id_observador and ";
        $sql .= "a.id_eleccion=$eleccion and a.id_centro=c.id_centro and ";
        if ($estado>0)
            $sql .= "c.estado=$estado and ";
        $sql .= "e.id_estado=c.estado and r.id_eleccion=a.id_eleccion and ";
        $sql .= "r.recuperado=0 and ";
        $sql .= "r.nro_recuperacion=$recuperado and r.id_asignacion=a.id_asignacion and ";
        $sql .= "r.bloqueo=0 and en.id_encuesta=r.id_encuesta ";
        if ($cedula!=0 && $cedula!="")
            $sql .= " and o.cedula=$cedula ";
        $sql .= " group by a.id_asignacion";
        $sql .= " order by r.hora_ingreso desc";
        $data=DB::select($sql);
        //echo $sql;

        foreach ($data as $data) {
            if ($data->nombres!=null) {
                if (FuncionesControllers::no_recuperado($data->id_asignacion,$data->nroreporte)==true) {
                    ?>
                    <tr valign="top">
                        <td><?php echo number_format($data->cedula,0,"","."); ?></td>
                        <td><?php echo $data->nombres." ".$data->apellidos ?></td>
                        <td><?php echo $data->estado ?></td>
                        <td align="center"><?php echo $data->nivel ?></td>
                        <td><?php echo "Hab: <strong>".$data->tlfhab."</strong> <br />Cel: <strong>".$data->tlfcel."</strong> <br />Alternativo: <strong>".$data->tlfotro."</strong>"; ?></td>
                        <td align="center"><?php echo $data->nroreporte ?></td>
                        <td align="center"><?php echo FuncionesControllers::buscar_falla($data->falla); ?></td>
                        <?php
                        $sql = "select id_operador from asignacion_operador where id_observador=".$data->id_observador;

                        $data2=DB::select($sql);
                        $id_operador=0;
                        foreach ($data2 as $data2)
                            $id_operador=$data2->id_operador;

                        $cod_operador=$id_operador;
                        ?>
                        <td><?php echo FuncionesControllers::buscar_operador($cod_operador); ?></td>
                        <td align="center">
                            <?php
                            if ($recuperado==1)
                                echo "<strong>Recup 1</strong>: ".$data->observ_rec1;
                            elseif ($recuperado==2)
                                echo "<strong>Recup 1</strong>: ".$data->observ_rec1."<br /><strong>Recup 2</strong>: ".$data->observ_rec2;
                            elseif ($recuperado==3)
                                echo "<strong>Recup 1</strong>: ".$data->observ_rec1."<br /><strong>Recup 2</strong>: ".$data->observ_rec2."<br /><strong>Recup 3</strong>: ".$data->observ_rec3;
                            ?>
                        </td>
                        <td align="center"><?php echo substr($data->hora_ingreso,strpos($data->hora_ingreso," ")+1); ?></td>
                        <td><a class="link_recuperar" href="javascript:;" onclick="recuperar_dato(<?php echo $eleccion; ?>, <?php echo $data->id_observador; ?>, <?php echo $data->id_encuesta; ?>)">Recuperar</a></td>
                    </tr>
                    <?php
                    }
                }
            }
        ?>
        </tbody>
    </table>
    <br />

    <?php
    $path = "excel";
    $dir = opendir($path);
    $datos_emergencias=0;
    while ($elemento = readdir($dir)) {
        if ($elemento=="datos_emergencias.xls")
            $datos_emergencias=1;
    }
    closedir($dir);
    ?>

    <div align="center">
        <!--input class="btn btn-primary" type="button" id="buscar" name="Imprimir" value="Imprimir Listado" onclick="imprimir_listado_recuperacion(this.form, <?php echo $recuperado; ?>, <?php echo $estado; ?>)" />
        <br /><br /><br /-->
        <a href="javascript:;" class="ver_mas" onclick="ver_excel('exportar_excel_recuperacion/id_eleccion=1,recuperado=<?php echo $recuperado; ?>')">
            Exportar Listado a Excel
        </a>
        <?php if ($datos_emergencias==1) { ?> (<a class="ver_mas_resaltado" href="excel/datos_emergencias.xls">Archivo Generado datos emergencia</a>) <?php } ?>
    </div>
<?php } ?>
{!! Form::close() !!}
@include('layaout.footer_admin')