<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width" />
	<meta name="apple-mobile-web-app-capable" content="yes" />

	<title>404 | AuthMyApp </title>
	
	<?php echo HTML::style('/assets/css/bootstrap/bootstrap.min.css') ?>
	<?php echo HTML::style('/assets/css/errors/index.css') ?>
	
</head>
<body>
	
	<div class='container-fluid' id='primary-container'>
		<div class='row-fluid'>
			<div class='hero-unit'>
				<h1>404 Not Found!</h1>
				<img src="/assets/img/dude1_confused_compressed.png" width="406" height="406">
				<p id='message'>
					<?php echo $message ?>
				</p>
					<a href="/welcome" class='btn btn-large btn-blue btn-block'>Return Home</a>
				</p>
				<p>
					<?php echo HTML::mailto("hello@authmyapp.com?subject=404_".urlencode($message), "Contact Us", array('class' => 'btn btn-large btn-block', 'target' => '_blank')) ?>
				</p>
			</div><!-- .hero-unit -->
		</div><!-- .row -->
	</div><!-- .container -->
	
</body>
</html>