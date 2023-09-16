
<div class="container">
	<div class="page-content">
		<div class="card" id="print_area">
			<div class="row mt-4">
				<div class="col-12 col-lg-12">

					<div class="row">
						<div class="col-12">
							<h4><?= lang('order_id'); ?> #<?= $order_info['uid'];?> </h4>
							<?php if($order_info['order_type']==5 || $order_info['is_payment']==1): ?>
								<span class="badge badge-success"><?= lang('paid'); ?></span>
							<?php endif;?>


							<small class="text-muted"><?= full_date($order_info['created_at'],$shop->id);?></small><br />
							<small class="text-muted"><?= lang('order_type'); ?>: <?= order_type($order_info['order_type']) ;?>
								
							<?php if($order_info['order_type'] == 4): ?>
								, <?= cl_format(!empty($order_info['pickup_date'])?$order_info['pickup_date']:$order_info['created_at']) ;?>
							<?php endif;?>
							</small>

							<hr />
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="customerInfo">
								<h3><?= !empty(lang('customer_name'))?lang('customer_name'):"Customer Name" ;?> : <?= $order_info['name'];?></h3>
								<p><?= lang('phone'); ?> : <?= $order_info['phone'];?></p>
								<p><?= lang('address'); ?> : <?= $order_info['address'];?></p>
							</div>
						</div>
						<!-- /.col -->

						<div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">

							<div class="customerInfo">
								<h2><?= !empty($shop->name)?$shop->name:$shop->username;?></h2>
								<p>
									<?= lang('phone'); ?> : <?= !empty($shop->phone)?$shop->phone:"";?>
									<br />
									<?= lang('email'); ?> : <?= !empty($shop->email)?$shop->email:"";?>
									<br />
									<?= lang('address'); ?> : <?= !empty($shop->address)?$shop->address:"";?>
									<br />
								</p>
							</div>


						</div>
						<!-- /.col -->
					</div>

					<div class="mt-4">

						<div class="table-responsive">
							<table class="table customTable invoiceTable" id="example1">
								<thead >
									<tr class="text-600 text-white bgc-default-tp1 py-25">
										<th>#</th>
										<th><?= lang('name'); ?></th>
										<th><?= lang('qty'); ?></th>
										<th><?= !empty(lang('unit_price'))?lang('unit_price'):"Unit Price"; ?></th>
										<th><?= !empty(lang('amount'))?lang('amount'):"Amount"; ?></th>
									</tr>
								</thead>
								<tbody>
									<?php $shop_id = restaurant($id)->id; ?>
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
										<tr>
											<td><?= $key+1;?></td>
											<td>
												<p><?= $row['is_package']==1?$row['package_name']:$row['name'];?> 
												<?php if($row['is_size']==1): ?>
													<span class="text-green"><?= lang('size'); ?> : <?= get_size($row['size_slug'],$row['shop_id']) ?></span>
												<?php endif;?>
											</p>
											<?php if(isset($row['is_extras']) && $row['is_extras']==1): ?>
												<?php $extraId = json_decode($row['extra_id']); ?>
												<div class="extars">
													<ul>
														<?php foreach ($extraId as $key => $ex): ?>
															<li><span>1 x <?= extras($ex,$row['item_id'])->ex_name ;?></span> = <span><?= currency_position(extras($ex,$row['item_id'])->ex_price,restaurant($id)->id) ;?> </span></li>
														<?php endforeach ?>
													</ul>
												</div>
											<?php endif;?>
											<p class="tax_fee">tax</p>
										</td>
										<td><?= $row['qty'];?></td>
										<td><?= currency_position($row['item_price'],$shop_id);?></td>
										<td><?= currency_position($row['item_price']*$row['qty'],$shop_id);?></td>
									</tr>
								<?php endforeach ?>
								<tr >
									<td colspan="3"></td>
									<td>
										<p><?= lang('sub_total'); ?></p>
										<p><?= lang('shipping'); ?></p>
											<p><?= lang('tax'); ?></p>
											
											<?php  if($tips !=0):?>
												<p><?= lang('tips'); ?></p>
											<?php endif ?>

											<?php  if($discount!=0):?>
												<p><?= lang('discount'); ?></p>
											<?php endif ?>

											<?php  if($coupon_percent!=0):?>
												<p><?= lang('coupon_discount'); ?></p>
											<?php endif ?>

											<p><b><?= lang('total'); ?></b></p>
									</td>
									<td>
										<p><b><?= $net_total;?></b></p>
										
										<p><?= $order_info['delivery_charge']==0?0:currency_position($order_info['delivery_charge'],$shop_id) ;?> </p>

											<p><?= currency_position($tax_fee,$shop_id);?> </p>

											<?php  if($tips !=0):?>
												<p><?= currency_position($tips,$shop_id);?> </p>
											<?php endif;?>
											<?php  if($discount!=0):?>
												<p><?= currency_position($discount,$shop_id);?> </p>
											<?php endif;?>

											<?php if($coupon_percent!=0): ?>
												<p><?= currency_position($coupon_percent,$shop_id);?> </p>
											<?php endif;?>
											
											<p><b><?= currency_position($grand_total,$shop_id);?> </b></p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

