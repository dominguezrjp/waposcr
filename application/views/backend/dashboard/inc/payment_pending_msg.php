<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 col-md-offset-4">
<!-- Widget: user widget style 1 -->
	<div class="box box-widget widget-user-2">
		<!-- Add the bg color to the header using any of the bg-* classes -->
		<div class="widget-user-header profile profile_flex" style="background-color: #<?= trim($this->my_info['colors']) ;?>">
			<div class="widget-user-image profile-img-2">
				<img class="img-circle" src="<?= base_url(!empty($this->my_info['thumb'])?$this->my_info['thumb']:'assets/admin/dist/img/user2-160x160.jpg') ;?>" alt="User Avatar">
			</div>
			<div class="right_details">
				<div class="right_left">
					<!-- /.widget-user-image -->
					<h3 class="widget-user-username"><?= isset($this->my_info['name'])?$this->my_info['name']:$this->my_info['username'];?></h3>
					<h5 class="widget-user-desc">
						<?php if($this->my_info['account_type']==0): ?>
							<?= ucfirst(!empty(lang('trial'))?lang('trial'):"trial")?>
							<?php else: ?>
								<?= isset($active_package['package_name'])? html_escape($active_package['package_name']):"";?>
							<?php endif;?>
						</h5>
						<h5 class="widget-user-desc"><?= cl_format($this->my_info['created_at']) ;?></h5>
					</div>
					<div class="right_right">

					</div>
				</div>
			</div>
			<div class="box-footer no-padding">
				<div class="text-center subscrip_option">
					<?php if($this->auth['is_request']==0): ?>
                        <h4><?= !empty(lang('alert'))?lang('alert'):"Alert"?>!! <?= !empty(lang('payment_pending_msg'))?lang('payment_pending_msg'):"Your payment is pending"?></h4>
                        <p> <?= !empty(lang('can_pay_subscription'))?lang('can_pay_subscription'):"You can pay from subscription"?></p>
                        <a href="<?= base_url('payment-method/'.$this->my_info['username'].'/'.$this->my_info['slug']);?>" class="btn btn-primary c_btn"><i class="fas fa-shopping-cart"></i> &nbsp; <?= lang('pay_now'); ?></a>
                    <?php else: ?>
                        <h4><?= !empty(lang('alert'))?lang('alert'):"Alert"?>!! <?= !empty(lang('pending_request_msg'))?lang('pending_request_msg'):"Your payment request is pending"?></h4>
                        <p> <?= lang('wait_for_confirmation'); ?></p>
                        <a href="<?= base_url('payment-method/'.$this->my_info['username'].'/'.$this->my_info['slug']);?>" class="btn btn-info c_btn"><i class="fa fa-exchange"></i> &nbsp; <?= lang('try_another_method'); ?></a>
                    <?php endif;?>
				</div>
			</div>
		</div>
	<!-- /.widget-user -->
</div>