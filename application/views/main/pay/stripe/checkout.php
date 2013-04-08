<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div>
		
		<div class='span9'>
			<form action="" method="POST">
			  <script
			    src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
			    data-key="<?php echo Factory_Payment::public_key('stripe'); ?>"
			    data-amount="2000"
			    data-name="Demo Site"
			    data-description="2 widgets ($20.00)"
			    data-image="/128x128.png">
			  </script>
			</form>
		</div><!-- .span9 -->
		
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>