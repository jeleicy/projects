<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\SessionusuarioControllers;
use App\usuarios;
use App\Http\Controllers\FuncionesControllers;
use Mail;

class UsuariosControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('usuarios.consulta', ["mensaje" => "", "tipo"=>"info"]);
    }

    public function nuevo_usuario() {
        Session::put("mensaje","");
        return view('usuario.nuevo',["mensaje"=>"", "id"=>0, "tipo"=>""]);
    }
	
    public function cambiar_contrasena() {
        return view('usuarios.cambiar_contrasena',["mensaje"=>"", "tipo"=>""]);
    }
	
    public function setearpass($id) {
		$sql="select * from  usuarios where id=".$id;
		$data=DB::select($sql);
		foreach ($data as $data) {
			$nombre=$data->nombres;
			$email=$data->email;
		}
		
		$clave=FuncionesControllers::generarClave();
		$sql = "update usuarios set password='".hash('ripemd160', $clave)."' 
				where id=".$id;
		DB::update($sql);
		$mensaje="Contraseña actualizada satisfactoriamente";
		$tipo="info";
		
		/************************* EMAIL A ENVIAR ***************************/
		  Mail::send('correo.setearpass', ["clave"=>$clave,"nombre"=>$nombre, "email"=>$email], function($message) use($email, $nombre)
			{
				$message->to($email, $nombre)->subject('Seteo de Contraseña');
				$message->to("jeleicy@gmail.com", $nombre)->subject('Seteo de Contraseña');
		  });
		/************************* EMAIL A ENVIAR ***************************/			
		
		return view('usuarios.consulta',["mensaje"=>$mensaje, "tipo"=>$tipo]);
    }
	
    public function guardar_cambiar_contrasena(Request $request) {
        $datos=$request->all();
		$pass1=$request->password;
		$pass2=$request->password2;
		if ($pass1==$pass2) {
			$sql = "update usuarios set password='".hash('ripemd160', $request->password)."' 
					where id=".Session::get("id_usuario");
			DB::update($sql);
			$mensaje="Contraseña actualizada satisfactoriamente";
			$tipo="info";
		} else {
			$mensaje="Las contraseñas deben ser iguales";
			$tipo="danger";
		}
		return view('usuarios.cambiar_contrasena',["mensaje"=>$mensaje, "tipo"=>$tipo]);
    }
	
	

    public function consultarusuarios($id)
    {
        $usuario=usuarios::findOrFail($id);
        return view::make('usuarios.edit', compact('usuario'));
    }        

    public function guardar_usuario_edicion(Request $request) {
        $id=$request->id;
        $usuario=usuarios::findOrFail($id);
        $usuario->fill($request->all());
        $usuario->save();
        return view('usuarios.consulta', ["mensaje" => "Usuario actualizado satisfactoriamente", "tipo"=>"info"]);
    }

    public function guardar_usuario_nuevo (Request $request) {
        $usuario = new usuarios($request->all());

        Session::put("mensaje","");

        $fileName = "";
        $sql = "select * from usuarios where email='".$request->email."'";
        $data=DB::select($sql);
        if (empty($data)) {
			$usuario->password=hash('ripemd160', $request->password);
			$usuario->id_empresas=Session::get("id_empresa");
            $usuario->save();
            return view('usuarios.consulta', ["mensaje" => "Usuario insertado satisfactoriamente", "tipo"=>"info"]);
        } else {
            return view('usuarios.nuevo', ["mensaje" => "Ya existe otro usuario con este email", "id" => 0, "tipo"=>$request->tipo]);
        }
    }

    public static function consulta()
    {
        //
        $usuario = usuarios::all();
        
        $strDatos="[";
        $end_data = usuarios::count();

        foreach ($usuario as $key=>$usuario) {
            $strDatos.="['".$usuario->nombres."',";
			$strDatos.="'".$usuario->id_empresa."',";
            $strDatos.="'<a href=consultarusuario/".$usuario->id.">Consultar</a> | <a href=eliminarusuario/".$usuario->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="usuario";
        $strColumnas="{ title: \"Tipo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>Empresa</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de usuarios";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
	
    public function verificar_usuario(Request $request) {
        $username=$request->username;
        $contrasena=$request->password;

        $validador = Validator::make(
            array('username' => $username, 'pass' => $contrasena),
            array('username' => 'required', 'pass' => 'required')
        );

        if ($validador->passes()) {
            $sql = "select e.logo, u.* from usuarios u, empresas e where u.email='".$username."'";
            $sql .= " and u.password='".hash('ripemd160', $contrasena)."' and e.id=u.id_empresas";
            $data = DB::select($sql);

            if (empty($data)) {
                return View::make('encuesta.login')->with('mensaje','error_autenticacion');
            } else {
                foreach ($data as $data) {					
					Session::put("rol",$data->rol);
					Session::put("nombre",$data->nombres);
					Session::put("id_empresa",$data->id_empresas);
					Session::put("id_usuario",$data->id);
					Session::put("id_autorizacion",0);
					if (is_file("empresas/logos/".$data->logo))
						Session::put("logo",$data->logo);
					else
						Session::put("logo","no_camera.png");
					
					if ($data->rol=="A") {
						return view('encuesta.dashboard',["cedula"=>0]);
					} elseif (strpos($data->rol,"E") !== false) {
						return view('encuesta.dashboard',["cedula"=>0]);
					} if ($data->rol=="C") {
						$sql = "select id, presento from autorizaciones where id_usuario=".$data->id;
						$data2=DB::select($sql);
						if (!empty ($data2)) {
							foreach ($data2 as $data2) {
								Session::put("id_autorizacion",$data2->id);
								if ($data2->presento==0)
									return View::make('encuesta.index',["email"=>$data->email,"entra"=>1]);
								else
									return View::make('encuesta.index_no',["email"=>$data->email,"entra"=>0]);
							}
						} else {
							return View::make('encuesta.index_no',["email"=>$data->email,"entra"=>0]);
						}
					}
                }
            }
        } else {
            return view('encuesta.login')->with('mensaje','error_autenticacion');
        }
    }
	
	public function salida() {
		Session::put("rol",0);
		Session::put("nombre",0);
		Session::put("id_empresa",0);
		Session::put("id_usuario",0);
		Session::put("id_autorizacion",0);
		return view('encuesta.login',["mensaje"=>""]);
	}
}