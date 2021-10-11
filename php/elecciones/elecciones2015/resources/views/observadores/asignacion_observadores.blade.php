<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

?>
@include('layaout.header_admin')
{!! Form::open(array('url' => 'asignacion_observadores', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<input type="hidden" name="id_estado" value="<?php echo $estado; ?>" />
<input type="hidden" name="id_municipio" value="<?php echo $municipio; ?>" />
<input type="hidden" name="id_parroquia" value="<?php echo $parroquia; ?>" />
<input type="hidden" name="id_centro" value="<?php echo $centro; ?>" />
<input type="hidden" name="id_asignacion" value="<?php echo $id_asignacion; ?>" />
<input type="hidden" name="id_operador" value="<?php echo $id_operador; ?>" />
<input type="hidden" name="id_observador" value="<?php echo $id_observador; ?>" />
<legend>Asignaciones</legend>
<br />

<br /><br />
<?php
if ($id_asignacion>0) {
    $sql = "select a.id_asignacion, o.id_observador, c.id_centro, ";
    $sql .= "e.id_eleccion, a.nro_mesa ";
    $sql .= "from eleccion e, observador o, centro c, asignacion a ";
    $sql .= "where o.id_observador=a.id_observador and ";
    $sql .= "c.id_centro=a.id_centro and ";
    $sql .= "e.id_eleccion=a.id_eleccion ";
    $sql .= "and a.id_asignacion=$id_asignacion";
    $data=DB::select($sql);
    foreach ($data as $data) {
        $id_eleccion=$data->id_eleccion;
        $id_observador=$data->id_observador;
        $id_centro=$data->id_centro;
        $nro_mesa=$data->nro_mesa;
    }
} elseif ($id_observador>0) {
    $sql = "select id_observador ";
    $sql .= "from observador ";
    $sql .= "where id_observador=$id_observador";
    $data=DB::select($sql);
    foreach ($data as $data)
        $id_observador=$data->id_observador;

    $id_eleccion=0;
    $id_centro=0;
    $nro_mesa=0;
}

if ($mensaje!="")
    echo '<div class="error" align="center">'.$mensaje.'</div><br /><br />';

?>
<?php if ($id_asignacion>0) { ?>
    <tr class="fondo1">
        <td align="right">N&uacute;mero de Mesa: </td>
        <td>
            <div id="data_mesas"></div>
        </td>
    </tr>
<?php } ?>
    @include('asignaciones.incluir_observador')
    <!--@include('asignaciones.incluir_operador')-->
    @include('asignaciones.incluir_centro')
<br /><br />
<div align="center">
    <input class="btn btn-primary" type="button" name="Guardar" value="Guardar" onclick="validar_asignacion(this.form)" />
</div>

{!! Form::close() !!}
@include('layaout.footer_admin')