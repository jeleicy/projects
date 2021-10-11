<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>
@include('layaout.header_admin')

{!! Form::open(array('url' => 'consulta_de_centros', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<input type="hidden" name="id_estado" value="<?php echo $estado; ?>" />
<input type="hidden" name="id_municipio" value="<?php echo $municipio; ?>" />
<input type="hidden" name="id_parroquia" value="<?php echo $parroquia; ?>" />
<br />

<br />
<legend>Busqueda centros de votaci&oacute;n</legend>
<br />

<br />
<?php
if ($mensaje!="")
    echo '<div class="error" align="center">'.$mensaje.'</div><br />';
?>
<div class="form-group">
    <label class="control-label col-xs-3">Nombre Centro:</label>
    <div class="col-xs-9">
        <input name="nombre" type="text" class="form-control" placeholder="Nombre Centro" value="<?php echo $nombre; ?>" />
        <br />
        <div id="nombre_observador"></div>
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

        <div class="col-xs-3">
        <span id="ver_parroquia">
            <select name="parroquia" class="form-control" id="parroquia" onchange="ver_centro_jquery(this.form)">Seleccione Parroquia...</select>
        </span>
        </div>
    </div>
<br /><br />
<div align="center">
    <input class="btn btn-primary" type="submit" name="Buscar" value="Buscar" onclick="buscar_centros(this.form)" />
</div>
<br />
<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Estado</th>
        <th>Municipio</th>
        <th>Parroquia</th>
        <th>C&oacute;digo</th>
    </tr>
    </thead>
    <tbody>
    <?php
   //  {
        $sql = "select c.* ";
        $sql .= "from centro c, asignacion a ";
        //if ($nombre!="" || $estado!=0 || $municipio!=0 || $parroquia!=0)
        $sql .= "where ";

        if ($nombre!="")
            $sql .= "c.nombre like '".strtoupper($nombre)."%' and ";

        if ($estado!=0)
            $sql .= "c.estado=$estado and ";

        if ($municipio!=0)
            $sql .= "c.municipio=$municipio and ";

        if ($parroquia!=0)
            $sql .= "c.parroquia=$parroquia and ";

        $sql .= " a.id_centro=c.id_centro ";

        /*if ($nombre!="" || $estado!=0 || $municipio!=0 || $parroquia!=0)
            $sql = substr($sql,0,strlen($sql)-4);*/

        $sql .= " order by nombre, codigo ";
//echo $sql;
        $data = DB::select($sql);
        foreach ($data as $data) {
            $nombre = $data->nombre;
            $estado_data = $data->estado;
            $municipio_data = $data->municipio;
            $parroquia_data = $data->parroquia;
            $codigo = $data->codigo;
            $direccion = $data->direccion;
            $electores = $data->electores;
            $id_centro = $data->id_centro;
            ?>
            <tr>
                <td onclick="ver_centro(<?php echo $id_centro; ?>)" style="cursor:pointer"><?php echo $nombre; ?></td>
                <td onclick="ver_centro(<?php echo $id_centro; ?>)" style="cursor:pointer"><?php echo FuncionesControllers::buscar_entidad($estado_data, 0, 0, 'estado'); ?></td>
                <td onclick="ver_centro(<?php echo $id_centro; ?>)" style="cursor:pointer"><?php echo FuncionesControllers::buscar_entidad($estado_data, $municipio_data, 0, 'municipio'); ?></td>
                <td onclick="ver_centro(<?php echo $id_centro; ?>)" style="cursor:pointer"><?php echo FuncionesControllers::buscar_entidad($estado_data, $municipio_data, $parroquia_data, 'parroquia'); ?></td>
                <td onclick="ver_centro(<?php echo $id_centro; ?>)" style="cursor:pointer"><?php echo $codigo; ?></td>
            </tr>
            <?php
        }
    //}
    ?>
    </tbody>
</table>
<br /><br />
<div align="center">
    <input class="btn btn-primary" type="button" name="Imprimir Tablero" value="Imprimir Tablero" onclick="imprimir_tablero('A', this.form)" />
    <!--input class="btn btn-primary" type="button" name="Imprimir Listado" value="Imprimir Listado" onclick="imprimir_listado(this.form)" /-->
</div>
<br /><br />
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