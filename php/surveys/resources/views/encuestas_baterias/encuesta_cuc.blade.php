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
<div id="header_tit" align="left"><span class="header_tit1">SEUC</span></div>

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
			where btp.id_tipo_prueba=tp.id and btp.id_bateria=".$id_bateria;
	echo $sql; return;
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
........................
<!-- ACEPTACION -->
<div id="aceptacion" align="center" style="display:inline;">
	<?php
		$sql = "select * from texto_aceptacion 
			where id_bateria=$id_bateria and 
				id_empresa=$id_empresa and activa=1";
		$data=DB::select($sql);
		$texto="";
		foreach ($data as $data) {
			$texto = $data->texto;
			$texto=str_replace("TXTNOMBRE","<strong>".strtoupper($nombres)."</strong>",$texto);
			$texto=str_replace("TXTAPELLIDO","<strong>".strtoupper($apellidos)."</strong>",$texto);
			$texto=str_replace("TXTCEDULA","<strong>".$cedula."</strong>",$texto);
			echo $texto;
		}
	?>
	
	<div align="center">
		<input type="button" name="si_acepta" value="Acepto" onclick="acepto_seuc()">
		<input type="button" name="no_acepta" value="NO Acepto">
	</div>	
	
</div>	
<!-- ACEPTACION -->

<!-- INSTRUCCIONES -->
<div id="instrucciones" align="center" style="display:none;">
	<?php
		$sql = "select i.texto, tp.nombre, i.posicion
				from instrucciones i, tipos_pruebas tp 
				where tp.id=$id_tp and i.id_prueba=tp.id and i.id_empresa=$id_empresa";
		//echo $sql; return;
		$data_i = DB::select($sql);		
		
		$instrucciones_antes="";
		$instrucciones_despues="";
		
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

	@include('encuestas_baterias.instrucciones',["boton"=> "1", "id_au"=>$id_au, "id_au"=>$id_au, "nro_inst"=>6, "titulo"=>$titulo,"instrucciones_antes"=>$instrucciones_antes,"instrucciones_despues"=>$instrucciones_despues, "tiempo"=>$tiempo, "funcion"=>"guardar_encuesta_ra"])
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
<br /><br />
<div id="prueba_cuadro_cont">
<?php
	$sql = "select * from preguntas_epa where id_pruebas=2 order by orden";
	$data=DB::select($sql);
	$cantidad=1;
	$imagenes=array();	
	
	foreach ($data as $data) {
		$id_pregunta = $data->id_preguntas;
		$orden_pregunta = $data->orden;
		$pregunta=$data->nombre;
		$respuesta=$data->respuesta;
		//$valor=$respuesta;
		$valor="";
		
		if ($cantidad==1) {
			$display="inline";
			$autofocus="autofocus";
		} else {
			$display="none";
			$autofocus="";
		}		

		$dir = opendir("imagenes/RA");
		$files = array();
		$imagenes=array();
		while ($file = readdir($dir)) {
			if( $file != "." && $file != "..") {
				$id_file_pregunta = substr($file,strpos($file,"_")+1);
				$id_file_pregunta = substr($id_file_pregunta,strpos($id_file_pregunta,"_")+1);
				$id_file_pregunta = substr($id_file_pregunta,0,strpos($id_file_pregunta,"."));		
				if (strlen($id_file_pregunta)==2) {
					$pregunta=substr($id_file_pregunta,0,1);
					$orden=substr($id_file_pregunta,1);
				} else {
					$pregunta=substr($id_file_pregunta,0,2);
					$orden=substr($id_file_pregunta,2);
				}
				if ($orden_pregunta==$pregunta) {
					$imagenes[$orden_pregunta][$orden]=$file;
				}
			}
		}
		/*echo "<pre>";
		print_r ($imagenes); 
		echo "</pre>";*/
		/*foreach ($imagenes as $key=>$value)
			echo $key."=".count($value)."<br>";*/
?>

<div id="prueba{{ $tabindex }}" style="display: {{ $display }};">
	<div id="prueba2_op_cont">
		<div id="prueba_num1">{{ $cantidad }}.</div>
		<button type="button" class="prueba2" onclick="javascript:;"><br /><img src='../imagenes/RA/<?php echo $imagenes[$orden_pregunta][1]; ?>'  width='75' height='75'/></button>
		<button type="button" class="prueba2"><br /><img src='../imagenes/RA/<?php echo $imagenes[$orden_pregunta][2]; ?>'  width='75' height='75'/></button>
		<button type="button" class="prueba2"><br /><img src='../imagenes/RA/<?php echo $imagenes[$orden_pregunta][3]; ?>'  width='75' height='75'/></button>
		<button type="button" class="prueba2"><br /><img src='../imagenes/RA/<?php echo $imagenes[$orden_pregunta][4]; ?>'  width='75' height='75'/></button>
		<button type="button" class="prueba2"><br /><div id='img_respuesta_<?php echo $id_pregunta; ?>' style='width=75px; height:75px; background: #ffff01; padding: 2px; margin: 5px; border-color: #c8c8c8; border: 2px solid'></div></button>
	</div>	
	
	<div id="prueba2_op_cont">
		<div id="prueba_num1"></div>		
		<strong>Seleccione una de las opciones...</strong>
		<br />
		<div style="float:right;">
		<button type="button" class="prueba2" href='javascript:;' onclick='ver_imagen(<?php echo $id_pregunta; ?>, 5, "<?php echo $imagenes[$orden_pregunta][5]; ?>")'><br /><img width='75' height='75' src='../imagenes/RA/<?php echo $imagenes[$orden_pregunta][5]; ?>' /></button>
		<button type="button" class="prueba2" href='javascript:;' onclick='ver_imagen(<?php echo $id_pregunta; ?>, 6, "<?php echo $imagenes[$orden_pregunta][6]; ?>")'><br /><img width='75' height='75' src='../imagenes/RA/<?php echo $imagenes[$orden_pregunta][6]; ?>' /></button>
		<button type="button" class="prueba2" href='javascript:;' onclick='ver_imagen(<?php echo $id_pregunta; ?>, 7, "<?php echo $imagenes[$orden_pregunta][7]; ?>")'><br /><img width='75' height='75' src='../imagenes/RA/<?php echo $imagenes[$orden_pregunta][7]; ?>' /></button>
		<button type="button" class="prueba2" href='javascript:;' onclick='ver_imagen(<?php echo $id_pregunta; ?>, 8, "<?php echo $imagenes[$orden_pregunta][8]; ?>")'><br /><img width='75' height='75' src='../imagenes/RA/<?php echo $imagenes[$orden_pregunta][8]; ?>' /></button>
		<button type="button" class="prueba2" href='javascript:;' onclick='ver_imagen(<?php echo $id_pregunta; ?>, 9, "<?php echo $imagenes[$orden_pregunta][9]; ?>")'><br /><img width='75' height='75' src='../imagenes/RA/<?php echo $imagenes[$orden_pregunta][9]; ?>' /></button>
		</div>
	</div>
</div>

<?php 
	echo "
		<script>
			respuesta_actual_co[".$id_pregunta."]=".$respuesta.";
		</script>";

	$tabindex++; $cantidad++;
		} ?>
</div>


<!-- CONTROL DE PREGUNTAS -->
<!--div id="pregunta_contenido">
<div id="pregunta_cont_activo">1</div>
<div id="pregunta_cont">2</div>
<div id="pregunta_cont">3</div>
<div id="pregunta_cont">4</div>
<div id="pregunta_cont">5</div>
<div id="pregunta_cont">6</div>
</div-->
<!-- CIERRE CONTROL DE PREGUNTAS -->


@include('encuestas_baterias.botones',["funcion"=>'guardar_encuesta_ra',"final"=>0])

</div>
</div>

<script>
	$("[tabindex='1']").focus();
</script>
</form>
@include('layout.pruebas.footer')