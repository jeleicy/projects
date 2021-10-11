<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use Form;
use DB;
use Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\FuncionesControllers;
use URL;

$ruta="";

if (strpos($_SERVER["REQUEST_URI"],"recordar") !== false || strpos($_SERVER["REQUEST_URI"],"consultarusuario") !== false || strpos($_SERVER["REQUEST_URI"],"eliminar_evaluacion") !== false)
	$ruta="../";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Encuesta de Potencial</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">	

    <!-- MetisMenu CSS -->
    <link href="{{ URL::asset('bp/bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <!--link href="{{ URL::asset('bp/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet"-->

    <!-- DataTables Responsive CSS -->
    <!--link href="{{ URL::asset('bp/bower_components/datatables-responsive/css/dataTables.responsive.css') }}" rel="stylesheet"-->

    <!-- Custom CSS -->
    <link href="{{ URL::asset('bp/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ URL::asset('bp/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">		

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!--funciones-->
	<script src="{{ URL::asset('js/funciones.js') }}"></script>
	
	<!--COMIENZO OTROS-->
    <!--link href="{{ URL::asset('fonts/css/font-awesome.min.css') }}" rel="stylesheet"-->
    <link href="{{ URL::asset('css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/icheck/flat/green.css') }}" rel="stylesheet">	
	<!--FIN OTROS-->
	
    <!-- select2 -->
    <link href="{{ URL::asset('css/select/select2.min.css') }}" rel="stylesheet">	
	
	<script>
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
		window.onhashchange=function(){window.location.hash="no-back-button";}
	</script>
	
	<!--FECHA-->
    <!--link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" media="screen"-->
    <link href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">
	<!--FECHA-->
</head>

<body>
<!--
 * parallax_login.html
 * @Author original @msurguy (tw) -> http://bootsnipp.com/snippets/featured/parallax-login-form
 * @Tested on FF && CH
 * @Reworked by @kaptenn_com (tw)
 * @package PARALLAX LOGIN.
-->
<br />
<?php
    if ($mensaje=="error")
        echo "<div class='alert alert-danger'><strong>Debe estar autenticado en nuestro sistema</strong></div>";
    elseif ($mensaje=="error_autenticacion")
        echo "<div class='alert alert-danger'><strong>Usuario y/o Contraseña invalidos</strong></div>";
 ?>

{!! Form::open(array('url' => 'verificar_usuario', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
	<input type="hidden" name="mensaje" value="">
<br /><br /><br /><br />
<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row-fluid user-row" align="center">
                        <img src="{{ URL::asset('imagenes/app.gif') }}" class="img-responsive" alt="Sign In"/>
                    </div>
                </div>
                <div class="panel-body">
                        <fieldset>
                            <input value="" autocomplete="off" placeholder="Email" class="form-control" placeholder="Username" name="username" id="username" type="text">
                            <input value="" data-validate-length="6,8" type="password" placeholder="Password" class="form-control" name="password" id="password">
                            <br />
							<div id="boton_2" align="center">
								<input type="submit" class="btn btn-primary" value="Ingresar">
							</div>
                        </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}

{!! Form::open(array('url' => 'comprar_prueba', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<div id="boton_2" align="center">
	<input type="submit" class="btn btn-primary" value="Deseo Comprar una Prueba">
</div>
{!! Form::close() !!}

</body>
</html>