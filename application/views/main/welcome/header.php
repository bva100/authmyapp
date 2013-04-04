<?php defined('SYSPATH') or die('No direct script access.');
?>

<div id="header">
	<p class="header-message">
		<span id='primary-message'>
			<a href="/welcome">
				<img src="/assets/img/logo_small.png" width="100" height="76" alt="AuthMyApp">
			</a>
		</span>
		<span class='pull-right header-btns'>
			<?php echo HTML::anchor("welcome/login", "Login", array('class' => 'btn btn-blue')) ?>
			<?php echo HTML::anchor("welcome/signup", "Sign Up", array('class' => 'btn btn-blue')) ?>
		</span>
	</p>
</div>

<style type="text/css" media="screen">
	#header {
		background-color: rgba(43, 43, 43, .8);
		text-shadow: 0.1em 0.1em 0.05em #333;
		position: fixed;
		top: 0px;
		z-index: 2;
		width: 100%;
	}
	.header-message {
		font-size: 22px;
		color: white;
		margin: 15px 0px 15px 40px;
		text-align: center;
	}
	#primary-message {
		position: relative;
		left: 55px;
	}
	.header-btns {
		position: relative;
		bottom: 4px;
		right: 20px;
	}
</style>