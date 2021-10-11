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
@include('layout.header_encuesta')

    <div class="container">
<?php
	if ($mensaje!="") {
		echo "<h2>".$mensaje."</h2>";
	} else {

	//$sql = "delete from pruebas_presentadas where id_autorizacion=233";
	//DB::delete($sql);
	
	//$sql = "delete from respuestas_co where id_autorizacion=233";
	//DB::delete($sql);	

	$sql = "select * from candidatos where id_autorizacion=".$id_au;
	$data=DB::select($sql);
	foreach ($data as $data) {
		$nombres=$data->nombres;
		$apellidos=$data->apellidos;
		$email=$data->email;
	}
	
	$pruebas=0;
	//PRUEBA CO
	$sql = "select rco.id from respuestas_co rco, preguntas_co phl
		where rco.id_autorizacion=".$id_au." and rco.id_opcion=phl.id_preguntas and 
		rco.id_pruebas=1";
	//echo "<br>$sql";
	$data=DB::select($sql);
	$cantidad_respuestas=count($data);
	if ($cantidad_respuestas>0) {
		$pruebas++;	
	}
	
	//PRUEBA HI
	$sql = "select rco.id from respuestas_co rco, preguntas_co phl
		where rco.id_autorizacion=".$id_au." and rco.id_opcion=phl.id_preguntas and 
		rco.id_pruebas=2";
	//echo "<br>$sql";
	$data=DB::select($sql);	
	$cantidad_respuestas=count($data);
	if ($cantidad_respuestas>0)
		$pruebas++;	
	
	//PRUEBA IEP
	$sql = "select rco.id from respuestas_co rco, preguntas_co phl
		where rco.id_autorizacion=".$id_au." and rco.id_opcion=phl.id_preguntas and 
		rco.id_pruebas=3";
	//echo "<br>$sql";
	$data=DB::select($sql);	
	$cantidad_respuestas=count($data);
	if ($cantidad_respuestas>0)
		$pruebas++;
	
	$pruebas++;
	echo "<script>nro_prueba=".$pruebas.";</script>";
	$pruebas--;
	
?>

    {!! Form::open(array('url' => 'guardar_encuesta', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="id_au" value="<?=$id_au?>">
		<div id="datos_prueba" align="center"></div>
		<?php
			$display="";
			if ($pruebas==0 || $pruebas==1) {
				$display[1]="none";
				$display[2]="none";
				$display[3]="none";
				$display[4]="none";
			} elseif ($pruebas==2) {
				$display[1]="none";
				$display[2]="none";				
				$display[3]="inline";
				$display[4]="none";
			} elseif ($pruebas==3) {
				$display[1]="none";
				$display[2]="none";
				$display[3]="none";
				$display[4]="inline";
			}
			$pruebas=2;
			$display[1]="none";
			$display[2]="inline";
			$display[3]="none";
			$display[4]="none";			
		?>
			<?php
				$i=1;				
				$sql = "select id from idioma where tipo='".\App::getLocale()."'";
				$data = DB::select($sql);
				foreach ($data as $data)
					$idioma=$data->id;
				
				$sql = "select distinct(tp.id), tp.nombre,btp.orden
						from tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where btp.id_bateria=4 and
							btp.id_tipo_prueba=tp.id and btp.orden>1 and a.id=".$id_au."
						order by orden";				
				$data = DB::select($sql);
				$i=2;
				$vista_prueba="";
				$tiempo="";
				foreach ($data as $data) {
					$tiempo[]=FuncionesControllers::buscarTiempo($data->id);
					$id_tp=$data->id;
										
					$vista_prueba[$i]=substr($tiempo,strpos($tiempo,"/")+1);
					$tiempo[$i]=substr($tiempo,0,strpos($tiempo,"/"));
					
					$sql = "select distinct(i.id_prueba), i.texto
						from instrucciones i, tipos_pruebas tp, bateria b, bateria_tipo_prueba btp, autorizaciones a
						where i.id_prueba=tp.id and btp.id_bateria=4 and
							btp.id_tipo_prueba=tp.id and i.id_idioma=".$idioma." and a.id=".$id_au."
							and a.id_empresas=i.id_empresa and tp.id=$id_tp order by 1";						
					//echo $sql; return;
					$data_i = DB::select($sql);
					if (empty($data_i))
						$instrucciones="";
					else
						foreach ($data_i as $data_i)
							$instrucciones=$data_i->texto;
					?>
						<div id="instrucciones_{{ $i }}" align="center" class="col-lg-10 text-left" style=" display:<?php echo $display[$i]; ?>; margin:50px;font-size: 11pt; border-style: solid; border-color: #1abb9c; padding:10px; color: #1abb9c">
							<h2>{{ $data->nombre }}</h2>
								<br /><br />
								<strong><h3 style="color: #000; texty-align: center">
									<?php echo $instrucciones; ?>
								</h3></strong>
								<br /><br />
								<strong><h4 style="color: #ff2a00; texty-align: center">Espere la indicación para dar inicio a la actividad.</h4></strong>
							<div align="center">
								<input name="boton_prueba_{{ $i }}" id="boton_prueba_{{ $i }}" <?php if ($i>3) echo "style='display:none'"; else echo "style='display:inline'"; ?>  onclick="ver_encuesta_co(<?php echo $tiempo; ?>, <?php echo $i; ?>, <?php echo $pruebas; ?>)" type="button" class="btn btn-primary" value="Comenzar">
							</div>
						</div>
					<?php
					$i++;
				}
			?>
		
		{!! Form::close() !!}
	</div>
		<div align="center">
		<?php
			$sql = "select * from bateria_tipo_prueba where id_bateria=4";
			$data=DB::select($sql);
			$prueba=1;
			foreach ($data as $data) {
				if ($prueba==1)
					$titulo="EJEMPLO DE PRUEBA CO";
				else
					$titulo="";
				?>
					<div id="encuesta_<?php echo $prueba; ?>" style="width: 100%; background: transparent; margin:0px; display: none; margin: auto; padding: 0px;">
						<strong><h1 style="color: #1abb9c; texty-align: center"><?php echo $titulo; ?></h1></strong>
						@include('prueba_co.preguntas_4_'.$prueba, ['tiempo' => $tiempo[$prueba+1], 'vista_prueba' => $vista_prueba[$prueba+1]])
					</div>					
				<?php
				$prueba++;				
			}
		?>

		</div>
		<br /><br /><br />
		
        <!-- /.row -->
<?php } ?>	
@include('layout.footer_encuesta')
