var stepOneComplete = false;
var stepTwoComplete = false;

// fb init
window.fbAsyncInit = function() {
	// Additional initialization code such as adding Event Listeners goes here
	FB.Event.subscribe('edge.create',
		function(response) {
			stepTwoComplete = true;
			$(".modal-facebook-done-header").fadeIn();
			$("#facebook-container .tile").addClass('completed').find('.btn').text('Completed');
		}
	);
};
// Load fb SDK
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&cookie=1&appId=164712480350937";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// dom ready
$(document).ready(function() {
	
	// on fb-like click
	$("#facebook-done").click(function(event) {
		$("#modal-facebook").modal('hide');
	});
	
	// on tweet, complete twitter tile
	$(".tweet").click(function(event) {
		stepOneComplete = true;
		$("#twitter-container .tile").addClass('completed').find('.btn').text('Completed');
		$("#modal-twitter-error").modal('hide');
	});
	
	// on facebook try again, close current modal and open facebook modal
	$(".facebook-try-again").click(function(event) {
		event.preventDefault();
		$("#modal-facebook-error").modal('hide');
		$("#modal-facebook").modal('show');
	});
	
	// get coupon
	$(".get-coupon").click(function(event) {
		event.preventDefault();
		var coupon_token = $(".coupon-token").text();
		
		// ensure tweet was tweeted
		if ( ! stepOneComplete) {
			$("#modal-twitter-error").modal('show');
			return 0;
		};
		
		// ensure fanpage was liked
		if( ! stepTwoComplete) {
			$("#modal-facebook-error").modal('show');
			return 0;
		}
	
		// in the future, ideally, we can validate with an ajax call to ensure that user follows @authmyapp and liked the fanpage here
		
		// produce code
		$.get('/coupon/getCode', {type: 'first_month_high', coupon_token: coupon_token }, function(data, textStatus, xhr) {
			if (textStatus === 'success' && data) {
				$(".get-coupon").fadeOut('fast', function(){
					$(".coupon-container").fadeIn();
					$("#input-coupon").val(data).focus().select();
				})
			}else{
				alert('Invalid, please try again');
			}
		});
		
	});
	
	$("#test").click(function(event) {
		event.preventDefault();
				var coupon_token = $(".coupon-token").text();
				alert(coupon_token);
		$.get('/coupon/getCode', {type: 'first_month_high', coupon_token: coupon_token }, function(data, textStatus, xhr) {
			if (textStatus === 'success' && data) {
				alert(data);
				$(".get-coupon").fadeOut('fast', function(){
					$(".coupon-container").fadeIn();
					$("#input-coupon").val(data).focus().select();
				})
			}else{
				alert('Invalid, please try again');
			}
		});
	});
	
});


