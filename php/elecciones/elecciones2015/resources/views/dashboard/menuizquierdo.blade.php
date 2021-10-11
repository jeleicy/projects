<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use Session;
use DB;

?>

<!-----------------------MENU IZQUIERDO---------------------------------->			
            <!-- /.navbar-top-links -->
			
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">			
			
						{{ FuncionesControllers::crear_menu(SessionusuarioControllers::show("privilegio")) }}
                  
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
<!-----------------------MENU IZQUIERDO---------------------------------->