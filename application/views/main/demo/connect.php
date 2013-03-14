<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class="modal hide fade" id="profile-modal">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>Data Recieved from Auth My App</h3>
	</div>
	<div class="modal-body">
		<table class="table table-striped">
			<tr>
				<td>Email</td>
				<td><?php echo $email ?></td>
			</tr>
			<tr>
				<td>First Name</td>
				<td><?php echo $first_name ?></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><?php echo $last_name ?></td>
			</tr>
			<tr>
				<td>Birthday</td>
				<td><?php echo date('m/d/y', $birthday) ?></td>
			</tr>
			<tr>
				<td>Gender</td>
				<td>
					<?php if ($gender === 'm'): ?>
						Male
					<?php else: ?>
						Female
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<td>IP</td>
				<td><?php echo $ip ?></td>
			</tr>
			<tr>
				<td>Country Code</td>
				<td><?php echo $country_code ?></td>
			</tr>
			<?php if ($facebook_id): ?>
				<tr>
					<td>Facebook Id</td>
					<td><?php echo $facebook_id ?></td>
				</tr>
			<?php endif ?>
			<tr>
				<td>Picture Url</td>
				<td>
					<?php echo $picture ?>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class='container'>
	
	<div class='row'>
		
		<div class='span3'>
			
			<div class='row'>
				<div class='span3'>
					<div class='thumbnail'>
						<?php echo HTML::image($picture , array("alt" => "", "width" => 200, 'id' => 'profile-pic'))?>
						<div class='caption'>
							<h3>
								<?php echo $first_name ?> <?php echo $last_name ?>
							</h3>
							<p>
								Tail shank ground round pig ham hock beef flank.Cras justo odio, dapibus ac facilisisi
							</p>
							<p class='action-btns'>
								<a href="#" class="btn btn-info">Action</a> <a href="#" class="btn">Action</a>
							</p>
						</div><!-- .caption -->
					</div><!-- .thumbnail -->
				</div><!-- .span3 -->
			</div><!-- .row -->
			
			<div class='row'>
				<div class='span3'>
					<div class='thumbnail' id='datepicker'>
						<img src="/assets/img/datepicker.jpg" width="219" height="190" alt="Datepicker">
					</div><!-- .thumbnail -->
				</div><!-- .span3 -->
			</div><!-- .row -->
			
		</div><!-- .span3 -->
		
		<div class='span9'>
			
			<div class='row'>
				<div class='span9'>
					<div class='hero-unit'>
						<h2>
							Your Account Has Been Created!
						</h2>
						<p>
							<?php echo $first_name ?>, your Best Widgets Ever profile has been automatically created. You are now inside the Best Widgets Ever app and can begin to deliver, manage and deploy widgets- immediately!
						</p>
					</div><!-- .hero-unit -->
				</div><!-- .span12 -->
			</div><!-- .row -->
			
			<div class='row'>
				<div class='span9'>
					<?php echo HTML::anchor("#profile-modal", "View Data Received From Auth My App", array('class' => 'btn btn-large btn-danger', 'id' => 'profile-btn', 'data-toggle' => 'modal')) ?>
				</div><!-- .span9 -->
			</div><!-- .name -->
			
			<hr />
			
			<div class='row'>
				<div class='span3'>
					<h3>
 						Deliver A Widget
					</h3>
					<p>
						secondary fermentation all-malt hoppy final gravity? attenuation amber shelf life bacterial strong
					</p>
					<p><?php echo HTML::anchor("#", "send widget", array('class' => 'btn btn btn-block')) ?></p>
				</div><!-- .span3 -->
				<div class='span3'>
					<h3>
						Manage Widgets
					</h3>
					<p>
						loin turkey shoulder ham hockish shankle beef ribs. big slab sirloin pancetta jerky beef, porkie loiny
					</p>
					<p><?php echo HTML::anchor("#", "open manager", array('class' => 'btn btn btn-block')) ?></p>
				</div><!-- .span3 -->
				<div class='span3'>
					<h3>
						Deploy A Widget
					</h3>
					<p>
						elephantnose fish cod tilefish tuna temperate perch freshwater shark pencilsmelt, forehead brooder lur
					</p>
					<p><?php echo HTML::anchor("#", "launch deployer", array('class' => 'btn btn-block', 'id' => 'launcher')) ?></p>
				</div><!-- .span3 -->
			</div><!-- .row -->
			
		</div><!-- .span8 -->
	</div><!-- .row -->
	
	<div id='datepicker'>
		
	</div><!-- .datepicker -->
	
</div><!-- .container -->
