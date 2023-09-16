<div class="cartItemList">
	<?php $subtotal = $total = 0; ?>
	<?php $i=1; foreach ($this->cart->contents() as $key => $row): ?>
	<?php if(isset($row['is_pos']) && $row['is_pos']==1): ?>
	<?php 
	$subtotal += $row['qty']*$row['price'];
	$total = $subtotal;

	$i_info = order_info();
	
	if(!empty(cart('discount'))):
		$discount = cart('discount');
	else:
		if(isset($i_info['discount']) && !empty($i_info['discount'])){
			$discount = get_percent($subtotal,$i_info['discount'],$i_info['is_pos']);
		}else{
			$discount = 0;
		};
	endif;


	if(!empty(cart('shipping'))):
		$shipping = cart('shipping');
	else:

		if(isset($i_info['delivery_charge']) && !empty($i_info['delivery_charge'])){
			$shipping = $i_info['delivery_charge'];
		}else{
			$shipping = 0;
		}
	endif;
	



 	if(restaurant()->is_tax==1 && restaurant()->tax_fee!=0): 
 		$tax = get_percent($subtotal,restaurant()->tax_fee);
 	else:
 		$tax = 0;
 	endif;

 	
 	if(!empty(cart('coupon')->coupon_discount)):
 		$get_percent = get_percent($subtotal,cart('coupon')->coupon_discount);
 		$coupon_discount = $get_percent;
 		$coupon_percent = cart('coupon')->coupon_discount;
 		$coupon_id = cart('coupon')->coupon_id;
 	else:
 		if(isset($i_info['is_coupon']) && !empty($i_info['coupon_percent'])){
 			$coupon_discount =  get_percent($subtotal,$i_info['coupon_percent']);
 			$coupon_percent = $i_info['coupon_percent'];
 			$coupon_id = $i_info['coupon_id'];
 		}else{

 			$coupon_discount = 0;
 		};
 	endif;


	

	$grandTotal = get_total($subtotal,$shipping,$discount,$tax,$coupon_discount,$tips=0,restaurant()->tax_status);
	?>
	<div class="singleCartContent">
		<div class="cartItems">
			<div class="itemThumb">
				<img src="<?= get_img($row['thumb'],$row['img_url'],$row['img_type']) ;?>" alt="item_img">
			</div>
			<div class="cartitemDetails">
				<div class="itemLeftDetails">
					<h4><?= html_escape($row['name']) ;?></h4>
					<?php if(isset($row['sizes']['is_size']) && $row['sizes']['is_size']==1): ?>
						<p><?= currency_position($row['sizes']['size_price'],restaurant()->id);?></p>
					<?php else: ?>
						<?php if(isset($row['extras']['is_extra']) && $row['extras']['is_extra']==1): ?>
							<p><?= currency_position($row['extra_price'],restaurant()->id);?></p>
						<?php else: ?>
							<p><?= currency_position($row['price'],restaurant()->id);?></p>
						<?php endif; ?>
					<?php endif; ?>
					<div class="incress_area">
						<span class="value-button minus default-light" data-id="<?= $row['rowid'] ;?>" value="Decrease Value">-</span>

						<span class="cart_qty_field"><input readonly type="number" id="qty_<?= $row['rowid'];?>" class="qty" value="<?= $row['qty'];?>" min-value='1' /></span>

						<span class="value-button add default-light" data-id="<?= $row['rowid'] ;?>"  value="Increase Value">+</span>
					</div> 

				</div><!-- itemLeftDetails -->

				<div class="itemPriceArea">
					<a href="javascript:;" class="remove_item danger-light" data-id="<?= $row['rowid'] ;?>">&#10006;</a>
					<?php if(isset($row['sizes']['is_size']) && $row['sizes']['is_size']==1): ?>
						<p class="subTotalTag"><?= currency_position(($row['qty']*$row['sizes']['size_price']),restaurant()->id);?></p>
					<?php else: ?>
						<?php if(isset($row['extras']['is_extra']) && $row['extras']['is_extra']==1): ?>
							<p class="subTotalTag"><?= currency_position(($row['qty']*$row['extra_price']),restaurant()->id);?></p>
						<?php else: ?>
							<p class="subTotalTag"><?= currency_position(($row['qty']*$row['price']),restaurant()->id);?></p>
						<?php endif; ?>
						
					<?php endif ?>
					
				</div>

			</div><!-- itemDetails -->
		</div><!-- cartItems -->
		<?php if(isset($row['extras']['is_extra']) && $row['extras']['is_extra']==1): ?>
			<div class="extras_size_area">
				<ul>
					<?php foreach ($row['extras']['extra_info'] as $ex): ?>
						<li><span><?= $row['qty'].' x '.$ex->ex_name;?></span> <span><?= currency_position(($row['qty']*$ex->ex_price),$row['shop_id']);?></span></li>
					<?php endforeach; ?>
				</ul>
			</div><!-- extras_size_area -->
			<div class="extraWithPrice">
				<span><?= currency_position(($row['qty']*$row['price']),restaurant()->id);?></span>
			</div>
		<?php endif ?>
	</div>
	<?php endif; ?> <!-- check pos == 1 -->
	<?php $i++; endforeach; ?>
</div>


<?php if($this->cart->total_items() > 0): ?>
<div class="cartOrderInfo">
	<div class="cartPriceArea">
		<div class="subTotalInfo bb_1">
			<p><span><?= lang('sub_total');?> (<?= $this->cart->total_items();?> <?= lang('items');?>)</span> <span>	<?= currency_position($subtotal,restaurant()->id);?></span></p>

			<?php if(!empty($shipping)):?>
				<p><span><?= lang('shipping');?></span> <span><?= currency_position($shipping,restaurant()->id);?></span></p>
			<?php endif ?>

			<?php if(isset($tax) && $tax!=0): ?>
				<p><span><?= lang('tax_fee');?> (<?= tax(restaurant()->tax_fee,restaurant()->tax_status);?>)</span> <span><?= currency_position($tax,restaurant()->id);?></span></p>
			<?php endif ?>

			<?php if(isset($discount)):?>
				<p><span><?= lang('discount');?></span> <span><?= currency_position($discount,restaurant()->id);?></span></p>
			<?php endif ?>


			<?php if(!empty($coupon_discount)):?>
				<p><span><?= lang('coupon_discount');?> (<?= $coupon_percent;?>%)</span> <span><?= currency_position($coupon_discount,restaurant()->id);?></span></p>
			<?php endif ?>
		</div>

		<div class="subTotalInfo">
			<p><span><?= lang('total');?></span>  <span><?= currency_position($grandTotal??0,restaurant()->id);?></span></p>
		</div>
	</div><!-- cartPriceArea -->
	<div class="cartActionArea">
		<ul>
			<li><a href="#couponModal" <?= empty(auth('is_order_edit'))?'data-toggle="modal"':"";?> > <span><i class="icofont-tag"></i> <?= !empty($coupon_discount)?  currency_position($coupon_discount,restaurant()->id) :"";?> <?= !empty($coupon_percent)?"(".$coupon_percent."%)":'';?></span> <span><?= lang('coupon');?></span></a></li>

			<li><a href="#discountModal" data-toggle="modal"><span><i class="icofont-dollar-minus"></i> <?= !empty($discount)? currency_position($discount,restaurant()->id) :"";?></span> <span><?= lang('discount');?></span></a></li>

			<li><a href="#shippingModal" <?= empty(auth('is_order_edit'))?'data-toggle="modal"':"";?>><span><i class="icofont-fast-delivery"></i><?= !empty($shipping)? currency_position($shipping,restaurant()->id) :"";;?></span> <span> <?= lang('shipping');?></span></a></li>
		</ul>
	</div>
</div>
<?php endif ?>

