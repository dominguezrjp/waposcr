<div class="col-lg-10">           
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">All Products</h5>
			<div class="card-tools">
				<a href="<?= base_url("admin/products/create_products");?>" class="btn btn-secondary text-right btn-sm addBtn"><i
					class="fa fa-plus"></i> Add New Products</a>
			</div>
		</div>
		<div class="card-body">
			<div class="card-content">
				<div class="table-responsive">
					<table class="table table-bordered" id="myTable">
						<thead>
							<tr>
								<th>Sl</th>
								<th>UID</th>
								<th>Product Name</th>
								<th>Price</th>
								<th>Stock status</th>
								<th>Barcode</th>
								<th>Action</th>
							</tr>
						</thead>
							<tbody>
								<?php foreach ($product_list as $key => $row): ?>
								<tr id="hide_<?= $row['id'];?>">
									<td><?= $key + 1;?></td>
									<td><?= $row['uid'] ?></td>
									<td><?= $row['title'] ?> <b><?= $row['category_name'] ?></b></td>
									<td><?= $row['price'] ?></td>
									<td><label class="label default-light-soft-active">Available: <?= $row['in_stock']-$row['sold_qty'];?></label></td>
									<td class="img-small"><img src="<?= base_url($row['barcode']);?>" alt=""></td>
									<td class="text-center">
										<div class="dropdown show custom-dropdown">
										  <a class="bg-default dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    <i class="fas fa-ellipsis-h"></i>
										  </a>
										  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										    <a class="dropdown-item" href="<?= base_url("/admin/products/edit_products/{$row['id']}?ln={$row['language']}") ?>"><i class="fa fa-edit"></i> Edit</a>

										    <a href="<?= base_url("/delete-item/{$row['id']}") ?>"
												data-id="<?= $row['id']; ?>" data-msg="Want to delete?"
												class="ajaxDelete dropdown-item"><i class="fa fa-trash"></i>
											Delete</a>
										    
										  </div>
										</div>
									
										</td>
									</tr>
								<?php endforeach ?>

							</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>