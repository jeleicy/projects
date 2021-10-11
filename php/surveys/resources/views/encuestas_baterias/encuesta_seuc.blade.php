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
<div id="header_tit" align="left"><span class="header_tit1">TCGO</span></div>

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
	//echo $sql; return;
	$data=DB::select($sql);
	foreach ($data as $data) {
		$proxima_pagina=$data->url;
		$id_tp=$data->id;
		$tiempo=FuncionesControllers::buscarTiempo($data->id);
		$vista_prueba=substr($tiempo,strpos($tiempo,"/")+1);
		$tiempo=substr($tiempo,0,strpos($tiempo,"/"));		
	}
	
	$sql = "select c.*, a.id_empresas from candidatos c, autorizaciones a 
		where c.id_autorizacion=a.id and 
			c.id_autorizacion=".$id_au;
	$data=DB::select($sql);
	
	$nombres="";
	$apellidos="";
	$email="";
	$id_empresa=0;
	$cedula='';
	
	foreach ($data as $data) {
		$nombres=$data->nombres;
		$apellidos=$data->apellidos;
		$email=$data->email;
		$id_empresa=$data->id_empresas;
		$cedula=$data->cedula;
	}
	
	$id_bateria=$id_bateria;
	
	$sql= "	select tbe.cod_evaluacion 
			from tb_evaluaciones tbe, autorizaciones a, candidatos c
			where a.id_tipo_prueba=".$id_bateria." and a.correo_evaluado=tbe.email_evaluado and 
				c.id_autorizacion=a.id and a.id=".$id_au;
	$data=DB::select($sql);
	foreach ($data as $data)
		$cod_evaluacion=$data->cod_evaluacion;
?>

<script>
	proxima_pagina='<?php echo $proxima_pagina; ?>';
	var id_au_ejemplo=<?=$id_au?>;
</script>

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

	@include('encuestas_baterias.instrucciones',["boton"=> "1", "nro_inst"=>0, "titulo"=>$titulo,"instrucciones_antes"=>$instrucciones_antes,"instrucciones_despues"=>$instrucciones_despues, "tiempo"=>$tiempo, "funcion"=>"guardar_encuesta_ra"])
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
	@include('encuestas_baterias.evaluacion_cuc',["cod_evaluacion"=>$cod_evaluacion])
</div>

@include('encuestas_baterias.botones',["funcion"=>'guardar_encuesta_seuc',"final"=>0])

</div>
</div>
</form>
@include('layout.pruebas.footer')