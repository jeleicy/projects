<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use DB;
use Session;
use Form;
use URL;
use App\Http\Controllers\FuncionesControllers;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <title>Red de Observacion</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">

    <!-- MetisMenu CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/metisMenu.min.css') }}">

    <!-- Timeline CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/timeline.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/sb-admin-2.css') }}">

    <!-- Morris Charts CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/morris.css') }}">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/estilos.css') }}">

    <script type="text/javascript" src="{{ URL::asset('assets/js/funciones.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/ajax.js') }}"></script>

    <!--link href="css/scwdemo.css" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="css/lightbox.css">
    <link type="text/css" rel="stylesheet" href="css/estilos.css"-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>


<?php if ($mensaje=="") { ?>

{!! Form::open(array('url' => 'guardar_cambiar_contrasena', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<?php
    $sql = "select id_observador from observador where email='$email'";
    $data=DB::select($sql);
    foreach ($data as $data)
        $id_observador=$data->id_observador;
?>
<input type="hidden" name="id_observador" value="<?php echo $id_observador; ?>" />
<legend>Cambiar Contrase&ntilde;a</legend>
<br />
<br />
<div class="form-group">
    <label class="control-label col-xs-3">Pregunta Secreta:</label>
    <div class="col-xs-9">
        <?php
        $sql = "select pregsec from observador where id_observador=".$id_observador;
        $data = DB::select($sql);
        foreach($data as $data)
            echo $data->pregsec;
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-3">Respuesta Secreta:</label>
    <div class="col-xs-9">
        <input name="respsec" type="text" class="form-control" placeholder="Respuesta Secreta" value="">
    </div>
</div>

<div class="form-group">
    <div class="col-xs-offset-3 col-xs-9">
        <input  class="btn btn-primary" type="button" name="Validar" value="Validar Respuesta" onclick="validar_respuesta(this.form)" />
        <input type="reset" class="btn btn-default" value="Limpiar">
    </div>
</div>

<div id="textos_contrasenas"></div>

{!! Form::close() !!}
<?php } else echo '<br /><br /><div class="error" align="center">'.$mensaje.'</div><br /><br />'; ?>

</div>
</div>


</body>
</html>
<!-----------------------FOOTER---------------------------------->
