<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Redirect;
use Form;
use App\Http\Controllers\FuncionesControllers;

use PDF;

?>

@include('layout.pruebas.header')

<?php

    function Baremo($baremo,$valor){
        $result = 0;
        switch (TRUE) {
            case ($baremo == 'B1') : $result = Ingles($valor); break;
            case ($baremo == 'C1') : $result = Realidad($valor); break;
            case ($baremo == 'C2') : $result  = Posibilidad($valor); break;
            case ($baremo == 'C3') : $result  = AccionResultados($valor); break;
            case ($baremo == 'C4') : $result  = Relaciones($valor); break;
            case ($baremo == 'C5') : $result  = Aprendizaje($valor); break;
            case ($baremo == 'CG') : $result  = SubCompetencias($valor); break;                                
        }
        return $result ;
    }
	
    function Ingles($bruto){

        $puntaje_neto_eval = intval(580 + ( ( ( $bruto - 55.68 ) / 21.18 ) * 200 ) );
        switch(TRUE){
            case ($bruto >= 0 & $bruto <= 29) : $nivel_resultado = 'BASICO'; break;
            case ($bruto >= 30 & $bruto <= 64) : $nivel_resultado = 'INTERMEDIO'; break;
            case ($bruto >= 65 & $bruto <= 100) : $nivel_resultado = 'AVANZADO'; break;
        }
        switch(TRUE){
            case ($bruto >= 0 & $bruto <= 10) : $sub_nivel_resultado = 'I'; break;
            case ($bruto >= 11 & $bruto <= 20) : $sub_nivel_resultado = 'II'; break;
            case ($bruto >= 21 & $bruto <= 29) : $sub_nivel_resultado = 'III'; break;
            case ($bruto >= 30 & $bruto <= 41) : $sub_nivel_resultado = 'I'; break;
            case ($bruto >= 42 & $bruto <= 52) : $sub_nivel_resultado = 'II'; break;
            case ($bruto >= 53 & $bruto <= 64) : $sub_nivel_resultado = 'III'; break;
            case ($bruto >= 65 & $bruto <= 76) : $sub_nivel_resultado = 'I'; break;
            case ($bruto >= 77 & $bruto <= 88) : $sub_nivel_resultado = 'II'; break;
            case ($bruto >= 89 & $bruto <= 100) : $sub_nivel_resultado = 'III'; break;
        }
        
        $porcentaje_neto_eval = ($neto / 1000) * 100;
        $resultado_eval = "Evaluado";
        $resultado = array("puntaje_neto_evaluacion"=> $puntaje_neto_eval, "porcentaje_neto_evaluacion"=> $porcentaje_neto_eval,"resultado_evaluacion"=> $resultado_eval, "nivel_resultado_evaluacion" => $nivel_resultado, "sub_nivel_resultado_evaluacion" => $sub_nivel_resultado); 
        return $resultado; 
    }
    
    function Realidad($bruto){
        $neto = 0;
        switch(TRUE){
            case ($bruto <= -1) : $neto = 5; break;   
            case ($bruto > -1 && $bruto < 6) : $neto = 25; break;
            case ($bruto == 6) : $neto = 40; break;
            case ($bruto > 6 && $bruto < 9) : $neto = 50; break;
            case ($bruto > 8 && $bruto < 13) : $neto = 60; break;
            case ($bruto > 12 && $bruto < 15) :  $neto = 75; break;                       
            case ($bruto > 14) : $neto = 95; break;  
            default : $neto == 0; break;   
        }
        return $neto; 
    }

    function Posibilidad($bruto){
        $neto = 0;
        switch(TRUE){
            case ($bruto < -4) : $neto = 5; break;   
            case ($bruto > -5 && $bruto < -5) : $neto = 25; break;
            case ($bruto > -3 && $bruto < 1) : $neto = 40; break;
            case ($bruto > 0 && $bruto < 4) : $neto = 50; break;
            case ($bruto > 3 && $bruto < 6) : $neto = 60; break;
            case ($bruto > 5 && $bruto < 8) :  $neto = 75; break;                       
            case ($bruto > 14) : $neto = 95; break;
            default : $neto == 0; break;   
        }
        return $neto; 
    }

    function AccionResultados($bruto){
        $neto = 0;
        switch(TRUE){
            case ($bruto < -7) : $neto = 5; break;   
            case ($bruto >-8 && $bruto < -2) : $neto = 25; break;
            case ($bruto > -3 && $bruto < 2) : $neto = 40; break;
            case ($bruto == 2) : $neto = 50; break;
            case ($bruto > 2 && $bruto < 5) : $neto = 60; break;
            case ($bruto > 4 && $bruto < 10) :  $neto = 75; break;                       
            case ($bruto > 9) : $neto = 95; break;
            default : $neto == 0;
            break;
        }
        return $neto; 
    }

    function Relaciones($bruto){
        $neto = 0;
        switch(TRUE){
            case ($bruto < -7) : $neto = 5; break;   
            case ($bruto > -6 && $bruto < -2) : $neto = 25; break;
            case ($bruto > -1 && $bruto < 2) : $neto = 40; break;
            case ($bruto > 1 && $bruto < 4) : $neto = 50; break;
            case ($bruto > 3 && $bruto < 6) : $neto = 60; break;
            case ($bruto > 5 && $bruto < 10) :  $neto = 75; break;                       
            case ($bruto > 9) : $neto = 95; break;
            default: $neto == 0;
            break;  
        }
        return $neto; 
    }

    function Aprendizaje($bruto){
        $neto = 0;
        switch(TRUE){
            case ($bruto < -7) : $neto = 5; break;   
            case ($bruto > -6 && $bruto < -2) : $neto = 25; break;
            case ($bruto > -1 && $bruto < 2) : $neto = 40; break;
            case ($bruto > 1 && $bruto < 4) : $neto = 50; break;
            case ($bruto > 3 && $bruto < 6) : $neto = 60; break;
            case ($bruto > 5 && $bruto < 10) :  $neto = 75; break;                       
            case ($bruto > 9) : $neto = 95; break;
            default: $neto == 0; break;   
        }
        return $neto; 
    }

    function SubCompetencias($bruto){
        $neto = 0;
        switch(TRUE){
            case ($bruto < -3) : $neto = 5; break;   
            case ($bruto > -4 && $bruto < -0) : $neto = 25; break;
            case ($bruto == 0) : $neto = 40; break;
            case ($bruto == 1) : $neto = 50; break;
            case ($bruto > 1 && $bruto < 4) : $neto = 60; break;
            case ($bruto == 4) :  $neto= 75; break;                       
            case ($bruto > 4) : $neto = 95; break;
            default: $neto == 0; break;
        }
        return $neto; 
    }
	

    /// Trae los datos del registro de la Evaluacion acorde al cod_evaluacion
    $sql_evaluacion = "SELECT * FROM tb_evaluaciones WHERE cod_evaluacion = '$cod_evaluacion'";
    $data = DB::select($sql_evaluacion); 
    foreach ($data as $data) {
        $id_evaluado = $data->id_evaluado;     
        $nombres_evaluado = $data->nombres_evaluado;   
        $apellidos_evaluado = $data->apellidos_evaluado;
        $email_evaluado = $data->email_evaluado;
        $codigo_prueba = $data->codigo_prueba;
        $status_evaluacion = $data->status_evaluacion;
        $fecha_evaluacion = date('Y-m-d');
        $vigencia_evaluacion = $data->vigencia_evaluacion;
        $hora_ini_evaluacion = date('H:i:s', time());
        $hora_fin_evaluacion = $data->hora_fin_evaluacion;
        $ingresos_evaluacion = $data->ingresos_evaluacion;
        $id_tutor = $data->id_tutor;
        $nombres_tutor = $data->nombres_tutor;
        $apellidos_tutor = $data->apellidos_tutor;
        $email_tutor = $data->email_tutor;
        $nombre_com_cliente = $data->nombre_com_cliente;
        $email_contacto_cliente = $data->email_contacto_cliente;
    } 

    /// Trae los datos del registro del cliente acorde al nombre_com_cliente
    $sql_cliente = "SELECT * FROM tb_clientes WHERE nombre_com_cliente = '$nombre_com_cliente'";
    $cliente = DB::select($sql_cliente); 
    /*foreach ($cliente as $cliente){
        $logo_cliente = $data->logo_cliente;
     } */

    ///Trae valores de la prueba
    $sql_prueba = "SELECT * FROM tb_pruebas WHERE codigo_prueba = '$codigo_prueba'";
	//echo $sql_prueba; return;
    $data = DB::select($sql_prueba);
    foreach ($data as $data){
        $nombre_prueba = $data->nombre_prueba;
        $tipo_prueba = $data->tipo_prueba;
        $categoria_prueba = $data->categoria_prueba;
        $cant_categorias_preguntas_prueba = $data->cant_categorias_preguntas_prueba;
        $cant_preguntas_prueba = $data->cant_preguntas_prueba;
        $cant_ingresos_prueba = $data->cant_ingresos_prueba;
        $tiempo_prueba = $data->tiempo_prueba;
        $porcentaje_min_aprobacion_prueba = $data->porcentaje_min_aprobacion_prueba;
        $mostrar_resultado_prueba = $data->mostrar_resultado_prueba;
        $mostrar_complementos_prueba = $data->mostrar_complementos_prueba;
        $complementos_prueba = $data->complementos_prueba;
        $mostrar_detalle_respondidas_prueba = $data->mostrar_detalle_respondidas_prueba;
        $mostrar_correctas_incorrectas_prueba = $data->mostrar_correctas_incorrectas_prueba;
        $mostrar_reporte_prueba = $data->mostrar_reporte_prueba;
        $reporte_prueba = $data->reporte_prueba;
        $usar_baremo_prueba = $data->usar_baremo_prueba;
        $baremo_prueba = $data->baremo_prueba;
        $resultado_simple_prueba = $data->resultado_simple_prueba;
    }
    
    ///Trae las preguntas de la prueba
    $sql_preguntas = "SELECT * FROM tb_preguntas WHERE codigo_prueba = '$codigo_prueba' ORDER BY numero_pregunta";  
	//echo $sql_preguntas; return;
    $data = DB::select($sql_preguntas);
    foreach ($data as $data){
        $pregunta[$data->numero_pregunta]["enunciado_pregunta"] = $data->enunciado_pregunta;
        $pregunta[$data->numero_pregunta]["numero_opciones"] = $data->numero_opciones;
        $pregunta[$data->numero_pregunta]["dificultad_pregunta"] = $data->dificultad_pregunta;
        $pregunta[$data->numero_pregunta]["peso_pregunta"] = $data->peso_pregunta;
        $pregunta[$data->numero_pregunta]["status_pregunta"] = $data->status_pregunta;
        $pregunta[$data->numero_pregunta]["numero_categoria"] = $data->numero_categoria;
        $pregunta[$data->numero_pregunta]["nombre_categoria"] = $data->nombre_categoria;
        $pregunta[$data->numero_pregunta]["numero_subcategoria"]= $data->numero_subcategoria;
        $pregunta[$data->numero_pregunta]["nombre_subcategoria"] = $data->nombre_subcategoria;
        $pregunta[$data->numero_pregunta]["imagen_pregunta"] = $data->imagen_pregunta;
        $pregunta[$data->numero_pregunta]["usar_opciones_generales"] = $data->usar_opciones_generales;        
    }

    ///Trae las opciones de las preguntas
    $sql_opciones = "SELECT * FROM tb_opciones WHERE codigo_prueba = '$codigo_prueba' ORDER BY numero_pregunta";
	
    $data = DB::select($sql_opciones);
    foreach ($data as $data) {    
        $opcion[$data->numero_pregunta][$data->numero_opcion]["enunciado_opcion"] = $data->enunciado_opcion;
        $opcion[$data->numero_pregunta][$data->numero_opcion]["valor_opcion"] = $data->valor_opcion;
        $opcion[$data->numero_pregunta][$data->numero_opcion]["correcta_opcion"] = $data->correcta_opcion;
        $opcion[$data->numero_pregunta][$data->numero_opcion]["imagen_opcion"] = $data->imagen_opcion;
    }
	//echo $sql_opciones; return;
	
                    $sql_respuestas_evaluados = "SELECT * FROM tb_respuestas_evaluados WHERE cod_evaluacion = '$cod_evaluacion' ORDER BY numero_pregunta";
					//echo "sql=".$sql_respuestas_evaluados; return;
                    $data = DB::select($sql_respuestas_evaluados);
					$cat1="";
					$cat2="";
					$cat3="";
					$cat4="";
					$cat5="";
					
					$cat_1_total=0;
					$cat_2_total=0;
					$cat_3_total=0;
					$cat_4_total=0;
					$cat_5_total=0;
					
                    foreach ($data as $data) {
                       $respuesta[$data->numero_pregunta][$data->numero_categoria_pregunta][$data->numero_subcategoria_pregunta][$data->valor_opcion] = $data->valor_opcion;
                       $respuesta[$data->numero_pregunta][$data->nombre_categoria_pregunta] = $data->nombre_categoria_pregunta;
                       $respuesta[$data->numero_pregunta][$data->nombre_subcategoria_pregunta] = $data->nombre_subcategoria_pregunta;
                        switch($data->numero_categoria_pregunta){
                            case 1 :
								if (isset($cat1[$data->numero_subcategoria_pregunta]))
									$valor=$cat1[$data->numero_subcategoria_pregunta];
								else
									$valor=0;
                                $cat1[$data->numero_subcategoria_pregunta] = $valor + $data->valor_opcion;
                                $cat_1_total = $cat_1_total + $data->valor_opcion;
                            break;
                            case 2 :
								if (isset($cat2[$data->numero_subcategoria_pregunta]))
									$valor=$cat2[$data->numero_subcategoria_pregunta];
								else
									$valor=0;							
                                $cat2[$data->numero_subcategoria_pregunta] = $valor + $data->valor_opcion;
                                $cat_2_total = $cat_2_total + $data->valor_opcion;
                            break;
                            case 3 :
								if (isset($cat3[$data->numero_subcategoria_pregunta]))
									$valor=$cat3[$data->numero_subcategoria_pregunta];
								else
									$valor=0;								
                                $cat3[$data->numero_subcategoria_pregunta] = $valor + $data->valor_opcion;
                                $cat_3_total = $cat_3_total + $data->valor_opcion;
                            break;
                            case 4 :
								if (isset($cat4[$data->numero_subcategoria_pregunta]))
									$valor=$cat4[$data->numero_subcategoria_pregunta];
								else
									$valor=0;								
                                $cat4[$data->numero_subcategoria_pregunta] = $valor + $data->valor_opcion;
                                $cat_4_total = $cat_4_total + $data->valor_opcion;
                            break;
                            case 5 :
								if (isset($cat5[$data->numero_subcategoria_pregunta]))
									$valor=$cat5[$data->numero_subcategoria_pregunta];
								else
									$valor=0;								
                                $cat5[$data->numero_subcategoria_pregunta] = $valor + $data->valor_opcion;
                                $cat_5_total = $cat_5_total + $data->valor_opcion;
                            break;
                        }
                    }
					//echo $cat_1_total; return;
                    $cat_1_total = Baremo('C1',$cat_1_total);
                    $cat_2_total = Baremo('C2',$cat_2_total);
                    $cat_3_total = Baremo('C3',$cat_3_total);
                    $cat_4_total = Baremo('C4',$cat_4_total);
                    $cat_5_total = Baremo('C5',$cat_5_total);	
					
					
	
 ?>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        
        <style type="text/css">     
            #reporte_cat0,#reporte_cat1,#reporte_cat2,#reporte_cat3,#reporte_cat4,#reporte_cat5{
                height: 400px; 
                min-width: 310px; 
                max-width: 1280px;
                margin: 50px;
                display: 'block';
             } 
        @media all {
           div.saltopagina{
              display: none;
           }
        }
         
        @media print{
           div.saltopagina{
              display:block;
              page-break-before:always;
           }
         
           /*No imprimir*/
           .oculto {display:none}
        } 

		</style>
		
		
        <script type="text/javascript"> 

            $(function () {
					var cat1_1=0;
					var cat1_2=0;
					var cat1_3=0;
					var cat1_4=0;
					var cat1_5=0;
					
					var cat2_1=0;
					var cat2_2=0;
					var cat2_3=0;
					var cat2_4=0;
					var cat2_5=0;

					var cat3_1=0;
					var cat3_2=0;
					var cat3_3=0;
					var cat3_4=0;
					var cat3_5=0;

					var cat4_1=0;
					var cat4_2=0;
					var cat4_3=0;
					var cat4_4=0;
					var cat4_5=0;

					var cat5_1=0;
					var cat5_2=0;
					var cat5_3=0;
					var cat5_4=0;
					var cat5_5=0;
				
                    <?php
					if (isset($cat1[1])) {
						$json = json_encode(Baremo('CG',$cat1[1]));
						echo "cat1_1 = ".$json.";";
					}
					if (isset($cat1[2])) {
						$json = json_encode(Baremo('CG',$cat1[2]));
						echo "cat1_2 = ".$json.";";
					}
					if (isset($cat1[3])) {
						$json = json_encode(Baremo('CG',$cat1[3]));
						echo "cat1_3 = ".$json.";";
					}	
					if (isset($cat1[4])) {
						$json = json_encode(Baremo('CG',$cat1[4]));
						echo "cat1_4 = ".$json.";";
					}	
					if (isset($cat1[5])) {
						$json = json_encode(Baremo('CG',$cat1[5]));
						echo "cat1_5 = ".$json.";";
					}
					
					if (isset($cat2[1])) {
						$json = json_encode(Baremo('C1',$cat2[1]));
						echo "cat2_1 = ".$json.";";
					}
                    if (isset($cat2[2])) {
						$json = json_encode(Baremo('C1',$cat2[2]));
						echo "cat2_2 = ".$json.";";
					}
                    if (isset($cat2[3])) {                    
						$json = json_encode(Baremo('C1',$cat2[3]));
						echo "cat2_3 = ".$json.";";
					}
                    if (isset($cat2[4])) {                    
						$json = json_encode(Baremo('C1',$cat2[4]));
						echo "cat2_4 = ".$json.";";
					}
                    if (isset($cat2[5])) {                 
						$json = json_encode(Baremo('C1',$cat2[5]));
						echo "cat2_5 = ".$json.";";
					}
					
					if (isset($cat3[1])) {
						$json = json_encode(Baremo('C2',$cat3[1]));
						echo "cat3_1 = ".$json.";";
					}
					if (isset($cat3[2])) {
						$json = json_encode(Baremo('C2',$cat3[2]));						
						echo "cat3_2 = ".$json.";";
					}
					if (isset($cat3[3])) {						
						$json = json_encode(Baremo('C2',$cat3[3]));						
						echo "cat3_3 = ".$json.";";
					}
					if (isset($cat3[4])) {						
						$json = json_encode(Baremo('C2',$cat3[4]));						
						echo "cat3_4 = ".$json.";";
					}
					if (isset($cat3[5])) {						
						$json = json_encode(Baremo('C2',$cat3[5]));						
						echo "cat3_5 = ".$json.";";
					}
					
					if (isset($cat4[1])) {					
						$json = json_encode(Baremo('C3',$cat4[1]));
						echo "cat4_1 = ".$json.";";
					}
					if (isset($cat4[2])) {
						$json = json_encode(Baremo('C3',$cat4[2]));
						echo "cat4_2 = ".$json.";";
					}
					if (isset($cat4[3])) {						
						$json = json_encode(Baremo('C3',$cat4[3]));
						echo "cat4_3 = ".$json.";";
					}
					if (isset($cat4[4])) {						
						$json = json_encode(Baremo('C3',$cat4[4]));
						echo "cat4_4 = ".$json.";";
					}
					if (isset($cat4[5])) {						
						$json = json_encode(Baremo('C3',$cat4[5]));
						echo "cat4_5 = ".$json.";";
					}

					if (isset($cat5[1])) {
						$json = json_encode(Baremo('C4',$cat5[1]));
						echo "cat5_1 = ".$json.";";
					}
					if (isset($cat5[2])) {			
						$json = json_encode(Baremo('C4',$cat5[2]));
						echo "cat5_2 = ".$json.";";
					}
					if (isset($cat5[3])) {						
						$json = json_encode(Baremo('C4',$cat5[31]));
						echo "cat5_3 = ".$json.";";
					}
					if (isset($cat5[4])) {						
						$json = json_encode(Baremo('C4',$cat5[4]));
						echo "cat5_4 = ".$json.";";
					}
					if (isset($cat5[5])) {						
						$json = json_encode(Baremo('C4',$cat5[5]));
						echo "cat5_5 = ".$json.";";
					}

					$json = json_encode($cat_1_total);
					echo "cat_1_total = ".$json.";";
					
					$json = json_encode($cat_2_total);
					echo "cat_2_total = ".$json.";";
					
					$json = json_encode($cat_3_total);
					echo "cat_3_total = ".$json.";";
					
					$json = json_encode($cat_4_total);
					echo "cat_4_total = ".$json.";";
					
					$json = json_encode($cat_5_total);
					echo "cat_5_total = ".$json.";"; 
                ?>
            ///--------------------------REPORTE CATEGORIA 0--------------------------------------    
                Highcharts.chart('reporte_cat0', {
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 10,
                            beta: 25,
                            depth: 70
                        }
                    },
                    title: {
                        text: 'Informe TCGO'
                    },
                    subtitle: {
                        text: 'Consolidado'
                    },
                    credits: {
                        enabled: true,
                        href: 'http://wwww.talentskey.com',
                        text: "Reporte TCGO - TalentsKey.com"
                    },
                    legend: {
                        align: 'right',
                        verticalAlign: 'middle',
                        layout: 'vertical'
                    },
                    plotOptions: {
                        column: {
                            depth: 35
                        }
                    },
                    xAxis: {
                        categories: ['DE LA REALIDAD','DE LA POSIBILIDAD','DE LA ACCION Y RESULTADOS','DE LAS RELACIONES','DEL APRENDIZAJE'],
                        labels:{
                           rotation: -20,
                           y: 20 
                        }
                    },
                    yAxis: {
                        title: {
                            text: null
                        },    
                        max: 100   
                    },
                    series: [
                        {
                            name: 'GESTIÓN',
                            data: [cat_1_total,cat_2_total,cat_3_total,cat_4_total,cat_5_total]
                        }
                    ]
                });
            ///--------------------------REPORTE CATEGORIA 1--------------------------------------
                Highcharts.chart('reporte_cat1', {
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 10,
                            beta: 25,
                            depth: 70
                        }
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: 'GESTIÓN DE LA REALIDAD'
                    },
                    credits: {
                        enabled: true,
                        href: 'http://wwww.talentskey.com',
                        text: "Reporte TCGO - TalentsKey.com"
                    },
                    legend: {
                        align: 'right',
                        verticalAlign: 'middle',
                        layout: 'vertical'
                    },
                    plotOptions: {
                        column: {
                            depth: 35
                        }
                    },
                    xAxis: {
                        categories: ['GESTIÓN DE LA REALIDAD'],
                        labels:{
                           rotation: 6,
                           y: 30 
                        }
                    },
                    yAxis: {
                        title: {
                            text: null
                        },    
                        max: 100   
                    },
                    series: [
                        {
                            name: 'MANEJO DE LA INFORMACIÓN',
                            data: [cat1_1]
                        },
                        {
                            name: 'GENERACIÓN DEL CONOCIMIENTO',
                            data: [cat1_2]
                        },
                        {
                            name: 'DISTINCIÓN DE LA REALIDAD',
                            data: [cat1_3]
                        },
                        {
                            name: 'JERARQUIZACIÓN DE LA REALIDAD',
                            data: [cat1_4]
                        },
                        {
                            name: 'COHERENCIA EMOCIONAL Y CORPORALIDAD<br/>EN LA GESTIÓN DE LA REALIDAD',
                            data: [cat1_5]
                        }
                    ]
                });

            ///--------------------------REPORTE CATEGORIA 2--------------------------------------
                Highcharts.chart('reporte_cat2', {
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 10,
                            beta: 25,
                            depth: 70
                        }
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: 'GESTIÓN DE LA POSIBILIDAD'
                    },
                    credits: {
                        enabled: true,
                        href: 'http://wwww.talentskey.com',
                        text: "Reporte TCGO - TalentsKey.com"
                    },
                    legend: {
                        align: 'right',
                        verticalAlign: 'middle',
                        layout: 'vertical'
                    },
                    plotOptions: {
                        column: {
                            depth: 35
                        }
                    },
                    xAxis: {
                        categories: ['GESTIÓN DE LA POSIBILIDAD'],
                        labels:{
                           rotation: 6,
                           y: 30 
                        }
                    },
                    yAxis: {
                        title: {
                            text: null
                        },    
                        max: 100   
                    },
                    series: [
                        {
                            name: 'APERTURA A LAS POSIBILIDADES',
                            data: [cat2_1]
                        },
                        {
                            name: 'RELACIÓN ENTRE POSIBILIDAD Y COMPROMISO',
                            data: [cat2_2]
                        },
                        {
                            name: 'RELACIÓN CON EL FUTURO',
                            data: [cat2_3]
                        },
                        {
                            name: 'TOMA DE DECISIÓN',
                            data: [cat2_4]
                        },
                        {
                            name: 'COHERENCIA EMOCIONAL Y CORPORAL/P',
                            data: [cat2_5]
                        }
                    ]
                });

            ///--------------------------REPORTE CATEGORIA 3--------------------------------------


                Highcharts.chart('reporte_cat3', {
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 10,
                            beta: 25,
                            depth: 70
                        }
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: 'GESTIÓN DE LA ACCION Y RESULTADOS'
                    },
                    credits: {
                        enabled: true,
                        href: 'http://wwww.talentskey.com',
                        text: "Reporte TCGO - TalentsKey.com"
                    },
                    legend: {
                        align: 'right',
                        verticalAlign: 'middle',
                        layout: 'vertical'
                    },
                    plotOptions: {
                        column: {
                            depth: 35
                        }
                    },
                    xAxis: {
                        categories: ['GESTIÓN DE LA ACCION Y RESULTADOS'],
                        labels:{
                           rotation: 6,
                           y: 30 
                        }
                    },
                    yAxis: {
                        title: {
                            text: null
                        },    
                        max: 100   
                    },
                    series: [
                        {
                            name: 'RELACIÓN ENTRE ACCIÓN Y RESULTADO',
                            data: [cat3_1]
                        },
                        {
                            name: 'IMPACTO DE LA PETICIÓN SOBRE LA EJECUCIÓN',
                            data: [cat3_2]
                        },
                        {
                            name: 'IMPACTO DE LA OFERTA SOBRE LA EJECUCIÓN',
                            data: [cat3_3]
                        },
                        {
                            name: 'RESPONSABILIDAD EN LA EJECUCIÓN',
                            data: [cat3_4]
                        },
                        {
                            name: 'COHERENCIA EMOCIONAL Y CORPORAL/C',
                            data: [cat3_5]
                        }
                    ]
                });

            ///--------------------------REPORTE CATEGORIA 4--------------------------------------
                Highcharts.chart('reporte_cat4', {
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 10,
                            beta: 25,
                            depth: 70
                        }
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: 'GESTIÓN DE LAS RELACIONES'
                    },
                    credits: {
                        enabled: true,
                        href: 'http://wwww.talentskey.com',
                        text: "Reporte TCGO - TalentsKey.com"
                    },
                    legend: {
                        align: 'right',
                        verticalAlign: 'middle',
                        layout: 'vertical'
                    },
                    plotOptions: {
                        column: {
                            depth: 35
                        }
                    },
                    xAxis: {
                        categories: ['GESTIÓN DE LAS RELACIONES'],
                        labels:{
                           rotation: 6,
                           y: 30 
                        }
                    },
                    yAxis: {
                        title: {
                            text: null
                        },    
                        max: 100   
                    },
                    series: [
                        {
                            name: 'APERTURA EN LA GESTIÓN DE LAS RELACIONES',
                            data: [cat4_1]
                        },
                        {
                            name: 'CONFIANZA Y RELACIÓN',
                            data: [cat4_2]
                        },
                        {
                            name: 'GESTIÓN DE LAS RELACIONES',
                            data: [cat4_3]
                        },
                        {
                            name: 'RELACIÓN Y RESULTADO',
                            data: [cat4_4]
                        },
                        {
                            name: 'COHERENCIA EMOCIONAL Y CORPORAL/R',
                            data: [cat4_5]
                        }
                    ]
                });

            ///--------------------------REPORTE CATEGORIA 5--------------------------------------
                Highcharts.chart('reporte_cat5', {
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 10,
                            beta: 25,
                            depth: 70
                        }
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: 'GESTIÓN DEL APRENDIZAJE'
                    },
                    credits: {
                        enabled: true,
                        href: 'http://wwww.talentskey.com',
                        text: "Reporte TCGO - TalentsKey.com"
                    },
                    legend: {
                        align: 'right',
                        verticalAlign: 'middle',
                        layout: 'vertical'
                    },
                    plotOptions: {
                        column: {
                            depth: 35
                        }
                    },
                    xAxis: {
                        categories: ['GESTIÓN DEL APRENDIZAJE'],
                        labels:{
                           rotation: 6,
                           y: 30 
                        }
                    },
                    yAxis: {
                        title: {
                            text: null
                        },    
                        max: 100   
                    },
                    series: [
                        {
                            name: 'RELACIÓN ENTRE APRENDIZAJE Y ACCIÓN',
                            data: [cat5_1]
                        },
                        {
                            name: 'APERTURA AL APRENDIZAJE',
                            data: [cat5_2]
                        },
                        {
                            name: 'CORRESPONSABILIDAD EN LOS PROCESOS DE APRENDIZAJE',
                            data: [cat5_3]
                        },
                        {
                            name: 'RECONOCIMIENTO DEL OTRO COMO AUTORIDAD<br/>EN LOS PROCESOS DE APRENDIZAJE',
                            data: [cat5_5]
                        },
                        {
                            name: 'COHERENCIA EMOCIONAL Y CORPORALIDAD/A',
                            data: [cat5_4]
                        }
                    ]
                });

            });
		</script>   

        <script src="../src/code/highcharts.js"></script>
        <script src="../src/code/highcharts-3d.js"></script>
        <!-- <script src="src/code/modules/exporting.js"></script> -->
        
            <center>
            <div align="center" style="width: 100%">
                <div align="justify" style="width: 95%">
                    <h5>Evaluado: <b><?php echo $nombres_evaluado . " " . $apellidos_evaluado; ?></b></h5>
                    <h5>Tutor: <b><?php echo $nombres_tutor . " " . $apellidos_tutor; ?></b></h5>
                    <h5>Cliente: <b><?php echo $nombre_com_cliente; ?></b></h5>
                    <h5>Fecha: <b><?php echo $fecha_evaluacion; ?></b></h5>
                </div>
                <div id="reporte_cat0" style="height: 500px"></div>
                <div align="justify" style="width: 90%">
                <table class="table table-striped" id="datatable-consolidado">
                    <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Porcentaje</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>GESTIÓN DE LA REALIDAD</th>
                            <td><?php echo $cat_1_total; ?></td>
                        </tr>
                        <tr>
                            <th>GESTIÓN DE LA POSIBILIDAD</th>
                            <td><?php echo $cat_2_total; ?></td>
                        </tr>
                            <tr>
                            <th>GESTIÓN DE LA ACCION Y RESULTADOS</th>
                            <td><?php echo $cat_3_total; ?></td>
                        </tr>
                         <tr>
                            <th>GESTIÓN DE LAS RELACIONES</th>
                            <td><?php echo $cat_4_total; ?></td>
                        </tr>
                        <tr>
                            <th>GESTIÓN DEL APRENDIZAJE</th>
                            <td><?php echo $cat_5_total; ?></td>
                        </tr>
                    </tbody>
                </table>
                </div>
                 
				

                <div id="reporte_cat0" style="height: 100px"></div>
                <div align="justify" style="width: 90%">
                    <p> 
                    Descripción:
                    </p>
                    <p>
                    <strong>GESTIÓN DE LA REALIDAD:</strong> El dominio de esta competencia se refiere al nivel de conocimiento que se tiene del terreno en que se pisa. En el modelo TCGO la realidad es un constructo obtenido de la síntesis de los recortes de información a nuestro alcance. En este sentido, construimos la realidad con las apreciaciones que generamos acerca del mundo que nos rodea. Esto nos transforma a todos en observadores distintos, dado que cada vez que recortamos información, elegimos entre lo que consideramos relevante y lo que no. Esto implica la habilidad de distinguir hechos de juicios personales, acerca de lo que interpretamos de lo que sucede a nuestro alrededor. Requiere la capacidad de manejar información precisa, investigar, escoger, analizar, validar, relacionar, proveer pruebas irrefutables, aportar testigos y entregar información sobre hechos a los demás para una adecuada retroalimentación.
                    </p>
                    <p>
                    <strong>POSIBILIDAD:</strong> Una buena puntuación en este dominio habla de una prometedora capacidad para la vislumbrar el futuro y el abanico de posibilidades que el mismo presenta. Requiere de la habilidad de fomentar el compromiso de llevar a cabo estas transformaciones, comportándose consistentemente con aquello que se quiere y se declara como posible. Implica la capacidad de escuchar, soñar, especular con muchas posibilidades, decidir una acción, enrolar a los demás, impulsar y desafiar aquello que hasta que el momento ha sido considerado posible en un dominio determinado.
                    </p>
                    <p>
                    <strong>ACCIÓN Y RESULTADOS:</strong> Este set de competencias indaga el momentum de la transformación de la “realidad” actual por aquella que se desea lograr, por medio de la acción concreta, constante y disciplinada; realizada por si mismo y a través de otros. Es la capacidad de generar algo nuevo, a través de la coordinación de acciones efectivas con otros, desde un espacio emocional que facilite la interacción. Indica el potencial presente para poder implementar estrategias y planes llevándolos a cabo a través de acciones programadasen tiempo y forma. Implica la habilidad de diseñar y coordinarse con otros de manera efectiva, implementar, ejecutar monitorear, evaluar y rediseñar para alcanzar las metas establecidas.
                    </p>
                    <strong>RELACIONES:</strong> Este dominio es un determinante de nuestra identidad en el mundo, es la capacidad de crear una red de relaciones valiosas. Implica la habilidad de diseñar y dar las conversaciones que se requieran para crear y gestionar la calidad de las relaciones con otros en momentos críticos y situaciones adversas ; siendo capaz para ello de distinguir, evaluar y valorar el nivel de salubridad de las mismas, profundizarlas, redefinirlas para construir, enriquecerlas y consolidarlas.
                    </p>                    
                    <p>
                    <strong>APRENDIZAJE:</strong> El dominio de esta competencia refiere a la capacidad de hacer juicios y declarar que no sabemos, para poder comprometernos a aprender aquello que es relevante para nuestros fines e inquietudes en un dominio determinado. Implica la disposición para ponerse en relación con un maestro, recibir juicios, incorporar nuevos conocimientos, y ponerlos en práctica hasta ser efectivos al momento de actuar con autonomía, alcanzar la excelencia y desarrollar la maestría en una determinada área.
                    </p>
                    <p>

                </div>

                   
<div class="saltopagina"></div>
                <div id="reporte_cat1" style="height: 400px"></div>
                <div align="justify" style="width: 90%">
                    <p> 
                    Descripción:
                    </p>
                    <p>
                    <strong>MANEJ DE LA INFORMACIÓN:</strong> Esta competencia fundamental, esta referida a la gestión de la investigación y búsqueda de fuentes de información relevantes, así como a la capacidad de articular esta información de modo coherente y consistente.
                    </p>
                    <p>
                    <strong>GENERACIÓN DEL CONOCIMIENTO:</strong> Esta competencia refiere a la evaluación de los mecanismos que permiten instrumentar y aplicar la información obtenida sobre una situación particular, y conllevan a un abordaje preciso y eficaz de la misma.
                    </p>
                    <p>
                    <strong>DISTINCIÓN DE LA REALIDAD:</strong> En el modelo TCGO la distinción de la “realidad” está determinada por la capacidad de diferenciar un determinado fenómeno. Una buena puntuación en esta competencia, habla de un óptimo conocimiento de los límites que dicha “realidad “presenta. Así como de sus propios recursos para aprehenderla y gestionarla de manera efectiva y adecuada.
                    </p>
                    <strong>JERARQUIZACIÓN DE LA REALIDAD:</strong> Solo nos es posible distinguir la “realidad” por medio de procesos de jerarquización. En el modelo TCGO la jerarquización es un proceso activo ligado a la valoración, selección y fundamentación de lo que se percibe, dice y se hace.
                    </p>                    
                    <p>
                    <strong>COHERENCIA EMOCIONAL Y CORPORALIDAD EN LA GESTIÓN DE LA REALIDAD:</strong> La puntuación alcanzada en esta competencia refleja el nivel de ajuste corporal y emocional requeridos para desarrollar la habilidad de gestionar de modo óptimo y eficaz este dominio.
                    </p>
                    <p>

                </div>
                <hr>
<div class="saltopagina"></div>
                <div id="reporte_cat2" style="height: 400px"></div>
                <div align="justify" style="width: 90%">
                    <p>
                    Descripción:
                    </p>
                    <p>
                    <strong>APERTURA A LAS POSIBILIDADES:</strong> En esta competencia se evalúa específicamente la capacidad de ampliar la mirada, fuera de los espacios habituales de interpretación, para vislumbrar espacios de oportunidad para cambios favorables.
                    </p>
                    <p>
                    <strong>RELACIÓN ENTRE POSIBILIDAD Y COMPROMISO:</strong> La puntuación obtenida en esta competencia está asociada a la capacidad de asumir un fuerte compromiso con aquello que se declara como posible, siendo capaz de sortear los obstáculos que se presenten en el camino hacia la meta.
                    </p>
                    <p>
                    <strong>RELACIÓN CON EL FUTURO:</strong> Indica la capacidad de proyectarse desde hoy hacia el futuro como espacio de diseño; mas allá del contexto actual y teniendo en cuenta lo incierto e imprevisible del mismo.
                    </p>
                    <p>
                    <strong>TOMA DE DECISIÓN:</strong> Esta competencia señala el grado de precisión y compromiso en la toma de decisiones necesarias, para transformar la posibilidad en una “realidad” exitosa en función de las metas establecidas.
                    </p>
                    <p>
                    <strong>COHERENCIA EMOCIONAL Y CORPORAL/P:</strong> El dominio de esta competencia requiere un determinado ajuste de la flexibilidad y la apertura necesarias para ejecutar el acto creativo del diseño de futuro.
                    </p>
                </div> 
                <hr>
<div class="saltopagina"></div>                
                <div id="reporte_cat3" style="height: 400px"></div>
                <div align="justify" style="width: 90%">
                    <p>
                    Descripción:
                    </p>
                    <p>
                    <strong>RELACIÓN ENTRE ACCIÓN Y RESULTADO:</strong> Se exploran en esta competencia los mecanismos que permiten sostener un alto grado de correlación entre la acción diseñada en las estrategias y la operacionalización en forma individual y colectiva en función de los objetivos fijados.
                    </p>
                    <p>
                    <strong>IMPACTO DE LA PETICIÓN SOBRE LA EJECUCIÓN:</strong> Se evalúa la habilidad de formular pedidos claros, oportunos, precisos y hacer que se cumplan, para lograr que dichas peticiones sean efectuadas según las condiciones de satisfacción esperadas.
                    </p>
                    <p>
                    <strong>IMPACTO DE LA OFERTA SOBRE LA EJECUCIÓN:</strong> El puntaje obtenido en esta competencia informa sobre la habilidad de formular ofertas pertinentes, efectivas y persuasivas, con el compromiso y la solvencia necesarias para lograr satisfacer expectativas a través del desenvolvimiento de esa acción propuesta.
                    </p>
                    <p>
                    <strong>RESPONSABILIDAD EN LA EJECUCIÓN:</strong> Evalúa el nivel de responsabilidad y consistencia para responder frente a los compromisos adquiridos, mas allá de los obstáculos y dificultades, con la tenacidad que ello requiere.
                    </p>
                    <p><hr>
                    <strong>COHERENCIA EMOCIONAL Y CORPORAL/C:</strong> Para el óptimo desarrollo de esta competencia es fundamental poseer la energía y la determinación necesarias, para cumplir con perseverancia y decisión los acuerdos asumidos.
                    </p>
                </div>
                <hr>
<div class="saltopagina"></div>
                <div id="reporte_cat4" style="height: 400px"></div>
                <div align="justify" style="width: 90%">
                    <p>
                    Descripción:
                    </p>
                    <p>
                    <strong>APERTURA EN LA GESTIÓN DE LAS RELACIONES:</strong> Esta competencia refiere a la disposición y habilidad de establecer y sostener relaciones productivas. Y también la capacidad generar alianzas que amplíen la red relacional con actores claves en la ejecución de un fin común.
                    </p>
                    <p>
                    <strong>CONFIANZA Y RELACIÓN:</strong> Este dominio hace referencia a la capacidad de generar confianza en el entorno como marco que posibilite el establecimiento de vínculos estrechos y duraderos. Utilizando como herramientas la sinceridad, y el compromiso pertinente, impactando éstos en la configuración de la identidad privada y pública.
                    </p>
                    <p>
                    <strong>GESTIÓN DE LAS RELACIONES:</strong> Muestra la capacidad de generar relaciones saludables y responder en los momentos críticos y de conflicto, dando las conversaciones necesarias en post de encontrar soluciones posibles al restablecimiento del estado de salubridad y equilibrio de la relación, para posibilitar la coordinación de acciones con un fin común.
                    </p>
                    <p>
                    <strong>RELACIÓN Y RESULTADO:</strong> Esta habilidad, esta relacionada con la capacidad de lograr un óptimo equilibrio entre la relación y los objetivos acordados recíprocamente. Generando un saldo positivo en términos de relación, como producto del proceso de coordinación de acciones y la interacción que conllevan el logro de resultados.
                    </p>
                    <p>
                    <strong>COHERENCIA EMOCIONAL Y CORPORAL/R:</strong> Se explora el lenguaje corporal y el ajuste emocional en la interacción social con los demás. Esto implica la capacidad de aceptar y respetar al otro, reconociendo sus sentimientos y emociones, procurando comprenderlas y apreciarlas, para lograr un óptimo desenvolvimiento de la relación.
                    </p>
                </div>
                <hr>
<div class="saltopagina"></div>               
                <div id="reporte_cat5" style="height: 400px"></div>
                <div align="justify" style="width: 90%">
                    <p>
                    Descripción:
                    </p>
                    <p>
                    <strong>RELACIÓN ENTRE APRENDIZAJE Y ACCIÓN:</strong> Se explora el nivel de destreza alcanzado en la integración del aprendizaje, lo cual genera un proceso que se retroalimenta y que permite ampliar la capacidad efectiva del nivel de ejecución.
                    </p>
                    <p>
                    <strong>APERTURA AL APRENDIZAJE:</strong> Refleja el grado de disposición para incorporar nuevos conocimientos, y recibir juicios acerca del nivel de desempeño actual y potencial que conlleva a un proceso de aprendizaje.
                    </p>
                    <p>
                    <strong>CORRESPONSABILIDAD EN LOS PROCESOS DE APRENDIZAJE:</strong> Muestra el nivel de habilidad para llevar adelante procesos de asunción y atribución de la responsabilidad personal, en la incorporación formal e informal de nuevos conocimientos y habilidades.
                    </p>
                    <p>
                    <strong>COHERENCIA EMOCIONAL Y CORPORALIDAD/A:</strong> Indica la capacidad de apertura, paciencia y curiosidad, así mismo el grado de humildad y el coraje de reconocer que algo no se sabe.
                    </p>
                    <p>
                    <strong>RECONOCIMIENTO DEL OTRO COMO AUTORIDAD EN LOS PROCESOS DE APRENDIZAJE:</strong> Se evalúa el grado de humildad y apertura requeridos para reconocer y conferir autoridad a los maestros, y nutrirse de su saber específico en el dominio que se requiere desarrollar.
                    </p>
                </div>
                <hr>            
            </div></center>
@include('layout.pruebas.footer')