<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='pricing-wrapper'>
	<div class='container' id='primary-container'>
		
		<!-- header -->
		<div class='row'>
			<div class='span12'>
				<div class='hero-unit'>
					<h2>
						Flexible Pricing for Your Needs
					</h2>
					<p>
						AuthMyApp has straight forward pricing with a variety of plans to choose from. Interested in a discount? <a href='/coupon'>Click here to get 30% off!</a>
					</p>
					<a href="/welcome/signup" class='btn btn-blue btn-large'>Get Started Today</a>
				</div><!-- .hero-unit -->
				
			</div><!-- .span12 -->
		</div><!-- .row -->
		
		<!-- table -->
		<div class='row'>
			<div class='span12'>
				<table class='table table-striped table-bordered' id='pricing-table'>
					<thead>
						<tr>
							<th>Name</th>
							<th>Price</th>
							<th>Signups (per month)</th>
							<th>Logins (per month)</th>
							<th>Programming</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($plans as $plan): ?>
							<tr>
								<td>
									<?php echo $plan->name() ?>
								</td>
								<td>
									<?php if ($plan->price()): ?>
										$<?php echo Num::format($plan->price(), 2, TRUE) ?>
									<?php else: ?>
										Free
									<?php endif ?>
								</td>
								<td>
									<?php echo Num::format($plan->signup_limit(), 0) ?>
								</td>
								<td>
									<?php if ($plan->monthly_login_limit()): ?>
										<?php echo Num::format($plan->monthly_login_limit(), 0) ?>
									<?php else: ?>
										Unlimited
									<?php endif ?>
								</td>
								<td>
									<?php if ($plan->downloads()): ?>
										We Do It
									<?php else: ?>
										You Do It
									<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div><!-- .span12 -->
		</div><!-- .row -->
		
		<div class='row'>
			<div class='span3 offset9'>
				<aside class='pull-right'>
					<p>
						Have a questions? <?php echo HTML::mailto("support@authmyapp.com?subject=Pricing", "Contact Us", array('target' => '_blank')) ?>
					</p>
				</aside>
			</div>
		</div><!-- .row -->
		
	</div><!-- .container -->
</div>

<?php echo $footer ?>

<style type="text/css" media="screen">
	#footer {
		box-shadow:inset 0 0 0px #888;
	}
	#primary-container {
		padding-top: 40px;
	}
</style>