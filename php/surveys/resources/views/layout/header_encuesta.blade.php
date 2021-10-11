<?php namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use Illuminate\Routing\Controller;
	use View;
	use Auth;
	use Validator;
	use Session;
	use DB;
	use Redirect;
	use Illuminate\Support\Facades\Input;
	use App\Http\Controllers\FuncionesControllers;
	use URL;

?>

<!DOCTYPE html>
<html lang="en">

<head bgcolor="#E6E6FA">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Encuestas</title>
	<script>
		var currentTabIndex=0;
	
		var prox_pregunta=1;
		var primera=new Array();
	
		var tocar_ejemplo=0;
	
		var nro_prueba=0;
		var nro_prueba_co=1;
		var preguntas=0;
		var preg_ant=0;
		var opciones=0;
		var resultado=0;	
		var nombre_ant="";
		var opciones_array=[];

		var j=0;
		var mas=0;
		var menos=0;
		var array_preguntas=[];
		var indice_array=0;

		var id_pregunta_co=1;
		var correcto_mas=0;
		var correcto_menos=0;
		var id_pregunta_co=0;
		var pregunta_actual_co=1;
		var respuesta_actual_co= new Array();
		var entrada=0;
		
		var tiempo_co=0;
		var tiempo_hi=0;
		var tiempo_op=0;
		var tiempo_epa=0;
		
		var respuesta_ra=new Array();
		var indice_ra=1;
		
		var respuesta_rv=new Array();
		var respuesta_hn=new Array();
		var respuesta_iep_mas=new Array();
		var respuesta_iep_menos=new Array();
		
		var id_bateria=0;
		var proxima_pagina="";
	</script>
	
	<style>
		#instrucciones{margin:auto; width:auto;min-width: 75%;}
	</style>

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
	
	<!--COMIENZO OTROS-->
    <!--link href="{{ URL::asset('fonts/css/font-awesome.min.css') }}" rel="stylesheet"-->
    <link href="{{ URL::asset('css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom styling plus plugins -->
	
	<?php if (strpos($_SERVER["REQUEST_URI"],"prueba_co/") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_epa_ejemplo") !== false) { ?>
		<link href="{{ URL::asset('css/custom_co.css') }}" rel="stylesheet">
	<?php } elseif (strpos($_SERVER["REQUEST_URI"],"aplicar_encuesta/") !== false || strpos($_SERVER["REQUEST_URI"],"aplicar_encuesta_iol_alt/") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_op/encuesta_5_1_") !== false) { ?>
		<link href="{{ URL::asset('css/custom_iol.css') }}" rel="stylesheet">
	<?php } elseif (strpos($_SERVER["REQUEST_URI"],"prueba_hi") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_epa_resto") !== false) { ?>
		<link href="{{ URL::asset('css/custom_hi.css') }}" rel="stylesheet">
	<?php } elseif (strpos($_SERVER["REQUEST_URI"],"prueba_op/") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_sl") !== false) { ?>
		<link href="{{ URL::asset('css/custom_op.css') }}" rel="stylesheet">
	<?php } ?>
	
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
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<!-- Large modal -->
				<div id="myModal" style="z-index: 1000;" class="modal fade bs-example-modal-lg" tabindex="1000" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
								<h4 class="modal-title" id="myModalLabel">Errores</h4>
							</div>
							<div class="modal-body" id="modal_text"></div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
					</div>
				</div>								
			</div>
		</div>
	</div>