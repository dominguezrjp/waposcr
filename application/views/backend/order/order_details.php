
<?php $shop = restaurant(auth('id')) ?>
<?php $gmap_settings = !empty(settings()['gmap_config'])?json_decode(settings()['gmap_config']):'' ?>
<?php $apps = !empty($settings['extra_config'])?json_decode($settings['extra_config']):'' ?>

<?php 
	if((isset($shop->is_admin_gmap) && $shop->is_admin_gmap==1) && (!empty($gmap_settings->is_gmap_key) && $gmap_settings->is_gmap_key==1) && isset($shop->is_gmap) && $shop->is_gmap ==0):
		$gmap = !empty(settings()['gmap_config'])?json_decode(settings()['gmap_config']):'';
		$gmap_key = $gmap->gmap_key;
	elseif(isset($shop->is_gmap) && $shop->is_gmap ==1 && !empty($shop->gmap_key)):
		$gmap_key = $shop->gmap_key;
	else:
		$gmap_key = '';
	endif;
?>
<?php if(isset($gmap_key) && !empty($gmap_key)): ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=  $gmap_key;?>" type="text/javascript"></script>
<?php endif;?>
<div class="row">
	<div class="col-md-8">
		<?php if ($this->session->flashdata('error')) { ?>
	        <div class="alert alert-danger alert-dismissible custom_alert" id="successMessage">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	            <h4>
	                <i class="icon fa fa-exclamation-circle"></i>
	                <?= !empty(lang('error'))?lang('error'):"Error";?>!!
	            </h4>
	            <?= $this->session->flashdata('error'); ?>
	        </div>
	    <?php } ?>
	</div>
</div>
<div class="row">
	<?php foreach ($item_list as $key => $order): ?>
		<div class="col-md-8">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('order_list'))?lang('order_list'):"order list";?></h3>
					<div class="box-tools pull-right orderDetails">
						<?php if($order['order_type']!=7): ?>
							<div class="row ">
									<div class="col-md-12 text-right mb-10 mr-15">
									<?php if($order['order_type']==1 && $order['status']==2 && $order['is_db_accept']==0): ?>
										<a class="btn bg-primary-soft" target="blank" href="#deliveryGuyModal"  data-toggle="modal">
											<i class="mr-1 icofont-vehicle-delivery-van"></i>
											<?= lang('add_delivery_boy') ;?>
										</a>
									<?php endif ?>

									<?php if(isset($_GET['action']) && $_GET['action']=="Edit"): ?>
										<a class="btn btn-secondary btn-sm" href="#itemModal" data-toggle="modal">
											<i class="mr-1 fa fa-plus text-120 w-2"></i>
											<?= !empty(lang('add_more_item'))?lang('add_more_item'):"Add More Items" ;?>
										</a>
									<?php else: ?>
										<?php if(isset($apps->edit_order_type) && $apps->edit_order_type==1): ?>
												 <?php if(file_exists(APPPATH.'controllers/admin/Pos.php')): ?>
													<a class="btn bg-info-light-active btn-sm" href="<?= base_url("admin/restaurant/edit_order/{$order_details['uid']}"); ?>"> <i class="mr-1 icofont-ui-edit text-120 w-2"></i>  <?= !empty(lang('edit_order'))?lang('edit_order'):"Edit Order" ;?>  </a>
												<?php endif; ?>
										<?php else: ?>
											 <a class="btn btn-info btn-sm" href="<?= base_url("admin/order-details/{$order_details['uid']}?action=Edit"); ?>">
												<i class="mr-1 fa fa-edit text-120 w-2"></i>
												<?= !empty(lang('edit_order'))?lang('edit_order'):"Edit Order" ;?>
											</a>
										<?php endif ?>
									<?php endif;?>


									<a class="btn btn-success btn-sm" target="blank" href="<?= base_url('invoice/'.auth('username').'/'.$order['uid']); ?>" class="btn bg-white btn-light mx-1px text-95"  data-title="PDF">
										<i class="mr-1 fa fa-file-pdf-o text-120 w-2"></i>
										<?= !empty(lang('invoice'))?lang('invoice'):"Invoice" ;?>
									</a>

									
								</div>
							</div>
						<?php endif;?>	
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body small-box">
					<div class="upcoming_events">
						<div class="order_information pt-5">
							<div class="orderTop">
								<div class="d_flex_alert-admin">
									<h4 class="ml-10 "><?= lang('order_id'); ?>: #<?= $order['uid'];?> </h4>
									
									<div class="double_text">
										<div class="text-left">
											
											<?php if($order['order_type']==7 && $order['table_no'] !=0): ?>
												<h5><label class="label bg-danger-soft"><?= lang('package_restaurant_dine_in');?> </label></h5> 
											<?php else: ?>
												<h5><label class="label bg-primary-soft"><?= order_type($order['order_type']);?> </label><?php if($order['is_pos']==1): ?>
										<label class="label bg-light-purple-soft ml-5"><?= lang('pos');?></label><?php endif; ?></h5>
											<?php endif ?>
											<?php if($order['order_type']==2): ?>
												<div class="mt-10">
													<label class="label primary-light-active" data-toggle="tooltip" title="Reservation Date"><?= full_time($order['reservation_date'],restaurant()->id) ;?></label> &nbsp;
													<label class="label default-light" data-toggle="tooltip" title="Total Person Number"><?= lang('total_person'); ?>: <?= $order['total_person'] ;?></label>
												</div>
											<?php endif;?>
											<?php if($order['order_type']==4): ?>
												<div class="mt-15">
													<label class="label default-light-active  p-5 fz-14" data-toggle="tooltip" title="Pickup Time"><?= lang('pickup_time'); ?> :  <?=!empty($order['pickup_time'])?slot_time_format($order['pickup_time'],restaurant()->id): time_format_12($order['reservation_date']) ;?></label> &nbsp;
													<?php if(isset($order['pickup_date']) && !empty($order['pickup_date'])): ?>
														<h5 class="mt-10 mb-0 fz-14 color-gray"><?= lang('pickup_date'); ?>: <?=!empty($order['pickup_date'])?cl_format($order['pickup_date'],restaurant()->id): time_format_12($order['reservation_date']) ;?></h5>
													<?php endif;?>
													<h5 class="mt-10 fz-14 color-gray"><?= lang('pickup_point'); ?> : <?= single_select_by_id($order['pickup_point'],'pickup_points_area')['address'] ;?> </h5>
													
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
														<label class="label default-light-active" data-toggle="tooltip" title="Table No"><?= lang('table'); ?> : <?= single_select_by_id($order['table_no'],'table_list')['name'] ;?></label>

														<label class="label bg-light-purple-soft" data-toggle="tooltip" title="Table No"><?= lang('token_number'); ?> : <?= $order['token_number'] ;?></label> &nbsp;
													<?php endif ?>
													
												</div>
											<?php endif;?>

											<?php if($order['order_type']==8): ?>
												<div class="mt-5">
													<label class="label default-light" data-toggle="tooltip"><?= lang('hotel_name'); ?> : <?= single_select_by_id($order['hotel_id'],'hotel_list')['hotel_name'] ;?></label>

													<label class="label default-light" data-toggle="tooltip" ><?= lang('room_number');?> : <?= $order['room_number'];?></label> &nbsp;
												</div>
											<?php endif;?>

											<?php if(!empty($order['customer_rating'])): ?>
												<div class="startRating mt-15" title="<?=$order['customer_rating'].' '. lang('stars'); ?>" data-toggle="tooltip">
													<?php for ($i=1; $i <=5; $i++) { ?>
														<span><i class="fa <?= $i<=$order['customer_rating']?"fa-star":"fa-star-o" ;?>"></i></span>

														<?php }; ?>
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
									<?php if(!empty($order['name'])): ?>
										<h4><b><span><?= lang('name'); ?></span>:</b> <?= html_escape($order['name']);?></h4>
									<?php endif; ?>
									<?php if(!empty($order['phone'])): ?>
										<p><b><span><?= lang('phone'); ?></span>:</b> <?= html_escape($order['phone']);?></p>
									<?php endif; ?>
									<?php if(!empty($order['email']) && $order['email'] != 'null'): ?>
										<p><b><span><?= lang('email'); ?></span>:</b> <?= html_escape($order['email']);?></p>
									<?php endif;?>
									<?php if(!empty($order['address'])): ?>
										<p><b><span><?= lang('address'); ?></span>:</b> <?= html_escape($order['address']);?></p>
									<?php endif;?>
								<?php endif ?>

								
								<p><b><span><?= lang('order_time'); ?> </span>:</b> <?= full_time(html_escape($order['created_at']),restaurant()->id);?></p>
								
								<?php if($order['status']==1): ?>
									<p><b><span><?= lang('accept'); ?> </span>:</b> <?= full_time(html_escape($order['accept_time']),restaurant()->id);?></p>
									<?php if($order['es_time'] !=0): ?>
										<p><b><?= lang('prepared_time') ;?> :</b> <?= $order['es_time'].' '.lang($order['time_slot']) ;?></p>
									<?php endif;?>
								<?php endif;?>
								<?php if($order['status']==2): ?>
									<p><b><span><?= lang('completed'); ?> </span>:</b> <?= full_time(html_escape($order['completed_time']),restaurant()->id);?></p>
									<!-- delivery_boy -->
									<?php if(isset($order['dboy_id']) && !empty($order['dboy_id'])): ?>
										<?php $dboy_info = $this->admin_m->single_select_by_id($order['dboy_id'],'staff_list'); ?>
										<p><b><span><?= lang('dboy_name'); ?> </span>:</b> <?= $dboy_info['name'];?></p>
									<?php endif; ?>
									<!-- delivery_boy -->

								<?php endif;?>

								<?php if($order['status']==3): ?>
									<p><b><span><?= lang('canceled'); ?></span>:</b> <?= full_time(html_escape($order['cancel_time']),restaurant()->id);?></p>
								<?php endif;?>
								

								
							</div>
							<!-- order action button list -->
							<div class="mt-20 orderBtnList">
								<?php if($order['status']==0): ?>

									<?php if(restaurant()->es_time ==0): ?>
										<a href="<?= base_url('admin/restaurant/order_status/'.$order['uid']).'/1' ;?>"   class="btn info-light" title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a> &nbsp;
									<?php else: ?>
										<a href="javascript:;"  data-id="<?= $order['uid'] ;?>" class="btn info-light showTimeModal" data-toggle="tooltip" title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a> &nbsp;
									<?php endif ?>



									<a href="<?= base_url('admin/restaurant/order_status/'.$order['uid']).'/2' ;?>" class="btn success-light" data-toggle="tooltip" title="Mark as Completed"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;


									<?php if($order['is_payment']==0): ?>
										<a href="<?= base_url('admin/restaurant/order_payment_status/'.$order['id']).'/1' ;?>" class="btn primary-light" data-toggle="tooltip" title="<?= lang('mark_as_completed_paid'); ?>"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed_paid'); ?> </a> &nbsp;
									<?php else: ?>
										<a href="javascript:;" class="btn success-light-active" data-toggle="tooltip" title="Completed"><i class="fa fa-check"></i> &nbsp; <?= lang('paid'); ?> </a> &nbsp;
									<?php endif ?>
									


									<?php if(is_access('order-cancel')==1): ?>
										<a href="<?= base_url('admin/restaurant/order_status/'.$order['uid']).'/3' ;?>" class="btn danger-light" data-toggle="tooltip" title="Mark as Cancel"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('cancel'); ?> </a> &nbsp;
									<?php endif; ?>


								<?php elseif($order['status']==1): ?>

									<a href="javascript:;" class="btn info-light-active" data-toggle="tooltip" title="Mark as Accept"><i class="fa fa-check"></i> &nbsp; <?= lang('accept'); ?> </a> &nbsp;

									<a href="<?= base_url('admin/restaurant/order_status/'.$order['uid']).'/2' ;?>" class="btn success-light" data-toggle="tooltip" title="Mark as Completed"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;

									<?php if($order['is_payment']==0): ?>
										<a href="<?= base_url('admin/restaurant/order_payment_status/'.$order['id']).'/1' ;?>" class="btn primary-light" data-toggle="tooltip" title="<?= lang('mark_as_completed_paid');?>"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('mark_as_completed_paid'); ?> </a> &nbsp;
									<?php else: ?>
										<a href="javascript:;" class="btn success-light-active" data-toggle="tooltip" title="Completed"><i class="fa fa-check"></i> &nbsp; <?= lang('paid'); ?> </a> &nbsp;
									<?php endif ?>



								<?php elseif($order['status']==2): ?>
									<a href="javascript:;" class="btn info-light-active" data-toggle="tooltip" title="Accepted"><i class="fa fa-check"></i> &nbsp; <?= lang('accepted'); ?> </a> &nbsp;

									<a href="javascript:;" class="btn success-light-active" data-toggle="tooltip" title="Completed"><i class="fa fa-check"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;

									<!-- payment status -->
									<?php if($order['is_payment']==0): ?>
										<a href="<?= base_url('admin/restaurant/order_payment_status/'.$order['id']).'/2' ;?>" class="btn primary-light" data-toggle="tooltip" title="<?= lang('mark_as_paid'); ?>"><i class="fa fa-check"></i> &nbsp; <?= lang('mark_as_paid'); ?> </a> &nbsp;
									<?php else: ?>
										<a href="javascript:;" class="btn success-light-active" data-toggle="tooltip" title="Completed"><i class="fa fa-check"></i> &nbsp; <?= lang('paid'); ?> </a> &nbsp;
									<?php endif ?>
									
									<?php if($order['order_type']==1): ?>
										<?php if(isset($order['is_db_completed']) && $order['is_db_completed']==1): ?>
											<a href="javascript:;" class="btn btn-secondary" data-toggle="tooltip" title="<?= lang('delivered');?>"><i class="fa fa-check"></i> &nbsp; <?= lang('delivered');?> </a> &nbsp;
										<?php else: ?>
											<a href="<?= base_url('admin/restaurant/order_payment_status/'.$order['id']).'/3?action=delivery' ;?>"  class="btn default-light b-c-0" data-toggle="tooltip" title="<?= lang('mark_as_delivered');?>"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('mark_as_delivered');?> </a> &nbsp;
											 &nbsp;
										<?php endif;?>
									<?php endif;?>
									

								<?php elseif($order['status']==3): ?>
									<a href="javascript:;" class="btn danger-light-active" data-toggle="tooltip" title="Cancled"><i class="fa fa-check"></i> &nbsp; <?= lang('canceled'); ?> </a> &nbsp;
								<?php endif;?>

							</div>
							<!-- order action button list -->
						</div>

					<?php if($order['order_type']==7 && $order['table_no'] !=0): ?>
						<?php $get_dinein_items = $this->admin_m->get_dinin_items($order['dine_id']); ?>
						<div class="row">
							<div class="col-md-6">
								<div class="orderBody orderDetailsPage">
									<?php foreach ($get_dinein_items as $key => $package): ?>
										<div class="singleItems">
											<h4><a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($package['id'])); ?>" target="_blank"> <i class="fa fa-eye fz-12"></i> &nbsp;<?= $package['package_name'] ;?> </a></h4>
											<div class="single_item_body">
												<div class="extrasArea kds details_view mt-5">
													<ul class="p-0">
														<?php foreach ($package['all_items'] as $key => $item): ?>
															<li class="space-between"><span>1 x <?= $item['title'] ;?>   </span> <span><?= currency_position($item['item_price'],restaurant()->id);?></span></li>
														<?php endforeach; ?>
														<div class="bt-1">
															<li class="space-between fw-bold"><span><?= lang('qty');?></span> <span>  1</span></li>
															<li class="space-between fw-bold"><span><?= lang('sub_total');?></span> <span> <?= currency_position($order['total'],restaurant()->id);?></span></li>
															<li class="space-between fw-bold bt-1"><span><?= lang('total');?></span> <span>  <?= currency_position($order['total'],restaurant()->id);?></span></li>
														</div>
													</ul>
												</div>
											</div>


										</div>
									<?php endforeach ?>
								</div>
							</div>
						</div>
					<?php else: ?>

						<div class="table-responsive">
							<table class="table table-bordered table-condensed table-striped">
								<thead>
									<tr>
										<th width=""><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
										<th width=""><?= !empty(lang('image'))?lang('image'):"image";?></th>
										<th width=""><?= !empty(lang('item_name'))?lang('item_name'):"name";?></th>
										<th width=""><?= !empty(lang('qty'))?lang('qty'):"qty";?></th>
										<th width=""><?= !empty(lang('total'))?lang('total'):"total";?></th>
										<?php if(isset($_GET['action']) && $_GET['action']=="Edit"): ?>
											<th><?= lang('action'); ?></th>
										<?php endif;?>
										
										
									</tr>
								</thead>
								<tbody>

								<?php $qty=0;$price=0;$total_price = 0; ?>
								<?php foreach ($order['item_list'] as $key => $row): ?>
									<?php if($row['is_package']==1): ?>
										<tr>
											<td><?= $key+1; ;?></td>
											<td><img src="<?= base_url($row['package_thumb']);?>" alt="" class="order-img"></td>
											<td>
											 <?= html_escape($row['package_name']);?> 
											 <label class="badge default-light-soft-active"><?= lang('package'); ?></label>
											 
											</td>

											<td>
											 <?= html_escape($row['qty']);?> x <?= currency_position(html_escape($row['item_price']),restaurant()->id);?></td>
											<td><?= currency_position(html_escape($row['sub_total']),restaurant()->id) ;?>  </td>
											<td>
												
											</td>
										</tr>
									<?php else: ?>
										<tr class="<?= isset($row['is_merge']) && $row['is_merge']==1?"merge_item":"";?>">
											<td>
												<?= $key+1; ;?>
											</td>
											<td><img src="<?= get_img($row['item_thumb'],$row['img_url'],$row['img_type']) ;?>" alt="" class="order-img"></td>
											<td><?php if(!empty($row['veg_type'])): ?>
												<label class="label " data-toggle="tooltip" title="<?= veg_type($row['veg_type']) ;?>"><i class="fa fa-square <?= $row['veg_type']==1?"c-success":"c-danger" ;?>"></i></label>
											
											<?php endif;?>
											 <?= html_escape($row['title']);?> 
											 <?php if($row['is_size']==1): ?>
											 	<label class="label bg-info-light-active ml-5"> <?= lang('size'); ?> : <?= $this->admin_m->get_size_by_slug($row['size_slug'],restaurant()->user_id) ;?></label>
											<?php endif;?>
											<div class="extras">
												<?php if(isset($row['is_extras']) && $row['is_extras']==1): ?>
													<?php $extraId = json_decode($row['extra_id']); ?>
													<div class="extrasArea details_view mt-5">
														<ul>
															<?php foreach ($extraId as $key => $ex): ?>
																<li><span>1 x <?= extras($ex,$row['item_id'])->ex_name ;?></span> + <span><?= currency_position(extras($ex,$row['item_id'])->ex_price,restaurant()->id) ;?> </span></li>
															<?php endforeach ?>
															
														</ul>
													</div>
												<?php endif;?>

											</div>
												<?php if(restaurant()->is_tax==1 && $row['tax_fee']!=0): ?>
													<p class="tax_status"><?= tax($row['tax_fee'],restaurant()->tax_status);?></p>
												<?php endif ?>
												<?php if(isset($row['item_comments']) && !empty($row['item_comments'])): ?>
												<div class="mt-5">
													<p class="itemComments"><i class="fa fa-comments"></i> <?= $row['item_comments'];?></p>
												</div>
												<?php endif; ?>
												<?php if($row['is_merge']==1 && !empty($row['merge_id'])): ?>
													<div class="mt-5">
														<div class="hidden"><?= lang('merge_id');?> : <a href=""> #<?= $row['merge_id'];?></a></div>
														<label class="label default-light-soft-active"> <i class="fa fa-exchange"></i> <?= lang('merged_item');?></label>
													</div>
												<?php endif; ?>
											</td>

											<td><?= html_escape($row['qty']);?> x <?= currency_position(html_escape($row['item_price']),restaurant()->id);?></td>
											<td><?= currency_position(html_escape($row['sub_total']),restaurant()->id) ;?> </td>
											<td class="text-right">
												<?php if(isset($_GET['action']) && $_GET['action']=="Edit"): ?>
												<a href="<?= base_url("admin/restaurant/delete_order_items/{$order_details['uid']}/{$row['id']}"); ?>" class="btn btn-danger btn-sm action_btn" data-msg="<?= lang('want_to_delete'); ?>"><i class="fa fa-trash"></i></a>
												<?php endif;?>
											</td>
										</tr>
									<?php endif;?>
									<?php 
										$qty = $qty+ $row['qty'];
										$price = $price+ $row['sub_total'];
										$total_price = $total_price+ $row['sub_total'];
										$grand_total = grand_total($total_price,$order['delivery_charge'],$order['discount'],$order['tax_fee'],$order['coupon_percent'],$order['tips'],$order['order_type'],restaurant()->tax_status,$order['is_pos']);

										if($order['order_type']==1){
											$delivery_charge = $order['delivery_charge'];
										}else{
											$delivery_charge = 0;
										}
									?>
								<?php endforeach ?>
								<tr class="bolder text-left" >
									<td colspan="3"></td >
									<td colspan="2">
										<div class="bottomPrice">

											<p class="flex-between"><span><?= lang('qty'); ?> </span>  <b><?= $qty ;?></b></p>
											<p class="flex-between"><span><?= lang('sub_total'); ?> </span> <b><?= currency_position($price,restaurant()->id) ;?> </b></p>

											
											

											<?php if($order['tips']!=0): ?>
												<p class="flex-between"><span><?= lang('tips'); ?> </span> <b><?= currency_position($order['tips'],restaurant()->id) ;?> </b></p>
											<?php endif;?>

											<?php if($order['order_type']==1): ?>
												<p class="flex-between"><span><?= lang('shipping'); ?> </span> <b><?=  currency_position($order['delivery_charge'],restaurant()->id) ;?> </b></p>
											<?php endif; ?>

											<?php if($order['tax_fee'] !=0): ?>
												<p class="flex-between"><span><?= lang('tax'); ?> </span> <b><?= currency_position(get_percent($price,$order['tax_fee']),restaurant()->id) ;?> </b></p>
											<?php endif; ?>

											<?php if($order['discount'] !=0): ?>
											<p class="flex-between"><span><?= lang('discount'); ?> </span> <b><?= currency_position(get_percent($price,$order['discount'],$order['is_pos']),restaurant()->id) ;?> </b></p>
											<?php endif;?>

											<?php if($order['coupon_percent']!=0): ?>
												<p class="flex-between"><span><?= lang('coupon_discount'); ?> </span> <b><?= currency_position(get_percent($price,$order['coupon_percent']),restaurant()->id) ;?> </b></p>
											<?php endif;?>

											<h4 class="fw-bold pt-5 pb-10 fz-16 priceTopBorder flex-between"><span><?= lang('total'); ?></span> <span><?= currency_position($grand_total,restaurant()->id) ;?> </span></h4>
										</div> 
									</td> 
								</tr>
								</tbody>
							</table>
						</div><!-- table-responsive -->
					<?php endif ?>
						<?php if(isset($order['is_change']) && $order['is_change']==1): ?>
							<div class="commentsArea">
								<h4><?= lang('change_amount');?> : <?= currency_position($order['change_amount'],restaurant()->id) ;?></h4>
							</div>
						<?php endif;?>

						<?php if(!empty($order['comments'])): ?>
							<div class="commentsArea">
								<h4><?= ucfirst(lang('comments')); ?>:</h4>
								<p><?= $order['comments'] ;?></p>
							</div>
						<?php endif;?>
					</div>	
				</div><!-- /.box-body -->
			</div>
		</div>
		<?php $addresses = $order['address']; ?>
		
		<div class="col-md-4">
			<?php if(isset($order['delivery_area']) && !empty($order['delivery_area'])): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"><?= lang('order_tracking'); ?></h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="googleMp">
								<div id="maps" style="width: 100%; height: 300px;"></div>  
							</div>
						</div><!-- /.box-body -->
					</div>
				</div>
			</div><!-- row -->
			 <?php $coordinates = getCoordinatesAttribute($order['delivery_area'],$order['shop_id']);?>
			<?php endif;?>

			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"><?= lang('status_history'); ?></h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<ul class="timeline">
								<!-- timeline item -->
								<li>
									<!-- timeline icon -->
									<i class="fa fa-bell bg-green"></i>
									<div class="timeline-item">
										<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['created_at']),restaurant()->id);?></span>

										<h3 class="timeline-header"><?= !empty(lang('just_created'))?lang('just_created'):"Just created" ;?></h3>

										<div class="timeline-body">
											<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= html_escape($order['name']);?></h5>
											
											<?php if($order['order_type']==1): ?>
												<p class="mt-5 mb-5"><i class="icofont-fast-delivery fz-20"></i> <?= html_escape($order['address']);?></p>
												<div class="mt-5">
													<?php if($order['shipping_id'] !=0): ?>
														<?php $shipping_info = shipping($order['shipping_id'],restaurant()->id) ?>
														<label class="label bg-primary-soft"><?= !empty(lang('shipping'))?lang('shipping') : "Shipping" ;?> -- <?= $order['delivery_charge']!=0? $shipping_info['area'].' : '.currency_position($order['delivery_charge'],restaurant()->id):'Free';?> </label>
													<?php else: ?>
														<label class="label bg-primary-soft"><?= !empty(lang('shipping'))?lang('shipping') : "Shipping" ;?> -- <?= $order['delivery_charge']!=0?currency_position($order['delivery_charge'],restaurant()->id):'Free';?> </label>
													<?php endif;?>
												</div>
											<?php endif; ?>

											<?php if($order['is_order_merge']==1): ?>
												<div class="mt-10">
													<label class="mt-5 label label-warning"><?= lang('order_merged');?></label>
												</div>
											<?php endif ?>
											<?php if(isJson(($order['merge_ids']))): ?>
												<p class="text-muted mt-5"><b><span><?= lang('merge_id'); ?> </span>:</b> <b><?= rtrim(implode(', ', json_decode($order['merge_ids'])), ',');;?></b></p>
											<?php endif; ?>
										</div>
									</div>
								</li>
								<?php if( $order['is_payment']==1): ?>
									<?php $paymentInfo = $this->admin_m->single_select_by_order_id($order['uid'],'order_payment_info') ?>
									<li>
										<!-- timeline icon -->
										<i class="fa fa-credit-card-alt bg-green"></i>
										<div class="timeline-item">
											<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['created_at']),restaurant()->id);?></span>
											<?php if($order['is_restaurant_payment']==1): ?>
											<h3 class="timeline-header"> <label class="label bg-success-soft"><i class="fa fa-check"></i> <?= lang('paid'); ?> <?= currency_position($order['total'],restaurant()->id) ;?>  &nbsp;</label></h3>
										<?php else: ?>
											<h3 class="timeline-header"> <label class="label bg-success-soft"><i class="fa fa-check"></i> <?= lang('paid'); ?> <?= currency_position(@$paymentInfo['price'],restaurant()->id) ;?>  &nbsp;</label></h3>
										<?php endif ?>

											<div class="timeline-body">
												<h5><?= !empty(lang('payment_by'))?lang('payment_by'):"Payment By" ;?>: <label class="label bg-primary-soft"><?= $order['payment_by']; ?></label></h5>
												<?php if(isset($paymentInfo['txn_id'])): ?>
													<div class="mt-5">
														<p><?= lang('txn_id'); ?>: <?= $paymentInfo['txn_id'];?></p>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</li>
								
								<?php endif;?>


								<?php if($order['status']==1): ?>
									<li class="active">
										<!-- timeline icon -->
										<i class="fa fa-bell bg-green"></i>
										<div class="timeline-item">
											<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['accept_time']),restaurant()->id);?></span>

											<h3 class="timeline-header"><?= lang('accepted'); ?> <?= lang('by_admin') ;?></h3>

											<div class="timeline-body">
												<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('admin'); ?></h5>
												<?php if(!empty($order['es_time']) && restaurant()->es_time !=0): ?>
													<p><?= lang('prepared_time') ;?> :</b> <?= $order['es_time'].' '.lang($order['time_slot']) ;?></p>
												<?php endif; ?>
											</div>
										</div>
									</li>
									<?php if($order['is_preparing']==1): ?>
										<li class="active">
											<!-- timeline icon -->
											<i class="fa fa-bell bg-green"></i>
											<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['accept_time']),restaurant()->id);?></span>

												<h3 class="timeline-header"><?= lang('accepted'); ?> <?= !empty(lang('by_kds'))?lang('by_kds'):"By KDS" ;?></h3>

												<div class="timeline-body">
													<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('kds'); ?></h5>
													<?php if(!empty($order['es_time'])): ?>
														<p><?= lang('prepared_time') ;?> :</b> <?= $order['es_time'].' '.lang($order['time_slot']) ;?></p>
													<?php endif; ?>
												</div>
											</div>
										</li>
									<?php endif;?>

									<?php if($order['is_preparing']==2): ?>
										<li class="active">
											<!-- timeline icon -->
											<i class="fa fa-bell bg-green"></i>
											<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['accept_time']),restaurant()->id);?></span>

												<h3 class="timeline-header kds"><?= lang('accepted'); ?> <?= !empty(lang('by_kds'))?lang('by_kds'):"By KDS" ;?></h3>

												<div class="timeline-body">
													<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('kds'); ?></h5>
													<?php if(!empty($order['es_time'])): ?>
														<p><?= lang('prepared_time') ;?> :</b> <?= $order['es_time'].' '.lang($order['time_slot']) ;?></p>
													<?php endif; ?>
												</div>
											</div>
										</li>

										<li class="active">
											<!-- timeline icon -->
											<i class="fa fa-bell bg-green"></i>
											<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['accept_time']),restaurant()->id);?></span>

												<h3 class="timeline-header kds"><?= lang('completed'); ?> <?= !empty(lang('by_kds'))?lang('by_kds'):"By KDS" ;?></h3>

												<div class="timeline-body">
													<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('kds'); ?></h5>
													<?php if(!empty($order['es_time'])): ?>
														<p><?= lang('prepared_time') ;?> :</b> <?= $order['es_time'].' '.lang($order['time_slot']) ;?></p>
													<?php endif; ?>
												</div>
											</div>
										</li>
									<?php endif;?>
								
								<?php endif;?>
								<?php if($order['status']==2): ?>
									<li class="active">
										<!-- timeline icon -->
										<i class="fa fa-bell bg-green"></i>
										<div class="timeline-item">
											<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['accept_time']),restaurant()->id);?></span>

											<h3 class="timeline-header"><?= lang('accepted'); ?> <?= lang('by_admin') ;?></h3>

											<div class="timeline-body">
												<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('admin'); ?></h5>
												<?php if(!empty($order['es_time'])): ?>
													<p><?= lang('prepared_time') ;?> :</b> <?= $order['es_time'].' '.lang($order['time_slot']) ;?></p>
												<?php endif; ?>
											</div>
										</div>
									</li>
									<?php if(isset($order['is_delivery']) && $order['is_delivery']==1): ?>
										<li class="active">
											<!-- timeline icon -->
											<i class="fa fa-bell bg-green"></i>
											<div class="timeline-item">
												<h3 class="timeline-header"><?= lang('delivery'); ?> <?= lang('by_admin') ;?></h3>

												<div class="timeline-body">
													<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('admin'); ?></h5>
													<?php if(!empty($order['company_details'])): ?>
														<h4 class="mt-10"><?= lang('delivery') ;?> :</b> <?= $order['company_details'] ;?></h4>
													<?php endif; ?>

													<?php if(!empty($order['tracking_number'])): ?>
														<p><?= lang('tracking_number') ;?> : <b> <?= $order['tracking_number'] ;?></b></p>
														<p><?= lang('delivery_date') ;?> : <b> <?= full_date($order['delivery_date'],restaurant()->id) ;?></b></p>
													<?php endif; ?>
												</div>
											</div>
										</li>

									<?php endif;?>
									<?php if($order['order_type']==1): ?>
										<?php if($order['dboy_status']==0): ?>
										<li>
											<!-- timeline icon -->
											<i class="fa fa-bell bg-green"></i>
											<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['completed_time']),restaurant()->id);?></span>

												<h3 class="timeline-header"><?= lang('completed'); ?> <?= lang('by_admin') ;?></h3>

												<div class="timeline-body">
													<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('admin'); ?></h5>
													
													<?php if(isset($order['dboy_id']) && !empty($order['dboy_id'])): ?>
														<?php $dboy_info = $this->admin_m->single_select_by_id($order['dboy_id'],'staff_list'); ?>
														<p><b><span><?= lang('dboy_name'); ?> </span>:</b> <?= $dboy_info['name'];?></p>
													<?php else: ?>
														<p><?= !empty(lang('order_is_waiting_for_picked'))?lang('order_is_waiting_for_picked'):"Order is waiting for picked" ;?> </p>
													<?php endif; ?>
												</div>
											</div>
										</li>
									<?php endif;?>
									<?php if($order['is_db_accept']==1): ?>
										<li>
											<!-- timeline icon -->
											<i class="fa fa-bell bg-green"></i>
											<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['dboy_accept_time']),restaurant()->id);?></span>
												<?php $dboy_info = $this->admin_m->single_select_by_id($order['dboy_id'],'staff_list'); ?>
												<h3 class="timeline-header"><?= !empty(lang('accepted_by_delivery_staff'))?lang('accepted_by_delivery_staff'):"Accepted By Delivery Staff" ;?> </h3>

												<div class="timeline-body">
													<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('delivery_staff'); ?></h5>
													<p><?= !empty(lang('accepted_by'))?lang('accepted_by'):"Accepted By" ;?> : <b><?= $dboy_info['name'] ;?></b></p>
												</div>
											</div>
										</li>
									<?php endif; ?>
									<?php if($order['is_picked']==1): ?>
										<li>
											<!-- timeline icon -->
											<i class="fa fa-bell bg-green"></i>
											<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['dboy_picked_time']),restaurant()->id);?></span>
												<?php $dboy_info = $this->admin_m->single_select_by_id($order['dboy_id'],'staff_list'); ?>
												<h3 class="timeline-header"><?= !empty(lang('picked_by_delivery_staff'))?lang('picked_by_delivery_staff'):"Picked By Delivery Staff" ;?> </h3>

												<div class="timeline-body">
													<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('delivery_staff'); ?></h5>
													<p><?= !empty(lang('picked_by'))?lang('picked_by'):"picked By" ;?> : <b><?= $dboy_info['name'] ;?></b></p>
												</div>
											</div>
										</li>
									<?php endif; ?>

									<?php if($order['is_db_completed']==1): ?>
										<li>
											<!-- timeline icon -->
											<i class="fa fa-bell bg-green"></i>
											<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['dboy_picked_time']),restaurant()->id);?></span>

												<?php if($order['db_completed_by']=='restaurant'): ?>
													<h3 class="timeline-header"><?= !empty(lang('delivered_by_delivery_staff'))?lang('delivered_by_delivery_staff'):"Delivered By Delivery Staff" ;?> </h3>
													<div class="timeline-body">
														<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <b><?= lang('vendor'); ?></b></h5>
														<p><?= !empty(lang('delivered_by'))?lang('delivered_by'):"Delivered By" ;?> : <b><?= isset($dboy_info['name']) && !empty($dboy_info['name'])?$dboy_info['name']:lang('admin') ;?></b></p>
													</div>
												<?php else: ?>
												<?php $dboy_info = $this->admin_m->single_select_by_id($order['dboy_id'],'staff_list'); ?>
													<h3 class="timeline-header"><?= !empty(lang('delivered_by_delivery_staff'))?lang('delivered_by_delivery_staff'):"Delivered By Delivery Staff" ;?> </h3>

													<div class="timeline-body">
														<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('delivery_staff'); ?></h5>
														<p><?= !empty(lang('delivered_by'))?lang('delivered_by'):"Delivered By" ;?> : <b><?= isset($dboy_info['name']) && !empty($dboy_info['name'])?$dboy_info['name']:lang('admin') ;?></b></p>
													</div>
												<?php endif; ?>
											</div>
										</li>
									<?php endif; ?>

									<?php else: ?> <!-- order type 1&5 -->
										<li>
											<!-- timeline icon -->
											<i class="fa fa-bell bg-green"></i>
											<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['completed_time']),restaurant()->id);?></span>

												<h3 class="timeline-header"><?= lang('completed'); ?> <?= lang('by_admin') ;?></h3>

												<div class="timeline-body">
													<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('admin'); ?></h5>
													<p><?= !empty(lang('order_is_on_the_way'))?lang('order_is_on_the_way'):"Order is on the way" ;?> </p>
												</div>
											</div>
										</li>
									<?php endif; ?>
								
								<?php endif;?>
								<?php if($order['status']==3): ?>
									<li>
										<!-- timeline icon -->
										<i class="fa fa-bell bg-red"></i>
										<div class="timeline-item">
											<span class="time"><i class="fa fa-clock-o"></i> <?= full_time(html_escape($order['cancel_time']),restaurant()->id);?></span>

											<h3 class="timeline-header"><?= lang('canceled'); ?> <?= lang('by_admin') ;?></h3>

											<div class="timeline-body">
												<h5><?= !empty(lang('status_from'))?lang('status_from'):"Status from" ;?>: <?= lang('admin'); ?></h5>
												
											</div>
										</div>
									</li>
								
								<?php endif;?>

								<!-- END timeline item -->

							</ul>
							<div class="card px-20" style="border:0; box-shadow: none;display: none;">
								<form action="<?= base_url("admin/restaurant/send_message"); ?>" method="post" target="_blank">
									<?=  csrf();?>
									<div class="card-body">
										<?php $country_list = $this->admin_m->select('country'); ?>
										<div class="msgArea">
											<div class="form-group">
												<label for=""><?= lang('country_code'); ?></label>
												<select name="dial_code" class="form-control select2">
													<?php foreach ($country_list as $key => $country): ?>
														<option value="<?= $country['dial_code']; ?>"><?= $country['code']; ?> (<?= $country['dial_code']; ?>)</option>
													<?php endforeach ?>

												</select>
											</div>
											<div class="form-group">
												<label for=""><?= lang('phone'); ?></label>
												<input type="text" name="phone" class="form-control" value="<?=  $order['phone'];?>">
											</div>

											<div class="form-group">
												<label for=""><?= lang('status'); ?></label>
												<select name="status" class="form-control">
													<option value="accepted"><?= lang('accepted'); ?></option>
													<option value="completed"><?= lang('completed'); ?></option>
													<option value="delivered"><?= lang('delivered'); ?></option>
												</select>
											</div>
										</div>
									</div>
									<div class="card-footer text-right">
										<input type="hidden" name="order_id" value="<?= $order['uid'] ;?>">
										<button class="btn btn-success" type="submit"><i class="fa fa-whatsapp"></i> <?= lang('submit'); ?></button>
									</div>
								</form>
							</div>
						</div><!-- /.box-body -->
					</div>
				</div>
			</div><!-- row -->



		</div>
	<?php endforeach; ?>
</div>


<!-- Modal -->
<div id="itemModal" class="modal fade " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content" id="showItems">
			<?php include 'inc/item_modal_content.php'; ?>
		</div>
	</div>
</div>


<?php 
	$dboyList = $this->admin_m->get_my_delivery_boy(auth('id'));

 ?>
<div id="deliveryModal" class="modal fade " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content" id="showItems">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">#<?= $order['uid'] ;?><?= lang('delivery_status'); ?></h4>
			</div>
			<form action="<?= base_url("admin/restaurant/add_delivery"); ?>" method="post">
				<?= csrf() ;?>
				<div class="modal-body">
					<div class="form-group">
						<label for=""><?= lang('select_delivery_boy'); ?></label>
						<select name="db_boy_id" id="add_dboy" class="form-control">
							<?php foreach ($dboyList as $dboy): ?>
								<option value="<?= $dboy['id'];?>"> <?= $dboy['name'];?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group">
						<label for=""><?= lang('tracking_number'); ?></label>
						<input type="text" name="tracking_number" class="form-control">
					</div>

					<div class="form-group">
						<label for=""><?= lang('company_details'); ?></label>
						<textarea name="company_details" class="form-control" cols="5" rows="5"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" value="<?= $order['id'] ;?>">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close');?></button>
					<button type="submit" class="btn btn-primary"><?= lang('save_change');?></button>
				</div>
			</form>
		</div>
	</div>
</div>


<div id="deliveryGuyModal" class="modal fade " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content" id="showItems">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">#<?= $order['uid'] ;?><?= lang('delivery_status'); ?></h4>
			</div>
			<form action="<?= base_url("admin/restaurant/add_delivery_guy"); ?>" method="post">
				<?= csrf() ;?>
				<div class="modal-body">
					<div class="form-group">
						<label for=""><?= lang('select_delivery_boy'); ?></label>
						<select name="db_boy_id" id="add_dboy" class="form-control">
							<?php foreach ($dboyList as $dboy): ?>
								<option value="<?= $dboy['id'];?>"> <?= $dboy['name'];?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" value="<?= $order['id'] ;?>">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close');?></button>
					<button type="submit" class="btn btn-primary"><?= lang('save_change');?></button>
				</div>
			</form>
		</div>
	</div>
</div>








<!-- Modal -->
<div id="SetTimeModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?= lang('set_prepared_time'); ?></h4>
			</div>
			<form action="<?= base_url('admin/restaurant/order_status/1/1') ;?>" method="post" autocomplete="off">
				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

				<div class="modal-body">
					<div class="setTime">
						<div class="row">
							<div class="col-md-5 pr-5">
								<input type="number" name="es_time" class="form-control" placeholder="<?= lang('set_time'); ?>" required value="<?= !empty(restaurant()->es_time)? restaurant()->es_time: 0 ;?>">
						
							</div>
							<div class="col-md-7 pl-5">
								<select name="time_slot" class="form-control" id="" required>
									<option value=""><?= lang('select'); ?></option>
									<option value="minutes" <?= restaurant()->time_slot=="minutes"?"selected":"" ;?>><?= lang('minutes'); ?></option>
									<option value="hours" <?=  restaurant()->time_slot=="hours"?"selected":"";?>><?= lang('hours'); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="uid" class="uid" value="">
					<div class="text-right">
						<button type="submit" class="btn btn-info"><?= lang('submit'); ?></button>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>


<?php if(isset($gmap_key) &&  !empty($gmap_key) && isset($coordinates)): ?>

<script type="text/javascript">
	function initialize() {
	   var latlng = new google.maps.LatLng(<?= isset($coordinates['latitude'])?$coordinates['latitude']:'' ;?>,<?= isset($coordinates['longitude'])?$coordinates['longitude']:'' ;?>);
	    var map = new google.maps.Map(document.getElementById('maps'), {
	      center: latlng,
	      zoom: 18
	    });
	    var marker = new google.maps.Marker({
	      map: map,
	      position: latlng,
	      draggable: false,
	      anchorPoint: new google.maps.Point(0, -29)
	   });
	    var infowindow = new google.maps.InfoWindow();   
	    google.maps.event.addListener(marker, 'click', function() {
	      var iwContent = '<div id="iw_container">' +
	      '<div class="iw_title"><b>Location</b> : <?=  isset($addresses)?$addresses:'';?></div></div>';
	      // including content to the infowindow
	      infowindow.setContent(iwContent);
	      // opening the infowindow in the current map and at the current marker location
	      infowindow.open(map, marker);
	    });
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
<?php endif;?>


<script>
	function add_price(price,id){
		$(`.item_price_${id}`).val(price);
	}
</script>