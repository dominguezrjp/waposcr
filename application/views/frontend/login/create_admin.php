<?php $settings = settings(); ?>
<section class="login_page">
	<div class="login_wrapper">
		<div class="row flex_common xs-reverse">
			<div class="col-md-5">
				<div class="left_create_admin">
					<div class="left_top_login">
						<span class="reg_msg block">
							<div class="alert alert-success alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong><i class="fas fa-check"></i> Success ! </strong>
								<p> Your site is near to live</p>
								<p>Please Set your information Here.</p>
							</div>
						</span>

						<span class="reg_msg block">
							<div class="alert alert-info alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								 <div class="d_flex_alert">
			                        <strong><i class="icon fas fa-question-circle"></i> Info!</strong>
			                        <div class="double_text">
			                            <div class="text-left">
			                               <p> You have to enter purchases code to active this site</p>
											<p>If you need help to find purchase code</p>
			                                
			                            </div>
			                           <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" class="re_url" target="blank">click here!</a>
			                        </div>
			                    </div>
							</div>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-7 col-lg-7 col-xs-12 col-sm-7">

				<div class="right_form_login signup ">
					<div class="login_content">
						<div class="user_login_header">
							<h4 class="heading">Registration as Author</h4>
						</div>
						<div class="form_content signup">
							<span class="reg_msg block">
								<?php $this->load->view('backend/inc/success_msg'); ?>
							</span>
							<form action="<?= base_url('login/create_admin') ;?>" method="post">
								<?=  csrf();?>
								<div class="login_form">
									<div class="form-group">
										<label><i class="fa fa-shopping-cart"></i> <?= !empty(lang('purchase_code'))?lang('purchase_code'):"Purchase code";?></label>
										<input type="text" name="code" class="form-control" placeholder="<?= !empty(lang('purchase_code'))?lang('purchase_code'):"Purchase code";?>" autocomplete="off">
									</div>

									<div class="form-group">
										<label><i class="fa fa-user-secret"></i> <?= !empty(lang('admin_username'))?lang('admin_username'):"Admin username";?></label>
										<input type="text" name="username" id="username" class="form-control" placeholder="<?= !empty(lang('username'))?lang('username'):"username";?>" autocomplete="off">
										<div class="alert_msg"></div>
					                      <div class="register_loader" style="display:none ;">
					                        <div class="searching"></div>
					                      </div>
									</div>

									<div class="form-group">
										<label><i class="fa fa-envelope-o"></i> <?= !empty(lang('admin_email'))?lang('admin_email'):"Admin email";?></label>
										<input type="text" name="email" class="form-control" placeholder="<?= !empty(lang('email'))?lang('email'):"email";?>">
									</div>

									<div class="row">
										<div class="form-group col-md-6 card-pr-5">
											<label><i class="fa fa-key"></i> <?= !empty(lang('admin_password'))?lang('admin_password'):"Admin password";?> </label>
											<input type="password" name="password" class="form-control" placeholder="<?= !empty(lang('password'))?lang('password'):"password";?>">
										</div>
										<div class="form-group col-md-6 card-pl-5">
											<label><i class="fa fa-key"></i> <?= !empty(lang('confirm_password'))?lang('confirm_password'):"confirm password";?> </label>
											<input type="password" name="cpassword" class="form-control" placeholder="<?= !empty(lang('confirm_password'))?lang('confirm_password'):"confirm password";?>">
										</div>
									</div>

									<div class="form-group">
										<input type="hidden" name="site_id" value="<?=  isset($settings['site_id'])?$settings['site_id']:"";?>">
										<button type="submit" class="btn btn-info"> <?= !empty(lang('submit'))?lang('submit'):"Submit";?> &nbsp; <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
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
