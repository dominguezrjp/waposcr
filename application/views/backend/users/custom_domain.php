<div class="row">
		<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	<div class="col-md-8">
		<form action="<?= base_url("admin/auth/request_custom_domain");?>" method="post" class="ajaxForm">
			<?= csrf();?>
			<div class="card">
				<div class="card-header"> <h5 class="m-0 mr-5"><?= lang('custom_domain');?> </h5></div>
				<div class="card-body">
					<div class="card-content">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<td>#</td>
										<td><?= lang('request_id');?></td>
										<td><?= lang('request_name');?></td>
										<td><?= lang('current_name');?></td>
										<td><?= lang('url');?></td>
										<td><?= lang('status');?></td>
									</tr>
								</thead>
								<tbody>
									<?php if(sizeof($request_list) > 0): ?>
									<?php foreach ($request_list as $key => $row): ?>
										<tr>
											<td><?= $key+1;?></td>
											<td><?= $row['request_id'];?></td>
											<td><?= !empty($row['request_name'])?$row['request_name']:"---";?></td>
											<td><?= $row['is_ready']==1?$row['request_name']:"---";?></td>
											<td>
												<?php $check_domain = @check_domain($row['url']); ?>
												<?php if(($check_domain['is_domain']==1 || $check_domain['is_subdomain']==1) && $row['is_ready']==1): ?>
													<?= 'https://'.$row['url'];?>
												<?php else: ?>
													---
												<?php endif; ?>
													
											</td>
											<td>
												<?php if($row['status']==0): ?>
													<label class="label label-primary"><?= lang('pending');?></label>
												<?php elseif($row['status']==1): ?>
													<label class="label label-primary"><?= lang('approved');?></label>
												<?php elseif($row['status']==2 && $row['is_ready']==1): ?>
													<label class="label label-success"><?= lang('running');?></label>
												<?php endif; ?>
											</td>
										</tr>
										<?php if(!empty($row['comments'])): ?>
											<tr>
												<td colspan="4">
													<p class="mt-10 mb-5"><strong><?= lang('message');?></strong></p>
													<?= $row['comments'];?>
												</td>
											</tr>
										<?php endif; ?>
									<?php endforeach ?>
									<?php else: ?>
										<tr>
											<td>1</td>
											<td>----</td>
											<td><?= auth('username');?></td>
											<td>----</td>
											<td><?= base_url(auth('username'));?></td>
											<td>----</td>
										</tr>
									<?php endif ?>
									
								</tbody>
							</table>
						</div>
					</div><!-- card-content -->
				</div><!-- card-body -->

				<?php if($this->settings['is_custom_domain']==1): ?>
					<?php $check_status = $this->admin_m->check_my_domain_status(auth('username')); ?>
					<?php if(empty($check_status) || $check_status->status==3): ?>
					<div class="card-footer text-right"> 
						<input type="hidden" name="request_name" value="<?= auth('username');?>">
						<a href="#requestSubdomainModal" data-toggle="modal" class="btn btn-secondary"><?= lang('send_request');?></a>
					</div>
					<?php endif; ?>
				<?php endif; ?>
			</div><!-- card -->
		</form>
	</div>
</div>

<?php $custom_msg = isJson($this->settings['custom_domain_comments'])?json_decode($this->settings['custom_domain_comments']):''; ?>
<div class="modal fade customModal" id="requestSubdomainModal">
	<div class="modal-dialog">
		<div class="modal-content ">
			<form action="<?= base_url("admin/auth/request_custom_domain");?>" method="post" class="ajaxForm">
				<?= csrf();?>
				<span class="reg_msg"></span>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?= lang('custom_domain');?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<select name="domain_type" class="form-control" onchange="domain_feature(this);">
							<option value=""><?= lang('select');?></option>
							<option value="subdomain">Subdomain</option>
							<option value="domain">Domain</option>
						</select>
					</div>
					<div class="form-group subdomain dis_none domainField">
						<label><?= lang('new_name');?></label>
						<div class="input-group">
							<div class="input-group-addon">
								https://
							</div>
							<input type="text" name="request_name" class="form-control remove_all" autocomplete="off" value="<?= auth('username');?>">
							<div class="input-group-addon">
								<?= get_domain_name(settings()['site_url']);?>
							</div>
						</div>
						<div class="form-group mt-5">
							<p>If You want to request as a new name. just change the <b><u><?= auth('username');?></u></b> from the text field</p>
						</div>
					</div>

					<div class="form-group domain dis_none domainField">
						<?php if(isset($custom_msg->custom_domain_msg) && !empty($custom_msg->custom_domain_msg)): ?>
							<div class="customInstructions">
								<p><?= $custom_msg->custom_domain_msg;?></p>
							</div>
							<hr>
						<?php endif ?>
						<label><?= lang('new_name');?></label>
						<div class="customDomainMSg">
							
						</div>
						<div class="input-group">
							<div class="input-group-addon">
								https://
							</div>
							<input type="text" name="request_domain_name" class="form-control" autocomplete="off" value="" placeholder="example.com">
						</div>
						<div class="form-group mt-5">
							<p class="label-default p-5" style="color:red;">Avoid http, https, www, etc.</p>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><?= lang('submit');?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function domain_feature(e){
		$('.domainField').slideUp();
		let val = $(e).val();
		$(`.${val}`).slideDown();
	}
</script>