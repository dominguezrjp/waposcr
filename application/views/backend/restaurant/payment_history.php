<div id="list_load">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('payment_history'))?lang('payment_history'):"Payment History";?> &nbsp; &nbsp;

					</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="upcoming_events">
						<div class="table-responsive">
							<table class="table table-bordered table-striped data_tables">
								<thead>
									<tr>
										<th width=""><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
										<th width=""><?= !empty(lang('order_number'))?lang('order_number'):"order number";?></th>
										<th width=""><?= !empty(lang('txn_id'))?lang('txn_id'):"txn_id";?></th>
										<th width=""><?= !empty(lang('amount'))?lang('amount'):"amount";?></th>
										<th width=""><?= !empty(lang('payment_status'))?lang('payment_status'):"Estado de pago";?></th>
										<th width=""><?= !empty(lang('payment_by'))?lang('payment_by'):"Payment by";?></th>
										<th width=""><?= !empty(lang('payment_date'))?lang('payment_date'):"Fecha de pago";?></th>
										
										
										
									</tr>
								</thead>
								<tbody>
									
									<?php foreach ($payment_history as $key => $row): ?>
										<tr>
											<td><?= $key+1; ;?></td>
											<td>#<?= html_escape($row['order_id']);?> </td>
											<td><?= html_escape($row['txn_id']);?> </td>
											<td><b><?= $row['price'];?> <?=  $row['currency_code'];?></b> </td>
											<td>
												<?php $statusType = ['succeeded','completed','authorized','captured','successful','approved','success']; ?>
												<?php if(in_array(strtolower($row['status']),$statusType)): ?>
													<label class="label success-light-active"><i class="icofont-check"></i> <?= html_escape($row['status']);?></label>
												<?php else: ?>
													<label class="label danger-light-active"><?= html_escape($row['status']);?></label>
												<?php endif; ?>
											</td>
											<td><?= html_escape(lang($row['payment_by']));?> </td>
											<td><?= full_time($row['created_at']);?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>	
				</div><!-- /.box-body -->
			</div>
		</div>
	</div>
</div>
	<div class="view_orderList">
		
	</div>


<script>
	$('.data_table').DataTable({
        'lengthChange': true,
    });
</script>