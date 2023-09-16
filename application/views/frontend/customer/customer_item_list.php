<?php foreach ($order_list as $key => $order): ?>
<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel"><?= lang('order_id'); ?> #<?= $order['uid'] ;?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true"><i class="icofont-close-line"></i></span>
	</button>
</div><!-- modal header -->
<div class="modal-body">
	<div class="table-responsive">
		<table class="table table-bordered table-condensed table-striped">
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
								<label class="badge badge-info fw_normal"><?= lang('package'); ?></label>

							</td>

							<td>
								<?= html_escape($row['qty']);?> x <?= currency_position($row['item_price'],$row['shop_id']);?></td>
								<td><?= currency_position($row['sub_total'],$row['shop_id']);?></td>

							</tr>
						<?php else: ?>
							<tr>
								<td><?= $key+1; ;?></td>
								<td><img src="<?= base_url($row['item_thumb']);?>" alt="" class="order-img"></td>
								<td>
									<?= html_escape($row['title']);?> <?php if(isset($row['veg_type']) && $row['veg_type'] !=0): ?> <i class="fa fa-circle veg_type <?= $row['veg_type']==1?'c_green':'c_red';?>" data-placement="top" data-toggle="tooltip" title="<?= veg_type($row['veg_type']);?>"></i><?php endif;?>

									<div>
										<?php if($row['is_size']==1): ?>
											<label class="label bg-info-light-active ml-5"> <?= lang('size'); ?>: <?= $this->admin_m->get_single_size_by_slug($row['size_slug'],$row['shop_id']) ;?></label>
										<?php endif;?>
									</div>
								</td>

								<td><?= html_escape($row['qty']);?> x <?= currency_position($row['item_price'],$row['shop_id']);?></td>
								<td><?= currency_position($row['sub_total'],$row['shop_id']);?></td>

							</tr>
						<?php endif;?>
						<?php 
						
						$qty = $qty+ $row['qty'];
						$price = $price+ $row['item_price'];
						$total_price = $total_price+ $row['sub_total'];
						$grand_total = grand_total($total_price,$order['delivery_charge'],$order['discount'],$order['tax_fee'],$order['coupon_percent'],$order['tips'],$order['order_type'],shop($row['shop_id'])->tax_status,$order['is_pos']);
						?>
					<?php endforeach; ?>
					<tr class="bolder" >
						<td colspan="3"></td >
						<td colspan="2">
							<div class="bottomPrice">
								<p class="flex-between"><span><?= lang('qty'); ?> </span>  <b><?= $qty ;?></b></p>
								<p class="flex-between"><span><?= lang('sub_total'); ?> </span> <b><?= currency_position($total_price,$order['shop_id']) ;?> </b></p>
								<p class="flex-between"><span><?= lang('tax_fee'); ?> </span> <b><?= currency_position(get_percent($price,$order['tax_fee']),$order['shop_id']) ;?></b></p>

								<?php if($order['tips']!=0): ?>
									<p class="flex-between"><span><?= lang('tips'); ?> </span> <b><?= currency_position($order['tips'],$order['shop_id']) ;?> </b></p>
								<?php endif;?>

								<?php if($order['order_type']==1 || $order['order_type']==5): ?>
									<p class="flex-between"><span><?= lang('shipping'); ?> </span> <b><?=  currency_position($order['delivery_charge'],$order['shop_id']) ;?> </b></p>
								<?php endif; ?>

								<?php if(isset($order['discount']) && $order['discount'] !=0): ?>
									<p class="flex-between"><span><?= lang('discount'); ?> </span> <b><?= currency_position(get_percent($price,$order['discount'],$order['is_pos']),$order['shop_id']) ;?> </b></p>
								<?php endif;?>

								<?php if($order['coupon_percent']!=0): ?>
									<p class="flex-between"><span><?= lang('coupon_discount'); ?> </span> <b><?= currency_position(get_percent($price,$order['coupon_percent']),$order['shop_id']) ;?> </b></p>
								<?php endif;?>

								<h4 class="fw-bold pt-5 pb-10 fz-16 priceTopBorder flex-between"><span><?= lang('total'); ?></span> <span><?= currency_position($grand_total,$order['shop_id']) ;?> </span></h4>
							</div>
						</td>
					</tr>
				</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<button type="button"  data-dismiss="modal" class="btn btn-secondary custom_btn"><?= lang('cancel'); ?></button>
		<?php if($order['order_type'] !=5): ?>
			<a href="<?= base_url("profile/reorder/{$order['uid']}");?>"  class="btn btn-primary custom_btn"><i class="fa fa-repeat"></i> <?= lang('order_again'); ?></a>
		<?php endif;?>
	</div>
</div>

<?php endforeach; ?>