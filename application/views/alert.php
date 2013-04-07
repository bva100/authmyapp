<?php defined('SYSPATH') or die('No direct script access.');
?>

<div class="alert alert-block alert-<?php echo $type ?>" id='alert-update'>
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $message ?>
</div>

<style type="text/css" media="screen">
	#alert-update {
		font-size: 16px;
		line-height: 23px;
		font-size: 550;
	}
</style>