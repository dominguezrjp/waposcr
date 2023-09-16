<a href="#" class="dropdown-toggle p-r notify_btn" data-toggle="dropdown">
	<i class="fa fa-bell-o <?= $notify > 0?"bell_ring":"" ;?>"></i>
	<?php if($notify > 0): ?>
		<span class="pulse-animation"></span>
		<span class="label notify_color"><?= $orders ;?></span>
	<?php endif;?>


</a>
<ul class="dropdown-menu">
	<li class="header"><?= lang('you_have'); ?> <?= $orders ;?> <?= lang('notifications'); ?></li>
	<li>
		<!-- inner menu: contains the actual data -->
		<ul class="menu">
			<li>
				<a href="<?= base_url('admin/restaurant/order_list') ;?>">
					<i class="icofont-live-support fz-16 text-aqua"></i>  <b><?= $orders ;?></b> <?= lang('new_orders_today'); ?>
				</a>
			</li>
			<li>
				<a href="<?= base_url('admin/restaurant/todays_reservation') ;?>">
					<i class="icofont-delivery-time text-yellow fz-16"></i> <?= lang('you_have'); ?> <?= $reservations ;?> <?= lang('reservation_today'); ?>
				</a>
			</li>
			<li>
				<a href="<?= base_url('admin/restaurant/order_list') ;?>">
					<i class="fa fa-list text-red"></i> <?= $completed_orders ;?> <?= lang('completed_orders'); ?>
				</a>
			</li>
		</ul>
	</li>
	<!-- <li class="footer"><a href="#">View all</a></li> -->
</ul>
<span class="is_notify" data-notify="<?= $notify > 0?1:0 ;?>"></span>