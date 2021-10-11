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

    {!! Form::model($usuario,array('url' => 'guardar_usuario_edicion', 'method' => 'put', 'class' =>  "form-horizontal", 'files'=>true,'onSubmit'=>'guardar();')) !!}
		
		<input type="hidden" name="id" value="<?=$usuario->id?>" />
<div class="row">
		<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ Session::get("mensaje") }}
		</div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombres <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombres" name="nombres" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="<?=$usuario->nombres?>">
            </div>
        </div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Empresa</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<?php if (Session::get("rol")=="EA") { ?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						{{ FuncionesControllers::buscar_empresa(Session::get("id_empresa")) }}
					</div>					
				<?php } else { ?>
				<select class="form-control" id="id_empresas" name="id_empresas" id="id_empresas">
					{{ FuncionesControllers::crear_combo('empresas', $usuario->id_empresas) }}
				</select>
				<?php } ?>
			</div>
		</div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" name="email" type="email" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Email" value="<?=$usuario->email?>">
            </div>
        </div>		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Rol</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<select class="form-control" id="rol" name="rol" id="rol">
					<?php if (Session::get("rol")!="EA") { ?>							
						<option value="A" <?php if ($usuario->rol=="A") echo "selected"; ?>>Administrador</option>
					<?php } ?>	
					<option value="EA" <?php if ($usuario->rol=="EA") echo "selected"; ?>>Empresa (Administrador)</option>
					<option value="ERRHH" <?php if ($usuario->rol=="ERRHH") echo "selected"; ?>>Empresa (RRHH)</option>
					<!--option value="C" <?php if ($usuario->rol=="C") echo "selected"; ?>>Candidato</option-->
				</select>
			</div>
		</div>
        <br />
        <div class="ln_solid"></div>
        <div class="form-group" align="center">
            {!! Form::submit('Guardar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
        </div>
</div>
    {!! Form::close() !!}

@include ('layout.footer')
