<?php $settings = settings(); ?>
<section class="login_page">
	<div class="login_wrapper">
		<div class="row flex_common xs-reverse">
			<div class="col-md-12 col-lg-5 col-xs-12 col-sm-12">
				<?php include APPPATH.'views/frontend/login/inc/login_left_content.php'; ?>
			</div>
			<div class="col-md-12 col-lg-7 col-xs-12 col-sm-12">
				<div class="right_form_login forgetPassword">
					<div class="login_content">
						<div class="user_login_header">
							<?php if(isset($type) && $type=="customer"): ?>
								<img src="<?= base_url(IMG_PATH.'customer.svg') ;?>" alt="">
							<?php elseif(isset($type) && $type=="delivery"):?>
								<img src="<?= base_url(IMG_PATH.'delivery.svg') ;?>" alt="">
							<?php else: ?>
								<h4 class="heading"><?= !empty(lang('sign_in'))?lang('sign_in'):"Sign In";?></h4>
							<?php endif;?>
							<h4 class="heading"><?= lang('forgot_password'); ?></h4>
						</div>
						<div class="form_content"> 
							<span class="reg_msg"></span>
							<form action="<?= base_url('customer/check_customer_info') ?>" method="post" id="recovery_password">
								<?= csrf() ;?>
								<div class="login_form" >
									<div class="form-group">
										<label><i class="fa fa-phone"></i> <?= lang('phone'); ?></label>
										<input type="text" name="phone" class="form-control" placeholder="<?= lang('phone');?>">
									</div>

									<div class="form-group">
										<button type="submit" class="btn btn-info"> <?= lang('submit'); ?> &nbsp; <i class="fa fa-angle-double-right"></i> </button>
									</div>
									

									<div class="form-group">
										<p><?= lang('remember_password'); ?><a href="<?= base_url('staff-login/customer') ;?>"><?= lang('sign_in'); ?></a></p>
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


<div class="modal" id="questionModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title"><?= lang('recovery_password_heading');?></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<form action="<?= base_url("customer/recovery_password");?>" method="post" id="checkAnswer">
				<?= csrf();?>
				<span class="reg_msg"></span>
				<!-- Modal body -->
				<div class="modal-body">
					<div id="showField"></div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><?= lang('submit');?></button>
				</div>
			</form>

		</div>
	</div>
</div>
