<?php defined('SYSPATH') or die('No direct script access.');
?>

<div class='container container-signup hide'>
	<div class='row'>
		<div class='span12'>
			<div class='hero-unit'>
				<h1>
					Redirecting to Facebook
				</h1>
				<p>
			 		We are now re-directing you towards Facebook to simplify your sign up process.
				</p>
				<img src="/assets/img/loading.gif" width="58" height="58" alt="Loading" id='signup-loader'>
				<div class='signup_security_code' data-security-code="<?php echo $security_code ?>"></div><!-- .hide -->
			</div><!-- .hero-unit -->
		</div><!-- .span10 offset1 -->
	</div><!-- .row -->
</div><!-- .container -->

<style type="text/css" media="screen">
	.container-signup {
		margin-top: 70px;
		text-align: center;
	}
	.container-signup p {
		padding-top: 20px;
		padding-bottom: 20px;
		font-size: 22px;
		font-weight: 490;
	}
</style>