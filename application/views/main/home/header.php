<?php defined('SYSPATH') or die('No direct script access.');
?>

<div id="header">
	<div class='container'>
		<div class='row'>
			<div class='span12'>
				<span class='pull-left' id='logo'>
					<a href="/home">
						<img src="/assets/img/logo_small.png" width="90" height="76" alt="Logo Small">
					</a>
				</span>
				<span class='pull-right header-btns'>
					<a href="<?php echo URL::base(TRUE).'base/profile?'.$user->id() ?>" id='header-profile'>
						<?php if ($user->picture()): ?>
							<?php echo HTML::image($user->picture() , array("width" => 25, "height "=> 25, 'id' => 'header-picture'))?>
						<?php endif ?>
						<?php echo $user->first_name() ?>
						<?php echo $user->last_name() ?>
					</a>
					<?php echo HTML::anchor("help", "Help", array('id' => 'header-help')) ?>
				</span>
			</div><!-- .span12 -->
		</div><!-- .row -->
	</div><!-- .container -->
</div>

<!-- menu-pulldown -->
<div class='container' id='header-pulldown-container'>
	<div class='row'>
		<div class='span12'>
			<div class='menu-pulldown-arrow pull-right hide'>
				<img src="/assets/img/arrow_up_white.png" width="20" height="20" alt="">
			</div><!-- .menu-pulldown-arrow -->
			<div class='menu-pulldown pull-right hide' id='header-pulldown' state='closed'>
				<ul class="nav nav-list">
					<li>
						<a href="/home">
							<img src="/assets/img/dashboard.png" width="22" height="22" class='header-pulldown-img'>
							Dashboard
						</a>
					</li>
					<li>
						<a href="/home/plans">
							<img src="/assets/img/cog.png" width="22" height="22" class='header-pulldown-img'>
							Account
						</a>
					</li>
					<li>
						<a href="/home/logout">
							<img src="/assets/img/power.png" width="21" height="21" class='header-pulldown-img' id='header-pulldown-logout'>
							Log Out
						</a>
					</li>
				</ul>
			</div><!-- .menu-pulldown -->
		</div><!-- .span12 -->
	</div><!-- .row -->
</div><!-- .container -->