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

<script>
	var indice_botones=new Array();
	var indice_botones_mas=new Array();
	var indice_botones_menos=new Array();
	var indice=0;
	
	var arreglo_layers=new Array();
	var arreglo_seleccion=new Array();
</script>

<form name="forma_cc" class="form-horizontal" onsubmit= "return nada()">
	<input type="hidden" name="id_au" id="id_au" value="<?=$id_au?>" />
	<input type="hidden" name="bateria" id="bateria" value="<?=$id_bateria?>" />
	<input type="hidden" name="orden" id="orden" value="<?=$orden?>" />
<div id="contenedor" style="height:1000px;border:0px solid green; position:relative;">
<!-- HEADER -->
<div id="header"><div id="header_fondo">
<div id="header_tit" align="left">
<span class="header_tit1">I</span><span class="header_tit2">nventario de </span> <span class="header_tit1">E</span><span class="header_tit2">stilo</span> <span class="header_tit1">P</span><span class="header_tit2">ersonal</span></div>

<div id="logo_inter">
<img src="../css/images/logo.png" width="122" height="60" alt="TalentsKey" />
</div>
</div></div>
<!-- CIERRE HEADER -->

<script>nro_prueba=7; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1; var cantidad=0;</script>

<?php 
	$tabindex=1;
	$i=0; 
	
	$sql = "select tp.id, tp.url, tp.vista_tiempo from tipos_pruebas tp, bateria_tipo_prueba btp
			where btp.id_tipo_prueba=tp.id and btp.id_bateria=".$id_bateria." and orden=7";
	//echo $sql; return;
	$data=DB::select($sql);
	foreach ($data as $data) {
		$proxima_pagina=$data->url;
		$id_tp=$data->id;		
		$tiempo=FuncionesControllers::buscarTiempo($data->id);
		$vista_prueba=substr($tiempo,strpos($tiempo,"/")+1);
		$tiempo=substr($tiempo,0,strpos($tiempo,"/"));		
	}
	
	//echo "tiempo=$tiempo..vista_prueba=$vista_prueba";
	
	$sql ="select * from autorizaciones where id=$id_au";
	$data=DB::select($sql);
	foreach ($data as $data) {
		$id_empresa=$data->id_empresas;
	}
	
	$id_bateria=$id_bateria;
?>

<script>
	proxima_pagina='<?php echo $proxima_pagina; ?>';
	var id_au_ejemplo=<?=$id_au?>;
</script>

<!-- INSTRUCCIONES -->
<div id="instrucciones" align="center" style="display:inline;">
	<?php
		$sql = "select i.texto, tp.nombre, i.posicion
				from instrucciones i, tipos_pruebas tp 
				where tp.id=$id_tp and i.id_prueba=tp.id and i.id_empresa=$id_empresa";
		//echo $sql; return;
		$data_i = DB::select($sql);		
		
		$instrucciones_antes="";
		$instrucciones_despues="";
		$titulo="";
		if (empty($data_i)) {
			$instrucciones_antes="";
			$instrucciones_despues="";
		} else
			foreach ($data_i as $data_i) {
				if ($data_i->posicion==0)
					$instrucciones_antes=$data_i->texto;
				else
					$instrucciones_despues=$data_i->texto;
				$titulo=$data_i->nombre;
			}
	?>

	@include('encuestas_baterias.instrucciones',["boton"=> "1", "id_au"=>$id_au, "nro_inst"=>9, "titulo"=>$titulo,"instrucciones_antes"=>$instrucciones_antes,"instrucciones_despues"=>$instrucciones_despues, "tiempo"=>$tiempo, "funcion"=>"guardar_encuesta_iep"])
	
</div>	
<!-- INSTRUCCIONES -->

<!-- CONTENIDO -->
<div id="encuesta" style="display:none;">

	<div id="cont2">

	<?php if ($vista_prueba==1) { ?>
		<div align="left" class="ver_tiempo" style="font-size: 12pt; font-weight: bold;">
			Tiempo restante para la prueba <span id="time">{{ $tiempo }}:00</span> minutos
		</div>
	<?php } ?>	
	
	<?php
		$sql = "select * from preguntas_epa where id_pruebas=5 order by orden";
		$data=DB::select($sql);
		
		$i=1;
		$cantidad=1;
		$j=0;
		foreach ($data as $data) {
			$pregunta=$data->nombre;
			$id_preguntas=$data->id_preguntas;
			$respuesta=$data->respuesta;
			$imagen=$data->imagen;		
			
			if ($cantidad==1) {
				$display="inline";
				$autofocus="autofocus";
			} else {
				$display="none";
				$autofocus="";
			}			
	?>

	<div id="prueba{{ $tabindex }}" style="display: {{ $display }};">
		<div id="prueba3_sl_cont1">
			<div id="prueba3_sl_cont">
				<div id="prueba3_sl_preg"><br />{{ $pregunta }}<br /></div>
				<br><br><br>
				<div id="prueba1_pc_contIEP">	
					
					<?php
					$sql = "select * from opciones_epa where id_pregunta=".$data->id_preguntas;
					$data_opciones=DB::select($sql);
					echo "<script>arreglo_layers[".$id_preguntas."]=new Array(4);</script>";
					foreach ($data_opciones as $data_opciones) {
						$opcion=$data_opciones->opcion;
						$select_mas="#c8c8c8";
						$select_menos="#c8c8c8";
						/*if ($data_opciones->respuesta==1)
							$select_mas="blue";
						if ($data_opciones->respuesta==-1)
							$select_menos="blue";*/
					?>
						<div id="prueba1_pc_resp">
							<div id="prueba1_pc_txt" class="clase_iep">{{ $data_opciones->opcion }}	
								<label id="label_menos_{{ $data_opciones->id_opciones }}" for="label_menos_{{ $data_opciones->id_opciones }}" style="float: right; position: relative; top:0px; border: 0px solid green; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: {{ $select_menos }}">
									&nbsp;&nbsp;&nbsp;
									<input src="../imagenes/negativo.gif" name='menos_{{ $data->id_preguntas }}' id='menos_{{ $data_opciones->id_opciones }}' value='{{ $data_opciones->id_opciones }}' onmousedown='colocar_respuesta("iep_menos", "","",{{ $data->id_preguntas }}, "{{ $data_opciones->id_opciones }}","{{ $opcion }}","")' class='radio_iol' type="image" width="30" height="30">
									&nbsp;&nbsp;&nbsp;
								</label>						
								<label id="label_mas_{{ $data_opciones->id_opciones }}" for="label_mas_{{ $data_opciones->id_opciones }}" style="float: right; position: relative; top:0px; margin: 0; border-radius: 15px 50px 30px; cursor: pointer; background: {{ $select_mas }}">
									&nbsp;&nbsp;&nbsp;
									<input src="../imagenes/positivo.gif" class='radio_iol' name='mas_{{ $data->id_preguntas }}' id='mas_{{ $data_opciones->id_opciones }}' value='{{ $data_opciones->id_opciones }}' onmousedown='colocar_respuesta("iep_mas", "","",{{ $data->id_preguntas }}, "{{ $data_opciones->id_opciones }}","{{ $opcion }}","")' type="image" width="30" height="30">
									&nbsp;&nbsp;&nbsp;
								</label>
							</div>
						</div>
						<br><br>
					<?php 
						$j++;
						echo "<script>arreglo_layers[".$id_preguntas."][".$j."]=".$data_opciones->id_opciones."</script>";
						} ?>
				</div>

			</div>
		</div>
	</div>
	<?php 
		echo "
			<script>
				respuesta_actual_co[".$tabindex."]=".$respuesta.";
			</script>";
			$j=0;
	$tabindex++; $cantidad++; }
	?>
	
<?php $funcion="guardar_encuesta_iep"; ?>
	
@include('encuestas_baterias.botones',["funcion"=>$funcion,"final"=>0])

</div>
</div>

@include('encuestas_baterias.finalizar_prueba_ultima',["funcion"=>$funcion,"final"=>1])

<script>
	$("[tabindex='1']").focus();
</script>
</div>
</form>
@include('layout.pruebas.footer')