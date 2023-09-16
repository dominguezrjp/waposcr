<div class="row">
	<div class="col-md-5">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('team'))?lang('team'):"team";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/home/add_team') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body" >

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="name"><?= !empty(lang('name'))?lang('name'):"name";?></label>
					        <input type="text" name="name" id="name" class="form-control" placeholder="<?= !empty(lang('name'))?lang('name'):"name";?> " value="<?= !empty($data['name'])?html_escape($data['name']):set_value('name'); ?>">
					    </div>

					    <div class="form-group col-md-12">
					      	<label for="name"><?= !empty(lang('designation'))?lang('designation'):"designation";?></label>
					        <input type="text" name="designation" id="designation" class="form-control" placeholder="<?= !empty(lang('designation'))?lang('designation'):"designation";?> " value="<?= !empty($data['designation'])?html_escape($data['designation']):set_value('designation'); ?>">
					    </div>
					</div>
					<div class="row">
						<div class="col-md-6 col-lg-6 col-sm-6">
							<label class="defaultImg">
								<?php if(isset($data['id']) && !empty($data['id'])): ?>
									<a href="<?= base_url('admin/home/delete_img/'.$data['id'].'/site_team');?>" class="deleteImg <?= isset($data['thumb']) && !empty($data['thumb'])?"":"opacity_0"?>" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-close"></i></a>
								<?php endif;?>
								
								<img src="<?= isset($data['thumb']) && !empty($data['thumb'])?base_url($data['thumb']):""?>" alt=""  class="imgPreview <?= isset($data['thumb']) && !empty($data['thumb'])?"":"opacity_0"?>">

							    <div class="imgPreviewDiv <?= isset($data['thumb']) && !empty($data['thumb'])?"opacity_0":""?>">
									<i class="fa fa-upload"></i>
									<h4><?= lang('upload_image'); ?></h4>
									<p class="fw_normal mt-3"><?= lang('max'); ?>: 500 x 500 px</p>
								</div>

								<input type="file" name="file[]" class="imgFile opacity_0" data-height="500" data-width="500">
							</label>
							<span class="img_error"></span>
						</div>
					</div>
				    <input type="hidden" name="id" value="<?= isset($data['id']) && html_escape($data['id']) !=0?html_escape($data['id']):0 ?>">
				</div><!-- /.box-body -->
				<div class="box-footer" >
					<?php if(isset($data['id']) && html_escape($data['id']) !=0){ ?>
						<div class="pull-left">
			          		<a href="<?= base_url('admin/home/team'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
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
				<h3 class="box-title"><?= !empty(lang('team'))?lang('team'):"team";?></h3>
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
									<th><?= !empty(lang('designation'))?lang('designation'):"designation";?></th>
									<th><?= !empty(lang('image'))?lang('image'):"image";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($team as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td><?= html_escape($row['name']); ?></td>
										<td><?= html_escape($row['designation']); ?></td>
										<td><div class="serviceImgs"><img src="<?= base_url($row['thumb']) ;?>" /></div></td>
										<td>
											<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="site_team" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp;  <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
										</td>
										<td>
											<a href="<?= base_url('admin/home/edit_team/'.html_escape($row['id'])); ?>" class="btn btn-info"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>
											<a href="<?= base_url('admin/home/item_delete/'.html_escape($row['id']).'/site_team'); ?>" class="btn btn-danger action_btn"  data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>
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
