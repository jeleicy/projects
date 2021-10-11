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

$ruta="";

//echo "ruta=".$_SERVER["REQUEST_URI"];

if (strpos($_SERVER["REQUEST_URI"],"consultarprueba") !== false || 
		strpos($_SERVER["REQUEST_URI"],"consultarempresa") !== false || 
		strpos($_SERVER["REQUEST_URI"],"consultarbateria") !== false || 
		strpos($_SERVER["REQUEST_URI"],"consultarinstrucciones") !== false || 
		strpos($_SERVER["REQUEST_URI"],"consultarcorreos") !== false || 
		strpos($_SERVER["REQUEST_URI"],"consultarusuario") !== false || 
		strpos($_SERVER["REQUEST_URI"],"eliminar_evaluacion") !== false || 
		strpos($_SERVER["REQUEST_URI"],"encuesta_reporte") !== false || 
		strpos($_SERVER["REQUEST_URI"],"aplicar_encuesta") !== false || 
		strpos($_SERVER["REQUEST_URI"],"setearpass") !== false || 
		strpos($_SERVER["REQUEST_URI"],"consultarpreguntaopcion") !== false ||
		strpos($_SERVER["REQUEST_URI"],"editarpregunta") !== false  ||
		strpos($_SERVER["REQUEST_URI"],"consultartexto_aceptacion") !== false ||
		strpos($_SERVER["REQUEST_URI"],"datos_participante") !== false ||
		strpos($_SERVER["REQUEST_URI"],"consultar_candidatos") !== false ||
		strpos($_SERVER["REQUEST_URI"],"buscar_candidato") !== false
		)
	$ruta="../";

$rol=array("A"=>"Administrador", "EA"=>"RRHH", "ERRHH"=>"Analista de RRHH");
//echo "ruta=".strpos($_SERVER["REQUEST_URI"],"consultarprueba")."...$ruta";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Encuestas</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/estilos.css') }}" rel="stylesheet">

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
    <div id="wrapper">
	
        <!-- Navigation -->
		<?php
			if ((substr($_SERVER["REQUEST_URI"],strlen($_SERVER["REQUEST_URI"])-7)!="public/") && (strpos($_SERVER["REQUEST_URI"],"salida") === false) && (strpos($_SERVER["REQUEST_URI"],"prueba_potencial") === false) && (strpos($_SERVER["REQUEST_URI"],"guardar_potencial") === false) && (strpos($_SERVER["REQUEST_URI"],"aplicar_encuesta") === false)) {
		?>
        <nav class="navbar navbar-default navbar-static-top" style="background-color: #fff;" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header" style="background-color: #fff;">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>				
				<?php $logo="empresas/logos/".Session::get("logo"); ?>
				<a href="dashboard"><img src="{{ URL::asset($logo) }}" /></a>
				<?php if (Session::get("rol")) { ?>
				Bienvenido (a):<?php echo Session::get("nombre")." ( ".FuncionesControllers::buscar_empresa(Session::get("id_empresa"))." ) ( ".$rol[Session::get("rol")]." )"; ?>
				<?php } else { ?>
				Bienvenido (a):<?php echo Session::get("nombre")." ( ".FuncionesControllers::buscar_empresa(Session::get("id_empresa"))." )"; ?>
				<?php } ?>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right" style="background-color: #fff;">
                <!--li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="salida"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                </li-->
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation" style="background-color: #fff;">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
						<?php if ((strpos(Session::get("rol"),"E") !== false) || (strpos(Session::get("rol"),"A") !== false)) { ?>
						<?php if ((Session::get("rol")=="A") || (Session::get("rol")=="EA")) { ?>
						
                        <li>
                            <a href="#"><i class="fa fa-child fa-fw"></i> Usuarios<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>crear_usuario">Crear</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_usuario">Consultar</a>
                                </li>
                            </ul>
                        </li>						
						<?php if (Session::get("rol")!="EA") { ?>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Empresas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>crear_empresa">Crear</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_empresa">Consultar</a>
                                </li>
                            </ul>
                        </li>						
                        <li>
                            <a href="#"><i class="fa fa-child fa-fw"></i> Tipos de Pruebas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>crear_pruebas">Crear</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_pruebas">Consultar</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-cogs"></i> Baterias<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>crear_bateria">Crear</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_bateria">Consultar</a>
                                </li>
                            </ul>
                        </li>							
						
						<?php } ?>
						
						<?php if (Session::get("rol")!="ERRHH") { ?>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Asignaciones<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>crear_asignacion">Crear</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_asignacion">Consultar</a>
                                </li>
                            </ul>
                        </li>
						<?php } ?>						
						<?php if (Session::get("rol")=="A") { ?>
                        <li>
                            <a href="#"><i class="fa fa-envelope-o fa-fw"></i> Correo<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>crear_correo">Crear</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_correo">Consultar</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-check-square"></i> Instrucciones<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>crear_instrucciones">Crear</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_instrucciones">Consultar</a>
                                </li>
                            </ul>
                        </li>	

                        <li>
                            <a href="#"><i class="fa fa-check-square"></i> Campos Adicionales<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>crear_campos">Crear</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_campos">Consultar</a>
                                </li>
                            </ul>
                        </li>	

                        <li>
                            <a href="#"><i class="fa fa-check-square"></i> Grupo de Candidatos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>crear_grupo_candidatos">Crear</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_grupo_candidatos">Consultar</a>
                                </li>
                            </ul>
                        </li>		

                        <li>
                            <a href="#"><i class="fa fa-check-square"></i> Texto de Aceptacion<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>crear_texto_aceptacion">Crear</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_texto_aceptacion">Consultar</a>
                                </li>
                            </ul>
                        </li>							
						<?php } ?>						
						<?php } ?>
						<?php if ((strpos(Session::get("rol"),"E") !== false) || (strpos(Session::get("rol"),"A") !== false)) { ?>
                        <!--li>
                            <a href="#"><i class="fa fa-male fa-fw"></i> Candidatos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_candidato">Consultar</a>
                                </li>
                            </ul>
                        </li-->
						<?php if (strpos(Session::get("rol"),"E") !== false) { ?>
						<li>
                            <a href="#"><i class="fa fa-file-image-o fa-fw"></i> Pruebas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>invitar">Invitar</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>invitar_consultar">Consultar Pruebas</a>
                                </li>
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_evaluadores">Consultar Evaluadores</a>
                                </li>								
                            </ul>
                        </li>
						<?php } ?>	

                        <li>
                            <a href="#"><i class="fa fa-cogs"></i> Candidatos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $ruta; ?>consultar_candidatos/0">Consultar</a>
                                </li>
                            </ul>
                        </li>	
						
						<li>
                            <a href="#"><i class="fa fa-bars"></i>Reportes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<?php 
									$sql = "select * from bateria order by 2";
									$data=DB::select($sql);
									$texto = '<ul class="nav nav-third-level">';
									foreach ($data as $data) {										
										$texto .='
										<li>
											<a href="'.$ruta.'encuesta_reporte/'.$data->id.'">
												<i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;
													'.$data->nombre.'
											</a>
										</li>';
									}
									$texto.="</ul>";
									echo $texto;									
									//FuncionesControllers::crear_menu_pruebas($data->id, $data->nombre, $ruta);
								?>
								<li>
									<a href="{{ $ruta }}encuesta_reporte/general">
										<i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;
											General
									</a>								
								</li>
								<li>
									<a href="{{ $ruta }}encuesta_reporte/estadistica">
										<i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;
											Estadisticas
									</a>								
								</li>								
                            </ul>
                        </li>
						<?php } ?>
						<li>
                            <a href="<?php echo $ruta; ?>cambiar_contrasena"><i class="fa fa-lock"></i> Cambiar Contraseña<span class="fa arrow"></span></a>
                        </li>						
						<li>
                            <a href="<?php echo $ruta; ?>salida"><i class="fa fa-sign-out fa-fw"></i> Salir del sistema<span class="fa arrow"></span></a>
                        </li>	
						<?php } ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
		<?php } ?>

        <!-- Page Content -->
        <div id="page-wrapper">