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

    {!! Form::open(array('url' => 'guardar_usuario_nuevo', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true,'onSubmit'=>'guardar();')) !!}
        <h2>Nueva usuario</h2> <hr />
<div class="row">
		<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ $mensaje }}
		</div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombres <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombres" name="nombres" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="">
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
					{{ FuncionesControllers::crear_combo('empresas', 0) }}
				</select>
				<?php } ?>
			</div>
		</div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" name="email" type="email" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Email" value="">
            </div>
        </div>		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Rol</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<select onchange="ver_rol(this.value)" class="form-control" id="rol" name="rol" id="rol">
					<?php if (Session::get("rol")!="EA") { ?>
						<option value="A">Administrador</option>
					<?php } ?>
					<option value="EA">Empresa (Administrador)</option>
					<option value="ERRHH">Empresa (RRHH)</option>
					<!--option value="C">Candidato</option-->
				</select>
			</div>
		</div>
        <div class="form-group" id="ver_pass">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Contraseña <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" name="password" type="password" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Password">
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