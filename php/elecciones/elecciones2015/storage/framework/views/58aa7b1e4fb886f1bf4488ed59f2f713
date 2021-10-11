<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use Session;
use DB;
use View;
use Illuminate\Support\Facades\URL;

?>

<!-----------------------MENU SUPERIOR---------------------------------->
            <ul class="nav navbar-top-links navbar-right">
			<!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Reporte 1</strong>
                                        <span class="pull-right text-muted"><?php echo FuncionesControllers::porcentaje_reporte(1); ?>% Completado</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo FuncionesControllers::porcentaje_reporte(1); ?>%">
                                            <span class="sr-only"><?php echo FuncionesControllers::porcentaje_reporte(1); ?>% Completado (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Reporte 2</strong>
                                        <span class="pull-right text-muted"><?php echo FuncionesControllers::porcentaje_reporte(2); ?>% Completado</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo FuncionesControllers::porcentaje_reporte(2); ?>%">
                                            <span class="sr-only"><?php echo FuncionesControllers::porcentaje_reporte(2); ?>% Completado</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Reporte 3</strong>
                                        <span class="pull-right text-muted"><?php echo FuncionesControllers::porcentaje_reporte(3); ?>% Completado</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo FuncionesControllers::porcentaje_reporte(3); ?>%">
                                            <span class="sr-only"><?php echo FuncionesControllers::porcentaje_reporte(3); ?>% Completado (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Reporte 4</strong>
                                        <span class="pull-right text-muted"><?php echo FuncionesControllers::porcentaje_reporte(4); ?>% Completado</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo FuncionesControllers::porcentaje_reporte(4); ?>%">
                                            <span class="sr-only"><?php echo FuncionesControllers::porcentaje_reporte(4); ?>% Completado (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Reporte 5</strong>
                                        <span class="pull-right text-muted"><?php echo FuncionesControllers::porcentaje_reporte(5); ?>% Completado</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo FuncionesControllers::porcentaje_reporte(5); ?>%">
                                            <span class="sr-only"><?php echo FuncionesControllers::porcentaje_reporte(5); ?>% Completado (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>						
                        <li class="divider"></li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="cambiar_contrasena"><i class="fa fa-user fa-fw"></i>Cambiar Contrase&ntilde;a</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="cerrar_session"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesion</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
<!-----------------------MENU SUPERIOR---------------------------------->