
	<!-- jQuery -->
    <script src="{{ URL::asset('bp/bower_components/jquery/dist/jquery.min.js') }}"></script>
	
	<!--funciones-->
	<script src="{{ URL::asset('js/funciones.js') }}"></script>    	
	
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('bp/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	
	<!-- DataTables -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('js/datatables/datatables.min.css') }}"/>
	<script type="text/javascript" src="{{ URL::asset('js/datatables/datatables.min.js') }}"></script>	

	<script class="init">
		$( document ).ready(function() {
			$('#tabla_reportes').DataTable({
					 "dom": 'lBfrtip',
					"buttons": [
						{
							extend: 'collection',
							text: 'Exportar',
							buttons: [
								'copy',
								'excel',
								'csv',
								'pdf',
								'print'
							]
						}
					]
			});
		});
	</script>		
		
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ URL::asset('bp/bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>

    <!-- DataTables JavaScript -->
    <!--script src="{{ URL::asset('bp/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('bp/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('bp/bower_components/datatables-responsive/js/dataTables.responsive.js') }}"></script-->

	<!-- daterangepicker -->
	<script type="text/javascript" src="{{ URL::asset('js/moment.min2.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/datepicker/daterangepicker.js') }}"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="{{ URL::asset('bp/dist/js/sb-admin-2.js') }}"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <!--script>
    $(document).ready(function() {
        $('#tabla_reportes').DataTable({
                responsive: true
        });
    });
    </script>
	
    <script>
    $(document).ready(function() {
        $('#usuario').DataTable({
                responsive: true
        });
    });
    </script-->

	<!--FECHA-->
	<!--script type="text/javascript" src="{{ URL::asset('js/jquery-1.8.3.min.js') }}" charset="UTF-8"></script-->
	<script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
	<script type="text/javascript" src="{{ URL::asset('js/locales/bootstrap-datetimepicker.es.js') }}" charset="UTF-8"></script>
	<script type="text/javascript">
		$('.fecha_reporte1').datetimepicker({
			language:  'es',
			weekStart: 1,
			todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0
		});
		$('.fecha_reporte2').datetimepicker({
			language:  'es',
			weekStart: 1,
			todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0
		});		
	</script>
	<!--FECHA-->
	
	<?php
		if (strpos($_SERVER["REQUEST_URI"],"encuesta/") !== false || strpos($_SERVER["REQUEST_URI"],"iol_alt") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_hl") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_co") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_hi") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_op") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_sl") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_epa") !== false) {
			if (strpos($_SERVER["REQUEST_URI"],"iol_alt") !== false)
				$tipo=1;
			else {
				$ruta=$_SERVER["REQUEST_URI"];
				while (strpos($ruta,"/") !== false)
					$ruta=substr($ruta,strpos($ruta,"/")+1);
				
				$id=$ruta;
				if (strpos($_SERVER["REQUEST_URI"],"encuesta_5") !== false || strpos($_SERVER["REQUEST_URI"],"encuesta_3_") !== false)
					$sql = "select * from autorizaciones where id=".substr($id,strpos($id,"-")+1);
				elseif (strpos($_SERVER["REQUEST_URI"],"prueba_co") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_op") !== false)
					$sql = "select * from autorizaciones where id=".substr($id,0,strpos($id,"-"));
				elseif (strpos($_SERVER["REQUEST_URI"],"_resto") !== false) {
					$id_au=substr($id,strpos($id,"-")+1);
					$id_au=substr($id_au,0,strpos($id_au,"-"));
					$sql = "select * from autorizaciones where id=".$id_au;
				} else
					$sql = "select * from autorizaciones where id=".$id;
				
				//echo $sql;
				$data=DB::select($sql);
				foreach ($data as $data)
					$tipo=$data->id_tipo_prueba;
			}
			$idioma = \App::getLocale();
			
			$ruta_wizard='../js/wizard/jquery.smartWizard_'.$tipo.'.js';
			?>
			   <!-- form wizard -->
			   
			   <script>
					var idioma = '<?php echo $idioma; ?>';
			   </script>
			   <?php if (strpos($_SERVER["REQUEST_URI"],"/encuesta_6_6") !== false) { ?>
				<script type="text/javascript" src="../js/wizard/jquery.smartWizard_7_iep.js"></script>
			   <?php } elseif (strpos($_SERVER["REQUEST_URI"],"prueba_hi_ejemplo") !== false) { ?>
					<script type="text/javascript" src="../js/wizard/jquery.smartWizard_3ejemplo.js"></script>
			   <?php } elseif (strpos($_SERVER["REQUEST_URI"],"prueba_hi") !== false) { ?>
					<script type="text/javascript" src="../js/wizard/jquery.smartWizard_3.js"></script>	
				<?php } elseif (strpos($_SERVER["REQUEST_URI"],"prueba_epa_resto") !== false) { ?>
					<script type="text/javascript" src="../js/wizard/jquery.smartWizard_7.js"></script>
				<?php } elseif ((strpos($_SERVER["REQUEST_URI"],"prueba_co") !== false && strpos($_SERVER["REQUEST_URI"],"-1") !== false) || (strpos($_SERVER["REQUEST_URI"],"sl_ejemplo") !== false || strpos($_SERVER["REQUEST_URI"],"epa_ejemplo") !== false)) { ?>
					<script type="text/javascript" src="../js/wizard/jquery.smartWizard_41.js"></script>
				<?php } elseif (strpos($_SERVER["REQUEST_URI"],"prueba_co") !== false && strpos($_SERVER["REQUEST_URI"],"-2") !== false) { ?>
					<script type="text/javascript" src="../js/wizard/jquery.smartWizard_42.js"></script>	
				<?php } elseif (strpos($_SERVER["REQUEST_URI"],"prueba_op/encuesta") !== false) {
					$tipo=substr($_SERVER["REQUEST_URI"],strpos($_SERVER["REQUEST_URI"],"encuesta_")+9);				
					$tipo=substr($tipo,0,strpos($tipo,"-"));
				?>
					<script type="text/javascript" src="../js/wizard/jquery.smartWizard_<?php echo $tipo; ?>.js"></script>
				<?php } else { ?>
					<script type="text/javascript" src='<?php echo $ruta_wizard; ?>'></script>
				<?php } ?>
				
				<script type="text/javascript">
					$(document).ready(function () {
						// Smart Wizard 	
						$('#wizard').smartWizard();

						function onFinishCallback() {
							$('#wizard').smartWizard('showMessage', 'Finish Clicked');
							//alert('Finish Clicked');
						}
					});
					
					$(document).ready(function () {
						// Smart Wizard 	
						$('#wizard_1').smartWizard();

						function onFinishCallback() {
							$('#wizard_1').smartWizard('showMessage', 'Finish Clicked');
							//alert('Finish Clicked');
						}
					});

					$(document).ready(function () {
						// Smart Wizard 	
						$('#wizard_2').smartWizard();

						function onFinishCallback() {
							$('#wizard_2').smartWizard('showMessage', 'Finish Clicked');
							//alert('Finish Clicked');
						}
					});

					$(document).ready(function () {
						// Smart Wizard 	
						$('#wizard_3').smartWizard();

						function onFinishCallback() {
							$('#wizard_3').smartWizard('showMessage', 'Finish Clicked');
							//alert('Finish Clicked');
						}
					});		

					$(document).ready(function () {
						// Smart Wizard 	
						$('#wizard_4').smartWizard();

						function onFinishCallback() {
							$('#wizard_4').smartWizard('showMessage', 'Finish Clicked');
							//alert('Finish Clicked');
						}
					});	

					$(document).ready(function () {
						// Smart Wizard 	
						$('#wizard_5').smartWizard();

						function onFinishCallback() {
							$('#wizard_5').smartWizard('showMessage', 'Finish Clicked');
							//alert('Finish Clicked');
						}
					});							
				</script>			
			<?php
		}		
			
	?>
	
	<script type="text/javascript">
	$(function() {
		$('input[name="fecha_reporte"]').daterangepicker();
	});
	
	$(document).ready(function() {
		$(".clase").keyup(function() {
			var dInput = this.value;
			var evt = evt || window.event;
			if (soloNumerosCC(dInput)==1) {
				if (evt.keyCode==13) {
					currentTabIndex = document.activeElement.tabIndex;
					currentTabIndex++;
					$("[tabindex='" + (currentTabIndex) + "']").focus();
				}
			} else
				this.value="";
		});
	});
	for (i=0; i<primera.length; i++)
		$("[tabindex='" + (primera[i]) + "']").focus();
	</script>	
<style>

<?php
if (strpos($_SERVER["REQUEST_URI"],"aplicar_encuesta/") !== false) {

	for ($i=0; $i<count($datos_id); $i++) {
		echo "
		#boton_".$datos_id[$i]." .notActive {
			color: #000000;
			background-color: #ffffff;
		}";
	}
?>
</style>

<script>
<?php
	for ($i=0; $i<count($datos_id); $i++) {
		echo "$('#boton_".$datos_id[$i]." a').on('click', function() {
			var sel = $(this).data('title');
			var tog = $(this).data('toggle');
			$('#'+tog).prop('value', sel);
			
			$('a[data-toggle=\"'+tog+'\"]').not('[data-title=\"'+sel+'\"]').removeClass('active').addClass('notActive');
			$('a[data-toggle=\"'+tog+'\"][data-title=\"'+sel+'\"]').removeClass('notActive').addClass('active');
		});";
	}
?>
</script>

<?php } ?>

</body>
</html>