<div class="row">
	<div class="col-md-11 col-sm-11">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('offline_payments'))?lang('offline_payments'):"Offline Payment";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body" >
				<div class="upcoming_events">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
									<th><?= !empty(lang('username'))?lang('username'):"username";?></th>
									<th><?= !empty(lang('email'))?lang('email'):"email";?></th>
									<th><?= !empty(lang('package'))?lang('package'):"package";?></th>
									<th><?= !empty(lang('price'))?lang('price'):"price";?></th>
									<th><?= !empty(lang('txn_id'))?lang('txn_id'):"Txn id";?></th>
									<th><?= !empty(lang('request_date'))?lang('request_date'):"Request Date";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($offline as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td><?= html_escape($row['username']); ?></td>
										<td><?= html_escape($row['email']); ?></td>
										<td><?= html_escape($row['package']); ?></td>
										<td class="uppercase"><?= html_escape($row['price']); ?> <?= !empty($row['currency_code'])?$row['currency_code']:get_currency('currency_code'); ?></td>
										<td><?= html_escape($row['txn_id']); ?></td>
										<td><?= full_time(html_escape($row['created_at'])); ?></td>
										<td><?= $row['status']==0?'<label class="label label-warning">'.lang('pending').'</label>':'<label class="label label-success">'.lang('paid').'</label>'; ?></td>

										<td>
											<?php if($row['status']==0): ?>
											<a href="<?= base_url('admin/dashboard/accept_payment_form_offline/'.html_escape($row['username'])."/0"); ?>" class="btn btn-info btn-sm action_btn" data-msg="<?= lang('verified_offline_payment_msg'); ?>" > <?= lang('approve'); ?>  &nbsp; <i class="fa fa-arrow-right"></i></a>
											<?php else: ?>
												<a href="javascript:;" class="btn btn-success btn-sm" onclick="return confirm('Your request already approved')"><i class="fa fa-check"></i> <?= lang('approved'); ?></a>
											<?php endif ?>
										</td>
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

