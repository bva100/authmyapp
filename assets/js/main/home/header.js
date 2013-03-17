$(document).ready(function() {
	$("#header-profile").click(function(event) {
		event.preventDefault();
		var $menu = $("#header-pulldown-container").find('.menu-pulldown');
		var state = $menu.attr('state');
		if (state === 'closed') {
			$('.menu-pulldown-arrow').show();
			$menu.slideDown(160);
			$menu.attr('state', 'open');
		}
	});
	$('html').mouseup(function (e)
	{
	    var $menu = $("#header-pulldown-container").find('.menu-pulldown');
		var state = $menu.attr('state');
	    if ($menu.has(e.target).length === 0 && state === 'open')
		{
			$('.menu-pulldown-arrow').hide();
			$menu.hide();
			$menu.attr('state', 'closed');
	    }
	});
});