<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Sessiongrupo_candidatosControllers;
use App\grupo_candidatos;
use App\Http\Controllers\FuncionesControllers;

class GrupoCandidatosControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('grupo_candidatos.consulta', ["mensaje" => ""]);
    }

    public function nuevo_grupo_candidatos() {
        Session::put("mensaje","");
        return view('grupo_candidatos.nuevo',["mensaje"=>"", "id"=>0, "tipo"=>""]);
    }

    public function consultargrupo_candidatos($id)
    {
        $grupo_candidatos=grupo_candidatos::findOrFail($id);
        return view::make('grupo_candidatos.edit', compact('grupo_candidatos'));
    }

    public function guardar_grupo_candidatos_edicion(Request $request) {
        $id=$request->id;
        $grupo_candidatos=grupo_candidatos::findOrFail($id);
        $grupo_candidatos->fill($request->all());

		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		$grupo_candidatos->activa=$activa;

        $grupo_candidatos->save();
        return view('grupo_candidatos.consulta', ["mensaje" => "Grupo de Candidato actualizado satisfactoriamente"]);
    }

    public function guardar_grupo_candidatos_nuevo (Request $request) {
        $grupo_candidatos = new grupo_candidatos($request->all());

        Session::put("mensaje","");

        $fileName = "";

		if ($request->activa)
			$activa=1;
		else
			$activa=0;

        $sql = "select * from grupo_candidatos where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
			$grupo_candidatos->activa=$activa;
            $grupo_candidatos->save();
            return view('grupo_candidatos.consulta', ["mensaje" => "Grupo de Candidato insertado satisfactoriamente"]);
        } else {
            return view('grupo_candidatos.nuevo', ["mensaje" => "Ya existe otro Grupo con este nombre", "id" => 0, "tipo"=>$request->tipo]);
        }
    }

    public static function consulta()
    {

        $grupo_candidatos = grupo_candidatos::all();

        $strDatos="[";
        $end_data = grupo_candidatos::count();

        foreach ($grupo_candidatos as $key=>$grupo_candidatos) {
            $strDatos.="['".$grupo_candidatos->nombres."',";
			$strDatos.="'".$grupo_candidatos->id_grupo_candidatos."',";
            $strDatos.="'<a href=consultargrupo_candidatos/".$grupo_candidatos->id.">Consultar</a> | <a href=eliminargrupo_candidatos/".$grupo_candidatos->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="grupo_candidatos";
        $strColumnas="{ title: \"Tipo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>Grupo de Candidatos</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]";
        $intCantidad=10;
        $strNombreArchivo="Listado de Grupo de Candidatos";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}
