<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		<div class='span9'>
			
			<?php if (isset($alert)): ?>
				<div class='row'>
					<div class='span9'>
						<?php echo $alert ?>
					</div><!-- .span9 -->
				</div><!-- .row -->
			<?php endif ?>
			
			<div class='well well-unit'>
				<legend>
					My Organizations
				</legend>
				<p>
					<?php foreach ($user->organizations() as $org): ?>
						
						<?php if ($org->name()): ?>
							
							<strong><?php echo $org->name() ?></strong>
							<?php foreach ($org->apps() as $app): ?>
								<ul>
									<li><?php echo $app->name() ?> <a href="/settings/app?app_id=<?php echo $app->id() ?>#basic-info">change</a></li>
								</ul>
							<?php endforeach ?>
							<br />
						<?php endif ?>
						
					<?php endforeach ?>
				</p>
				<legend id='create-new-org'>
					Add a New Organization To Your Account
				</legend>
				<p>
					<?php echo Form::open("/home/addNewOrganizationProcess"); ?>
						<label for="organization_name" id='new-org-label'>Organization Name</label><input type="text" name="name" value="" id="new-organization" placeholder='Brand New Organization, Inc'>
						
						<?php echo Form::submit("submit", "Add Organization", array('class' => 'btn btn-blue', 'id' => 'submit-new-org')); ?>
					<?php echo Form::close(); ?>
				</p>
			</div><!-- .well well-unit -->
			
		</div><!-- .span9 -->
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>