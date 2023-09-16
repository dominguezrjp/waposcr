<?php $shop_id = $shop_id; ?>
<?php include APPPATH.'views/common_layouts/topMenu.php' ?>
<div class="container restaurant-container mt-80">
	<?php if(count($this->cart->contents())>0 && $shop_id == cart_id()): ?>
		<div class="showCheckoutData" id="showCheckoutData">
			<?php $this->load->view('layouts/checkout_content'); ?>
		</div>
	<?php else: ?>
		<div class="empty_msg">
			<div class="top_cart_order">
				<div class="limit_msg">
					<i class="fa fa-frown fa-3x"></i>
					<h4><?= lang('cart_is_empty'); ?></h4>
					<a href="<?= base_url($slug) ;?>" class="btn btn-info custom_btn mt-15"><?= lang('back'); ?></a>
				</div>
			</div>
		</div>
	<?php endif;?>
</div>