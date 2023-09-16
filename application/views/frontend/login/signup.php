<?php $settings = settings(); ?>
<section class="signupSection">
	<div class="login_wrapper">
		<div class="row flex_common xs-reverse">
			<div class="col-md-12 col-lg-5 col-xs-12 col-sm-12">
				<?php include 'inc/login_left_content.php'; ?>
			</div>
			<div class="col-md-12 col-lg-7 col-xs-12 col-sm-12">
				<div class="right_form_login signup ">
					<div class="login_content">
						<div class="user_login_header" data-aos="fade-down" data-aos-delay="100">
							<h4 class="heading" ><?= !empty(lang('sign-up'))?lang('sign-up'):"sign up";?></h4>
							<p><?= !empty(lang('sign_up_text'))?lang('sign_up_text'):"";?></p>
						</div>
						<div class="form_content signup">
							<span class="reg_msg"></span>
							<form action="<?= base_url('login/user_registration') ;?>" method="post" class="form-submit" autocomplete="off">
								<?=  csrf();?>
								<?php isset($_GET['u']) && !empty($_GET['u'])?$username = $_GET['u']:$username = ""; ?>
								<div class="login_form">
									<div class="form-group">
										<label><i class="fa fa-user-secret"></i> <?= !empty(lang('restaurant_username'))?lang('restaurant_username'):"Restaurant name";?></label>
										<input type="text" name="username" id="username" class="form-control" placeholder="<?= !empty(lang('restaurant_username'))?lang('restaurant_username'):"Restaurant name";?>" autocomplete="off" value="<?= $username ;?>">
										<div class="alert_msg"></div>
					                      <div class="register_loader" style="display:none ;">
					                        <div class="searching"></div>
					                      </div>
									</div>

									<div class="form-group">
										<label><i class="fa fa-user-circle"></i> <?= !empty(lang('owner_name'))?lang('owner_name'):"Owner Name";?></label>
										<input type="text" name="name"  class="form-control" placeholder="<?= !empty(lang('owner_name'))?lang('owner_name'):"Owner Name";?>" autocomplete="off">
									</div>

									<div class="form-group">
										<label><i class="fa fa-envelope-o"></i> <?= !empty(lang('email'))?lang('email'):"email";?></label>
										<input type="text" name="email" class="form-control" placeholder="<?= !empty(lang('email'))?lang('email'):"email";?>">
									</div>
									<div class="form-group" style="direction:ltr;">
										<label><i class="fa fa-phone"></i> <?= !empty(lang('phone'))?lang('phone'):"phone";?></label>
										<input type="text" name="phone" class="form-control" id="phone" placeholder="<?= !empty(lang('phone'))?lang('phone'):"phone";?>">
										<input type="hidden" name="country_code" class="country_code" value="">
										<input type="hidden" name="dial_code" class="dial_code" value="">
									</div>

									<div class="row">
										<div class="form-group col-md-6 card-pr-5">
											<label><i class="fa fa-key"></i> <?= !empty(lang('password'))?lang('password'):"password";?> </label>
											<input type="password" name="password" class="form-control" placeholder="<?= !empty(lang('password'))?lang('password'):"password";?>">
										</div>
										<div class="form-group col-md-6 card-pl-5">
											<label><i class="fa fa-key"></i> <?= !empty(lang('confirm_password'))?lang('confirm_password'):"confirm password";?> </label>
											<input type="password" name="cpassword" class="form-control" placeholder="<?= !empty(lang('confirm_password'))?lang('confirm_password'):"confirm password";?>">
										</div>
									</div>

									<div class="form-group">
										<?php if(isset($settings['is_recaptcha']) && $settings['is_recaptcha']==1): ?>
											<?php if(isset($this->settings['recaptcha']->site_key) && !empty($this->settings['recaptcha']->site_key)): ?>
									           <div class="g-recaptcha" data-sitekey="<?= $this->settings['recaptcha']->site_key;?>"></div>
									        <?php endif;?>
								         <?php endif;?>
									</div>


									<div class="form-group">
										<label class="pointer"> <input type="checkbox" name="terms" value="1">&nbsp; <?= lang('read_terms'); ?><a href="<?= base_url('terms-conditions') ?>"><?= lang('terms_condition'); ?></a> <?= lang('accept_them'); ?></label>
									</div>



									<div class="form-group">
										<button type="submit" class="btn btn-info"><i class="fa fa-user-plus"></i> &nbsp; <?= !empty(lang('sign-up'))?lang('sign-up'):"sign up";?></button>
									</div>


									<div class="form-group">
										<p><?= !empty(lang('already_member'))?lang('already_member'):"Already a Member?";?> <a href="<?= base_url('login') ;?>"><?= !empty(lang('sign_in'))?lang('sign_in'):"sign in";?></a></p>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>						
