<?php $shop_info = $this->common_m->shop_info($shop_id); ?>
<?php 
if($shop_info['is_area_delivery']==1):
	if(isset($cost) && $cost!=0): 
		$shipping = $cost;
	else:
		$shipping = 0;
	endif;

else:
	$shipping = $shop_info['delivery_charge_in'];
endif;

if(isset($coupon_price)){
	$coupon_price = $coupon_price;
}else{
	$coupon_price = 0;
}
if(isset($tips)){
	$tips = $tips;
}else{
	$tips = 0;
}

?>

<div class="row">
	<div class="col-lg-6 col-sm-12">
		<div class="upperSum">
			<div class="flex justify-between">
				<p><?=  !empty(lang('qty'))?lang('qty'):'Qty';?> :</p> <span class="cart_count"><?= $this->cart->total_items() ;?></span>
			</div>
			<div class="flex justify-between">
				<p><?= !empty(lang('sub_total'))?lang('sub_total'):'sub_total' ;?> : </p> <span> <span class="total_price"><?= currency_position($this->cart->total(),$shop_id);?></span>
			</div>

			

			<div class="dis_none <?= $shop_info['is_area_delivery']==1?"showShipping":"show_address";?> ">
				<?php if($shipping!=0): ?>
					<div class="flex justify-between">
						<p><?= !empty(lang('shipping'))?lang('shipping'):'Shipping' ;?> : </p><span class="d_charge"><?= currency_position($shipping,$shop_id);?></span>
					</div>
				<?php else: ?>
					<div class="flex justify-between">
						<p><?= !empty(lang('shipping'))?lang('shipping'):'Shipping' ;?> : </p><span class="d_charge"><?= !empty(lang('Free'))?lang('Free'):'Free' ;?></span>
					</div>
				<?php endif; ?>
			</div>

			<div class="discount_tax">

				<?php if($shop_info['tax_fee'] !=0): ?>
					<?php $tax_fee = get_percent($this->cart->total(),$shop_info['tax_fee']); ?>
					<div class="flex justify-between">
						<p><?= lang('tax') ;?> : </p> <span class="d_charge"><?= currency_position($tax_fee,$shop_id);?></span>
					</div>
				<?php else: ?>
					<?php $tax_fee = 0; ?>
				<?php endif;?>


				<?php if($shop_info['discount'] !=0): ?>
					<?php $discount = get_percent($this->cart->total(),$shop_info['discount']); ?>
					<div class="flex justify-between">
						<p><?= !empty(lang('discount'))?lang('discount'):'Discount' ;?> : </p> <span class="d_charge"><?= currency_position($discount,$shop_id) ;?></span> 
					</div>
				<?php else: ?>
					<?php $discount = 0; ?>
				<?php endif;?>
			</div>


			<div class="couponPricearea " style="display:none;">
				<div class="flex justify-between">
					<p><?= !empty(lang('coupon_discount'))?lang('coupon_discount'):'coupon_discount' ;?> : </p><span class="coupon_price"><?= currency_position($coupon_price,$shop_id) ;?></span>
				</div>
			</div>

			<?php if($tips!=0): ?>
				<div class="tips">
					<div class="flex justify-between">
						<p><?= !empty(lang('tip'))?lang('tip'):'tip' ;?> : </p><span class="tip_price"><?= currency_position($tips,$shop_id) ;?></span>
					</div>
				</div>
			<?php endif; ?>


		</div>


		<?php if($shop_info['is_area_delivery']==1): ?>

			<div class="dis_none <?= $shop_info['is_area_delivery']==1?"showShipping":"show_address" ;?>">
				<div class="flex justify-between ">
					<h4 class=""><?= !empty(lang('total'))?lang('total'):'total' ;?> : </h4> 
					<?php if($shop_info['tax_status']=="+"): ?>
						<h4 class=""> <?= currency_position(($this->cart->total()+$shipping+$tax_fee+$tips)-($discount+$coupon_price),$shop_id);?></h4> 
					<?php else: ?>

						<h4 class=""> <?= currency_position(($this->cart->total()+$shipping+$tips)-($discount+$coupon_price+$tax_fee),$shop_id);?></h4> 
					<?php endif ?>
				</div>
			</div>
			<div class="show_price">
				<div class="flex justify-between">
					<h4 class=""><?= !empty(lang('total'))?lang('total'):'total' ;?> : </h4> 
					<?php if($shop_info['tax_status']=="+"): ?>
						<h4 class="totalPrice"><?=currency_position(($this->cart->total()+$tax_fee+$tips)-($discount+$coupon_price),$shop_id);?></h4>
					<?php else: ?>
						<h4 class="totalPrice"><?=currency_position(($this->cart->total()+$tips)-($discount+$coupon_price+$tax_fee),$shop_id);?></h4>
					<?php endif ?>
				</div>
			</div>
		<?php else: ?>

			<div class="dis_none <?= $shop_info['is_area_delivery']==1?"showShipping":"show_address" ;?>">
				<div class="flex justify-between ">
					<h4 class=""><?= !empty(lang('total'))?lang('total'):'total' ;?> : </h4> 
					<h4 class=""> 
						<?php if($shop_info['tax_status']=="+"): ?>
							<?= currency_position(($this->cart->total()+$shipping+$tax_fee+$tips)-($discount+$coupon_price),$shop_id);?>
						<?php else: ?>
							<?= currency_position(($this->cart->total()+$shipping+$tips)-($discount+$coupon_price+$tax_fee),$shop_id);?>
						<?php endif ?>
							
						</h4> 
				</div>
			</div>
			<div class="show_price defaultshipping">
				<div class="flex justify-between">
					<h4 class=""><?= !empty(lang('total'))?lang('total'):'total' ;?> : </h4> 
					<?php if($shop_info['tax_status']=="+"): ?>
						<h4><?=currency_position(($this->cart->total()+$tax_fee+$tips)-($discount+$coupon_price),$shop_id);?></h4>
					<?php else: ?>
						<h4><?=currency_position(($this->cart->total()+$tips)-($discount+$coupon_price+$tax_fee),$shop_id);?></h4>
					<?php endif ?>
				</div>
			</div>
		<?php endif; ?>
		
	</div><!-- col-md-6 -->
</div><!-- row -->