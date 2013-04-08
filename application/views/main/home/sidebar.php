<?php defined('SYSPATH') or die('No direct script access.');
?>

<ul class="nav nav-tabs nav-stacked" id='primary-sidebar'>
	<li <?php if($page === 'manage'){echo 'class="active"';} ?> >
		<a href="/home">
			<img src="/assets/img/dashboard.png" width="20" height="20" class='sidebar-img'>
			Dashboard
		</a>
	</li>
	<li <?php if ($page === 'analytics') {echo 'class="active"'; } ?>>
		<a href="/home/analytics">
			<img src="/assets/img/graph_pie.png" width="20" height="20" class='sidebar-img'>
			Analytics
		</a>
	</li>
	<li <?php if($page === 'downloads'){echo 'class="active"';} ?>>
		<a href="/downloads">
			<img src="/assets/img/download.png" width="20" height="20" class='sidebar-img'>
			Downloads
		</a>
	</li>
	<li <?php if ($page === 'organizations') {echo 'class="active"'; } ?>>
		<a href="/home/organizations">
			<img src="/assets/img/briefcase.png" width="20" height="13" class='sidebar-img'>
			Organizations
		</a>
	</li>
	<li <?php if($page === 'payments'){echo 'class="active"';} ?>>
		<a href="/home/plans?limit=4&payments=1">
			<img src="/assets/img/credit.png" width="18" height="18" class='sidebar-img'>
			<span id='sidebar-billing-text'>
				Plan Options
			</span>
		</a>
	</li>
</ul>

<div id="secondary-sidebar">
	<?php echo HTML::anchor("home/plans", "Upgrade Account", array('class' => 'btn btn-blue btn-block')) ?>
	<?php echo HTML::anchor("home/addapp", "Add a New App", array('class' => 'btn btn-block')) ?>
</div>