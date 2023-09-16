<div class="row">
	<?php if(isset($action) && $action=='add_new'): ?>
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?= lang('create_notification');?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<form action="<?= base_url('admin/notify/create_notification') ?>" method="post" enctype= "multipart/form-data">
					<div class="box-body" >

						<!-- csrf token -->
						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

						<div class="row">
							<div class="form-group col-md-12">
						      	<label for="title"><?= lang('title');?></label>
						        <input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"title";?>" value="<?= isset($data['title'])?html_escape($data['title']):set_value('title'); ?>">
						    </div>

						    <div class="form-group col-md-12">
						      	<label for="title"><?= lang('details');?></label>
						        <textarea name="details" class="textarea" class="form-control" cols="5" rows="5"><?= isset($data['details'])?html_escape($data['details']):""; ?></textarea>
						    </div>
						    
						</div>

					    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id']!=0?$data['id']:0; ?>">
					</div><!-- /.box-body -->
					<div class="box-footer" >
						<div class="pull-left">
							<a href="<?= base_url('admin/notify/'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
			          	</div>
			          	<div class="pull-right">
			          		<button type="submit" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
			          	</div>
					</div>
				</form>
			</div>
		</div>
	<?php endif ?>



<?php if(isset($action) && $action=='Notify'): ?>
	<div class="col-md-5">
		<form action="<?= base_url('admin/notify/send') ?>" method="post" enctype= "multipart/form-data">
			<!-- csrf token -->
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
			<div class="card">
				<div class="card-header"> <h3 class="card-title"><?= lang('send_notifications');?></h3></div>
				<div class="card-body">
					<div class="card-content">
						<div class="form-group col-md-12">
							<label><?= lang('select_notification');?></label>
							<select name="notification_id" id="notify_id" class="form-control" readonly>
								<option value=""><?= lang('select_notification');?></option>
								<?php foreach ($notification_list as $key => $notify): ?>
									<option value="<?= $notify['id'];?>" <?= isset($data['id']) && $data['id']==$notify['id']?"selected":"";?> ><?= $notify['title'];?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group col-md-12">
							<label for="title"><?= lang('restaurants');?> <label href="javascript:;" class="pl-5 label success-light pointer custom-checkbox"><input type="checkbox" class="checkAll" data-lang="<?= lang('checked_all');?>"> <?= lang('select_all');?></label> </label>
							<select name="restaurant_id[]" class="form-control select2" id="checkedItem" multiple >
								<?php foreach ($restaurant_list as $key => $restaurant): ?>
									<?php if(isset($selected_restaurant) && !in_array($restaurant['id'],$selected_restaurant)): ?>
									<option value="<?= $restaurant['id'];?>"> <?= $restaurant['username'];?></option>
								<?php endif ?>
								<?php endforeach ?>
							</select>
						</div>
					</div><!-- card-content -->
				</div><!-- card-body -->
				<div class="card-footer text-right"> 
					<a href="<?= base_url("admin/notify");?>" class="btn btn-default pull-left"><?= lang('cancel');?></a>
					<button class="btn btn-secondary" type="submit"><?= lang('send');?></button>
				</div>
			</div><!-- card -->
		</form>
	</div>
<?php endif ?>
<?php if(isset($action) && $action==FALSE): ?>
	<div class=" col-md-8">
		<div class="card">
			<div class="card-header space-between"> 
				<h3 class="card-title"> <?= lang('notification_list');?> </h3>
				<a href="<?= base_url("admin/notify/add_new");?>" class="btn btn-secondary"><i class="fa fa-plus"></i> <?= lang('add_new');?></a>
			</div>
			<div class="card-body">
				<div class="card-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
								<th><?= !empty(lang('title'))?lang('title'):"title";?></th>
								<th><?= !empty(lang('details'))?lang('details'):"details";?></th>
								<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
								<th width="30%"><?= !empty(lang('action'))?lang('action'):"action";?></th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; foreach ($notification_list as $row): ?>
							<tr>
								<td><?= $i;?></td>
								<td><?= $row['title'] ?></td>
								<td><?= character_limiter($row['details'],150);?></td>
								<td>
									<?php if(is_access('change-status')==1): ?>
										<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="admin_notification_list" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
									<?php endif; ?>
								</td>
								<td>
									<a href="<?= base_url('admin/notify/send_notify/'.html_escape($row['id'])); ?>" class="btn btn-info btn-sm" ><i class="fa fa-send"></i></a>
									<a href="#detailsModal_<?= $row['id'];?>" data-toggle="modal" class="btn btn-primary btn-sm" ><i class="fa fa-eye"></i></a>
									<?php if(is_access('update')==1): ?>
										<a href="<?= base_url('admin/notify/edit_notification/'.html_escape($row['id'])); ?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> </a>
									<?php endif; ?>
									<?php if(is_access('delete')==1): ?>
										<a href="<?= base_url('admin/home/item_delete/'.html_escape($row['id']).'/admin_notification_list'); ?>" class="btn btn-danger btn-sm action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"Want to Delete?";?>"><i class="fa fa-trash"></i></a>
									<?php endif;?>

								</td>


							</tr>
							<?php $i++; endforeach ?>
						</tbody>
					</table>
				</div><!-- card-content -->
			</div><!-- card-body -->
		</div><!-- card -->
	</div>
<?php endif ?>

</div>

<?php foreach ($notification_list as $key => $notify): ?>
	
	<div class="modal fade" id="detailsModal_<?= $notify['id'];?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Modal title</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for=""><?= lang('title');?></label>
						<p><?= $notify['title'];?></p>
					</div>

					<div class="form-group">
						<label for=""><?= lang('details');?></label>
						<p><?= $notify['details'];?></p>
					</div>
					<hr>
					<div class="form-group">
						<label for=""><?= lang('send_notifications');?></label>
							<ul class="ul notificationUl"> 
								<?php foreach ($notify['send_notification'] as $value): ?>
								<li>
									<div class="restraurantDetails">
										<label><?= lang('name');?></label>
										<p><?= $value['username'];?></p>
									</div>
									<div class="restraurantDetails">
										<label><?= lang('send_time');?></label>
										<p><?= full_date($value['send_at']);?></p>
									</div>

									<div class="restraurantDetails">
										<label><?= lang('status');?></label>
										<?php if($value['seen_status']==1): ?>
											<div>
												<label class="label label-success"><i class="fa fa-check"></i> <?= lang('seen');?></label>
												<p><?= full_date($value['send_at']);?></p>
											</div>
										<?php else: ?>
											<div>
												<label class="label label-danger"><?= lang('pending');?></label>
											</div>
										<?php endif ?>
									</div>	
								</li>

								<?php endforeach; ?>
							</ul>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close');?></button>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>