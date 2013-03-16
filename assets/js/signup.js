$(".signup").click(function(event) {
	event.preventDefault();
	var security_code = $(".signup_security_code").attr('data-security-code');	
	
	$('.container').siblings().fadeOut('fast', function() {
		$('.container-signup').hide().fadeIn( function() {
			setTimeout( function() {
				window.location.href = '/connect_facebook?app_id=1&dao_type=kohana&v=1&security_code=' + security_code;
			}, 2000 );
		});
	});
});