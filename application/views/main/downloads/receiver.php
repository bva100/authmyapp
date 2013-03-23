<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		
		<div class='span9'>
			
			<div class='row'>
				
				<div class='download-setup-body span9'>
					
					<!-- header -->
					<div class='row'>
						
						<div class='download-header'>
							
							<div class='span2'>
								<a href="/downloads/sender?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>&type=<?php echo $type ?>" class='btn btn-small pull-left'>
									<img src="/assets/img/left_small.png" width="6" height="10">
									Previous Step
								</a>
							</div><!-- .span2 -->
							
							<div class='span5 download-header-text' style='text-align: center'>
								<h4>
									Step Three: Sign Up Receiver
								</h4>
							</div>
							
							<div class='span2'>
								<a href="/downloads?app_id<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>" class='btn btn-small pull-right'>
									Complete
									<img src="/assets/img/right_small.png" width="6" height="10">
								</a>
							</div>
							
						</div>
						
					</div><!-- .row -->
					
					<hr class='no-style'/>
					
					<!-- forms -->
					<div class='row'>
						<div class='span9'>
							<div class='download-setup-form well well-unit' id='sender-setup'>
								<h5>
									After installing this file, AuthMyApp will be able to send sign up data to <?php echo $app->name() ?>.
								</h5>
								<p class='do-not-share'>
									<span class="label label-important">Warning</span> This file contains a secret code which is unique to <?php echo $app->name() ?>. For security purposes, it is important that you do not share this file with others.
								</p>
								<?php echo Form::open("downloads/process"); ?>
									<input type="hidden" name="type" value="sender">
									<input type="hidden" name="app_id" value="<?php echo $app->id() ?>" class='app-id'>
									<hr />
									<?php echo Form::submit("submit", "Download Data Receiver", array('class' => 'btn btn-blue submitter')); ?>
								<?php echo Form::close(); ?>
							</div>
						</div>
					</div>
					
					<!-- download setup results -->
					<div id='results-container' class='hide'>
						<div class='row'>
							<div class='span9'>
								<div id='download-setup-results'></div><!-- .download-setup-results -->
								<div id="download-setup-results-receiver"></div>
							</div>
						</div>
						<div class='row'>
							<div class='span9'>
								<a href="/downloads/receiver?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>" class='btn btn-large pull-right'>
									Proceed to Next Step
									<img src="/assets/img/right_small.png" width="6" height="10">
								</a>
							</div>
						</div>
					</div><!-- .name -->
					
				</div>
			</div><!-- .row -->
			
		</div><!-- .span9 -->
		
	</div><!-- .row -->
	
</div><!-- .container -->