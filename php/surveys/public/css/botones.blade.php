<?php
	if ($final==0)
		$texto_boton="Finalizar...";
	else
		$texto_boton="Finalizar...";
	
	if ($funcion=="guardar_encuesta_hn")
		$clase="_hn";
	else
		$clase="";
?>

<!-- BOTONES -->
<br /><br /><br />
<div id="cont_botones_pru1{{ $clase }}" align="left">
	<div align="center" class="botones_pru" style="width:100%; position:relative; border: 0px solid green;">
		<input type="button" style="display: none;" id="anterior" class="botones" onclick="anterior_op()" value="Anterior">
		<input type="button" style="display: inline;" id="siguiente" class="botones" onclick="siguiente_op()" value="Siguiente">
		<input type="button" style="display: none;" id="finalizar" class="botones" onclick="{{ $funcion }}()" value="{{ $texto_boton }}">
	</div>
</div>
<!-- CIERRE BOTONES -->