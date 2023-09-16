<div class="col-md-9">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title"><?= !empty(lang('permission_list'))?lang('permission_list'):"Permission List";?> <a href="#permissionModal" data-toggle="modal" class="btn btn-secondary">Add new</a></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
			</div>
		</div>
		<!-- /.box-header -->
		<form action="<?= base_url('admin/adminstaff/add_permission_list') ?>" method="post" class="skill_form" >
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
			<div class="box-body">
				<div class="upcoming_events">
					<div class="table-responsive">
						<div class="col-md-6">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th width=""><?= !empty(lang('sl'))?lang('sl'):"Sl";?></th>
										<th width=""><?= !empty(lang('title'))?lang('title'):"title";?></th>
										<th width=""><?= !empty(lang('slug'))?lang('slug'):"slug";?></th>
										<th width=""><?= !empty(lang('type'))?lang('type'):"type";?></th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; foreach ($permission_list as $row): ?>
									<?php if($row['role']=='user'): ?>
										<tr>
											<td><?= $i;?></td>
											<td><input type="text" class="form-control" name="title[]" value="<?= html_escape($row['title']); ?>"></td>
											<td>
												<?= $row['slug'];?>
											</td>
											<td class="text-center"><p class="label <?= $row['role']=='user'?'label-default':'label-success';?>"><?= $row['role'];?></p></td>


											<input type="hidden" name="id[]" value="<?= isset($row['id']) && $row['id'] !=0?$row['id']:0 ?>">
										</tr>
									<?php endif ?>
									<?php $i++; endforeach ?>
								</tbody>
							</table>
						</div>
						<div class="col-md-6">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th width=""><?= !empty(lang('sl'))?lang('sl'):"Sl";?></th>
										<th width=""><?= !empty(lang('title'))?lang('title'):"title";?></th>
										<th width=""><?= !empty(lang('slug'))?lang('slug'):"slug";?></th>
										<th width=""><?= !empty(lang('type'))?lang('type'):"type";?></th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; foreach ($permission_list as $row): ?>
									<?php if($row['role']=='admin_staff'): ?>
										<tr>
											<td><?= $i;?></td>
											<td><input type="text" class="form-control" name="title[]" value="<?= html_escape($row['title']); ?>"></td>
											<td>
												<?= $row['slug'];?>
											</td>
											<td class="text-center"><p class="label <?= $row['role']=='user'?'label-default':'label-success';?>"><?= str_replace('_', " ", $row['role']) ;?></p></td>


											<input type="hidden" name="id[]" value="<?= isset($row['id']) && $row['id'] !=0?$row['id']:0 ?>">
										</tr>
									<?php endif ?>
									<?php $i++; endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>	
			</div><!-- /.box-body -->
			<div class="box-footer">
				<div class="pull-right">
					<button type="submit" name="register" class="btn btn-primary btn-block btn-flat c_btn"><i class="fa fa-save"></i> &nbsp; <?= !empty(lang('save_change'))?lang('save_change'):"save change";?></button>
				</div>
			</div>
		</form>
	</div>
</div>


<div class="modal fade" id="permissionModal">
	<div class="modal-dialog">
		<form action="<?= base_url("admin/adminstaff/add_new_permission_list");?>" method="post">
			<?= csrf();?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">New Permission</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" class="form-control">
					</div>

					<div class="form-group">
						<label>Slug</label>
						<input type="text" name="slug" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submt" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</form>
	</div>
</div>