<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=Generator content="Microsoft Word 15 (filtered)">
<title>{{ trans('iol_test.cabecera_pdf') }}</title>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:"Arial Narrow";
	panose-1:2 11 6 6 2 2 2 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman",serif;}
p.NormalWeb40, li.NormalWeb40, div.NormalWeb40
	{mso-style-name:"Normal \(Web\)40";
	margin-top:11.25pt;
	margin-right:0in;
	margin-bottom:11.25pt;
	margin-left:0in;
	font-size:10.5pt;
	font-family:"Times New Roman",serif;}
p.Ttulo213, li.Ttulo213, div.Ttulo213
	{mso-style-name:"Título 213";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:9.75pt;
	margin-left:0in;
	font-size:16.5pt;
	font-family:"Times New Roman",serif;
	color:black;
	font-weight:bold;}
@page WordSection1
	{size:8.5in 11.0in;
	margin:70.85pt 85.05pt 70.85pt 85.05pt;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>

<p class=MsoNormal><b><span lang=ES-MX style='font-size:18.0pt;font-family:"Arial",sans-serif'><img width=170 height=74 src="imagenes/mth.png"></span></b></p>

<br /><br /><br /><br /><br /><br /><br /><br />

<p align=center style='text-align:center'><b><span lang=ES-MX style='font-size:22.0pt;font-family:"Arial",sans-serif'>{{ trans('iol_test.titulo_iol') }}</span></b></p>

<p align=center style='text-align:center'><b><span lang=ES-MX style='font-size:22.0pt;font-family:"Arial",sans-serif'>({{ trans('iol_test.iniciales_iol') }})</span></b></p>

<br /><br /><br /><br /><br /><br />
<br /><br /><br /><br /><br /><br />

<p align=center style='text-align:center'><b><span lang=ES-MX style='font-size:18.0pt;font-family:"Arial",sans-serif'>({{ trans('iol_test.perfil_basico') }})</span></b></p>

<br /><br /><br /><br /><br />
<br /><br /><br /><br /><br />
<p class=MsoNormal><b><span lang=IT style='font-size:16.0pt;font-family:"Arial",sans-serif'>{{ trans('iol_test.nombre_participante') }}: {{ $data['candidato'] }}</span></b></p>
<p class=MsoNormal><b><span lang=IT style='font-size:16.0pt;font-family:"Arial",sans-serif'>{{ trans('iol_test.fecha_evaluacion') }}: {{ strtoupper($data['fecha']) }}</span></b></p>
<p class=MsoNormal><b><span lang=IT style='font-size:16.0pt;font-family:"Arial",sans-serif'>{{ trans('iol_test.elaborado') }}: José Taricani L.</span></b></p>

<div align="right">
	<img width=110 height=37 src="imagenes/app.gif">
</div>
<br /><br /><br /><br />

<p style='text-align:justify'><span lang=ES style='font-family: "Arial",sans-serif'>
	{{ trans('iol_test.parrafo1') }}
</span></p>

<p style='text-align:justify'><span lang=ES style='font-family:"Arial",sans-serif'>{{ trans('iol_test.parrafo2') }}:</span></p>

<table align="center" width="30%">
	<tr><td><img width=12 height=12src="imagenes/image001.gif" alt="*"><b><span lang=ES-VE style='font-family:"Arial",sans-serif'>D </span></b><span lang=ES-VE style='font-family:"Arial",sans-serif'>{{ trans('iol_test.D') }}</span></p></td></tr>
	<tr><td><img width=12 height=12src="imagenes/image001.gif" alt="*"><b><span lang=ES-VE style='font-family:"Arial",sans-serif'>I </span></b><span lang=ES-VE style='font-family:"Arial",sans-serif'>{{ trans('iol_test.I') }}</span></p></td></tr>
	<tr><td><img width=12 height=12src="imagenes/image001.gif" alt="*"><b><span lang=ES-VE style='font-family:"Arial",sans-serif'>S </span></b><span lang=ES-VE style='font-family:"Arial",sans-serif'>{{ trans('iol_test.S') }}</span></p></td></tr>
	<tr><td><img width=12 height=12src="imagenes/image001.gif" alt="*"><b><span lang=ES-VE style='font-family:"Arial",sans-serif'>C </span></b><span lang=ES-VE style='font-family:"Arial",sans-serif'>{{ trans('iol_test.C') }}</span></p></td></tr>
</table>

<p style='text-align:justify'>
	<span lang=ES style='font-family: "Arial",sans-serif'>
{{ trans('iol_test.parrafo3') }}
	</span>
</p>

<p align=center style='text-align:center'><span lang=ES><img src="imagenes/imagen_{{ \App::getLocale() }}.gif"></span></p>

<p class=MsoNormal><b><span lang=ES-MX style='font-size:18.0pt;font-family:"Arial",sans-serif'>{{ trans('iol_test.cabecera_pdf') }}</span></b></p>

<br /><br />

<table border=0 width="70%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">&nbsp;</td>
		<td style="border-style: solid; border-width: 1px; font-weight: bold; background:#ff9900; font-family:'Arial',sans-serif;" colspan="14" align="center">{{ trans('iol_test.orientacion_laboral') }}</td>
		<td align="center">&nbsp;</td>
	</tr>
	<tr style="font-weight: bold; background:#fff; font-family:'Arial',sans-serif;">
		<td colspan="16" align="center">&nbsp;</td>
	</tr>	
	<tr align="center" style="font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">
		<td align="center" style="background:#fff;border-style: none; font-weight: bold; font-family:'Arial',sans-serif;">%</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">D</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">I</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">S</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">C</td>
		<td align="center" style="background:#fff;">&nbsp;</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">D</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">I</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">S</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">C</td>
		<td align="center" style="background:#fff;">&nbsp;</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">D</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">I</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">S</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#ffcc00; font-family:'Arial',sans-serif;">C</td>
		<td align="center" style="border-style: none; font-weight: normal; background:#fff; font-family:'Arial',sans-serif;">Sg</td>
	</tr>
	<tr style="font-weight: bold; background:#fff; font-family:'Arial',sans-serif;">
		<td colspan="16" align="center">&nbsp;</td>
	</tr>	
		<?php
			$i=5;
			$j=0;
			$porcentaje=array(10,20,40,20,10);
			// 10 20 40 20 10
			while ($i>0) {
			?>
			<tr>
				<td align="center" style="background:#fff; border-style: solid; border-width: 1px; font-weight: normal; font-family:'Arial',sans-serif;"><?php echo $porcentaje[$j]; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["deseada_D"]==$i) echo "x"; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["deseada_I"]==$i) echo "x"; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["deseada_S"]==$i) echo "x"; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["deseada_C"]==$i) echo "x"; ?></td>
				<td align="center">&nbsp;</td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["bajo_presion_D"]==$i) echo "x"; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["bajo_presion_I"]==$i) echo "x"; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["bajo_presion_S"]==$i) echo "x"; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["bajo_presion_C"]==$i) echo "x"; ?></td>
				<td align="center">&nbsp;</td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["cotidiana_D"]==$i) echo "x"; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["cotidiana_I"]==$i) echo "x"; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["cotidiana_S"]==$i) echo "x"; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:<?php if ($i==5) echo "#99cc00"; elseif ($i==3) echo "#ffff00"; elseif ($i==1) echo "#ff99cc"; ?>" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php if ($data["cotidiana_C"]==$i) echo "x"; ?></td>
				<td align="center" style="border-style: solid;border-width: 1px; background:#fff" style="font-weight: normal;font-family:'Arial',sans-serif;"><?php echo $i; ?></td>
			</tr>
			<?php
				$j++;
				$i--;
			}
		?>
	<tr style="font-weight: bold; background:#fff; font-family:'Arial',sans-serif;">
		<td colspan="16" align="center">&nbsp;</td>
	</tr>	
	<tr>
		<td align="center" style="background:#fff; border-style: none;">&nbsp;</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["mas_D"] }}</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["mas_I"] }}</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["mas_S"] }}</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["mas_C"] }}</td>
		<td align="center">&nbsp;</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["menos_D"] }}</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["menos_I"] }}</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["menos_S"] }}</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["menos_C"] }}</td>
		<td align="center">&nbsp;</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["mas_D"]-$data["menos_D"] }}</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["mas_I"]-$data["menos_I"] }}</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["mas_S"]-$data["menos_S"] }}</td>
		<td align="center" style="border-style: solid;border-width: 1px; font-weight: normal;font-family:'Arial',sans-serif;">{{ $data["mas_C"]-$data["menos_C"] }}</td>
		<td align="center">&nbsp;</td>
	</tr>
	<tr style="font-weight: bold; background:#fff; font-family:'Arial',sans-serif;">
		<td colspan="16" align="center">&nbsp;</td>
	</tr>	
	<tr align="center">
		<td align="center" style="background:#fff; border-style: none;">&nbsp;</td>
		<td colspan="4" align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#8db4e2; font-family:'Arial',sans-serif; font-size:8pt;">{{ trans('iol_test.deseada') }} (+)</td>
		<td align="center">&nbsp;</td>
		<td colspan="4" align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#8db4e2; font-family:'Arial',sans-serif; font-size:8pt;">{{ trans('iol_test.bajo_presion') }} (-)</td>
		<td align="center">&nbsp;</td>
		<td colspan="4" align="center" style="border-style: solid;border-width: 1px; font-weight: bold; background:#8db4e2; font-family:'Arial',sans-serif; font-size:8pt;">{{ trans('iol_test.cotidiana') }} (=)</td>
		<td align="center" style="border-style: none;">&nbsp;</td>
	</tr>
</table>

<!--p align=center style='text-align:center'><span lang=ES><img src="imagenes/image004.gif"></span></p-->
<br /><br />
<p style='text-align:justify;'>
	<span lang=ES-VE style='font-family:"Arial",sans-serif'>
		{{ trans('iol_test.parrafo4') }}
	</span>
</p>
		<p style=" page-break-before: always;">
		{{ trans('iol_test.parrafo5') }} <strong>{{ strtoupper($perfil) }}</strong>
		