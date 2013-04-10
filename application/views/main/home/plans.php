<?php defined('SYSPATH') or die('No direct script access.');
?>

<div class="modal hide fade" id="coupon-modal" style='text-align: center'>
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h4>Add Your Coupon</h4>
	</div>
	<div class="modal-body">
		<input type="text" name="coupon_code" value="" id="input-coupon-code" placeholder='coupon-code' style='margin-left: 15px'>
		<a href="#" class="btn btn-blue" style='margin-bottom: 10px' id='add-coupon'>Add</a>
	</div>
</div>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		<div class='span9'>
			
			<?php if (isset($alert)): ?>
				<div class='row'>
					<div class='span9'>
						<?php echo $alert ?>
					</div><!-- .span9 -->
				</div><!-- .row -->
			<?php endif ?>
			
			<!-- intro message -->
			<?php if ($app AND $new_app): ?>
					<div class='well well-unit'>
						<h3>
							<?php echo $app->name() ?> has been added to your account
						</h3>
						<p>
							Next Step: to ensure AuthMyApp can send signup data to <?php echo $app->name() ?>, please choose a plan below.
						</p>
					</div>
			<?php endif ?>
			
				<table class="table table-hover table-bordered" id='plan-table'>
					<tr>
						<th>
							Name
						</th>
						<th>
							Price
						</th>
						<th>
							Signups
						</th>
						<th>
							Login Limit
						</th>
						<th>
							Programming
						</th>
						<th>
						</th>
					</tr>
					<?php foreach ($plans as $plan): ?>
						<tr>
							<td>
								<?php echo $plan->name() ?>
							</td>
							<td>
								<?php if ( ! $plan->price()): ?>
									Free
								<?php else: ?>
									$<?php echo $plan->price() ?> / month
								<?php endif ?>
							</td>
							<td id='signup-limit'>
								<?php echo Num::format($plan->signup_limit(), 0, FALSE) ?>
							</td>
							<td>
								<?php if ($plan->monthly_login_limit() !== 0): ?>
									<?php echo $plan->monthly_login_limit() ?> / month
								<?php else: ?>
									unlimited
								<?php endif ?>
							</td>
							<td>
								<?php if ($plan->downloads()): ?>
									None
								<?php else: ?>
									Required
								<?php endif ?>
							</td>
							<td>
								<?php if ($app AND $new_app): ?>
									
									<!-- does not yet have a plan -->
									<?php echo Form::open("pay/planStripeProcess", array('class' => 'plan-form')); ?>
										<input type="hidden" name="plan_id" value="<?php echo $plan->id() ?>">
										<input type="hidden" name="app_id" value="<?php echo $app->id() ?>">
										<input type="hidden" name="new_app" value="<?php echo $new_app ?>">
										<input type="hidden" name="payment_token" value="<?php echo $payment_token ?>">
										<?php if ( $user->stripe_id()  OR $plan->id() === 1 ): ?>
											<!-- if user has a stripe ID or is plan is free, skip stripe-modal -->
											<?php echo Form::submit("submit", "Select", array('class' => 'btn btn-plan-action btn-plan-submit')); ?>
										<?php else: ?>
											<!-- onlick, show stripe-modal -->
											<script src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
												data-key="<?php echo Factory_Payment::public_key('stripe'); ?>"
												data-amount="<?php echo str_replace('.', '', (string)$plan->price()); ?>"
												data-name="AuthMyApp"
												data-description="The <?php echo $plan->name() ?> Plan"
												data-image="/assets/img/logo_circle_extra_small.png"
												data-panel-label="Subscribe"
												data-label="Select">
											</script>
										<?php endif ?>
									<?php echo Form::close(); ?>
									
								<?php else: ?>
									
									<!-- already has a plan -->
									<?php if ($user->plan_id() === $plan->id()): ?>
										<!-- current plan -->
										<strong>Your Plan</strong>
										
									<?php elseif($user->plan_id() > $plan->id()): ?>
										
										<!-- plan is smaller than current -->
										<?php echo Form::open("pay/planStripeProcess"); ?>
											<input type="hidden" name="plan_id" value="<?php echo $plan->id() ?>">
											<input type="hidden" name="payment_token" value="<?php echo $payment_token ?>">
											<?php if ( $user->stripe_id() AND $plan->id() === 1): ?>
												<?php echo Form::submit("submit", "Cancel", array('class' => 'btn btn-plan-action btn-plan-submit btn-plan-cancel')); ?>
											<?php elseif ( $user->stripe_id() OR $plan->id() === 1): ?>
												<!-- if user has a stripe ID or is plan is free, skip stripe-modal -->
												<?php echo Form::submit("submit", "Select", array('class' => 'btn btn-plan-action btn-plan-submit')); ?>
											<?php else: ?>
												<!-- onlcick, show stripe-modal -->
												<script src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
													data-key="<?php echo Factory_Payment::public_key('stripe'); ?>"
													data-amount="<?php echo str_replace('.', '', (string)$plan->price()); ?>"
													data-name="AuthMyApp"
													data-description="The <?php echo $plan->name() ?> Plan"
													data-image="/assets/img/logo_circle_extra_small.png"
													data-panel-label="Subscribe"
													data-label="Select">
												</script>
											<?php endif ?>
										<?php echo Form::close(); ?>
										
									<?php else: ?>
										
										<!-- plan is greater than current -->
										<?php echo Form::open("pay/planStripeProcess"); ?>
											<input type="hidden" name="plan_id" value="<?php echo $plan->id() ?>">
											<input type="hidden" name="payment_token" value="<?php echo $payment_token ?>">
											<?php if ( $plan->id() === 1 ): ?>
												<?php echo Form::submit("submit", "Select", array('class' => 'btn btn-plan-action')); ?>
											<?php elseif ( $user->stripe_id() ): ?>
												<!-- if user has a stripe ID or is plan is free, skip stripe-modal -->
												<?php echo Form::submit("submit", "Upgrade", array('class' => 'btn btn-blue btn-plan-action btn-plan-action')); ?>
											<?php else: ?>
												<!-- onlcick, show stripe-modal -->
												<script src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
													data-key="<?php echo Factory_Payment::public_key('stripe'); ?>"
													data-amount="<?php echo str_replace('.', '', (string)$plan->price()); ?>"
													data-name="AuthMyApp"
													data-description="The <?php echo $plan->name() ?> Plan"
													data-image="/assets/img/logo_circle_extra_small.png"
													data-panel-label="Subscribe"
													data-label="Select">
												</script>
											<?php endif ?>
										<?php echo Form::close(); ?>
										
									<?php endif ?>
									
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach ?>
				</table>
			
				<div id='see-more-plans-container'>
					
					<!-- new plans -->
					<?php if (isset($limit)): ?>
						<?php if ($app AND $new_app): ?>
							<?php echo HTML::anchor("home/plans?app_id=".$app->id().'&new_app='.$new_app.'&limit=null', "view higher volume plans", array('id' => 'see-more-plans', 'class' => 'pull-left')) ?>
						<?php else: ?>
							<?php echo HTML::anchor('home/plans?limit=null', "view higher volume plans", array('id' => 'see-more-plans', 'class' => 'pull-left')) ?>
						<?php endif ?>
					<?php endif ?>
					
					<!-- coupon model opene -->
					<a href="#coupon-modal" data-toggle='modal' class='pull-right'>Add A Coupon</a>
					
				</div>
				
		</div><!-- .span9 -->
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>