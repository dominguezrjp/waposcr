<div class="row">
	<div class="col-md-5">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('services'))?lang('services'):"services";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/home/add_services') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="title"><?= !empty(lang('title'))?lang('title'):"title";?></label>
					        <input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"title";?>" value="<?= !empty($data['title'])?html_escape($data['title']):set_value('title'); ?>">
					    </div>
					    <div class="col-md-12">
							<label><?= !empty(lang('details'))?lang('details'):"details";?></label>
							<textarea name="details" id="" cols="5" rows="5" class="form-control textarea"><?= !empty($data['details'])?html_escape($data['details']):set_value('details'); ?></textarea>
						</div>
					</div>
					<div class="row mt-15">
						<div class="form-group col-md-12">
							<div class="serviceImg adminService" style="display:<?= isset($data['images']) && !empty($data['images'])?'block':'none'; ?>;">
								<img src="<?= !empty($data['images'])?base_url($data['images']):''; ?>" class="service_icon_preview" alt="">
							</div>
							 <input type="file" name="file[]" class="service_img" data-height="0" data-width="0">
							   <span class="img_error"></span>
						</div>
					</div>
				    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?$data['id']:0 ?>">
				</div><!-- /.box-body -->
				<div class="box-footer">
					<?php if(isset($data['id']) && $data['id'] !=0){ ?>
						<div class="pull-left">
			          		<a href="<?= base_url('admin/home/services'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
			          	</div>
		          <?php } ?>
		          	<div class="pull-right">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-7">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('services'))?lang('services'):"services";?></h3>
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
									<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
									<th><?= !empty(lang('title'))?lang('title'):"title";?></th>
									<th><?= !empty(lang('image'))?lang('image'):"image";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($services as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td><?= character_limiter(html_escape($row['title']),30); ?></td>
										<td><div class="site_imges">
											<img src="<?= !empty($row['thumb'])?base_url(html_escape($row['thumb'])):''; ?>" alt="">
										</div></td>
										<td>
											<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="site_services" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
										</td>
										<td><a href="<?= base_url('admin/home/edit_services/'.html_escape($row['id'])); ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>
										<a href="<?= base_url('admin/home/item_delete/'.html_escape($row['id']).'/site_services'); ?>" class="btn btn-danger btn-sm action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>
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
