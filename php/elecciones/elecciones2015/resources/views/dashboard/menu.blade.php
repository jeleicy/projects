<?php namespace app\Http\Controllers;
	use Session;
	use App\Http\Controllers\FuncionesControllers;
?>
<!-- INICIO MENU -->
<ul class="nav navbar-nav side-nav">
{{ FuncionesControllers::crear_menu(SessionusuarioControllers::show("privilegio")) }}
</ul>
<!-- FIN MENU -->