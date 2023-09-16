<div class="row">
	<div class="col-md-4">

		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('languages'))?lang('languages'):"languages";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/home/add_languages') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<div class="row">
						<div class="form-group col-md-12">
					      	<label ><?= !empty(lang('lang_name'))?lang('lang_name'):"Language name";?></label>
					        <input type="text" name="lang_name" class="form-control" placeholder="<?= !empty(lang('lang_name'))?lang('lang_name'):"Language name";?>" value="<?= !empty($data['lang_name'])?html_escape($data['lang_name']):set_value('lang_name'); ?>">
					    </div>

					    <div class="form-group col-md-12">
					      	<label for="type_name"><?= !empty(lang('language_slug'))?lang('language_slug'):"Language Slug";?> <i class="fa fa-info-circle" title="Language name (slug) must be in english alphabet and can't change"></i></label>
					        <input type="text" name="slug" class="form-control" placeholder="<?= !empty(lang('slug'))?lang('slug'):"Language Slug";?>" <?= isset($data['slug']) && !empty($data['slug'])?"readonly":'';?> value="<?= !empty($data['slug'])?html_escape($data['slug']):set_value('slug'); ?>">
					    </div>
					    <div class="form-group col-md-12">
					      	<label for="price"><?= !empty(lang('direction'))?lang('direction'):"Direction";?></label>
					        <div class="">

					        	<label class="custom-radio"><input type="radio" class="" name="direction" value="ltr" checked="" <?= isset($data['direction']) && $data['direction']=="ltr"?"checked":'';?>> <?= !empty(lang('ltr'))?lang('ltr'):"LTR";?> (<?= !empty(lang('left_to_right'))?lang('left_to_right'):"Left to right";?>)</label> &nbsp;&nbsp;&nbsp;&nbsp;

					        	<label class="custom-radio"><input type="radio" class="" name="direction" value="rtl" <?= isset($data['direction']) && $data['direction']=="rtl"?"checked":'';?>> <?= !empty(lang('rtl'))?lang('rtl'):"RTL";?> (<?= !empty(lang('right_to_left'))?lang('right_to_left'):"Right to left";?>)</label>
					        </div>
					    </div>
					</div>
				    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id']!=0?$data['id']:0 ?>">
				</div><!-- /.box-body -->
				<div class="box-footer">
					<?php if(isset($data['id']) && $data['id'] !=0){ ?>
						<div class="pull-left">
			          		<a href="<?= base_url('admin/home/languages'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
			          	</div>
		          <?php } ?>
		          	<div class="pull-right">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('languages'))?lang('languages'):"languages";?></h3>
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
									<th>#</th>
									<th><?= !empty(lang('name'))?lang('name'):"name";?></th>
									<th><?= !empty(lang('slug'))?lang('slug'):"slug";?></th>
									<th><?= !empty(lang('direction'))?lang('direction'):"direction";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
								
								<?php $i=1; foreach ($languages as $row): ?>
										<tr>
											<td><?= $i;?></td>
											<td><?= html_escape($row['lang_name']); ?></td>
											<td><?= html_escape($row['slug']); ?></td>
											<td><?= html_escape($row['direction']); ?></td>
											<td>
												<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="languages" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
											</td>
											<td>
												<a href="<?= base_url('admin/home/edit_languages/'.html_escape($row['id'])); ?>" class="btn btn-info"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>

												<a href="<?= base_url('admin/home/delete_lang/'.html_escape($row['id'])); ?>" class="btn btn-danger action_btn"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"delete";?></a>
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
