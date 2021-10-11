@include('layout.header_encuesta')
		<br /><br /><br />
		<div class='alert alert-info' align="center">
			<img src="{{ URL::asset('imagenes/app.gif') }}">
			<br /><br />
		
			<strong>{{ trans('iol_test.estimada') }}  {{ trans('iol_test.sr') }}. <?=$candidato?>, 
			<br /><br />{{ trans('iol_test.gracias') }}
			<br /><br />{{ trans('iol_test.texto3') }}</strong>
		</div>
@include('layout.footer_encuesta')