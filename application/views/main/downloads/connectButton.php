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
							
							<div class='span5 offset2 download-header-text' style='text-align: center'>
								<?php if ($type === 'connect_facebook'): ?>
									<h4>
										Step One: Facebook Connect Button
									</h4>
								<?php endif ?>
							</div>
							
							<div class='span2'>
								<?php if ($type === 'connect_facebook'): ?>
									<a href="/downloads/sender?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>&type=<?php echo $type ?>" class='btn btn-small pull-right'>
										Next Step
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
							<?php if ($type === 'connect_facebook'): ?>
								<div class='download-setup-form well' id='connect-button-setup'>
									<?php echo Form::open("downloads/process"); ?>
										<input type="hidden" name="type" value="receiver" id='type-input'>
										<input type="hidden" name="app_id" value="<?php echo $app->id() ?>" class='app-id'>
										<div class='row'>
											<p class='span2 offset1'>
												<label for="text">Button Text</label>
												<input type="text" name="text" value="Connect with Facebook" id='text-input'>
											</p>
											<p class='offset1 span2'>
												<label for="size">Button Size</label>
												<select id='size-input'>
													<option value="extra-large">Extra Large</option> 
													<option value="large" selected>Large</option>
													<option value="medium">Medium</option>
													<option value="small">Small</option>
												</select>
											</p>
										</div><!-- .row -->
										<div class='row'>
											<?php echo Form::submit("submit", "Preview Signup Button", array('class' => 'btn btn-blue submitter span3')); ?>
										</div><!-- .row -->
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
							</div>
						</div>
						<div class='row'>
							<div class='span9'>
								<a href="/downloads/sender?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>&type=<?php echo $type ?>" class='btn btn-large pull-right'>
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