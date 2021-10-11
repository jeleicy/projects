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
<form name="forma_cc" class="form-horizontal">
	<input type="hidden" name="id_au" id="id_au" value="<?=$id_au?>" />
	<input type="hidden" name="bateria" id="bateria" value="<?=$id_bateria?>" />
	<input type="hidden" name="orden" id="orden" value="<?=$orden?>" />
<div id="contenedor">
<!-- HEADER -->
<div id="header"><div id="header_fondo">
<div id="header_tit" align="left">
<span class="header_tit1">H</span><span class="header_tit2">abilidad </span> <span class="header_tit1">N</span><span class="header_tit2">umerica</span></div>

<div id="logo_inter">
<img src="../css/images/logo.png" width="122" height="60" alt="TalentsKey" />
</div>
</div></div>
<!-- CIERRE HEADER -->

<script>nro_prueba=2; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1; var cantidad=0;</script>

<?php 
	$tabindex=1;
	$i=0; 
	
	$sql = "select tp.id, tp.url, tp.vista_tiempo from tipos_pruebas tp, bateria_tipo_prueba btp
			where btp.id_tipo_prueba=tp.id and btp.id_bateria=".$id_bateria." and orden=6";
	//echo $sql; return;
	$data=DB::select($sql);
	foreach ($data as $data) {
		$proxima_pagina=$data->url;
		$id_tp=$data->id;
		$tiempo=FuncionesControllers::buscarTiempo($data->id);
		$vista_prueba=substr($tiempo,strpos($tiempo,"/")+1);
		$tiempo=substr($tiempo,0,strpos($tiempo,"/"));		
	}
	
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

	@include('encuestas_baterias.instrucciones',["nro_inst"=>8, "titulo"=>$titulo,"instrucciones_antes"=>$instrucciones_antes,"instrucciones_despues"=>$instrucciones_despues, "tiempo"=>$tiempo, "funcion"=>"guardar_encuesta_hn"])
	
</div>	
<!-- INSTRUCCIONES -->

<!-- CONTENIDO -->
<div id="encuesta" style="display:none;">

<div id="cont2">
	<?php if ($vista_prueba==1) { ?>
		<div align="center" class="ver_tiempo" style="font-size: 12pt; font-weight: bold;">
			Tiempo restante para la prueba <span id="time">{{ $tiempo }}:00</span> minutos
		</div>
	<?php } ?>	

<?php
	$sql = "select * from preguntas_epa where id_pruebas=4 order by orden";
	$data=DB::select($sql);
	
	$i=1;
	$cantidad=1;
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
	<div id="prueba2_sl_cont1">
		<div id="prueba_num"></div>
		<div id="prueba2_sl_btn1cont">
			<div id="prueba2_sl_btn1_mediano" align="center">
					<br />
				<div id="op_{{ $id_preguntas }}" style="font-size: 25px;"><img src="../imagenes/HN/{{ $imagen }}"></div>
				<br /><br />
				<div class="prueba2_sl_btn1_respuesta" id='respuesta_{{ $data->id_preguntas }}' style='color: blue; line-height: 200%'></div>
			</div>
		</div>
	</div>
	<br /><br /><br />
	<div id="prueba2_sl_cont4hn">
		<div id="prueba2_sl_cont5">
<?php
		$sql = "select * from opciones_epa where id_pregunta=".$data->id_preguntas;
		$data_opciones=DB::select($sql);
		$k=1;
		foreach ($data_opciones as $data_opciones) {
			$id_pregunta = $data->id_preguntas;
			$opcion=$data_opciones->opcion;
			$opciones=explode("–",$opcion);														
			$antes="";
			$despues="";

			if (isset($opciones[0]))
				$antes=$opciones[0];
			if (isset($opciones[1]))
				$despues=$opciones[1];
			
			if (strpos($data_opciones->opcion,"imagenes") !== false)
				$opcion="<img src='../".$data_opciones->opcion."' height='35' width='35'>&nbsp;&nbsp;&nbsp;";
			else
				$opcion=$data_opciones->opcion;
?>
			<br>
			<button type="button" onclick="colocar_respuesta('hn', '{{ $antes }}', '{{ $despues }}', {{ $data->id_preguntas }}, {{ $data_opciones->id_opciones }}, '{{ $pregunta }}', '')" class="prueba1">{{ $opcion }}</button>
			<br>
		<?php } ?>
		</div>
	</div>
	<br><br><br><br><br>
	@include('encuestas_baterias.botones',["funcion"=>'guardar_encuesta_hn',"final"=>0])
</div>
	<?php 
		echo "
			<script>
				respuesta_actual_co[".$tabindex."]=".$respuesta.";
			</script>";

	$tabindex++; $cantidad++; }
	?>

</div>

</div>

<script>
	$("[tabindex='1']").focus();
</script>
</form>
@include('layout.pruebas.footer')