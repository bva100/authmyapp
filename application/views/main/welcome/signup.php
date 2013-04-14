<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='login-wrapper'>
	<div class='container' id='primary-container'>
		<div class='row'>
			
			<!-- signup container -->
			<div class='span6 offset3 well' id='signup-container'>
				<h3>Get Started With AuthMyApp</h3>
				<p>
					We use Facebook Connect to simplify your signup experience. Click on the button below to get started.
				</p>
				<hr />
				<p id='signup-button-container'>
					<?php echo HTML::anchor("connect_facebook?app_id=1&security_code=".$security_code.'&connect_version='.Controller_Api_Abstract::CONNECT_VERSION, 
					"Connect with Facebook", 
					array('class' => 'btn btn-facebook btn-cta ')) ?>
				</p>
			</div>
			
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .login-wrapper -->