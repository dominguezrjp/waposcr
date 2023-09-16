<div class="row">
	<div class="col-md-5 <?= isset($data['id']) && $data['id'] !=0?'':'hidden';?>">
		<div class="box box-primary ">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('features'))?lang('features'):"features";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/dashboard/add_features') ?>" method="post" class="skill_form" >
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
							<label for="title"><?= !empty(lang('features'))?lang('features'):"features";?> <?= !empty(lang('name'))?lang('name'):"name";?>*</label>

							<input type="text" name="features" id="title" class="form-control" placeholder="features " value="<?= !empty($data['features'])?html_escape($data['features']):set_value('features'); ?>">



						</div>

						<div class="form-group col-md-12 hidden">
							<label for="title"><?= !empty(lang('slug'))?lang('slug'):"slug";?> <?= !empty(lang('name'))?lang('name'):"name";?>*</label>



							<input type="text" name="slug" id="title" class="form-control" placeholder="slug " value="<?= !empty($data['slug'])?html_escape($data['slug']):set_value('slug'); ?>">

						</div>


					</div>

					<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?$data['id']:0 ?>">
				</div><!-- /.box-body -->
				<div class="box-footer">
					<?php if(isset($data['id']) && $data['id'] !=0){ ?>
						<div class="pull-left">
							<a href="<?= base_url('admin/dashboard/features'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"Cancel";?></a>
						</div>
					<?php } ?>
					<div class="pull-right">
						<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"Submit";?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-7">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('features_list'))?lang('features_list'):"Features List";?></h3>
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
									<th width=""><?= !empty(lang('sl'))?lang('sl'):"Sl";?></th>
									<th width=""><?= !empty(lang('features'))?lang('features'):"Features";?></th>
									<th width=""><?= !empty(lang('slug'))?lang('slug'):"Slug";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($features as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td><?= html_escape($row['features']); ?></td>
										<td><?= html_escape($row['slug']); ?></td>
										<td>
											<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="features" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1? (!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
										</td>
										<td><a href="<?= base_url('admin/dashboard/edit_features/'.html_escape($row['id'])); ?>" class="btn btn-info"> <i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a></td>
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