<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	
	<div class='row'>
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		<div class='span9'>
				
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
								Download each file then, if needed, view step by step instructions
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
											<a href="/downloads/connectButton?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>&type=connect_facebook" class='btn-downloader link-black'>Get Connect Button</a>
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
										<ol>
											<li>
												Click on the blue download button to the right
											</li>
											<li>
												Edit the size and text of your login button
											</li>
											<li>
												Click preview. A preview of the button as well as a grey box of html code appears
											</li>
											<li>
												Add this html (iframe) to your webpage by copying and pasting
											</li>
										</ol>
										<p>
											<a href="#close" class='btn tutorial-closer'>Close</a>
										</p>
									</div>
								</div><!-- .span6 -->
								<div class='span2 btn-downloader-container'>
									<?php if ($user->plan()->downloads()): ?>
										<a href="/downloads/connectButton?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>&type=connect_facebook" class="btn btn-info btn-downloader" data-open="#connect-facebook-setup">
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</a>
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
											<a href="/downloads/sender?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>&type=facebook" class='btn-downloader link-black'>Get Direction Sender</a>
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
														Upload the entire <?php echo $app->sender_uri() ?> folder and the facebook.php file it contains to <?php echo $app->name() ?>. It should be placed in your <?php echo HTML::anchor("http://en.wikipedia.org/wiki/Root_directory", "root directory", array('target' => '_blank')) ?>. Uploading can be accomplished using FTP and we recommend <?php echo HTML::anchor("http://filezilla-project.org/", "FireZilla", array('target' => 'blank')) ?>
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
										<a href="/downloads/sender?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>&type=facebook" class="btn btn-info btn-downloader" data-open="#sender-setup">
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</a>
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
											<a href="/downloads/connectButton?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>" class='btn-downloader link-black'>Get Data Receiver</a>
										</span>
									</h3>
									<p>
										Allow AuthMyApp to send sign up data to <?php echo $app->name() ?>
									</p>
									<a href="#see-tutorial-connect-button" data-open="#tutorial-receiver" class='tutorial-open-close'>
										View Instructions
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
														Upload the entire <?php echo $app->receiver_uri() ?> folder and the Index.php file it contains to <?php echo $app->name() ?>. It should be placed in your <?php echo HTML::anchor("http://en.wikipedia.org/wiki/Root_directory", "root directory", array('target' => '_blank')) ?>. Uploading can be accomplished using FTP and we recommend <?php echo HTML::anchor("http://filezilla-project.org/", "FireZilla", array('target' => 'blank')) ?>
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
										<a href="/downloads/receiver?app_id=<?php echo $app->id() ?>&new_app=<?php echo $new_app ?>&type=facebook" class="btn btn-info btn-downloader" data-open='#receiver-setup'>
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</a>
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
											<a href="/downloads/connectButton?app_id=<?php echo $app->id() ?>&type=login_facebook" class='btn-downloader link-black'>Get Login Button</a>
										</span>
									</h3>
									<p>
										Let returning users login with a "Login using Facebook" button
									</p>
									<div class='tutorial-container'>
										<a href="#see-tutorial-connect-button" data-open="#tutorial-login-facebook" class='tutorial-open-close'>
											View Instructions
										</a>
										<div class='tutorial hide' id='tutorial-login-facebook' state='closed'>
											<div classs='tutorial-body' id='tutorial-login-body'>
												<h5>
													Implementing your "Login with Facebook" button
												</h5>
												<ol>
													<li>
														Click on the blue download button to the right
													</li>
													<li>
														Edit the size and text of your login button
													</li>
													<li>
														Click preview. A preview of the button as well as a grey box of html code appears
													</li>
													<li>
														Add this html (iframe) to your webpage by copying and pasting
													</li>
												</ol>
												<p>
													<a href="#close" class='btn tutorial-closer'>Close</a>
												</p>
											</div>
										</div>
									</div><!-- .tutorial-container -->
								</div><!-- .span6 -->
								<div class='span2 btn-downloader-container'>
									<?php if ($user->plan()->downloads()): ?>
										<a href="/downloads/connectButton?app_id=<?php echo $app->id() ?>&type=login_facebook" class="btn btn-info btn-downloader" id='download-button-btn'>
											<img src="/assets/img/download_file.png" width="45" height="45" alt="Download" class='download-file'>
										</a>
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
					
					<div class='well'>
						<h3 id="select-app-title">
							Select an App or Website
						</h3>
					</div><!-- .well well-unit -->
					
					<?php foreach ($user->apps() as $app): ?>
						<div class='app-container'>
							<div class='app-header'>
								<span class='app-name'>
									<?php echo HTML::anchor("/downloads?app_id=".$app->id(), $app->name()) ?>
								</span>
							</div>
						</div>
					<?php endforeach ?>
					
				<?php endif ?>
				
			</div><!-- .download-select -->
			
		</div><!-- .span9 -->
	</div><!-- .row -->

</div><!-- .container -->

<?php echo $footer ?>