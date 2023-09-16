<div class="slots_area mb-20">
	<?php if(count($roomNumers) >0): ?>
		<div class="ml-8">	
			<label><?= lang('select_room_number');?></label>	
		</div>	
		<div class="roomNumber slots_area">	
			<?php foreach ($roomNumers as $key => $room): ?>
				<label class="single_slots"> 
					<input type="radio" name="room_number"  value="<?= $room ;?>" class="singleSlot"><?= $room;?>
				</label>
			<?php endforeach; ?>
		</div>	
	<?php else: ?>
		<h4 class="pickupMsg"><?= lang('sorry_room_numbers_not_available');?></h4>
	<?php endif ?>
</div>