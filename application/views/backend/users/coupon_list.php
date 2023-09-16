<div class="row">
	<div class="col-lg-8">
		<div class="card">
			<div class="card-header space-between">
				<h4 class="box-title"><?= lang('coupon_list'); ?> </h4>
				<a href="<?= base_url('admin/coupon/add_coupon')?>" class="btn btn-secondary btn-sm ml-20"><i class="fa fa-plus"></i> <?= lang('add_new'); ?></a>
				
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th><?= lang('title'); ?></th>
							<th><?= lang('coupon_code'); ?></th>
							<th><?= lang('limit'); ?></th>
							<th><?= lang('used'); ?></th>
							<th><?= lang('discount'); ?></th>
							<th><?= lang('start_date'); ?></th>
							<th><?= lang('end_date'); ?></th>
							<th><?= lang('status'); ?></th>
							<th><?= lang('action'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($couponList as $key => $row): ?>
							<tr>
							   <td><?= $key+1;?></td>
							   <td><?= $row['title'];?>
							   <td><?= $row['coupon_code'];?>
							   		<div class="">
							   			<?php if(today() > $row['end_date']): ?>
							   			<label class="label label-warning"><i class="icofont-ban"></i> <?= lang('expired');?></label>
							   		<?php else: ?>
							   			<label class="label label-success"><i class="icofont-check-alt"></i> <?= lang('active');?></label>
							   		<?php endif;?>
							   		</div>
							   </td>
							   <td><?= $row['total_limit'];?></td>
							   <td><label class="label label-primary"><?= $row['total_used'];?></label></td>
							   <td><label class="label label-default"><?= $row['discount'];?> %</label></td>
							   <td><?= full_date($row['start_date'],restaurant($row['user_id'])->id);?></td>
							   <td><?= full_date($row['end_date'],restaurant($row['user_id'])->id);?></td>
							   <td>
							   		
							   		<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="coupon_list" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
							   </td>
							   <td>
							   	<a href="<?= base_url("admin/coupon/edit/{$row['id']}") ;?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
							   	<a href="<?= base_url('admin/dashboard/item_delete/'.html_escape($row['id']).'/coupon_list'); ?>" class="btn btn-danger btn-sm action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):'Want to delete?' ;?>"><i class="fa fa-trash"></i> </a>
							   </td>
						    </tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>