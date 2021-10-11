@include('layout.header_encuesta')
		<br /><br /><br />
		<div class='alert alert-info' align="center">
			<img src="{{ URL::asset('imagenes/app.gif') }}">
			<br /><br />
			<strong>{{ trans('iol_test.estimada') }} {{ trans('iol_test.sr') }}. <?=$candidato?>, <br /><br />
			<?php if ($perfil=="Invalido") { ?>
				<br /><br />{{ trans('iol_test.gracias') }}<br />
					{{ trans('iol_test.texto1') }}
					<br />	 
					{{ trans('iol_test.texto2') }}
					<a href='aplicar_encuesta_iol_alt/<?php echo $id_au; ?>' style='color:red; font-size:11pt'>{{ trans('iol_test.link') }}.</a>
			<?php  } else { ?>
				<br /><br />{{ trans('iol_test.texto3') }}</strong>
			<?php } ?>		
		</div>
@include('layout.footer_encuesta')