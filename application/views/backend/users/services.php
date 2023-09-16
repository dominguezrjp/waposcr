<div class="row">
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('services'))?lang('services'):"services";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/auth/add_services') ?>" method="post"  enctype= "multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
					      	<label><?= !empty(lang('title'))?lang('title'):"title";?></label>
					        <input type="text" name="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"Title";?>" value="<?= !empty($data['title'])?html_escape($data['title']):""; ?>">
					    </div>
					    <div class="col-md-12">
							<label><?= !empty(lang('details'))?lang('details'):"details";?></label>
							<textarea name="details" id="" cols="5" rows="5" class="form-control" placeholder="<?= !empty(lang('details'))?lang('details'):"details";?>"><?= !empty($data['details'])?html_escape($data['details']):set_value('details'); ?></textarea>
							<span class="error"><?= form_error('details'); ?></span>
						</div>
					</div>
					<div class="row mt-15">
						<div class="form-group col-md-12">
							<label><?= !empty(lang('icon'))?lang('icon'):"icon";?></label>
							<input type="text" name="icon" id="icon" class="form-control" placeholder="Font awsome icon" value='<?= !empty($data['icon'])?$data['icon']:set_value('icon'); ?>'>
					        		<span class="error"><?= form_error('icon'); ?></span>
						</div>
					</div>
				    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
				</div><!-- /.box-body -->
				<div class="box-footer">
					<?php if(isset($data['id']) && $data['id'] !=0){ ?>
						<div class="pull-left">
			          		<a href="<?= base_url('admin/auth/services'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
			          	</div>
		          <?php } ?>
		          	<div class="pull-right">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-8">
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
									<th><?= !empty(lang('icon'))?lang('icon'):"icon";?></th>
									<th ><?= !empty(lang('details'))?lang('details'):"details";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($services as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td><?= html_escape($row['title']); ?></td>
										<td><?= !empty($row['icon'])?$row['icon']:''; ?></td>
										<td><?= character_limiter($row['details'],50); ?></td>

										<td><a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="services" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a></td>

										<td>

											<a href="<?= base_url('admin/auth/edit_services/'.html_escape($row['id'])); ?>" class="btn btn-info"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>

										<a href="<?= base_url('delete-item/'.html_escape($row['id']).'/services'); ?>" class="btn btn-danger action_btn"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>
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
