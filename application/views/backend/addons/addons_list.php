<div class="row">
	<div class="col-md-10">
		<div class="card">
			<div class="card-header flex_between"> <h4 class="m-0 mr-5"> <?= lang('add_ons');?></h4> <a href="#addNewModal" data-toggle="modal" class="btn btn-secondary"><i class="fa fa-plus"></i> <?= lang('add_new');?></a></div>
			<div class="card-body">
				<div class="card-content">
					<?php  $this->load->view('backend/inc/success_msg');?>
					<div class="table-responsive">
						<table class="table data_table table-bordered table-stripped">
							<thead>
								<tr>
									<th>#</th>
									<th>Addons Name</th>
									<th>Purchase Code</th>
									<th>License Name</th>
									<th>Purchase Date</th>
									<th>Active Date</th>
									<th width="15%">Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($addonsList as $key => $row):?>	
									<tr>
										<td><?= $key+1;?></td>
										<td><?= $row['script_name'].'-'.$row['item_id'];?></td>
										<td><?= $row['purchase_code'];?></td>
										<td><?= $row['license_name'];?></td>
										<td><?= full_time($row['purchase_date']);?></td>
										<td><?= full_time($row['active_date']);?></td>
										<td>

											<?php if($row['is_install']==1): ?>

												<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="addons_list" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>


												<label class="label label-success"><i class="fa fa-check"></i> <?= lang('installed');?></label>
											<?php else:?>
												<label class="label label-danger "><i class="fa fa-close"></i> <?= lang('not_installed');?></label>
											<?php endif; ?>

										</td>

											


										<td>
											<?php if($row['is_install']==1): ?>
												<a href="<?= base_url("admin/addons/uninstall/{$row['id']}");?>" class="btn btn-danger btn-sm action_btn"><i class="icofont-hand-drag1"></i> <?= lang('uninstall');?></a>
											<?php else:?>
												<a href="#addNewModal" data-toggle="modal" class="btn btn-secondary btn-sm"><i class="fa fa-check"></i> <?= lang('installed');?></a>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach;?>	
							</tbody>
						</table>
					</div>
				</div><!-- card-content -->
			</div><!-- card-body -->
			<div class="card-footer text-right"> 

			</div>
		</div><!-- card -->
	</div>
</div>


<div class="modal fade" id="addNewModal">
	<div class="modal-dialog">
		<form action="<?= base_url("admin/addons/install_addons");?>" method="post" class="custom-fields">
			<?= csrf();?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?= lang('add_new');?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Addons Purchase Code</label>
						<input type="text" name="purchase_code" class="form-control">
					</div>
					<div class="form-group">
						<label>Script Purchase Code</label>
						<input type="text" name="script_purchase_code" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary"><?= lang('submit');?></button>
				</div>
			</div>
		</form>
	</div>
</div>