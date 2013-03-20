<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php if ($app): ?>
	<div class="modal hide fade" id="download-options-modal">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">×</a>
			<h3>Download Options</h3>
		</div>
		<div class="modal-body hide" id='download-button-modal-body'>
			<p>
				<?php echo Form::open("home/downloadsProcess"); ?>
					<input type="hidden" name="type" value="connect_facebook">
					<input type="hidden" name="app_id" value="<?php echo $app->id() ?>">
					<label for="text">Text</label><input type="text" name="text" value="Connect with Facebook">
				    <p><?php echo Form::submit("submit", "Download", array('class' => 'btn btn-blue')); ?></p>
				<?php echo Form::close(); ?>
			</p>
		</div>
		<div class="modal-body hide" id='download-receiver-modal-body'>
			<p>
				receiver
			</p>
		</div>
		<div class="modal-body hide" id='download-login-button-modal-body'>
			<p>
				logins
			</p>
		</div>
	</div>
<?php endif ?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	
	<div class='row'>
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		<div class='span9'>
			
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
									<span class='required'>Connect Button</span>
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
						
						<hr />
						
						<!-- receiver -->
						<div class='row'>
							<div class='span6'>
								<h3>
									<span class='required'>Data Receiver</span>
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
									Login Button
								</h3>
								<p>
									Let new users login with a "Login using Facebook" button
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
						
						<hr />
						
						<!-- db creator -->
						<div class='row'>
							<div class='span6'>
								<h3>
									Database Creator
								</h3>
								<p>
									Automatically create a new database with an AuthMyApp user table
								</p>
								<a href="#see-tutorial-connect-button" id='see-tutorial-connect-btn' class='tutorial-opener'>
									View Tutorial
								</a>
								<p class='tutorial hide' id='tutorial-connect-btn'>
									Beef tenderloin strip steak t-bone filet mignon. Chicken prosciutto bacon spare ribs capicola salami tenderloin tail corned beef turducken rump ham hock frankfurter tri-tip. Prosciutto tongue turkey, spare ribs ribeye flank frankfurter pork loin drumstick jerky jowl meatloaf rump. Flank ball tip boudin short loin meatball biltong. Ribeye chuck shoulder, venison swine andouille beef.
								</p>
							</div><!-- .span6 -->
							<div class='span2 btn-downloader-container'>
								<?php if ($user->plan()->downloads()): ?>
									<button class="btn btn-info btn-downloader" id='download-db-btn'>
										<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
									</button>
								<?php else: ?>
									<button class="btn btn-downloader disabled" id='download-db-btn'>
										<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
									</button>
								<?php endif ?>
							</div><!-- .span2 -->
						</div><!-- .row -->
						
						<hr />
						
						<!-- user session -->
						<div class='row'>
							<div class='span6'>
								<h3>
									Session Manager
								</h3>
								<p>
									Download to manage your user's session after logging in
								</p>
								<a href="#see-tutorial-connect-button" id='see-tutorial-connect-btn' class='tutorial-opener'>
									View Tutorial
								</a>
								<p class='tutorial hide' id='tutorial-connect-btn'>
									Beef tenderloin strip steak t-bone filet mignon. Chicken prosciutto bacon spare ribs capicola salami tenderloin tail corned beef turducken rump ham hock frankfurter tri-tip. Prosciutto tongue turkey, spare ribs ribeye flank frankfurter pork loin drumstick jerky jowl meatloaf rump. Flank ball tip boudin short loin meatball biltong. Ribeye chuck shoulder, venison swine andouille beef.
								</p>
							</div><!-- .span6 -->
							<div class='span2 btn-downloader-container'>
								<?php if ($user->plan()->downloads()): ?>
									<button class="btn btn-info btn-downloader" id='download-session-btn'>
										<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
									</button>
								<?php else: ?>
									<button class="btn btn-downloader disabled" id='download-session-btn'>
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
			
		</div><!-- .span9 -->
	</div><!-- .row -->
</div><!-- .container -->