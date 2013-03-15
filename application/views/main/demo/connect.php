<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container'>
	<div class='row'>
		<div class='span12'>
			<h2>
				Data transfer complete. <span class='muted'>Wasn't that easy?</span>
			</h2>
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
			
			<?php echo Form::open("demo/app"); ?>
				<?php echo Form::hidden("email", $email); ?>
				<?php echo Form::hidden("first_name", $first_name); ?>
				<?php echo Form::hidden("last_name", $last_name); ?>
				<?php echo Form::hidden("birthday", $birthday); ?>
				<?php echo Form::hidden("gender", $gender); ?>
				<?php echo Form::hidden("ip", $ip); ?>
				<?php echo Form::hidden("country_code", $country_code); ?>
				<?php echo Form::hidden("facebook_id", $facebook_id); ?>
				<?php echo Form::hidden("picture", $picture); ?>
				<?php echo Form::hidden("method", $method); ?>
				<?php echo Form::submit("submit", "Look Inside Example Company's App", array('class' => 'btn btn-large btn-danger', 'id' => 'view-app')); ?>
			<?php echo Form::close(); ?>
			
			
		</div><!-- .span12 -->
	</div><!-- .row -->
</div><!-- .container -->