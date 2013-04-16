<?php defined('SYSPATH') or die('No direct script access.');
?>

<div id="footer">
	<?php echo HTML::anchor("http://blog.authmyapp.com", "blog", array('target' => 'blank')) ?>
	<?php echo HTML::anchor("http://blog.authmyapp.com/faqs", "faq", array('target' => 'blank')) ?>
	<?php echo HTML::anchor("welcome/pricing", "pricing") ?>
	<?php echo HTML::anchor("help", "help") ?>
	<?php echo HTML::mailto('hello@authmyapp.com', 'contact us', array('target' => '_blank')) ?>
	<a href="http://www.facebook.com/authmyapp">
		<img src="/assets/img/facebook.png" width="25" height="25" alt="Facebook" class='footer-social-btn' id='facebook-social-btn'>
	</a>
	<a href="http://www.twitter.com/authmyapp">
		<img src="/assets/img/twitter.png" width="25" height="25" alt="Twitter" class='footer-social-btn' id='twitter-social-btn'>
	</a>
</div>

<?php if (strpos(Kohana_Request::detect_uri(), 'welcome') !== FALSE): ?>
	<style type="text/css" media="screen">
		#footer {
			width: 100%;
			text-align: center;
			padding: 30px 0px;
			box-shadow: inset 0 0 20px #aaa;
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
<?php else: ?>
	<style type="text/css" media="screen">
		#footer {
			position: relative;
			bottom: 0px;
			border-top: 1px solid #cccccc;
			width: 100%;
			margin-top: 60px;
			text-align: center;
			padding: 10px 0px;
		}
		#footer a {
			font-size: 14px;
			padding: 20px;
			text-align: center;
		}
		.footer-social-btn {
			margin-top: 2px;
			width: 16px;
			height: 16px;
		}
		.footer-social-btn {
			position: absolute;
			top: 12px;
			margin-left: 5px;
			margin-bottom: 4px;
		}
	</style>
<?php endif ?>
<style type="text/css" media="screen">
	.footer-social-btn:hover {
		text-decoration: none;
		/*drop shadow*/
		-moz-box-shadow: 0px 2px 2px 1px #888;
		-webkit-box-shadow: 0px 2px 2px 1px #888;
		box-shadow: 0px 0px 10px 4px #ccc;
	}
</style>