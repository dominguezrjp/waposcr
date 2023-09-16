
	<div class="dropdown show custom-dropdown">
		<a class="bg-default dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-ellipsis-h"></i>
		</a>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
			<?php if($row['is_due']==1): ?>
				<a class="dropdown-item text-success action_btn" href="<?= base_url("/admin/vendor/change_status/{$row['id']}") ?>"><i class="fa fa-check"></i> Mark as Paid</a>
			<?php else: ?>
				<a class="dropdown-item text-success" href="javascript:;"><i class="fa fa-check"></i> Paid</a>
			<?php endif ?>
			<a class="dropdown-item text-danger" href="<?= base_url("/admin/products/edit_products/{$row['id']}") ?>"><i class="fa fa-trash"></i> Delete</a>
		</div>
	</div>
