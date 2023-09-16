<?php $settings = settings(); ?>
<section class="login_page">
	<div class="login_wrapper">
		<div class="row flex_common xs-reverse">
			<div class="col-md-12 col-lg-5 col-xs-12 col-sm-12">
				<?php include 'inc/login_left_content.php'; ?>
			</div>
			<div class="col-md-12 col-lg-7 col-xs-12 col-sm-12">
				<div class="right_form_login forgetPassword">
					<div class="login_content">
						<div class="user_login_header">
							<h4 class="heading"><?= lang('forgot_password'); ?></h4>
							<p><?= lang('forget_pass_alert'); ?></p>
						</div>
						<div class="form_content"> 
							<span class="reg_msg"></span>
							<form action="<?= base_url('login/recovery_password') ?>" method="post" class="form-submit">
								<?= csrf() ;?>
								<div class="login_form" >
									<div class="form-group">
										<label><i class="fa fa-envelope-o"></i> <?= lang('email'); ?></label>
										<input type="text" name="email" class="form-control" placeholder="Username / Email">
									</div>

									<div class="form-group">
										<button type="submit" class="btn btn-info"> <?= lang('submit'); ?> &nbsp; <i class="fa fa-angle-double-right"></i> </button>
									</div>
									

									<div class="form-group">
										<p><?= lang('remember_password'); ?><a href="<?= base_url('login') ;?>"><?= lang('sign_in'); ?></a></p>
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