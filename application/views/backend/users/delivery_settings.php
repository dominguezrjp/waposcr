	<div class="row">
			<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	<form class="email_setting_form validForm" action="<?= base_url('admin/auth/add_delivery_settings');?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<div class="col-md-5">
			<div class="card">
				<div class="card-header">
					<h4><?= lang('radius_base_delivery_settings'); ?></h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 mb-20">
							<div class="custom-control custom-switch prefrence-item ml-10">
								<div class="gap">
									<input type="checkbox" id="is_radius" name="is_radius" class="switch-input "  <?= isset(restaurant()->is_radius) && restaurant()->is_radius==1?"checked" : "" ;?>>

									<label for="is_radius" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

								</div>
								<div class="preText">
									<div class="">
										<label class="custom-control-label"><?= !empty(lang('enable_radius_base_delivery'))?lang('enable_radius_base_delivery'):'Enable Raduis Based Delivery' ;?></label>
										<p class="text-muted"><small><?= !empty(lang('enable_to_allow_in_your_system'))?lang('enable_to_allow_in_your_system'):"Enable to allow in your system"; ?>.</small></p>
									</div>
								</div>
							</div><!-- custom-control -->
						</div>

						<?php $radius_config = json_decode(restaurant()->radius_config) ?>

						<div class="form-group col-md-12">
							<label><?= lang('latitude');?>  <span class="error">*</label>
							<input type="text" name="latitude"  class="form-control" placeholder="<?= !empty(lang('latitude'))?lang('latitude'):"Whatsapp Number";?>" value="<?= isset($radius_config->latitude) && !empty($radius_config->latitude)?$radius_config->latitude : "" ;?>" required>

						</div>

						<div class="form-group col-md-12">
							<label><?= lang('longitude');?>  <span class="error">*</label>
							<input type="text" name="longitude"  class="form-control" placeholder="<?= !empty(lang('longitude'))?lang('longitude'):"Whatsapp Number";?>" value="<?= isset($radius_config->longitude) && !empty($radius_config->longitude)?$radius_config->longitude : "" ;?>" required>

						</div>

						<div class="form-group col-md-12">
							<label><?= lang('radius');?></label>
							<div class="input-group ">
								<input type="number" name="radius" class="form-control" value="<?= isset($radius_config->radius) && !empty($radius_config->radius)?$radius_config->radius : "" ;?>" placeholder="<?= lang('radius');?>" required>
								<span class="input-group-addon">Km</span>
							</div>
						</div>

						<div class="form-group col-md-12">
							<label><?= lang('not_found_msg');?></label>
							<textarea name="msg" id="not_found_msg" class="form-control" cols="5" rows="5"><?= isset($radius_config->msg) && !empty($radius_config->msg)?$radius_config->msg : "" ;?></textarea>
						</div>
						

						
					</div><!-- row -->
				</div><!-- card-body -->
				<div class="card-footer text-right">
					<input type="hidden" name="id" value="<?= isset(restaurant()->id)?html_escape(restaurant()->id):0; ?>">
					<button type="submit" class="btn btn-secondary"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</div><!-- col-9 -->
	</form>
		
</div>








































































