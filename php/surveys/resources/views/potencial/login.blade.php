@include('layout.header')

<!--
 * parallax_login.html
 * @Author original @msurguy (tw) -> http://bootsnipp.com/snippets/featured/parallax-login-form
 * @Tested on FF && CH
 * @Reworked by @kaptenn_com (tw)
 * @package PARALLAX LOGIN.
-->
<br /><br /><br /><br />
<?php
    if ($mensaje=="error")
        echo "<div class='alert alert-danger'><strong>Debe estar autenticado en nuestro sistema</strong></div>";
    elseif ($mensaje=="error_autenticacion")
        echo "<div class='alert alert-danger'><strong>Usuario y/o Contraseña invalidos</strong></div>";
 ?>

{!! Form::open(array('url' => 'verificar_usuario', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
	<input type="hidden" name="mensaje" value="">
<br /><br /><br /><br />
<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row-fluid user-row" align="center">
                        <img src="{{ URL::asset('imagenes/app.gif') }}" class="img-responsive" alt="Sign In"/>
                    </div>
                </div>
                <div class="panel-body">
                        <fieldset>
                            <input value="" required="required" autocomplete="off" placeholder="Email" class="form-control" placeholder="Username" name="username" id="username" type="text">
                            <input value="" data-validate-length="6,8" type="password" required="required" placeholder="Password" class="form-control" placeholder="Password" name="password" id="password" type="password">
                            <br />
							<div id="boton_2" align="center">
								<input onclick="login_in()" type="button" class="btn btn-primary" value="Ingresar">
							</div>
                        </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@include('layout.footer')