<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div id='primary-wrapper'>
	<div class='container' id='primary-container'>
		<div class='row'>
			<div class='span3'>
				<?php echo $sidebar ?>
			</div><!-- .span3 -->
			<div class='span9'>
				
				<?php if (count($user->apps()) === 0): ?>
					
					<div class='no-apps-container well'>
						<h2>
							Welcome to Auth-My-App
						</h2>
						<p>
							We will now walk you through the steps to add your first app or website
						</p>
						<hr />
						<?php echo HTML::anchor("/home/addApp", "Add an app or website", array('class' => 'btn btn-large btn-blue')) ?>
					</div><!-- .no-apps-container -->
					
				<?php else: ?>
					
					<!-- apps -->
					<div class='apps'>
						<?php foreach ($user->apps() as $app): ?>
							<div class='app-container'>
								<div class='app-header'>
									<span class='app-name'><?php echo $app->name() ?></span>
								</div>
								<div class='app-body'>
									<p>
										best app ever!
									</p>
								</div>
							</div>
						<?php endforeach ?>
					</div><!-- .app -->
					
				<?php endif ?>
				
			</div><!-- .span10 -->
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .wrapper -->