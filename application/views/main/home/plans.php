<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		<div class='span9'>
			
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
									
									<?php echo Form::open("home/plansProcess"); ?>
										<input type="hidden" name="plan_id" value="<?php echo $plan->id() ?>">
										<input type="hidden" name="app_id" value="<?php echo $app->id() ?>">
										<input type="hidden" name="new_app" value="<?php echo $new_app ?>">
										<?php echo Form::submit("submit", "Select", array('class' => 'btn btn-blue btn-plan-action btn-plan-submit')); ?>
									<?php echo Form::close(); ?>
									
								<?php else: ?>
									
									<?php if ($user->plan_id() === $plan->id()): ?>
										<strong>Your Plan</strong>
									<?php elseif($user->plan_id() > $plan->id()): ?>
										<?php echo Form::open("home/plansProcess"); ?>
											<input type="hidden" name="plan_id" value="<?php echo $plan->id() ?>">
											<?php echo Form::submit("submit", "Select", array('class' => 'btn btn-plan-action')); ?>
										<?php echo Form::close(); ?>
									<?php else: ?>
										<?php echo Form::open("home/plansProcess"); ?>
											<input type="hidden" name="plan_id" value="<?php echo $plan->id() ?>">
											<?php echo Form::submit("submit", "Upgrade", array('class' => 'btn btn-blue btn-plan-action')); ?>
										<?php echo Form::close(); ?>
									<?php endif ?>
									
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach ?>
				</table>
			
				<div id='see-more-plans-container'>
					<?php if (isset($limit)): ?>
						<?php if ($app AND $new_app): ?>
							<?php echo HTML::anchor("home/plans?app_id=".$app->id().'&new_app='.$new_app.'&limit=null', "view higher volume plans", array('id' => 'see-more-plans')) ?>
						<?php else: ?>
							<?php echo HTML::anchor('home/plans?limit=null', "view higher volume plans", array('id' => 'see-more-plans')) ?>
						<?php endif ?>
					<?php endif ?>
				</div>
				
		</div><!-- .span9 -->
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>