<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Sessionpreguntas_opcionesControllers;
use App\preguntas;
use App\opciones;
use App\Http\Controllers\FuncionesControllers;

class PreguntasOpcionesControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('preguntas_opciones.consulta', ["mensaje" => ""]);
    }

    public function nuevo_preguntas_opciones() {
        Session::put("mensaje","");
        return view('preguntas_opciones.nuevo',["mensaje"=>"", "id"=>0, "tipo"=>""]);
    }

    public function consultarpreguntas_opciones($id)
    {
        $preguntas_opciones=preguntas_opciones::findOrFail($id);
        return view::make('preguntas_opciones.edit', compact('preguntas_opciones'));
    }        

    public function guardar_preguntas_opciones_edicion(Request $request) {
        //dd($request->all());
        //return;
        $id=$request->id;
        $preguntas_opciones=preguntas_opciones::findOrFail($id);
        $preguntas_opciones->fill($request->all());
		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		$preguntas_opciones->activa=$activa;
		
		$texto=$request->texto;
		//$texto=str_replace("<p>","<span>",$texto);
		//$texto=str_replace("</p>","</span>",$texto);
		$preguntas_opciones->texto=$texto;		
		
        $preguntas_opciones->save();
        return view('preguntas_opciones.consulta', ["mensaje" => "preguntas_opciones actualizado satisfactoriamente"]);
    }

    public function guardar_preguntas_opciones_nuevo (Request $request) {
		//dd($request->all());
		
        $preguntas_opciones = new preguntas_opciones($request->all());

        Session::put("mensaje","");

        $fileName = "";
		
		if ($request->activa)
			$activa=1;
		else
			$activa=0;
		
        $sql = "select * from preguntas_opciones where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
			$preguntas_opciones->activa=$activa;
			$texto=$request->texto;
			//$texto=str_replace("<p>","<span>",$texto);
			//$texto=str_replace("</p>","</span>",$texto);
			$preguntas_opciones->texto=$texto;
            $preguntas_opciones->save();
            return view('preguntas_opciones.consulta', ["mensaje" => "preguntas_opciones insertadas satisfactoriamente"]);
        } else {
            return view('preguntas_opciones.nuevo', ["mensaje" => "Ya existe otra instruccion con este nombre", "id" => 0, "tipo"=>$request->tipo]);
        }
    }

    public static function consulta()
    {
        //
        $preguntas_opciones = preguntas_opciones::all();
        
        $strDatos="[";
        $end_data = preguntas_opciones::count();

        foreach ($preguntas_opciones as $key=>$preguntas_opciones) {
            $strDatos.="['".$preguntas_opciones->nombres."',";
			$strDatos.="'".$preguntas_opciones->id_preguntas_opciones."',";
            $strDatos.="'<a href=consultarpreguntas_opciones/".$preguntas_opciones->id.">Consultar</a> | <a href=eliminarpreguntas_opciones/".$preguntas_opciones->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="preguntas_opciones";
        $strColumnas="{ title: \"Tipo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>preguntas_opciones</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de preguntas_opciones";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
	
	public function consultarpreguntaopcion($id) {
		return view('pruebas.consultarpreguntaopcion',["mensaje"=>"", "id"=>$id]);
	}
	
	public function consultaropcion($id) {
		return view('pruebas.consultaropcion',["mensaje"=>"", "id"=>$id]);
	}	
	
	public function editarpregunta($id) {
		//dd($id);
		//"1.1"
		//id_pregunta.id_tipo_prueba
		$id_pregunta=substr($id,0,strpos($id,"."));
		$id_tipo_prueba=substr($id,strpos($id,".")+1);
		return view('pruebas.editarpregunta',["mensaje"=>"", "id_pregunta"=>$id_pregunta, "id_tipo_prueba"=>$id_tipo_prueba]);
	}
	
	public function nuevapregunta($id) {
		//dd($id);
		//"1.1"
		//id_pregunta.id_tipo_prueba
		$id_tipo_prueba=$id;
		return view('pruebas.nuevapregunta',["mensaje"=>"", "id_tipo_prueba"=>$id_tipo_prueba]);
	}
	
	public function guardar_pregunta(Request $request) {
		dd($request->all());				
		$preguntas = new preguntas($request->all());
		//'id_tipo_prueba','pregunta','respuesta','imagen','orden','id_idioma','fecha_creacion','activo'
		//$pregunta=$request->pregunta;
		//$id_idioma=$request->id_idioma;
		//$activo=$request->activo;
		$id_tipo_prueba=$request->id_tipo_prueba;
		
		$imagen=Input::file('imagen');
		if ($imagen) {
			if (Input::file('imagen')->isValid()) {
				$destino = 'imagenes/pruebas/'.$id_tipo_prueba; // upload path
				if(!readdir($destino))
					mkdir($destino, 0700);
				
				$extension = Input::file('imagen')->getClientOriginalExtension(); // getting image extension

				$imagen = $empresa->id . '.' . $extension; // renameing image
				Input::file('imagen')->move($destino, $imagen); // uploading file to given path
				$preguntas->imageb=$imagen;
			}
		}		

		$preguntas->save();		
		self::consultarpreguntaopcion($id_tipo_prueba);		
		//return view('pruebas.consultarpreguntaopcion',["mensaje"=>"Pregunta insertada satisfactoriamente", "id_pregunta"=>$id_pregunta, "id_tipo_prueba"=>$id_tipo_prueba]);
	}	
	
}