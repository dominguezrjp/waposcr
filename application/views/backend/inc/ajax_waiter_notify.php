<?php $todays_notify= $this->admin_m->get_todays_waiter_notification(restaurant()->id); ?>
<?php foreach ($todays_notify as $key => $notify): ?>
	<li class="wow fadeIn " data-wow-duration="5s" data-wow-delay="<?=  $key+1;?>0s"
		id="hide_<?= $notify['id'] ;?>">
		<div class="notify_msg">
			<div class="p-r leftIcon">
				<span class="pulse-animation"></span><i class="fa fa-bell-o <?= $notify > 0?"bell_ring":"" ;?> "></i>
			</div> 
			<div class="tableMsg">
				<h4 class="p-r waiterNotify"><?= lang('customer_waiting_msg'); ?> <b><?= $notify['table_name'] ;?></b></h4>
			</div>
			<a href="<?= base_url('admin/notification/accept_waiter/'.$notify['id']) ;?>" class="waiterAccept" data-id="<?=  $notify['id'];?>"><?= lang('accept'); ?></a>
		</div>
	</li>
<?php endforeach ?>
