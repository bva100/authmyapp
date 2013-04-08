<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div>
		
		<div class='span9'>
			<div id="preapprove"></div>
		</div><!-- .span9 -->
		
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>

<!-- wepay iframe -->
<script type="text/javascript" src="https://www.wepay.com/js/iframe.wepay.js"></script>
<script type="text/javascript">
    WePay.iframe_checkout("preapprove", "<?php echo $response->preapproval_uri; ?>");
</script>