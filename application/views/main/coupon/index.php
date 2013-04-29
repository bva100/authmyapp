<?php defined('SYSPATH') or die('No direct script access.');
?>

<div class="modal hide fade" id="modal-facebook">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>Like AuthMyApp's Fanpage</h3>
	</div>
	<div class="modal-footer">
		<div class='fb-like-container'>
			<div class="fb-like" data-href="http://www.facebook.com/pages/Auth-My-App/475324372522142" data-send="false" data-width="225" data-show-faces="true" data-font="segoe ui"></div>
		</div>
		<div class='modal-facebook-done-header hide'>
			<hr />
			<a class='close btn btn-primary btn-block close-facebook-modal' id='facebook-done' disabled='false'>All Done</a>
		</div>
	</div>
</div>

<div class="modal hide fade" id="modal-facebook-error">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3><i class="icon-facebook-sign icon-1x"></i> Likin' That Fanpage <i class="icon-facebook-sign icon-1x"></i></h3>
	</div>
	<div class="modal-footer">
		<p>
			Hmmm... looks like you haven't liked the AuthMyApp fanpage yet!
		</p>
		<p>
			<a href='#' class='btn btn-warning facebook-try-again'>Like Us</a>
		</p>
	</div>
</div>

<div class="modal hide fade" id="modal-twitter-error">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3><i class="icon-twitter icon-1x"></i> Tweet Tweet Tweet <i class="icon-twitter icon-1x"></i></h3>
	</div>
	<div class="modal-footer">
		<p>
			Hmmm... looks like you haven't sent AuthMyApp a tweet yet!
		</p>
		<p>
			<a href="https://twitter.com/share?<?php echo $tweet_params ?>" target='_blank' class='btn btn-warning tweet'>Tweet Us</a>
		</p>
	</div>
</div>

<div class='container' id='primary-container'>
			
	<!-- intro box -->
	<div class='row'>
		<div class='span12' id='top-intro-box'>
			<section class='intro-box'>
				<h1>Get An AuthMyApp Discount Coupon</h1>
				<p style='coupon-copy'>
					Want a sweet 30% off of your first month for <em>any plan you choose?</em> Follow these 3 simple steps:
				</p>
			</section><!-- .intro-box -->
		</div>
	</div>
	
	<!-- steps -->
	<div class='row'>
		
		<!-- twitter -->
		<div class="span4" id='twitter-container'>
			<section class="tile">
				<h3 class="tile-title">Step 1: Twitter</h3>
				<p>show us some love with a tweet and be sure to follow @AuthMyApp</p>
				<p class='tweet'><i class="icon-twitter icon-4x"></i></p>
				<a href="https://twitter.com/share?<?php echo $tweet_params ?>" target='_blank' class='btn btn-warning btn-large btn-block tweet'>Tweet</a>
			</section>
		</div>
		
		<!-- facebook -->
		<div class="span4" id='facebook-container'>
			<section class="tile">
				<h3 class="tile-title">Step 2: Facebook</h3>
				<p>like our fanpage and get awesome tips on programming, designing and marketing</p>
				<p class='like'><i class="icon-facebook-sign icon-4x"></i></p>
				<a class="btn btn-warning btn-large btn-block" href='#modal-facebook' data-toggle='modal'>Like</a>
			</section>
		</div>
		
		<!-- coupon -->
		<div class="span4" id='coupon-container'>
			<section class="tile">
				<h3 class="tile-title">Step 3: Coupon</h3>
				<p>your sweet 30% off your first month coupon code will appear here</p>
				<p class='tweet'><i class="icon-check icon-4x"></i></p>
				<p class='coupon-container hide'>
					<span class="coupon-token hide"><?php echo $coupon_token ?></span>
					<input type="text" name="coupon" value="" id="input-coupon" placeholder='coupon code appears here'>
				</p>
				<a class="btn btn-warning btn-large btn-block get-coupon" href="#get-coupon">Get Coupon</a>
				
				<!-- <a class="btn btn-warning btn-large btn-block" id='test' href="#get-coupon">Get test</a> -->
			</section>
		</div>
		
	</div>
	
	<div class='row'>
		<nav class='span4' id='nav-container'>
			<a href="/" title='Social Connect Simplified' class='return-link'>&larr; Return to AuthMyApp</a>
		</nav>
	</div>
	
</div>

<div id="fb-root"></div>