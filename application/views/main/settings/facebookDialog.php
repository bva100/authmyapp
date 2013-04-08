<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div>
		
		<div class='span9'>
			
			<?php if ($user->plan()->name() === 'Free'): ?>
				
				<!-- not premium alert -->
				<div class='row'>
					<div class='span9'>
						<div class='well well-unit'>
							<h3>
								Premium account needed
							</h3>
							<p>
								Before customizing your Facebook dialog box, you must signup for a premium account. All premium account tiers will give you access to the customized Facebook dialog box option.
							</p>
							<p>
								<?php echo HTML::anchor("home/plans", "Upgrade Account", array('class' => 'btn btn-large btn-blue', 'id' => 'upgrade-account')) ?>
							</p>
						</div><!-- .wel well-unit -->
					</div><!-- .span9 -->
				</div><!-- .row -->
			
			<?php else: ?>
				
				<!--  facebook dialog -->
				<div class='row' id='update-facebook-app'>
					<div class='span9'>
						<div id='facebook-app-form' class='well'>
							<legend>
								Display your own dialog box by adding your Facebook app data
								<a href="#" class='pull-right' id='facebook-app-form-help'>help!</a>
							</legend>
							<?php echo Form::open("settings/appFacebookDialogProcess"); ?>
								<input type="hidden" name="app_id" value="<?php echo $app->id() ?>" id="app-id">
								
								<label for="facebook_id">Facebook Id</label>
								<input type="text" name="facebook_app_id" value="<?php echo $app->facebook_app_id() ?>" placeholder='9810990270247' id="facebook_id">

								<label for="facebook_secret">Facebook Secret</label>
								<input type="text" name="facebook_secret" value="<?php echo $app->facebook_secret() ?>" placeholder='kj901901209709h1f109h120089' id="facebook_secret">
							    <p><?php echo Form::submit("submit", "Update Facebook App", array('class' => 'btn btn-large btn-blue')); ?></p>
							
							<?php echo Form::close(); ?>
							
							<!-- warning -->
							<?php if ($app->facebook_app_id() AND $app->facebook_secret()): ?>
								<h5>
									<span class="label label-important">Important</span> <strong>You're facebook's app must point toward http://www.authmyapp.com/.</strong>
								</h5>
								<p>
									<em>How To:</em> In your Facebook developers app page, select the <?php echo $app->name() ?> app. In the veritcal tab to the left, find settings and click "basic". Locate the section titled "Select how your app integrates with Facebook". Select "Website with Facebook Login" and enter http://www.authmyapp.com/ into the "site URL" input textbox. Be sure to click the "Save Changes" button at the bottom of the form when you are done.
								</p>
								<hr />
								<p id='all-done-with-facebook'>
									All done? <?php echo HTML::anchor("/home", "Return To My Dashboard.") ?>
									<br />
									Confused? <a href="#" id='redo-make-one-for-me'>Build A New Facebook App For Me</a>.
								</p>
							<?php endif ?>
							
							<?php if ( ! $app->facebook_app_id() ): ?>
								<hr />
								<a href="#" id='make-one-for-me'>Make a Facebook App For Me!</a>
							<?php endif ?>
							
						</div><!-- .facebook-form -->
					</div><!-- .row3 offset3 -->
				</div><!-- .row -->
				
				<!-- create facebook app -->
				<div class='row hide' id='create-facebook-app'>
					<div class='span9'>
						<div class='well well-unit'>
							<h3>
								Don't have a Facebook App for <?php echo $app->name() ?>?
							</h3>
							<p>
								We'll make one for you and automatically integrate it with your AuthMyApp account. We charge a one time fee of $25 for this service.
							</p>
							<br />
							<legend>
								What We Need From You
							</legend>
							<ol>
								<li>A high quality picture of your logo</li>
								<li>A brief 130 character description of your app or website</li>
								<li>A more detailed description which can be up to 1000 characters.</li>
							</ol>
							<legend>
								Optional Items You Can Add
							</legend>
							<ul>
								<li>A tagline (up to 40 characters)</li>
								<li>The URL to your privacy policy</li>
								<li>The URL to your terms of service</li>
								<li>A user support E-mail</li>
							</ul>
							<br />
							<p>
								Shoot us an email with the above information. <em>We will do our best to build you your custom dialog box and Facebook appas soon as possible</em>.
							</p>
							<p>
								<?php echo HTML::mailto('hello@authmyapp.com?subject=Facebook+App+Request&body=(please+write+your+message+below+this+top+line)+app_id+is+'.$app->id(), 'Email Us', array('class' => 'btn btn-blue btn-large', 'target' => '_blank')); ?>
							</p>
						</div><!-- .well well-unit -->
					</div><!-- .span9 -->
				</div><!-- .row -->
				
				<div class='row hide' id='facebook-app-prompter'>
					<div class='span9'>
						<div class='well well-unit'>
							<h3>
								Add Your Brand to the Facebook Signup Process
							</h3>
							<p>
								You can easily change the default AuthMyApp Facebook Dialog associated with the signup process. Before we get started, do you already have a Facebook App for <?php echo $app->name() ?>? (<a href="#help" data-toggle='popover' id='facebook-app-prompter-help'>I'm not sure</a>)
							</p>
							<button id='have-facebook-app' class='btn btn-large'>Yes, I Have A Facebook App</button>
							<button id='do-not-have-facebook-app' class='btn btn-large btn-blue'>No, I Don't Have A Facebook App</button>
						</div><!-- .well well-unit -->
					</div><!-- .span9 -->
				</div><!-- .row -->
				
			<?php endif ?>
			
		</div>
		
	</div><!-- .row -->
	
	<div id='facebook-app-id' class='hide'><?php echo $app->facebook_app_id() ?></div>
	
</div><!-- .container -->

<?php echo $footer ?>