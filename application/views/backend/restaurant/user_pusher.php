<div class="row">
	<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	<div class="col-md-6">
		<?php $pusher = isJson($settings['pusher_config'])?json_decode($settings['pusher_config']):''; ?>
		<form action="<?= base_url("admin/auth/add_pusher");?>" method="post">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
			<div class="card">
				<div class="card-header"><h3><?= lang('pusher');?></h3></div>
				<div class="card-body">
					<div class="form-group">
						<label><?= lang('app_id');?> <span class="error">*</span></label>
						<input type="text" name="app_id" class="form-control" placeholder="<?= lang('app_id');?>" value="<?= !empty($pusher->app_id)?$pusher->app_id :"";?>">
					</div>

					<div class="form-group">
						<label><?= lang('auth_key');?> <span class="error">*</span></label>
						<input type="text" name="auth_key" class="form-control" placeholder="<?= lang('auth_key');?>" value="<?= !empty($pusher->auth_key)?$pusher->auth_key :"";?>">
					</div>

					<div class="form-group">
						<label><?= lang('secret');?> <span class="error">*</span></label>
						<input type="text" name="secret" class="form-control" placeholder="<?= lang('secret');?>" value="<?= !empty($pusher->secret)?$pusher->secret :"";?>">
					</div>

					<div class="form-group">
						<label><?= lang('cluster');?> <span class="error">*</span></label>
						<input type="text" name="cluster" class="form-control" value="<?= !empty($pusher->cluster)?$pusher->cluster :"";?>">
					</div>

					<div class="form-group">
						<label><?= lang('status');?> <span class="error">*</span></label>
						<select name="status" class="form-control">
							<option value="1" <?= isset($pusher->status) && $pusher->status=="1"?"selected":'';?>><?= lang('enable');?></option>
							<option value="0" <?= isset($pusher->status) && $pusher->status=="0"?"selected":'';?>><?= lang('disable');?></option>
						</select>
					</div>
					<div class="form-group mt-10">
						<label class="custom-checkbox"><input type="checkbox" name="is_debug" value="1" <?= isset($pusher->is_debug) && $pusher->is_debug=="1"?"checked":'';?>><?= lang('enable_development_mode');?></label>
					</div>
				</div>
				<div class="card-footer text-right">
					<input type="hidden" name="id" value="<?= $settings['id'];?>">
					<button type="submit" class="btn btn-secondary"><?= lang('submit');?></button>
				</div>
			</div>
		</form>
	</div>
</div>