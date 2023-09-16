<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('allergens'))?lang('allergens'):"Allergens";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/menu/add_allergen') ?>" method="post" enctype= "multipart/form-data">
				<div class="box-body" >

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="title"><?= !empty(lang('name'))?lang('name'):"name";?></label>
					        <input type="text" name="name" id="title" class="form-control" placeholder="<?= !empty(lang('name'))?lang('name'):"name";?>" value="<?= isset($data['name'])?html_escape($data['name']):set_value('name'); ?>">
					    </div>

					    <div class="form-group col-md-12">
							<div class="serviceImg" style="display:<?= !empty($data['thumb'])?'block':'none'; ?>;">
								<img src="<?= !empty($data['thumb'])?base_url($data['thumb']):''; ?>" class="service_icon_preview" alt="">
							</div>
							<div class="">
								<label for=""><?= !empty(lang('image'))?lang('image'):"image";?></label>
								<input type="file" name="file[]" class="service_img" data-height="500" data-width="500">
							    <span class="img_error"></span>
							</div>
						</div>
					   
					</div>

				    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id']!=0?$data['id']:0; ?>">
				</div><!-- /.box-body -->
				<div class="box-footer" >
					<div class="pull-left">
						<?php if(isset($data['id']) && $data['id']!=0): ?>
		          			<a href="<?= base_url('admin/menu/allergen'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
		          		<?php endif;?>
		          	</div>
		          	<div class="pull-right">
		          		<button type="submit" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('allergens'))?lang('allergens'):"Allergens";?></h3>
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
									<th><?= !empty(lang('name'))?lang('name'):"name";?></th>
									<th><?= !empty(lang('image'))?lang('image'):"image";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($allergens as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td><?= $row['name'] ?></td>
										<td><img src="<?= base_url($row['images']) ?>" alt="" style="height: 50px;width: 80px;"></td>
										<td>
											<?php if(is_access('change-status')==1): ?>
												<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="allergens" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
											<?php endif; ?>
										</td>
										<td>
											<?php if(is_access('update')==1): ?>
												<a href="<?= base_url('admin/menu/edit_allergen/'.html_escape($row['id'])); ?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>
											<?php endif; ?>
											<?php if(is_access('delete')==1): ?>
												<a href="<?= base_url('delete-item/'.html_escape($row['id']).'/allergens'); ?>" class="btn btn-danger btn-sm action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"Want to Delete?";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>
											<?php endif;?>

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
