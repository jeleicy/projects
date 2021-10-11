<!-- ************************************Header*************************************** -->

<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=Generator content="Microsoft Word 15 (filtered)">
<title>Inventario de Fortalezas Humanas</title>
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

<p align=center style='text-align:center'><b><span lang=ES-MX style='font-size:22.0pt;font-family:"Arial",sans-serif'>FORTALEZAS HUMANAS (IFH)</span></b></p>

<p align=center style='text-align:center'><b><span lang=ES-MX style='font-size:22.0pt;font-family:"Arial",sans-serif'>(Resultado Cuantitativo)</span></b></p>

<br /><br /><br /><br /><br /><br />
<br /><br /><br /><br /><br />
<br /><br /><br /><br /><br />
<p class=MsoNormal><b><span lang=IT style='font-size:16.0pt;font-family:"Arial",sans-serif'>Nombre del Candidato: {{ $data['candidato'] }}</span></b></p>
<p class=MsoNormal><b><span lang=IT style='font-size:16.0pt;font-family:"Arial",sans-serif'>Fecha de Evaluación: {{ strtoupper($data['fecha']) }}</span></b></p>
<p class=MsoNormal><b><span lang=IT style='font-size:16.0pt;font-family:"Arial",sans-serif'>Elaborado por: José Taricani L.</span></b></p>

<br /><br /><br /><br /><br /><br />
<br /><br /><br /><br /><br />
<br /><br /><br /><br /><br />

<div align="right">
	<img width=110 height=37 src="imagenes/app.gif">
</div>
<br /><br /><br /><br />

<p style='text-align:justify'><span lang=ES style='font-family: "Arial",sans-serif'>
	Resultado obtenido:
</span></p>



<!--****************************************Tabla*************************************-->
				<table width="75%" border=1 cellspacing="0" align="center">
					<tr>
						<th align="left" width="25%">Fortaleza</th>	
						<th align="left" width="25%">Dimension</th>
						<th align="center">Puntaje Bruto</th>
						<th align="center">Pentil</th>
						<th align="center">Categoría</th>
					</tr>
					<tr id="indice" valign="middle">
						<td style="font-size:9pt; background-color:#ff9900;  font-weight: bold">
							Curiosidad<br />	
							Conocimiento<br />
							Juicio<br />
							Creatividad<br />
							Perspectiva
						</td>	
						<td align="left" style="background-color:#ff9900; font-weight: bold">Sabiduria</td>
						<td align="center">{{ $data["puntaje_sabiduria"] }}</td>
						<td align="center">{{ $data["pentil_sabiduria"] }}</td>
						<td align="center" style="background-color:<?php echo $data["color_sabiduria"]; ?>">{{ $data["categoria_sabiduria"] }}</td>
					</tr>
					<tr id="indice">
						<td style="font-size:9pt; background-color:#ccffcc; font-weight: bold">
							Valentía<br />
							Perseverancia<br />
							Integridad<br />
							Entusiasmo
						</td>	
						<td align="left" style="background-color:#ccffcc; font-weight: bold">Coraje</td>
						<td align="center">{{ $data["puntaje_coraje"] }}</td>
						<td align="center">{{ $data["pentil_coraje"] }}</td>
						<td align="center" style="background-color:<?php echo $data["color_coraje"]; ?>">{{ $data["categoria_coraje"] }}</td>
					</tr>	
					<tr id="indice">
						<td style="font-size:9pt; background-color:#9ccffb; font-weight: bold">
							Bondad<br />
							Amor<br />
							Inteligencia Social
						</td>	
						<td align="left" style="background-color:#9ccffb; font-weight: bold">Humanidad</td>
						<td align="center">{{ $data["puntaje_humanidad"] }}</td>
						<td align="center">{{ $data["pentil_humanida"] }}</td>
						<td align="center" style="background-color:<?php echo $data["color_humanidad"]; ?>">{{ $data["categoria_humanidad"] }}</td>
					</tr>						
					<tr id="indice">
						<td style="font-size:9pt; background-color:#ffcc00;  font-weight: bold">
							Civismo<br />
							Imparcialidad<br />
							Liderazgo
						</td>	
						<td align="left" style="background-color:#ffcc00; font-weight: bold">Justicia</td>
						<td align="center">{{ $data["puntaje_justicia"] }}</td>
						<td align="center">{{ $data["pentil_justicia"] }}</td>
						<td align="center" style="background-color:<?php echo $data["color_justicia"]; ?>">{{ $data["categoria_justicia"] }}</td>
					</tr>		
					<tr id="indice">
						<td style="font-size:9pt; background-color:#0bfc00; font-weight: bold">
							Auto-Control<br />
							Prudencia<br />
							Humildad<br />
							Perdón
						</td>	
						<td align="left" style="background-color:#0bfc00; font-weight: bold">Templanza</td>
						<td align="center">{{ $data["puntaje_templanza"] }}</td>
						<td align="center">{{ $data["pentil_templanza"] }}</td>
						<td align="center" style="background-color:<?php echo $data["color_templanza"]; ?>">{{ $data["categoria_templanza"] }}</td>
					</tr>		
					<tr id="indice">
						<td style="font-size:9pt; background-color:#b8a0e7;  font-weight: bold">
							Gratitud<br />
							Esperanza<br />
							Espiritualidad<br />
							Belleza<br />
							Humor
						</td>	
						<td align="left" style="background-color:#b8a0e7; font-weight: bold">Trascendencia</td>
						<td align="center">{{ $data["puntaje_trancendencia"] }}</td>
						<td align="center">{{ $data["pentil_transcendencia"] }}</td>
						<td align="center" style="background-color:<?php echo $data["color_transcendencia"]; ?>">{{ $data["categoria_transcendencia"] }}</td>
					</tr>	
					<tr><td colspan="5" style="background-color:#ffffff;">&nbsp;</td></tr>
					<tr id="indice">
						<td style="background-color:#ffffff;">&nbsp;</td>	
						<td align="left" style="background-color:#b8a0e7; font-weight: bold">Tendencia</td>
						<td align="center">{{ $data["puntaje"] }}</td>
						<td align="center">{{ $data["pentil"] }}</td>
						<td align="center" style="background-color:<?php echo $data["color"]; ?>">{{ $data["categoria"] }}</td>
					</tr>
					<tr><td colspan="5" style="background-color:#ffffff;">&nbsp;</td></tr>
					<tr id="indice">
						<td style="background-color:#ffffff;">&nbsp;</td>	
						<td colspan="4" align="left" style="background-color:#b8a0e7; font-weight: bold">Baremo General 2017</td>
					</tr>					
				</table>
				
<!--****************************************Tabla*************************************-->

<!--****************************************Contenido*********************************-->

<br /><br /><br /><br /><br /><br />
<br /><br /><br /><br /><br /><br />
<br /><br /><br /><br /><br /><br />

<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><FONT FACE="Arial, serif"><FONT SIZE=4><B>Posibles
resultados y alcance.</B></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><FONT FACE="Arial, serif"><FONT SIZE=3>De
manera sencilla, se puede analizar un resultado en tres grandes
categor&iacute;as por las implicaciones que de ellas se derivan, a
saber:</FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<UL>
	<LI><P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><FONT FACE="Arial, serif"><FONT SIZE=3>Inferior
	al Promedio</FONT></FONT></P>
	<LI><P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><FONT FACE="Arial, serif"><FONT SIZE=3>Promedio</FONT></FONT></P>
	<LI><P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><FONT FACE="Arial, serif"><FONT SIZE=3>Superior
	al Promedio</FONT></FONT></P>
</UL>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<TABLE WIDTH="40%" BORDER=1 BORDERCOLOR="#00000a" CELLPADDING=7 CELLSPACING=0>
	<TR VALIGN=TOP>
		<TD>
			<P ALIGN=CENTER><FONT FACE="Arial, serif"><FONT SIZE=3><B>Inferior
			al Promedio</B></FONT></FONT><FONT FACE="Arial, serif"><FONT SIZE=3>
			</FONT></FONT><FONT FACE="Arial, serif">(Pentil 1 y 2)</FONT></P>
		</TD>
		<TD>
			<P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT FACE="Arial, serif"><FONT SIZE=3><B>Promedio
			</B></FONT></FONT>
			</P>
			<P ALIGN=CENTER><FONT FACE="Arial, serif">(Pentil 3)</FONT></P>
		</TD>
		<TD>
			<P ALIGN=CENTER><FONT FACE="Arial, serif"><FONT SIZE=3><B>Superior
			al Promedio</B></FONT></FONT><FONT FACE="Arial, serif"><FONT SIZE=3>
			</FONT></FONT><FONT FACE="Arial, serif">(Pentil 4 y 5)</FONT></P>
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD>
			<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in"><FONT FACE="Arial, serif">La
			disposici&oacute;n para otorgarle importancia y poner en pr&aacute;ctica
			los requerimientos del valor en cuesti&oacute;n tiende a estar por
			debajo de la tendencia general. Ello supone poca claridad sobre la
			naturaleza intr&iacute;nseca de este valor y de sus implicaciones
			directas en la vida cotidiana. Muestra un pobre reportorio de
			pautas de acci&oacute;n espec&iacute;fica vinculado con el valor
			para ponerlo en la pr&aacute;ctica y hacerlo valer oportunamente y
			con propiedad. Requiere hacer un esfuerzo sostenido para advertir
			los rasgos esenciales de este valor en el comportamiento de
			quienes lo rodean y reconocer sus m&eacute;ritos. </FONT><FONT FACE="Arial, serif"><B>En
			resumen:</B></FONT><FONT FACE="Arial, serif"> este valor en
			particular es una fuente limitada de satisfacci&oacute;n y de
			gratificaciones en las diferentes facetas de su vida, al cual le
			asigna poca relevancia y un impacto remoto en su bienestar en
			general.</FONT></P>
			<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in"><BR>
			</P>
			<P ALIGN=JUSTIFY><BR>
			</P>
		</TD>
		<TD>
			<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in"><FONT FACE="Arial, serif">La
			disposici&oacute;n para otorgarle importancia y poner en pr&aacute;ctica
			los requerimientos del valor en cuesti&oacute;n tiende a estar a
			la par de la tendencia general. Ello supone claridad sobre la
			naturaleza intr&iacute;nseca de este valor y de sus implicaciones
			directas en la vida cotidiana. Muestra un aceptable reportorio de
			pautas de acci&oacute;n espec&iacute;fica vinculado con el valor
			para ponerlo en la pr&aacute;ctica y hacerlo valer oportunamente y
			con propiedad. Advierte los rasgos esenciales de este valor en el
			comportamiento de quienes lo rodean y reconoce sus m&eacute;ritos.
			</FONT><FONT FACE="Arial, serif"><B>En resumen:</B></FONT><FONT FACE="Arial, serif">
			este valor en particular es una fuente continua de satisfacci&oacute;n
			y de gratificaciones en las diferentes facetas de su vida, al cual
			le asigna relevancia y un impacto sustancial en su bienestar en
			general.</FONT></P>
			<P ALIGN=JUSTIFY><BR>
			</P>
		</TD>
		<TD>
			<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in"><FONT FACE="Arial, serif">La
			disposici&oacute;n para otorgarle importancia y poner en pr&aacute;ctica
			los requerimientos del valor en cuesti&oacute;n tiende a estar por
			encima de la tendencia general. Ello supone mucha claridad sobre
			la naturaleza intr&iacute;nseca de este valor y de sus
			implicaciones directas en la vida cotidiana. Muestra un amplio
			reportorio de pautas de acci&oacute;n espec&iacute;fica vinculado
			con el valor para ponerlo en la pr&aacute;ctica y hacerlo valer
			oportunamente y con propiedad. Advierte los rasgos esenciales de
			este valor en el comportamiento de quienes lo rodean y reconoce de
			manera manifiesta sus m&eacute;ritos. </FONT><FONT FACE="Arial, serif"><B>En
			resumen:</B></FONT><FONT FACE="Arial, serif"> este valor en
			particular es una fuente vigorosa de satisfacci&oacute;n y de
			gratificaciones en las diferentes facetas de su vida, al cual le
			asigna especial relevancia y un impacto notorio en su bienestar en
			general.</FONT></P>
			<P ALIGN=JUSTIFY><BR>
			</P>
		</TD>
	</TR>
</TABLE>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P LANG="es-MX" ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><BR><BR>
</P>
<P LANG="es-MX" ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><BR><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">La
Psicolog&iacute;a Positiva centra su atenci&oacute;n en las
&ldquo;Fortalezas Humanas&rdquo;, es decir en aquellos aspectos que
permiten que cualquier ser humano aprenda, disfrute, sea alegre,
generoso, solidario y optimista, en lugar del estudio y el
tratamiento de la enfermedad mental.</SPAN></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">Basado
en innovadoras investigaciones, Martin Seligman, concluye que al
identificar lo mejor en nosotros mismos y desarrollar estos aspectos,
se puede incrementar sensiblemente el nivel de bienestar en la vida y
situarse en un plano que ofrece mayores posibilidades de realizaci&oacute;n
duradera: el sentido y la determinaci&oacute;n por un prop&oacute;sito
noble en la vida.</SPAN></FONT></FONT></P>
<P LANG="es-MX" ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><BR><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">Una
Fortaleza Humana es un rasgo moral, una caracter&iacute;stica
psicol&oacute;gica, que:</SPAN></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><BR><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-left: 0.49in; margin-right: 0.63in; margin-bottom: 0.14in">
<FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">a) se
expresa en diferentes &aacute;mbitos y, a lo largo del tiempo, en
forma consistente.</SPAN></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-left: 0.49in; margin-right: 0.63in; margin-bottom: 0.14in">
<FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">b) es
valorada en s&iacute; misma; es decir, una condici&oacute;n que se
desea por su valor intr&iacute;nseco, no requiere de mayores
justificaciones. </SPAN></FONT></FONT>
</P>
<P ALIGN=JUSTIFY STYLE="margin-left: 0.49in; margin-right: 0.63in; margin-bottom: 0.14in">
<FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">c) cuando
alguien act&uacute;a en funci&oacute;n de ella, despierta intensas
emociones positivas aut&eacute;nticas en s&iacute; mismo y en los que
le rodea.</SPAN></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-left: 0.49in; margin-right: 0.63in; margin-bottom: 0.14in">
<FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">d) se
reconocen como valiosas en casi todas las culturas del mundo, ellas
tienden a poseer un car&aacute;cter universal.</SPAN></FONT></FONT></P>
<P LANG="es-MX" ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><BR><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><FONT COLOR="#000000"><FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">Llegar
a ser una persona plena e &iacute;ntegra consiste en mostrar,
mediante actos voluntarios, todas o la mayor&iacute;a de las
fortalezas que expresan de la mejor manera la naturaleza humana de un
individuo. </SPAN></FONT></FONT></FONT>
</P>
<P LANG="es-MX" ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><BR><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><FONT COLOR="#000000"><FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">A
continuaci&oacute;n, una clasificaci&oacute;n general de las 6
Fortalezas Humanas:</SPAN></FONT></FONT></FONT></P>
<P LANG="es-MX" ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><BR><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-left: 0.38in; text-indent: -0.38in; margin-top: 0.05in; margin-bottom: 0in; line-height: 115%">
<FONT COLOR="#000000"> </FONT><FONT COLOR="#000000"> <FONT FACE="Times New Roman, serif"><FONT SIZE=3><FONT FACE="Arial, serif"><SPAN LANG="es-MX">I.-
</SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX"><B>Sabidur&iacute;a</B></SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX">:
fortalezas de car&aacute;cter cognoscitivo que propician el
aprendizaje, y la generaci&oacute;n, la aplicaci&oacute;n y
divulgaci&oacute;n del conocimiento.</SPAN></FONT></FONT></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-left: 0.38in; text-indent: -0.38in; margin-top: 0.05in; margin-bottom: 0in; line-height: 115%">
<FONT COLOR="#000000"> <FONT FACE="Times New Roman, serif"><FONT SIZE=3><FONT FACE="Arial, serif"><SPAN LANG="es-MX">II.-
</SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX"><B>Coraje:</B></SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX">
fortalezas emocionales que involucran el ejercicio de la voluntad
para encarar con determinaci&oacute;n cometidos frente a oposiciones
externas e internas.</SPAN></FONT></FONT></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-left: 0.38in; text-indent: -0.38in; margin-top: 0.05in; margin-bottom: 0in; line-height: 115%">
<FONT FACE="Times New Roman, serif"><FONT SIZE=3><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX">III.-
</SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX"><B>Humanidad</B></SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX">:
fortalezas interpersonales que involucran estimar y entablar
relaciones sociales positivas con otros.</SPAN></FONT></FONT></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-left: 0.38in; text-indent: -0.38in; margin-top: 0.05in; margin-bottom: 0in; line-height: 115%">
<FONT FACE="Times New Roman, serif"><FONT SIZE=3><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX">IV.-
</SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX"><B>Justicia</B></SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX">:
fortalezas c&iacute;vicas en las que se sustenta el bienestar de la
familia, la comunidad, la naci&oacute;n y el mundo.</SPAN></FONT></FONT></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-left: 0.38in; text-indent: -0.38in; margin-top: 0.05in; margin-bottom: 0in; line-height: 115%">
<FONT COLOR="#000000"> <FONT FACE="Times New Roman, serif"><FONT SIZE=3><FONT FACE="Arial, serif"><SPAN LANG="es-MX">V.-
</SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX"><B>Templanza</B></SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX">:
fortalezas que nos protegen frente a los excesos. Permiten una
expresi&oacute;n moderada de los apetitos y necesidades, ajustadas a
las circunstancias.</SPAN></FONT></FONT></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-left: 0.38in; text-indent: -0.38in; margin-top: 0.05in; margin-bottom: 0in; line-height: 115%">
<FONT FACE="Times New Roman, serif"><FONT SIZE=3><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX">VI.-
</SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX"><B>Trascendencia</B></SPAN></FONT></FONT><FONT COLOR="#000000"><FONT FACE="Arial, serif"><SPAN LANG="es-MX">:
fortalezas que forjan las conexiones con el universo como un todo, lo
divino, proveen de significado y provocan emociones equivalentes a la
elevaci&oacute;n.  </SPAN></FONT></FONT></FONT></FONT>
</P>
<P LANG="es-MX" STYLE="margin-bottom: 0.14in"><BR><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-top: 0.17in; margin-bottom: 0in"><FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">Cada
persona muestra preponderancia hacia ciertas fortalezas en
particular, si las pone en pr&aacute;ctica en los principales &aacute;mbitos
de su vida puede obtener una fuente abundante de gratificaci&oacute;n,
alcanzar una mayor gama de satisfacci&oacute;n e incrementar su
realizaci&oacute;n como persona.</SPAN></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-top: 0.17in; margin-bottom: 0.14in"><FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">Una
fortaleza se manifiesta, por parte de la persona, en un rango
conductual (creencias, sentimientos y acciones) de forma tal que
puede ser determinada su magnitud ya sea por su frecuencia o
intensidad cualitativa. Esta condici&oacute;n es un rasgo distintivo,
es decir, genera una pauta general de comportamientos a trav&eacute;s
de diversas situaciones, con estabilidad en el tiempo. Destaca el
grado de expresi&oacute;n presente del valor, m&aacute;s all&aacute;
del rendimiento en cualquier &aacute;mbito de acci&oacute;n.</SPAN></FONT></FONT><FONT FACE="Arial, serif"><FONT SIZE=3>
</FONT></FONT><FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">Permite
contemplar el sistema de valores propio de la &ldquo;naturaleza
humana&rdquo; que caracteriza a un grupo o persona.</SPAN></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">El
crecimiento personal, como ser humano en la b&uacute;squeda del
desarrollo de todo su potencial, constituye la expresi&oacute;n m&aacute;s
completa de adoptar las fortalezas humanas. Ello se traduce en
condiciones deseables y m&aacute;s optimistas durante el transcurso
de la vida tales como: emociones positivas, entrega, inter&eacute;s,
sentido y prop&oacute;sito.</SPAN></FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><FONT FACE="Arial, serif"><FONT SIZE=3><SPAN LANG="es-MX">Si
se disponen las 6 fortalezas humanas tipificadas en un cuadro de
coordenadas cartesianas, donde en el eje de las abscisas (horizontal)
se encuadra la propensi&oacute;n a la acci&oacute;n
(activaci&oacute;n-moderaci&oacute;n) y, en el eje de las ordenadas
(vertical), la preponderancia hacia las cosas (en un plano colectivo)
o hacia la gente (en un plano m&aacute;s individual), se puede llegar
a una proyecci&oacute;n de su &aacute;mbito de influencia y
predominancia con los siguientes par&aacute;metros:</SPAN></FONT></FONT></P>
<P LANG="es-MX" ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><BR><BR>
</P>
<P ALIGN=CENTER STYLE="margin-bottom: 0.14in"><IMG SRC="imagenes/estrella.JPG" ALIGN=BOTTOM WIDTH=545 HEIGHT=383 BORDER=0></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><BR><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0.14in"><FONT FACE="Arial, serif"><FONT SIZE=3>Durante
la vida encontramos cabida para expresarnos y manifestarnos en todos
estos planos, pero la inclinaci&oacute;n por algunos de ellos en
lugar de otros, hace que las mayores fuentes de estimulaci&oacute;n
est&eacute;n sesgadas en la direcci&oacute;n de tales preferencias. A
la vez, la exclusi&oacute;n de algunos de tales planos limita la gama
de posibilidades y reduce la esencia que es propia de la naturaleza
humana, aminorando la posibilidad de una vida rica y plena en sus
diferentes facetas.</FONT></FONT></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><FONT FACE="Arial, serif"><FONT SIZE=3>Necesitamos
descubrir, desarrollar y expandir nuestras propias cualidades
fundamentales, por ende, aprender a promover tales rasgos en los
diferentes &aacute;mbitos de nuestra existencia y quehacer cotidiano.
Requerimos hacer valer la identidad que nos hace una persona
plenamente humana y, por ello, &uacute;nica y singular.</FONT></FONT></P>

<!--****************************************Contenido*********************************-->

<!-- ************************************Footer*************************************** -->

</body>

</html>

<!-- ************************************Footer*************************************** -->