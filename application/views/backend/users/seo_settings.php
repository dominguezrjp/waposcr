<div class="row">
	<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	<div class="col-md-6">
		<?php $data = json_decode($settings['seo_settings'],true); ?>
		<form class="email_setting_form" action="<?= base_url('admin/auth/add_seo_settings') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<?= csrf() ;?>
			<div class="card">
				<div class="card-header">
					<h4><?= !empty(lang('seo_settings'))?lang('seo_settings'):"Seo Settings";?></h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="form-group col-sm-12">
							<label class="control-label"><?= !empty(lang('google_analytics'))?lang('google_analytics'):"google analytics";?> </label>

							<div class="">
								<input type="text" class="form-control"  name="analytics_id" placeholder="<?= !empty(lang('google_analytics_id'))?lang('google_analytics_id'):"google analytics ID";?>" value="<?= !empty($settings['analytics_id'])?$settings['analytics_id']:''; ?>">

							</div>
						</div>

						<div class="form-group col-sm-12">
							<label class="control-label"><?= !empty(lang('facebook_pixel'))?lang('facebook_pixel'):"Facebook Pixel";?> </label>

							<div class="">
								<input type="text" class="form-control"  name="pixel_id" placeholder="<?= !empty(lang('facebook_pixel_id'))?lang('facebook_pixel_id'):"Facebook Pixel ID";?>" value="<?= !empty($settings['pixel_id'])?$settings['pixel_id']:''; ?>">

							</div>
						</div>
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
					    
					</div><!-- row -->
						
				</div><!-- card-body -->
				<div class="card-footer">
					<input type="hidden" name="id" value="<?= isset($settings['id']) && $settings['id'] !=0?$settings['id']:0 ?>">
					<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</form>
	</div><!-- col-9 -->
	
</div>