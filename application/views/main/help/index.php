<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div>
		
		<div class='span9'>
			<div class='well'>
				<h3>AuthMyApp Help</h3>
				<p>
					You'll find all of the implementation help you'll need here. Use the sidebar to the left to find a topic. If you have more questions, we'd be happy to help. Please <?php echo HTML::mailto('hello@authmyapp.com?Subject=I need some help!', 'shoot us an email', array('target' => '_blank')) ?> or checkout the <?php echo HTML::anchor("blog.authmyap.com/faq", "FAQ") ?>.
				</p>
			</div><!-- .hero-unit -->
		</div>
		
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>