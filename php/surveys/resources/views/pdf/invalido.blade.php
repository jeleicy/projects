@include('pdf.header')

<p align=center style='text-align:center'><b><span lang=ES style='font-family:"Arial",sans-serif'>“{{ strtoupper(trans('iol_test_invalido.perfil')) }}”</span></b></p>

<br />

<br />

<p class=MsoNormal><b><span lang=ES style='font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

<!-- INICIO CARACTERISTICAS DEL PERFIL -->

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=621 style='width:466.1pt;border-collapse:collapse;border:none'>
 <tr>
	<td>
	{{ trans('iol_test_invalido.parrafo1') }}
	</td>
 </tr>
</table>

<!-- FIN CARACTERISTICAS DEL PERFIL -->

@include('pdf.footer')