<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php if ($user->plan_state() !== Model_User::PLAN_STATE_ACTIVE): ?>
	<div class="alert alert-block alert-danger" id='alert-payment'>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p>
			<strong>Alert!</strong> There was an issue with your last payment invoice. Your data transfers will be placed on hold until this issue resolved. To change or update your payment method, please <a href="/pay/changeStripeCc">click here.</a>
		</p>
	</div>

	<style type="text/css" media="screen">
		#alert-payment {
			font-size: 16px;
			line-height: 23px;
			font-size: 550;
		}
	</style>
<?php endif ?>