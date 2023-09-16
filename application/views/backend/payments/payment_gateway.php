<div class="row">
	<div class="col-md-8">
		<div class="payment_msg"></div>
		<div class="">
			<div class="nav-tabs-custom">
				<?php 
					$setting = $this->settings;
					$settings = $this->settings;
					$u_info = $this->my_info;
				?>
			<ul class="nav nav-tabs">
				<?php foreach (payment_method_list() as $key => $pay): ?>
					<?php if($settings[$pay['active_slug']]==1 && $settings[$pay['status_slug']]==1): ?>
						<li class="<?=  isset($_GET['method']) && $_GET['method']==$pay['slug']?"active":"";?> <?= $pay['slug']!='offline'?is_package:"";?>"><a href="<?= base_url("payment-method/{$slug}/{$account_type}?method={$pay['slug']}") ;?>"><?= lang($pay['slug']) ;?></a></li>
					<?php endif;?>
				<?php endforeach; ?>
				
				
				<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" >
					<?php  if(isset($_GET['method'])):?>
						<?php 
							$method = $_GET['method'];
						 ?>
						<?php foreach (payment_method_list() as $key => $pay): ?>
							<?php if($method==$pay['slug']): ?>
								<?php include "inc/{$pay['slug']}.php"; ?>
							<?php endif;?>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="tab-pane active" id="activity" role="tabpanel" aria-labelledby="home-tab">
							<div class="selectPaymentMsg">
								<p><i class="icofont-pay"></i></p>
								<h4><?= lang('please_select_your_payment_menthod'); ?></h4>
							</div>
						</div>
					<?php endif;?>
				</div>
				<!-- /.tab-pane -->
			</div>
				<!-- /.tab-content -->
			</div>
		</div>
	</div>
</div>
<?php if(isset($_GET['method']) && !empty($_GET['method'])): ?>
<div class="row">
	<div class="col-md-8">
		<div class="card subscribeInvoice bg_white">
			<?php include APPPATH.'views/common/subscription_invoice_thumb.php'; ?>
		</div>
	</div>
</div>
<?php endif ?>