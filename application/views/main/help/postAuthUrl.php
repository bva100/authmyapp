<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div>
		
		<div class='span9'>
			
			<h3 class='help-header' id='data-receiver'>
				Post Auth Url: <span class='muted'>Where do the users go?</span>
			</h3>
			<p class='help-body'>
				After your new user clicks on the Connect with Facebook button and walks through the Facebook Dialog prompt, he or she will be redirected back t your domain. Specifically, they will be redirected to your app/webpage's <b>Post Auth Url</b>. 
			</p>
			<br />
			<p class='help-body'>
				Your Post Auth Url is the same URL which is placed into the "Redirect Successful Signups To" input box when adding a new app or website.
			</p>
			<p class='help-body-img-container'>
				<img src="/assets/img/add_post_auth_url.png" width="500" height="234">
			</p>
			<br /><br />
			<p class='help-body'>
				To find out what the Post Auth Url is for an app you have already added, follow these steps:
			</p>
			<ol>
				<li>Login into you account</li>
				<li>On the "dashboard" page (home page), click on "settings" for your app/website.</li>
				<li>Scroll down to the "technical details" section</li>
				<li>Your Post Auth Url can be found in the input box labeled "Post Auth Uri"</li>
			</ol>
			<!-- warning -->
			<div class="alert alert-block alert-danger alert-plan">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>
					<strong>Alert!</strong> If you change your Post Auth Url, you must re-install your <a href='/help/signups#data-sender'>data sender</a> and your <a href='/help/signups#data-receiver'>data receiver.</a>
				</p>
			</div>
			<p class='help-body-img-container' style='margin-top: 40px; margin-bottom: 30px'>
				<img src="/assets/img/edit_post_auth_url.png" width="500" height="164" alt="Edit Post Auth Url">
			</p>
			
			<p>
				Experiencing any problems? Please checkout our <?php echo HTML::anchor("blog.authmyapp.com/faqs", "FAQ") ?> or <?php echo HTML::mailto("hello@authmyapp.com?subject=Please+help+me!", "shoot us a question.", array('target' => '_blank')) ?>
			</p>
			
		</div>
		
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>