
	<?php $days = get_days(); $off_day = []; ?>
	<?php foreach ($days as $key => $day): 
		$my_days =$this->common_m->get_single_appoinment($key,$shop->id);
		if(isset($my_days['days']) && html_escape($my_days['days'])==$key){

		}else{
			$off_day[] = $key;
		}
	endforeach; ?>

	<?php $time =$this->common_m->get_single_appoinment(date('w'),$shop->id); ?>
	<?php if(!empty($time)): ?>
		<div class="open_time" data-id="<?=  $shop->id;?>" data-status='<?= check_shop_open_status($shop->id) ;?>'></div> 

		<div class="off_days" data-id="<?=  $shop->id;?>" data-day='<?= json_encode($off_day) ;?>'></div> 

		<div class="off_time" data-id="<?=  $shop->id;?>" data-start="<?= isset($time['start_time'])?$time['start_time']:0;?>" data-end="<?= isset($time['end_time'])?$time['end_time']:0;?>"></div>

	<?php endif;?> <!-- check empty time -->