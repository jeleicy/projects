<script src="datatables/js/jquery-1.12.3.js"></script>

<script type="text/javascript">
	function startTimer() {
		var timer = duration, minutes, seconds;
		var duration=60 * 1;
		
		setInterval(function () {
			minutes = parseInt(timer / 60, 10)
			seconds = parseInt(timer % 60, 10);

			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			$('#time').text(minutes + ":" + seconds);

			if (--timer < 0) {
				timer = duration;
			}
			
			if (timer==60) {
				alert("tiempo culminado !!!")
		}, 1000);
	}

	jQuery(function ($) {
		var fiveMinutes = 60 * 1,
			display = $('#time');
		startTimer(fiveMinutes, display);
	});

</script>

<body>
    <div>Registration closes in <span id="time">01:00</span> minutes!</div>
</body>
