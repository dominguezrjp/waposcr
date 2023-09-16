<div class="row">
	<div class="col-md-11 col-sm-11">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('payment_transaction'))?lang('payment_transaction'):"Payment Transaction";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body" >
				<div class="upcoming_events">
					<div class="table-responsive">
						<table id="example1" class="table table-bordered">
							<thead>
								<tr>
									<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
									<th><?= !empty(lang('name'))?lang('name'):"name";?></th>
									<th><?= !empty(lang('package_name'))?lang('package_name'):"Package Name";?></th>
									<th><?= !empty(lang('price'))?lang('price'):"price";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									<th><?= !empty(lang('txn_id'))?lang('txn_id'):"Txn id";?></th>
									<th><?= !empty(lang('payment_by'))?lang('payment_by'):"Payment by";?></th>
									<th><?= !empty(lang('date'))?lang('date'):"Payment Date";?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($transactions as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td>
											<?php if(isset($row['user_id'])): ?>
												<?php $user = get_user_info_by_id($row['user_id']);?>
												<?= isset($user['username']) && !empty($user['username'])?$user['username']:"<span class='error'>".lang('not_found')."</span>";?>
											<?php endif; ?>

											</td>

										<td><?= $row['account_type']!=0?html_escape(get_package_info_by_id($row['account_type']))['package_name']:''; ?></td>
										<td class="uppercase"><?= html_escape($row['price']); ?> <?= html_escape($row['currency_code']); ?></td>
										<td><?= html_escape($row['status']); ?></td>
										<td><?= html_escape($row['txn_id']); ?></td>
										<td>
											<label class='label <?= $row['payment_type']==0?'bg-primary-soft':($row['payment_type']==1?"label-info":($row['payment_type']==2?'label-warning':'label-success')) ;?>'>
												<?=  get_payment_type(html_escape($row['payment_type']));?>
													
												</label>
											</td>
										<td><?= full_time(html_escape($row['created_at'])); ?></td>
										
									</tr>
								<?php $i++; endforeach ?>
							</tbody>
						</table>
					</div>
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>
</div>

