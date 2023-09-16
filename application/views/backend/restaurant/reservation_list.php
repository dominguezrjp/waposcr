<div id="list_load">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					
					<?php if(isset($page_type) && $page_type=="All"): ?>
						<h3 class="box-title"><?= !empty(lang('all_reservation_list'))?lang('all_reservation_list'):"All Reservation list";?> &nbsp; &nbsp;
					 	<a href="<?= base_url('admin/restaurant/todays_reservation') ;?>" class="btn btn-success success-light btn-flat"><i class="fa fa-arrow-right"></i> &nbsp;<?= !empty(lang('todays_reservations'))?lang('todays_reservations'):"Todays Reservation";?> </a>
					 <?php else: ?>
					 	<h3 class="box-title"><?= !empty(lang('todays_reservations'))?lang('todays_reservations'):"Todays Reservation list";?> &nbsp; &nbsp;
					 	
					 	<a href="<?= base_url('admin/restaurant/reservation_list') ;?>" class="btn btn-success success-light btn-flat"><i class="fa fa-list"></i> &nbsp;<?= !empty(lang('all_reservation_list'))?lang('all_reservation_list'):"All Reservations";?> </a>
					<?php endif;?>

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
										<th width=""><?= !empty(lang('sl'))?lang('sl'):"sl";?></th></th>
										<th width=""><?= !empty(lang('order_id'))?lang('order_id'):"order id";?></th></th>
										<th width=""><?= !empty(lang('name'))?lang('name'):"name";?></th>
										<th width=""><?= !empty(lang('phone'))?lang('phone'):"phone";?></th>
										<th width=""><?= !empty(lang('order_type'))?lang('order_type'):"order type";?></th>
										<th width=""><?= !empty(lang('overview'))?lang('overview'):"Overview";?></th>
										<th width=""><?= !empty(lang('comments'))?lang('comments'):"Comments";?></th>
										<th width=""><?= !empty(lang('status'))?lang('status'):"Status";?></th>
										<th width=""><?= !empty(lang('action'))?lang('action'):"action";?></th>
										
										
									</tr>
								</thead>
								<tbody>
									
								<?php foreach ($order_list as $key => $row): ?>
									<tr>
										<td><?= $key+1; ;?></td>
										<td> <?= html_escape($row['uid']) ;?>
											<?php if($row['status']==0): ?>
												<label class="label danger-light-active ml-10"><?= get_time_ago($row['created_at']) ;?></label> 
											<?php endif;?></td>	
										<td><?= html_escape($row['name']);?></td>
										<td><?= html_escape($row['phone']);?></td>
										<td>
											<label class="label default-light-active"><?= order_type($row['order_type']);?> </label> &nbsp;
											<div class="mt-5">
												<label class="label default-light"><?= full_time($row['created_at'],restaurant()->id);?> </label> &nbsp;
											</div>
											
										</td>
										<td>
											<label class="label default-light-active" data-toggle="tooltip" title="Reservation Date"><?= full_time($row['reservation_date'],restaurant()->id) ;?></label> &nbsp;
											<label class="label default-light-active" data-toggle="tooltip" title="Total Person Number"><?= lang('total_person'); ?>: <?= $row['total_person'] ;?></label>
											<?php if($row['is_table']==1): ?>
												<label class="label default-light-active"><?= lang('table_reservation'); ?></label>
											<?php endif;?>

											<label class="label info-light-active" data-toggle="tooltip"><?= single_select_by_id($row['reservation_type'],'reservation_types')['name'] ;?></label>
										</td>

										<td><?= html_escape($row['comments']) ;?></td>
										<td>
											<?php if($row['status']==0): ?>
												<label class="label danger-light" data-toggle="tooltip" title="Pending order"> <?= lang('pending'); ?> <i class="fa fa-spinner"></i></label>
												</div>
											<?php elseif($row['status']==1): ?>
												<label class="label info-light" data-toggle="tooltip" title="Accept By Shop"><i class="fa fa-check"></i> <?= lang('accept'); ?></label>
											<?php elseif($row['status']==2): ?>
												<label class="label success-light-active" data-toggle="tooltip" title="Completed Order"><i class="fa fa-check-square-o"></i> <?= lang('completed'); ?></label>
											<?php elseif($row['status']==3): ?>
												<label class="label danger-light-active" data-toggle="tooltip" title="Order Cancled"><i class="fa fa-ban"></i> <?= lang('canceled'); ?></label>
											<?php endif;?>
										</td>
										<td>
											<div class="btn-group">
												<a href="javascript:;" class="dropdown-btn dropdown-toggle btn btn-danger btn-sm btn-flat" data-toggle="dropdown" aria-expanded="false">
													<span class="drop_text"><?= lang('action'); ?> </span> <span class="caret"></span>
												</a>
							                 
							                  <ul class="dropdown-menu dropdown-ul" role="menu">
							                  	<?php if($row['status'] == 0): ?>
							                    	<li class="cl-info-soft"><a href="<?= base_url('admin/restaurant/reservation_order_status/'.$row['uid']).'/1' ;?>" ><i class="fa fa-check"></i> <?= lang('accept'); ?></a></li>
							                	<?php endif;?>
							                	<?php if($row['status'] == 0 || $row['status'] == 1): ?>
								                    <li class="cl-success-soft"><a href="<?= base_url('admin/restaurant/reservation_order_status/'.$row['uid']).'/2' ;?>" ><i class="icofont-checked"></i> <?= lang('completed'); ?></a></li>
								                <?php endif;?>

								                <?php if($row['status'] == 0): ?>
								                	<?php if(is_access('order-cancel')==1): ?>
									                    <li class="cl-warning-soft" ><a href="<?= base_url('admin/restaurant/reservation_order_status/'.$row['uid']).'/3' ;?>" ><i class="fa fa-close"></i> <?= lang('cancel'); ?></a></li>
									                <?php endif; ?>
								                <?php endif;?>

								                <?php if($row['status'] == 3 || $row['status'] == 2): ?>
									                	<?php if(is_access('delete')==1): ?>
									                    <li class="cl-danger-soft"><a href="<?= base_url('admin/menu/delete/'.$row['id']) ;?>" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>" class="action_btn"><i class="fa fa-trash"></i> <?= lang('delete'); ?></a></li>
									                <?php endif; ?>
								                <?php endif;?>
							                  </ul>
							                </div><!-- button group -->
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


<script>
	$('.data_table').DataTable({
        'lengthChange': true,
    });
</script>