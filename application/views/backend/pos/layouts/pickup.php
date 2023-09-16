<div class="pickup">
	<?php $time =$this->common_m->get_single_appoinment(date('w'),$shop_id); ?>
	<?php $pickup_area =$this->common_m->get_pickup_area($shop_id); ?>
	<div class="row">
		<div class="col-md-12">
			<div class="pickup_area_list">
				<div class="mb-10">
					<label class=""><?= lang('select_pickup_area'); ?></label>
				</div>
				<div class="pickupPointSlot">
					<?php foreach ($pickup_area as $key => $area): ?>
						<label class="singleSlots" data-toggle="tooltip" title="<?= $area['address'] ;?>" data-title="<?= $area['name']." - ".$area['address'] ;?>"><?= $area['name'] ;?><input type="radio" name="pickup_point_id" class="activeSlot" value="<?= $area['id'];?>"></label>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<div class="pickupDetailsArea dis_none">
		<?php if(isset($time) && !empty($time)): ?>
			<div class="form-group col-md-6 col-6 mt-20">
				
				<label><?= !empty(lang('pickup_date'))?lang('pickup_date'):'Pickup date' ;?> <span class="error">*</span></label>
				<div class="pickupCheckDate mt-5 mb-10">
					<label class="label bg-light-purple-soft  custom-radio-2 dateLabel"><input type="radio" class="pickup_date_checker" name="today" data-id="<?= $shop_id;?>" value="1" checked><?= lang('today'); ?></label>
					<label class="label bg-light-purple-soft ml-10 custom-radio-2 dateLabel"><input type="radio" class="pickup_date_checker" name="today" data-id="<?= $shop_id;?>" value="2"><?= lang('others'); ?></label>
				</div>
				<div class="pickupTime" style="display: none;">

					<div class="input-group date flatpickr" id="datepicker" data-target-input="nearest">
						<input type="text" name="pickup_date" class="form-control datepicker-1" data-target="#datepicker" data-input/>
						<div class="input-group-append" data-target="#datepicker" data-toggle="datetimepicker">
							<div class="input-group-text"><i class="fa fa-calendar"></i></div>
						</div>
					</div>
				</div>
			</div>

			<!-- pickup time slots -->
			<div class="form-group col-md-12 col-lg-12 col-12 mt-5">
				<div class="pickupTimeSlots null">
					<i class="fa fa-spinner fa-spin"></i>
				</div>
			</div>
			<!-- pickup time slots -->

		<?php else: ?>
			<div class="form-group col-md-6 col-12 mt-10">
				<label><?= !empty(lang('pickup_time'))?lang('pickup_time'):'pickup time' ;?> <span class="error">*</span></label>
				<div class="pickup_up" >
					<h4><?= lang('pickup_time_alert'); ?></h4>
				</div>
			</div>
		<?php endif; ?>
		</div><!-- pickupDetailsArea -->
	</div> <!-- row -->
</div><!-- order_type_body -->