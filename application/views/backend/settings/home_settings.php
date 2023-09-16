<div class="row">
	<?php include APPPATH."views/backend/dashboard/admin_inc/alert_info.php"; ?>
</div>
<div class="row">
	<?php include 'inc/leftsidebar.php'; ?>
	<form class="email_setting_form" action="<?= base_url('admin/settings/add_home_setting') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="form-group  col-md-4 col-sm-6 col-xs-6">
							<label ><?= !empty(lang('users'))?lang('users'):"users";?></label>
							<div class="gap">
								<input type="checkbox" id="is_user" name="set-name" class="switch-input setting_option" data-type="is_user" data-value="<?= $settings['is_user'];?>" <?= isset($settings['is_user']) && $settings['is_user']==1?'checked':'';?>>
								<label for="is_user" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>
							</div>
						</div>


						<div class="form-group  col-md-4 col-sm-6 col-xs-6">
							<label ><?= !empty(lang('order_video'))?lang('order_video'):"order video";?></label>
							<div class="gap">
								<input type="checkbox" id="is_order_video" name="set-name" class="switch-input setting_option" data-type="is_order_video" data-value="<?= $settings['is_order_video'];?>" <?= isset($settings['is_order_video']) && $settings['is_order_video']==1?'checked':'';?>>
								<label for="is_order_video" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>
							</div>
						</div>
					</div>



					<?php $socila_data = json_decode($settings['social_sites']); ?>
					<div class="row">
						<div class="form-group col-md-6">
					      	<div class="input-group">
				                <span class="input-group-addon" title="Facebook"><i class="fa fa-facebook"></i></span>
				                <input type="text" class="form-control" name="facebook" autocomplete="off" value="<?= isset($socila_data->facebook)?$socila_data->facebook:"";?>" placeholder="<?= lang('facebook_link'); ?>">
			              </div>
					    </div>

					    <div class="form-group col-md-6">
					      	<div class="input-group">
				                <span class="input-group-addon" title="Whatsapp"><i class="fa fa-whatsapp"></i></span>
				                 <span class="input-group-addon" title="Whatsapp"><?= user()->dial_code ;?></span>
				                <input type="text" class="form-control" name="whatsapp" autocomplete="off" value="<?= !empty($socila_data->whatsapp)?$socila_data->whatsapp:"";?>" placeholder="<?= lang('whatsapp'); ?>">
			              </div>
					    </div>

					</div>

					<div class="row">
						<div class="form-group col-md-6">
					      	<div class="input-group">
				                <span class="input-group-addon" title="Linkedin"><i class="fa fa-linkedin-square"></i></span>
				                <input type="text" class="form-control" name="linkedin" autocomplete="off" value="<?= !empty($socila_data->linkedin)?$socila_data->linkedin:"";?>" placeholder="<?= lang('linkedin'); ?>">
			              </div>
					    </div>

					    <div class="form-group col-md-6">
					      	<div class="input-group">
				                <span class="input-group-addon" title="Instagram"><i class="fa fa-instagram"></i></span>
				                <input type="text" class="form-control" name="instagram" autocomplete="off" value="<?= !empty($socila_data->instagram)?$socila_data->instagram:"";?>" placeholder="<?= lang('instagram'); ?>">
			              </div>
					    </div>

					</div>

					<div class="row">
						<div class="form-group col-md-6">
					      	<div class="input-group">
				                <span class="input-group-addon" title="phone"><i class="fas fa-phone"></i></span>
				                <span class="input-group-addon" title="Whatsapp"><?= user()->dial_code ;?></span>
				                <input type="text" class="form-control" name="phone" autocomplete="off" value="<?= !empty($socila_data->phone)?$socila_data->phone:"";?>" placeholder="<?= lang('phone'); ?>">
			              </div>
					    </div>

					    <div class="form-group col-md-6">
					      	<div class="input-group">
				                <span class="input-group-addon" title="youtube"><i class="fab fa-youtube"></i></span>
				                <input type="text" class="form-control" name="youtube" autocomplete="off" value="<?= !empty($socila_data->youtube)?$socila_data->youtube:"";?>" placeholder="<?= lang('youtube'); ?>">
			              	</div>
					    </div>
					    <div class="form-group col-md-6">
					      	<div class="input-group">
				                <span class="input-group-addon" title="email"><i class="fa fa-envelope-o"></i></span>
				                <input type="text" class="form-control" name="email" autocomplete="off" value="<?= !empty($socila_data->email)?$socila_data->email:"";?>" placeholder="<?= lang('email'); ?>">
			              	</div>
					    </div>
					</div>
					<div class="row">
						<hr>
					    <div class="form-group col-md-6">
					    	<label for=""><?= lang('order_video'); ?></label>
					      	<div class="input-group">
				                <span class="input-group-addon" title="youtube"><i class="fab fa-youtube"></i></span>
				                <input type="text" class="form-control" name="order_video" autocomplete="off" value="<?= !empty($socila_data->order_video)?$socila_data->order_video:"";?>" placeholder="<?= lang('order_video'); ?>">
			              	</div>
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






