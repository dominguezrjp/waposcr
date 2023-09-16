<?php $shop = restaurant(auth('id')) ?>


<div class="row">
	<div class="col-md-3">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= lang('new_order'); ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body kds" >
				<div class="kds">

					<?php foreach ($order_list as $key => $row): ?>
						<?php if($row['status'] ==0): ?>
							<div class="single_order new">
								<div class="order_header info-light-active">
									<h4><span><?= lang('order_id'); ?> : #<?= $row['uid'] ;?></span> <span><?= lang('table_no'); ?>: <?= single_select_by_id($row['table_no'],'table_list')['name'] ;?></span></h4>
								</div>
								<div class="dineorderDetails mt-5 text-center">
									<h4 class="mb-3"><?= lang('token_number'); ?>: <?= $row['token_number'] ;?></h4>
									<p class="fz-18"><b><?= lang('price'); ?></b> : <?= currency_position($row['total'],restaurant()->id) ;?></p>
								</div>
								
								<div class="orderBody">
									<?php foreach ($row['package_list'] as $key => $package): ?>
										<div class="singleItems">
											<h4><a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($package['id'])); ?>" target="_blank"> <i class="fa fa-eye fz-12"></i> &nbsp;<?= $package['package_name'] ;?> </a></h4>
											<div class="single_item_body">
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($package['all_items'] as $key => $item): ?>
															<li><span>1 x <?= $item['title'] ;?></span></li>
														<?php endforeach ?>

													</ul>
												</div>
											</div>
											
											
										</div>
									<?php endforeach ?>
								</div>
								<div class="orderfooter bg_white text-center">
									<?php if(restaurant()->es_time == 0): ?>
										<a href="<?= base_url('admin/restaurant/order_status/'.$row['uid']).'/1' ;?>"  data-id="<?= $row['uid'] ;?>" class="btn info-light showTimeModal" data-toggle="tooltip" title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a> 

									<?php else: ?>
										<a href="javascript:;"  data-id="<?= $row['uid'] ;?>" class="btn info-light showTimeModal" data-toggle="tooltip" title="Mark as Accept"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a> 

									<?php endif;?>
									&nbsp;

									<a href="<?= base_url('admin/restaurant/order_status/'.$row['uid']).'/2' ;?>" class="btn success-light" data-toggle="tooltip" title="Mark as Completed"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;

									<a href="<?= base_url('admin/restaurant/order_status/'.$row['uid']).'/3' ;?>" class="btn danger-light" data-toggle="tooltip" title="Mark as Cancel"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('cancel'); ?> </a> &nbsp;
								</div>

							</div>
						<?php endif;?>
					<?php endforeach ?>
					
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>


	<div class="col-md-3">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= lang('accepted'); ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body kds" >
				<div class="kds">

					<?php foreach ($order_list as $key => $row): ?>
						<?php if($row['status'] ==1): ?>
							<div class="single_order accepted">
								<div class="order_header accepted">
									<h4><span><?= lang('order_id'); ?> : #<?= $row['uid'] ;?></span> <span><?= lang('table_no'); ?>: <?= single_select_by_id($row['table_no'],'table_list')['name'] ;?></span></h4>
								</div>
								<div class="dineorderDetails mt-5 text-center">
										<h4 class="mb-3"><?= lang('token_number'); ?>: <?= $row['token_number'] ;?></h4>
										<p class="fz-18"><b><?= lang('price'); ?></b> : <?= currency_position($row['total'],restaurant()->id) ;?></p>
									</div>
								<div class="preparedTime">
									<i class="fa fa-clock"></i>
									<p class="showPTime get_time" id="show_time_<?= $row['id'] ;?>" data-time="<?= $row['estimate_time'] ;?>" data-id="<?= $row['id'];?>"></p>
								</div>
								<div class="orderBody">
									<?php foreach ($row['package_list'] as $key => $package): ?>
										<div class="singleItems">
											<h4><a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($package['id'])); ?>" target="_blank"><?= $package['package_name'] ;?> </a></h4>
											<div class="single_item_body">
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($package['all_items'] as $key => $item): ?>
															<li><span>1 x <?= $item['title'] ;?></span></li>
														<?php endforeach ?>

													</ul>
												</div>
											</div>
											
											
										</div>
									<?php endforeach ?>
								</div>
								<div class="orderfooter bg_white text-center">

									<a href="javascript:;" class="btn info-light-active" data-toggle="tooltip" title="Mark as Accept"><i class="fa fa-check"></i> &nbsp; <?= lang('accept'); ?> </a> &nbsp;

									<a href="<?= base_url('admin/restaurant/order_status/'.$row['uid']).'/2' ;?>" class="btn success-light" data-toggle="tooltip" title="Mark as Completed"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;
								</div>

							</div>
						<?php endif;?>
					<?php endforeach ?>
					
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>

	<div class="col-md-3">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= lang('completed'); ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body kds" >
				<div class="kds">

					<?php foreach ($order_list as $key => $row): ?>
						<?php if($row['status'] ==2): ?>
							<div class="single_order completed">
								<div class="order_header success-light-active">
									<h4><span><?= lang('order_id'); ?> : #<?= $row['uid'] ;?></span> <span><?= lang('table_no'); ?>: <?= single_select_by_id($row['table_no'],'table_list')['name'] ;?></span></h4>
								</div>
								<div class="dineorderDetails mt-5 text-center">
									<h4 class="mb-3"><?= lang('token_number'); ?>: <?= $row['token_number'] ;?></h4>
									<p class="fz-18"><b><?= lang('price'); ?></b> : <?= currency_position($row['total'],restaurant()->id) ;?></p>
								</div>
								<div class="orderBody">
									<?php foreach ($row['package_list'] as $key => $package): ?>
										<div class="singleItems">
											<h4><a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($package['id'])); ?>" target="_blank"><?= $package['package_name'] ;?></a></h4>
											<div class="single_item_body">
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($package['all_items'] as $key => $item): ?>
															<li><span>1 x <?= $item['title'] ;?></span></li>
														<?php endforeach ?>

													</ul>
												</div>
											</div>
											
											
										</div>
									<?php endforeach ?>
								</div>
								<div class="orderfooter bg_white text-center">
									<a href="javascript:;" class="btn info-light-active" data-toggle="tooltip" title="Accepted"><i class="fa fa-check"></i> &nbsp; <?= lang('accepted'); ?> </a> &nbsp;

									<a href="javascript:;" class="btn success-light-active" data-toggle="tooltip" title="Completed"><i class="fa fa-check"></i> &nbsp; <?= lang('completed'); ?> </a> &nbsp;
								</div>

							</div>
						<?php endif;?>
					<?php endforeach ?>
					
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>

	<div class="col-md-3">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= lang('cancled'); ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body kds" >
				<div class="kds">

					<?php foreach ($order_list as $key => $row): ?>
						<?php if($row['status'] ==3): ?>
							<div class="single_order new">
								<div class="order_header danger-light-active">
									<h4><span><?= lang('order_id'); ?> : #<?= $row['uid'] ;?></span> <span><?= lang('table_no'); ?>: <?= single_select_by_id($row['table_no'],'table_list')['name'] ;?></span></h4>
								</div>
								<div class="dineorderDetails mt-5 text-center">
									<h4 class="mb-3"><?= lang('token_number'); ?>: <?= $row['token_number'] ;?></h4>
									<p class="fz-18"><b><?= lang('price'); ?></b> : <?= currency_position($row['total'],restaurant()->id) ;?></p>
								</div>
								<div class="orderBody">
									<?php foreach ($row['package_list'] as $key => $package): ?>
										<div class="singleItems">
											<h4><a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($package['id'])); ?>" target="_blank"><?= $package['package_name'] ;?></a></h4>
											<div class="single_item_body">
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($package['all_items'] as $key => $item): ?>
															<li><span>1 x <?= $item['title'] ;?></span></li>
														<?php endforeach ?>

													</ul>
												</div>
											</div>
											
											
										</div>
									<?php endforeach ?>
								</div>
							</div>
						<?php endif;?>
					<?php endforeach ?>
					
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>


</div>

	
</div>





<!-- Modal -->
<div id="SetTimeModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?= lang('set_prepared_time'); ?></h4>
			</div>
			<form action="<?= base_url('admin/restaurant/order_status/1/1') ;?>" method="post" autocomplete="off">
				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

				<div class="modal-body">
					<div class="setTime">
						<div class="row">
							<div class="col-md-5 pr-5">
								<input type="number" name="es_time" class="form-control" placeholder="<?= lang('set_time'); ?>" required value="<?= !empty(restaurant()->es_time)? restaurant()->es_time: 0 ;?>">
						
							</div>
							<div class="col-md-7 pl-5">
								<select name="time_slot" class="form-control" id="" required>
									<option value=""><?= lang('select'); ?></option>
									<option value="minutes" <?= restaurant()->time_slot=="minutes"?"selected":"" ;?>><?= lang('minutes'); ?></option>
									<option value="hours" <?=  restaurant()->time_slot=="hours"?"selected":"";?>><?= lang('hours'); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="uid" class="uid" value="">
					<div class="text-right">
						<button type="submit" class="btn btn-info"><?= lang('submit'); ?></button>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>
