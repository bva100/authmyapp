<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div>
		
		<div class='span9'>
			
			<!-- warning -->
			<div class="alert alert-block  alert-plan">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>
					<strong>Alert!</strong> Be sure to <a href='/help/signups'>setup your signups</a> before installing your login button.
				</p>
			</div>
			
			<!-- step 1 header -->
			<h3 class='help-header'>
				Get the Login Button
			</h3>
			<!-- step 1 body -->
			<p class='help-body'>
				<strong>After installing your signup button, you have the options to make a separate login button.</strong>
				<ol class='help-body-steps'>
					<li>After logging into you account, click on the <?php echo HTML::anchor("/downloads", "downloads") ?> tab.</li>
					<li>Find the "Get Login Button" section and click on the blue download button <img src="/assets/img/download_btn_mini.png" width="16" height="13"></li>
					<li>Customize the text of button and the size of button. Click "Preview Login Button" when complete and copy the lines of code which appear in a grey box below the preview.</li>
					<li>Paste this code into the desired location within the HTML of your webpage. </li>
				</ol>
			</p>
			<p>
				<em>This step is optional. User's should be able to "login" with the Connect button you have already created. However, some UX folks prefer to have one distinct signup button and one distinct login button.</em>
			</p>
			
			<hr />
			<h3>
				And You're All Done! <span class="muted">That's all it takes</span>
			</h3>
			<p>
				Experience any problems? Please checkout our <?php echo HTML::anchor("blog.authmyapp.com/faqs", "FAQ") ?> or <?php echo HTML::mailto("hello@authmyapp.com?subject=Please+help+me!", "shoot us a question.", array('target' => '_blank')) ?>
			</p>
			
		</div>
		
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>