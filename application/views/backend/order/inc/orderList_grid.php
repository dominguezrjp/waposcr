<div class="row">
	<?php $total_item = $total_amount =0; ?>
	<?php foreach ($order_list as $key => $row): ?>
		<div class="col-md-3">
			<div class="singleOrder">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"> <a href="<?= base_url("admin/restaurant/get_item_list_by_order_id/{$row['uid']}");?>">#<?= $row['uid'];?></a></h3>

					</div>
					<div class="card-body p-0 thumb-card">
						<div class="customerInfo">
							<h5 class="infoTitle"><?= lang('customer_info');?> :</h5>
							
							<?php if($row['is_guest_login']==1): ?>
								<p><?= lang('walk_in_customer');?></p>
							<?php else: ?>
								<p><?= html_escape($row['name']);?></p>
								<p><?= html_escape($row['phone']);?></p>
								<p><?= html_escape($row['address']);?></p>
							<?php endif; ?>

							<?php if($row['is_pos']==1): ?>
								<div><label class="label bg-light-purple-soft"><?= lang('pos');?></label></div>
							<?php endif ?>
						</div><!-- customerInfo -->

						<div class="orderInfo">
							<h5 class="infoTitle"><?= lang('order_type');?> :</h5>
							<?php if($row['order_type']==7 && $row['table_no'] !=0): ?>
								<label class="label bg-danger-soft"><?= lang('package_restaurant_dine_in');?> </label> &nbsp;
							<?php else: ?>
								<label class="label bg-primary-soft"><?= order_type($row['order_type']);?> </label> &nbsp;
							<?php endif ?>

							<?php if($row['order_type']==7): ?>
								<?php if(!empty($row['table_no']) || $row['table_no']!=0): ?>
									<label class="label default-light-active" data-toggle="tooltip" title="Table No"><?= lang('table'); ?> : <?= single_select_by_id($row['table_no'],'table_list')['name'] ;?></label> &nbsp;

									<div class="mt-10">
										<label class="label bg-light-purple-soft" data-toggle="tooltip" title="Table No"><?= lang('token_number'); ?> : <?= $row['token_number'] ;?></label> &nbsp;
									</div>
								<?php endif ?>
								
							<?php endif;?>


							<?php if($row['order_type']==1 || $row['order_type']==5): ?>
								<div class="mt-5">
									<?php if($row['shipping_id'] !=0): ?>
										<?php $shipping_info = shipping($row['shipping_id'],restaurant()->id) ?>
										<label class="label default-light-active"><?= !empty(lang('shipping'))?lang('shipping') : "Shipping" ;?> -- <?= $row['delivery_charge']!=0? $shipping_info['area'].' : '.currency_position($shipping_info['cost'],restaurant()->id):'Free';?> </label>
									<?php else: ?>
										<label class="label default-light-active"><?= !empty(lang('shipping'))?lang('shipping') : "Shipping" ;?> -- <?= $row['delivery_charge']!=0?currency_position($row['delivery_charge'],restaurant()->id):'Free';?> </label>
									<?php endif;?>
								</div>
							<?php endif; ?>
							<div class="mt-2">

								<?php if($row['order_type']==2): ?>
									<label class="label default-light" data-toggle="tooltip" title="Booking Date"><?= full_time($row['reservation_date'],restaurant()->id) ;?></label> &nbsp;
									<label class="label default-light" data-toggle="tooltip" title="Total Person Number"><?= lang('total_person'); ?>: <?= $row['total_person'] ;?></label>
								<?php endif;?>

								<?php if($row['order_type']==4): ?>
									<?php if(isset($row['pickup_date']) && !empty($row['pickup_date'])): ?>
									<label class="label default-light " data-toggle="tooltip" title="<?= lang('pickup_date'); ?>"><?= lang('pickup_date'); ?>: <?=!empty($row['pickup_date'])?cl_format($row['pickup_date'],restaurant()->id): time_format_12($row['reservation_date'],restaurant()->id) ;?></label> &nbsp;
								<?php endif;?>
								<div class=" mt-4">
									<label class="label bg-light-purple-soft " data-toggle="tooltip" title="Pickup Time"><?= lang('pickup_time'); ?>: <?=!empty($row['pickup_time'])?slot_time_format($row['pickup_time'],restaurant()->id): time_format_12($row['reservation_date'],restaurant()->id) ;?></label> &nbsp;
								</div>
							<?php endif;?>

							<?php if($row['is_payment']==1): ?>
								<?php if($row['is_payment']==1): ?>
									<label class="label success-light" ><?= lang('paid'); ?></label> &nbsp;
									<label class="label default-light" data-toggle="tooltip" title="Payment paid by"><?= lang($row['payment_by']); ?></label> &nbsp;
								<?php else: ?>
									<label class="label danger-light" ><?= lang('rejected'); ?></label>
								<?php endif;?>

							<?php endif;?>

							<?php if($row['order_type']==6): ?>
								<div class="mt-10">
									<label class="label default-light-active" data-toggle="tooltip" title="Table No"><?= lang('table'); ?> : <?= single_select_by_id($row['table_no'],'table_list')['name'] ;?></label> &nbsp;
									<label class="label default-light-active" data-toggle="tooltip" title="Total Person Number"><?= lang('total_person'); ?> : <?= $row['total_person'] ;?></label>
								</div>
							<?php endif;?>

							<?php if($row['order_type']==8): ?>
								<div class="mt-10">
									<label class="label default-light-active" data-toggle="tooltip"><?= lang('hotel_name'); ?> : <?= single_select_by_id($row['hotel_id'],'hotel_list')['hotel_name'] ;?></label> &nbsp;

									<label class="label default-light" data-toggle="tooltip" ><?= lang('room_number');?> : <?= $row['room_number'];?></label> &nbsp;
								</div>
							<?php endif;?>

						</div>
					</div><!-- orderInfo -->

					<div class="oder_info-2">
						<h5 class="infoTitle"><?= lang('order_details');?> :</h5>
						<?php if($row['order_type']==7): ?>
							<label class="label default-light" data-toggle="tooltip" title="Total Price"> <?= lang('price'); ?> : <?= currency_position($row['total'],restaurant()->id) ;?> </label>
							<div class="mt-2">
								<label class="label bg-primary-soft" data-toggle="tooltip" title="Order Time"> <?= lang('order'); ?> Time: <?= full_time(html_escape($row['created_at']),restaurant()->id);?></label>
							</div>
						<?php else: ?>

							<label class="label default-light" data-toggle="tooltip" title="Total Qty"> <?= lang('qty'); ?> : <?= $row['total_item'] ;?></label>
							<label class="label default-light-active" data-toggle="tooltip" title="Total Price"> <?= lang('price'); ?> : <?= currency_position(grand_total($row['total_price'],$row['delivery_charge'],$row['discount'],$row['tax_fee'],$row['coupon_percent'],$row['tips'],$row['order_type'],restaurant()->tax_status,$row['is_pos']),restaurant()->id);?></label>
							<div class="mt-2">
								<label class="label bg-primary-soft" data-toggle="tooltip" title="Order Time"> <?= lang('order'); ?> Time: <?= full_time(html_escape($row['created_at']),restaurant()->id);?></label>
							</div>
						<?php endif;?>
					</div><!-- oder_info-2 -->

				<div class="order_info_3 mb-10 mt-10 ml-10">
					<h5 class="infoTitle"><?= lang('order_status');?> :</h5>


					<?php if($row['status']==0): ?>
						<div>
							<label class="label danger-light" data-toggle="tooltip" title="Pending order"> <?= lang('pending'); ?> <i class="fa fa-spinner"></i></label>
					</div>
					<?php elseif($row['status']==1): ?>
						<label class="label info-light" data-toggle="tooltip" title="Accept By Shop"><i class="fa fa-check"></i> <?= lang('accept'); ?></label>
						<div class="mt-2">

							<?php if($row['estimate_time'] > d_time()): ?>
								<label class="label default-light">
									<?= lang('prepared_time') ;?> : <?= $row['es_time'].' '.lang($row['time_slot']) ;?> 
								</label> &nbsp; &nbsp;
								<?php if($row['status']==1 && $row['is_preparing']==2): ?>
									<label class="label default-light-active"><?= lang('prepared_finish'); ?></label> 
								<?php else: ?>
									<label class="label default-light-active get_time" id="show_time_<?= $row['id'] ;?>" data-time="<?= $row['estimate_time'] ;?>" data-id="<?= $row['id'];?>"></label> 	
								<?php endif;?>
							<?php endif;?>

						</div>
					<?php elseif($row['status']==2): ?>
						<label class="label success-light-active" data-toggle="tooltip" title="Completed Order"><i class="fa fa-check-square-o"></i> <?= lang('completed'); ?></label>

						<?php if($row['order_type']==1 || $row['order_type']==5): ?>
							<div class="deliveryStatus mt-5">
								<?php if($row['dboy_status']==1): ?>
									<label class="label default-light-active" data-toggle="tooltip" title="Accept By Delivery Saff"><i class="fa fa-check"></i> <?= lang('accepted_by_delivery_staff'); ?></label>
								<?php elseif($row['dboy_status']==2): ?>
									<label class="label default-light-active" data-toggle="tooltip" title="Picked By Delivery Saff"><i class="fa fa-check"></i> <?= lang('picked'); ?></label>
								<?php elseif($row['dboy_status']==3): ?>
									<label class="label default-light-active" data-toggle="tooltip" title="Completed By Delivery Saff"><i class="fa fa-check"></i> <?= lang('completed'); ?></label>
								<?php endif;?>
							</div>

						<?php endif;?>
					<?php elseif($row['status']==3): ?>
						<?php if(is_access('order-cancel')==1): ?>
							<label class="label danger-light-active" data-toggle="tooltip" title="Order Canceled"><i class="fa fa-ban"></i> <?= lang('canceled'); ?></label>
						<?php endif; ?>
					<?php endif;?>
					<?php if(!empty($row['customer_rating'])): ?>
						<div class="startRating mt-5" title="<?=$row['customer_rating'].' '. lang('stars'); ?>" data-toggle="tooltip">
							<?php for ($i=1; $i <=5; $i++) { ?>

								<span><i class="fa <?= $i<=$row['customer_rating']?"fa-star":"fa-star-o" ;?>"></i></span>

								<?php }; ?>
						</div>
						<?php endif;?>
					</div>

					<?php if($row['is_order_merge']==1): ?>
						<div class="mt-5 ml-10">
							<label class="label default-light-soft-active"><i class="fa fa-exchange"></i> <?= lang('order_merged');?></label>
						</div>
					<?php endif ?>

				</div><!-- card-body -->
				<div class="card-footer">
					<?php if(isset($is_filter) && $is_filter==FALSE): ?>
						<?php if($row['order_type']==7): ?>
							<a href="<?= base_url('admin/restaurant/todays_dine') ;?>" target="_blank"  class="btn success-light btn-sm btn-flat "><i class="fa fa-eye"></i></a>
						<?php else: ?>
							<a href="javascript:;" data-id="<?=  $row['uid'];?>" class="btn success-light btn-sm btn-flat quick_view"><i class="fa fa-eye"></i></a>
						<?php endif;?>
					<?php endif; ?>

					<div class="btn-group">
						<a href="javascript:;" class="dropdown-btn dropdown-toggle btn btn-danger btn-sm btn-flat" data-toggle="dropdown" aria-expanded="false">
							<span class="drop_text"><?= lang('action'); ?> </span> <span class="caret"></span>
						</a>
						<?php if(isset($is_filter) && $is_filter==TRUE): ?>
							<ul class="dropdown-menu dropdown-ul" role="menu">

								<?php if($row['order_type']==7 && !empty($row['table_no'])): ?>
								<?php else: ?>
									<li class="cl-primary-soft"><a href="<?= base_url('admin/order-details/'.$row['uid']) ;?>" ><i class="fa fa-eye"></i> <?= lang('order_details'); ?></a></li>
								<?php endif;?>

								<?php if($row['status'] == 0): ?>
									<li class="cl-info-soft">
										<?php if(restaurant()->es_time==0): ?>
											<a href="<?= base_url('admin/restaurant/order_status/'.$row['uid']).'/1' ;?>" data-shop="<?= $row['shop_id'] ;?>"  title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a>
										<?php else: ?>
											<a href="javascript:;" class="showTimeModal" data-shop="<?= $row['shop_id'] ;?>" data-id="<?= $row['uid'] ;?>"><i class="fa fa-check"></i> <?= lang('accept'); ?></a>
										<?php endif ?>
									</li>
								<?php endif;?>
								<?php if($row['status'] == 0 || $row['status'] == 1): ?>

									<li class="cl-success-soft"><a href="<?= base_url('admin/restaurant/order_status/'.$row['uid']).'/2' ;?>" data-shop="<?= $row['shop_id'] ;?>" class="" data-toggle="tooltip" title="Mark as Completed"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed'); ?> </a></li>
								<?php endif;?>

								<?php if($row['status'] == 0): ?>
									<?php if(is_access('order-cancel')==1): ?>
										<li class="cl-warning-soft" ><a href="<?= base_url('admin/restaurant/order_status/'.$row['uid']).'/3' ;?>" data-shop="<?= $row['shop_id'] ;?>" class="" data-toggle="tooltip" title="Mark as Cancel"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('cancel'); ?></span> </a></li>
									<?php endif; ?>
								<?php endif;?>

								<?php if($row['status'] != 2): ?>
									<?php if(is_access('delete')==1): ?>
										<li class="cl-danger-soft"><a href="<?= base_url('admin/menu/delete/'.$row['id']) ;?>" data-shop="<?= $row['shop_id'] ;?>" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>" class="action_btn"><i class="fa fa-trash"></i> <?= lang('delete'); ?></a></li>
									<?php endif; ?>
								<?php endif;?>
							</ul>

							<?php if($row['order_type']==7 && !empty($row['table_no'])): ?>
							<?php else: ?>
								<a href="<?= base_url('admin/restaurant/get_item_list_by_order_id/'.$row['uid']) ;?>" target="_blank"  class="btn success-light btn-sm btn-flat ml-5 "><i class="fa fa-eye"></i></a>

								<a class="btn btn-success btn-flat btn-sm ml-5" target="blank" href="<?= base_url('invoice/'.auth('username').'/'.$row['uid']); ?>">
									<i class="fa fa-file-pdf-o"></i> &nbsp;
									<?= !empty(lang('invoice'))?lang('invoice'):"Invoice" ;?>
								</a>
							<?php endif;?>
						<?php else: ?>
							<ul class="dropdown-menu dropdown-ul" role="menu">

								<?php if($row['order_type']==7 && !empty($row['table_no'])): ?>
								<?php else: ?>
									<li class="cl-primary-soft"><a href="<?= base_url('admin/order-details/'.$row['uid']) ;?>" ><i class="fa fa-eye"></i> <?= lang('order_details'); ?></a></li>
								<?php endif;?>

								<?php if($row['status'] == 0): ?>
									<li class="cl-info-soft">

										<?php if(restaurant()->es_time==0): ?>
											<a href="<?= base_url('admin/restaurant/order_status_by_ajax/'.$row['uid']).'/1' ;?>" class="orderStatus" data-shop="<?= $row['shop_id'] ;?>"  title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a> 
										<?php else: ?>
											<a href="javascript:;" class="showTimeModal" data-shop="<?= $row['shop_id'] ;?>" data-id="<?= $row['uid'] ;?>"><i class="fa fa-check"></i> <?= lang('accept'); ?></a>
										<?php endif; ?>

									</li>
								<?php endif;?>
								<?php if($row['status'] == 0 || $row['status'] == 1): ?>

									<li class="cl-success-soft"><a href="<?= base_url('admin/restaurant/order_status_by_ajax/'.$row['uid']).'/2' ;?>" data-shop="<?= $row['shop_id'] ;?>" class="orderStatus" data-toggle="tooltip" title="Mark as Completed"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed'); ?> </a></li>
								<?php endif;?>

								<?php if($row['status'] == 0): ?>
									<?php if(is_access('order-cancel')==1): ?>
										<li class="cl-warning-soft" ><a href="<?= base_url('admin/restaurant/order_status_by_ajax/'.$row['uid']).'/3' ;?>" data-shop="<?= $row['shop_id'] ;?>" class="orderStatus" data-toggle="tooltip" title="Mark as Cancel"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('cancel'); ?></span> </a></li>
									<?php endif; ?>
								<?php endif;?>

								<?php if($row['status'] != 2): ?>
									<?php if(is_access('delete')==1): ?>
										<li class="cl-danger-soft"><a href="<?= base_url('admin/menu/delete/'.$row['id']) ;?>" data-shop="<?= $row['shop_id'] ;?>" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>" class="action_btn"><i class="fa fa-trash"></i> <?= lang('delete'); ?></a></li>
									<?php endif; ?>
								<?php endif;?>
							</ul>
							<?php if($row['order_type']==7 && !empty($row['table_no'])): ?>
							<?php else: ?>
								<a class="btn btn-success btn-flat btn-sm ml-5" target="blank" href="<?= base_url('invoice/'.auth('username').'/'.$row['uid']); ?>">
									<i class="fa fa-file-pdf-o"></i> &nbsp;
									<?= !empty(lang('invoice'))?lang('invoice'):"Invoice" ;?>
								</a>
							<?php endif;?>

						<?php endif; ?>
					</div><!-- button group -->
				</div>
			</div><!-- card -->
		</div>
	</div>
	<?php 
	$total_amount += $row['total'];
	?>
<?php endforeach; ?>
<div class="counFooter">
	 <?= lang('grand_total');?> : <b><?= currency_position($total_amount,$_ENV['ID']);?></b>
	
</div>
</div>
