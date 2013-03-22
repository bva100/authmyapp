<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	
	<div class='row'>
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		<div class='span9'>
			
			<?php if ($app): ?>
				<!-- download setup container -->
				<div class='download-setup hide'>
					
					<!-- header -->
					<h2 id='download-setup-title-container'>
						<a id='download-setup-back-button' class="back-button left blue" data-title="Back" href="/downloads?app_id=<?php echo $app->id() ?>"></a>
						<span id='download-setup-title'>Download Setup</span>
					</h2>
					
					<div class='download-setup-body'>
						
						<!-- connect-facebook -->
						<div class='download-setup-form well' id='connect-facebook-setup' data-title='Get The Facebook Signup Button'>
							<?php echo Form::open("downloads/process"); ?>
								<input type="hidden" name="type" value="connect_facebook">
								<input type="hidden" name="app_id" value="<?php echo $app->id() ?>" class='app-id'>
								<div class='row'>
									<p class='span2 offset1'>
										<label for="text">Button Text</label>
										<input type="text" name="text" value="Connect with Facebook" id='facebook-connect-text-input'>
									</p>
									<p class='offset1 span2'>
										<label for="size">Button Size</label>
										<select id='facebook-connect-size-input'>
											<option value="extra-large">Extra Large</option> 
											<option value="large" selected>Large</option>
											<option value="medium">Medium</option>
											<option value="small">Small</option>
										</select>
									</p>
								</div><!-- .row -->
								<div class='row'>
									<?php echo Form::submit("submit", "Get This Button", array('class' => 'btn btn-blue submitter span3')); ?>
								</div><!-- .row -->
							<?php echo Form::close(); ?>
						</div>
						
						<!-- sender -->
						<div class='download-setup-form well' id='sender-setup' data-title='Get The Data Sender'>
							<?php echo Form::open("downloads/process"); ?>
								<input type="hidden" name="type" value="sender">
								<input type="hidden" name="app_id" value="<?php echo $app->id() ?>" class='app-id'>
								<div class='row'>
									HERE ARE THE SETUP OPTIONS
								</div><!-- .row -->
							    <div class='row'>
									<?php echo Form::submit("submit", "Submit"); ?>
								</div>
							<?php echo Form::close(); ?>
							
						</div><!-- .download-setup-form well -->
						
					</div><!-- .download-setup-body -->
					
					<div id='download-setup-results'></div><!-- .download-setup-results -->
					
				</div><!-- .download-setup -->
			<?php endif ?>
				
			<!-- download content container -->
			<div class='download-content'>
					
				<!-- free account block -->
				<?php if ( ! $user->plan()->downloads()): ?>
					
					<div class='well well-unit' id='primary-download-well'>
						<h3>
							Let Us Do The Programming For You
						</h3>
						<p>
							The downloads on this page make it easy to integrate your app or website with AuthMyApp. To get access, you'll need to upgrade your account.
						</p>
						<?php echo HTML::anchor("home/plans", "Upgrade Account", array('class' => 'btn btn-large btn-info', 'id' => 'upgrade-account-cta')) ?>
					</div><!-- .name -->
					
				<?php endif ?>
				
				<!-- app param passed -->
				<?php if ($app): ?>

					<?php if ( $user->plan()->downloads()): ?>
						<!-- intro -->
						<div class='well' id='primary-download-well'>
							<h3>
								The programming has been completed for you
							</h3>
							<p>
								Download each file then click on the help button for step by step instructions
							</p>
						</div><!-- .well -->
					<?php endif ?>

					<!-- get downloads for specific app -->

					<div class='downloads-container' id='downloads-app-container'>
						<div class='downloads-header'>
							<span class='downloads-name'>Downloads for <?php echo $app->name() ?></span>
						</div><!-- .app-header -->
						<div class='downloads-body' id='downloads-app-body'>

							<!-- signup button -->
							<div class='row'>
								<div class='span6'>
									<h3>
										<span class='required'>
											<a href="#" class='btn-downloader link-black' data-open="#connect-facebook-setup">Get Connect Button</a>
										</span>
									</h3>
									<p>
										Let new users signup with a "Connect using Facebook" button
									</p>
									<a href="#see-tutorial-connect-button" data-open='#tutorial-connect-btn' class='tutorial-open-close'>
										Open Tutorial
									</a>
									<div class='tutorial hide' id='tutorial-connect-btn' state='closed'>
										<h5>
											Implementing your "Connect using Facebook" button
										</h5>
										<p>
											Beef tenderloin strip steak t-bone filet mignon. Chicken prosciutto bacon spare ribs capicola salami tenderloin tail corned beef turducken rump ham hock frankfurter tri-tip. Prosciutto tongue turkey, spare ribs ribeye flank frankfurter pork loin drumstick jerky jowl meatloaf rump. Flank ball tip boudin short loin meatball biltong. Ribeye chuck shoulder, venison swine andouille beef.
										</p>
										<p>
											<a href="#close" class='btn tutorial-closer'>Close</a>
										</p>

									</div>
								</div><!-- .span6 -->
								<div class='span2 btn-downloader-container'>
									<?php if ($user->plan()->downloads()): ?>
										<button class="btn btn-info btn-downloader" data-open="#connect-facebook-setup">
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</button>
									<?php else: ?>
										<button class="btn btn-downloader disabled" id='download-button-btn'>
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</button>
									<?php endif ?>
								</div><!-- .span2 -->
							</div><!-- .row -->
							
							<hr />
							
							<!-- sender -->
							<div class='row'>
								<div class='span6'>
									<h3>
										<span class='required'>
											<a href="#" class='btn-downloader link-black' data-open="#sender-setup">Get Direction Sender</a>
										</span>
									</h3>
									<p>
										Allow <?php echo $app->name() ?> to send directions to AuthMyApp
									</p>
									<a href="#see-tutorial-sender" id='see-tutorial-sender-btn' class='tutorial-opener'>
										View Tutorial
									</a>
									<p class='tutorial hide' id='tutorial-connect-btn'>
										Beef tenderloin strip steak t-bone filet mignon. Chicken prosciutto bacon spare ribs capicola salami tenderloin tail corned beef turducken rump ham hock frankfurter tri-tip. Prosciutto tongue turkey, spare ribs ribeye flank frankfurter pork loin drumstick jerky jowl meatloaf rump. Flank ball tip boudin short loin meatball biltong. Ribeye chuck shoulder, venison swine andouille beef.
									</p>
								</div><!-- .span4 -->
								<div class='span2 btn-downloader-container'>
									<?php if ($user->plan()->downloads()): ?>
										<button class="btn btn-info btn-downloader" id='download-sender-btn'>
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</button>
									<?php else: ?>
										<button class="btn btn-downloader disabled" id='download-receiver-btn'>
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</button>
									<?php endif ?>
								</div><!-- .span4 -->
							</div><!-- .row -->
							
							<hr />
							
							<!-- receiver -->
							<div class='row'>
								<div class='span6'>
									<h3>
										<span class='required'>
											<a href="#" class='btn-downloader link-black' data-open="#receiver-setup">Get Data Receiver</a>
										</span>
									</h3>
									<p>
										Allow AuthMyApp to send signup data to <?php echo $app->name() ?>
									</p>
									<a href="#see-tutorial-connect-button" id='see-tutorial-connect-btn' class='tutorial-opener'>
										View Tutorial
									</a>
									<p class='tutorial hide' id='tutorial-connect-btn'>
										Beef tenderloin strip steak t-bone filet mignon. Chicken prosciutto bacon spare ribs capicola salami tenderloin tail corned beef turducken rump ham hock frankfurter tri-tip. Prosciutto tongue turkey, spare ribs ribeye flank frankfurter pork loin drumstick jerky jowl meatloaf rump. Flank ball tip boudin short loin meatball biltong. Ribeye chuck shoulder, venison swine andouille beef.
									</p>
								</div><!-- .span4 -->
								<div class='span2 btn-downloader-container'>
									<?php if ($user->plan()->downloads()): ?>
										<button class="btn btn-info btn-downloader" id='download-receiver-btn'>
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</button>
									<?php else: ?>
										<button class="btn btn-downloader disabled" id='download-receiver-btn'>
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</button>
									<?php endif ?>
								</div><!-- .span4 -->
							</div><!-- .row -->

							<hr />

							<!-- login button -->
							<div class='row'>
								<div class='span6'>
									<h3>
										<span>
											<a href="#" class='btn-downloader link-black' data-open="#connect-facebook-setup">Get Login Button</a>
										</span>
									</h3>
									<p>
										Let returning users login with a "Login using Facebook" button
									</p>
									<div class='tutorial-container'>
										<a href="#see-tutorial-connect-button" data-open='#tutorial-connect-btn' class='tutorial-opener'>
											View Tutorial
										</a>
										<p class='tutorial hide' id='tutorial-connect-btn' state='closed'>
											Beef tenderloin strip steak t-bone filet mignon. Chicken prosciutto bacon spare ribs capicola salami tenderloin tail corned beef turducken rump ham hock frankfurter tri-tip. Prosciutto tongue turkey, spare ribs ribeye flank frankfurter pork loin drumstick jerky jowl meatloaf rump. Flank ball tip boudin short loin meatball biltong. Ribeye chuck shoulder, venison swine andouille beef.
										</p>
									</div><!-- .tutorial-container -->
								</div><!-- .span6 -->
								<div class='span2 btn-downloader-container'>
									<?php if ($user->plan()->downloads()): ?>
										<button class="btn btn-info btn-downloader" id='download-button-btn'>
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</button>
									<?php else: ?>
										<button class="btn btn-downloader disabled" id='download-button-btn'>
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</button>
									<?php endif ?>
								</div><!-- .span2 -->
							</div><!-- .row -->
							
						</div><!-- .app-body -->
					</div><!-- .app-container -->
					
				<?php else: ?>
					<!-- list apps -->
					
				<?php endif ?>
				
			</div><!-- .download-select -->
			
		</div><!-- .span9 -->
	</div><!-- .row -->

</div><!-- .container -->