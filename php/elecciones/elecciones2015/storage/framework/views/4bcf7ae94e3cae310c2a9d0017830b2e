<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

?>

<div class="form-group">
    <label class="control-label col-xs-3">Cedula Observador:</label>
    <div class="col-xs-9">
        <input name="cedula_observador" type="text" class="form-control" placeholder="Cedula" value="<?php echo $cedula_observador; ?>" <?php if ($cedula_observador!="" && SessionusuarioControllers::show("privilegio")!="1") echo " readonly "; ?> onkeypress="return numeros(event)">
        <br />
        <div id="nombre_observador"></div>
    </div>
</div>
<div align="center">
    <input class="btn btn-default" type="button" name="Buscar Observador" value="Buscar Observador" onclick="ajax_buscar_observador('observador')" />
</div>
<br />