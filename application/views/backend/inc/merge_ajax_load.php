<?php if(!empty(restaurant()->id)): ?>
	<?php $merge_orders = $this->admin_m->get_merged_order_list(); ?>
	<?php foreach ($merge_orders as $singleMerge): ?>
		<li class="mergeLi_<?= $singleMerge['id'];?>">
			<div class="newMerge">
				<div class="merge_header">
					<h4> <i class="fa fa-bell"></i> <?= lang('a_new_order_is_merge');?></h4>
					<a href="javascript:;" data-id="<?= $singleMerge['id'];?>"  class="closeMergeNotification"><i class="fa fa-close"></i></a>
				</div>
				<a href="<?= base_url("admin/order-details/{$singleMerge['uid']}");?>" class="merge_body" target="_blank">
					<h4><b><?= $singleMerge['uid'];?></b> <?= lang('order_id_is_merged');?></h4>
					<p><?= lang('merge_id');?> : <b><?= $singleMerge['merge_id']['merge_id'];?></b></p>
				</a>
			</div>
		</li>
	<?php endforeach; ?>
<?php endif ?>