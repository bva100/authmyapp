<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div>
		
		<div class='span9'>
			
			<h3 class='help-header'>
				Uploading Files: <span class='muted'>Tips and tricks</span>
			</h3>
			<p class='help-body'>
				After downloading a file from AuthMyApp, you'll have to upload it to your server. There a number of ways to upload new files to your server. If you know how to use <a href="http://en.wikipedia.org/wiki/Secure_copy" target='_blank'>SCP</a>, we highly recommend using that protocol.
			</p>
			<p class='help-body'>
				Uploading can also  be accomplished using <a href='http://en.wikipedia.org/wiki/File_Transfer_Protocol' target='_blank'>FTP</a> and we recommend <?php echo HTML::anchor("http://filezilla-project.org/", "FireZilla", array('target' => 'blank')) ?> to make everything easy. You can find step-by-setup instruction for FireZilla <?php echo HTML::anchor("https://wiki.filezilla-project.org/FileZilla_Client_Tutorial_(en)", "here", array('target' => '_blank')) ?>.
				
			</p class='help-body'>
				<strong>Use GoDaddy?</strong> Find step by step upload instructions <?php echo HTML::anchor("http://support.godaddy.com/help/article/3239/uploading-files-using-the-ftp-file-manager?locale=en", "here", array('target' => '_blank')) ?>
				<br />
				<strong>Use WordPress?</strong> Find step by step upload instructions <?php echo HTML::anchor("http://codex.wordpress.org/FTP_Clients", "here", array('target' => '_blank')) ?>
			</p>
		</li>
			</p>
			
			<!-- warning -->
			<div class="alert alert-block alert-danger alert-plan">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p>
					<strong>Alert!</strong> Be sure to your AuthMyApp files do not end in "copy" nor have any numbers appended.
				</p>
			</div>
			
		
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>