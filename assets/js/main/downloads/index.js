$(document).ready(function() {
	
	$(".tutorial-open-close").click(function(event) {
		event.preventDefault();
		var $tutorial = $( $(this).attr('data-open') );
		var state     = $tutorial.attr('state');
		tutorialOpenClose($tutorial, state);
		tutorialOpenCloseText( $(this), state);
	});
	
	$(".tutorial-closer").click(function(event) {
		event.preventDefault();
		var $tutorial = $(this).parents('.tutorial');
		tutorialOpenClose($tutorial, 'opened');
	});
	
	$(".btn-downloader").click(function(event) {
		event.preventDefault();
		var $toOpen = $( $(this).attr('data-open') );
		downloadSetupShow($toOpen);
	});
	
	$("#download-setup-back-button").click(function(event) {
		event.preventDefault();
		downloadSetupHide();
	});
	
	$("#connect-facebook-setup .submitter").click(function(event) {
		event.preventDefault();
		var text = $('#facebook-connect-text-input').val();
		var size = $("#facebook-connect-size-input").val();
		var appId = $('.app-id').val();
		
		$.post('/downloads/process', {type: 'connect_facebook_button', text: text, size: size, app_id: appId}, function(data, textStatus, xhr) {
			if (textStatus === 'success' && data) {
				$("#download-setup-results").hide().html(data).fadeIn();
			};
		});
		
	});
	
});

function downloadSetupShow ($toOpen) {
	// set vars
	$('#download-setup-title').text($toOpen.attr('data-title'));
	
	// hide siblings
	$toOpen.siblings().hide();
	
	// animate
	$('.download-content').fadeOut(function() {
		$('.download-setup').fadeIn(function() {
			$toOpen.fadeIn();
		});
	})
}

function downloadSetupHide () {
	$(".download-setup").fadeOut(function () {
		$(".download-content").fadeIn();
	})
}

function tutorialOpenClose ($tutorial, state) {
	if (state === 'opened') {
		// close it
		$tutorial.slideUp();
		$tutorial.attr('state', 'closed');
	}else{
		// open it
		$tutorial.slideDown();
		$tutorial.attr('state', 'opened');
	}
}

function tutorialOpenCloseText ($openClose, state) {
	if (state === 'opened') {
		$openClose.text('Open Tutorial');
	}else{
		$openClose.text('Close Tutorial');
	}
}