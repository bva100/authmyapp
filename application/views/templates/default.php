<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width" />
	<meta name="apple-mobile-web-app-capable" content="yes" />

	<title><?php echo $title ?></title>
	<meta name="description" content="<?php echo $meta_description ?>" />
	<meta name="copyright" content="<?php echo $meta_copywrite ?>">
	<link rel="shortcut icon" href="<?php echo $favicon ?>" type='image/x-icon'/>
	<link rel="apple-touch-icon" href="<?php echo $apple_touch_icon ?>">
	
	<meta property="og:title" content="<?php echo $fb_title ?>" />
	<meta property="og:type" content="<?php echo $fb_type ?>" />
	<meta property="og:url" content="<?php echo $fb_url ?>" />
	<meta property="og:description" content="<?php echo $fb_description ?>" />
	<meta property="og:image" content="<?php echo $fb_img ?>" />
	<meta property="og:site_name" content="<?php echo $fb_site_name ?>" />
	<meta property="fb:app_id" content="<?php echo $fb_app_id  ?>" />
	
	<?php if (isset($stylesheets)): ?>
		<?php foreach ($stylesheets as $stylesheet): ?>
			<?php echo HTML::style($stylesheet); ?>
		<?php endforeach ?>
	<?php endif ?>
	
</head>
<body>
	
	<?php if (isset($content)): ?>
		<?php echo $content ?>
	<?php endif ?>
	
</body>
</html>

<!--[if lt IE 9]>
  <script>
    document.createElement("header" );
    document.createElement("footer" );
    document.createElement("section"); 
    document.createElement("aside"  );
    document.createElement("nav"    );
    document.createElement("article"); 
    document.createElement("hgroup" ); 
    document.createElement("time"   );
  </script>
  <noscript>
     <strong>Warning !</strong>
     Because your browser does not support HTML5, some elements are simulated using JScript.
     Unfortunately your browser has disabled scripting. Please enable it in order to display this page.
  </noscript>
<![endif]-->

<?php if (isset($scripts)): ?>
	<?php foreach ($scripts as $script): ?>
		<?php echo HTML::script($script) ?>
	<?php endforeach ?>
<?php endif ?>
