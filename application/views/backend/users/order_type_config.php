<div class="row">
	<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	<div class="col-md-7">
		<form action="<?= base_url('admin/restaurant/add_order_configuration'); ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<?= csrf() ;?>
			<div class="card">
				<div class="card-header">
					<h4><?= lang('order_configuration'); ?></h4>
				</div>
				<div class="card-body">
					<div class="row p-15 " style="padding-top: 0!important;">
						<?php foreach ($order_types as $key => $types): ?>
							<?php if(is_feature(auth('id'),'online-payment')==1  && check()==1): 
								$is_payment = 1;
							else:
								$is_payment = 0;
							endif;
							?>

							<?php if($types['slug']!='pay-in-cash'): ?>

								<?php if(isset($types['is_admin_enable']) && $types['is_admin_enable']==1): ?>
									<div class="custom-control order-preference custom-switch prefrence-item ml-10">
										
										<div class="topContent">
											<div class="gap">
												<input type="checkbox" id="<?= $types['slug'];?>" name="order_types" class="switch-input change_type_status" data-id="<?= $types['id'];?>" data-value="<?= $types['status'];?>" data-table="users_active_order_types" <?= isset($types['status']) && $types['status']==1?'checked':'';?>>

												<label for="<?= $types['slug'];?>" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

											</div>
											<div class="preText">
												<label class="custom-control-label"><?= !empty($types['type_name'])?$types['type_name']:'' ;?></label>
												<p class="text-muted"><small><?= !empty(lang('enable_to_allow_in_your_system'))?lang('enable_to_allow_in_your_system'):"Enable to allow in your system"; ?>.</small></p>
											</div>
										</div>
										<?php if(check()==1): ?>
										<?php if($types['slug']=='pay-cash' ): ?>
											<p class="text-danger"><?= lang('payment_not_available');?></p>
										<?php else: ?>
											<?php if(isset($is_payment) && $is_payment==1): ?>
												<?php if($types['slug']!='pay-in-cash' && $types['is_admin_enable']==1):?>
													<div class="left_payment_op <?= is_package ;?>">
														<label class="custom-checkbox">
															<input type="checkbox" name="is_payment[<?= $types['id'];?>]" value="<?= $types['id'];?>" <?= isset($types['is_payment']) && $types['is_payment']==1?"checked":"";?>> <?= lang('enable_payment')?>
														</label>
													</div>
													<div class="left_payment_op <?= is_package ;?>">
														<label class="custom-checkbox">
															<input type="checkbox" name="is_required[<?= $types['id'];?>]" value="<?= $types['id'];?>" <?= isset($types['is_required']) && $types['is_required']==1?"checked":"";?>> <?= lang('payment_required')?>
														</label>
													</div>

												<?php else: ?>
													<div class="left_payment_op hidden">
														<label class="custom-checkbox">
															<input type="checkbox" name="is_payment[<?= $types['id'];?>]" value="<?= $types['id'];?>"  <?= overlay==1?"checked":"" ;?>> <?= lang('enable_payment')?>
														</label>
													</div>
													<div class="left_payment_op hidden">
														<label class="custom-checkbox">
															<input type="checkbox" name="is_required[<?= $types['id'];?>]" value="<?= $types['id'];?>"  <?= overlay==1?"checked":"" ;?>> <?= lang('enable_payment')?>
														</label>
													</div>
												<?php endif; ?>


											 

											<?php endif ?> <!-- check is feature -->

										<?php endif; ?>
									<?php endif; ?>

									</div>
								<?php endif; ?><!-- is_admin_enabled -->


							<?php endif; ?><!-- check slug -->

							<input type="hidden" name="ids[]" value="<?= $types['id'];?>">
						<?php endforeach; ?> 

					</div><!-- row -->
						
				</div><!-- card-body -->
				<div class="card-footer text-right">
					<button type="submit" class="btn btn-secondary"><?= lang('submit');?>	</button>
				</div>
			</div><!-- card -->

			
		</form>
	</div><!-- col-9 -->
</div>
