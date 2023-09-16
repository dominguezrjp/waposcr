<div class="row cDomain">
	<div class="col-md-10">
		<div class="card">
		<?php if($this->check_domain['is_folder']==0): ?>
			<?php if($this->settings['is_custom_domain']==1): ?>
				<div class="card-header space-between"> <h4 class="m-0 mr-5"><?= lang('domain_list');?> </h4> <a href="#commentsModal" data-toggle="modal" class="btn btn-secondary"><?= lang('set_comments');?></a></div>
				<div class="card-body ">
					<div class="card-content">
						<div class="table-responsive m-h-250">
							<table class="table table-striped">
								<thead>
									<tr>
										<td>#</td>
										<td><?= lang('request_id');?></td>
										<td><?= lang('shop_name');?></td>
										<td><?= lang('request_name');?></td>
										<td><?= lang('current_name');?></td>
										<td><?= lang('url');?></td>
										<td><?= lang('request_date');?></td>
										<td><?= lang('approved_date');?></td>
										<td><?= lang('status');?></td>
										<td><?= lang('action');?></td>
									</tr>
								</thead>
								<tbody>
									<?php if(sizeof($domain_list) > 0): ?>
										<?php foreach ($domain_list as $key => $row): ?>
											<tr>
												<td><?= $key+1;?>
													
												</td>
												<td><?= $row['request_id'];?>
													<div class="mt-5">
														<?php if($row['is_subdomain']==1): ?>
															<label class="label bg-primary-soft">subdomain</label>
														<?php endif ?>
														<?php if($row['is_domain']==1): ?>
															<label class="label bg-success-soft">domain</label>
														<?php endif ?>
													</div>
												</td>
												<td><label class="label label-default"><?= restaurant($row['user_id'])->username;?></label></td>
												<td><label class="label bg-light-purple-soft" style="text-transform:lowercase;"><?= strtolower($row['request_name']);?></label></td>
												<td><label class="label bg-success-soft" style="text-transform:lowercase;"><?= $row['is_ready']==1?strtolower($row['request_name']):"---";?></label></td>
												<td>
													<?php $check_domain = check_domain($this->settings['site_url']); ?>
													<?php if($check_domain['is_domain']==1 || $check_domain['is_subdomain']==1): ?>
														<?= $row['url'];?>
													<?php else: ?>
														----
													<?php endif ?>
												</td>

												<td>
													<?= full_time($row['request_date']);?>
												</td>
												<td>
													<?php if($row['is_ready']==1): ?>
														<?= full_time($row['approved_date']);?>
													<?php else: ?>
														-------
													<?php endif ?>
												</td>
												<td>
													<div class="dropdown customDropdown">
														<button class="btn  <?= $row['status']==2?"bg-success-soft":($row['status']==1?"btn-info":"btn-secondary");?> dropdown-toggle" type="button" data-toggle="dropdown">
														<?php if($row['status']==0): ?>
															<?= lang('pending')?>
														<?php elseif ($row['status']==1): ?>
															<?= lang('approved')?>
														<?php elseif($row['is_ready']==1): ?>
															<?= lang('serve')?>
														<?php endif ?>
														<span class="caret"></span></button>
														<ul class="dropdown-menu ">
															<li class="dropdown-header"><?= lang('action');?></li>
															<?php if($row['status']==0): ?>
																<li><a href="javascript:;" onclick="openModal(<?= $row['id'];?>,1)"><?= lang('approved')?></a></li>
															<?php endif; ?>
															<?php if($row['status'] ==1):?>
																<li><a href="javascript:;" onclick="openModal(<?= $row['id'];?>,2)"><i class="fa fa-check"></i> <?= lang('serve')?></a></li>
															<?php endif; ?>

															<?php if($row['status'] ==2):?>
																<li><a href="javascript:;" onclick="openModal(<?= $row['id'];?>,1)"><?= lang('hold')?></a></li>
															<?php endif; ?>
															<?php if($row['status']==0): ?>
																<li><a href="javascript:;" onclick="openModal(<?= $row['id'];?>,3)"><?= lang('cancled')?></a></li>
															<?php endif ?>
														</ul>
													</div>
												</td>
												<td>
													<a href="<?= base_url('admin/home/item_delete/'.html_escape($row['id']).'/custom_domain_list'); ?>" class="btn btn-danger action_btn" data-msg="<?= lang('want_to_delete');?>"><i class="fa fa-trash"></i> <?= lang('delete');?></a>
												</td>
											</tr>
										<?php endforeach ?>
									<?php endif ?>

								</tbody>
							</table>
						</div>
					</div><!-- card-content -->
				</div><!-- card-body -->
			<?php else: ?>
				<div class="empty-msg text-center" style="padding: 3rem;">
					<h4>Enable sub domain feature <a href="<?= base_url("admin/dashboard/enable_custom_domain");?>" class="btn btn-success action_btn mr-5"><i class="fa fa-check"></i> Enable</a></h4>
				</div>
			<?php endif; ?>
			<?php else: ?>
				<div class="empty-msg text-center" style="padding: 3rem;">
					<h4>Sorry, this feature is not supported</h4>
					<p>You need to install the script in root folder</p>
				</div>
			<?php endif; ?>
		</div><!-- card -->
	</div>
</div>


<?php $custom_msg = isJson($settings['custom_domain_comments'])?json_decode($settings['custom_domain_comments']):''; ?>



<div class="modal fade <?= is_package;?>" id="commentsModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url("admin/dashboard/add_default_comments");?>" method="post">
				<?= csrf();?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?= lang('comments');?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label><?= lang('approved_message');?></label>
						<textarea name="approved_msg" class="form-control" cols="5" rows="5"><?= !empty($custom_msg->approved_msg)?$custom_msg->approved_msg:'';?></textarea>
					</div>

					<div class="form-group">
						<label><?= lang('canceled_message');?></label>
						<textarea name="cancled_msg" class="form-control" cols="5" rows="5"><?= !empty($custom_msg->cancled_msg)?$custom_msg->cancled_msg:'';?></textarea>
					</div>

					<div class="form-group">
						<label><?= lang('custom_domain');?></label>
						<textarea name="custom_domain_msg" class="form-control textarea" cols="5" rows="5"><?= !empty($custom_msg->custom_domain_msg)?$custom_msg->custom_domain_msg:'';?></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" value="<?= !empty($settings['id'])?$settings['id']:0;?>">
					<button type="submit" class="btn btn-primary"><?= lang('submit');?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade <?= is_package;?>" id="approveModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url("admin/dashboard/change_domain_status");?>" method="post">
				<?= csrf();?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?= lang('comments');?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group approved_msg dis_none">
						<label><?= lang('approved_msg');?></label>
						<textarea name="approved_msg" class="form-control" cols="30" rows="10"><?= !empty($custom_msg->approved_msg)?$custom_msg->approved_msg:'';?></textarea>
					</div>

					<div class="form-group cancled_msg dis_none">
						<label><?= lang('cancled_msg');?></label>
						<textarea name="cancled_msg" class="form-control" cols="30" rows="10"><?= !empty($custom_msg->cancled_msg)?$custom_msg->cancled_msg:'';?></textarea>
					</div>

					<div class="form-group serve_msg dis_none">
						<label><?= lang('serve_msg');?></label>
						<div class="serveMsg">
							<h4>Please Make sure propagation is over</h4>
							<p class="mt-5"> it should take N seconds, where N – is TTL for this A record; you can edit it manually and reduce the number to speed up the process), and then the wildcard subdomain will work correctly</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="status" value="0">
					<input type="hidden" name="id" value="0">
					<button type="submit" class="btn btn-primary"><?= lang('submit');?></button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>
	function openModal(ID,status){
		$('#approveModal').modal('show');
		$('[name="status"]').val(status);
		$('[name="id"]').val(ID);
		if(status==1){
			$('.approved_msg').not($('.cancled_msg, .serve_msg').hide()).show();
		}else if(status==2){
			$('.serve_msg').not($('.approved_msg, .cancled_msg').hide()).show();
		}else if(status==3){
			$('.cancled_msg').not($('.approved_msg, .serve_msg').hide()).show();
		}else{
			$('.approved_msg, .cancled_msg, .serve_msg').hide();
		}
	}
</script>