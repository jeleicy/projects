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
		<br /><br /><br />
		<div class='alert alert-info'>
			<strong>Estimada Sr(a). <?=$candidato?>, Muchas gracias por presentar nuestra encuesta IOL.
			<br /><br />Ha sido reenviada su reporte de presentacion de la prueba IOL</strong>";
		</div>
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


