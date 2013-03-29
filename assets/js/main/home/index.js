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
	
	$(".index-app-container").click(function(event) {
		$(this).siblings().find('.index-app-body').slideUp();
		$(this).find('.index-app-body').slideDown();
	});
	
});
