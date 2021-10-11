<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use URL;
use App\Http\Controllers\FuncionesControllers;

?>

<br /><br />

<span style="font-family: Verdana; font-size: 12pt;">
	{{ trans('iol_test.estimada') }} {{ trans('iol_test.sr') }}: <?php echo strtoupper($nombres); ?>

	<br /><br />
	<?=$texto_email?>
</span>
<br /><br />

<!--{{ trans('iol_test.firma1') }}, <br />
{{ trans('iol_test.write') }}<a href="mailto:soporte@talentskey.com">soporte@talentskey.com</a><br />
Julio C. Peña<br />
Soporte Talents Key<br />
Telf. Ofic.: 0212 731 23 50<br />
Cel.: 0414 324 03 88<br /-->

Para cualquier duda o necesidad al respecto, <br />
escribe al correo <a href="mailto:soporte@talentskey.com">soporte@talentskey.com</a><br />
{{ Session::get("nombre") }}<br />
Soporte Talents Key<br />
Telf. Ofic.: 0212 731 23 50<br />
Cel.: 0414 324 03 88<br />

<br /><br />

<!--img src="{{ URL::asset('imagenes/logo_baltico.jpg') }}"-->
<img src="{{ URL::asset('imagenes/mth.png') }}">