    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <!--script src="{{ URL::asset('js/jquery.js') }}"></script-->

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	
	<!-- daterangepicker -->
	<script type="text/javascript" src="{{ URL::asset('js/moment.min2.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/datepicker/daterangepicker.js') }}"></script>
	
    <!-- form wizard -->
    <script type="text/javascript" src="{{ URL::asset('js/wizard/jquery.smartWizard.js') }}"></script>
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
		
</body>

</html>
