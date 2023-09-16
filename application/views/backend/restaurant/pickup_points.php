
<div class="row">
	<?php include APPPATH.'views/backend/common/inc/leftsidebar.php'; ?>
	<div class="col-md-5">
		<div class="row">
			<form class="email_setting_form" action="<?= base_url('admin/restaurant/add_pickup_points/'.$shop_id) ?>" method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="row p-15">
									<div class="table-responsive">
										<table class="table table-condensed table-striped">
											<thead>
												<tr class="text-center">
													<th width="2%"><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
													<th width="20%"><?= !empty(lang('name'))?lang('name'):"name";?></th>
													<th width="30%"><?= !empty(lang('latitude'))?lang('latitude'):"latitude";?></th>
													<th width="30%"><?= !empty(lang('longitude'))?lang('longitude'):"longitude";?></th>
													<th width="30%"><?= !empty(lang('address'))?lang('address'):"address";?></th>
													<th width="30%"><?= !empty(lang('action'))?lang('action'):"action";?></th>
												</tr>
											</thead>
											<tbody class="input_fields_wrap">
												<?php if(count($pickup_points) > 0): ?>
												<?php foreach ($pickup_points as $key => $points): ?>
													<tr>
														<td><?=  $key+1;?></td>
														<td><input type="text" name="name_ex[]" class="form-control" value="<?=  !empty($points['name'])?$points['name']:"";?>"></td>
														<td><input type="text" name="latitude_ex[]" class="form-control" value="<?=  !empty($points['latitude'])?$points['latitude']:"";?>"></td>
														<td><input type="text" name="longitude_ex[]" class="form-control" value="<?=  !empty($points['longitude'])?$points['longitude']:"";?>"></td>
														<td><input type="text" name="address_ex[]" class="form-control" value="<?=  !empty($points['address'])?$points['address']:"";?>"></td>
														<input type="hidden" name="ex_id[]" value="<?= isset($points['id']) && $points['id']!=0?$points['id']:0; ?>">
														<td>

															<a href="<?= base_url('delete-item/'.html_escape($points['id']).'/pickup_points_area'); ?>" class="label label-danger action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"Want to Delete?";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>


															</td>
													</tr>
												<?php endforeach ?>
												<input type="hidden" class="total_points" value="<?= count($pickup_points) ;?>">
												<?php else: ?>
													<tr>
														<td>1</td>
														<td><input type="text" name="name[]" class="form-control"></td>
														<td><input type="text" name="latitude[]" class="form-control"></td>
														<td><input type="text" name="longitude[]" class="form-control"></td>
														<td><input type="text" name="address[]" class="form-control"></td>
													</tr>
													<input type="hidden" class="total_points" value="1">
												<?php endif;?>
											</tbody>

										</table>
									</div>
									<div class="text-right">
										<a href="javascript:;"  class="label label-info add_field_button"><i class="fa fa-plus"></i> <?= !empty(lang('add_new'))?lang('add_new'):"Add New";?></a>
									</div>
								</div><!-- row -->
									
							</div><!-- card-body -->
							<div class="card-footer">
								<input type="hidden" name="id" value="<?= isset($settings['id'])?html_escape($settings['id']):0; ?>">
								<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
							</div>
						</div><!-- card -->
					</div><!-- col-9 -->
				</form>
		</div><!-- row -->
		<div class="row">
			<form action="<?= base_url('admin/restaurant/add_pickup_slots/') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h4><?= lang('pickup_time'); ?></h4>
						</div>
						<div class="card-body">
							<div class="row p-15">
								<div class="table-responsive">
									<div class="pickup-slots">
										<?php $pickup_slots = json_decode($restaurant['pickup_time_slots'],true); ?>
										<?php $get_time = getTimeSlot('30','00:00','23:00') ?>
										<?php foreach ($get_time as $key2 => $slots): ?>
										<?php $timeSlot =  $slots['slot_start_time'].' - '.$slots['slot_end_time'];?>
										<label class="time_slot success-light <?= !empty($pickup_slots) && !empty($slots['slot_start_time']) && in_array($timeSlot,$pickup_slots)==1?"active":"" ;?>">

											<input type="checkbox" class="timeCheckeds" name="time_slots[<?= $key2;?>]" value="<?= $timeSlot ;?>" <?= isset($pickup_slots) && in_array($timeSlot,$pickup_slots)==1?"checked":"" ;?>> <?= time_format($slots['slot_start_time'],restaurant()->id) ;?> - <?= time_format($slots['slot_end_time'],restaurant()->id) ;?>
										</label>

										<?php endforeach ?>
									</div>
								</div>
							</div><!-- row -->
								
						</div><!-- card-body -->
						<div class="card-footer">
							<input type="hidden" name="id" value="<?= isset(restaurant()->id)?restaurant()->id:0; ?>">
							<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
						</div>
					</div><!-- card -->
				</div><!-- col-9 -->
			</form>
		</div>
	</div>
	

	<div class="col-md-4">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"><?= lang('google_map_api_key'); ?></h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body" >
						<div class="upcoming_events">
							<form action="<?= base_url('admin/restaurant/add_gmap/'.$shop_id); ?>" method="post"> 

								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
								<div class="row">
									<div class="form-group  col-md-4 col-sm-6 col-xs-6">
										<label > <?= !empty(lang('google_map_status'))?lang('google_map_status'):'Google Map Status' ;?></label>
										<div class="gap">
											<input type="checkbox" id="is_gmap" name="is_gmap" class="switch-input "  <?= isset(restaurant()->is_gmap) && restaurant()->is_gmap==1?"checked" : "" ;?>>

											<label for="is_gmap" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group">
										<label for=""><?= lang('google_map_api_key'); ?></label>
										<input type="text" name="gmap_key" class="form-control" value="<?= !empty(restaurant()->gmap_key)? restaurant()->gmap_key: '' ;?>">
									</div> 
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10 text-right">
										<input type="hidden" name="id" value="<?= isset(restaurant()->id)?restaurant()->id:0; ?>">
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):'save change';?></button>
									</div>
								</div>
							</form>
						</div>	
					</div><!-- /.box-body -->
				</div>
			</div>	
		</div>
	</div>		
</div>


