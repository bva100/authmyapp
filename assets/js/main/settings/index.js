$(document).ready(function() {
	var appId = $(".app-id").text();
	var failed = 'Your request cannot be completed at this time. Please try again soon.';
	
	$("#facebook-app-form-help").popover({
		'title': 'Customize Facebook Dialog',
		'content': 'To add your own brand\'s image, title and description, enter your Facebook app id and Facebook app secret here. If you don\'t have a Facebook app, we can make one for you. See below.',
		'trigger': 'hover',
		'placement': 'left',
		'container': 'body',
	});
	
	$("#update-secret").click(function(event) {
		event.preventDefault();
		var answer = redownload();
		if (answer) {
			$.post('/settings/updateAppSecret', {app_id: appId}, function(data, textStatus, xhr) {
				if (textStatus === 'success') {
					$("#app-secret").text(data);
				}else{
					alert(failed);
				}
			});
		};
	});
	
});

// redownload confirm
function redownload() {
	var answer = confirm("After changing you'll have to update (download from AuthMyApp then re-upload to your server) your data receiver and directions sender scripts. Are you sure you want to proceed?")
	if (answer){
		return(true)
	}else{
		return(false)
	}
}


