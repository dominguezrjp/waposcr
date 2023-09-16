<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title"><?= lang('invoice');?></h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped data_tables">
						<thead>
							<tr>
								<th>#</th>
								<th><?= lang('package_name');?></th>
								<th><?= lang('price');?></th>
								<th><?= lang('billing_cycle');?></th>
								<th><?= lang('last_billing');?></th>
								<th><?= lang('status');?></th>
								<th><?= lang('expire_date');?></th>
								<th><?= lang('invoice');?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($transaction_list as $key => $row): ?>
								<tr>
									<td><?= $key+1;?></td>
									<td><?= $row->package_name;?></td>
									<td><?= $row->price;?></td>
									<td><?= $row->package_type;?></td>
									<td><?= full_date($row->active_date);?></td>
									<td>
										<?php if($row->is_expired==0): ?>
											<?php if($row->is_payment==0): ?>
												<label class="label bg-default-soft"><?= lang('pending');?></label>
											<?php else: ?>
												<?php if(($row->active_date <= $row->expire_date) && $row->is_running==1): ?>
													<label class="label bg-success-soft"><i class="fa fa-check"></i> <?= lang('running');?></label>
												<?php else: ?>
													<label class="label bg-danger-soft"> <i class="fa fa-ban"></i> <?= lang('expired');?></label>
												<?php endif; ?>
											<?php endif; ?>
										<?php else: ?>
											<label class="label bg-danger-soft"> <i class="fa fa-ban"></i> <?= lang('expired');?></label>
										<?php endif; ?>
									</td>
									<td><?= !empty($row->expire_date)?full_date($row->expire_date):'';?> <?php if(!empty($row->expire_date) && $row->is_running==1): ?> <span class="label bg-default-soft ml-10"> <?=  day_left(d_time(),$row->expire_date)['day_left'];?> </span> <?php endif; ?></td>
									<td>
										<a href="<?= base_url("subscription-invoice/".md5($row->id));?>" class="btn btn-secondary btn-sm" target="blank"><i class="fa fa-file-pdf"></i></a>
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
