<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;

?>
@include('layaout.header_admin')
	<legend>Estadisticas de Votos</legend>
<br /><br />

<ol>
	<li><a class="ver_mas" href="javascript:;" onclick="ver_excel('reporte_votos/<?php echo  SessionusuarioControllers::show("id_eleccion"); ?>')">Exportar a Excel cantidad de votos</a></li>
</ol>

<?php
	$sql = "select distinct(v.fecha_hora) as cortes ";
	$sql .= "from votos v, candidato c ";
	$sql .= "where v.id_candidato=c.id_candidato and ";
	$sql .= "c.id_eleccion=1";
	$sql .= " and v.id_eleccion=1";
	$sql .= " and v.id_eleccion=c.id_eleccion";
	$data=DB::select($sql);
	$cortes=1;
	$i=1;
	foreach ($data as $data) {
		echo "T$cortes = <strong>".substr($data->cortes,strpos($data->cortes," "))."</strong>";
		$cortes++;
		$i++;
		if ($i<9)
			echo " / ";
		else {
			echo "<br />";
			$i=1;
		}
	}
	$cortes--;
?>
	<br /><br />

    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
		<tr>
			<th colspan="<?php echo ($cortes+1); ?>">Cortes (datos sin ponderar - Cantidades) (Nota: El % dado es en cuanto al numero total de votos de esa mesa)</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>Partido</td>
			<?php
			for ($i=1; $i<($cortes+1); $i++) {
				echo "<td>T$i (votos)</td>";
			}
			?>
		</tr>
		<?php
		$sql = "select distinct(c.id_candidato), c.nombre, c.partido ";
		$sql .= "from votos v, candidato c ";
		$sql .= "where v.id_candidato=c.id_candidato and ";
		$sql .= "c.id_eleccion=".SessionusuarioControllers::show("id_eleccion");
		$sql .= " and v.id_eleccion=".SessionusuarioControllers::show("id_eleccion");
		$sql .= " and v.id_eleccion=c.id_eleccion ";
		$sql .= "order by 2";
		$data=DB::select($sql);
		$j=1;

		foreach ($data as $data) {
		if ($j==1) $j=2;
		else $j=1;
		?>
		<tr>
			<td><?php echo $data->partido; ?></td>
			<?php
			$sql = "select v.cantidad, v.id_votos, a.nro_mesa, a.id_asignacion ";
			$sql .= "from votos v, asignacion a ";
			$sql .= "where v.id_candidato=".$data->id_candidato;
			$sql .= " and v.id_eleccion=".SessionusuarioControllers::show("id_eleccion");
			$sql .= " and v.id_asignacion=a.id_asignacion";
			//echo $sql;
			$data2=DB::select($sql);
			$i=1;
			$suma="";
			$mesa_votos="";
			foreach ($data2 as $data2) {
				echo "<td align='center'>".$data2->cantidad." (".number_format((($data2->cantidad*100)/FuncionesControllers::buscar_votos_mesa_total($data2->nro_mesa,$data2->id_asignacion)),2,",",".")."%)</td>";
				$suma[$data->partido][$i]=$data2->cantidad;
				$mesa_votos[$data->partido][$i]=$data2->nro_mesa.".".$data2->id_asignacion;
				$i++;
			}
			?>
		</tr>
		<?php
		}
		?>

		<?php
		echo "<tr>";
		echo "<td align='center'>&nbsp;</td>";
		for ($j=1; $j<$i; $j++) {
			$sumatoria=0;
			foreach ($suma as $key => $value) {
				$sumatoria+=$suma[$key][$j];
			}
			$array_sumatoria[$j]=$sumatoria;
			echo "<td align='center'>".$sumatoria."</td>";
		}
		echo "</tr>";
		?>
		</tbody>
		</table>

    <!--table id="example" class="display" cellspacing="0" width="100%">
        <thead>
		<tr>
			<th colspan="<?php echo ($cortes+1); ?>">Cortes (datos sin ponderar - Porcentajes)</th>
		</tr>
		</thead>
		<tbody>		
		<tr>
			<td>Partido</td>
			<?php
				for ($i=1; $i<($cortes+1); $i++)
					echo "<td>T$i (%)</td>";
			?>
		</tr>
		<?php
			if (!empty($suma)) {
				/*
				echo "<pre>";
				print_r ($suma);
				echo "</pre>";
				echo "<pre>";
				print_r ($mesa_votos);
				echo "</pre>";
				*/

				foreach ($suma as $key => $value) {
					if ($j==1) $j=2;
					else $j=1;
					echo "<tr>";
					echo "<td>".$key."</td>";
					$total_porcentaje=0;
					foreach ($suma[$key] as $key2 => $value2) {
						//$porcentaje=($value2*100)/($array_sumatoria[$key2]);
						$mesa=substr($mesa_votos[$key][$key2],0,strpos($mesa_votos[$key][$key2],"."));
						$asignacion=substr($mesa_votos[$key][$key2],strpos($mesa_votos[$key][$key2],".")+1);
						$votos_totales=FuncionesControllers::buscar_votos_mesa_total($mesa,$asignacion);
						$porcentaje=($value2*100)/$votos_totales;
						$porcentaje=number_format($porcentaje,2,",",".");
						echo "<td align='center'>".$porcentaje."% ($votos_totales)</td>";
						$total_porcentaje+=$porcentaje;
					}
					$tp[]=$total_porcentaje;
					echo "</tr>";
				}
			}
		?>
		</tbody>
	</table-->
	
	<br /><br />
	

@include('layaout.footer_admin')