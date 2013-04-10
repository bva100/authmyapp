$(document).ready(function() {
	
	$("#change-to-active-state").popover({
		'title': 'Make Active',
		'content': 'Click this button to activate your app or website.',
		'trigger': 'hover',
		'placement': 'left',
	});
	$("#change-to-paused-state").popover({
		'title': 'Pause It',
		'content': 'Click this button to pause signups. Use pause when your app or website is under construction.',
		'trigger': 'hover',
		'placement': 'left',
	});
	$("#facebook-customize").popover({
		'title': 'Customize Facebook Dialog',
		'content': 'Add your brand\'s picture, title and description to the Facebook dialog box. This dialog box appears after users click the "Connect with Facebook" button on your app or website.',
		'trigger': 'hover',
		'placement': 'left',
	});
	
	// on DOM ready, hide all but first
	$(".index-app-container .app-body:not(:first)").hide();
	$(".index-app-container .app-header:first").css('border-bottom', '1px solid #dddddd')
	
	$(".index-app-container").click(function(event) {
		$(this).siblings().find('.index-app-body').slideUp();
		$(this).siblings().find('.app-header').css('border-bottom', 'none');
		$(this).find('.index-app-body').slideDown();
		$(this).find('.app-header').css('border-bottom', '1px solid #dddddd');
	});
	
});

$(".btn-plan-cancel").click(function(event) {
	var results = cancelPlanConfirm();
	if ( ! results) {
		event.preventDefault();
	};
});

$("#add-coupon").click(function(event) {
	event.preventDefault();
	var coupon_code = $("#input-coupon-code").val();
	if ( ! coupon_code || coupon_code.length < 1 ) {
		return false;
	}
	// check if coupon is valid stripe coupon
	$.post('/pay/validateStripeCoupon', {coupon_code: coupon_code}, function(data, textStatus, xhr) {
		alert(data);
	});
	
	
});

// confirm plan cancellation
function cancelPlanConfirm() {
	var answer = confirm("This action will cancel your subscription. Are you sure you wish to proceed?");
	if (answer){
		return(true);
	}
	else
	{
		return(false);
		event.preventDefault();
	}
}