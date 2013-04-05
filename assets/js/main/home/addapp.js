$(document).ready(function() {
	
	$("#submit-addapp").click(function(event) {
		var name        = $("#inputName").val();
		var domain      = $("#inputDomain").val();
		var org         = $('input[name=organization]:checked', '#new-app-form').val();
		var new_org     = $("#new-org-name").val();
		var postAuthUrl = $("#inputPostAuthUrl").val();
		var senderUri   = $("#inputSenderUri").val();
		var receiverUri = $("#inputReceiverUri").val();
		
		// validate
		if ( ! name) {
			event.preventDefault();
			alert('Please enter a name for your app or website');
			$("#inputName").focus();
			return(0);
		};
		if ( ! domain) {
			event.preventDefault();
			alert('Please enter the domain assoicated with your app or website');
			$("#inputDomain").focus();
			return(0);
		}
		if ( ! valid_url(domain) ) {
			// attempt to append http:// to string
			var domain = 'http://' + domain;
			$("#inputDomain").val(domain);
			// re check validity
			if ( ! valid_url(domain)) {
				event.preventDefault();
				alert('That domain doesn\'t look quite right. Please try again.');
				$("#inputDomain").focus();
				return(0);
			};
		};
		if ( postAuthUrl && ! valid_url(postAuthUrl) ) {
			// attempt to append http:// to string
			var postAuthUrl = 'http://' + postAuthUrl;
			// set new val to dom element
			$("#inputPostAuthUrl").val(postAuthUrl);
			// re-check
			if ( ! valid_url(postAuthUrl)) {
				event.preventDefault();
				alert('That redirect URL doesn\'t look quite right. Please ensure you are entering a valid URL.');
				$("#inputPostAuthUrl").focus();
				return(0);
			};
		};
		if ( postAuthUrl.indexOf(domain) == -1 ) {
			event.preventDefault();
			alert('Your redirect URL must belong to your domain. For example, if my redirect url is www.barkingdoggiedog.com/welcome, my domain must be www.barkingdoggiedog.com');
			$("#inputPostAuthUrl").val(domain + '/').focus();
			return(0);
		};
		if ( ! ama_compliant(postAuthUrl)) {
			event.preventDefault();
			alert('Your redirect URL cannot contain "AuthMyApp" ');
			$("#inputPostAuthUrl").focus();
			return(0);
		};
		if ( senderUri.charAt(0) !== '/') {
			var senderUri = '/' + senderUri;
			$('#inputSenderUri').val(senderUri);
		};
		if ( ! ama_compliant(senderUri)) {
			event.preventDefault();
			alert('Your sender uri cannot contain "AuthMyApp" ');
			$("#inputSenderUri").focus();
			return(0);
		};
		if (receiverUri.charAt(0) !== '/') {
			var receiverUri = '/' + receiverUri;
			$("#inputReceiverUri").val(receiverUri);
		};
		if ( ! ama_compliant(receiverUri)) {
			event.preventDefault();
			alert('Your receiver uri cannot contain "AuthMyApp" ');
			$("#inputReceiverUri").focus();
			return(0);
		};
	});
	
	$("#help-post-auth-url").popover({
			'title': 'Where Should We Send Them Next?',
			'content': 'Type in the URL of the page you\'d like to send the user to after they\'ve successfully signed up using Facebook Connect. Feel free to skip this step if you are unsure.',
			'trigger': 'hover',
		});
	
});

function ama_compliant (str) {
	str = str.toLowerCase();
	if (str.indexOf('authmyapp') !== -1) {
		return false;
	}else{
		return true;
	}
}

function valid_url (url) {
	if(url.indexOf('.') === -1)
	{
		return false;
	}
	else if(/^([a-z]([a-z]|\d|\+|-|\.)*):(\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?((\[(|(v[\da-f]{1,}\.(([a-z]|\d|-|\.|_|~)|[!\$&'\(\)\*\+,;=]|:)+))\])|((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=])*)(:\d*)?)(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*|(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)){0})(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url)) {
		return true;
	} else {
		return false;
	}
}
