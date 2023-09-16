<div class="row">
	<div class="col-md-7">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('staff_list'))?lang('staff_list'):"Staff List";?> &nbsp; &nbsp; <a href="<?= base_url('admin/restaurant/staff/') ;?>" class="btn btn-info info-light btn-flat"><i class="fa fa-plus"></i> &nbsp;<?= !empty(lang('add_new'))?lang('add_new'):"Add New Table";?> </a></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="upcoming_events">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= !empty(lang('sl'))?lang('sl'):"Sl";?></th>
									<th><?= !empty(lang('name'))?lang('name'):"name";?></th>
									<th><?= !empty(lang('email'))?lang('email'):"email";?></th>
									<th><?= !empty(lang('permission'))?lang('permission'):"permission";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($staff_list as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td><?= html_escape($row['name']); ?></td>
										<td><?= html_escape($row['email']); ?></td>
										<td>
											<table class="table table-bordered">
												<tr>
													<th><?= !empty(lang('sl'))?lang('sl'):"Sl";?></th>
													<th><?= !empty(lang('name'))?lang('name'):"name";?></th>
												</tr>
												<?php foreach ($row['permission'] as $key => $value): ?>
													<tr>
														<td><?= $key+1 ;?></td>
														<td><?= $value['title'] ;?></td>
													</tr>
												<?php endforeach ?>
											</table>
										</td>
										<td>


											<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="staff_list" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1? (!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
										</td>
										<td>
											<a href="javascript:;" title="Reset Password" data-toggle="tooltip" data-placement="top" class="btn btn-flat btn-warning btn-sm staff_reset_password" data-id="<?= $row['id'];?>"> <i class="fa fa-lock"></i> </a>

											<a href="<?= base_url('admin/restaurant/edit_staff/'.html_escape($row['id'])); ?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>

										<a href="<?= base_url('delete-item/'.html_escape($row['id']).'/staff_list'); ?>" class=" action_btn btn btn-danger btn-sm" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>

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
		<div class="col-md-5">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('permission_list'))?lang('permission_list'):"Permission List";?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<form action="<?= base_url('admin/restaurant/add_permission_list') ?>" method="post" class="skill_form" >
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<div class="box-body">
						<div class="upcoming_events">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width=""><?= !empty(lang('sl'))?lang('sl'):"Sl";?></th>
											<th width=""><?= !empty(lang('title'))?lang('title'):"title";?></th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1; foreach ($permission_list as $row): ?>
											<tr>
												<td><?= $i;?></td>
												<td><input type="text" class="form-control" name="title[]" value="<?= html_escape($row['title']); ?>" readonly disabled></td>
												
												
												<input type="hidden" name="id[]" value="<?= isset($row['id']) && $row['id'] !=0?$row['id']:0 ?>">
											</tr>
										<?php $i++; endforeach ?>
									</tbody>
								</table>
							</div>
						</div>	
					</div><!-- /.box-body -->
					
				</form>
			</div>
		</div>
</div>