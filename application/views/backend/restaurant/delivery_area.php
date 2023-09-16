<div class="row">
	<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<form action="<?= base_url("admin/restaurant/delivery_config");?>" method="post">
							<div class="card-body">
								<?= csrf();?>
								<div class="custom-control custom-switch prefrence-item ml-10 bg_white">
									<div class="gap">
										<input type="checkbox" id="is_area_delivery" name="is_area_delivery" class="switch-input "  <?= isset(restaurant()->is_area_delivery) && restaurant()->is_area_delivery==1?"checked" : "" ;?>>

										<label for="is_area_delivery" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

									</div>
									<div class="preText">
										<div class="">
											<label class="custom-control-label"><?= !empty(lang('area_based_delivery_charge'))?lang('area_based_delivery_charge'):'Area based delivery charge' ;?></label>
											<p class="text-muted"><small><?= !empty(lang('enable_to_allow'))?lang('enable_to_allow'):"Enable to allow"; ?></small></p>
										</div>
										<div class="float-right">

										</div>
									</div>
								</div>
							</div>

							<div class="card-footer">
								<button class="btn btn-secondary"><?= lang('submit');?></button>
							</div>	
						</form>
					</div>
				</div>
			</div>
			<?php if(isset(restaurant()->is_area_delivery) && restaurant()->is_area_delivery==1): ?>
			<div class="row mt-20">
				<div class="col-md-12">
					<form class="email_setting_form" action="<?= base_url('admin/restaurant/add_delivery_area/'.$shop_id) ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
							<div class="card">
								<div class="card-header">
									<h4><?= lang('add_delivery_area'); ?></h4>

								</div>
								<div class="card-body">
									<div class="row p-15">
										<div class="row">
											<div class="form-group col-md-12">
												<label for="title"><?= !empty(lang('area_name'))?lang('area_name'):" Area Name";?> *</label>
												<input type="text" name="area" id="name" class="form-control" placeholder="<?= !empty(lang('area_name'))?lang('area_name'):"Area Name";?>" value="<?= !empty($data['area'])?html_escape($data['area']):""; ?>">
											</div>

											<div class="form-group col-md-12">
												<label for="title"><?= !empty(lang('delivery_charge'))?lang('delivery_charge'):"Delivery Charge";?></label>
												<input type="text" name="cost" class="form-control latitude" value="<?= !empty($data['cost'])?html_escape($data['cost']):0; ?>">
											</div>
										</div>
									</div><!-- row -->

								</div><!-- card-body -->
								<div class="card-footer">
									<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
									<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
								</div>
							</div><!-- card -->
					</form>

				</div>
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h4><?= lang('delivery_area'); ?></h4>
						</div>
						<div class="card-body">
							<div class="row p-15">
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
												<th><?= lang('area_name'); ?></th>
												<th><?= lang('charge'); ?></th>
												<th><?= lang('action'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php $i=1; foreach ($delivery_area_list as $row): ?>
											<tr>
												<td><?= $i;?></td>
												<td><?= html_escape($row['area']); ?></td>
												<td><?= html_escape($row['cost']); ?></td>
												<td>

													<a href="<?= base_url('admin/restaurant/edit_delivery_area/'.html_escape($row['id']).'/'.$shop_id); ?>"  class="btn btn-sm btn-info"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>

													<a href="<?= base_url('delete-item/'.html_escape($row['id']).'/delivery_area_list'); ?>" class=" action_btn btn btn-sm btn-danger" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>" ><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>

												</td>
											</tr>
											<?php $i++; endforeach ?>
										</tbody>
									</table>
								</div>
							</div><!-- row -->

						</div><!-- card-body -->
					</div><!-- card -->
				</div>	
			</div><!-- row -->
		<?php endif ?>
	</div>
		
</div>

