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
<form name="forma_cc" class="form-horizontal" onsubmit= "return guardar_encuesta_co_ejemplo()">
	<input type="hidden" name="id_au" id="id_au" value="<?=$id_au?>" />
	<input type="hidden" name="bateria" id="bateria" value="<?=$id_bateria?>" />
	<input type="hidden" name="orden" id="orden" value="<?=$orden?>" />
<div id="contenedor">
<!-- HEADER -->
<div id="header"><div id="header_fondo">
<div id="header_tit" align="left">
<span class="header_tit1">C</span><span class="header_tit2">apacidad</span> <span class="header_tit1">O</span><span class="header_tit2">rganizativa</span></div>

<div id="logo_inter">
<img src="../css/images/logo.png" width="122" height="60" alt="TalentsKey" />
</div>
</div></div>
<!-- CIERRE HEADER -->

<script>nro_prueba=0; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1; var cantidad=0;</script>

<?php 
	$tabindex=1;
	$i=0; 
	//echo $id_bateria; return;
	$sql = "select tp.id, tp.url, tp.vista_tiempo, btp.orden
			from tipos_pruebas tp, bateria_tipo_prueba btp
			where btp.id_tipo_prueba=tp.id and btp.id_bateria=".$id_bateria." 
				and btp.orden=".$orden;
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
	
	$id_bateria=substr($id_bateria,strpos($id_bateria,"-")+1);
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

	@include('encuestas_baterias.instrucciones',["nro_inst"=>0, "titulo"=>$titulo,"instrucciones_antes"=>$instrucciones_antes,"instrucciones_despues"=>$instrucciones_despues, "tiempo"=>$tiempo, "funcion"=>"guardar_encuesta_co"])
</div>	
<!-- INSTRUCCIONES -->

<!-- CONTENIDO -->
<div id="encuesta" style="display:none;">
<div id="cont3">
	<?php if ($vista_prueba==1) { ?>
		<div align="left" class="ver_tiempo_cc" style="font-size: 12pt; font-weight: bold;">
			Tiempo restante para la prueba <span id="time">{{ $tiempo }}:00</span> minutos
		</div>
		<br /><br />
	<?php } ?>	

<div id="prueba1_sl_cont">
<br /><br /><br />
<div align="center">
<?php 
	$sql = "select * from preguntas_co where id_pruebas=1 and id_preguntas<4 order by orden";
	$data=DB::select($sql);
	$cantidad=1;
	foreach ($data as $data) {
		$id_pregunta=$data->id_preguntas;
		$pregunta=$data->nombre;
		$respuesta=$data->respuesta;
		$valor="";
		if ($cantidad==1) {
			$display="inline";
			$autofocus="autofocus";
		} else {
			$display="none";
			$autofocus="";
		}
		?>
		<div align="center" style="display: {{ $display }}" id="prueba{{ $tabindex }}">
			<div class="prueba1_sl_txt">{{ $pregunta }}
				<input tabindex={{ $tabindex }} {{ $autofocus }} maxlength='2' class='clase_co' style='font-size: 28px; width:50px; height:30px; text-align: center' type='text' name='coord_{{ $id_pregunta }}' id='coord_{{ $id_pregunta }}' value='{{ $valor }}'>
			</div>
		</div>		
		<?php
		echo "
			<script>
				respuesta_actual_co[".$id_pregunta."]=".$respuesta.";
				//tabindex=".$tabindex.";
			</script>";
		$tabindex++;
		$cantidad++;
	}
?>
</div>
<br /><br /><br />
<div id="valor" style="text-align: center; font-size:14pt; width: 100%;"></div>

@include('encuestas_baterias.botones',["funcion"=>'guardar_encuesta_co',"final"=>0])

</div>

<!-- ARCHIVADOR -->
<div id="cont_archivador" style="z-index:1000;">
<a href="javascript:;"  onclick="colocar_nro(1)"><div id="texto_arch" class="texto_arch">1<br />Aa - Al</div></a>
<a href="javascript:;"  onclick="colocar_nro(9)"><div id="texto_arch" class="texto_arch">9<br />Cp - Cz</div></a>
<a href="javascript:;"  onclick="colocar_nro(17)"><div id="texto_arch" class="texto_arch">17<br />Ha - Hz</div></a>
<a href="javascript:;"  onclick="colocar_nro(25)"><div id="texto_arch" class="texto_arch">25<br />Mj - Mo</div></a>
<a href="javascript:;"  onclick="colocar_nro(33)"><div id="texto_arch" class="texto_arch">33<br />Sa - Si</div></a>

<a href="javascript:;"  onclick="colocar_nro(2)"><div id="texto_arch" class="texto_arch">2<br />Am - Au</div></a>
<a href="javascript:;"  onclick="colocar_nro(10)"><div id="texto_arch" class="texto_arch">10<br />Da - Dz</div></a>
<a href="javascript:;"  onclick="colocar_nro(18)"><div id="texto_arch" class="texto_arch">18<br />Ia - Iz</div></a>
<a href="javascript:;"  onclick="colocar_nro(26)"><div id="texto_arch" class="texto_arch">26<br />Mp - Mz</div></a>
<a href="javascript:;"  onclick="colocar_nro(34)"><div id="texto_arch" class="texto_arch">34<br />Sj - St</div></a>

<a href="javascript:;"  onclick="colocar_nro(3)"><div id="texto_arch" class="texto_arch">3<br />Av - Az</div></a>
<a href="javascript:;"  onclick="colocar_nro(11)"><div id="texto_arch" class="texto_arch">11<br />Ea - Er</div></a>
<a href="javascript:;"  onclick="colocar_nro(19)"><div id="texto_arch" class="texto_arch">19<br />Ja - Jz</div></a>
<a href="javascript:;"  onclick="colocar_nro(27)"><div id="texto_arch" class="texto_arch">27<br />Na - Nz</div></a>
<a href="javascript:;"  onclick="colocar_nro(35)"><div id="texto_arch" class="texto_arch">35<br />Su - Sz</div></a>

<a href="javascript:;"  onclick="colocar_nro(4)"><div id="texto_arch" class="texto_arch">4<br />Ba - Bi</div></a>
<a href="javascript:;"  onclick="colocar_nro(12)"><div id="texto_arch" class="texto_arch">12<br />Es - Ez</div></a>
<a href="javascript:;"  onclick="colocar_nro(20)"><div id="texto_arch" class="texto_arch">20<br />Ka - Ko</div></a>
<a href="javascript:;"  onclick="colocar_nro(28)"><div id="texto_arch" class="texto_arch">28<br />Oa - Oz</div></a>
<a href="javascript:;"  onclick="colocar_nro(36)"><div id="texto_arch" class="texto_arch">36<br />Ta - Ti</div></a>

<a href="javascript:;"  onclick="colocar_nro(5)"><div id="texto_arch" class="texto_arch">5<br />Bj - Br</div></a>
<a href="javascript:;"  onclick="colocar_nro(13)"><div id="texto_arch" class="texto_arch">13<br />Fa - Fr</div></a>
<a href="javascript:;"  onclick="colocar_nro(21)"><div id="texto_arch" class="texto_arch">21<br />Kp - Kz</div></a>
<a href="javascript:;"  onclick="colocar_nro(29)"><div id="texto_arch" class="texto_arch">29<br />Pa - Pr</div></a>
<a href="javascript:;"  onclick="colocar_nro(37)"><div id="texto_arch" class="texto_arch">37<br />Tj - Tz</div></a>

<a href="javascript:;"  onclick="colocar_nro(6)"><div id="texto_arch" class="texto_arch">6<br />Bs - Bz</div></a>
<a href="javascript:;"  onclick="colocar_nro(14)"><div id="texto_arch" class="texto_arch">14<br />Fs - Fz</div></a>
<a href="javascript:;"  onclick="colocar_nro(22)"><div id="texto_arch" class="texto_arch">22<br />La - Le</div></a>
<a href="javascript:;"  onclick="colocar_nro(30)"><div id="texto_arch" class="texto_arch">30<br />Ps - Pz</div></a>
<a href="javascript:;"  onclick="colocar_nro(38)"><div id="texto_arch" class="texto_arch">38<br />U - V</div></a>

<a href="javascript:;"  onclick="colocar_nro(7)"><div id="texto_arch" class="texto_arch">7<br />Ca - Ch</div></a>
<a href="javascript:;"  onclick="colocar_nro(15)"><div id="texto_arch" class="texto_arch">15<br />Ga - Go</div></a>
<a href="javascript:;"  onclick="colocar_nro(23)"><div id="texto_arch" class="texto_arch">23<br />Lf - Lz</div></a>
<a href="javascript:;"  onclick="colocar_nro(31)"><div id="texto_arch" class="texto_arch">31<br />Qa - Qz</div></a>
<a href="javascript:;"  onclick="colocar_nro(39)"><div id="texto_arch" class="texto_arch">39<br />Wa - Wz</div></a>

<a href="javascript:;"  onclick="colocar_nro(8)"><div id="texto_arch" class="texto_arch">8<br />Ci - Co</div></a>
<a href="javascript:;"  onclick="colocar_nro(16)"><div id="texto_arch" class="texto_arch">16<br />Gp - Gz</div></a>
<a href="javascript:;"  onclick="colocar_nro(24)"><div id="texto_arch" class="texto_arch">24<br />Ma - Mi</div></a>
<a href="javascript:;"  onclick="colocar_nro(32)"><div id="texto_arch" class="texto_arch">32<br />Ra - Rz</div></a>
<a href="javascript:;"  onclick="colocar_nro(40)"><div id="texto_arch" class="texto_arch">40<br />X - Y -Z</div></a>
</div>
<!-- CIERRE ARCHIVADOR -->

</div>
</div>

<script>
	$("[tabindex='1']").focus();
</script>
</form>
@include('layout.pruebas.footer')