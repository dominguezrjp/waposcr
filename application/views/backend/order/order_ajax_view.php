<div class="orderList_ajax_area left">
	<div class="orderlistHeader">
		<h4><?= lang('order_details'); ?></h4>
		<a href="javascript:;" class="close_view"><i class="fa fa-close"></i></a>
	</div>

	<?php foreach ($item_list as $key => $order): ?>
		<div class="orderListBody">
			<div class="topOrderView">
				<div class="single_alert alert alert-info alert-dismissible mb-0">
					<div class="d_flex_alert-admin mt-10">
						<h4 class="ml-10"><?= lang('order_id'); ?>: #<?= $order['uid'];?></h4>
						<div class="double_text mt-10">
							<div class="text-left">
								<h5>
									<!-- order  typr -->
									<label class="order-type default-light-active"> <?= order_type($order['order_type']);?></label></h5>

									<!-- order  typr -->
								<?php if($order['order_type']==1 || $order['order_type']==5): ?>
									<div class="mt-10 text-center">
										<label class="label default"><?= !empty(lang('delivery_charge'))?lang('delivery_charge') : "Delivery charge" ;?>: <?= $order['delivery_charge']!=0?currency_position($order['delivery_charge'],restaurant()->id):lang('free');?> </label>
									</div>
								<?php endif; ?>

								<?php if(isset($order['is_change']) && $order['is_change']==1): ?>
									<p class="c_white text-center"><b><?= lang('change');?> : <?= currency_position($order['change_amount'],restaurant()->id) ?> </b></p>
								<?php endif ?>

								<?php if($order['order_type']==2): ?>
									<div class="mt-10">
										<label class="label primary-light-active" data-toggle="tooltip" title="Reservation Date"><?= full_time($order['reservation_date'],restaurant()->id) ;?></label> &nbsp;
										<label class="label default-light-active" data-toggle="tooltip" title="Total Person Number"><?= lang('total_person'); ?>: <?= $order['total_person'] ;?></label>
									</div>
								<?php endif;?>

								<?php if($order['order_type']==4): ?>
									<div class="mt-10">
										<label class="label default-light-active" data-toggle="tooltip" title="Pickup Time"><?= lang('pickup_time'); ?> :  <?=!empty($order['pickup_time'])?$order['pickup_time']: time_format_12($order['reservation_date']) ;?></label> &nbsp;



										<h5 class="mt-10"><?= lang('pickup_point'); ?> : <?= single_select_by_id($order['pickup_point'],'pickup_points_area')['address'] ;?> </h5>
										<?php if(isset($order['pickup_date']) && !empty($order['pickup_date'])): ?>
											<h5 class=" mt-20"><?= lang('pickup_date'); ?>: <?=!empty($order['pickup_date'])?cl_format($order['pickup_date'],restaurant()->id): time_format_12($order['reservation_date']) ;?></h5>
										<?php endif;?>
									</div>
								<?php endif;?>

								<?php if($order['order_type']==6): ?>
									<div class="mt-10">
										<label class="label default-light-active" data-toggle="tooltip" title="Pickup Time"><?= lang('table'); ?> : <?= single_select_by_id($order['table_no'],'table_list')['name'] ;?></label> &nbsp;
										<label class="label default-light-active" data-toggle="tooltip" title="Total Person Number"><?= lang('total_person'); ?> : <?= $order['total_person'] ;?></label>
									</div>
								<?php endif;?>

							<?php if($order['order_type']==7): ?>
								<div class="mt-10">
									<?php if(!empty($order['table_no']) || $order['table_no']!=0): ?>
										<h5 class="" ><b><?= lang('table_no'); ?>: <?= single_select_by_id($order['table_no'],'table_list')['name'] ;?></b></h5>
									<?php endif ?>
									<h5 class="" ><b><?= lang('token_number'); ?>: <?= $order['token_number'] ;?></b></h5>
								</div>
							<?php endif;?>

							<?php if($order['order_type']==8): ?>
								<div class="mt-10">
									<h5 class="" ><?= lang('hotel_name'); ?> : <?= single_select_by_id($order['hotel_id'],'hotel_list')['hotel_name'] ;?></h5>

									<h5 class=""><?= lang('room_number');?> : <?= $order['room_number'];?></h5>
								</div>
							<?php endif;?>
							</div>
						</div>
					</div>
				</div>
				<div class="order_details">
					<?php if($order['is_guest_login']==1): ?>
						<p><b><?= lang('walk_in_customer');?></b></p>
					<?php else: ?>
						<h4><b><span><?= lang('name'); ?></span></b> <p class="ml-10"><?= html_escape($order['name']);?></p></h4>
						<p><b><span><?= lang('phone'); ?></span></b> <p class="ml-10"><?= html_escape($order['phone']);?></p></p>
						<?php if($order['email']!='null' && !empty($order['email'])): ?>
							<p><b><span><?= lang('email'); ?></span></b> <p class="ml-10"><?= html_escape($order['email']);?></p></p>
						<?php endif;?>
					
						<?php if($order['order_type'] !=4): ?>
							<p><b><span><?= lang('address'); ?></span></b> <p class="ml-10"><?= html_escape($order['address']);?></p></p>
						<?php endif;?>

					<?php endif; ?>
					<p><b><span><?= lang('order_date'); ?></span></b> <p class="ml-10"><?= full_time(html_escape($order['created_at']),restaurant()->id);?></p></p>
					<?php if($order['status']==1): ?>
						<p><b><span><?= lang('accept'); ?> </span></b> <p class="ml-10"><?= full_time(html_escape($order['accept_time']),restaurant()->id);?></p></p>
					<?php endif;?>
					<?php if($order['status']==2): ?>
						<p><b><span><?= lang('completed'); ?> </span></b> <p class="ml-10"><?= full_time(html_escape($order['completed_time']),restaurant()->id);?></p></p>
					<?php endif;?>

					<?php if($order['status']==3): ?>
						<p><b><span><?= lang('cancel'); ?></span></b> <p class="ml-10"><?= full_time(html_escape($order['cancel_time']),restaurant()->id);?></p></p>
					<?php endif;?>
				</div>
				<div class="mt-10 action_btn_area">
					<?php if($order['status']==0): ?>
						<?php if(restaurant()->es_time==0): ?>
							<a href="<?= base_url('admin/restaurant/order_status_by_ajax/'.$order['uid']).'/1' ;?>" data-shop="<?= $order['shop_id'] ;?>" class="orderStatus btn btn-info"  title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a> 
						<?php else: ?>
							<a href="javascript:;" class="btn info-light showTimeModal" data-shop="<?= $order['shop_id'] ;?>" data-id="<?= $order['uid'] ;?>" data-toggle="tooltip" title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a> &nbsp;
						<?php endif; ?>


						<a href="<?= base_url('admin/restaurant/order_status_by_ajax/'.$order['uid']).'/2' ;?>" data-shop="<?= $order['shop_id'] ;?>"  class="btn success-light orderStatus" data-toggle="tooltip" title="Mark as Completed"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;
						<?php if(is_access('order-cancel')==1): ?>
						<a href="<?= base_url('admin/restaurant/order_status_by_ajax/'.$order['uid']).'/3' ;?>" data-shop="<?= $order['shop_id'] ;?>" class="btn danger-light orderStatus" data-toggle="tooltip" title="Mark as Cancel"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('cancel'); ?></span> </a> &nbsp;
					<?php endif; ?>

					<?php elseif($order['status']==1): ?>
						<a href="javascript:;" class="btn info-light-active" data-shop="<?= $order['shop_id'] ;?>"  data-toggle="tooltip" title="Mark as Accept"><i class="fa fa-check"></i> &nbsp; <?= lang('accept'); ?> </a> &nbsp;

						<a href="<?= base_url('admin/restaurant/order_status_by_ajax/'.$order['uid']).'/2' ;?>" data-shop="<?= $order['shop_id'] ;?>" class="btn success-light orderStatus" data-toggle="tooltip" title="Mark as Completed"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;
					<?php elseif($order['status']==2): ?>
						<a href="javascript:;" class="btn info-light-active"  data-toggle="tooltip" data-shop="<?= $order['shop_id'] ;?>" title="Accepted"><i class="fa fa-check"></i> &nbsp; <?= lang('accepted'); ?> </a> &nbsp;

						<a href="javascript:;" class="btn success-light-active"  data-toggle="tooltip" data-shop="<?= $order['shop_id'] ;?>" title="Completed"><i class="fa fa-check"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;

					<?php elseif($order['status']==3): ?>
						<a href="javascript:;" class="btn danger-light-active"  data-toggle="tooltip" data-shop="<?= $order['shop_id'] ;?>" title="Cancled"><i class="fa fa-check"></i> &nbsp; <?= lang('cancled'); ?> </a> &nbsp;
					<?php endif;?>
				</div>
			</div>
			<div class="orderListBody_items">

			<?php if($order['order_type']==7): ?>
				<?php $get_dinein_items = $this->admin_m->get_dinin_items($order['dine_id']); ?>
				<div class="orderBody">
					<?php foreach ($get_dinein_items as $key => $package): ?>
						<div class="singleItems">
							<h4><a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($package['id'])); ?>" target="_blank"> <i class="fa fa-eye fz-12"></i> &nbsp;<?= $package['package_name'] ;?> </a></h4>
							<div class="single_item_body">
								<div class="extrasArea kds details_view mt-5">
									<ul class="p-0">
										<?php foreach ($package['all_items'] as $key => $item): ?>
											<li class="space-between"><span>1 x <?= $item['title'] ;?>   </span> <span><?= currency_position($item['item_price'],restaurant()->id);?></span></li>
										<?php endforeach ?>

									</ul>
								</div>
							</div>


						</div>
					<?php endforeach ?>
				</div>
			<?php endif; ?>


				<?php $qty=0;$price=0;$total_price = 0; ?>
				<?php foreach ($order['item_list'] as $key => $row): ?>
					<?php if($row['is_package']==1): ?>
						<div class="singleItem">
								<img src="<?= base_url($row['package_thumb']);?>" alt="" class="order-img">
								<div class="singleItemDetails">
									<h4> <?= html_escape($row['package_name']);?> <label class="badge default-light-soft-active"><?= lang('package'); ?></label></h4>
									<p><?= html_escape($row['qty']);?> x <?= html_escape($row['item_price']);?> = <?= currency_position($row['sub_total'],restaurant()->id);?></p>
								</div>
							</div>
						<?php else: ?>
							<div class="singleItem">
								<div class="topSingleItem">
									<img src="<?= get_img($row['item_thumb'],$row['img_url'],$row['img_type']) ;?>" alt="" class="order-img">
									<div class="singleItemDetails">
										<h4> <?= html_escape($row['title']);?> <label class="label " data-toggle="tooltip" title="<?= veg_type($row['veg_type']) ;?>"><i class="fa fa-square <?= $row['veg_type']==1?"c-success":"c-danger" ;?>"></i></label></h4>
										<?php if($row['is_size']==1): ?>
											<p class="sizeTitle mb-0"> 
												<?= lang('size'); ?> :
												<label class="mb-0"> <?= $this->admin_m->get_size_by_slug($row['size_slug'],restaurant()->user_id) ;?></label>
											</p>
										<?php endif;?>

										<p><?= html_escape($row['qty']);?> x <?= html_escape($row['item_price']);?> = <?= currency_position(html_escape($row['sub_total']),restaurant()->id) ;?>
										</p>

									</div>
								</div>
								<div class="extras">
									<?php if(isset($row['is_extras']) && $row['is_extras']==1): ?>
										<?php $extraId = json_decode($row['extra_id']); ?>
										<div class="extrasArea">
											<h4 ><?= lang('extras'); ?></h4>
											<ul>
												<?php foreach ($extraId as $key => $ex): ?>
													<li><span>1 x <?= extras($ex,$row['item_id'])->ex_name ;?></span> = <span><?= currency_position(extras($ex,$row['item_id'])->ex_price,restaurant()->id) ;?></span></li>
												<?php endforeach ?>

											</ul>
										</div>
									<?php endif;?>
								</div>

							</div>
						<?php endif;?>
						<?php 
						$qty = $qty+ $row['qty'];
						$price = $price+ $row['sub_total'];
						$total_price = $total_price+ $row['sub_total'];
						$grand_total = grand_total($total_price,$order['delivery_charge'],$order['discount'],$order['tax_fee'],$order['coupon_percent'],$order['tips'],$order['order_type'],restaurant()->tax_status,$order['is_pos']);
						
						?>
					<?php endforeach; ?>

					<div class="bottomPrice">


						<?php if($order['order_type']==7): ?>
							<p class="flex-between"><span><?= lang('qty'); ?> </span>  <b><?= $qty;?></b></p>
							<p class="flex-between"><span><?= lang('sub_total'); ?> </span> <b><?= currency_position($order['total'],restaurant()->id) ;?></b></p>
						<?php else: ?>
							<p class="flex-between"><span><?= lang('qty'); ?> </span>  <b><?= $qty ;?></b></p>
							<p class="flex-between"><span><?= lang('sub_total'); ?> </span> <b><?= currency_position($price,restaurant()->id) ;?></b></p>
						<?php endif ?>



						
						<?php if($order['tips']!=0): ?>
							<p class="flex-between"><span><?= lang('tips'); ?> </span> <b><?= currency_position($order['tips'],restaurant()->id) ;?> </b></p>
						<?php endif;?>

						<?php if($order['order_type']==1 || $order['order_type']==5): ?>
							<p class="flex-between"><span><?= lang('shipping'); ?> </span> <b><?=  currency_position($order['delivery_charge'],restaurant()->id) ;?> </b></p>
						<?php endif; ?>

						<?php if($order['tax_fee']!=0): ?>
							<p class="flex-between"><span><?= lang('tax_fee'); ?> </span> <b><?= currency_position(get_percent($price,$order['tax_fee']),restaurant()->id) ;?> </b></p>
						<?php endif; ?>

						<?php if($order['discount'] !=0): ?>
							<p class="flex-between"><span><?= lang('discount'); ?> </span> <b><?= currency_position(get_percent($price,$order['discount'],$order['is_pos']),restaurant()->id) ;?> </b></p>
						<?php endif;?>

						<?php if($order['coupon_percent']!=0): ?>
							<p class="flex-between"><span><?= lang('coupon_discount'); ?> </span> <b><?= currency_position(get_percent($price,$order['coupon_percent']),restaurant()->id) ;?> </b></p>
						<?php endif;?>



						<?php if($order['order_type']==7): ?>
							<h4 class="fw-bold pt-5 pb-10 fz-16 priceTopBorder flex-between"><span><?= lang('total'); ?></span> <span><?= currency_position($order['total'],restaurant()->id) ;?></span></h4>
						<?php else: ?>
							<h4 class="fw-bold pt-5 pb-10 fz-16 priceTopBorder flex-between"><span><?= lang('total'); ?></span> <span><?= currency_position(@$grand_total,restaurant()->id) ;?></span></h4>
						<?php endif; ?>
					</div>
			</div>
			
		</div>
		<div class="text-center mt-20 pb-20">
			<a href="<?= base_url('admin/restaurant/get_item_list_by_order_id/'.$order['uid']) ;?>" class="btn success-light-active "><i class="fa fa-eye"></i> <?= lang('order_details'); ?></a>
			</div>
	<?php endforeach; ?>
</div>


<?php include 'estimate_time_modal.php' ?>