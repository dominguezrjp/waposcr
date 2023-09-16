<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('users'))?lang('users'):"users";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
				<div class="filterarea">
					<div class="filterContent">
						<div class="filtercontentBody">
							<form action="" method="get" class="filterForm">
								<div class="filterBody">
									<div class="form-group">
										<label for=""><?= lang('username'); ?></label>
										<input type="text" name="name" class="form-control" value="<?=  isset($_GET['name'])?$_GET['name']:'';?>" placeholder="<?= lang('username'); ?> ">
									</div>
									<div class="form-group">
										<label for=""><?= lang('package_name'); ?></label>
										<select name="package" id="" class="form-control">
											<option value=""><?= lang('all'); ?></option>
											<?php foreach ($packages as $key => $type): ?>
												<option value="<?=  $type['slug'];?>" <?= isset($_GET['package']) && $_GET['package']==$type['slug']?"selected":'' ;?>><?= $type['package_name']; ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="form-group mt-15">
										<button type="submit" class="btn btn-primary filterBtn"><i class="icofont-filter"></i> <?= lang('filter'); ?></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body" >

				<div class="text-right hidden">
					<a href="<?= base_url('admin/dashboard/add_user') ?>" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> <?= !empty(lang('add_new'))?lang('add_new'):"Add New";?></a>
				</div>
				<br>
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
	                <thead>
	                <tr>
	                  <th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
	                  <th><?= !empty(lang('username'))?lang('username'):"username";?></th>
	                  <th><?= !empty(lang('email'))?lang('email'):"email";?></th>
	                  <th><?= !empty(lang('active_date'))?lang('active_date'):"active Date";?></th>
	                  <th><?= !empty(lang('account_type'))?lang('account_type'):"account type";?></th>
	                  <th><?= !empty(lang('extras'))?lang('extras'):"Extras";?></th>
	                  <th><?= !empty(lang('status'))?lang('status'):"status";?></th>
	                  <th><?= !empty(lang('change_package'))?lang('change_package'):"Change Package";?></th>
	                  <th><?= !empty(lang('action'))?lang('action'):"action";?></th>
	                </tr>
	                </thead>
	                <tbody>
	                <?php $i=1; foreach ($all_user as $key => $row): ?>
		                <tr>
		                  <td><?= $i; ?></td>
		                  <td><a href="<?= base_url($row['username']) ;?>" target="blank" class="link_profile" data-toggle="tooltip" data-placement="top" title="Click to view profile"><?= html_escape(strtolower($row['username'])); ?></a> </td>
		                  <td><?= html_escape($row['email']); ?></td>
		                  <td> <?= $row['start_date']!='0000-00-00 00:00:00'?(full_time(html_escape($row['start_date']))):(!empty(lang('not_verified'))?lang('not_verified'):"Not Verify yet"); ?></td>
						  <td>
						  	<?php if($row['is_expired'] == 0): ?>
							  	<span class="label label-default mr-5" data-toggle="tooltip" data-placement="top" title="<?= 'Expired Date: '.$row['end_date'];?>" >
							  		<?php if($row['package_type']=="free"): ?>
							  		<?= !empty(lang('free_account'))?lang('free_account'):"Free Account";?>
							  	<?php elseif($row['package_type']=="trial"): ?>
							  		<?= !empty(lang('trial_package'))?lang('trial_package'):"Trial Package";?>
							  	<?php else: ?>
							  		<?php if($row['is_payment']==1 && $row['end_date'] !='0000-00-00 00:00:00'): ?>
							  			<?= day_left(d_time(),$row['end_date'])['day_left']; ?>
							  		<?php else: ?>
							  			<?= !empty(lang('not_active'))?lang('not_active'):"Not active yet";?> 
							  		<?php endif ?>
							  	<?php endif ?>
							  	</span>
						  	<?php else: ?>
						  		<span class="label label-danger mr-5"  data-toggle="tooltip" data-placement="top" title="<?= 'Expired on: '.day_left(d_time(),$row['end_date'])['day_left'];?>" > <?= !empty(lang('expired'))?lang('expired'):"Expired";?></span>
						  	<?php endif ?>

		                  	<a href="javascript:;"  class="label label-primary primary-light"><?= html_escape($row['package_name']);?></a>

		                  </td>
		                  <td>
		                  		<a href="javascript:;" data-toggle="tooltip" title="<?= lang('supervised_by');?>"  class="label <?= $row['staff_id']==0?"bg-success-soft":"bg-light-purple-soft";?> "><?= isset($row['staff_id']) && $row['staff_id']==0?lang('admin'):s_id($row['staff_id'],'staff_list')->name??'';?></a>


			                  	<?php if(@restaurant($row['id'])->is_admin_gmap == 1): ?>
			                  		<label class="label bg-success-soft" data-toggle="tooltip" title="<?= lang('allow_gmap_access'); ?>"><i class="fa fa-map-marker"></i></label>
			                  	<?php endif;?>

			                  	<?php if(@restaurant($row['id'])->is_admin_onsignal == 1): ?>
			                  		<label class="label bg-success-soft hidden" data-toggle="tooltip" title="<?= lang('allow_onsignal_access'); ?>"><i class="icofont-hand-drag1"></i></label>
			                  	<?php endif;?>
			                  	<?php $unseen_notify = @$this->admin_m->get_last_notification(restaurant($row['id'])->id); ?>
			                  	<?php if(isset($unseen_notify->seen_status) && $unseen_notify->seen_status==0): ?>
			                  		<label class="label bg-danger-soft " data-toggle="tooltip" title="<?= lang('unseen_notification'); ?>"><i class="icofont-notification"></i></label>
			                  	<?php elseif(isset($unseen_notify->seen_status) && $unseen_notify->seen_status==1): ?>
			                  		<label class="label bg-success-soft " data-toggle="tooltip" title="<?= lang('seen_notification'); ?>"><i class="icofont-notification"></i></label>
			                  	<?php endif; ?>
		                  </td>
		                  <td class="rtl_flex">
		                  		<?php if(is_access('change-user-operation')==1): ?>
				                  	<?php if($row['is_active']== 1){ ?>
					                  	<a href="<?= base_url('admin/dashboard/change_status/'.$row['id']."/".$row['is_active']); ?>" class="label label-success ml-5 action_btn" data-msg="Do you want to hold this account?" data-toggle="tooltip" data-placement="top" title="Click to Deactive" ><i class="fa fa-check"></i>&nbsp; <?= !empty(lang('active'))?lang('active'):"Active";?> </a>
					                 <?php }else{ ?>
					                  	<a href="<?= base_url('admin/dashboard/change_status/'.$row['id']."/".$row['is_active']);?>" class="label label-danger ml-5 action_btn" data-msg="<?= lang('want_to_active_this_account'); ?>" data-toggle="tooltip" data-placement="top" title="Click to Active" ><i class="fa fa-ban"></i> &nbsp; <?= !empty(lang('deactive'))?lang('deactive'):"Dactive";?> </a>
					                <?php } ?>
					            
							
								 <?php if($row['is_verify']== 1): ?>
									<a href="javascript:;" class="label label-success ml-5" data-toggle="tooltip" data-placement="top" title="Email Verified"><i class="fa fa-check"></i>&nbsp; <?= !empty(lang('verified'))?lang('verified'):"Verified";?></a>
								<?php else: ?>
									<a href="<?= base_url('admin/dashboard/verify_by_admin/'.html_escape($row['username'])."/1"); ?>" class="label label-danger ml-5 action_btn" data-msg="<?= lang('want_to_verify_this_account'); ?>?" data-toggle="tooltip" data-placement="top" title="Email Verify"><i class="fa fa-ban"></i>&nbsp; <?= !empty(lang('not_verified'))?lang('not_verified'):"Not verified";?></a>
								<?php endif ?> 


								<?php if($row['is_payment']== 1): ?>
									<a href="javascript:;" class="label label-success ml-5" data-toggle="tooltip" data-placement="top" title="Payment status" data-msg="<?= lang('payment_is_verified'); ?>"><i class="fa fa-check" ></i>&nbsp;<?= !empty(lang('paid'))?lang('paid'):"Paid";?> </a>
								<?php else: ?>
									<a href="<?= base_url('admin/dashboard/payment_by_admin/'.html_escape($row['username'])."/1"); ?>" class="label label-danger ml-5 action_btn" data-toggle="tooltip" data-placement="top" title="Click for paid Offline Payment" data-msg="<?= lang('verified_offline_payment_msg'); ?>"><i class="fa fa-money"></i>&nbsp; &nbsp;<?= !empty(lang('pending'))?lang('pending'):"pending";?></a>
								<?php endif ?> 
							<?php endif ?>
			                
		                  </td>

		                  <td>
		                  	
		                  	<?php if(is_access('change-package')==1): ?>
		                  		<a href="#packageModal_<?= $row['id'];?>" title="Change Package" data-toggle="modal" class="btn btn-info btn-sm btn-flat"><i class="fa fa-toggle-on"></i> <?= !empty(lang('change_package'))?lang('change_package'):"Change package";?></a>
		                  	<?php endif ?>
		                  </td>
		                  
		                  <td>
		                  	<a href="<?= base_url("login/custom_login/{$row['id']}");?>" title="Login as Restaurant" data-toggle="tooltip" data-placement="top" class="btn btn-flat btn-secondary btn-sm action_btn"><i class="icofont-login"></i></a>
		                  	<?php if(is_access('reset-password')==1): ?>
		                  		<a href="javascript:;" title="<?= lang('reset_password');?>" data-toggle="tooltip" data-placement="top" class="btn btn-flat btn-warning btn-sm reset_password" data-id="<?= $row['id'];?>"> <i class="fa fa-lock"></i> </a>
		                  	<?php endif ?>

		                  	<?php if(is_access('change-user-operation')==1): ?>
		                  		<a href="<?= base_url('admin/auth/profile/'.md5($row['id'])."/?year=".date('Y')."&month=".date('m')); ?>"  data-toggle="tooltip" data-placement="top" title="Profile details" class="btn btn-flat btn-primary btn-sm" target="blank"> <i class="fa fa-eye"></i> </a>
		                  	<?php endif ?>

							<?php if($this->session->userdata('user_role')==1): ?>
			                  	<a href="<?= base_url('admin/dashboard/delete_user/'.$row['id']) ?>" data-msg=" <?= lang('delete_user_msg'); ?>" class="btn btn-flat btn-danger btn-sm action_btn hidden" data-toggle="tooltip" data-placement="top" title="Delete user" ><i class="fa fa-trash-o"></i></a>
		                  	<?php endif; ?>

		                  </td>
		                </tr>
	            	<?php $i++; endforeach ?>
	                </tbody>
	              </table>
				</div>
			</div><!-- /.box-body -->
			<div class="box-footer" >
				<div class="col-md-12 text-center">
					<div class="pagination">
						<?= $this->pagination->create_links(); ;?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php foreach ($all_user as $key => $users): ?>
	<!-- Modal -->
	<div id="packageModal_<?= $users['id'];?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title"><?= !empty(lang('change_packege'))?lang('change_packege'):"Change Packages";?></h4>
	      </div>
	      <form action="<?= base_url('admin/dashboard/change_packege_by_admin/'.$users['id']); ?>" method="post">
	      	<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

		      <div class="modal-body" style="overflow: hidden;">
		        <div class="package_area" style="justify-content: center;">
		        	<div class="form-group">
		        		<label><?=  !empty(lang('username'))?lang('username'):'Username';?></label>
		        		<h4><?= html_escape($users['username']) ;?></h4>
		        	</div>

		        	<div class="form-group">
		        		<label><?=  !empty(lang('current_package'))?lang('current_package'):'Current package';?></label>
		        		<h4><?= html_escape($users['package_name']) ;?></h4>
		        	</div>
		        	<div class="form-group">
		        		<label> <?=  !empty(lang('packages'))?lang('packages'):'Packages';?></label>
		        		<select name="package_id" id="" class="form-control">
		        			<?php  foreach ($packages as $key => $modal_package): ?>
								<option <?= $users['account_type']==$modal_package['id']?"selected":"" ;?> value="<?=  $modal_package['id'];?>"><?= $modal_package['package_name'];?> - <?= get_currency('icon').' '.$modal_package['price'] ;?> / <?= $modal_package['package_type'];?></option>
							<?php  endforeach; ?>
		        		</select>
		        	</div>
		        	<div class="form-group">
		        		<label class="custom-checkbox"><input type="checkbox" name="is_mail" id="checkbox" value="1"> <?= lang('send_payment_mail_to_user');?></label>
		        	</div>
					
				</div>
		      </div>
		      <div class="modal-footer text-left">
		        <?=  submit_btn();?>
		      </div>
	      </form>
	    </div>

	  </div>
	</div>
<?php endforeach ?>
