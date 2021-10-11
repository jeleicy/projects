@include('pdf.header')

<!-- INICIO CARACTERISTICAS DEL PERFIL -->

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=621 style='width:466.1pt;border-collapse:collapse;border:none'>
 <tr>
  <td width=158 valign=top style='width:1.65in;border:solid black 1.0pt; padding:0in 5.4pt 0in 5.4pt'>
	  <p class=MsoNormal align=center style='margin-bottom:10.0pt;text-align:center; line-height:115%'><b><span lang=ES-VE style='font-size:11.0pt;line-height: 115%;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
	  <p class=MsoNormal align=center style='margin-bottom:10.0pt;text-align:center; line-height:115%'><b><span lang=ES-VE style='font-size:11.0pt;line-height: 115%;font-family:"Arial",sans-serif'>{{ trans ('iol_test.Principales') }}</span></b></p>
  </td>
  <td width=151 valign=top style='width:113.4pt;border:solid black 1.0pt; border-left:none;padding:0in 5.4pt 0in 5.4pt'> 
	<p class=MsoNormal align=center style='margin-bottom:10.0pt;text-align:center; line-height:115%'><b><span lang=ES-VE style='font-size:11.0pt;line-height: 115%;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
	<p class=MsoNormal align=center style='margin-bottom:10.0pt;text-align:center; line-height:115%'><b><span lang=ES-VE style='font-size:11.0pt;line-height: 115%;font-family:"Arial",sans-serif'>{{ trans ('iol_test.Iniciativa') }}</span></b></p>
  </td>
  <td width=151 valign=top style='width:113.4pt;border:solid black 1.0pt; border-left:none;padding:0in 5.4pt 0in 5.4pt'>
	  <p class=MsoNormal align=center style='margin-bottom:10.0pt;text-align:center; line-height:115%'><b><span lang=ES-VE style='font-size:11.0pt;line-height: 115%;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
	  <p class=MsoNormal align=center style='margin-bottom:10.0pt;text-align:center; line-height:115%'><b><span lang=ES-VE style='font-size:11.0pt;line-height: 115%;font-family:"Arial",sans-serif'>{{ trans ('iol_test.Implicaciones') }}</span></b></p> 
  </td>
  <td width=161 valign=top style='width:120.5pt;border:solid black 1.0pt; border-left:none;padding:0in 5.4pt 0in 5.4pt'>
	<p class=MsoNormal align=center style='margin-bottom:10.0pt;text-align:center; line-height:115%'><b><span lang=ES-VE style='font-size:11.0pt;line-height: 115%;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
	<p class=MsoNormal align=center style='margin-bottom:10.0pt;text-align:center; line-height:115%'><b><span lang=ES-VE style='font-size:11.0pt;line-height: 115%;font-family:"Arial",sans-serif'>{{ trans ('iol_test.Supervision') }}</span></b></p>
  </td>
 </tr>
 <tr>
  <td width=158 valign=top style='width:1.65in;border:solid black 1.0pt; border-top:none;padding:0in 5.4pt 0in 5.4pt'>
		<p class=MsoNormal style='margin-bottom:10.0pt;line-height:115%'><span lang=ES-VE style='font-size:10.0pt;line-height:115%;font-family:"Arial Narrow",sans-serif'>&nbsp;</span></p>
		<p class=MsoNormal style='margin-bottom:10.0pt;text-align:justify;line-height: 115%'>
			<span lang=ES-VE style='font-size:10.0pt;line-height:115%;font-family: "Arial",sans-serif'>
				<!-- PRINCIPALES RASGOS -->
				{{ trans('iol_test_cooperativo.texto_principal') }}
			</span>
		</p>
  </td>
  <td width=151 valign=top style='width:113.4pt;border-top:none;border-left: none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt; padding:0in 5.4pt 0in 5.4pt'>
	  <p class=MsoNormal style='margin-bottom:10.0pt;line-height:115%'><span lang=ES-VE style='font-size:10.0pt;line-height:115%;font-family:"Arial Narrow",sans-serif'>&nbsp;</span></p> 
		<p class=MsoNormal style='margin-bottom:10.0pt;text-align:justify;line-height: 115%'>
			<span lang=ES-VE style='font-size:10.0pt;line-height:115%;font-family: "Arial",sans-serif'>
				<!-- INICIATIVA DIRECCIONAL -->
				{{ trans('iol_test_cooperativo.texto_iniciativa') }}
			</span>
		</p>
		<p class=MsoNormal style='margin-bottom:10.0pt;line-height:115%'><span lang=ES-VE style='font-size:10.0pt;line-height:115%;font-family:"Arial Narrow",sans-serif'>&nbsp;</span></p>
  </td>
  <td width=151 valign=top style='width:113.4pt;border-top:none;border-left: none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt; padding:0in 5.4pt 0in 5.4pt'> 
		<p class=MsoNormal style='margin-bottom:10.0pt;line-height:115%'><span lang=ES-VE style='font-size:10.0pt;line-height:115%;font-family:"Arial Narrow",sans-serif'>&nbsp;</span></p>
		<p class=MsoNormal style='margin-bottom:10.0pt;text-align:justify;line-height: 115%'>
			<span lang=ES-VE style='font-size:10.0pt;line-height:115%;font-family: "Arial",sans-serif'>
				<!-- PRINCIPALES IMPLICACIONES EN SU DESEMPEÑO -->
				{{ trans('iol_test_cooperativo.texto_implicaciones') }}
			</span>
		</p>
  </td>
  <td width=161 valign=top style='width:120.5pt;border-top:none;border-left: none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt; padding:0in 5.4pt 0in 5.4pt'>
	  <p class=MsoNormal style='margin-bottom:10.0pt;line-height:115%'><span lang=ES-VE style='font-size:10.0pt;line-height:115%;font-family:"Arial Narrow",sans-serif'>&nbsp;</span></p>
	  <p class=MsoNormal style='margin-bottom:10.0pt;text-align:justify;line-height: 115%'>
		<span lang=ES-VE style='font-size:10.0pt;line-height:115%;font-family: "Arial",sans-serif'>
			<!-- SUPERVISIÓN EFECTIVA -->
			{{ trans('iol_test_cooperativo.texto_supervision') }}
		</span>
	  </p>
	  <p class=MsoNormal style='margin-bottom:10.0pt;line-height:115%'><span lang=ES-VE style='font-size:10.0pt;line-height:115%;font-family:"Arial Narrow",sans-serif'>&nbsp;</span></p>
  </td>
 </tr>
</table>

<!-- FIN CARACTERISTICAS DEL PERFIL -->

@include('pdf.footer')