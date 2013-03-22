<?php defined('SYSPATH') or die('No direct script access.');
?>

<div class='container container-signup hide'>
	<div class='row'>
		<div class='span12'>
			<h2>
				Create your Auth-My-App account
			</h2>
			<?php echo HTML::anchor('connect_facebook?app_id=1&security_code='.$security_code.'&connect_version='.Controller_Api::CONNECT_VERSION, "Signup using Facebook", array('class' => 'btn btn-facebook btn-large btn-cta')) ?>
		</div><!-- .span10 offset1 -->
	</div><!-- .row -->
</div><!-- .container -->

<style type="text/css" media="screen">
	body {
		background-image:url('/assets/img/checkboxes.png');
	}
	.container-signup {
		margin-top: 150px;
		text-align: center;
	}
	.container-signup h2 {
		margin-bottom: 40px;
	}
</style>