<div class="row">
<div class="col-md-4 ">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title"><?= lang('restaurant_profile');?></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body" >
			<div class="user_profile_view">
					<div class="image_field">
						<img src="<?= base_url(!empty($auth_info['thumb'])?$auth_info['thumb']:'assets/frontend/images/avatar.png');?>" alt="">
					</div>
					<div class="single_details_profile mt-10">
						<div class="user_contact_details">
							<h4> <i class="fa fa-user-circle"></i> <?= html_escape($auth_info['name']) ;?> - <label title="Member Since" data-toggle="tooltip" data-placement="top"><i class="fa fa-clock-o"></i> <?= html_escape(full_date($auth_info['created_at']),$auth_info['id']) ;?></label> </h4>
							
							<div class=" profile_bottom_details">
								<?php if($auth_info['country'] !=0): ?>
							    <p><b><i class="fa fa-map-marker"></i> <?= html_escape(get_country($auth_info['country'])['name']) ;?> - <?= html_escape(get_country($auth_info['country'])['currency_symbol']) ;?> - <?= !empty($auth_info['dial_code'])?$auth_info['dial_code']: get_country($auth_info['country'])['dial_code'] ;?></b> </p>
							<?php endif;?>

							<?php if(isset($auth_info['email']) && !empty($auth_info['email'])): ?>
								<p><b><i class="fa fa-envelope-o"></i> <?=  ucfirst($auth_info['email']);?></b></p>
							<?php endif;?>

							<?php if(isset($auth_info['phone']) && !empty($auth_info['phone'])): ?>
								<p><b><i class="fa fa-phone"></i><?= !empty($auth_info['dial_code'])?$auth_info['dial_code']: get_country($auth_info['country'])['dial_code'] ;?> <?=  $auth_info['phone'];?></b></p>
							<?php endif;?>

							    <p><b title="last login" data-toggle="tooltip" data-placement="top"><i class="fa fa-laptop"></i>  <?= html_escape(full_time($auth_info['last_login'])) ;?></b> </p>
							    

							    <p class="text-center verified_item"> 
							    	<span data-toggle="tooltip" data-placement="top" title=" <?= $auth_info['is_active']==1?"Active User":"User is not active" ;?>"><i class="fas fa-user-shield <?= $auth_info['is_active']==1?"c_green":"c_red" ;?>"></i></span> 

							   	<span data-toggle="tooltip" data-placement="top" title="<?= $auth_info['is_verify']==1?"Email Verified":"Email is not Verified" ;?> "><i class="fa fa-envelope <?= $auth_info['is_verify']==1?"c_green":"c_red" ;?>"></i></span> 
							     <span data-toggle="tooltip" data-placement="top" title="<?= $auth_info['is_payment']==1?"Payment Verified":"Payment is not Verified" ;?>"><i class="fa fa-credit-card <?= $auth_info['is_payment']==1?"c_green":"c_red" ;?>"></i>
							     </span>
							     <?php if($auth_info['is_expired']==1): ?>
							     	<span data-toggle="tooltip" data-placement="top" title="Account Expired"><i class="fa fa-ban c_red"></i></span>
							     <?php endif;?>
							 </p>
							</div>
						</div>
					</div>
					<?php if($auth_info['id']==auth('id')): ?>
						<div class="edit_add_info text-center">
							<a href="<?= base_url('admin/auth/edit_profile/'.md5($auth_info['id'])) ;?>" class="btn btn-success btn-flat"> <i class="fa fa-plus mr-5"></i> <?= lang('add_edit_info'); ?></a>
						</div>
					<?php endif;?>
			</div><!-- user_profile_img -->


			<?php if(USER_ROLE==1 && $auth_info['id'] != auth('id')): ?>
			<div class="user_profile_details text-center mt-20">
				<div class="form-group profile-btn-group">
					<?php if(@restaurant($auth_info['id'])->is_admin_gmap==0): ?>
						<a href="<?= base_url("admin/settings/enable_extras/{$auth_info['id']}/is_admin_gmap/1"); ?>" class="btn btn-secondary" data-toggle="tooltip" title="<?= lang('allow_gmap_access'); ?>"><i class="fa fa-map-marker"></i> <?= lang('enable'); ?></a>
					<?php else: ?>
						<a href="<?= base_url("admin/settings/enable_extras/{$auth_info['id']}/is_admin_gmap/0"); ?>" class="btn btn-primary" data-toggle="tooltip"><i class="fa fa-map-marker"></i> <?= lang('disable'); ?></a>
					<?php endif;?>

					<?php if(@restaurant($auth_info['id'])->is_admin_onsignal==0): ?>
						<a href="<?= base_url("admin/settings/enable_extras/{$auth_info['id']}/is_admin_onsignal/1"); ?>" class="btn btn-secondary hidden" data-toggle="tooltip" title="<?= lang('allow_onsignal_access'); ?>"><i class="icofont-hand-drag1"></i> <?= lang('enable'); ?></a>
					<?php else: ?>
						<a href="<?= base_url("admin/settings/enable_extras/{$auth_info['id']}/is_admin_onsignal/0"); ?>" class="btn btn-primary action_btn hidden" data-toggle="tooltip" title="<?= lang('disabled_onsignal_access'); ?>"><i class="icofont-hand-drag1"></i> <?= lang('disable'); ?></a>
					<?php endif;?>
					<a href="#usernameModal" data-toggle="modal" class="btn btn-info"><i class="fa fa-edit"></i> <?= lang('username'); ?></a>
					 <?php if(check()==1): ?>
						<?php $unseen_notify = @$this->admin_m->get_last_unseen_notification($restaurant['id']); ?>
						<?php if(isset($unseen_notify['check']) && $unseen_notify['check']==1): ?>
							<a href="#notificationModal" class="btn btn-danger" data-toggle="modal" title="<?= lang('unseen_last_notification'); ?>"> <?= lang('unseen');?> <i class="icofont-notification"></i></a>
						<?php else: ?>
							<a href="#notificationModal" class="btn btn-secondary" data-toggle="modal" title="<?= lang('send_notification'); ?>"><i class="icofont-notification"></i></a>
						<?php endif; ?>
					<?php endif; ?>



				</div>
				<?php if(!auth('is_staff')): ?>
					<div class="text-center">
						<a href="<?= base_url('admin/dashboard/delete_user/'.$auth_info['id']) ?>" data-msg=" <?= lang('delete_user_msg'); ?>" class="btn btn-danger action_btn" data-toggle="tooltip" data-placement="top" title="Delete user" ><i class="fa fa-trash-o"></i> <?= lang('delete');?></a>
					</div>
				<?php endif; ?>
			</div>
			<?php endif;?>
		</div><!-- /.box-body -->
	</div>
</div>


<?php $order_type_list = @$this->admin_m->get_active_order_types_by_shop_id($restaurant['id']); ?>
<?php if(isset($order_type_list) && count($order_type_list) > 0): ?>
	<div class="col-md-4">
		<div class="card">
			<form action="<?= base_url("admin/auth/enable_order_types");?>" method="post">
				<?= csrf() ;?>
				<div class="card-header">
					<h3 class="card-title"><?= lang('manage_order_types');?></h3>
				</div>
				<div class="card-body">
					
					<ul class="order_type_lists">
						<?php foreach ($order_type_list as $key => $order): ?>
							<li><label class="custom-checkbox"><input type="checkbox" name="is_admin_enable[<?= $order['type_id'];?>]" <?= isset($order['is_admin_enable']) && $order['is_admin_enable']==1?"checked" :""; ;?> value="<?= $order['type_id'];?>"><?= $order['name'];?></label></li>
							<input type="hidden" name="type_ids[]" value="<?= $order['type_id'];?>">
						<?php endforeach; ?>
						
					</ul>
				</div>
				<div class="card-footer text-right">
					<input type="hidden" name="shop_id" value="<?= $restaurant['id'];?>">
					<button type="submit" class="btn btn-secondary"><?= lang('save_change');?></button>
				</div>
			</form>
		</div>
	</div>
<?php endif; ?>
</div><!-- row -->

<?php if(!auth('is_staff') && isset($earning_list)): ?>
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header no-print"> <h4 class="m-0 mr-5"> <?= lang('earnings');?> </h4></div>
			<div class="card-body pt-0">
				<div class="action-buttons exportPrintBtn mt-10">
					<a href="javascript:;" onclick="printDiv('printArea')" class="btn btn-success-light"  data-title="Print">
						<i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
						<?= !empty(lang('print'))?lang('print'):"Print" ;?>
					</a>
					<?php if(check()==1): ?>
						<a id="exportBtn" href="javascript:;" class="btn btn-gray-light"  data-title="PDF">
							<i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
							<?= !empty(lang('export'))?lang('export'):"Export" ;?>
						</a>
					<?php endif;?>
				</div>
				<div id="printArea">
					<div class="salesDropdownArea mb-5 mt-5">
						<ul>
							<li><a href="<?= base_url("admin/auth/profile/{$user_id}");?>"><span class="btn btn-gray-light"><?= lang('all_time');?></span></a></li>
							<li><a href="<?= base_url("admin/auth/profile/{$user_id}/?year=".(!empty($year)? $year:0));?>"><?= !empty($year)? '<span>/</span>'. $year:"";;?></a></li>

							<li><a href="<?= base_url("admin/auth/profile/{$user_id}/?year=".(!empty($year)? $year:0).'&month='.(!empty($month)? $month:0));?>"><?= !empty($month)? '<span>/</span>'. date("F", mktime(0, 0, 0, $month, 10)):"";;?></a></li>
							<?php if(isset($_GET['d']) && !empty($_GET['d'])): ?>
							<li><a href="javascript:;"> <?= !empty($month)? '<span>/</span>'. date("l, d",strtotime($year.'-'.$month.'-'.$_GET['d'])):"";?> </a></li>
						<?php endif ?>
					</ul>
				</div>
				<div class="card-content">
					<div class="earningTables">
						<?php include 'income_table.php'; ?>
					</div>
				</div><!-- card-content -->
			</div><!-- printArea -->

			</div><!-- card-body -->
		</div><!-- card -->

	</div>


	<?php $staff_activities = $this->admin_m->get_staff_activities_by_user_id($auth_info['id']);  ?>
	<?php if(sizeof($staff_activities) > 0): ?>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header"><h4><?= lang('staff_activities');?></h4></div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped data_tables">
						<thead>
							<tr>
								<th>#</th>
								<th><?= lang('staff_name');?></th>
								<th><?= lang('package_name');?></th>
								<th><?= lang('price');?></th>
								<th><?= lang('active_date');?></th>
								<th><?= lang('status');?></th>
								<th><?= lang('action');?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($staff_activities as $key => $st): ?>
								<?php $packages = $this->admin_m->get_package_info_by_id($st['package_id']); ?>
								<tr>
									<td><?= $key+1;?></td>
									<td><?= $st['name'];?></td>
									<td><?= $packages['package_name'];?></td>
									<td><?= admin_currency_position($st['price']);?></td>
									<td><?= full_date($st['active_date']);?></td>
									<td>
										<?php if($st['is_new']==1): ?>
											<label class="label bg-success-soft"><?= lang('newly_added');?></label>
										<?php elseif ($st['is_renewal']==1): ?>
											<label class="label bg-light-purple-soft"><?= lang('renewal');?></label>
										<?php endif; ?>
									</td>
									<td>
										<a href="<?= base_url("admin/adminstaff/activities/{$st['staff_id']}");?>" class="btn btn-flat btn-secondary btn-sm"> <i class="fa fa-eye"></i> </a>
									</td>
								</tr>
							<?php endforeach ?>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php endif ?>
	
</div><!-- row -->
<?php endif ?>


 <!-- printThis -->
	<script type="text/javascript" src="<?= base_url();?>assets/frontend/html2pdf/html2pdf.bundle.js"></script>

	<script>

		var order="<?= random_string('numeric', 4);?>";
		// $('#printBtn').on("click", function () {
		// 	window.print();  
		// });


		function printDiv(divName) {
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;
		}


		$('#exportBtn').on("click", function () {
			var element = document.getElementById('print_area');
			var opt = {
               // margin:       1,
               filename:     'order_'+order+'.pdf',
               image:        { type: 'jpeg', quality: 0.98 },
               html2canvas:  { scale: 2 },
               jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
           };

           html2pdf().set(opt).from(element).save();
       });
   </script>
