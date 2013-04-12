<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php if ( $user->plan_state() !== Model_User::PLAN_STATE_ACTIVE ): ?>
	<div class="alert alert-block alert-danger" id='alert-payment'>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p>
			<strong>Alert!</strong>
			
			<?php if ( $user->plan_state() === Model_User::PLAN_STATE_OVERDUE ): ?>
				
				<!-- message for overdue -->
				Your credit card is no longer valid. Your data transfers may be placed on hold until this issue resolved. To change or update your credit card, please 
				<a href="/pay/changeStripeCc">click here.</a>
				
			<?php elseif( $user->plan_state() === Model_User::PLAN_STATE_PAYMENT_HOLD ): ?>
				
				<!-- message for hold -->
				Your monthly plan was cancelled because we are no longer able to bill your credit card. Your data will no longer transfer. Please select a new plan by
				<a href="/home/plans">clicking here.</a>
				
			<?php endif ?>
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