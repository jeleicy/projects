<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use Session;
use DB;
use View;
use Illuminate\Support\Facades\URL;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <title>Red de Observacion</title>

    <!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">

    <!-- MetisMenu CSS -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/metisMenu.min.css') }}">

    <!-- Timeline CSS -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/timeline.css') }}">

    <!-- Custom CSS -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/sb-admin-2.css') }}">

    <!-- Morris Charts CSS -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/morris.css') }}">

    <!-- Custom Fonts -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/css/estilos.css') }}">

	<script type="text/javascript" src="{{ URL::asset('assets/js/funciones.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/ajax.js') }}"></script>

	<!--link href="css/scwdemo.css" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="css/lightbox.css">
	<link type="text/css" rel="stylesheet" href="css/estilos.css"-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!--FUNCIONES MORRIS-->
	
		<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/raphael-min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/morris.js') }}"></script>
		<script src="{{ URL::asset('assets/js/prettify.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js//example.js') }}"></script>
		<link rel="stylesheet" href="{{ URL::asset('assets/css/example.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('assets/css/prettify.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('assets/css/morris.css') }}">	

    <!--FUNCIONES DATATABLE-->
    <link rel="stylesheet" href="{{ URL::asset('assets/datatables/DataTables-1.10.9/css/jquery.dataTables.min.css') }}" />
    <style type="text/css" class="init">

    </style>
    <script type="text/javascript" src="{{ URL::asset('assets/datatables/jQuery-2.1.4/jquery-2.1.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/datatables/DataTables-1.10.9/js/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript" class="init">
        $(document).ready(function() {
            $('#example').DataTable( {
                columnDefs: [ {
                    targets: [ 0 ],
                    orderData: [ 0, 1 ]
                }, {
                    targets: [ 1 ],
                    orderData: [ 1, 0 ]
                }, {
                    targets: [ 4 ],
                    orderData: [ 4, 0 ]
                } ]
            } );
        } );

    </script>
	
	<!-- FUNCIONES DATEPICKER-->
  <!--script type="text/javascript" src="assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/moment.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" /-->	

</head>

<body>

<div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div cla
                 ss="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--a class="navbar-brand" href="{{URL::asset('dashboardindex') }}">
                    <img src="images/logo_peq.jpg" border="0" width="20" height="30">
                </a-->
                <a class="navbar-brand" href="{{URL::asset('dashboardindex') }}">
                    Observadores de Venezuela - {{ SessionusuarioControllers::show("nombres") }} {{  SessionusuarioControllers::show("apellidos") }} ({{ FuncionesControllers::buscar_privilegio(SessionusuarioControllers::show("privilegio")) }})
                </a>
            </div>
            <!-- /.navbar-header -->

		@include('dashboard.menusuperior')
			
		@include('dashboard.menuizquierdo')
        </nav>

    <div id="page-wrapper">
