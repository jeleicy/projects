<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\texto_aceptacion;
use App\Http\Controllers\FuncionesControllers;

class TextoAceptacionControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('texto_aceptacion.consulta', ["mensaje" => ""]);
    }

    public function nuevo_texto_aceptacion() {
        Session::put("mensaje","");
        return view('texto_aceptacion.nuevo',["mensaje"=>"", "id"=>0, "tipo"=>""]);
    }

    public function consultartexto_aceptacion($id)
    {
        $texto_aceptacion=texto_aceptacion::findOrFail($id);
        return view::make('texto_aceptacion.edit', compact('texto_aceptacion'));
    }        

    public function guardar_texto_aceptacion_edicion(Request $request) {
        $id=$request->id;
        $texto_aceptacion=texto_aceptacion::findOrFail($id);
        $texto_aceptacion->fill($request->all());
		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		$texto_aceptacion->activa=$activa;
		
        $texto_aceptacion->save();
        return view('texto_aceptacion.consulta', ["mensaje" => "Texto actualizado satisfactoriamente"]);
    }

    public function guardar_texto_aceptacion_nuevo (Request $request) {
		//dd($request->all());
        $texto_aceptacion = new texto_aceptacion($request->all());

        Session::put("mensaje","");

        $fileName = "";
		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		
        $sql = "select * from texto_aceptacion where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
			$texto_aceptacion->activa=$activa;
            $texto_aceptacion->save();
            return view('texto_aceptacion.consulta', ["mensaje" => "Texto insertado satisfactoriamente"]);
        } else {
            return view('texto_aceptacion.nuevo', ["mensaje" => "Ya existe otro Texto con este nombre", "id" => 0, "tipo"=>$request->tipo]);
        }
    }

    public static function consulta()
    {

        $texto_aceptacion = texto_aceptacion::all();
        
        $strDatos="[";
        $end_data = texto_aceptacion::count();

        foreach ($texto_aceptacion as $key=>$texto_aceptacion) {
            $strDatos.="['".$texto_aceptacion->nombres."',";
			$strDatos.="'".$texto_aceptacion->id_texto_aceptacion."',";
            $strDatos.="'<a href=consultartexto_aceptacion/".$texto_aceptacion->id.">Consultar</a> | <a href=eliminartexto_aceptacion/".$texto_aceptacion->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="texto_aceptacion";
        $strColumnas="{ title: \"Tipo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>Textos</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de Textos";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}