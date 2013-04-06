$(document).ready(function() {
	
	$('select').selectpicker();
	
	$("#download-setup-results-sender").show(function(){
		var appId = $('.app-id').val();
		$("#download-setup-results-sender").load('/downloads?app_id=' + appId + ' #tutorial-sender-body');
	});
	
	$("#download-setup-results-receiver").show(function(){
		var appId = $('.app-id').val();
		$("#download-setup-results-receiver").load('/downloads?app_id=' + appId + ' #tutorial-receiver-body');
	});
	
	$(".tutorial-open-close").click(function(event) {
		event.preventDefault();
		var $tutorial = $( $(this).attr('data-open') );
		var state     = $tutorial.attr('state');
		tutorialOpenCloseText( $(this), state);
		tutorialOpenClose($tutorial, state);
	});
	
	$(".tutorial-closer").click(function(event) {
		event.preventDefault();
		var $tutorial = $(this).parents('.tutorial');
		var $openClose = $tutorial.siblings('.tutorial-open-close');
		tutorialOpenCloseText($openClose, 'opened');
		tutorialOpenClose($tutorial, 'opened');
	});
	
	$("#connect-button-setup .submitter, #login-button-setup .submitter").click(function(event) {
		event.preventDefault();
		var type = $("#type-input").val();
		var text = $('#text-input').val();
		var size = $("#size-input").val();
		var appId = $('.app-id').val();
		
		$.post('/downloads/process', {type: type, text: text, size: size, app_id: appId}, function(data, textStatus, xhr) {
			if (textStatus === 'success' && data) {
				$("#download-setup-results").html(data);
				$("#results-container").fadeIn();
			}else
			{
				alert('Your request cannot be completed at this time. Please try again soon');
			}
		});
	});
	
	$("#sender-setup .submitter").click(function(event) {
		$("#results-container").fadeIn('slow');
	});
	
	$("#receiver-setup .submitter").click(function(event) {
		$("#results-container").fadeIn('slow');
	});
	
});

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
		//close it then display text
		$openClose.text('View Instructions');
	}else{
		// open it then display text
		$openClose.text('Hide Instructions');
	}
}