<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\SessioninstruccionesControllers;
use App\instrucciones;
use App\Http\Controllers\FuncionesControllers;

class InstruccionesControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('instrucciones.consulta', ["mensaje" => ""]);
    }

    public function nuevo_instrucciones() {
        Session::put("mensaje","");
        return view('instrucciones.nuevo',["mensaje"=>"", "id"=>0, "tipo"=>""]);
    }

    public function consultarinstrucciones($id)
    {
        $instrucciones=instrucciones::findOrFail($id);
        return view::make('instrucciones.edit', compact('instrucciones'));
    }        

    public function guardar_instrucciones_edicion(Request $request) {
        //dd($request->all());
        //return;
        $id=$request->id;
        $instrucciones=instrucciones::findOrFail($id);
        $instrucciones->fill($request->all());
		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		$instrucciones->activa=$activa;
		
		$texto=$request->texto;
		//$texto=str_replace("<p>","<span>",$texto);
		//$texto=str_replace("</p>","</span>",$texto);
		$instrucciones->texto=$texto;		
		
        $instrucciones->save();
        return view('instrucciones.consulta', ["mensaje" => "instrucciones actualizado satisfactoriamente"]);
    }

    public function guardar_instrucciones_nuevo (Request $request) {
		//dd($request->all());
		
        $instrucciones = new instrucciones($request->all());

        Session::put("mensaje","");

        $fileName = "";
		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		
        $sql = "select * from instrucciones where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
			$instrucciones->activa=$activa;
			$texto=$request->texto;
			//$texto=str_replace("<p>","<span>",$texto);
			//$texto=str_replace("</p>","</span>",$texto);
			$instrucciones->texto=$texto;
            $instrucciones->save();
            return view('instrucciones.consulta', ["mensaje" => "Instrucciones insertadas satisfactoriamente"]);
        } else {
            return view('instrucciones.nuevo', ["mensaje" => "Ya existe otra instruccion con este nombre", "id" => 0, "tipo"=>$request->tipo]);
        }
    }

    public static function consulta()
    {
        //
        $instrucciones = instrucciones::all();
        
        $strDatos="[";
        $end_data = instrucciones::count();

        foreach ($instrucciones as $key=>$instrucciones) {
            $strDatos.="['".$instrucciones->nombres."',";
			$strDatos.="'".$instrucciones->id_instrucciones."',";
            $strDatos.="'<a href=consultarinstrucciones/".$instrucciones->id.">Consultar</a> | <a href=eliminarinstrucciones/".$instrucciones->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="instrucciones";
        $strColumnas="{ title: \"Tipo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>instrucciones</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de instrucciones";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}