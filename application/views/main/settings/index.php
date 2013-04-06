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
		<a href="/home/organizations#create-new-org" class=" pull-left">Add a New Organization</a>
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
				<div class='app-secrets'>
					<p style='text-align: center'>
						<strong>Secret:</strong> <span id="app-secret"><?php echo $app->secret() ?></span>
					</p>
					<p style='text-align: center'>
						<strong>Access Token:</strong> <span id="access-token"><?php echo $app->access_token() ?></span> (<a href="#" id='update-access-token'>reset</a>)
					</p>
				</div><!-- .app-secrets -->
				<hr />
				<legend id='basic-info-legend'>
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
					<?php echo Form::open("/settings/updateAppName"); ?>
						<?php echo Form::hidden("app_id", $app->id()); ?>
						<span class='app-settings-form-label'>Name:</span> 
						<input type="text" name="name" value="<?php echo $app->name() ?>" id="name">
						<button type='submit' id='update-name' class='btn btn-small'>update</button>
					<?php echo Form::close(); ?>
				</p>
				<legend id='tech-legend'>
					Technical Details
				</legend>
				<p>
					<?php echo Form::open("/settings/updateAppDomain"); ?>
						<?php echo Form::hidden("app_id", $app->id()); ?>
						<span class='app-settings-form-label'>Domain:</span> <input type="text" name="domain" value="<?php echo $app->domain() ?>" id="domain">
						<button type='submit' id='update-domain' class='btn btn-small' onclick='redownload()'>update</button>
					<?php echo Form::close(); ?>
				</p>
				<p>
					<?php echo Form::open("/settings/updateAppSenderUri"); ?>
						<?php echo Form::hidden("app_id", $app->id()); ?>
						<span class='app-settings-form-label'>Sender Uri:</span> <input type="text" name="sender_uri" value="<?php echo $app->sender_uri() ?>" id="sender-uri">
						<button type='submit' id='update-sender-uri' class='btn btn-small' onclick='redownload()'>update</button>
					<?php echo Form::close(); ?>
				</p>
				<p>
					<?php echo Form::open("/settings/updateAppReceiverUri"); ?>
						<?php echo Form::hidden("app_id", $app->id()); ?>
						<span class='app-settings-form-label'>Receiver Uri:</span> <input type="text" name="receiver_uri" value="<?php echo $app->receiver_uri() ?>" id="receiver-uri">
						<button type='submit' id='update-receiver-uri' class='btn btn-small' onclick='redownload()'>update</button>
					<?php echo Form::close(); ?>
				</p>
				<p>
					<?php echo Form::open("/settings/updateAppPostAuthUri"); ?>
						<?php echo Form::hidden("app_id", $app->id()); ?>
						<span class='app-settings-form-label'>Post Auth Uri:</span> <input type="text" name="post_auth_uri" value="<?php echo $app->post_auth_uri() ?>" id="post-auth-uri">
						<button type='submit' id='update-post-auth-uri' class='btn btn-small' onclick='redownload()'>update</button>
					<?php echo Form::close(); ?>
				</p>
			</div><!-- .app-settings-form well -->
		</div><!-- .span9 -->
		
	</div><!-- .row -->
	
	<div class='app-id hide'><?php echo $app->id() ?></div><!-- .hide -->
	
</div><!-- .container -->