<div class="leftSidebar delivery-guy <?= isset($page) && $page=="Delivery OrderList"?"xs-hidden sm-hidden":"";?> <?= isset($page_title) && $page_title=="Delivery Account"?"pt-20":"";?>" >
	<div class="topInfo <?= isset($page_title) && $page_title=="Delivery Account"?"xs-hidden sm-hidden pb-20":"";?>">
		<div class="topImg">
			<img src="<?= base_url(!empty($info['thumb'])?$info['thumb']:IMG_PATH.'avatar.png') ;?>" alt="">
		</div>
		<div class="leftDetails">
			<h4><?= $info['name'] ;?></h4>
			<p><?=  my_currency($info['country_id'],'dial_code');?> <?= $info['phone'] ;?></p>
			<p class="badge badge-secondary bg-green"><?= !empty(lang('delivery_staff'))?lang('delivery_staff'):"Delivery Staff"; ?></p>
		</div>
	</div>
	<div class="leftSideDetails <?= isset($page) && $page=="Delivery OrderList"?"xs-hidden sm-hidden":"";?>">
		<ul>
			<li class="<?= isset($page) && $page=="Delivery OrderList"?"active":"";?>"><a href="<?= base_url('staff/new_order_list'); ?>"><i class="fa fa-shopping-basket"></i><span class="hidden-xs hidden-sm"> <?= !empty(lang('order'))?lang('order'):"Order"; ?></span></a></li>

			<li class="<?= isset($page_title) && $page_title=="Delivery Account"?"active":"";?>"><a href="<?= base_url('staff/account') ;?>"><i class="icofont-users-alt-4"></i> <span class="hidden-xs hidden-sm"><?= !empty(lang('account'))?lang('account'):"Account" ;?></span> </a></li>

			<li class="<?= isset($page_title) && $page_title=="Delivery Report"?"active":"";?>"><a href="<?= base_url('staff/report') ;?>"><i class="icofont-chart-line"></i>  <span class="hidden-xs hidden-sm"><?= !empty(lang('reports'))?lang('reports'):"reports" ;?></span> </a></li>

			<li class="<?= isset($page_title) && $page_title=="Delivery Panel"?"active":"";?>"><a href="<?= base_url('staff/delivery') ;?>"><i class="fa fa-user-circle-o"></i> <span class="hidden-xs hidden-sm"><?= !empty(lang('personal_info'))?lang('personal_info'):"Personal Info" ;?></span> </a></li>

			<li class="<?= isset($page_title) && $page_title=="Delivery Password"?"active":"";?>"><a href="<?= base_url('staff/delivery_password') ;?>"><i class="fa fa-key"></i> <span class="hidden-xs hidden-sm"> <?= !empty(lang('change_pass'))?lang('change_pass'):"Change Password" ;?></span></a></li>

			<li><a href="<?= base_url('staff/logout?type=delivery'); ?>"><i class="fa fa-sign-out"></i>  <span class="hidden-xs hidden-sm"><?= !empty(lang('logout'))?lang('logout'):"Logout" ;?></span></a></li>
		</ul>
	</div>
</div>
