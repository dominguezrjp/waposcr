<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<?php if(!empty($msg)): ?>
		<div class="verify_msg text_success ">
			<div class="verify_content payment">
				<i class="far fa-smile-o"></i>
				<div class="payment_msg">
					<h3><?= lang('payment_verified_successfully'); ?></h3>
				</div>	
				<?=!empty($this->session->flashdata('success_msg'))? $this->session->flashdata('success_msg'):$msg ;?>
				<a href="<?= base_url('dashboard');?>" class="btn btn-success c_btn"><i class="fas fa-check"></i> &nbsp; <?= lang('ok'); ?></a>
			</div>
		</div>
	<?php endif;?>
</div>
</div>