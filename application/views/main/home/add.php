<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		<div class='span12'>
			<div class='new-app well'>
				<div class='row'>
					<div class='span12'>
						<h2>Add a New App or a New Website</h2>
					</div><!-- .span12 -->
				</div><!-- .row -->
				
				<hr />
				
				<div class='row'>
					<div class='span4 offset4'>
						
						<?php echo Form::open("home/addProcess", array('class' => 'form-vertical')); ?>
							
							<legend>
								Basics
							</legend>
							
							<div class="control-group">
								<label class="control-label" for="inputEmail">Name</label>
								<div class="controls">
									<input type="text" id="inputEmail" placeholder="Name">
								</div>
								<label class="control-label" for="inputDomain">Domain</label>
								<div class="controls">
									<input type="text" id="inputDomain" placeholder="www.mywebsite.com">
								</div>
							</div>
							
							<legend>
								Organization
							</legend>
							
							<div class='control-group'>
								<?php foreach ($user->organizations() as $org): ?>
									<div class='control-group'>
										<label class='radio'>
											here
										</label>
										<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
									</div><!-- .control-group -->
								<?php endforeach ?>
							</div><!-- .control-group -->
							
							<legend>
								Optional Nerdy Stuff
							</legend>
							
							<label class="control-label" for="inputUri">Redirect Uri</label>
							<div class="controls">
								<input type="text" id="inputUri" placeholder="/authMyAppReceiver">
							</div>
							
							
						<?php echo Form::close(); ?>
						
					</div><!-- .span4 -->
				</div><!-- .row -->
			</div><!-- .no-apps-container -->
		</div><!-- .span12 -->
	</div><!-- .row -->
</div><!-- .container -->