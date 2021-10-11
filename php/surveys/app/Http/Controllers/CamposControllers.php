<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\SessioncamposControllers;
use App\campos_candidatos;
use App\contenidos_campos;
use App\Http\Controllers\FuncionesControllers;

class CamposControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('campos.consulta', ["mensaje" => ""]);
    }

    public function nuevo_campos() {
        Session::put("mensaje","");
        return view('campos.nuevo',["mensaje"=>"", "id"=>0, "tipo"=>""]);
    }

    public function consultarcampos($id)
    {
        $campos=campos_candidatos::findOrFail($id);
        return view::make('campos.edit', compact('campos'));
    }        

    public function guardar_campos_edicion(Request $request) {
        $id=$request->id;
        $campos=campos_candidatos::findOrFail($id);
        $campos->fill($request->all());
		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		$campos->activa=$activa;
		
        $campos->save();
        return view('campos.consulta', ["mensaje" => "Grupo de Candidato actualizado satisfactoriamente"]);
    }

    public function guardar_campos_nuevo (Request $request) {		
        $campos = new campos_candidatos($request->all());
		
		//dd($request->all());

        Session::put("mensaje","");

        $fileName = "";
		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		
        $sql = "select * from campos_candidatos where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
			$campos->activa=$activa;
			$campos->valores=$request->valores_tipo_campo;
            $campos->save();
            return view('campos.consulta', ["mensaje" => "Grupo de Candidato insertado satisfactoriamente"]);
        } else {
            return view('campos.nuevo', ["mensaje" => "Ya existe otro Grupo con este nombre", "id" => 0, "tipo"=>$request->tipo]);
        }
    }

    public static function consulta()
    {

        $campos = campos::all();
        
        $strDatos="[";
        $end_data = campos::count();

        foreach ($campos as $key=>$campos) {
            $strDatos.="['".$campos->nombres."',";
			$strDatos.="'".$campos->id_campos."',";
            $strDatos.="'<a href=consultarcampos/".$campos->id.">Consultar</a> | <a href=eliminarcampos/".$campos->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="campos";
        $strColumnas="{ title: \"Tipo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>Grupo de Candidatos</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de Grupo de Candidatos";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}