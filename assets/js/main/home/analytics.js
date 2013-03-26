$(document).ready(function() {
	var appId = $("#app-id").text();
	
	// on dom ready
	$("#chart-signups").fadeIn( function(){
		drawSignupsChart(appId);
		updateSignupCounter(appId, 30);
	});
	$("#chart-logins").fadeIn(function(){
		drawLoginsChart(appId);
		updateLoginCounter(appId, 30);
	})
	$("#signups-days-ago").focus();
	
	// methods
	$("#update-signups-chart").click(function(event) {
		event.preventDefault();
		var daysAgo = $("#signups-days-ago").val();
		drawSignupsChart(appId, daysAgo);
		updateSignupCounter(appId, daysAgo);
	});
	
	$("#signups-days-ago").focus(function(event) {
		$(document).keypress(function(e) {
			if(e.which == 13) {
				var daysAgo = $("#signups-days-ago").val();
				drawSignupsChart(appId, daysAgo);
				updateSignupCounter(appId, daysAgo);
			}
		});
	});
	
	$("#update-logins-chart").click(function(event) {
		event.preventDefault();
		var daysAgo = $("#logins-days-ago").val();
		drawLoginsChart(appId, daysAgo)
		updateLoginCounter(appId, daysAgo);
	});
	
	$("#logins-days-ago").focus(function(event) {
		$(document).keypress(function(e) {
			if(e.which == 13) {
				var daysAgo = $("#logins-days-ago").val();
				drawLoginsChart(appId, daysAgo);
				updateLoginCounter(appId, daysAgo);
			}
		});
	});
	
});

function updateLoginCounter (appId, daysAgo) {
	$.get('/home/getAppAnalytics', {app_id: appId, days_ago: daysAgo, type: 'login_counter'}, function(data, textStatus, xhr) {
		$("#login-counter").hide().text(data).fadeIn();
	});
}

function updateSignupCounter (appId, daysAgo) {
	$.get('/home/getAppAnalytics', {app_id: appId, days_ago: daysAgo, type: 'signup_counter'}, function(data, textStatus, xhr) {
		$("#signup-counter").hide().text(data).fadeIn();
	});
}

function drawSignupsChart (appId, daysAgo) {
	
	$("#chart-signups").empty();
	
	$.get('/home/getAppAnalytics', {app_id: appId, days_ago: daysAgo, type: 'signups', format: 'json'}, function(data, textStatus, xhr) {
		var signupArray = $.parseJSON( data ) ;
		
		// draw
		$.jqplot('chart-signups',  [ signupArray ], { 
			animate: true,
			series:[
				{shadowDepth: 1.5, color:'#0088cc'}
			],
			axes:{
				xaxis:{
					label:'Days ',
					labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
					labelOptions: {
						fontFamily: 'Gotham, helvetica, sans-serif',
						fontSize: '12pt'
					}
				},
				yaxis:{
					label:'Signups ',
					labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
					labelOptions: {
						fontFamily: 'Gotham, helvetica, sans-serif',
						fontSize: '12pt'
					}
				}
			},
			grid:{
				gridLineColor: '#ddd',
				background: '#f9f9f9',
				borderWidth: 1.0, 
				borderColor: '#f9f9f9',
				shadow: false,
			}
		});
	});
}

function drawLoginsChart (appId, daysAgo) {
	
	$("#chart-logins").empty();
	
	$.get('/home/getAppAnalytics', {app_id: appId, days_ago: daysAgo, type: 'logins', format: 'json'}, function(data, textStatus, xhr) {
		var loginArray = $.parseJSON( data ) ;
		
		// draw
		$.jqplot('chart-logins',  [ loginArray ], { 
			animate: true,
			series:[
				{shadowDepth: 1.5, color:'#0088cc'}
			],
			axes:{
				xaxis:{
					label:'Days ',
					labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
					labelOptions: {
						fontFamily: 'Gotham, helvetica, sans-serif',
						fontSize: '12pt'
					}
				},
				yaxis:{
					label:'Logins ',
					labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
					labelOptions: {
						fontFamily: 'Gotham, helvetica, sans-serif',
						fontSize: '12pt'
					}
				}
			},
			grid:{
				gridLineColor: '#ddd',
				background: '#f9f9f9',
				borderWidth: 1.0, 
				borderColor: '#f9f9f9',
				shadow: false,
			}
		});
	});
}