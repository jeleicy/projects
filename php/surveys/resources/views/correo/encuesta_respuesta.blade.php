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
			<strong>{{ trans('iol_test.estimada') }} {{ trans('iol_test.sr') }}. <?=$candidato?>, <br /><br />
			{{ trans('iol_test.gracias') }}.
			<?php if ($perfil=="Invalido") {
				echo "<br /><br />Este perfil de Orientación Laboral muestra una perspectiva indefinida, <br />
				(un tanto confusa o conflictuada) propia de un profesional que se encuentra en una 
				etapa de <br />transición, aún no completada del todo, por factores de diversas índoles 
				(personal / laboral).";
			} else {
				echo "<br /><br />".$texto_correo."</strong>";
			} ?>		
		</div>
</span>
<br /><br />
<!--
{{ trans('iol_test.firma1') }}, <br />
{{ trans('iol_test.write') }}<a href="mailto:soporte@talentskey.com">soporte@talentskey.com</a><br />
Julio C. Peña<br />
Soporte Talents Key<br />
Telf. Ofic.: 0212 731 23 50<br />
Cel.: 0414 324 03 88<br />-->

<br /><br />

<img src="{{ URL::asset('imagenes/app.gif') }}">


