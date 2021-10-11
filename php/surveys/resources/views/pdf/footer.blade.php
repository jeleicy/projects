</p>

<p style='text-align:justify; page-break-before: always;'><b><span lang=ES-VE style='font-size:16.0pt;font-family:"Arial",sans-serif'>{{ trans ('iol_test.cabecera_pdf') }}</span></b></p>
<p style='text-align:justify;'>
	<span lang=ES-VE style='font-family:"Arial",sans-serif'>
	{{ trans ('iol_test.parrafo6') }}.
	</span>
</p>

<br /><br />

<table border=1 width="70%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>&nbsp;</td>
		<td align="center" style="text-align: center; background: #4bacc6">(D)</td>
		<td align="center" style="text-align: center; background: #4bacc6">(I)</td>
		<td align="center" style="text-align: center; background: #4bacc6">(S)</td>
		<td align="center" style="text-align: center; background: #4bacc6">(C)</td>
	</tr>
	<tr align="center">
		<td style="text-align: center; background: #ff0000">{{ trans('iol_test.very_hight') }}<br />5</td>
		<td>
			{{ trans('iol_test.Vigoroso') }}	<br />	{{ trans('iol_test.Demandante') }}	<br />	{{ trans('iol_test.Dominante') }}	<br />	{{ trans('iol_test.Agresivo') }}	<br />
			<?php if ($data["cotidiana_D"]==5) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Efusivo') }}	<br />	{{ trans('iol_test.Carismatico') }}	<br />	{{ trans('iol_test.Fascinante') }}	<br />	{{ trans('iol_test.Arrollador') }}	<br />
			<?php if ($data["cotidiana_I"]==5) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>			
			{{ trans('iol_test.Posesivo') }}	<br />	{{ trans('iol_test.Compulsivo') }}	<br />	{{ trans('iol_test.Impasible') }}	<br />	{{ trans('iol_test.Inflexible') }}	<br />
			<?php if ($data["cotidiana_S"]==5) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Perfeccionista') }}	<br />	{{ trans('iol_test.Rigido') }}	<br />	{{ trans('iol_test.Cauteloso') }}	<br />	{{ trans('iol_test.Impositivo') }}	<br />
			<?php if ($data["cotidiana_C"]==5) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>	
	</tr>
	<tr align="center" style="text-align: center; background: #99ff99">
		<td>{{ trans('iol_test.hight') }}<br />4</td>
		<td>
			{{ trans('iol_test.Intrepido') }}	<br />	{{ trans('iol_test.Competitivo') }}	<br />	{{ trans('iol_test.Desafiante') }}	<br />	{{ trans('iol_test.Pro-activo') }}	<br />
			<?php if ($data["cotidiana_D"]==4) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Convincente') }}	<br />	{{ trans('iol_test.Animado') }}	<br />	{{ trans('iol_test.Incentivador') }}	<br />	{{ trans('iol_test.Sociable') }}	<br />
			<?php if ($data["cotidiana_I"]==4) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Esmerado') }}	<br />	{{ trans('iol_test.Conciso') }}	<br />	{{ trans('iol_test.Laborioso') }}	<br />	{{ trans('iol_test.Organizado') }}	<br />
			<?php if ($data["cotidiana_S"]==4) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Ingenioso') }}	<br />	{{ trans('iol_test.Riguroso') }}	<br />	{{ trans('iol_test.Sistematico') }}	<br />	{{ trans('iol_test.Focalizado') }}	<br />
			<?php if ($data["cotidiana_C"]==4) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
	</tr>
	<tr align="center">
		<td style="text-align: center; background: #ffff00">{{ trans('iol_test.average') }}<br />3</td>
		<td>
			{{ trans('iol_test.Directo') }}	<br />	{{ trans('iol_test.Resuelto') }}	<br />	{{ trans('iol_test.Determinado') }}	<br />	{{ trans('iol_test.Valeroso') }}	<br />
			<?php if ($data["cotidiana_D"]==3) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>			
			{{ trans('iol_test.Calido') }}	<br />	{{ trans('iol_test.Amigable') }}	<br />	{{ trans('iol_test.Ameno') }}	<br />	{{ trans('iol_test.Conciliador') }}	<br />
			<?php if ($data["cotidiana_I"]==3) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Adaptable') }}	<br />	{{ trans('iol_test.Relajado') }}	<br />	{{ trans('iol_test.Consistente') }}	<br />	{{ trans('iol_test.Impecable') }}	<br />
			<?php if ($data["cotidiana_S"]==3) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Planificador') }}	<br />	{{ trans('iol_test.Objetivo') }}	<br />	{{ trans('iol_test.Analitico') }}	<br />	{{ trans('iol_test.Previsivo') }}	<br />
			<?php if ($data["cotidiana_C"]==3) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
	</tr>
	<tr align="center" style="text-align: center; background: #ffccff">
		<td>{{ trans('iol_test.low') }}<br />2</td>
		<td>
			{{ trans('iol_test.Discreto') }}	<br />	{{ trans('iol_test.Modesto') }}	<br />	{{ trans('iol_test.Cooperador') }}	<br />	{{ trans('iol_test.Humilde') }}	<br />
			<?php if ($data["cotidiana_D"]==2) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Reflexivo') }}	<br />	{{ trans('iol_test.Atento') }}	<br />	{{ trans('iol_test.Cordial') }}	<br />	{{ trans('iol_test.Amable') }}	<br />
			<?php if ($data["cotidiana_I"]==2) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Voluble') }}	<br />	{{ trans('iol_test.Intranquilo') }}	<br />	{{ trans('iol_test.Impaciente') }}	<br />	{{ trans('iol_test.Cumplido') }}	<br />
			<?php if ($data["cotidiana_S"]==2) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Dubitativo') }}	<br />	{{ trans('iol_test.Convencional') }}	<br />	{{ trans('iol_test.Intuitivo') }}	<br />	{{ trans('iol_test.Informal') }}	<br />
			<?php if ($data["cotidiana_C"]==2) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
	</tr>
	<tr align="center">
		<td style="text-align: center; background: #ff0000">{{ trans('iol_test.very_low') }}<br />1</td>
		<td>
			{{ trans('iol_test.Indeciso') }}	<br />	{{ trans('iol_test.Recatado') }}	<br />	{{ trans('iol_test.Docil') }}	<br />	{{ trans('iol_test.Complaciente') }}	<br />
			<?php if ($data["cotidiana_D"]==1) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Reservado') }}	<br />	{{ trans('iol_test.Indiferente') }}	<br />	{{ trans('iol_test.Distante') }}	<br />	{{ trans('iol_test.Apatico') }}	<br />
			<?php if ($data["cotidiana_I"]==1) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Urgido') }}	<br />	{{ trans('iol_test.Impetuoso') }}	<br />	{{ trans('iol_test.Frenetico') }}	<br />	{{ trans('iol_test.Impulsivo') }}	<br />
			<?php if ($data["cotidiana_S"]==1) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
		<td>
			{{ trans('iol_test.Radical') }}	<br />	{{ trans('iol_test.Desinhibido') }}	<br />	{{ trans('iol_test.Irreverente') }}	<br />	{{ trans('iol_test.Arriesgado') }}	<br />
			<?php if ($data["cotidiana_C"]==1) echo "<img src='imagenes/estrella.gif'>"; ?>
		</td>
	</tr>
</table>
<!--p style='text-align:justify'><span lang=ES style='font-family: "Arial",sans-serif'><img width=600 height=442 src="imagenes/image005.gif"></span></p-->

</div>

</body>

</html>
 
