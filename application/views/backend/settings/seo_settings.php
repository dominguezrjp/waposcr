<div class="row">
	<?php include APPPATH."views/backend/dashboard/admin_inc/alert_info.php"; ?>
</div>
<div class="row">
	<?php include 'inc/leftsidebar.php'; ?>
	<form class="email_setting_form" action="<?= base_url('admin/settings/add_seo_settings') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<?php $data = @json_decode($settings['seo_settings'],true); ?>
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="form-group col-md-12">
							<label><?= !empty(lang('title'))?lang('title'):"Title";?></label>
							<input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"title";?>" value="<?= isset($data['title'])?html_escape($data['title']):""; ?>">
						</div>

						<div class="form-group col-md-12">
							<label><?= !empty(lang('keywords'))?lang('keywords'):"keywords";?></label>
							<input type="text" name="keywords" id="keywords" class="form-control" placeholder="<?= !empty(lang('keywords'))?lang('keywords'):"keywords";?>" value="<?= isset($data['keywords'])?html_escape($data['keywords']):""; ?>">
						</div>

						<div class="form-group col-md-12">
							<label for="price"><?= !empty(lang('description'))?lang('description'):"sub heading";?></label>
							<textarea name="description" id="" class="form-control " cols="10" rows="5"><?= !empty($data['description'])?$data['description']:""; ?></textarea>
						</div>

					</div>
				</div><!-- card-body -->
				<div class="card-footer">
					<input type="hidden" name="id" value="<?= isset($settings['id'])?html_escape($settings['id']):0; ?>">
					<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</div><!-- col-9 -->
	</form>
</div>
