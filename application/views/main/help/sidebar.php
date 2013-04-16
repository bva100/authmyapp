<?php defined('SYSPATH') or die('No direct script access.');
?>


<ul class="nav nav-tabs nav-stacked" id='primary-sidebar'>
	<li <?php if($page === 'signups'){echo 'class="active"';} ?> >
		<a href="/help/signups">
			Signups
		</a>
	</li>
	<li <?php if ($page === 'logins') {echo 'class="active"'; } ?>>
		<a href="/help/logins">
			Logins
		</a>
	</li>
	<li <?php if($page === 'uploading'){echo 'class="active"';} ?>>
		<a href="/help/uploading">
			Uploading
		</a>
	</li>
	<li>
		<a href="/api/docs">
			API Docs
		</a>
	</li>
</ul>