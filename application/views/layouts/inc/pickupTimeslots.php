
<label ><?= !empty(lang('pickup_time'))?lang('pickup_time'):'pickup time' ;?> <span class="error">*</span></label>
<div class="slots_area">
	<?php if(count($getTmes) >0): ?>
		<?php foreach ($getTmes as $key => $slots): ?>
			<label class="single_slots"> <input type="radio" name="pickup_time" value="<?= $slots ;?>" class="timeChecked"><?= slot_time_format($slots,$shop_id) ;?></label>
		<?php endforeach; ?>
	<?php else: ?>
		<h4 class="pickupMsg"><?= lang('sorry_today_pickup_time_is_not_available');?></h4>
	<?php endif ?>

</div>