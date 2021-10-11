<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\SessionempresaControllers;
use App\empresa;
use App\Http\Controllers\FuncionesControllers;

class empresaControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('empresa.consulta', ["mensaje" => ""]);
    }

    public function nuevo_empresa() {
        Session::put("mensaje","");
        return view('empresa.nuevo',["mensaje"=>"", "id"=>0, "tipo"=>""]);
    }

    public function consultarempresas($id)
    {
        $empresa=empresa::findOrFail($id);
        return view::make('empresa.edit', compact('empresa'));
    }        

    public function guardar_empresa_edicion(Request $request) {
        //dd($request->all());
        //return;
        $id=$request->id;
        $empresa=empresa::findOrFail($id);
        $empresa->fill($request->all());
		
		$logo=Input::file('logo');
		if ($logo) {
			if (Input::file('logo')->isValid()) {
				$destino = 'empresas/logos/'; // upload path
				$extension = Input::file('logo')->getClientOriginalExtension(); // getting image extension

				$imagen = $empresa->id . '.' . $extension; // renameing image
				Input::file('logo')->move($destino, $imagen); // uploading file to given path
				$empresa->logo=$imagen;
			}
		}
		
        $empresa->save();
        return view('empresa.consulta', ["mensaje" => "Empresa actualizado satisfactoriamente"]);
    }

    public function guardar_empresa_nuevo (Request $request) {
        $empresa = new empresa($request->all());

        Session::put("mensaje","");

        $imagen = "";
        $sql = "select * from empresas where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
			$empresa->save();
			
			$logo=Input::file('logo');
			if ($logo) {
				if (Input::file('logo')->isValid()) {
					$destino = 'empresas/logos/'; // upload path
					$extension = Input::file('logo')->getClientOriginalExtension(); // getting image extension

					$imagen = $empresa->id . '.' . $extension; // renameing image
					Input::file('logo')->move($destino, $imagen); // uploading file to given path
					$empresa->logo=$imagen;
				}
			}    			
			$sql = "update empresas set logo='$imagen' where id=".$empresa->id;
			DB::update($sql);
            return view('empresa.consulta', ["mensaje" => "Empresa insertado satisfactoriamente"]);
        } else {
            return view('empresa.nuevo', ["mensaje" => "Ya existe otra empresa con este nombre", "id" => 0, "tipo"=>$request->tipo]);
        }
    }

    public static function consulta()
    {
        //
        $empresa = empresa::all();
        
        $strDatos="[";
        $end_data = empresa::count();

        foreach ($empresa as $key=>$empresa) {
            $strDatos.="['".$empresa->nombres."',";
			$strDatos.="'".$empresa->id_empresa."',";
            $strDatos.="'<a href=consultarempresa/".$empresa->id.">Consultar</a> | <a href=eliminarempresa/".$empresa->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="empresa";
        $strColumnas="{ title: \"Tipo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>Empresa</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de empresa";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}