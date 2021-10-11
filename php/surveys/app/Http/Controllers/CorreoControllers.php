<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\SessioncorreoControllers;
use App\correo;
use App\Http\Controllers\FuncionesControllers;

class CorreoControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('correo.consulta', ["mensaje" => ""]);
    }

    public function nuevo_correo() {
        Session::put("mensaje","");
        return view('correo.nuevo',["mensaje"=>"", "id"=>0, "tipo"=>""]);
    }

    public function consultarcorreos($id)
    {
        $correo=correo::findOrFail($id);
        return view::make('correo.edit', compact('correo'));
    }        

    public function guardar_correo_edicion(Request $request) {
        //dd($request->all());
        //return;
        $id=$request->id;
        $correo=correo::findOrFail($id);
        $correo->fill($request->all());
		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		$correo->activa=$activa;
		$correo->texto=$request->noise;
        $correo->save();
        return view('correo.consulta', ["mensaje" => "Correo actualizado satisfactoriamente"]);
    }

    public function guardar_correo_nuevo (Request $request) {
		//dd($request->all());
		
        $correo = new correo($request->all());

        Session::put("mensaje","");

        $fileName = "";
		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		
        $sql = "select * from correo where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
			$correo->texto=$request->noise;
			$correo->activa=$activa;
            $correo->save();
            return view('correo.consulta', ["mensaje" => "Correo insertado satisfactoriamente"]);
        } else {
            return view('correo.nuevo', ["mensaje" => "Ya existe otra correo con este nombre", "id" => 0, "tipo"=>$request->tipo]);
        }
    }

    public static function consulta()
    {
        //
        $correo = correo::all();
        
        $strDatos="[";
        $end_data = correo::count();

        foreach ($correo as $key=>$correo) {
            $strDatos.="['".$correo->nombres."',";
			$strDatos.="'".$correo->id_correo."',";
            $strDatos.="'<a href=consultarcorreo/".$correo->id.">Consultar</a> | <a href=eliminarcorreo/".$correo->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="correo";
        $strColumnas="{ title: \"Tipo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>correo</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de correo";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}