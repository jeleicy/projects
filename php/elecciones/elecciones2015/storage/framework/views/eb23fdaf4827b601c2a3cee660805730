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

<div class="form-group">
    <label class="control-label col-xs-3">Centro:</label>
    <div class="col-xs-3">
        <span id="ver_centro">
            <select name="centro" class="form-control" id="centro">Seleccione Centro...</select>
        </span>
    </div>
</div>

<div class="form-group">
    <span id="ver_mesas"></span>
</div>

<script>
    var f = eval("document.forms[0]");
    f.id_estado.value=<?php echo $estado; ?>;
    f.id_municipio.value=<?php if ($municipio=="") $municipio=0; echo $municipio; ?>;
    f.id_parroquia.value=<?php if ($parroquia=="") $parroquia=0;  echo $parroquia; ?>;
    f.id_centro.value=<?php if ($centro=="") $centro=0;  echo $centro; ?>;

    ver_municipio_jquery(f);
    ver_parroquia_jquery(f);
    ver_centro_jquery(f);
    ver_centro_mesas_jquery(f);

    ajax_buscar_observador('operador');
    ajax_buscar_observador('observador');
</script>