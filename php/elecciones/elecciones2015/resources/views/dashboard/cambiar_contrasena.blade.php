<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>
@include('layaout.header_admin')

<?php if ($mensaje=="") { ?>

{!! Form::open(array('url' => 'guardar_cambiar_contrasena', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<?php
        $id_observador=SessionusuarioControllers::show("id_observador");
?>
<input type="hidden" name="id_observador" value="<?php echo $id_observador; ?>" />
<legend>Cambiar Contrase&ntilde;a</legend>
<br />
<br />
<div class="form-group">
    <label class="control-label col-xs-3">Pregunta Secreta:</label>
    <div class="col-xs-9">
        <?php
            $sql = "select pregsec from observador where id_observador=".$id_observador;
            $data = DB::select($sql);
            foreach($data as $data)
                echo $data->pregsec;
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-3">Respuesta Secreta:</label>
    <div class="col-xs-9">
        <input name="respsec" type="text" class="form-control" placeholder="Respuesta Secreta" value="">
    </div>
</div>

<div class="form-group">
    <div class="col-xs-offset-3 col-xs-9">
        <input  class="btn btn-primary" type="button" name="Validar" value="Validar Respuesta" onclick="validar_respuesta(this.form)" />
        <input type="reset" class="btn btn-default" value="Limpiar">
    </div>
</div>

<div id="textos_contrasenas"></div>

{!! Form::close() !!}
<?php } else echo '<br /><br /><div class="error" align="center">'.$mensaje.'</div><br /><br />'; ?>
@include('layaout.footer_admin')