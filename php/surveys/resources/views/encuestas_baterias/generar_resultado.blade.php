<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Redirect;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\EncuestaControllers;

use PDF;

//echo "id_au=".$id_au; return;

?>

@include('layout.pruebas.header')

<!-- CONTENIDO -->
<div id="encuesta">
{{ EncuestaControllers::generar_resultado_epa($id_au) }}
</div>

@include('layout.pruebas.footer')