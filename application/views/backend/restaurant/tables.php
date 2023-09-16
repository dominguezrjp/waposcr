<div class="row">
	<?php include APPPATH.'views/backend/common/inc/leftsidebar.php'; ?>
	<?php if(isset($is_create) && $is_create == false): ?>
		<div class="col-md-5">
			<div class="card">
				<div class="card-header">
						<h4><?= lang('table_list'); ?> &nbsp; &nbsp; <?php if($this->admin_m->count_table('table_areas') >0): ?> <a href="<?= base_url('admin/restaurant/create_table/'.$shop_id) ;?>" class="btn btn-info info-light btn-flat"><i class="fa fa-plus"></i> &nbsp;<?= !empty(lang('add_new_table'))?lang('add_new_table'):"Add New Table";?> </a> <?php else: ?><span class="text-danger">*<?= lang('add_area_first'); ?></span><?php endif;?></h4>
					</div>
				<div class="card-body">
					<div class="row p-15">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
										<th><?= lang('name'); ?></th>
										<th><?= lang('size'); ?></th>
										<th><?= lang('area'); ?></th>
										<th><?= lang('status'); ?></th>
										<th><?= lang('action'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; foreach ($table_list as $row): ?>
										<tr>
											<td><?= $i;?></td>
											<td><?= html_escape($row['name']); ?></td>
											<td><?= html_escape($row['size']); ?></td>
											<td><?= html_escape(single($row['area_id'],'table_areas')->area_name); ?></td>
											<td><a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="table_list" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a></td>

											<td>
												
											<div class="btn-group">
												<a href="javascript:;" class="dropdown-btn dropdown-toggle btn btn-danger btn-sm btn-flat" data-toggle="dropdown" aria-expanded="false">
													<span class="drop_text"><?= lang('action'); ?> </span> <span class="caret"></span>
												</a>

												<ul class="dropdown-menu dropdown-ul" role="menu">
													<li class="cl-info-soft"><a href="<?= base_url('admin/restaurant/edit_tables/'.html_escape($row['id']).'/'.$shop_id); ?>" ><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a></li>
													<li class="cl-danger-soft"><a href="<?= base_url('delete-item/'.html_escape($row['id']).'/table_list'); ?>" class=" action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a></li>

												</ul>
											</div><!-- button group -->

										</td>
										</tr>
									<?php $i++; endforeach ?>
								</tbody>
							</table>
						</div>
					</div><!-- row -->
						
				</div><!-- card-body -->
			</div><!-- card -->
		</div><!-- col-9 -->
	<?php endif;?>
	<?php if(isset($is_create) && $is_create==TRUE): ?>
		<form class="email_setting_form" action="<?= base_url('admin/restaurant/add_tables/'.$shop_id) ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
			<div class="col-md-5">
				<div class="card">
					<div class="card-header d-flex space-between">
						<h4><?= lang('add_new_table'); ?></h4>
						<a href="<?= base_url('admin/restaurant/tables/'.$shop_id); ?>"><i class="fa fa-close text-danger"></i></a>
					</div>
					<div class="card-body">
						<div class="row p-15">
							<div class="row">
								<div class="form-group col-md-12">
									<label for="title"><?= !empty(lang('name'))?lang('name'):" Name";?> *</label>
									<input type="text" name="name" id="name" class="form-control" placeholder="<?= !empty(lang('name'))?lang('name'):"Name";?>" value="<?= !empty($data['name'])?html_escape($data['name']):set_value('name'); ?>">
								</div>

								<div class="form-group col-md-12">
									<label for="title"><?= !empty(lang('size'))?lang('size'):"size";?></label>
									<input type="text" name="size" class="form-control" value="<?= !empty($data['size'])?html_escape($data['size']):0; ?>">
								</div>
								<div class="form-group col-md-12">
									<label for="title"><?= !empty(lang('area'))?lang('area'):"area";?></label>
									<select name="area_id" class="form-control">
										<option value=""><?= lang('select_area'); ?></option>
										<?php foreach ($table_areas as $key => $area): ?>
											<option value="<?= $area['id'];?>" <?= isset($data['area_id']) && $data['area_id']==$area['id']?"selected":"" ;?>><?= $area['area_name']; ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
						</div><!-- row -->
							
					</div><!-- card-body -->
					<div class="card-footer">
						<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
						<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
					</div>
				</div><!-- card -->
			</div><!-- col-9 -->
		</form>
	<?php endif;?>
	<div class="col-md-4">
		<div class="row">
			<?php if(isset($is_create) && $is_create == false): ?>
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header with-border">
									<h3 class="box-title"> <?= lang('add_new_area'); ?></h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
									</div>
								</div>
								<!-- /.box-header -->
								<form action="<?= base_url('admin/restaurant/add_area/'.$shop_id) ?>" method="post" class="skill_form" enctype= "multipart/form-data">
									<div class="box-body">

										<!-- csrf token -->
										<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

										<div class="row">
											<div class="form-group col-md-12">
												<label><?= lang('area_name'); ?></label>
												<input type="text" name="area_name" class="form-control">
											</div>
										</div>
										
										
									</div><!-- /.box-body -->
									<div class="box-footer">
										<div class="pull-right">
											<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
										</div>
									</div>
								</form>
							</div>
						</div><!-- col_12 -->
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header with-border">
									<h3 class="box-title"> <?= lang('areas'); ?></h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
									</div>
								</div>
								<!-- /.box-header -->

								<!-- csrf token -->
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

								<div class="row">
									<div class="col-md-12">
										<table class="table">
											<thead>
												<th><?= lang('sl'); ?></th>
												<th><?= lang('name'); ?></th>
												<th><?= lang('action'); ?></th>
											</thead>
											<tbody>
												<?php foreach ($table_areas as $key => $area): ?>
													<tr>
														<td><?= $key+1;?></td>
														<td><?= $area['area_name'];?></td>
														<td>
															<a href="#areaEditModal_<?= $area['id'];?>" data-toggle="modal" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>

															<a href="<?= base_url('delete-item/'.html_escape($area['id']).'/table_areas'); ?>" class="btn btn-danger btn-sm action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>
														</td>
													</tr>
												<?php endforeach ?>
											</tbody>
										</table>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div>
					</div><!-- col_12 -->
				<?php endif;?>	
		</div>
	</div>		
</div>






<?php foreach ($table_areas as $key => $value): ?>
<!-- Modal -->
<div id="areaEditModal_<?= $value['id'];?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<form action="<?= base_url('admin/restaurant/add_area/'.$shop_id) ?>" method="post" class="skill_form" enctype= "multipart/form-data">
    		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
    		<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
    			<h4 class="modal-title"><?= lang('area');?></h4>
    		</div>
    		<div class="modal-body">
    			<div class="">
    				<label for=""><?= lang('area_name'); ?></label>
    				<input type="text" name="area_name" class="form-control" value="<?= $value['area_name'];?>">
    			</div>
    		</div>
    		<div class="modal-footer">
    			<div class="pull-left">
    				<button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close'); ?></button>
    			</div>
    			<div class="">
    				<input type="hidden" name="id" value="<?= $value['id'] ;?>">
    				<button type="submit" class="btn btn-primary"><?= lang('submit'); ?></button>
    			</div>
    		</div>
    	</form>
    </div>

  </div>
</div>

	
<?php endforeach ?>