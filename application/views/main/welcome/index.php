<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='top-wrapper'>
	
	<div class='container'>
		<div class='row'>
			<div class='span12'>
				<div class='hero-unit' id='featurette-one'>
					<h1>
						Facebook Connect Simplified
					</h1>
					<p>
						Connect your app or website to Facebook and simplify your user signup process.
					</p>
					<?php echo HTML::anchor("connect_facebook?app_id=1&security_code=".$security_code.'&connect_version='.Controller_Api_Abstract::CONNECT_VERSION, "Get Started", array('class' => 'btn btn-large btn-blue btn-cta signup')) ?>
				</div><!-- .hero-unit -->
			</div><!-- .span12 -->
		</div><!-- .row -->
	</div><!-- .container -->
	
</div><!-- .wrapper -->

<div class='core-features'>

	<div class='container' id='featurette-two'>
		
		<div class='row'>
			
			<!-- Validate -->
			<div class='span6'>
				<div class='row'>
					<div class='span1'>
						<img src="/assets/img/check.png" width="44" height="37" alt="Validate Signup Data" id='validate-icon'>
					</div><!-- .span1 -->
					<div class='span5'>
						<h2>Validate Signup Data</h2>
						<p>
							Avoid annoying captchas and email confirmations. Get validated sign up data by outsourcing your validation to Facebook. Save time and money by reducing spam.
						</p>
					</div><!-- .span4 -->
				</div><!-- .row -->
			</div><!-- .span6 -->
			
			<!-- Convert -->
			<div class='span6'>
				<div class='row'>
					<div class='span1'>
						<img src="/assets/img/graph.png" width="42" height="41" alt="Increase conversion" id='convert-icon'>
					</div><!-- .span1 -->
					<div class='span5'>
						<h2>Increase Conversion</h2>
						<p>
							Increase your landing page conversion rates by removing the hassle of long forms. Make it easy for your customers to signup and purchase your product or service.
					</div><!-- .span5 -->
				</div><!-- .row -->
			</div><!-- .span6 -->
			
		</div><!-- .row -->
		
		<div class='row'>
			
			<!-- Easy to Manage-->
			<div class='span6 core-bottom-row'>
				<div class='row'>
					<div class='span1'>
						<img src="/assets/img/clipboard.png" width="40" height="54" alt="Easy to manage" id='manage-icon'>
					</div><!-- .span1 -->
					<div class='span5'>
						<h2>Flexible Pricing</h2>
						<p>
							Straight forward pricing lets you choose the right plan for your needs. We offer a free plan and our premium plans start at just $10 a month. <a href='/welcome/pricing'>View plan pricing details.</a>
						</p>
					</div><!-- .span5 -->
				</div><!-- .row -->
			</div><!-- .span6 -->
			
			<!-- Fast Setup -->
			<div class='span6 core-bottom-row'>
				<div class='row'>
					<div class='span1'>
						<img src="/assets/img/stopwatch.png" width="46" height="53" alt="Fast Setup" id='setup-icon'>
					</div><!-- .span1 -->
					<div class='span5'>
						<h2>Super Fast Setup</h2>
						<p>
							Get all of the power of Facebook connect with none of the headaches. Create an account in minutes and start accepting new signups today.
						</p>
					</div><!-- .span5 -->
				</div><!-- .row -->
			</div><!-- .span6 -->
			
		</div><!-- .row -->
		
		<!-- hr drop -->
		<div class='row'>
			<div class='span12'>
				<img src="assets/img/hr-drop.png" width="1000" height="10" alt="Facebook Connect Simplified" class='hr-drop'>
			</div><!-- .span12 -->
		</div><!-- .row -->
		
		<!-- form to button -->
		<div class='row'>
			
			<h3 class='form-example-header featurette-header'>
				Why would you choose this...
			</h3>
			<div class='span12 form-example' id='form-input-example'>
				<form class="form-horizontal">
					<div class='span4'>
						<div class="control-group">
							<label class="control-label" for="inputEmail">Email</label>
							<div class="controls">
								<input type="text" id="inputEmail" placeholder="Email">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">Password</label>
							<div class="controls">
								<input type="password" id="inputPassword" placeholder="Password">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">First Name</label>
							<div class="controls">
								<input type="text" id="inputPassword" placeholder="First name">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">Last Name</label>
							<div class="controls">
								<input type="text" id="inputPassword" placeholder="Last name">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">Gender</label>
							<div class="controls">
								<input type="text" id="inputPassword" placeholder="Gender">
							</div>
						</div>
					</div>

					<div class='span4'>
						<div class="control-group">
							<label class="control-label" for="inputPassword">Birthday</label>
							<div class="controls">
								<input type="text" id="inputPassword" placeholder="Birthday">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">Locale</label>
							<div class="controls">
								<input type="text" id="inputPassword" placeholder="Language">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">Phone</label>
							<div class="controls">
								<input type="text" id="inputPassword" placeholder="Phone">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">Country</label>
							<div class="controls">
								<input type="text" id="inputPassword" placeholder="Country">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">Postal</label>
							<div class="controls">
								<input type="text" id="inputPassword" placeholder="Postal Code">
							</div>
						</div>
					</div>
					<script type="text/javascript"
						src="http://www.google.com/recaptcha/api/challenge?k=6Lfq398SAAAAAIx02GqWT9Ub1Zbo2aQ8ItVmvNls">
					</script>
				</form>
			</div><!-- .span6 -->
			
			<h3 class='form-example-header featurette-header'>
				...when all you need is this?
			</h3>
			<div class='span12 form-example'>
				<?php echo HTML::anchor("#", "Connect using Facebook", array('class' => 'btn btn-facebook btn-large', 'id' => 'form-example-btn')) ?>	
			</div><!-- .span6 -->
		</div><!-- .row -->
		
		<!-- hr drop -->
		<div class='row'>
			<div class='span12'>
				<img src="assets/img/hr-drop.png" width="1000" height="10" alt="Facebook Connect Simplified" class='hr-drop'>
			</div><!-- .span12 -->
		</div><!-- .row -->
		
		<div class='row'>
			<div class='span12' style='text-align: center'>
				<h3 class='featurette-header featurette-header-bold'>
					How It Works
				</h3>
			</div><!-- .span4 -->
		</div><!-- .row -->
		
		<hr class='hr-how-it-works'/>
		
		<!-- how it works. step one. -->
		<div class='row'>
			<div class='span12'>
				<h3 class='featurette-header featurette-header-bold'>
					Step One.
				</h3>
				<h3 class='featurette-header-small'>
					Create your new account and register <?php echo HTML::anchor("#create", "here") ?>
				</h3>
				<h3 class='featurette-header-small muted'>
					It will take less than three minutes
				</h3>
			</div><!-- .span -->
		</div><!-- .row -->
		
		<hr class='hr-how-it-works'/>
		
		<!-- how it works. step two. -->
		<div class='row'>
			<div class='span12' style='text-align: right'>
				<h3 class='featurette-header featurette-header-bold'>
					Step Two.
				</h3>
				<h3 class='featurette-header-small'>
					Redirect new sign ups to AuthMyApp
				</h3>
				<h3 class='featurette-header-small muted'>
 					Find the button that does this for you <?php echo HTML::anchor("tutorial/article?create-a-redirect-button", "here") ?>
				</h3>
			</div><!-- .span -->
		</div><!-- .row -->
		
		<hr class='hr-how-it-works'/>
		
		<!-- how it works. step three. -->
		<div class='row'>
			<div class='span12' id='how-it-works-final'>
				<h3 class='featurette-header featurette-header-bold'>
					Step Three.
				</h3>
				<h3 class='featurette-header-small'>
					Receive the sign up data and create a new user
				</h3>
				<h3 class='featurette-header-small muted'>
					We already wrote all the nerdy scripts for you <?php echo HTML::anchor("tutorial/article?create-a-new-user-with-php", "here") ?>
				</h3>
			</div><!-- .span12 -->
		</div><!-- .row -->
		
		<!-- hr drop -->
		<div class='row'>
			<div class='span12'>
				<img src="assets/img/hr-drop.png" width="1000" height="10" alt="Facebook Connect Simplified" class='hr-drop'>
			</div><!-- .span12 -->
		</div><!-- .row -->
		
		<!-- demo -->
		<div class='row'>
			<div class='span12'>
				<h3 class='featurette-header' id='demo-header'>
					Check out the <?php echo HTML::anchor("demo", "demo.") ?> <span class='muted'>It'll blow you away.</span>
				</h3>
			</div><!-- .span12 -->
		</div><!-- .row -->
		
		<!-- hr drop -->
		<div class='row'>
			<div class='span12'>
				<img src="assets/img/hr-drop.png" width="1000" height="10" alt="Facebook Connect Simplified" class='hr-drop'>
			</div><!-- .span12 -->
		</div><!-- .row -->
		
	</div><!-- .container -->
	
</div><!-- .core-features -->

<div class='bottom-band'>
	
	<div class='container'>
		<div class='row'>
			<div class='span12'>
				<h2>AuthMyApp Simplifies Facebook Connect</h2>
				<?php echo HTML::anchor("connect_facebook?app_id=1&security_code=".$security_code.'&connect_version='.Controller_Api_Abstract::CONNECT_VERSION, "Get Started", array('class' => 'btn btn-large btn-blue btn-cta signup')) ?>
			</div><!-- .span12 -->
		</div><!-- .row -->
	</div><!-- .container -->
	
</div><!-- .bottom-signup -->

<?php echo $footer ?>

<?php echo $signup ?>