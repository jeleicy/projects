<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\SessionControllers;
use App\bateria;
use App\bateria_tipo_prueba;
use App\Http\Controllers\FuncionesControllers;

class BateriaControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('bateria.consulta', ["mensaje" => ""]);
    }

    public function nuevo_bateria() {
        Session::put("mensaje","");
        return view('bateria.nuevo',["mensaje"=>"", "id"=>0, "tipo"=>""]);
    }

    public function consultarbaterias($id)
    {
        $bateria=bateria::findOrFail($id);
        return view::make('bateria.edit', compact('bateria'));
    }        

    public function guardar_bateria_edicion(Request $request) {
        //dd($request->all());
        //return;
		$datos=$request->all();
        $id=$request->id;
        $bateria=bateria::findOrFail($id);
        $bateria->fill($request->all());		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		$bateria->activa=$activa;		
        $bateria->save();
		
		$id_tipo_prueba=array();
		$i=0;
        
		foreach ($datos as $key => $value) {
			if (strpos($key,"id_tipos_pruebas") !== false) {
				$id_tipo_prueba[$i]=$value;				
				$id_tp=substr($key,17);
				$orden[$i]=$datos["orden_".$id_tp];
				$i++;
			}	
		}	

		$sql = "delete from bateria_tipo_prueba where id_bateria=".$id;
        //print_r ($id_tipo_prueba);
        //var_dump($id_tipo_prueba[0]);
		DB::delete($sql);
		foreach ($id_tipo_prueba as $key => $value) {
			$bateria_tipo_prueba = new bateria_tipo_prueba($datos);
			$bateria_tipo_prueba->id_bateria=$id;
			$bateria_tipo_prueba->id_tipo_prueba=$value;
			$bateria_tipo_prueba->orden=$orden[$key];
			$bateria_tipo_prueba->save();
		} 		
        return view('bateria.consulta', ["mensaje" => "Bateria actualizada satisfactoriamente"]);
    }

    public function guardar_bateria_nuevo (Request $request) {		
		//dd($request->all());
		
		$datos=$request->all();		        

        Session::put("mensaje","");

		if ($request->activa) $activa=1;
		else $activa=0;
		
        $sql = "select * from bateria where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
			$bateria = new bateria($request->all());
			$bateria->activa=$activa;
            $bateria->save();
			$id_bateria=$bateria->id;
			
			$id_tipo_prueba=array();
			$orden="";
			$i=0;
			foreach ($datos as $key => $value) {
				if (strpos($key,"id_tipos_pruebas") !== false) {
					$id_tipo_prueba[$i]=$value;				
					$id_tp=substr($key,17);				
					$orden[$i]=$datos["orden_".$id_tp];
					$i++;
				}	
			}
			$sql = "delete from bateria_tipo_prueba where id_bateria=".$id_bateria;
			DB::delete($sql);
            //print_r ($id_tipo_prueba);
			foreach ($id_tipo_prueba as $key => $value) {
				$bateria_tipo_prueba = new bateria_tipo_prueba($datos);
				$bateria_tipo_prueba->id_bateria=$id_bateria;
				$bateria_tipo_prueba->id_tipo_prueba=$value;
				$bateria_tipo_prueba->orden=$orden[$key];
				$bateria_tipo_prueba->save();
			}
			
            return view('bateria.consulta', ["mensaje" => "Bateria insertada satisfactoriamente"]);
        } else {
            return view('bateria.nuevo', ["mensaje" => "Ya existe otra bateria con este nombre", "id" => 0, "tipo"=>$request->tipo]);
        }
    }

    public static function consulta()
    {
        //
        $bateria = bateria::all();
        
        $strDatos="[";
        $end_data = bateria::count();

        foreach ($bateria as $key=>$bateria) {
            $strDatos.="['".$bateria->nombres."',";
			$strDatos.="'".$bateria->id_bateria."',";
            $strDatos.="'<a href=consultarbateria/".$bateria->id.">Consultar</a> | <a href=eliminarbateria/".$bateria->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="bateria";
        $strColumnas="{ title: \"Tipo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>bateria</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de bateria";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}