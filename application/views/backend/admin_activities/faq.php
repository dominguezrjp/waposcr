<div class="row">
	<div class="col-md-5">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('faq'))?lang('faq'):"faq";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/home/add_faq') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="heading"><?= !empty(lang('title'))?lang('title'):"title";?></label>
					        <input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"package / pricing";?>" value="<?= !empty($data['title'])?html_escape($data['title']):set_value('title'); ?>">
					        <span class="error"><?= form_error('title'); ?></span>
					    </div>

					    <div class="form-group col-md-12">
					      	<label for="price"><?= !empty(lang('details'))?lang('details'):"details";?></label>
					        <textarea name="details" id="" class="form-control textarea" cols="30" rows="10"><?= !empty($data['details'])?$data['details']:set_value('details'); ?></textarea>
					        <span class="error"><?= form_error('details'); ?></span>
					    </div>

					   
					</div>
				    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?$data['id']:0 ?>">
				</div><!-- /.box-body -->
				<div class="box-footer">
					<?php if(isset($data['id']) && $data['id'] !=0){ ?>
						<div class="pull-left">
			          		<a href="<?= base_url('admin/home/faq'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
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
			<h3 class="box-title"><?= !empty(lang('faq_list'))?lang('faq_list'):"Faq List";?></h3>
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
								<th><?= !empty(lang('title'))?lang('title'):"title";?></th>
								<th><?= !empty(lang('details'))?lang('details'):"details";?></th>
								<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
								<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; foreach ($faq as $row): ?>
							<tr>
								<td><?= $i;?></td>
								<td><?= html_escape($row['title']);?></td>
								<td><?= character_limiter($row['details'],80);?></td>
								<td>
									<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="faq" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
								</td>
								<td><a href="<?= base_url('admin/home/edit_faq/'.html_escape($row['id'])); ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>
									<a href="<?= base_url('admin/home/item_delete/'.html_escape($row['id']).'/faq'); ?>" class="btn btn-danger btn-sm  action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"  ></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>
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


