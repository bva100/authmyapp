<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class="modal fade" id="intro-modal">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>Example Company demo</h3>
	</div>
	<div class="modal-body">
		<p>
			You've landed on the Example Company website and have decide to signup for their service. Click the Connect with Auth My App button to continue this demo.
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary pull-right" data-dismiss="modal">OK</a>
	</div>
</div>

<div class='container'>
	
	<div class='row'>
		<div class='span12'>
			<div class='hero-unit'>
				<h1>Example Company</h1>
				<p>
					It's surprisingly simple to get high quality products delivered to your front door.
					<br />
					Sign up now for a free account with just <i>one very simple click</i>!
				</p>
				<?php echo HTML::anchor("connect_facebook?app_id=2&security_code=".$security_code, "Connect with Auth-My-App Facebook button", array('class' => 'btn btn-primary btn-large')) ?>
			</div><!-- .hero-unit -->
		</div><!-- .span12 -->
	</div><!-- .row -->
	
	<div class='row'>
		
		<div class='span4'>
			<h3>
				<img src="/assets/img/fire.png" width="23" height="26" alt="Fire" id='fire-icon'>
				Hamburger Shankle
			</h3>
			<p>
				Bacon ipsum dolor sit amet prosciutto ham shoulder hamburger salami turducken, ribeye tongue. Meatball spare ribs turducken pancetta steak. 
			</p>
		</div><!-- .span4 -->
		
		<div class='span4'>
			<h3>
				<img src="/assets/img/glass.png" width="24" height="27" alt="Glass" id='drink-icon'>
				Microbrewery Goblet
			</h3>
			<p>
				Cask bock cask conditioned ale. Fermenting yeast units of bitterness bunghole, becher craft beer. Copper enzymes black malt alcohol, pitching hops on ipa.
			</p>
		</div><!-- .span4 -->
		
		<div class='span4'>
			<h3>
				<img src="/assets/img/fish.png" width="25" height="27" alt="Fish" id='fish-icon'>
				Black Dragonfish
			</h3>
			<p>
				Gibberfish, elver pygmy sunfish jewelfish Pacific lamprey scaly dragonfish shortnose chimaera; tuna hoki hammerhead shark Alaska blackfish, shark.
			</p>
		</div><!-- .span4 -->
		
	</div><!-- .row -->
	
	<hr />
	
	<div class='row'>
		
		<div class='span12'>
			<h2>
				Best service ever. <span class='muted'>It'll really blow your mind.</span> <a href='/connect_facebook?app_id=2'>Get started now.</a>
			</h2>
		</div><!-- .span8 -->
		
	</div><!-- .row -->
	
</div><!-- .container -->