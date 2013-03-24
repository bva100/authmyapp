<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div id="new-app-primary-wrapper">
	<div class='container'>
		<div class='row'>
			<div class='span10 offset1'>
				<div class='new-app'>
					<div class='row'>
						<div class='span10' id='new-app-header'>
							<h2>Add a New App or a New Website</h2>
						</div><!-- .span12 -->
					</div><!-- .row -->
					
					<div class='row'>
						<div class='span4 offset3' id='new-app-form'>

							<?php echo Form::open("home/addappProcess", array('class' => 'form')); ?>

								<legend>
									Basics
								</legend>

								<div class="control-group">
									<label class="control-label" for="inputName">Name</label>
									<div class="controls">
										<input type="text" id="inputName" placeholder="Name" name='name'>
									</div>
									<label class="control-label" for="inputDomain">Domain</label>
									<div class="controls">
										<input type="text" id="inputDomain" placeholder="www.mywebsite.com" name='domain'>
									</div>
								</div>

								<legend>
									Organization
								</legend>
								<div class='control-group'>
									<?php foreach ($user->organizations() as $org): ?>
										<?php if ($org->name()): ?>
											<input type="radio" name="organization" id="radio-label-org-<?php echo $org->id() ?>" value="<?php echo $org->id() ?>" class='radio-selector'>
											<label for="radio-label-org-<?php echo $org->id() ?>" class='radio-label'>
												<?php echo $org->name() ?>
											</label>
										<?php endif ?>
									<?php endforeach ?>
									<input type="radio" name="organization" id="new-org" value="0" class='radio-selector' checked>
									<label for="new-org" class='radio-label'>
										<input type="text" id="new-org-name" placeholder="Type a new organization's name" name='newOrganization'>
									</label>
								</div><!-- .control-group -->

								<legend>
									Optional Nerdy Stuff
								</legend>

								<label class="control-label" for="inputUri">Redirect Uri for Signups</label>
								<div class="controls">
									<input type="text" id="inputUri" placeholder="/authMyAppReceiver" name='uri'>
								</div>

								<p class='submitter'>
									<?php echo Form::submit("submit", "Create It", array('class' => 'btn btn-blue btn-large btn-block', 'id' => 'submit-addapp')); ?>
								</p>
							<?php echo Form::close(); ?>

						</div><!-- .span4 -->
					</div><!-- .row -->
				</div><!-- .no-apps-container -->
			</div><!-- .span12 -->
		</div><!-- .row -->
	</div><!-- .container -->
</div>