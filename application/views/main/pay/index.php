<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		
		<div class='span9'>
			<div id='checkout'>
				<script type="text/javascript" src="https://www.wepay.com/min/js/iframe.wepay.js">
				</script>
			</div><!-- .checkout -->
		</div><!-- .span9 -->
		
	</div><!-- .row -->
</div><!-- .container -->

<script type="text/javascript">
    WePay.iframe_checkout("checkout", "<?php echo $response->checkout_uri ?>");
</script>