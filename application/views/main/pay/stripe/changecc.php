<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		<div class='span12 offset0'>
			<div class='hero-unit' style='text-align: center; margin-top: 20px'>
				<h3>Update Your Credit Card</h3>
				<p>
					If there was an issue with a payment, you can update your credit card or add a new one here.
				</p>
				<form action="/pay/changeStripeCcProcess" method="post" style='margin: 15px 0px'>
					<input type="hidden" name="token" value="<?php echo $token ?>" id="token">
					<script src="https://checkout.stripe.com/v2/checkout.js" 
						class="stripe-button"
						data-key="<?php echo $pk ?>"
						data-name="AuthMyApp"
						data-description="Update Credit Card"
						data-image="/assets/img/logo_circle_extra_small.png"
						data-panel-label="Update"
						data-label="Update Credit Card Information">
					</script>
				</form>
			</div><!-- .hero-unit -->
		</div><!-- .span4 offset34 -->
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>