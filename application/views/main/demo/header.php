<?php defined('SYSPATH') or die('No direct script access.');
?>

<div id="header">
	<p class="header-message">
		You're now visiting the Example Company demo <?php echo HTML::anchor("", "Close Demo", array('class' => 'btn btn-mini btn-demo')) ?>
	</p>
</div>

<style type="text/css" media="screen">
	#header {
		background-color: #3a87ad;
		position: fixed;
		top: 0px;
		width: 100%;
	}
	.header-message {
		font-size: 18px;
		color: white;
		margin: 15px 0px 15px 40px;
		text-align: center;
	}
	.btn-demo {
		position: relative;
		left: 30px;
	}
</style>