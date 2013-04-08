$(document).ready(function() {
	var appId = $(".app-id").text();
	var failed = 'Your request cannot be completed at this time. Please try again soon.';
	var facebookAppId = $("#facebook-app-id").text();
	
	// onload
	if ( ! facebookAppId) {
		$("#update-facebook-app, #create-facebook-app").hide();
		$("#facebook-app-prompter").show();
	};
	
	$("#facebook-app-prompter-help").popover({
		'title': 'Not Sure About This One?',
		'content': 'Then you most likely do not have a Facebook App and we recommend that your click the "No, I Don\'t have A Facebook App" button.',
		'trigger': 'hover',
		'placement': 'top',
		'container': 'body',
	});
	
	$("#facebook-app-form-help").popover({
		'title': 'Customize Facebook Dialog',
		'content': 'To add your own brand\'s image, title and description, enter your Facebook app id and Facebook app secret here. If you don\'t have a Facebook app, we can make one for you. Click the link below.',
		'trigger': 'hover',
		'placement': 'left',
		'container': 'body',
	});
	
	$("#have-facebook-app").click(function(event) {
		event.preventDefault();
		$("#facebook-app-prompter").fadeOut('fast', function(){
			$("#update-facebook-app").fadeIn('fast');
		});
	});
	
	$("#do-not-have-facebook-app").click(function(event) {
		event.preventDefault();
		$("#facebook-app-prompter").fadeOut('fast', function(){
			$("#create-facebook-app").fadeIn('fast');
		})
	});
	
	$("#make-one-for-me, #redo-make-one-for-me").click(function(event) {
		event.preventDefault();
		$("#update-facebook-app").fadeOut('fast', function(){
			$("#create-facebook-app").fadeIn('fast');
		})
	});
	
	$("#update-access-token").click(function(event) {
		event.preventDefault();
		var answer = redownload();
		if (answer) {
			$.post('/settings/updateAppAccessToken', {app_id: appId}, function(data, textStatus, xhr) {
				if (textStatus === 'success') {
					$("#access-token").text(data);
				}else{
					alert(failed);
				}
			});
		};
	});
	
});

// redownload confirm
function redownload() {
	var answer = confirm("After changing you'll have to update your data receiver and directions sender scripts. To do this, you'll have to re-download these files from AuthMyApp then re-upload them to your server. Are you sure you want to proceed?")
	if (answer){
		return(true)
	}else{
		event.preventDefault();
		return(false)
	}
}


