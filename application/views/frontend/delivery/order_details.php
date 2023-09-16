<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="d_single_order_area">
				<div class="d_single_order_header">
					<a href="<?= base_url('staff/new_order_list'); ?>" ><i class="fa fa-angle-left"></i></a>
					<h4># <?= $order_info['uid']?></h4>
					<?php $icon = shop($order_info['shop_id'])->icon; ?>
				</div>

				<div class="d_single_order_body">
					<div class="shopArea delivery-panel">
						<div class="topd_Order pb-7">
							<p><?= lang('shipping'); ?></p>
							<p><b><?= $order_info['delivery_charge']!=0?$order_info['delivery_charge'].' '. $icon:lang('free')?></b></p>
						</div>
						<div class="topd_Order bt-1-dashed pt-7">
							<h4><?= !empty(lang('total_earnings'))?lang('total_earnings'):"Total Earnings"; ?></h4>
							<p><b><?= number_format(number($order_info['total']),2)?> <?=  $icon;?></b></p>
						</div>
						<?php if(!empty($order_info['payment_by']) && $order_info['is_payment']==1): ?>
							<div class="topd_Order bt-1-dashed pt-7">
								<p class="digitalPaymentText bg-green"><i class="fa fa-check"></i> <?= lang('digital_payment');?> (<b><?=lang($order_info['payment_by']);?></b>)</p>
							</div>
						<?php endif; ?>
					</div>

					<div class="shopArea delivery-panel">
						<ul>
							<li>
								<i class="fa fa-shopping-cart bg-green"></i>
								<div class="shopDetails">
									<h4><?= !empty($shop->name)?$shop->name:$shop->username;?></h4>
									<p><?= !empty($shop->phone)?$shop->phone:"";?></p>
									<p><?= !empty($shop->address)?$shop->address:"";?></p>
									<a href="<?= !empty($shop->location)?$shop->location:"";?>"><i class="icofont-reply"></i> <?= lang('get_direction'); ?></a>
								</div>
							</li>
							<li>
								<i class="fa fa-map-marker bg-green"></i>
								<div class="shopDetails">
									<h4><?= $order_info['name']?></h4>
									<p><?= $order_info['phone']?></p>
									<p><?= $order_info['address']?></p>
									<?php $shpping_info = $this->common_m->delivery_area_by_shop_id($order_info['shipping_id'],$order_info['shop_id']); ?>
									<?php if(isset($shpping_info['area']) && !empty($shpping_info['area'])): ?>
									<p><?= lang('delivery_area');?> : <span style="color:rebeccapurple;"><?= $shpping_info['area'];?></span></p>
									<?php endif;?>
									<p><?= lang('shipping')?> :  <?= $order_info['delivery_area'];?></p>
									<?php if(!empty($order_info['delivery_area'])): ?>
										<?php $coordinates = getCoordinatesAttribute($order_info['delivery_area'],$order_info['shop_id']);?>
										<?php if(!empty($coordinates['latitude']) && !empty($coordinates['longitude'])): ?>
											<a href="https://maps.google.com?q=<?= isset($coordinates['latitude'])?$coordinates['latitude']:'' ;?>,<?= isset($coordinates['longitude'])?$coordinates['longitude']:'' ;?>" target="blank"> <i class="icofont-reply"></i> <?= lang('get_direction'); ?></a>
										<?php endif; ?>
									<?php endif;?>
									<a href="tel:<?= $order_info['phone']?>"><i class="icofont-phone"></i> <?= lang('call_now'); ?></a>
								</div>
							</li>
						</ul>
					</div>
					<div class="orderareaDetails delivery-panel">
						<div class="orderareaHeader d_single_order_header">
							<i class="fa fa-list fz-18"></i>
							<h4><?= lang('order_items'); ?></h4>
						</div>
						<div class="orderItemList">
							
							<ul>
								<?php $qty=0;$sub_total=0;$total_price = 0;$net_total=0; ?>
									<?php foreach ($item_list as $key => $row): ?>
										<?php 
											$qty = $qty+ $row['qty'];
											 $sub_total = $sub_total+ $row['sub_total'];
								             $net_total = $net_total+ $row['sub_total'];
								             $pre_total = $net_total+$order_info['delivery_charge'];
								             $discount = !empty($order_info['discount']) || $order_info['discount']!=0?$order_info['discount']:0;
								             $grand_total = $pre_total - $discount;
										 ?>
										<li>
										 	<div class="d_orderDetails">
										 		<h5><?= $row['qty'];?> x <?= $row['is_package']==1?$row['package_name']:$row['name'];?> </h5>
										 		<?php if(isset($row['is_extras']) && $row['is_extras']==1): ?>
										 			<?php $extraId = json_decode($row['extra_id']); ?>
										 			<div class="extars">
										 				<ul>
										 					<?php foreach ($extraId as $key => $ex): ?>
										 						<li><span>1 x <?= extras($ex,$row['item_id'])->ex_name ;?></span></li>
										 					<?php endforeach ?>
										 				</ul>
										 			</div>
										 		<?php endif;?>
										 	</div>

										</li>
									<?php endforeach; ?>
							</ul>
						</div>
						<?php if(isset($order_info['is_change']) && $order_info['is_change']==1 && $order_info['change_amount']!=0): ?>
							<h4 class="change-amount"><?= lang('change');?> : <?= $order_info['change_amount'].' '.$icon;?> </h4>
						<?php endif ?>
					</div>
					<div class="deliver-footer">
						<?php if($order_info['dboy_status']==0): ?>
						<a href="<?= base_url('staff/accept_order/'.$order_info['uid'].'/'.auth('staff_id')); ?>" class="btn btn-success btn-block orderBtn"><?= !empty(lang('mark_as_accepted'))?lang('mark_as_accepted'):"Mark as accepted"; ?></a>

					<?php elseif($order_info['dboy_status']==1 && $order_info['is_db_accept']==1): ?>
						<a href="<?= base_url('staff/picked_order/'.$order_info['uid'].'/'.auth('staff_id')); ?>" class="btn btn-success btn-block orderBtn"><?= !empty(lang('mark_as_picked'))?lang('mark_as_picked'):"Mark as Picked"; ?></a>

					<?php elseif($order_info['dboy_status']==2 && $order_info['is_picked']==1): ?>
						<a href="<?= base_url('staff/completed_order/'.$order_info['uid'].'/'.auth('staff_id')); ?>" class="btn btn-success btn-block orderBtn"> <i class="icofont-check"></i>  <?= !empty(lang('mark_as_completed'))?lang('mark_as_completed'):"Mark as Completed"; ?></a>

					<?php elseif($order_info['dboy_status']==3 && $order_info['is_db_completed']==1): ?>
						<a href="javascript:;" class="btn btn-success btn-block"> <i class="icofont-check"></i>  <?= !empty(lang('completed'))?lang('completed'):"Completed"; ?></a>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>