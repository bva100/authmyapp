<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<!--[if lt IE 9 ]>
<script>
	alert('Please update your browser or use Chrome, Firefox or Safari, to view your analytics')
</script>
<![endif]-->

<div class='container' id='primary-container'>
	<div class='row'>
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		<div class='span9'>
			
			<!-- signups chart -->
			<h3>
				<span class="chart-title">
					Sign Ups Over the Last <input type="text" value="30" id="signups-days-ago">Days
				</span>
				<span class="label label-info" id='signup-counter'></span>
				<a href="#drawChart" class='btn pull-right' id='update-signups-chart'>update</a>
			</h3>
			<div id='chart-signups' class='hide'></div>
			
			<hr />
			<!-- logins chart -->
			<h3>
				<span class="chart-title">
					Logins Over the Last <input type="text" value="30" id="logins-days-ago">Days
				</span>
				<span class="label label-info" id='login-counter'></span>
				<a href="#drawChart" class='btn pull-right' id='update-logins-chart'>update</a>
			</h3>
			<div id='chart-logins' class='hide'></div>
			
			<div id='app-id' class='hide'><?php echo $app->id() ?></div>
			<div id='app-name' class='hide'><?php echo $app->name() ?></div>
			
		</div><!-- .span9 -->
	</div><!-- .row -->
</div><!-- .container -->

	<?php echo $footer ?>