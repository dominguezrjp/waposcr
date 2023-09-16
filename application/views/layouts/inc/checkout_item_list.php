<div class="row">
	<?php $shop_id = 0; ?>
	<?php $i=1; foreach ($this->cart->contents() as $key => $row): ?>
	<?php $shop_id = $row['shop_id']; ?>
	<div class="col-md-6" id="hide_item_<?= $row['rowid'] ;?>">
		<div class="single_item_cart order_list">
			<div class="left_cart">
				<img src="<?= get_img($row['thumb'],$row['img_url'],$row['img_type']) ;?>" alt="itemImg">
				<div class="single_cart_item_details">
					<h4><?= html_escape($row['name']) ;?> <span class="extrasTitleCard">
						<?php if(isset($row['is_extras']) && $row['is_extras']==1 && !empty($row['extra_id'])): ?>
							<?php foreach (json_decode($row['extra_id'],true) as $ex):?>
								<?php echo $extras_name =  rtrim('+'.$this->common_m->get_extras_name($ex,$row['item_id']).'+','+'); ?>
							<?php endforeach ?>
						<?php endif ?>
					</span></h4>
					<div class="order_qty">
						<div class="incress_area">
							<span class="value-button minus" data-id="<?= $row['rowid'] ;?>" value="Decrease Value"><i class="icofont-minus"></i></span>

							<span class="cart_qty_field"><input readonly type="number" id="qty_<?= $row['rowid'] ;?>" class="qty" value="<?= $row['qty'] ;?>" min-value='1' /></span>

							<span class="value-button add" data-id="<?= $row['rowid'] ;?>"  value="Increase Value"><i class="icofont-plus"></i></span>
						</div>  
						&nbsp; <span class="sizeTitle"><?= isset($row['sizes']['size_slug']) && !empty($row['sizes']['size_slug'])?lang('size').' : '.get_size($row['sizes']['size_slug'],$row['shop_id']):"" ;?></span>
					</div>
					<p class="price_qty_area"> <?= currency_position($row['price'],$shop_id) ;?> x <?= html_escape($row['qty']) ;?> = <?= currency_position($this->cart->format_number($row['subtotal']),$shop_id) ;?></p>
					
				</div>
			</div>
			<div class="right_cart">
				<a href="javascript:;" data-id="<?= $row['rowid'] ;?>" class="remove_item"><i class="icofont-close-line"></i></a>
			</div>
		</div>
	</div>
	
	<?php $i++; endforeach; ?>
	
</div>
<div class="row">
	<div class="col-md-12 total_sum_area">
		<?php $shop_info = $this->common_m->shop_info($shop_id); ?>
		<div class="total_sum">
			<div class="row">
				<div class="col-lg-6 col-sm-12">
					<div class="upperSum">
						<div class="flex justify-between">
							<p><?=  !empty(lang('qty'))?lang('qty'):'Qty';?> :</p> <span class="cart_count"><?= $this->cart->total_items() ;?></span>
						</div>
						<div class="flex justify-between">
							<p><?= !empty(lang('sub_total'))?lang('sub_total'):'sub_total' ;?> : </p> <span><?= currency_position($this->cart->total(),$shop_info['shop_id']);?></span>
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
									<p><?= !empty(lang('discount'))?lang('discount'):'Discount' ;?> : </p> <span class="d_charge"><?=currency_position($discount,$shop_id) ;?></span> 
								</div>
							<?php else: ?>
								<?php $discount = 0; ?>
							<?php endif;?>
						</div>

						<?php 
							if($shop_info['is_area_delivery']==1):
								if(isset($cost)): 
									$shipping = $cost;
								else:
									$shipping = 0;
								endif;
							else:
								$shipping = $shop_info['delivery_charge_in'];
							endif;
						?>

						<div class="dis_none <?= $shop_info['is_area_delivery']==1?"showShipping":"show_address";?>">
							<?php if($shipping!=0): ?>
								<div class="flex justify-between">
									<p><?= !empty(lang('shipping'))?lang('shipping'):'Shipping' ;?> : </p><span class="d_charge"><?= currency_position($shipping, $shop_id);?> </span>
								</div>
							<?php else: ?>
								<div class="flex justify-between">
									<p><?= !empty(lang('shipping'))?lang('shipping'):'Shipping' ;?> : </p><span class="d_charge"><?= !empty(lang('Free'))?lang('Free'):'Free' ;?></span>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<?php if($shop_info['is_area_delivery']==1): ?>
					<div class="dis_none <?= $shop_info['is_area_delivery']==1?"showShipping":"show_address" ;?>">
						<div class="flex justify-between ">
							<h4 class=""><?= !empty(lang('total'))?lang('total'):'total' ;?> : </h4> 
							<h4 class=""> <?= currency_position(($this->cart->total()+$shipping+$tax_fee)-$discount,$shop_id);?></h4> 
						</div>
					</div>
					<div class="show_price">
						<div class="flex justify-between">
							<h4 class=""><?= !empty(lang('total'))?lang('total'):'total' ;?> : </h4> 
							<h4><?=currency_position(($this->cart->total()+$tax_fee)-$discount,$shop_id);?></h4>
						</div>
					</div>
				<?php else: ?>
					<div class="dis_none <?= $shop_info['is_area_delivery']==1?"showShipping":"show_address" ;?>">
						<div class="flex justify-between ">
							<h4 class=""><?= !empty(lang('total'))?lang('total'):'total' ;?> : </h4> 
							<h4 class=""> <?= currency_position(($this->cart->total()+$shipping+$tax_fee)-$discount,$shop_id);?></h4> 
						</div>
					</div>
					<div class="show_price defaultshipping">
						<div class="flex justify-between">
							<h4 class=""><?= !empty(lang('total'))?lang('total'):'total' ;?> : </h4> 
							<h4><?=currency_position(($this->cart->total()+$tax_fee)-$discount,$shop_id);?></h4>
						</div>
					</div>
				<?php endif; ?>

				</div><!-- col-md-6 -->
				
			</div><!-- row -->
		</div>
	</div>
</div>