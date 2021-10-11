		
        </div>		
        <!-- /#page-content -->
		
    </div>
    <!-- /#wrapper -->		
	
    <!-- jQuery -->
    <script src="{{ URL::asset('bp/bower_components/jquery/dist/jquery.min.js') }}"></script>

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
	
	

	<?php 
	if (strpos($_SERVER["REQUEST_URI"],"buscar_candidato") !== false) { ?>
		<script class="init">
			$( document ).ready(function() {
				for (i=1; i<cant_tablas; i++) {
					$('#tabla_reportes_'+i).DataTable({
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
				}
			});
		</script>
	<?php
	}
	?>
		
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
		if (strpos($_SERVER["REQUEST_URI"],"encuesta/") !== false || strpos($_SERVER["REQUEST_URI"],"iol_alt") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_hl") !== false || strpos($_SERVER["REQUEST_URI"],"prueba_co") !== false) {
			if (strpos($_SERVER["REQUEST_URI"],"iol_alt") !== false)
				$tipo=1;
			else {
				$id=substr($_SERVER["REQUEST_URI"],strlen($_SERVER["REQUEST_URI"])-1);
				$sql = "select * from autorizaciones where id=".$id;
				$data=DB::select($sql);
				foreach ($data as $data)
					$tipo=$data->id_tipo_prueba;
			}
			?>
			   <!-- form wizard -->
				<script type="text/javascript" src="../js/wizard/jquery.smartWizard_<?php echo $tipo; ?>.js"></script>
				<script type="text/javascript">
					$(document).ready(function () {
						// Smart Wizard 	
						$('#wizard').smartWizard();

						function onFinishCallback() {
							$('#wizard').smartWizard('showMessage', 'Finish Clicked');
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
	</script>
	
    <!-- form validation -->
    <script src="{{ URL::asset('js/validator/validator.js') }}"></script>
    <script>
        // initialize the validator function
        validator.message['date'] = 'not a real date';
        validator.message['number'] = 'not a real number';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select.required', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required')
            .on('keyup blur', 'input', function () {
                validator.checkField.apply($(this).siblings().last()[0]);
            });

        // bind the validation to the form submit event
        $('#send').click('submit');//.prop('disabled', true);

        $('form').submit(function (e) {
            e.preventDefault();
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit) {
				//this.submit();
				return false;
            }                        //
        });
</script>	

<script>
	$(document).ready(function() {
		$("#tipo_campo").change(function() {
			var valor_campo = $("#tipo_campo").val();
			if (valor_campo.indexOf("SELECCION")>-1)
				document.getElementById("valores_tipo_campo").style.display = "inline";
			else
				document.getElementById("valores_tipo_campo").style.display = "none";
		});
	});
</script>

	<!--funciones-->
	<script src="{{ URL::asset('js/funciones.js') }}"></script>
</body>

</html>