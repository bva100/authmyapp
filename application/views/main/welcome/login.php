<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>
	
<div class='login-wrapper'>
	<div class='container' id='primary-container'>
		<div class='row'>
			
			<!-- login container -->
			<div class='span6 offset3 well' id='login-container'>
				<h3>Login to AuthMyApp</h3>
				<p>
				</p>
				<hr />
				<p>
					<?php echo HTML::anchor("connect_facebook?app_id=1&security_code=".$security_code.'&connect_version='.Controller_Api_Abstract::CONNECT_VERSION, 
					"Login with Facebook", 
					array('class' => 'btn btn-facebook btn-cta')) ?>
				</p>	
			</div><!-- .span4 offset4 -->
		</div><!-- .row -->
	</div><!-- .container -->
	
</div><!-- .login-wrapper -->
