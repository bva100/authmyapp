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
			<div class="alert alert-block alert-info alert-plan">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>
					<strong>Alert!</strong> You'll have to subscribe to a premium plan before you can access your downloads. Premium plans start at just $10 a month and you can find the details <a href="/welcome/pricing">by clicking here.</a>
				</p>
			</div>
			
			<!-- step 1 header -->
			<h3 class='help-header'>
				Step 1: <span class='muted'>Get the Connect Button</span>
			</h3>
			<!-- step 1 body -->
			<p class='help-body'>
				<strong>Installing your button is a simple copy and paste job.</strong>
				<ol class='help-body-steps'>
					<li>After logging into you account, click on the <?php echo HTML::anchor("/downloads", "downloads") ?> tab.</li>
					<li>Find the "Get Connect Button" section and click on the blue download button <img src="/assets/img/download_btn_mini.png" width="16" height="13"></li>
					<li>Customize the text of button and the size of button. Click "Preview Signup Button" when complete and copy the lines of code which appear in a grey box below the preview.</li>
					<li>Paste this code into the desired location within the HTML of your webpage. </li>
				</ol>
			</p>
			
			<!-- step 2 header -->
			<h3 class='help-header' id='data-sender'>
				Step 2: <span class='muted'>Get the Data Sender</span>
			</h3>
			<p class='help-body'>
				<strong>Get the file which allows your website to send directions to AuthMyApp.</strong>
				<ol class='help-body-steps'>
					<li>After logging into you account, click on the <?php echo HTML::anchor("/downloads", "downloads") ?> tab.</li>
					<li>Find the "Get Direction Sender" section and click on the blue download button <img src="/assets/img/download_btn_mini.png" width="16" height="13"></li>
					<li>Click the "Download Direction Sender". This will install a .zip file onto your computer. Uncompress the file by double clicking it.</em></li>
					<li>Upload the file to your server. Not sure how to upload? <?php echo HTML::anchor("help/uploading", "Click here.") ?></li>
				</ol>
			</p>
			
			<!-- step 3 header -->
			<h3 class='help-header' id='data-receiver'>
				Step 3: <span class='muted'>Get the Data Receiver</span>
			</h3>
			<p class='help-body'>
				<strong>Get the file which allows your website to receive signup data back from AuthMyApp.</strong>
				<ol class='help-body-steps'>
					<li>After logging into you account, click on the <?php echo HTML::anchor("/downloads", "downloads") ?> tab.</li>
					<li>Find the "Get Direction Receiver" section and click on the blue download button <img src="/assets/img/download_btn_mini.png" width="16" height="13"></li>
					<li>Click the "Download Direction Receiver". This will install a .zip file onto your computer. Uncompress the file by double clicking it.</em></li>
					<li>Upload the file to your server. Not sure how to upload? <?php echo HTML::anchor("help/uploading", "Click here.") ?></li>
				</ol>
			</p>
			
			<hr />
			<h3>
				And You're All Done! <span class="muted">What is the next step?</span>
			</h3>
			<p>
				Learn more about what to do next by checking out the <a href="/help/dataReceived">data received help.</a>
			</p>
			<br />
			<p>
				Experiencing any problems? Please checkout our <?php echo HTML::anchor("blog.authmyapp.com/faqs", "FAQ") ?> or <?php echo HTML::mailto("hello@authmyapp.com?subject=Please+help+me!", "shoot us a question.", array('target' => '_blank')) ?>
			</p>
			
		</div>
		
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>