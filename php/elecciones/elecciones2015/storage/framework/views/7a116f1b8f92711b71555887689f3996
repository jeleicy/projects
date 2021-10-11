<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Form;
use App\Http\Controllers\SessionusuarioControllers;

?>

<div class="form-group">
    <label class="control-label col-xs-3">Cedula Operador:</label>
    <div class="col-xs-9">
        <input name="cedula_operador" type="text" class="form-control" placeholder="Cedula" value="<?php echo $cedula_operador; ?>" <?php if ($cedula_operador!="" && SessionusuarioControllers::show("privilegio")!="1") echo " readonly "; ?> onkeypress="return numeros(event)">
        <br />
        <div id="nombre_operador"></div>
    </div>
</div>
<div align="center">
    <input class="btn btn-default" type="button" name="Buscar Operador" value="Buscar Operador" onclick="ajax_buscar_observador('operador')" />
</div>
<br />