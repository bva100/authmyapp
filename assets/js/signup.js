$(".signup").click(function(event) {
	event.preventDefault();
	$('.container').siblings().fadeOut('fast', function() {
		$('.container-signup').hide().fadeIn('fast');
	});
});