<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div>
		
		<div class='span9'>
			<form action="/pay/planStripeProcess" method="POST">
					<script
				    src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
				    data-key="<?php echo Factory_Payment::public_key('stripe'); ?>"
				    data-amount="<?php echo $plan->price(); ?>"
				    data-name="<?php echo $plan->name(); ?> Plan"
				    data-description="Monthly Subscription"
				    data-image="/128x128.png"
					data-panel-label="Subscribe"
					data-label="Select">
				  </script>
			</form>
		</div><!-- .span9 -->
		
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>

<style type="text/css" media="screen">
</style>