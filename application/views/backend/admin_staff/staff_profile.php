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
						<form class="" action="<?= base_url('admin/adminstaff/update_staff_profile') ?>" method="post">
							<?=  csrf();?>

							<div class="row">
								<div class="form-group col-sm-6">
									<label  class="control-label"><?= !empty(lang('name'))?lang('name'):"Name";?></label>

									<div class="">
										<input type="text" name="name" class="form-control"  placeholder="<?= !empty(lang('name'))?lang('name'):"name";?>" value="<?= html_escape($auth_info['name']); ?>">
									</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="control-label"><?= !empty(lang('email'))?lang('email'):"email";?></label>

									<div class="">
										<input type="email" class="form-control"  name="email" placeholder="<?= !empty(lang('email'))?lang('email'):"email";?>" value="<?= html_escape($auth_info['email']); ?>" readonly>
										
									</div>
								</div>

								<div class="form-group col-sm-6">
									<label class="control-label"><?= !empty(lang('phone'))?lang('phone'):"phone";?></label>

									<div class="">
										<input type="hidden" name="id" value="<?= $auth_info['id'] ;?>">
										<input type="text" class="form-control"  name="phone" placeholder="<?= !empty(lang('phone'))?lang('phone'):"phone";?>" value="<?= html_escape($auth_info['phone']); ?>">
										
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<div class="permisionList">
										<h4><?= !empty(lang('available_permossion'))?lang('available_permossion'):"Available Permission";?> </h4>
										<ul>
											<?php foreach ($permission_list as $key => $value): ?>
												<li><?php if(is_access($value['slug'])==1): ?>
													<i class="icofont-check-alt bg-success-soft"></i>
												<?php else: ?>
													<i class="icofont-close-line bg-danger-soft"></i>
												<?php endif;?>

												 <h4><?= $value['title'] ;?></h4></li>
											<?php endforeach ?>
										</ul>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-md-12">
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
					<form class="form-horizontal " action="<?= base_url('admin/adminstaff/change_pass') ?>" method="post" id="change_pass_form">
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
					<form action="<?= base_url('admin/adminstaff/upload_profile'); ?>" class="upload_img" method="post" enctype= "multipart/form-data"> 
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