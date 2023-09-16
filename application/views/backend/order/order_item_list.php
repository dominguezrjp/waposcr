<div class="row">
	<?php foreach ($item_list as $key => $order): ?>
		<div class="col-md-8">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('order_list'))?lang('order_list'):"order list";?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body bg_gray">
					<div class="upcoming_events">
						<div class="order_information">
							<div class="single_alert alert alert-info alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<div class="d_flex_alert-admin">
									<h4 class="ml-10"><?= lang('order_id'); ?>: #<?= $order['uid'];?></h4>
									<div class="double_text">
										<div class="text-left">
											<h5><label class="order-type default-light-active"> <?= order_type($order['order_type']);?></label></h5>
											<?php if($order['order_type']==1 || $order['order_type']==5): ?>
												<div class="mt-10 text-center">
													<label class="label default"><?= !empty(lang('delivery_charge'))?lang('delivery_charge') : "Delivery charge" ;?>: <?= $order['delivery_charge']!=0?$order['delivery_charge']:lang('free');?> </label>
												</div>
											<?php endif; ?>
											<?php if($order['order_type']==2): ?>
												<div class="mt-10">
													<label class="label primary-light-active" data-toggle="tooltip" title="Reservation Date"><?= full_time($order['reservation_date'],restaurant()->id) ;?></label> &nbsp;
													<label class="label default-light" data-toggle="tooltip" title="Total Person Number"><?= lang('total_person'); ?>: <?= $order['total_person'] ;?></label>
												</div>
											<?php endif;?>
											<?php if($order['order_type']==4): ?>
												<div class="mt-10">
													<label class="label default-light-active" data-toggle="tooltip" title="Pickup Time"><?= lang('pickup_time'); ?> :  <?=!empty($order['pickup_time'])?$order['pickup_time']: time_format_12($order['reservation_date']) ;?></label> &nbsp;
													<h5 class="mt-10"><?= lang('pickup_point'); ?> : <?= single_select_by_id($order['pickup_point'],'pickup_points_area')['address'] ;?> </h5>
												</div>
											<?php endif;?>

											<?php if($order['order_type']==6): ?>
													<div class="mt-10">
														<label class="label default-light-active" data-toggle="tooltip" title="Pickup Time"><?= lang('table'); ?> : <?= $order['table_no'] ;?></label> &nbsp;
														<label class="label default-light-active" data-toggle="tooltip" title="Total Person Number"><?= lang('total_person'); ?> : <?= $order['total_person'] ;?></label>
													</div>
												<?php endif;?>


										</div>
									</div>
								</div>
							</div>


							
							<div class="order_details">
								<h4><b><span><?= lang('name'); ?></span>:</b> <?= html_escape($order['name']);?></h4>
								<p><b><span><?= lang('phone'); ?></span>:</b> <?= html_escape($order['phone']);?></p>
								<p><b><span><?= lang('email'); ?></span>:</b> <?= html_escape($order['email']);?></p>
								<?php if(!empty($order['address'])): ?>
									<p><b><span><?= lang('address'); ?></span>:</b> <?= html_escape($order['address']);?></p>
								<?php endif;?>
								<p><b><span><?= lang('order'); ?> </span>:</b> <?= full_time(html_escape($order['created_at']),restaurant()->id);?></p>
								<?php if($order['status']==1): ?>
									<p><b><span><?= lang('accept'); ?> </span>:</b> <?= full_time(html_escape($order['accept_time']),restaurant()->id);?></p>
									<p><b><?= lang('prepared_time') ;?> :</b> <?= $order['es_time'].' '.lang($order['time_slot']) ;?></p>
								<?php endif;?>
								<?php if($order['status']==2): ?>
									<p><b><span><?= lang('completed'); ?> </span>:</b> <?= full_time(html_escape($order['completed_time']),restaurant()->id);?></p>
								<?php endif;?>

								<?php if($order['status']==3): ?>
									<p><b><span><?= lang('calcel'); ?></span>:</b> <?= full_time(html_escape($order['cancel_time']),restaurant()->id);?></p>
								<?php endif;?>
							</div>
							
							<div class="mt-20">
								<?php if($order['status']==0): ?>
									<a href="javascript:;"  data-id="<?= $order['uid'] ;?>" class="btn info-light showTimeModal" data-toggle="tooltip" title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a> &nbsp;

									<a href="<?= base_url('admin/restaurant/order_status/'.$order['uid']).'/2' ;?>" class="btn success-light" data-toggle="tooltip" title="Mark as Completed"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;
									
									<?php if(is_access('order-cancel')==1): ?>
										<a href="<?= base_url('admin/restaurant/order_status/'.$order['uid']).'/3' ;?>" class="btn danger-light" data-toggle="tooltip" title="Mark as Cancel"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('cancel'); ?> </a> &nbsp;
									<?php endif; ?>
								<?php elseif($order['status']==1): ?>
									<a href="javascript:;" class="btn info-light-active" data-toggle="tooltip" title="Mark as Accept"><i class="fa fa-check"></i> &nbsp; <?= lang('accept'); ?> </a> &nbsp;

									<a href="<?= base_url('admin/restaurant/order_status/'.$order['uid']).'/2' ;?>" class="btn success-light" data-toggle="tooltip" title="Mark as Completed"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;
								<?php elseif($order['status']==2): ?>
									<a href="javascript:;" class="btn info-light-active" data-toggle="tooltip" title="Accepted"><i class="fa fa-check"></i> &nbsp; <?= lang('accepted'); ?> </a> &nbsp;

									<a href="javascript:;" class="btn success-light-active" data-toggle="tooltip" title="Completed"><i class="fa fa-check"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;

								<?php elseif($order['status']==3): ?>
									<?php if(is_access('order-cancel')==1): ?>
										<a href="javascript:;" class="btn danger-light-active" data-toggle="tooltip" title="Cancled"><i class="fa fa-check"></i> &nbsp; <?= lang('canceled'); ?> </a> &nbsp;
									<?php endif; ?>
								<?php endif;?>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-condensed table-striped" id="example1">
								<thead>
									<tr>
										<th width=""><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
										<th width=""><?= !empty(lang('image'))?lang('image'):"image";?></th>
										<th width=""><?= !empty(lang('item_name'))?lang('item_name'):"name";?></th>
										<th width=""><?= !empty(lang('qty'))?lang('qty'):"qty";?></th>
										<th width=""><?= !empty(lang('total'))?lang('total'):"total";?></th>
										
										
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
											<td><?= currency_position(html_escape($row['sub_total']),restaurant()->id) ;?></td>
											<td>
												
											</td>
										</tr>
									<?php else: ?>
										<tr>
											<td><?= $key+1; ;?></td>
											<td><img src="<?= get_img($row['item_thumb'],$row['img_url'],$row['img_type']) ;?>" alt="" class="order-img"></td>
											<td><?php if(!empty($row['veg_type'])): ?>
												<label class="label " data-toggle="tooltip" title="<?= veg_type($row['veg_type']) ;?>"><i class="fa fa-square <?= $row['veg_type']==1?"c-success":"c-danger" ;?>"></i></label>
											
											<?php endif;?>
											 <?= html_escape($row['title']);?> 
											 <?php if($row['is_size']==1): ?>
											 	<label class="label bg-info-light-active ml-5"> Size: <?= $this->admin_m->get_size_by_slug($row['size_slug'],restaurant()->user_id) ;?></label>
											<?php endif;?>
											 <?php if(!empty($row['items_content'])): ?>
												 <div class="mt-5">
												 	<?php foreach ($row['items_content'] as $key => $contents): ?>
												 		<label class="badge default-light-soft-active"><?=  html_escape($contents['label']);?> : <?=  html_escape($contents['value']);?></label> &nbsp;
												 	<?php endforeach ?>
												 </div>
											<?php endif;?>

											</td>

											<td><?= html_escape($row['qty']);?> x <?= currency_position(html_escape($row['item_price']),restaurant()->id);?> </td>
											<td><?= currency_position(html_escape($row['sub_total']),restaurant()->id) ;?> </td>
											<td>
												
											</td>
										</tr>
									<?php endif;?>
									<?php 
										$qty = $qty+ $row['qty'];
										$price = $price+ $row['item_price'];
										$total_price = $total_price+ $row['sub_total'];

										if($order['order_type']==1 || $order['order_type']==5){
											$last_price = $total_price.' + '.$order['delivery_charge'].'= '.($total_price+$order['delivery_charge']);
										}else{
											$last_price = $total_price;
										}
									?>
								<?php endforeach ?>
								<tr class="bolder" >
									<td colspan="2"></td >
									<td><?= lang('total'); ?></td> 
									<td><?= $qty ;?> </td> 
									<td><?=  currency_position($last_price,restaurant()->id);?></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>	
				</div><!-- /.box-body -->
			</div>
		</div>
	<?php endforeach; ?>
</div>

<?php include 'estimate_time_modal.php' ?>