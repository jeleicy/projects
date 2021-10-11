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
use App\Http\Controllers\SessionusuarioControllers;

use App\alta;
use App\cirugias;
use App\paciente;
use App\nro_historia;
use App\clinica_medico;
use App\cirugia_seguro;
use App\seguros_medicos;
use App\medico_cirugia;
use App\datos_cirugia;

use App\Http\Controllers\FuncionesControllers;

class CirugiasControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /periodicos
     *
     * @return Response
     */
    public function index()
    {       
        $today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];
        $fecha_act = $ano."-".$mes."-".$dia;

        $fecha = $fecha_act;
        $nuevafecha = strtotime ( '-365 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );

        $fecha_act = $fecha;
        $fecha2=FuncionesControllers::fecha_normal($fecha_act);
        $fecha1=FuncionesControllers::fecha_normal($nuevafecha);

        Session::put("fecha",$fecha_act);

        $consulta=0;

        $id_medico=Session::get("id_medico");

        $consulta=1;
        return view::make('cirugias.pacientes',["fecha1"=>$fecha1, "fecha2"=>$fecha2, "consulta"=>$consulta,"id_medico"=>$id_medico,"id_clinica"=>0,"id_seguro"=>0]);
    }

    public function consulta_cirugia_2(Request $request)
    {
        $fecha=$request->fecha;
        $fecha1=FuncionesControllers::fecha_mysql(substr($fecha,0,strpos($fecha,"-")-1));
        $fecha2=FuncionesControllers::fecha_mysql(substr($fecha,strpos($fecha,"-")+2));
        $consulta=0;

        $datos = Input::all();
        $id_medico="";
        if (Session::get("id_medico")==0) {
            foreach ($datos as $key=>$value) {
                if (strpos($key,"chk_") !== false)
                    $id_medico.=$value.",";
            }
            $id_medico=substr($id_medico,0,strlen($id_medico)-1);
        } else
            $id_medico=Session::get("id_medico");

        if ($request->consulta)
            $consulta=$request->consulta;
        $id_clinica=$request->id_clinica;
        $id_seguro=$request->id_seguro;
        return view::make('cirugias.pacientes',["fecha1"=>$fecha1, "fecha2"=>$fecha2, "consulta"=>$consulta,"id_medico"=>$id_medico,"id_clinica"=>$id_clinica,"id_seguro"=>$id_seguro]);
    }    

    public function consulta_cirugia_3(Request $request)
    {
        //dd($request->all());
        $consulta=0;
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;       

        $datos = Input::all();
        $id_medico="";
        if (Session::get("id_medico")==0) {
            foreach ($datos as $key=>$value) {
                if (strpos($key,"chk_") !== false)
                    $id_medico.=$value.",";
            }
            $id_medico=substr($id_medico,0,strlen($id_medico)-1);
        } else
            $id_medico=Session::get("id_medico");

        $cedula=0;
        if ($request->cedula)
            $cedula=$request->cedula;

        if ($request->consulta)
            $consulta=$request->consulta;
        return view::make('cirugias.consulta_2',["fecha1"=>$fecha1, "fecha2"=>$fecha2, "consulta"=>$consulta,"id_medico"=>$id_medico,"indice"=>$request->indice, "cedula"=>$cedula, "id_seguro"=>$request->id_seguro, "id_clinica"=>$request->id_clinica]);
    }       

    public function nuevo_cirugia() {
        Session::put("mensaje","");
        Session::put('id',0);

        $today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];

        if ($dia<10) $dia="0".$dia;
        if ($mes<10) $mes="0".$mes;

        $fecha_act = $dia."/".$mes."/".$ano;

        Session::put("fecha",$fecha_act);

        return view('cirugias.nuevo',["mensaje"=>"", "id"=>0, "id_clinica"=>0, "cedula_medico"=>"", "direccion"=>"", "color"=>"", "pais"=>"", "ciudad"=>"", "id_cirugia"=>0,"cedula"=>"", "nro_historia"=>"","cedula_paciente"=>"","monto"=>0, "id_moneda"=>0,"nro_historia"=>"","observaciones"=>"","referencias"=>"","seguro"=>0]);
    }

    public function solo_cirugia(Request $request) {
        $id_cirugia=$request->id_cirugia;
        return view('cirugias.solo_cirugia',["id_cirugia"=>$id_cirugia]);
    }

    public function consultarcirugia($id)
    {
        return view('cirugias.solo_cirugia_consulta',["id_datos_cirugia"=>$id]);
    }

    public function eliminarcirugia($id)
    {
        $sql = "delete from datos_cirugia where id=".$id;
        DB::delete($sql);
        return redirect()->route('consulta_cirugia');
    }

    public function alta_cirugia(Request $request)
    {
        //dd($request->all());
        /*GUARDANDO ALTA*/
        $alta = new alta($request->all());
        $alta->id_cirugia=$request->id_cirugia;
        $fecha=$request->fecha;
        $fecha=str_replace("-", "/", $fecha);
        $fecha=FuncionesControllers::fecha_mysql($fecha);
        $alta->fecha=$fecha;
        /*if (strpos(Session::get('fecha'),"/") !== false)
            $alta->fecha=FuncionesControllers::fecha_mysql(Session::get('fecha'));
        else
            $alta->fecha=Session::get('fecha');*/
        $alta->save();

        /*GUARDANDO DATOS_CIRUGIA - ALTA*/
        $datos_cirugia = new datos_cirugia($request->all());
        $datos_cirugia->id_cirugia=$request->id_cirugia;
        /*$fecha=Session::get('fecha');
        if (strpos($fecha,"/") !== false)
            $fecha=FuncionesControllers::fecha_mysql($fecha);*/

        $datos_cirugia->fecha_carga=$fecha;
        $datos_cirugia->fecha_alta=$fecha;
        $datos_cirugia->id_tipo_atencion=7;
        $datos_cirugia->tipo_atencion='ALTA';
        $datos_cirugia->monto=0;
        $datos_cirugia->save();

        $sql = "select p.cedula from cirugias c, paciente p where c.id_paciente=p.id and c.id=".$request->id_cirugia;
        $data=DB::select($sql);
        foreach ($data as $data) $cedula=$data->cedula;

        return Redirect::route('consulta_cirugia_3', array('id_medico' => Session::get("id_medico"), 'fecha1'=>0, 'fecha2'=>0, 'consulta'=>2, 'indice'=>-1, 'cedula'=>$cedula));
        //return view('generica.formainsertada', ["tipo"=>"alta_cirugia"]);
    }

    public function guardar_edicion_solo_cirugia(Request $request) {
        //dd($request->all());      

        $id_datos_cirugia=$request->id_datos_cirugia;
        $sql = "select * from datos_cirugia where id=".$id_datos_cirugia;
        $data=DB::select($sql);
        foreach ($data as $data) $id_cirugia=$data->id_cirugia;

        $sql = "update cirugias set nro_historia='".$request->nro_historia."' where id=".$id_cirugia;
        DB::update($sql);          

        /*GUARDANDO DATOS_CIRUGIA*/
        $datos_cirugia=datos_cirugia::findOrFail($id_datos_cirugia);
        $datos_cirugia->fill($request->all());
        $datos_cirugia->habitacion=0;
        $datos_cirugia->id_cirugia=$id_cirugia;
        $datos_cirugia->fecha_carga=FuncionesControllers::fecha_mysql($request->fecha_cirugia);
        $monto_total=$request->monto;
        //$monto_total=substr($monto_total,3);
        $monto_total=str_replace(".", "", $monto_total);
        $monto_total=str_replace(",", ".", $monto_total);
        $datos_cirugia->monto=$monto_total/100;
        if (isset($request->cirujano))
            $datos_cirugia->cirujano=$request->cirujano;
        else
            $datos_cirugia->cirujano=Session::get("nombre");

        $datos_cirugia->save();

        $sql = "select p.cedula from datos_cirugia dc, cirugias c, paciente p where dc.id_cirugia=c.id and c.id_paciente=p.id and dc.id=".$request->id_datos_cirugia;
        $data=DB::select($sql);
        foreach ($data as $data) $cedula=$data->cedula;        

        /*GUARDANDO MEDICO_CIRUGIA*/
        $sql = "delete from medico_cirugia where id_datos_cirugia=".$id_datos_cirugia;
        DB::delete($sql);

        $medico_cirugia = new medico_cirugia($request->all());
        $medico_cirugia->id_cirugia=$id_cirugia;
        $datos = Input::all();
        $res="";
        $monto="";
        $id_rol="";
        foreach ($datos as $key=>$value) {
            if (strpos($key,"rol_") !== false) {
                $res.=$value.",";
                $id=substr($key,4);
                $id_rol.=$id.",";
                $nombre="monto_".$id;
                $cantidad=$datos[$nombre];
                //$cantidad=substr($cantidad,3);
                $cantidad=str_replace(".", "", $cantidad);
                $cantidad=str_replace(",", ".", $cantidad);
                $monto.=$cantidad.",";
            }
        }
        $res=substr($res,0,strlen($res)-1);
        $id_rol=substr($id_rol,0,strlen($id_rol)-1);
        $monto=substr($monto,0,strlen($monto)-1);

        $medico_cirugia->id_rol=$id_rol;

        $rol=$res;
        if ($rol=="0") $rol='';
        if (strpos($rol,"OTRO") !== false)
            $rol.=" (".$request->otro_rol.")";
        $medico_cirugia->rol=$rol;
        $medico_cirugia->monto=$monto;
        $medico_cirugia->id_datos_cirugia=$id_datos_cirugia;
        $medico_cirugia->save();        

        return Redirect::route('consulta_cirugia_3', array('id_medico' => Session::get("id_medico"), 'fecha1'=>0, 'fecha2'=>0, 'consulta'=>1, 'indice'=>-1, 'cedula'=>$cedula));        
        //return view('generica.formainsertada', ["tipo"=>"cirugia_medico"]);
    }

    public function guardar_solo_cirugia(Request $request) {
        //dd($request->all());

        $sql = "update cirugias set nro_historia='".$request->nro_historia."' where id=".$request->id_cirugia;
        DB::update($sql);

        /*GUARDANDO DATOS_CIRUGIA*/
        $datos_cirugia = new datos_cirugia($request->all());
        $datos_cirugia->id_cirugia=$request->id_cirugia;
        $datos_cirugia->habitacion=0;
        if (strpos($request->fecha_cirugia,"-") !== false)
            $request->fecha_cirugia=str_replace("-", "/", $request->fecha_cirugia);
        $datos_cirugia->fecha_carga=FuncionesControllers::fecha_mysql($request->fecha_cirugia);
        $datos_cirugia->id_tipo_atencion=3;
        $datos_cirugia->tipo_atencion='CIRUGIA';
        if ($request->monto_total==0) {
            $monto=$request->monto;
            //$monto=substr($monto,3);
            $monto=str_replace(".", "", $monto);
            $monto=str_replace(",", ".", $monto);
            $datos_cirugia->monto=$monto;
        } else
            $datos_cirugia->monto=$request->monto_total;
        if ($request->observaciones=="")
            $datos_cirugia->observaciones="-";
        /*if ($request->fecha_alta!="")
            $datos_cirugia->fecha_alta=FuncionesControllers::fecha_mysql($request->fecha_alta);*/

        if (isset($request->cirujano))
            $datos_cirugia->cirujano=$request->cirujano;
        else
            $datos_cirugia->cirujano=Session::get("nombre");            

        $datos_cirugia->save();

        $sql = "select max(id) as id_datos_cirugia from datos_cirugia";
        $data=DB::select($sql);
        foreach ($data as $data)
            $id_datos_cirugia=$data->id_datos_cirugia;        

        $sql = "select p.cedula from cirugias c, paciente p where c.id_paciente=p.id and c.id=".$request->id_cirugia;
        $data=DB::select($sql);
        foreach ($data as $data) $cedula=$data->cedula;

        /*GUARDANDO MEDICO_CIRUGIA*/
        $medico_cirugia = new medico_cirugia($request->all());
        $medico_cirugia->id_cirugia=$request->id_cirugia;
        $datos = Input::all();
        $res="";
        $monto="";
        $id_rol="";
        foreach ($datos as $key=>$value) {
            if (strpos($key,"rol_") !== false) {
                $res.=$value.",";
                $id=substr($key,4);
                $id_rol.=$id.",";
                $nombre="monto_".$id;
                $cantidad=$datos[$nombre];
                //$cantidad=substr($cantidad,3);
                $cantidad=str_replace(".", "", $cantidad);
                $cantidad=str_replace(",", ".", $cantidad);
                $monto.=$cantidad.",";
            }
        }
        $res=substr($res,0,strlen($res)-1);
        $id_rol=substr($id_rol,0,strlen($id_rol)-1);
        $monto=substr($monto,0,strlen($monto)-1);

        $medico_cirugia->id_rol=$id_rol;

        $rol=$res;
        if ($rol=="0") $rol='';
        if (strpos($rol,"OTRO") !== false)
            $rol.=" (".$request->otro_rol.")";
        $medico_cirugia->rol=$rol;

        $medico_cirugia->monto=$monto;

        $medico_cirugia->id_datos_cirugia=$id_datos_cirugia;

        $medico_cirugia->save();        

        return Redirect::route('consulta_cirugia_3', array('id_medico' => Session::get("id_medico"), 'fecha1'=>0, 'fecha2'=>0, 'consulta'=>1, 'indice'=>-1, 'cedula'=>$cedula));        
        //return view('generica.formainsertada', ["tipo"=>"cirugia_medico"]);
    }

    public function guardar_cirugia_nuevo (Request $request) {
        $id_paciente=0;
        $id_medico=0;
        $id_nro_historia=0;
        $id_cirugia=0;

        //dd($request->all());
        
        $img_sticker=Input::file('img_sticker');
        $sql = "select id from paciente where cedula='".$request->cedula_paciente."'";
        $data = DB::select($sql);
        foreach ($data as $data) $id_paciente=$data->id;

        $sql = "select id from medico where cedula='".$request->cedula_medico."'";
        $data = DB::select($sql);
        foreach ($data as $data) $id_medico=$data->id;

        /*GUARDANDO NRO DE HISTORIA*/
        /*if ($request->nro_historia!="") {
            $sql = "select nh.* from nro_historia nh, paciente p ";
            $sql .= "where nh.id_clinica=".$request->id_clinica." and nh.id_paciente=p.id and ";
            $sql .= "p.cedula='".$request->cedula_paciente."'";

            $data = DB::select($sql);
            if (empty($data)) {
                $nro_historia = new nro_historia($request->all());
                $nro_historia->id_paciente=$id_paciente;            
                $nro_historia->save();

                $sql = "select max(id) as id from nro_historia";
                $data = DB::select($sql);
                foreach ($data as $data) $id_nro_historia=$data->id;              
            } else {
                foreach ($data as $data)
                    $id_nro_historia=$data->id;

                $nro_historia=nro_historia::findOrFail($id_nro_historia);
                $nro_historia->fill($request->all());
                $nro_historia->save();
            }
        }*/

        /*
        --paciente
        --clinica_medico
        --seguros_medicos
        --cirugias
        --cirugia_seguro
        --datos_cirugia
        --medico_cirugia
        */

        /*GUARDANDO PACIENTE*/
        $sql = "select id from paciente where cedula='".$request->cedula."' and id_medico=".Session::get("id_medico");
        $data=DB::select($sql);
        if (empty($data)) {
            $paciente = new paciente($request->all());
            $paciente->nombres=strtoupper($request->nombres);
            $paciente->apellidos=strtoupper($request->apellidos);            
            $paciente->id_medico=Session::get("id_medico");
            $paciente->save();

            $sql = "select max(id) as id from paciente where cedula='".$request->cedula."' and id_medico=".Session::get("id_medico");
            $data=DB::select($sql);
        }
        foreach ($data as $data)
            $id_paciente=$data->id;

        /*GUARDANDO CLINICA_MEDICO*/

        $sql = "select id_clinica from clinica_medico where nombre='".strtoupper($request->clinica)."' and id_medico=".Session::get("id_medico");
        $data=DB::select($sql);
        if (empty($data)) {
            $clinica_medico = new clinica_medico($request->all());
            $clinica_medico->id_medico=Session::get("id_medico");
            $clinica_medico->nombre=strtoupper($request->clinica);
            $clinica_medico->pais=248;
            $clinica_medico->ciudad='CARACAS';
            $clinica_medico->save();

            $sql = "select max(id_clinica) as id_clinica from clinica_medico where nombre='".strtoupper($request->clinica)."' and id_medico=".Session::get("id_medico");
            $data=DB::select($sql);
        }
        foreach ($data as $data)
                $id_clinica=$data->id_clinica;

        /*GUARDANDO SEGUROS_MEDICO*/

        $seguros=explode(",", $request->seguros);

        for ($i=0; $i<count($seguros); $i++) {
            $sql = "select id from seguros_medicos where nombre='".strtoupper($seguros[$i])."' and id_medico=".Session::get("id_medico");
            $data=DB::select($sql);
            if (empty($data)) {
                $seguros_medicos = new seguros_medicos($request->all());
                $seguros_medicos->id_medico=Session::get("id_medico");
                $seguros_medicos->nombre=strtoupper($seguros[$i]);
                $seguros_medicos->direccion="";
                $seguros_medicos->save();

                $sql = "select max(id) as id from seguros_medicos where nombre='".strtoupper($seguros[$i])."' and id_medico=".Session::get("id_medico");
                $data=DB::select($sql);
            }
            foreach ($data as $data)
                $id_seguro[]=$data->id;
        }       
            
        /*GUARDANDO CIRUGIA*/
        $fileName="";
        if ($img_sticker) {
             $carpeta=$id_paciente;
            if (Input::file('img_sticker')->isValid()) {
                $destinationPath = 'paciente/' . $carpeta; // upload path
                $extension = Input::file('img_sticker')->getClientOriginalExtension(); // getting image extension
                if (!is_dir($destinationPath))
                    mkdir($destinationPath);

                $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                Input::file('img_sticker')->move($destinationPath, $fileName); // uploading file to given path
            }
        }

        $cirugia = new cirugias($request->all());
        $cirugia->id_paciente=$id_paciente;
        $cirugia->id_medico=Session::get("id_medico");
        if (isset($request->nro_historia))
            $cirugia->id_nro_historia=$request->nro_historia;
        else
            $cirugia->id_nro_historia=0;
        $cirugia->id_moneda=127;
        if ($fileName!="")
            $cirugia->img_sticker=$fileName;
        //$cirugia->fecha_cirugia=FuncionesControllers::fecha_mysql($request->fecha_cirugia);
        if (strpos($request->fecha_cirugia,"-") !== false)
            $cirugia->fecha_cirugia=str_replace("-", "/", $request->fecha_cirugia);
        $cirugia->fecha_cirugia=FuncionesControllers::fecha_mysql($cirugia->fecha_cirugia);
        if ($request->tipo_atencion==3) {
            $cirugia->nro_historia=$request->nro_historia;
            $cirugia->cirujano=$request->cirujano;
        } else {
            $cirugia->nro_historia=0;
            $cirugia->cirujano="";
        }
        $cirugia->id_clinica=$id_clinica;
        $cirugia->nombre=strtoupper($request->diagnostico);

        $cirugia->seguros=strtoupper($request->seguros);
        $cirugia->save();

        $sql = "select max(id) as id from cirugias";
        $data = DB::select($sql);
        foreach ($data as $data) 
            $id_cirugia=$data->id;

        /*GUARDANDO CIRUGIA_SEGURO*/
        if (count($id_seguro)>0) {
            for ($i=0; $i<count($id_seguro); $i++)  {
                $cirugia_seguro = new cirugia_seguro($request->all());

                $cirugia_seguro->id_cirugia=$id_cirugia;
                $cirugia_seguro->id_seguro=$id_seguro[$i];
                $cirugia_seguro->save();
            }
        }

        /*GUARDANDO DATOS_CIRUGIA*/
        //id_cirugia,observaciones,referencias,habitacion,fecha_carga,fecha_alta,id_tipo_atencion,tipo_atencion,monto,cirujano
        $datos_cirugia = new datos_cirugia($request->all());
        $datos_cirugia->id_cirugia=$id_cirugia;
        $datos_cirugia->habitacion=0;
        //$datos_cirugia->fecha_carga=FuncionesControllers::fecha_mysql($request->fecha_cirugia);

        $fecha=$request->fecha_cirugia;
        if (strpos($fecha,"-") !== false)
            $fecha=str_replace("-", "/", $fecha);

        $datos_cirugia->fecha_carga=FuncionesControllers::fecha_mysql($fecha);
              
        $datos_cirugia->id_tipo_atencion=$request->tipo_atencion;
        $sql = "select * from maestro where padre='tipo_atencion' and id_campo=".$request->tipo_atencion;
        $data=DB::select($sql);
        foreach ($data as $data)
            $datos_cirugia->tipo_atencion=$data->campo;
        if ($request->monto_total==0) {
            $monto=$request->monto;
            //$monto=substr($monto,3);
            $monto=str_replace(".", "", $monto);
            $monto=str_replace(",", ".", $monto);
            $datos_cirugia->monto=$monto;
        } else
            $datos_cirugia->monto=$request->monto_total;
        if ($request->observaciones=="")
            $datos_cirugia->observaciones="-";
        /*if ($request->fecha_alta!="")
            $datos_cirugia->fecha_alta=FuncionesControllers::fecha_mysql($request->fecha_alta);*/
        if ($datos_cirugia->tipo_atencion==3)
            $datos_cirugia->tipo_atencion="CIRUGIA";

        if (isset($request->cirujano))
            $datos_cirugia->cirujano=$request->cirujano;
        else
            $datos_cirugia->cirujano=Session::get("nombre");

        //echo "nombre=".$datos_cirugia->cirujano;
        //return;

        $datos_cirugia->save();

        $sql = "update cirugias set monto='".$request->monto_total."' where id=".$id_cirugia;
        DB::update($sql);

        $sql = "select max(id) as id_datos_cirugia from datos_cirugia";
        $data=DB::select($sql);
        foreach ($data as $data)
            $id_datos_cirugia=$data->id_datos_cirugia;

        /*GUARDANDO MEDICO_CIRUGIA*/
        $medico_cirugia = new medico_cirugia($request->all());
        $medico_cirugia->id_cirugia=$id_cirugia;

        $datos = Input::all();
        $res="";
        $monto="";
        $id_rol="";
        foreach ($datos as $key=>$value) {
            if (strpos($key,"rol_") !== false) {
                $res.=$value.",";
                $id=substr($key,4);
                $id_rol.=$id.",";
                $nombre="monto_".$id;
                $cantidad=$datos[$nombre];
                //$cantidad=substr($cantidad,3);
                $cantidad=str_replace(".", "", $cantidad);
                $cantidad=str_replace(",", ".", $cantidad);
                $monto.=$cantidad.",";
            }
        }
        $res=substr($res,0,strlen($res)-1);
        $id_rol=substr($id_rol,0,strlen($id_rol)-1);
        $monto=substr($monto,0,strlen($monto)-1);

        $medico_cirugia->id_rol=$id_rol;
        $rol=$res;
        if ($rol=="0") $rol='';
        if (strpos($rol,"OTRO") !== false)
            $rol.=" (".$request->otro_rol.")";
        $medico_cirugia->rol=$rol;
        $medico_cirugia->monto=$monto;
        $medico_cirugia->id_datos_cirugia=$id_datos_cirugia;
        if ($id_rol!=0)
            $medico_cirugia->save();        

/************************* EMAIL A ENVIAR ***************************/
               /* Mail::send('correo.usuario', $request->all(), function($message)
                {
                    $message->to('jeleicy@gmail.com', $request->nombres." ".$request->apellidos)->subject('Usuario Nuevo!');
                });  

                Mail::send('correo.usuario', $request->all(), function($message)
                {
                    $message->to($request->email, $request->nombres." ".$request->apellidos)->subject('Usuario Nuevo!');
                });*/
/************************* EMAIL A ENVIAR ***************************/
        //return view('generica.formainsertada', ["tipo"=>"cirugia_medico"]);
        return Redirect::route('consulta_cirugia');
    }

    public static function consulta_cirugias($id_cirugia) {
        $sql = "select cirugias.id,datos_cirugia.tipo_atencion,cirugias.nombre,
                        medico_cirugia.rol,medico_cirugia.monto as monto_rol,
                        datos_cirugia.fecha_carga,datos_cirugia.fecha_alta,
                        cirugias.seguros,clinica_medico.nombre,
                        datos_cirugia.monto as monto_total, datos_cirugia.observaciones,datos_cirugia.id
                
                from cirugias

                Left JOIN datos_cirugia on datos_cirugia.id_cirugia=cirugias.id
                Left JOIN medico_cirugia on medico_cirugia.id_cirugia=cirugias.id and medico_cirugia.rol!=''
                Left JOIN clinica_medico on clinica_medico.id_clinica=cirugias.id_clinica

                where datos_cirugia.id_cirugia=".$id_cirugia." and datos_cirugia.id_tipo_atencion=3 and
                    medico_cirugia.id_datos_cirugia=datos_cirugia.id

                group by cirugias.id,datos_cirugia.tipo_atencion,cirugias.nombre,
                        medico_cirugia.rol,medico_cirugia.monto,
                        datos_cirugia.fecha_carga,datos_cirugia.fecha_alta,
                        cirugias.seguros,clinica_medico.nombre";
        //echo $sql;
        //return;
        $data = DB::select($sql);
        $end_data = count($data);
        $strDatos="[";
        $i=0;
        foreach ($data as $data) {
            $strDatos.="['".$data->tipo_atencion."',";
            $strDatos.="'".strtoupper($data->rol)."',";
            $strDatos.="'".$data->monto_rol."',";
            $strDatos.="'".$data->monto_total."',";
            $strDatos.="'".FuncionesControllers::fecha_normal($data->fecha_carga)."',";
            $strDatos.="'".$data->observaciones."',";
            $strDatos.="'Consultar Cirugia";
            $strDatos.="']";

            if (! ($i == $end_data-1)==true) {
                $strDatos.=",";
            }
            $i++;
        }
        $strDatos.="]";
        $strTabla="cirugia";
        $strColumnas="{ title: \"Tipo Atencion\" },{ title: \"Rol\" },{ title: \"Monto Rol\" },{ title: \"Monto Tipo Atencion\" },{ title: \"Fecha Atencion\" },{ title: \"Observaciones\" },{ title: \"-\" }";
        $strtfoot="<th>Tipo Atencion</th><th>Rol</th><th>Monto Rol</th><th>Monto Tipo Atencion</th><th>Fecha Atencion</th><th>Observaciones</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de cirugias";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);

    }

    public static function consulta($fecha1, $fecha2)
    {
        //
        $sql = "select
                    cir.nombre as nombre_cirugia, cir.id as id_cirugia, 
                    m.id as id_medico, m.nombres as nombre_medico, 
                    m.apellidos as apellidos_medico, 
                    p.nombres, p.apellidos,
                    c.nombre as clinica, c.id, cir.id_clinica, 
                    cir.fecha_cirugia, sum(cs.monto) as monto
                from
                    paciente p, medico_cirugia mc, 
                    cirugias cir, clinica c, medico m,
                    cirugia_seguro cs
                where 
                    mc.id_cirugia=cir.id and 
                    cir.id_medico=m.id and cir.id_paciente=p.id and
                    c.id=cir.id_clinica and 
                    cs.id_cirugia=cir.id and 
                    cir.fecha_cirugia between '".$fecha1."' and '".$fecha2."' ";

                if (Session::get("tipo")==2)
                    $sql .= " and m.id=".Session::get("id_medico");

        $sql .= " group by m.id, m.nombres, m.apellidos, 
                    p.nombres, p.apellidos, c.nombre, c.id, cir.id_clinica, cir.fecha_cirugia";

        //echo $sql;
        //return;
        $data = DB::select($sql);
        $end_data = count($data);
        $strDatos="[";
        $i=0;
        foreach ($data as $data) {
            $strDatos.="['".$data->nombre_cirugia."',";
            $strDatos.="'".strtoupper($data->nombres." ".$data->apellidos)."',";
            $strDatos.="'".strtoupper($data->nombre_medico." ".$data->apellidos_medico)."',";
            $strDatos.="'".$data->clinica."',";
            $strDatos.="'".FuncionesControllers::fecha_normal($data->fecha_cirugia)."',";
            $strDatos.="'Bs. ".number_format($data->monto,"2",",",".")."','";
            $strDatos.='<div class="btn-group"><a href="consultarcirugia/'.$data->id_cirugia.'"><button class="btn btn-default" type="button">Consultar</button></a></div>';
            $strDatos.="']";

            if (! ($i == $end_data-1)==true) {
                $strDatos.=",";
            }
            $i++;
        }
        $strDatos.="]";
        $strTabla="cirugia";
        $strColumnas="{ title: \"Cirugia\" },{ title: \"Paciente\" },{ title: \"Medico\" },{ title: \"Clinica\" },{ title: \"Fecha Cirugia\" },{ title: \"Monto\" },{ title: \"-\" }";
        $strtfoot="<th>Cirugia</th><th>Paciente</th><th>Clinica</th><th>Fecha Cirugia</th><th>Monto</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de cirugias";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}