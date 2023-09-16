<div class="row">
		<?php include 'inc/leftsidebar.php'; ?>
		<?php $notification = !empty($settings['notifications'])?json_decode($settings['notifications']):""; ?>
	<?php if(isset($notification->is_active_onsignal) && $notification->is_active_onsignal==1): ?>
		<div class="col-md-6">
			<form action="<?= base_url('admin/dashboard/send_notification') ;?>" method="post" class="validForm" enctype= "multipart/form-data">
				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
				<div class="card">
					<div class="card-header"><h4><?= lang('send_notifications'); ?></h4></div>
					<div class="card-body">
						
						<div class="row">

							<div class="form-group col-md-12">
								<label for=""><?= lang('heading'); ?> </label>
								<input type="text" name="headings" class="form-control" placeholder="<?= lang('heading'); ?>" >
								
							</div>
							<div class="form-group col-md-12">
								<label for=""><?= lang('message'); ?></label>
								<textarea name="msg" class="form-control" id="msg" cols="5" rows="5" placeholder="<?= lang('message'); ?>"></textarea>
								
							</div>

							<div class="form-group col-md-12">
								<label for=""><?= lang('custom_link'); ?> </label>
								<input type="text" name="url" class="form-control" placeholder="<?= lang('custom_link'); ?>">
								
							</div>
							
						</div>
						
					</div><!-- card-body -->
					<div class="card-footer text-right">
						<input type="hidden" name="app_id" value="<?= isset($notification->onsignal_app_id) && !empty($notification->onsignal_app_id)?$notification->onsignal_app_id:0 ;?>">
						
						<button type="submit" class="btn btn-secondary"><?= lang('submit'); ?></button>
					</div>
				</div>
			</form>
		</div>
	<?php endif ?>

	<div class="col-md-6 mt-20">
		<form action="<?= base_url('admin/settings/add_notification') ;?>" method="post" class="validForm" enctype= "multipart/form-data">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
			<div class="card">
				<div class="card-header"><h4><?= lang('notifications'); ?></h4></div>
				<div class="card-body">
					
					<div class="row">

						<div class="form-group col-md-12">
							<label for=""><?= lang('onsignal_app_id'); ?> </label>
							<input type="text" name="onsignal_app_id" class="form-control" placeholder="<?= lang('onsignal_app_id'); ?>" value="<?= !empty($notification->onsignal_app_id)? $notification->onsignal_app_id:"";?>" >
							
						</div>
						<div class="form-group col-md-12">
							<label for=""><?= lang('user_auth_key'); ?></label>
							<input type="text" name="user_auth_key" class="form-control" placeholder="<?= lang('user_auth_key'); ?>" value="<?= !empty($notification->user_auth_key)? $notification->user_auth_key:"";?>">
							
						</div>
						


						<div class="col-md-12">
							<div class="form-group">
								<label class="custom-radio mr-20"> <input type="radio" name="is_active_onsignal" checked  <?= isset($notification->is_active_onsignal) && $notification->is_active_onsignal==1?"checked":"";?> value="1"><?= lang('active')?></label>

								<label class="custom-radio"> <input type="radio" name="is_active_onsignal" value="0" <?= isset($notification->is_active_onsignal) && $notification->is_active_onsignal==0?"checked":"";?> ><?= lang('disable')?></label>
							</div>
						</div>
						
					</div>
					
				</div><!-- card-body -->
				<div class="card-footer text-right">
					<input type="hidden" name="id" value="<?= isset($settings['id']) && !empty($settings['id'])?$settings['id']:0 ;?>">
					
					<button type="submit" class="btn btn-secondary"><?= lang('submit'); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>

