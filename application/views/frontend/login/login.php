<?php $settings = settings(); ?>
<section class="signupSection">
	<div class="login_wrapper">
		<div class="row flex_common xs-reverse">
			<div class="col-md-12 col-lg-5 col-xs-12 col-sm-12">
				<?php include 'inc/login_left_content.php'; ?>
			</div>
			<div class="col-md-12 col-lg-7 col-xs-12 col-sm-12">
				<div class="right_form_login loginForm">
					<div class="topSigin">
						<div class="login_content mt-0 pt-0">
							<div class="user_login_header">
								<h4 class="heading"><?= !empty(lang('sign_in'))?lang('sign_in'):"Sign In";?></h4>
								<p><?= !empty(lang('sign_in_text'))?lang('sign_in_text'):"";?></p>
							</div>

							<div class="form_content">
								<?php if ($this->session->flashdata('verify')) { ?>
									<div class="single_alert text-left alert alert-success alert-dismissible mb-5" id="successMessage">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<h4>
											<i class="icon fa fa-check"></i>
											<?= lang('success'); ?>
										</h4>
										<?= $this->session->flashdata('verify') ;?>
									</div>
								<?php } ?>
								<span class="reg_msg"></span>
								<form action="<?= base_url('login/user_login') ?>" class="" method="post" id="user_login_form" autocomplete="off">
									<?= csrf() ;?>
									<div class="login_form" >
										<div class="form-group">
											<label><i class="fa fa-user-secret"></i><?= !empty(lang('username'))?lang('username'):"username";?>/ <?= !empty(lang('email'))?lang('email'):"email";?></label>
											<input type="text" name="email" class="form-control usermail" placeholder="<?= !empty(lang('username'))?lang('username'):"username";?> / <?= !empty(lang('email'))?lang('email'):"email";?>">
										</div>

										<div class="form-group">
											<label><i class="fa fa-key"></i> <?= !empty(lang('password'))?lang('password'):"password";?> <?php if((isset($type) && $type=='customer') || !isset($type)): ?> <a href="<?= base_url('login/forgot');?>" class="ml-7"><?= !empty(lang('forgot'))?lang('forgot'):"Forgot?";?></a> <?php endif ?></label>
											<input type="password" name="password" class="form-control pass" placeholder="<?= !empty(lang('password'))?lang('password'):"password";?>">
										</div>
										<div class="form-group">
											<?php if(isset($settings['is_recaptcha']) && $settings['is_recaptcha']==1): ?>
												<?php if(isset($this->settings['recaptcha']->site_key) && !empty($this->settings['recaptcha']->site_key)): ?>
												<div class="g-recaptcha" data-sitekey="<?= $this->settings['recaptcha']->site_key;?>"></div>
											<?php endif;?>
										<?php endif;?>
									</div>

									<div class="form-group">
										<button type="submit" class="btn btn-info"><i class="fa fa-sign-in"></i> &nbsp; <?= !empty(lang('sign_in'))?lang('sign_in'):"Sign In";?></button>
									</div>

									

									<div class="form-group">
										<p><?= !empty(lang('dont_have_account'))?lang('dont_have_account'):"Don't have account";?>? <a href="<?= base_url('sign-up') ;?>"><?= !empty(lang('sign-up'))?lang('sign-up'):"Sign Up";?></a></p>
									</div>
								</div>
							</form>
						</div>
					<?php if(is_demo()==1): ?>
						<div class="btns" style="display: flex;
							align-items: center;
							justify-content: center;
							margin-top: 35px;
							flex-wrap: wrap; margin-bottom: 5px;">
							<a href="javascript:;" data-user="admin" data-pas="1234" class="btn btn-info mr-1 loginBTN">Admin Login</a>
							<a href="javascript:;" data-user="phplime" data-pas="1234" class="btn btn-info mr-1 loginBTN">Restaurant Login</a>
						</div>
						<div class="user" style="display: flex;
						align-items: center;
						justify-content: center;
						margin-top: 35px;
						flex-wrap: wrap;">
						<div class="mr-10" style="margin-right: 30px;"><h4>Admin Access</h4>
							<code>
								username: admin <br>
								password: 1234
							</code>

						</div>

						<div class=""><h4>Restaurant Access</h4>
							<code>
								username: phplime <br>
								password: 1234
							</code>

						</div>
					</div>
				<?php endif;?>



					</div>
				</div>
					<div class="othersLogin">
						<ul>
							<li><a href="<?= base_url('staff-login/staff') ;?>"><i class="icofont-users-social"></i> <?= lang('staff_login') ;?></a></li>
							<li><a href="<?= base_url('staff-login/customer') ;?>"><i class="icofont-users-alt-4"></i> <?= !empty(lang('customer_login'))?lang('customer_login'):"Customer Login" ;?></a></li>
							<?php if(check()==1): ?>
								<li><a href="<?= base_url('staff-login/delivery') ;?>"><i class="icofont-fast-delivery"></i> <?= !empty(lang('delivery_guy_login'))?lang('delivery_guy_login'):"Delivery Guy Login" ;?></a></li>
							<?php endif;?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>						