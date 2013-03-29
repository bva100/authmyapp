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
				<div class='row'>
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
									All done? <?php echo HTML::anchor("/home", "Return to My Dashboard.") ?>
								</p>
							<?php endif ?>
							
						</div><!-- .facebook-form -->
					</div><!-- .row3 offset3 -->
				</div><!-- .row -->
				
				<!-- create facebook app -->
				<div class='row'>
					<div class='span9'>
						<h3>
							Don't have a Facebook App for your app or website?
						</h3>
						<p>
							We'll make one for you and automatically integrate it with your AuthMyApp account. We charge a one time fee of $25 for this service. To get started, we'll need three things from you:
						</p>
						<ol>
							<li>A high quality picture of your logo</li>
							<li>A brief 130 character description of your app or website</li>
							<li>A more detailed description which can be up to 1000 characters.</li>
						</ol>
						<p>
							optionally, you can also add
						</p>
						<ul>
							<li>A tagline (up to 40 characters)</li>
							<li>The URL to your privacy policy</li>
							<li>The URL to your terms of service</li>
							<li>A user support E-mail</li>
						</ul>
						<p>
							Shoot us an email with the above information. We will do our best to get you your custom dialog box as soon as possible.
						</p>
						<p>
							<?php echo HTML::mailto('hello@authmyapp.com?subject=Facebook+App+Request&body=(please+write+your+message+below+this+top+line)+app_id+is+'.$app->id(), 'Email Us', array('class' => 'btn btn-blue btn-large', 'target' => '_blank')); ?>
						</p>
					</div><!-- .span9 -->
				</div><!-- .row -->
				
			<?php endif ?>
			
		</div>
		
	</div><!-- .row -->
	
</div><!-- .container -->