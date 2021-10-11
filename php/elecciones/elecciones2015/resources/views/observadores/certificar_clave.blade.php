<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

?>
@include('layaout.header_admin')
<?php
    //echo hash('ripemd160',"RedObservacion2015");
?>
{!! Form::open(array('url' => 'certificar_clave', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<input type="hidden" name="id_asignacion" value="<?php echo $id_asignacion; ?>" />
<input type="hidden" name="id_observador" value="<?php echo $id_observador; ?>" />
<input type="hidden" name="reporte" value="<?php echo $reporte; ?>" />

<legend>Clave de Seguridad para revertir Planillas</legend>

<div class="form-group">
    <label class="control-label col-xs-3">Contrase&ntilde;a:</label>
    <div class="col-xs-9">
        <input name="contrasena" type="password" class="form-control" placeholder="Contrase&ntilde;a"">
    </div>
</div>

<div class="form-group">
    <div class="col-xs-offset-3 col-xs-9">
        <input  class="btn btn-primary" type="submit" name="Validar" value="Validar" />
        <input type="reset" class="btn btn-default" value="Limpiar">
    </div>
</div>

{!! Form::close() !!}
@include('layaout.footer_admin')