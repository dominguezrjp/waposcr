<div class="row">
	<div class="col-lg-11">
		 <div class="card">
		 	<div class="card-header"> <h5 class="m-0 mr-5">Order List </h5></div>
		 	<div class="card-body">
		 		<div class="card-content">
		 			<div class="table-responsive">
		 				<table class="table table-striped text-center" id="myTable">
		 					<thead>
		 						<tr>
		 							<th>#</th>
		 							<th>Order ID</th>
		 							<th>Customer Name</th>
		 							<th>Item List</th>
		 							<th>Total Price</th>
		 							<th>Status</th>
		 							<th>Date</th>
		 							<th>Action</th>
		 						</tr>
		 					</thead>
		 					<tbody>
		 						<?php foreach ($order_list as $key=> $row): ?>
		 							<tr>
		 								<td><?= $key+1;?></td>
		 								<td><?= $row['uid'];?></td>
		 								<td><?= $row['customer_name'];?></td>
		 								<td class="text-left">
		 									<div class="itemList">
		 										<ul>
		 											<?php foreach ($row['item_list'] as $item): ?>

		 												<li><span><?= $item['qty'];?> x (<?= $item['product_uid'] .'-'. $item['old_price'];?>) <?= $item['title'];?><b> <?= $item['category_name'];?></b> = </span><b><?= currency_position($item['sub_total'],$row['vendor_id']);?></b></li>

		 											<?php endforeach ?>
		 										</ul>
		 										<?php if($row['is_due']==1 &&!empty($row['due_price'])): ?>
			 										<label class="label bg-gray">Due: <?= currency_position($row['due_price'],$row['vendor_id']);?></label>
			 									<?php endif ?>
		 									</div>
		 								</td>
		 								<td> <?= currency_position($row['total_price'],$row['vendor_id']);?> </td>
		 								<td>
		 									<?php if($row['is_due']==1): ?>
		 										<label class="label bg-danger-soft"> <i class="fa fa-check"></i> Unpaid</label>
		 									<?php else: ?>
			 									<label class="label bg-success"> <i class="fa fa-check"></i> Paid</label>
			 								<?php endif ?>
		 								</td>
		 								<td>
		 									<?= full_time($row['created_at']);?>
		 								</td>
		 								<td class="text-center">
		 									<?php include 'inc/order_btn.php'; ?>

		 								</td>
		 							</tr>
		 						<?php endforeach ?>
		 						
		 					</tbody>
		 				</table>
		 			</div>
		 		</div><!-- card-content -->
		 	</div><!-- card-body -->
		</div><!-- card -->
	</div>
</div>		 
		