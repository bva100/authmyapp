<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		
		<div class='span9'>
			
			<div class='well'>
				<h3 id="select-app-title">
					View Analytics for Which App or Website?
				</h3>
			</div><!-- .well well-unit -->
			
			<?php foreach ($user->apps() as $app): ?>
				<div class='app-container analytics-app-container'>
					<div class='app-header analytics-app-header'>
						<span class='app-name analytics-app-name'>
							<?php echo HTML::anchor("home/analytics?app_id=".$app->id(), $app->name()) ?>
						</span>
					</div>
				</div>
			<?php endforeach ?>
			
		</div><!-- .span9 -->
		
	</div><!-- .row -->
</div><!-- .container -->