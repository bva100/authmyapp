<?php defined('SYSPATH') or die('No direct script access.');
?>

<div id="footer">
	<?php echo HTML::anchor("faq", "faq") ?>
	<?php echo HTML::anchor("fees", "fees") ?>
	<?php echo HTML::anchor("http://blog.authmyapp.com", "blog") ?>
	<?php echo HTML::anchor("help", "help") ?>
	<a href="http://www.facebook.com/authmyapp">
		<img src="/assets/img/facebook.png" width="25" height="25" alt="Facebook" class='footer-social-btn'>
	</a>
	<a href="http://www.twitter.com/authmyapp">
		<img src="/assets/img/twitter.png" width="25" height="25" alt="Twitter" class='footer-social-btn'>
	</a>
</div>

<style type="text/css" media="screen">
	#footer {
		width: 100%;
		text-align: center;
		padding: 30px 0px;
		box-shadow:inset 0 0 20px #aaa;
	}
	#footer a {
		font-size: 18px;
		padding: 20px;
		text-align: center;
	}
	.footer-social-btn {
		margin-left: 5px;
		margin-bottom: 4px;
	}
</style>