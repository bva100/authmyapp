<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div id='primary-wrapper'>
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
				
				<?php if (count($user->apps()) === 0): ?>
					
					<div class='row'>
						<div class='span9'>
							<div class='no-apps-container well'>
								<h2>
									Welcome to Auth-My-App
								</h2>
								<p>
									We will now walk you through the steps to add your first app or website
								</p>
								<hr />
								<?php echo HTML::anchor("/home/addApp", "Add an app or website", array('class' => 'btn btn-large btn-blue')) ?>
							</div>
						</div>
					</div>
					
				<?php else: ?>
					
					<!-- apps -->
					<div class='row'>
						<div class='span9'>
							<div class='apps'>
								<?php foreach ($user->apps() as $app): ?>
									<div class='app-container'>
										<div class='row'>
											<div class='app-header span9'>
												<span class='app-name'><?php echo $app->name() ?></span>
											</div>
										</div><!-- .row -->
										<div class='row'>
											<div class='app-body span9'>
												<div class='row'>
													<div class='span3'>
														<?php if ($app->state() === Model_App::STATE_PAUSED): ?>
															<a href="/home/settingsProcessAppState?app_id=<?php echo $app->id() ?>&state=active" class='btn btn-block clearfix'>
																<span class='app-btn-text pull-left'>Now Paused</span>
																<img src="/assets/img/pause.png" width="21" height="32" class='app-btn-img pull-right'>
															</a>
														<?php else: ?>
															<a href="/home/settingsProcessAppState?app_id=<?php echo $app->id() ?>&state=paused" class='btn btn-block clearfix'>
																<span class='app-btn-text pull-left'>Now Active</span>
																<img src="/assets/img/play.png" width="36" height="36" class='app-btn-img pull-right'>
															</a>
														<?php endif ?>
													</div><!-- .span3 -->
													<div class='span3'>
														<a href="/downloads?app_id=<?php echo $app->id() ?>" class='btn btn-block clearfix'>
															<span class='app-btn-text pull-left'>Downloads</span>
															<img src="/assets/img/download_file.png" width="36" height="36" class='app-btn-img pull-right'>
														</a>
													</div>
													<div class='span3'>
														<a href="#dialog" class='btn btn-block clearfix'>
															<span class='app-btn-text pull-left'>Customize</span>
															<img src="/assets/img/facebook.png" width="36" height="36" class='app-btn-img pull-right'>
														</a>
													</div>
												</div><!-- .row -->
												<div class='row'>
													<div class='span3'>
														<a href="/help" class='btn btn-block clearfix'>
															<span class='app-btn-text pull-left'>Get Help</span>
															<img src="/assets/img/question.png" width="36" height="36" class='app-btn-img pull-right'>
														</a>
													</div>
													<div class='span3'>
														<a href="/home/settings?app_id=<?php echo $app->id() ?>" class='btn btn-block clearfix'>
															<span class='app-btn-text pull-left'>Settings</span>
															<img src="assets/img/cogs.png" width="36" height="36" class='app-btn-img pull-right'>
														</a>
													</div>
													<div class='span3'>
														<a href="/analyze" class='btn btn-block clearfix'>
															<span class='app-btn-text pull-left'>Analytics</span>
															<img src="/assets/img/graph_pie.png" width="36" height="36" class='app-btn-img pull-right'>
														</a>
													</div><!-- .span3 -->
												</div><!-- .row -->
											</div>
										</div><!-- .row -->
									</div>
								<?php endforeach ?>
							</div><!-- .app -->
						</div><!-- .span9 -->
					</div><!-- .row -->
					
				<?php endif ?>
				
			</div><!-- .span9 -->
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .wrapper -->