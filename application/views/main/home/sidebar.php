<?php defined('SYSPATH') or die('No direct script access.');
?>

<ul class="nav nav-tabs nav-stacked" id='primary-sidebar'>
	<li <?php if($page === 'manage'){echo 'class="active"';} ?> >
		<a href="/home">
			<img src="/assets/img/dashboard.png" width="20" height="20" class='sidebar-img'>
			Apps and Websites
		</a>
	</li>
	<li <?php if($page === 'downloads'){echo 'class="active"';} ?>>
		<a href="/home/downloads">
			<img src="/assets/img/download.png" width="20" height="20" class='sidebar-img'>
			Get Downloads
		</a>
	</li>
	<li <?php if($page === 'account'){echo 'class="active"';} ?>>
		<a href="/home/account">
			<img src="/assets/img/cog.png" width="20" height="20" class='sidebar-img'>
			Account Settings
		</a>
	</li>
	<li <?php if($page === 'billing'){echo 'class="active"';} ?>>
		<a href="/home/billing">
			<img src="/assets/img/credit.png" width="18" height="18" class='sidebar-img'>
			<span id='sidebar-billing-text'>
				Payments and Billing
			</span>
		</a>
	</li>
</ul>

<div id="secondary-sidebar">
	<?php echo HTML::anchor("home/plans", "Upgrade Account", array('class' => 'btn btn-info btn-block')) ?>
	<?php echo HTML::anchor("home/addapp", "Add a New App", array('class' => 'btn btn-block')) ?>
</div>