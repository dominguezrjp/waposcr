<div class="topCustomerProfile">
	<h4><?= !empty(lang('customer_panel'))?lang('customer_panel'):"Customer panel"; ?></h4>
</div>
<div class="customer_profile">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?php include APPPATH.'views/frontend/customer/leftSidebar.php';  ?>
			</div>
			<div class="col-md-9">
				<div class="serviceRightSide">
					<div class="profleForm">
						<h4 class="header"><?= !empty(lang('change_password'))?lang('change_password'):"Change Password" ;?></h4>
						<form action="<?= base_url('staff/change_password') ;?>" method="post">
							<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">


							<div class="row">
								<div class="form-group col-md-6">
									<label for=""><?= lang('new_pass'); ?></label>
									<input type="text" name="password" class="form-control">
								</div>
								<div class="form-group col-md-6">
									<label for=""><?= lang('confirm_password'); ?></label>
									<input type="text" name="cpassword" class="form-control">
								</div>
								<div class="form-group text-center mt-20 mb-0 col-md-12">
									<input type="hidden" name="active_phone" value="<?=  $info['phone'];?>">
									<button class="btn btn-primary"><?= lang('submit'); ?></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>