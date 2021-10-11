<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

@include ('layout.header')

<script>
	pruebas_disponibles_array= new Array();
	<?php 
		$arreglo_pruebas=FuncionesControllers::cantidad_pruebas();
		if (!empty($arreglo_pruebas)) {
			foreach ($arreglo_pruebas as $key=>$value)
				echo "pruebas_disponibles_array[".$key."]=".abs($value)."; ";
		}
	?>
</script>

    {!! Form::open(array('url' => 'guardar_asignacion', 'name' => 'asignar_prueba', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
        <h2>Nueva Asignacion</h2> <hr />
		<input type="hidden" name="error" id="error" value="0" />
		
		<div align="left" class="alert alert-{{ $tipo }} alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>			
		
<div class="row">
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Empresa</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<?php if (Session::get("rol")=="EA") { ?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						{{ FuncionesControllers::buscar_empresa(Session::get("id_empresa")) }}
					</div>					
				<?php } else { ?>
				<select class="form-control" id="id_empresas" name="id_empresas" id="id_empresas">
					{{ FuncionesControllers::crear_combo('empresas', 0) }}
				</select>
				<?php } ?>		
			</div>
		</div>
		<?php if (Session::get("rol")=="EA") { ?>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Usuario</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<select class="form-control" id="id_usuario_asignado" name="id_usuario_asignado">
					{{ FuncionesControllers::crear_combo_usuarios() }}
				</select>
			</div>
		</div>
		<input type="hidden" name="cantidad_pruebas" id="cantidad_pruebas" value="" />
		<?php } else {
		?>
			<input type="hidden" name="cantidad_pruebas" id="cantidad_pruebas" value="-1" />
		<?php } ?>	

		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Bateria</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<select class="form-control" id="id_tipo_prueba" name="id_tipo_prueba">
					<option value=0>Seleccione...</option>
					{{ FuncionesControllers::crear_combo("bateria",0) }}
				</select>
			</div>
		</div>	

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cantidad de Pruebas: <span class="msj">(*)</span>:</label>
            <div class="col-md-3">
                <input id="cantidad" maxlength="3" name="cantidad" type="number" required="required" class="form-control" placeholder="Cantidad Pruebas" value="">
				<?php if (Session::get("rol")=="EA") { ?>
					<span id="disponibles" style="background:yellow; font-weight: bold;"></span>
				<?php } ?>
            </div>
        </div>
			
        <br />
        <div class="ln_solid"></div>
        <div class="form-group" align="center">
			<input class="send-btn btn btn-primary" type="submit" style="display:none" name="asignar" id="asignar" value="Asignar">
        </div>
</div>
		
		{!! Form::close() !!}

@include ('layout.footer')