<?php if(sizeof($staff_list) > 0): ?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4><?= lang('staff_activities');?></h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table  table-condensed table-striped data_tables">
						<thead>
							<tr>
								<th>#</th>
								<th><?= lang('staff_name');?></th>
								<th><?= lang('username');?></th>
								<th><?= lang('email');?></th>
								<th><?= lang('package_name');?></th>
								<th><?= lang('package_type');?></th>
								<th><?= lang('price');?></th>
								<th><?= lang('active_date');?></th>
								<th><?= lang('status');?></th>
								<th><?= lang('action');?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($staff_list as $key => $row): ?>

								<tr>
									<td><?= $key+1;?></td>
									<td><?= $row['staff_name'];?></td>
									<td><?= $row['username'];?></td>
									<td><?= $row['email'];?></td>
									<td><?= $row['package_name'];?></td>
									<td><?= !empty($row['package_type'])?lang($row['package_type']):$row['package_type'];?></td>
									<td><?= admin_currency_position($row['price']);?></td>
									<td><?= full_time($row['package_active_date']);?></td>
									<td>
										<?php if($row['is_new']==1): ?>
											<label class="label bg-success-soft"><?= lang('newly_added');?></label>
										<?php elseif ($row['is_renewal']==1): ?>
											<label class="label bg-light-purple-soft"><?= lang('renewal');?></label>
										<?php endif; ?>
									</td>
									<td>
										<a href="<?= base_url("admin/adminstaff/activities/{$row['staff_id']}");?>" class="btn btn-flat btn-primary btn-sm"> <i class="fa fa-eye"></i> </a>
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
<?php endif ?>