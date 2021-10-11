<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

?>
@include('layaout.header_admin')
<br />
{!! Form::open(array('url' => 'guardar_candidato', 'method' => 'post', 'class' =>  "form-horizontal")) !!}

<input type="hidden" name="id_estado" value="<?php echo $estado; ?>" />
<input type="hidden" name="id_municipio" value="<?php echo $municipio; ?>" />
<input type="hidden" name="id_parroquia" value="<?php echo $parroquia; ?>" />
<input type="hidden" name="id_candidato" value="<?php echo $id_candidato; ?>" />

<legend>Candidatos</legend>
<br />

<br /><br />
<?php
if ($id_candidato>0) {
    $sql = "select * from candidato where id_candidato=$id_candidato";
    $data=DB::select($sql);
    foreach ($data as $data) {
        $nombre = $data->nombre;
        $partido = $data->partido;
        $id_eleccion = $data->id_eleccion;
        $estado= $data->id_estado;
        $municipio= $data->id_municipio;
        $codm= $data->codm;
        $tendencia= $data->tendencia;
    }
}

if ($mensaje!="")
    echo '<div class="error" align="center">'.$mensaje.'</div><br />';
?>
<div class="form-group">
    <label class="control-label col-xs-3">Nombre:</label>
    <div class="col-xs-9">
        <input name="nombre" type="text" class="form-control" placeholder="Nombre" value="<?php echo $nombre; ?>">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-xs-3">Partido:</label>
    <div class="col-xs-9">
        <input name="partido" type="text" class="form-control" placeholder="Partido" value="<?php echo $partido; ?>">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-xs-3">Estado:</label>
    <div class="col-xs-3">
        <select name="estado" id="estado" onchange="ver_municipio_jquery(this.form);" class="form-control">
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

    <div class="col-xs-3">
            <span id="ver_municipio">
                <select name="municipio" id="municipio" class="form-control" onchange="ver_parroquia_jquery(this.form)">Seleccione Municipio...</select>
            </span>
    </div>

</div>
<div class="form-group">
    <label class="control-label col-xs-3">Codm:</label>
    <div class="col-xs-9">
        <input name="codm" type="text" class="form-control" placeholder="Codm" value="<?php echo $codm; ?>" onkeypress="return numeros(event)">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-xs-3">Tendencia:</label>
    <div class="col-xs-9">
        <input name="tendencia" type="text" class="form-control" placeholder="Tendencia" value="<?php echo $tendencia; ?>" onkeypress="return numeros(event)">
    </div>
</div>
<br /><br />
<div align="center">
    <input class="btn btn-primary" type="button" name="Guardar" value="Guardar" onclick="validar_candidato(this.form)" />
    <input class="btn btn-primary" type="reset" value="Limpiar">
</div>

<br /><br />
<div class="error" align="center">Todos los campos marcados con (*) son obligatorios</div>
<br /><br />

<br />
<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>Nombre</th>
        <th>Partido</th>
        <th>Estado/Municipio/Parroquia</th>
        <th>Eleccion</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $numero=1;
    $sql = "select c.*, e.nombre as estado, m.nombre as municipio, p.nombre as parroquia ";
    $sql .= "from candidato c, estado e, municipio m, parroquia p ";
    $sql .= "where e.id_estado=m.id_estado and ";
    $sql .= "m.id_municipio=p.id_municipio and p.id_estado=m.id_estado and p.id_estado=e.id_estado ";
    $sql .= "and c.id_estado=e.id_estado and c.id_municipio=m.id_municipio ";
    $sql .= "order by c.nombre, c.partido";
    //echo $sql;

    $data=DB::select($sql);
    $i=1;
    foreach ($data as $data) {
    if ($i==1) $i=2;
    else $i=1;

    $nombre = $data->nombre;
    $partido = $data->partido;
    $id_eleccion = $data->id_eleccion;
    $id_candidato = $data->id_candidato;

    $estado = $data->estado;
    $municipio = $data->municipio;
    $parroquia = $data->parroquia;
    ?>
    <tr>
        <td onclick="ver_candidato(<?php echo $id_candidato; ?>)" style="cursor:pointer"><?php echo $numero; ?></td>
        <td onclick="ver_candidato(<?php echo $id_candidato; ?>)" style="cursor:pointer"><?php echo $nombre; ?></td>
        <td onclick="ver_candidato(<?php echo $id_candidato; ?>)" style="cursor:pointer"><?php echo $partido; ?></td>
        <td onclick="ver_candidato(<?php echo $id_candidato; ?>)" style="cursor:pointer"><?php echo $estado." / ".$municipio." / ".$parroquia; ?></td>
        <td onclick="ver_candidato(<?php echo $id_candidato; ?>)" style="cursor:pointer"><?php echo FuncionesControllers::buscar_eleccion($id_eleccion); ?></td>
        <td><img style="cursor:pointer" src="assets/images/cancel.gif" onclick="eliminar_candidato(<?php echo $id_candidato; ?>)" /></td>
    </tr>
    <?php
    $numero++;
    }
    ?>
    </tbody>
</table>

<script>
    var f = eval("document.forms[0]");
    f.id_estado.value=<?php echo $estado; ?>;
    f.id_municipio.value=<?php if ($municipio=="") $municipio=0; echo $municipio; ?>;
    f.id_parroquia.value=<?php if ($parroquia=="") $parroquia=0;  echo $parroquia; ?>;
    ver_municipio_jquery(f);
    ver_parroquia_jquery(f);
</script>

{!! Form::close() !!}
@include('layaout.footer_admin')