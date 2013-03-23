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
						
						<!-- sender -->
						<div class='download-setup-form well well-unit' id='sender-setup' data-title='Get The Directions Sender'>
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
						</div><!-- .download-setup-form well -->
						
						<!-- receiver -->
						<div class='download-setup-form well well-unit' id='receiver-setup' data-title='Get The Directions Sender'>
							<h5>
								After installing this file, AuthMyApp will be able to send sign up data to <?php echo $app->name() ?>
							</h5>
							<p class='do-not-share'>
								<span class="label label-important">Warning</span> This file contains a secret code which is unique to <?php echo $app->name() ?>. For security purposes, it is important that you do not share this file with others.
							</p>
							<?php echo Form::open("downloads/process"); ?>
								<input type="hidden" name="type" value="receiver">
								<input type="hidden" name="app_id" value="<?php echo $app->id() ?>" class='app-id'>
								<hr />
								<?php echo Form::submit("submit", "Download Data Receiver", array('class' => 'btn btn-blue submitter')); ?>
							<?php echo Form::close(); ?>
						</div><!-- .download-setup-form well -->
						
						
					</div><!-- .download-setup-body -->
					
					<div id='download-setup-results' class='hide'></div><!-- .download-setup-results -->
					
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
									<a href="#see-tutorial-connect-button" data-open='#tutorial-connect-facebook' class='tutorial-open-close'>
										View Instructions
									</a>
									<div class='tutorial hide' id='tutorial-connect-facebook' state='closed'>
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
									<a href="#see-tutorial-sender" data-open='#tutorial-sender' class='tutorial-open-close'>
										View Instructions
									</a>
									<div class='tutorial hide' id='tutorial-sender' state='closed'>
										<div classs='tutorial-body' id='tutorial-sender-body'>
											<h5>
												Installing Your "Directions Sender"
											</h5>
											<ol>
												<li>
													Unzip the .zip file which you'll receive after clicking the download button. Typically unzipping can be accomplished by double clicking on the downloaded file
												</li>
												<li>
													Locate the folder called "<?php echo $app->sender_uri() ?>"
												</li>
												<li>
													<p>
														Upload the entire <?php echo $app->sender_uri() ?> folder and the facebook.php file it contains to <?php echo $app->name() ?>. It should be placed in the <?php echo HTML::anchor("http://en.wikipedia.org/wiki/Root_directory", "root directory", array('target' => '_blank')) ?>. Uploading can be accomplished using FTP and we recommend <?php echo HTML::anchor("http://filezilla-project.org/", "FireZilla", array('target' => 'blank')) ?>
													</p>
													<p class='step-by-step'>
														<strong>Use GoDaddy?</strong> Find step by step upload instructions <?php echo HTML::anchor("http://support.godaddy.com/help/article/3239/uploading-files-using-the-ftp-file-manager?locale=en", "here", array('target' => '_blank')) ?>
														<br />
														<strong>Use WordPress?</strong> Find step by step upload instructions <?php echo HTML::anchor("http://codex.wordpress.org/FTP_Clients", "here", array('target' => '_blank')) ?>
													</p>
												</li>
											</ol>
										</div>
										<p>
											<a href="#close" class='btn tutorial-closer'>Close</a>
										</p>
									</div><!-- .tutorial hide -->
								</div><!-- .span4 -->
								<div class='span2 btn-downloader-container'>
									<?php if ($user->plan()->downloads()): ?>
										<button class="btn btn-info btn-downloader" data-open="#sender-setup">
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
										Allow AuthMyApp to send sign up data to <?php echo $app->name() ?>
									</p>
									<a href="#see-tutorial-connect-button" data-open="#tutorial-receiver" class='tutorial-open-close'>
										View Tutorial
									</a>
									<div class='tutorial hide' id='tutorial-receiver' state='closed'>
										<div classs='tutorial-body' id='tutorial-receiver-body'>
											<h5>
												Installing Your "Data Receiver"
											</h5>
											<ol>
												<li>
													Unzip the .zip file which you'll receive after clicking the download button. Typically unzipping can be accomplished by double clicking on the downloaded file
												</li>
												<li>
													Locate the folder called "<?php echo $app->receiver_uri() ?>"
												</li>
												<li>
													<p>
														Upload the entire <?php echo $app->receiver_uri() ?> folder and the facebook.php file it contains to <?php echo $app->name() ?>. It should be placed in the <?php echo HTML::anchor("http://en.wikipedia.org/wiki/Root_directory", "root directory", array('target' => '_blank')) ?>. Uploading can be accomplished using FTP and we recommend <?php echo HTML::anchor("http://filezilla-project.org/", "FireZilla", array('target' => 'blank')) ?>
													</p>
													<p class='step-by-step'>
														<strong>Use GoDaddy?</strong> Find step by step upload instructions <?php echo HTML::anchor("http://support.godaddy.com/help/article/3239/uploading-files-using-the-ftp-file-manager?locale=en", "here", array('target' => '_blank')) ?>
														<br />
														<strong>Use WordPress?</strong> Find step by step upload instructions <?php echo HTML::anchor("http://codex.wordpress.org/FTP_Clients", "here", array('target' => '_blank')) ?>
													</p>
												</li>
											</ol>
										</div>
										<p>
											<a href="#close" class='btn tutorial-closer'>Close</a>
										</p>
									</div><!-- .tutorial hide -->
								</div><!-- .span4 -->
								<div class='span2 btn-downloader-container'>
									<?php if ($user->plan()->downloads()): ?>
										<button class="btn btn-info btn-downloader" data-open='#receiver-setup'>
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