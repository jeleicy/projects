<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use Redirect;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\FoldersControllers;

?>

@include ('layout.header')
<?php
	echo "<br /><br /><div class='alert alert-info'><strong>".$tipo." insertado satisfactoriamente.</strong>";
?>
@include ('layout.footer')