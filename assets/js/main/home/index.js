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
		var type = $(this).attr('id');
		$("#download-options-modal").modal('show');
		
		switch (type){
			case 'download-button-btn':
				$("#download-button-modal-body").show();
				break;
			default:
				alert('download not available at this time');
		}
		
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
		$openClose.text('Open Tutorial');
	}else{
		$openClose.text('Close Tutorial');
	}
}