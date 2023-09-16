<div id="list_load">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-info">
				<div class="box-header with-border">
					
					<h3 class="box-title"><?= lang('call_waiter_list');?>
					</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body bg_gray">
					<div class="upcoming_events">
						<div class="table-responsive">
							<table class="table table-bordered table-condensed table-striped" id="">
								<thead>
									<tr>
										<th width="">#</th>
										<th width=""><?= !empty(lang('table_no'))?lang('table_no'):"table_no";?></th>
										<th width=""><?= !empty(lang('status'))?lang('status'):"Status";?></th>
										
										
									</tr>
								</thead>
								<tbody>
									
								<?php foreach ($order_list as $key => $row): ?>
									<tr>
										<td><?= $key+1; ;?> <?php if($row['status']==0): ?>
												<label class="label danger-light-active ml-10"><?= get_time_ago($row['created_at']) ;?></label> 
											<?php endif;?></td>
										
										<td>
											<label class="label default-light-active"><?= $row['table_no'];?> </label> &nbsp;
											
										</td>
										
										
										<td>
											<?php if($row['is_ring']==1): ?>
												<label class="label danger-light" data-toggle="tooltip" title="Pending order"> <?= lang('pending'); ?> <i class="fa fa-spinner"></i></label>
												</div>
											<?php elseif($row['is_ring']==0): ?>
												<label class="label info-light" data-toggle="tooltip" title="Accept By Shop"><i class="fa fa-check"></i> <?= lang('accept'); ?></label>
											<?php endif;?>
										</td>
										
									</tr>
								<?php endforeach ?>
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

