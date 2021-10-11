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
	$opciones=array(1=>'Completamente',
					2=>'Moderadamente',
					3=>'Ligeramente',
					
					4=>'Ligeramente',
					5=>'Moderadamente',
					6=>'Completamente');
?>

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
<span class="header_tit1">I</span><span class="header_tit2">nventario de </span> <span class="header_tit1">F</span><span class="header_tit2">ortalezas</span> <span class="header_tit1">H</span><span class="header_tit2">umanas</span></div>

<div id="logo_inter">
<img src="../css/images/logo.png" width="122" height="60" alt="TalentsKey" />
</div>
</div></div>
<!-- CIERRE HEADER -->

<script>nro_prueba=10; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1; var cantidad=0;</script>

<?php 
	$tabindex=1;
	$i=0; 
	
	$sql = "select tp.id, tp.url, tp.vista_tiempo from tipos_pruebas tp, bateria_tipo_prueba btp
			where btp.id_tipo_prueba=tp.id and btp.id_bateria=".$id_bateria."";
	//echo $sql; return;
	$data=DB::select($sql);
	$proxima_pagina="";
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

	@include('encuestas_baterias.instrucciones',["boton"=> "1", "id_au"=>$id_au, "nro_inst"=>12, "titulo"=>$titulo,"instrucciones_antes"=>$instrucciones_antes,"instrucciones_despues"=>$instrucciones_despues, "tiempo"=>$tiempo, "funcion"=>"guardar_encuesta_ifh"])
	
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
		$sql = "select * from preguntas_ifh order by orden";
		//echo $sql; return;
		$data=DB::select($sql);
		
		$i=1;
		$cantidad=1;
		$j=0;
		foreach ($data as $data) {
			$pregunta=$data->pregunta;
			$id_pregunta=$data->id;
			$respuesta=$data->respuesta;
			$imagen=$data->imagen;
			
			echo "<script>respuesta_actual_co[".$cantidad."]=".$respuesta.";</script>";
			
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
			<br /><br />
			<div id="prueba3_sl_preg" style="width: 100%;">{{ $pregunta }}</div>
			<br /><br />
			<?php
				$paso=0;
				foreach ($opciones as $key=>$value) {
					$selected="";
					if ($key==$respuesta)
						$selected="checked";
					else
						$selected="";
					
					echo "<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
							<td width='80%'>
								<table border=0 width='20%' align='center'>
									";
									if ($key<4)
										$titulo="en Desacuerdo: ";
									else
										$titulo="de Acuerdo: ";
									
									if ($key==1 || $key==4)
										echo "<tr><td align='center'><strong>".$titulo."</strong></td><td>&nbsp;</td></tr>";
									
					echo "
									<tr>
										<td width='75%' align='right'>".$value."</td>
										<td><input onclick='verificar_click()' class='radio_ifh' $selected type='radio' name='op_".$id_pregunta."' id='op_".$id_pregunta."' value='".$key."'></td>
									</tr>
								
								</table>
							</td>
						</tr>";														
					/*if ($paso==7) {
						$paso=0;
					} elseif ($paso==2) {
						echo "<tr onmouseover='this.bgColor=\"#c8c8c8\"' onmouseout='this.bgColor=\"#ffffff\"'>
								<td width='80%'>&nbsp;</td>
							</tr>";
					}*/
					$paso++;
				}
			?>
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
	
<?php $funcion="guardar_encuesta_ifh"; ?>
	
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