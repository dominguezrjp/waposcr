<div class="row">
	<div class="col-md-6">
		<?php $pusher = isJson($this->settings['pusher_config'])?json_decode($this->settings['pusher_config']):''; ?>
		<form action="<?= base_url("admin/settings/add_pusher");?>" method="post">
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
						<select name="cluster" class="form-control">
							<option value="ap1" <?= isset($pusher->cluster) && $pusher->cluster=="ap1"?"selected":'';?>>ap1</option>
						</select>
					</div>

					<div class="form-group">
						<label><?= lang('status');?> <span class="error">*</span></label>
						<select name="status" class="form-control">
							<option value="1" <?= isset($pusher->status) && $pusher->status=="1"?"selected":'';?>><?= lang('enable');?></option>
							<option value="0" <?= isset($pusher->status) && $pusher->status=="0"?"selected":'';?>><?= lang('disable');?></option>
						</select>
					</div>
				</div>
				<div class="card-footer text-right">
					<input type="hidden" name="id" value="<?= $this->settings['id'];?>">
					<button type="submit" class="btn btn-secondary"><?= lang('submit');?></button>
				</div>
			</div>
		</form>
	</div>
</div>