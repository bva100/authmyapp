<?php defined('SYSPATH') or die('No direct script access.');
?>

<div class="modal hide" id="modal-data-source-enum">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>Data Source Enumerated</h3>
	</div>
	<div class="modal-body">
		<p>
			The Data Source string can one of the following:
		</p>
		<ol>
			<li>"facebook"</li>
			<li>"twitter"</li>
			<li>"linkedin"</li>
		</ol>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn pull-right" data-dismiss='modal'>Close</a>
	</div>
</div>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div>
		
		<div class='span9'>
			
			<h3 class='help-header'>
				Data Received <span class='muted'>the next step</span>
			</h3>
			<p class='help-body'>
				After your new user clicks on the Connect with Facebook button and walks through the Facebook Dialog prompt, they will be redirected to the URL you entered into the "Redirect Successful Signups To" input box. If you are unsure of which URL you entered, or would like to change it, please <a href="/help/postAuthUrl">click here.</a>
			</p>
			<p class='help-body'>
				If you have correctly installed the <a href="/help/signups#data-sender">Data Sender File</a> and the <a href="/help/signups#data-receiver">Data Receiver File</a>, a number of <a href="http://en.wikipedia.org/wiki/Session_management#Web_server_session_management">session variables</a> will automatically be added to your new user's <a href="http://en.wikipedia.org/wiki/Session_management#Web_server_session_management">session</a>.
			</p>
			<p>
				<table class='table table-bordered table-striped'>
					<tr>
						<th>Data</th>
						<th>Type</th>
						<th>Access With</th>
					</tr>
					<tr>
						<td>user's email</td>
						<td>string</td>
						<td>$_SESSION['email']</td>
					</tr>
					<tr>
						<td>user's first name</td>
						<td>string</td>
						<td>$_SESSION['firstName']</td>
					</tr>
					<tr>
						<td>user's last name</td>
						<td>string</td>
						<td>$_SESSION['lastName']</td>
					</tr>
					<tr>
						<td>user's birthday</td>
						<td>integer (unix timestamp)</td>
						<td>$_SESSION['birthday']</td>
					</tr>
					<tr>
						<td>user's facebook pic</td>
						<td>string (url to pic)</td>
						<td>$_SESSION['pictureFacebook']</td>
					</tr>
					<tr>
						<td>user's gender</td>
						<td>char ("m" or "f")</td>
						<td>$_SESSION['gender']</td>
					</tr>
					<tr>
						<td>user's ip</td>
						<td>string</td>
						<td>$_SESSION['ip']</td>
					</tr>
					<tr>
						<td>user's <a href='http://en.wikipedia.org/wiki/ISO_3166-2' target='_blank'>country code</a></td>
						<td>string</td>
						<td>$_SESSION['countryCode']</td>
					</tr>
					<tr>
						<td>user's <a href='http://en.wikipedia.org/wiki/List_of_UTC_time_offsets' target='_blank'>timezone offset</a></td>
						<td>integer</td>
						<td>$_SESSION['timezone']</td>
					</tr>
					<tr>
						<td>user's Facebook id</td>
						<td>string</td>
						<td>$_SESSION['facebookId']</td>
					</tr>
					<tr>
						<td>user's Facebook token</td>
						<td>string</td>
						<td>$_SESSION['facebookToken']</td>
					</tr>
					<tr>
						<td>Facebook token's expiration</td>
						<td>integer (unix timestamp)</td>
						<td>$_SESSION['facebookTokenExpires']</td>
					</tr>
					<tr>
						<td>data source</td>
						<td>string (<a href='#modal-data-source-enum' data-toggle='modal'>can be...</a>)</td>
						<td>$_SESSION['dataSource']</td>
					</tr>
				</table>
			</p>
			
			<!-- ending -->
			<hr />
			<p>
				Experience any problems? Please checkout our <?php echo HTML::anchor("blog.authmyapp.com/faqs", "FAQ") ?> or <?php echo HTML::mailto("hello@authmyapp.com?subject=Please+help+me!", "shoot us a question.", array('target' => '_blank')) ?>
			</p>
		</div>
		
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>