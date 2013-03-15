<?php defined('SYSPATH') or die('No direct script access.');
?>
<div class='container'>
	<div class='span12'>
		<h2>
			<center>
				Demo Form
			</center>
		</h2>
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
		</form>
		
		<div class='row'>
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
				<?php echo HTML::anchor("#", "Connect using Facebook", array('class' => 'btn btn-custom btn-large', 'style' => 'background-color: #3B5998')) ?>	
		</div><!-- .row -->
		
		
		
	</div><!-- .span5 offset3 -->
</div><!-- .container -->


<style type="text/css" media="screen">
	.btn-custom {
		background-color: hsl(221, 72%, 27%) !important;
		background-repeat: repeat-x;
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#1d4cb3", endColorstr="#133276");
		background-image: -khtml-gradient(linear, left top, left bottom, from(#1d4cb3), to(#133276));
		background-image: -moz-linear-gradient(top, #1d4cb3, #133276);
		background-image: -ms-linear-gradient(top, #1d4cb3, #133276);
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #1d4cb3), color-stop(100%, #133276));
		background-image: -webkit-linear-gradient(top, #1d4cb3, #133276);
		background-image: -o-linear-gradient(top, #1d4cb3, #133276);
		background-image: linear-gradient(#1d4cb3, #133276);
		border-color: #133276 #133276 hsl(221, 72%, 23.5%);
		color: #fff !important;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.23);
		-webkit-font-smoothing: antialiased;
	}
</style>