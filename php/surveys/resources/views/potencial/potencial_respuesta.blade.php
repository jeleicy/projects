@include('layout.header_encuesta')
		<br /><br /><br />
		<div class='alert alert-info'>
			<img src="imagenes/app.gif" border=0>
			<?php  
				echo "<br /><br />Gracias por realizar nuestra encuesta.</strong>";
			?>
		</div>
		
			<!--br /><br />
			<div align="center">Sus Resultados Fueron:</div>
			<br /><br />
			<table border="0" width="20%" align="center" cellpadding="15" cellspacing="15">
				<tr class="alert alert-info alert-dismissible fade in" align="center" style="font-size: 12pt; font-weight: bold;"><td colspan="3">Factores de Potencial</td></tr>
				<?php
					$aux="";
					for ($i=0; $i<count($res); $i++)
						$aux.=$res[$i].",";
					$aux=substr($aux,0,strlen($aux)-1);
					
					$sql = "select r.fecha, r.valor, r.id_opciones, o.nombre, o.id_opciones
							from resultados_potencial r, opciones_potencial o
							where r.id_candidato=".$id_candidato." and o.id_opciones=r.id_opciones and 
							r.id in (".$aux.") order by o.id_opciones";
					$data=DB::select($sql);
					$i=1;
					$suma=0;
					foreach ($data as $data) {
						?>
							<tr>
								<td><?php echo $i; ?>.-</td>
								<td><?php echo $data->nombre; ?></td>
								<td width="15%" align="center"><?php echo number_format($data->valor,2,",","."); ?></td>
							</tr>
						<?php
						$suma+=$data->valor;
						$i++;
					}
				?>
					<tr class="alert alert-info alert-dismissible fade in" align="right" style="font-size: 12pt; font-weight: bold;">
						<td colspan="2">Total = </td>
						<td align="center"><?php echo number_format(($suma/6),2,",","."); ?></td>
					</tr>				
			</table-->		
		
@include('layout.footer_encuesta')