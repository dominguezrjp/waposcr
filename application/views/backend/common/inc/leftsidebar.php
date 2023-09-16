<div class="col-md-3">
	<div class="card">
		<div class="card-body">
			<div class="leftSidebar">
				<ul class="flex-column">
					<li><a href="<?= base_url('admin/restaurant/general/'); ?>" class="<?= isset($page_title) && $page_title == "Profile"?"active":"" ;?>"><i class="fa fa-cog"></i> <?= !empty(lang('general'))?lang('general'):"general"; ?></a></li>
					<?php if(is_access('profile-control')==1): ?>
						<li><a href="<?= base_url('admin/restaurant/profile'); ?>" class="<?= isset($page_title) && $page_title == "Restaurant Configuration"?"active":"" ;?>"> <i class="icofont-badge"></i> <?= !empty(lang('restaurant_configuration'))?lang('restaurant_configuration'):"Restaurant Configuration"; ?></a></li>

						<li><a href="<?= base_url('admin/restaurant/reservation/'.md5(restaurant()->id)); ?>" class="<?= isset($page_title) && $page_title == "Available Days"?"active":"" ;?>"><i class="icofont-bullhorn"></i> <?= !empty(lang('available_days'))?lang('available_days'):"Available days"; ?></a></li>


						<li><a href="<?= base_url('admin/restaurant/pickup_points/'.md5(restaurant()->id)); ?>" class="<?= isset($page_title) && $page_title == "Pickup Points"?"active":"" ;?>"><i class="icofont-location-pin"></i> <?= !empty(lang('pickup_points'))?lang('pickup_points'):"Pickup Points"; ?></a></li>

						<li><a href="<?= base_url('admin/restaurant/tables/'.md5(restaurant()->id)); ?>" class="<?= isset($page_title) && $page_title == "Tables"?"active":"" ;?>"><i class="icofont-dining-table"></i> <?= !empty(lang('tables'))?lang('tables'):"Tables"; ?></a></li>

						<li><a href="<?= base_url('admin/restaurant/location/'.md5(restaurant()->id)); ?>" class="<?= isset($page_title) && $page_title == "Locations"?"active":"" ;?>"><i class="icofont-map-pins"></i> <?= !empty(lang('locations'))?lang('locations'):"locations"; ?></a></li>

						
						<?php if(is_feature(auth('id'),'qr-code')==1): ?>
							<li><a href="<?= base_url('admin/restaurant/qrbuilder/'.md5(restaurant()->id)); ?>" class="<?= isset($page_title) && $page_title == "Qr Builder"?"active":"" ;?>"><i class="icofont-brand-steam"></i> <?= !empty(lang('qr_builder'))?lang('qr_builder'):"Qr Builder";?></a> </li>

							<li><a href="<?= base_url('admin/restaurant/table_qrbuilder/'.md5(restaurant()->id)); ?>" class="<?= isset($page_title) && $page_title == "Table Qr Builder"?"active":"" ;?>"><i class="icofont-dining-table"></i><i class="icofont-qr-code"></i> <?= !empty(lang('table_qr_builder'))?lang('table_qr_builder'):"Table Qr Builder";?></a></li>
						<?php endif ?>
						<li><a href="<?= base_url('admin/room_services/'); ?>" class="<?= isset($page_title) && $page_title == "Room Services"?"active":"" ;?>"><i class="icofont-ui-home"></i>  <?= lang('room_services');?></a></li>
					<?php endif;?>
				</ul>
			</div>
		</div>
	</div>
</div><!-- col-md-3 -->