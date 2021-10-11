<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

@include ('layout.header')

<div class="row">
		<div align="left" class="alert alert-success alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			Su pago ha sido procesado exitosamente...
		</div>

</div>

@include ('layout.footer')