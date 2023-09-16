<div class="row">
		<?php include 'inc/leftsidebar.php'; ?>
	<div class="col-md-6">
		<form action="<?= base_url('admin/settings/add_pwa') ;?>" method="post" class="validForm" enctype= "multipart/form-data">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
			<div class="card pwa">
				<div class="card-header"><h4><?= lang('pwa'); ?></h4></div>
				<div class="card-body">
					<?php $pwa = json_decode($settings['pwa_config']); ?>
					<div class="row">
						<div class="col-md-12 text-center">
							<div class="form-group ">
								<label for=""><?= !empty(lang('logo'))?lang('logo'):"Logo";?></label>
								<div class="">
									<label class="image_upload_box logo pwa">
										<img src="<?= !empty($pwa->logo)?base_url($pwa->logo):base_url('assets/frontend/images/logo.jpg'); ?>" class="service_icon_preview" alt="">
										<input type="file" name="images" class="pwa_img" data-height="500" data-width="500">
										<input type="hidden" name="old_img" value="<?= !empty($pwa->logo)?$pwa->logo:""; ?>">
									</label>
								</div>

								<span class="img_error"></span>
							</div>
						</div>

						<div class="form-group col-md-12">
							<label for=""><?= lang('title'); ?> <span class="error">*</span></label>
							<input type="text" name="title" class="form-control" value="<?= !empty($pwa->title)? $pwa->title:"";?>" required>
							
						</div>
						<div class="form-group col-md-6">
							<label><?= !empty(lang('theme_color'))?lang('theme_color'):"Theme Color" ;?>:</label>

							<div class="color_picker">
								<div class="input-group my-colorpicker2 colorpicker-element">
									<input type="text" class="form-control" name="theme_color" value="<?= !empty($pwa->theme_color)? $pwa->theme_color:"FF9800";?>">

									<div class="input-group-addon">
										<i style="background-color: #FF9800;"></i>
									</div>
								</div>	
							</div>
						</div>

						<div class="form-group col-md-6">
							<label><?= !empty(lang('background_color'))?lang('background_color'):"Background Color" ;?>:</label>

							<div class="color_picker">
								<div class="input-group my-colorpicker2 colorpicker-element">
									<input type="text" class="form-control" name="background_color" value="<?= !empty($pwa->background_color)? $pwa->background_color:"FF9800";?>">

									<div class="input-group-addon">
										<i style="background-color: #FF9800;"></i>
									</div>
								</div>	
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label class="custom-radio mr-20"> <input type="radio" name="is_pwa_active" checked  <?= isset($pwa->is_pwa_active) && $pwa->is_pwa_active==1?"checked":"";?> value="1"><?= lang('active')?></label>

								<label class="custom-radio"> <input type="radio" name="is_pwa_active" value="0" <?= isset($pwa->is_pwa_active) && $pwa->is_pwa_active==0?"checked":"";?> ><?= lang('disable')?></label>
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

