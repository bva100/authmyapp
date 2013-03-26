<?php defined('SYSPATH') or die('No direct script access.');
?>

<div class="modal hide" id="change-org-modal">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>Select An Organization</h3>
	</div>
	<div class="modal-body">
		<?php foreach ($user->organizations() as $users_org): ?>
			<?php if ($users_org->name()): ?>
				<?php echo Form::open("/settings/updateAppOrg"); ?>
					<?php echo Form::hidden("app_id", $app->id()); ?>
					<?php echo Form::hidden("org_id", $users_org->id()); ?>
				    <p>
						<?php echo Form::submit("submit", $users_org->name(), array('class' => 'btn btn-block btn-large')); ?>
					</p>
				<?php echo Form::close(); ?>
			<?php endif ?>
		<?php endforeach ?>
	</div>
	<div class="modal-footer">
		<a href="#addOrg" class=" pull-left">Add a New Organization</a>
		<a href="#" class="btn" data-dismiss='modal'>Close</a>
	</div>
</div>

<?php echo $header ?>

<div class='container' id='primary-container'>
	
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div><!-- .span3 -->
		
		<div class='span9'>
			<div id='app-settings-form' class='well'>
				<h3>
					<?php echo $app->name() ?> Settings
				</h3>
				<hr />
				<p style='text-align: center'>
					<strong>AuthMyApp Id:</strong> <?php echo $app->id() ?>
				</p>
				<p style='text-align: center'>
					<strong>Secret:</strong> <span id="app-secret"><?php echo $app->secret() ?></span> <a href="#" id='update-secret'>refresh</a>
				</p>
				<legend>
					Basic Info
				</legend>
				<p>
					<span class='app-settings-form-label'>Organization: </span>
					<span class='app-settings-form-name'>
					<?php if ( ! $org->name() ): ?>
						No Name
					<?php endif ?>
						<strong style='margin-right: 150px'><?php echo $org->name() ?></strong>
					<?php $org->name() ?>
					<a href="#change-org-modal" id='change-org-opener' class='pull-right' data-toggle='modal'>change</a>
					</span>
				</p>
				<p>
					<span class='app-settings-form-label'>Name:</span> <input type="text" name="name" value="<?php echo $app->name() ?>" id="name">
					<a href="#" id='update-name' class='btn btn-small'>update</a>
				</p>
				<legend>
					Technical Details
				</legend>
				<p>
					<span class='app-settings-form-label'>Domain:</span> <input type="text" name="domain" value="<?php echo $app->domain() ?>" id="domain">
					<a href="#" id='update-domain' class='btn btn-small'>update</a>
				</p>
				<p>
					<span class='app-settings-form-label'>Sender Uri:</span> <input type="text" name="sender-uri" value="<?php echo $app->sender_uri() ?>" id="sender-uri">
					<a href="#" id='update-sender-uri' class='btn btn-small' onclick='redownload'>update</a>
				</p>
				<p>
					<span class='app-settings-form-label'>Receiver Uri:</span> <input type="text" name="receiver-uri" value="<?php echo $app->receiver_uri() ?>" id="receiver-uri">
					<a href="#" id='update-receiver-uri' class='btn btn-small' onclick='redownload'>update</a>
				</p>
				<p>
					<span class='app-settings-form-label'>Post Auth Uri:</span> <input type="text" name="post-auth-uri" value="<?php echo $app->post_auth_uri() ?>" id="post-auth-uri">
					<a href="#" id='update-post-auth-uri' class='btn btn-small' onclick='redownload'>update</a>
				</p>
				<p>
					<span class='app-settings-form-label'>Delivery Method:</span> <input type="text" name="delivery-method" value="<?php echo $app->delivery_method(TRUE) ?>" id="deliver-method">
					<a href="#" id='update-post-auth-uri' class='btn btn-small' onclick='redownload'>update</a>
				</p>
			</div><!-- .app-settings-form well -->
		</div><!-- .span9 -->
		
	</div><!-- .row -->
	
	<div class='app-id hide'><?php echo $app->id() ?></div><!-- .hide -->
	
</div><!-- .container -->