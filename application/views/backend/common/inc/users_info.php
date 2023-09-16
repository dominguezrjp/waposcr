<?php if($this->auth['user_role']==0):?>
	<?php if(!empty(restaurant()->name) || !empty(restaurant()->phone) || @restaurant()->country_id != 0 ||  !empty(restaurant()->dial_code) ): ?>
		<div class="row">
			<div class="col-md-4 ">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"><?= !empty(lang('owner_profile'))?lang('owner_profile'):"Owner Profile";?></h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body" >
						<div class="user_profile_view">
							<div class="image_field">
								<img src="<?= base_url(!empty($auth_info['thumb'])?$auth_info['thumb']:'assets/frontend/images/avatar.png');?>" alt="">
							</div>
							<div class="single_details_profile mt-10">
								<div class="user_contact_details">
									<h4> <i class="fa fa-user-circle"></i> <?= html_escape($auth_info['name']) ;?> - <label title="Member Since" data-toggle="tooltip" data-placement="top"><i class="fa fa-clock-o"></i> <?= html_escape(full_date($auth_info['created_at']),$auth_info['id']) ;?></label> </h4>
									
									<div class=" profile_bottom_details">
										<?php if($auth_info['country'] !=0): ?>
											<p><b><i class="fa fa-map-marker"></i> <?= html_escape(get_country($auth_info['country'])['name']) ;?> - <?= html_escape(get_country($auth_info['country'])['currency_symbol']) ;?> - <?= !empty($auth_info['dial_code'])?$auth_info['dial_code']: get_country($auth_info['country'])['dial_code'] ;?></b> </p>
										<?php endif;?>

										<?php if(isset($auth_info['email']) && !empty($auth_info['email'])): ?>
											<p><b><i class="fa fa-envelope-o"></i> <?=  ucfirst($auth_info['email']);?></b></p>
										<?php endif;?>

										<?php if(isset($auth_info['phone']) && !empty($auth_info['phone'])): ?>
											<p><b><i class="fa fa-phone"></i><?= !empty($auth_info['dial_code'])?$auth_info['dial_code']: get_country($auth_info['country'])['dial_code'] ;?> <?=  $auth_info['phone'];?></b></p>
										<?php endif;?>

										<p><b title="last login" data-toggle="tooltip" data-placement="top"><i class="fa fa-laptop"></i>  <?= html_escape(full_time($auth_info['last_login'])) ;?></b> </p>


										<p class="text-center verified_item"> 
											<span data-toggle="tooltip" data-placement="top" title=" <?= $auth_info['is_active']==1?"Active User":"User is not active" ;?>"><i class="fas fa-user-shield <?= $auth_info['is_active']==1?"c_green":"c_red" ;?>"></i></span> 

											<span data-toggle="tooltip" data-placement="top" title="<?= $auth_info['is_verify']==1?"Email Verified":"Email is not Verified" ;?> "><i class="fa fa-envelope <?= $auth_info['is_verify']==1?"c_green":"c_red" ;?>"></i></span> 
											<span data-toggle="tooltip" data-placement="top" title="<?= $auth_info['is_payment']==1?"Payment Verified":"Payment is not Verified" ;?>"><i class="fa fa-credit-card <?= $auth_info['is_payment']==1?"c_green":"c_red" ;?>"></i>
											</span>
											<?php if($auth_info['is_expired']==1): ?>
												<span data-toggle="tooltip" data-placement="top" title="Account Expired"><i class="fa fa-ban c_red"></i></span>
											<?php endif;?>
										</p>
									</div>
								</div><!-- user_contact_details -->
							</div><!-- single_details_profile -->
							<?php if($auth_info['id']==auth('id')): ?>
							<div class="edit_add_info text-center">
								<a href="<?= base_url('admin/auth/edit_profile/'.md5($auth_info['id'])) ;?>" class="btn btn-success btn-flat"> <i class="fa fa-plus mr-5"></i> <?= lang('add_edit_info'); ?></a>
							</div>
							<?php endif;?>
						</div><!-- user_profile_img -->
					</div><!-- /.box-body -->
				</div>
				<div class="card">
					<div class="card-body">
						<?php if(!auth('is_staff')): ?>
				            <?php if($auth_info['is_deactived']==0): ?>
				                <a href="<?= base_url('admin/auth/deactive_account/1/'.html_escape($auth_info['username'])); ?>" class="action_btn deactivation_btn btn" data-msg="<?= lang('want_to_deactive_account'); ?>">
				                  <i class="fa fa-ban"></i> <span><?= !empty(lang('deactive_account'))?lang('deactive_account'):"Deactive Account";?></span>
				                </a>
				              <?php else: ?> <!-- is_deactive -->
				              
				                <a href="<?= base_url('admin/auth/deactive_account/0/'.html_escape($auth_info['username'])); ?>" data-msg="<?= lang('want_to_active_account'); ?>" class="action_btn activation_btn btn">
				                  <i class="fa fa-check"></i> <span><?= !empty(lang('active_account'))?lang('active_account'):"Active Account";?></span>
				                </a>
				              <?php endif;?> <!-- deactive -->
				            <?php endif;?>
					</div>
				</div>
			</div>
		</div>
	<?php else: ?>
		<?php include APPPATH.'views/backend/dashboard/install_profile.php'; ?>
	<?php endif; ?>
<?php endif ?>


<?php if($auth_info['id']==auth('id') && auth('user_role')==0): ?>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
				<?php if($this->is_empty['country']==0 && $this->is_empty['profile_pix']==0 && $this->is_empty['phone']==0): ?>
					<div class="single_alert alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<div class="d_flex_alert">
							<h4><i class="icon fas fa-warning"></i> <?= lang('Warning'); ?></h4>
							<div class="double_text">
								 <h4 class="mb-5"><?= lang('Those Steps are most important to configure first');?></h4>
								<?php lang('empty-phone');?></p>
								
								<?php  if($this->is_empty['profile_pix']==0):?>
									<p><?= lang('empty-profile');?></p>
								<?php endif;?>
								<?php if($this->is_empty['country']==0): ?>	
									<p><?= lang('empty-country-1');?> </p>
									<p><?= lang('empty-country-2');?> </p>
								<?php endif;?>

								<a href="<?= base_url('admin/restaurant/general') ;?>" class="re_url"><?= lang('click_here'); ?></a>
							</div>
						</div>
					</div>
				<?php endif;?>


				<?php if(empty(restaurant()->phone) && isset(restaurant()->country_id) && restaurant()->country_id == 0 && auth('user_role')==0): ?>
					<div class="single_alert alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<div class="d_flex_alert">
							<h4><i class="icon fas fa-warning"></i> <?= lang('Warning'); ?></h4>
							<div class="">
								<h4><?= lang('restaurant_empty_msg');?></h4>
								<p><?= lang('restaurant_empty_msg-2');?></p>
								<p><?= lang('restaurant_empty_msg-3');?></p>
							</div>
							 <a href="<?= base_url('admin/restaurant/general') ;?>" class="re_url"><?= lang('click_here'); ?></a>
						</div>
					</div>
				<?php endif;?>
			</div>
		</div>
	</div>
<?php endif;?>