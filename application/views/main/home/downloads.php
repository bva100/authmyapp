<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	
	<?php if ($message AND $message_type): ?>
		<div class="alert alert-<?php echo $message_type?> hide">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<span class="alert-text"><?php echo $message ?></span>
		</div>
	<?php endif ?>
	
	<div class='row'>
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		<div class='span9'>
			
			<?php if ( ! $app): ?>
				
				<h3>sell things!</h3>
				
			<?php else: ?>
				
				<?php echo $app->name() ?>
				
			<?php endif ?>
			
			
			
		</div><!-- .span9 -->
	</div><!-- .row -->
</div><!-- .container -->