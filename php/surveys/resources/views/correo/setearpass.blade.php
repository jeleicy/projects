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
	Estimada Sr(a): <?php echo strtoupper($nombre); ?>
	<br /><br />
	Su Contraseña ha sido cambiada satisfactoriamente.<br /><br />
	Ahora para ingresar a nuestro sistema debera hacerlo con los siguientes datos:<br /><br />
	Email: {{ $email }}
	<br />
	Contraseña: {{ $clave }}
</span>
<br /><br />

Para cualquier duda o necesidad al respecto, <br />
escribe al correo <a href="mailto:soporte@talentskey.com">soporte@talentskey.com</a><br />
Julio C. Peña<br />
Soporte Talents Key<br />
Telf. Ofic.: 0212 731 23 50<br />
Cel.: 0414 324 03 88<br />

<br /><br />

<img src="{{ URL::asset('imagenes/app.gif') }}">