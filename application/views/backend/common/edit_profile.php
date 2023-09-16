<div class="row">
	<div class="col-md-8">
		<div class="reg_msg"></div>
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#activity" data-toggle="tab"><i class="fa fa-user-circle"></i>  <?= !empty(lang('profile'))?lang('profile'):"Profile";?></a></li>
				<li><a href="#settings" data-toggle="tab"><i class="fa fa-key"></i> &nbsp;<?= !empty(lang('change_pass'))?lang('change_pass'):"Change password";?></a></li>
			</ul>
			<div class="tab-content">
				<div class="active tab-pane" id="activity">
					<!-- Post -->
					<div class="post">
						<form class="validForm" action="<?= base_url('admin/auth/update_profile') ?>" method="post">
							<?=  csrf();?>

							<div class="row">
								<div class="form-group col-sm-6">
									<label  class="control-label"><?= !empty(lang('owner_name'))?lang('owner_name'):"owner name";?></label>

									<div class="">
										<input type="text" name="name" class="form-control"  placeholder="<?= !empty(lang('owner_name'))?lang('owner_name'):"Owner name";?>" value="<?= html_escape($auth_info['name']); ?>">
									</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="control-label"><?= !empty(lang('email'))?lang('email'):"email";?> <span class="error">*</span></label>

									<div class="">
										<input type="email" class="form-control"  name="email" placeholder="<?= !empty(lang('email'))?lang('email'):"email";?>" value="<?= html_escape($auth_info['email']); ?>" required>
										
									</div>
								</div>
							</div>
							<div class="row">

								<div class="form-group col-sm-6">
									<label  class="control-label"><?= !empty(lang('county'))?lang('county'):"county";?> - 
									<?php if(isset($auth_info['country']) && $auth_info['country']!=0): ?> <?= get_country($auth_info['country'])['currency_name'].' ('.get_country($auth_info['country'])['currency_code'].' '.get_country($auth_info['country'])['currency_symbol'].')' ;?> <?php endif;?></label>

									<div class="">
										<select name="country" id="" class="form-control select2 country">
											<option value=""><?= lang('select_county'); ?></option>
											<?php foreach ($countries as $key => $country): ?>
												<option <?= $auth_info['country']==$country['id']?"selected":"" ;?> value="<?=  $country['id'];?>" data-dial="<?=  $country['dial_code'];?>"><?= $country['name'] ;?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								
							</div>
							
							<div class="row">

								<?php if(isset($auth_info['country']) && $auth_info['country'] !=0): ?>
									<div class="form-group col-sm-6">
										<label  class="control-label"><?= !empty(lang('dial_code'))?lang('dial_code'):"Dial Code";?> <span class="error">*</span></label>

										<div class="">
											<input type="text" name="dial_code" class="form-control dial_code" value="<?= !empty($auth_info['dial_code'])?$auth_info['dial_code']: get_country($auth_info['country'])['dial_code'] ;?>">
										</div>
									</div>
								<?php endif;?>	

								<div class="form-group col-sm-6">
									<label  class="control-label"><?= !empty(lang('phone'))?lang('phone'):"Phone";?> <span class="error">*</span></label>

									<div class="">
										<input type="text" name="phone" class="form-control" value="<?=  $auth_info['phone'];?>" placeholder="Phone Number" required>
									</div>
								</div>

							</div>
						
							


							<div class="row">
								<div class="form-group col-sm-6">
									<label  class=" control-label"><?= !empty(lang('gender'))?lang('gender'):"gender";?></label>

									<div class="">
										<select name="gender" id="gender" class="select2 form-control">
											<option value=""><?= !empty(lang('select'))?lang('select'):"Select";?></option>
											<option <?= ($auth_info['gender'] !='') && $auth_info['gender']=="Male"?$m="selected":$m=""; ?> value="Male">Male</option>
											<option <?= ($auth_info['gender'] !='') && $auth_info['gender']=="Female"?$m="Female":$m=""; ?> value="Female">Female</option>
										</select>
									</div>
								</div>
								<div class="form-group col-sm-6">
									<label for="" class=" control-label"><?= !empty(lang('designation'))?lang('designation'):"Designation";?></label>

									<div class="">
										<input type="text" name="designation" class="form-control"  placeholder="<?= !empty(lang('designation'))?lang('designation'):"Designation";?>" value="<?= html_escape($auth_info['designation']); ?>">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="form-group col-sm-6 hidden">
									<label class=" control-label"><?= lang('website'); ?></label>

									<div class="">
										<input type="text" name="website" class="form-control" placeholder="website" value="<?= html_escape($auth_info['website']); ?>">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="form-group col-sm-12">
									<label  class="control-label"><?= !empty(lang('address'))?lang('address'):"address";?></label>

									<div class="">
										<textarea class="form-control"  placeholder="<?= !empty(lang('address'))?lang('address'):"address";?>" name="address"><?= html_escape($auth_info['address']);?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-md-12">
										<a href="<?= base_url('admin/auth/') ?>" class="btn btn-default btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"Cancel";?></a> &nbsp;&nbsp;&nbsp;&nbsp;
										<div class="pull-right">
											<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"save change";?></button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<!-- /.post -->
				</div>

				<div class="tab-pane" id="settings">
					<form class="form-horizontal " action="<?= base_url('admin/auth/change_pass') ?>" method="post" id="change_pass_form">
						<!-- csrf token -->
						   <?= csrf(); ?>

						<div class="form-group">
							<label  class="col-sm-3  control-label"><?= !empty(lang('old_pass'))?lang('old_pass'):"Old Password";?></label>
							<div class="col-sm-9">
								<input type="password" class="form-control"  name="old_pass" placeholder="<?= !empty(lang('old_pass'))?lang('old_pass'):"Old Password";?>">
							</div>
						</div>

						<div class="form-group">
							<label  class="col-sm-3 control-label"><?= !empty(lang('new_pass'))?lang('new_pass'):"New Password";?></label>
							<div class="col-sm-9">
								<input type="password" class="form-control"  name="new_pass" placeholder="<?= !empty(lang('new_pass'))?lang('new_pass'):"New Password";?>">
							</div>
						</div>

						<div class="form-group">
							<label  class="col-sm-3 control-label"><?= !empty(lang('confirm_password'))?lang('confirm_password'):"Confirm Password";?></label>
							<div class="col-sm-9">
								<input type="password" class="form-control"  name="c_pass" placeholder="<?= !empty(lang('confirm_password'))?lang('confirm_password'):"Confirm Password";?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-10 col-md-offset-2">
								<a href="<?= base_url('admin/auth/') ?>" class="btn btn-default btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"Cancel";?></a>
								<div class="pull-right">
									<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- /.tab-pane -->
			</div>
			<!-- /.tab-content -->
		</div>
		<!-- /.nav-tabs-custom -->
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('profile_pic'))?lang('profile_pic'):"Profile Picture";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body" >
				<div class="user_profile_img">
					<form action="<?= base_url('admin/auth/upload_profile'); ?>" class="upload_img" method="post" enctype= "multipart/form-data"> 
						<!-- csrf token -->
						   <?= csrf(); ?>

						<label title="Upload Profile Picture">
							<?php if(empty($auth_info['thumb'])): ?>
								<div class="upload_msg">
									<i class="fa fa-upload"></i>
									<p><?= !empty(lang('profile_pic'))?lang('profile_pic'):"Upload Profile Picture";?></p>
								</div>
							<?php endif ?>
							<img src="<?= !empty($auth_info['thumb'])?base_url($auth_info['thumb']):''; ?>" class="uploaded_img" alt="">
							<input type="file" name="file[]" style="display: none;" accept="image/*">
						</label>

					</form>
					<div class="img_progress">
						<div class="upload_progress" style="display: none;">
							<div class="progress">
								<div class="progress-bar progress-bar-success progress-bar-striped myprogress" role="progressbar" style="width:0%">0%</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>
</div>