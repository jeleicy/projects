@include('layout.header')
    <div class="container">
	<?php
		$sql = "select id, presento, nombre_evaluado, correo_evaluado 
			from autorizaciones
			where id=".$id;
		//echo $sql; return;
		$data=DB::select($sql);
		$presento="";
		if (!empty($data)) {
			foreach ($data as $data) {
				$presento=$data->presento;
				$nombre_evaluado=$data->nombre_evaluado;
				$correo_evaluado=$data->correo_evaluado;
			}
		} else
			$presento=1;
		if ($presento==1) {
		?>
			<br /><br /><br />
			<div class="container">
				<div class="label label-primary" style="font-size: 12pt;" align="right">No esta autorizado para presentar esta prueba, o ya fue evaluado</div>
			</div>		
		<?php
		} else {

	?>
    {!! Form::open(array('url' => 'guardar_potencial', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		<input type="hidden" name="id" value="<?=$id?>" />
	{!! Form::close() !!}
		
		<div id="potencial" class="col-md-11" style="background: #ffffff; margin:50px; display: inline;">
			<!--strong><h1 style="color: #1abb9c; texty-align: center">Comienza APRECIACION DE POTENCIAL</h1></strong-->
			<h2>Evaluado: <?php echo $nombre_evaluado." (".$correo_evaluado.")"; ?></h2>
			@include('potencial.preguntas')
		</div>
		<br /><br /><br />
		
        <!-- /.row -->

		<?php } ?>
@include('layout.footer')