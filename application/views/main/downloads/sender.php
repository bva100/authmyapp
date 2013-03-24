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
								<?php if ( ! $new_app ): ?>
									<a href="/downloads?app_id=<?php echo $app->id() ?>" class='btn btn-small pull-left'>
										<img src="/assets/img/notes_small.png" width="12" height="15" class='note-img'> 
										Back to Menu
									</a>
								<?php else: ?>
									<?php if ($type === 'facebook'): ?>
										<a href="/downloads/connectButton?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>&type=connect_facebook" class='btn btn-small pull-left'>
											<img src="/assets/img/left_small.png" width="6" height="10">
											Previous Step
										</a>	
									<?php endif ?>
								<?php endif ?>
							</div><!-- .span2 -->
							
							<div class='span5 download-header-text' style='text-align: center'>
								<?php if ($type === 'facebook'): ?>
									<h4>
										Step Two: Directions Sender
									</h4>
								<?php endif ?>
							</div>
							
							<div class='span2'>
								<?php if ($type === 'facebook'): ?>
									<a href="/downloads/receiver?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>" class='btn btn-small pull-right'>
										Next Step: Receiver
										<img src="/assets/img/right_small.png" width="6" height="10">
									</a>	
								<?php endif ?>
							</div>
							
						</div>
						
					</div><!-- .row -->
					
					<hr class='no-style'/>
					
					<!-- forms -->
					<div class='row'>
						<div class='span9'>
							<!-- connect-facebook -->
							<?php if ($type === 'facebook'): ?>
								<div class='download-setup-form well well-unit' id='sender-setup'>
									<h5>
										After installing this file, <?php echo $app->name() ?> will be able to send directions to AuthMyApp.
									</h5>
									<p class='do-not-share'>
										<span class="label label-important">Warning</span> This file contains a secret code which is unique to <?php echo $app->name() ?>. For security purposes, it is important that you do not share this file with others.
									</p>
									<?php echo Form::open("downloads/process"); ?>
										<input type="hidden" name="type" value="sender">
										<input type="hidden" name="app_id" value="<?php echo $app->id() ?>" class='app-id'>
										<hr />
										<?php echo Form::submit("submit", "Download Directions Sender", array('class' => 'btn btn-blue submitter')); ?>
									<?php echo Form::close(); ?>
								</div>
							<?php endif ?>
						</div><!-- .span9 -->
					</div><!-- .row -->
					
					<!-- download setup results -->
					<div id='results-container' class='hide'>
						<div class='row'>
							<div class='span9'>
								<div id='download-setup-results'></div><!-- .download-setup-results -->
								<div id="download-setup-results-sender"></div>
							</div>
						</div>
						<div class='row'>
							<div class='span9'>
								<a href="/downloads/receiver?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>" class='btn pull-right'>
									Proceed to Next Step: receiver
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