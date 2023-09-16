
<?php 

// echo '10 ='.number_format('10', 2, ',', '.').'<br>';
// echo '100 = '.number_format('100', 2, ',', '.').'<br>';
// echo '1000 = '.number_format('1000', 2, ',', '.').'<br>';
// echo '10000 = '.number_format('10000', 2, ',', '.').'<br>';
 ?>





<div class="row">
	<div class="col-lg-9">
		 <div class="card">
		 	<div class="card-header"> 
		 		<h5 class="m-0 mr-5 card-title">Order List </h5> 
		 		<div class="card-tools"><a href="<?= base_url("admin/pos");?>" class="btn btn-secondary"><i class="fa fa-plus"></i> New Order</a></div>
		 	</div>
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
		