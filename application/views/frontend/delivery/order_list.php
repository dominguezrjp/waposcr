<div class="topCustomerProfile">
	<h4><?= !empty(lang('delivery_staff_panel'))?lang('delivery_staff_panel'):"Delivery Staff panel"; ?></h4>
</div>
<div class="customer_profile">
	<div class="container container-xll">
		<div class="row">
			<div class="col-lg-3 col-12">
				<?php include APPPATH.'views/frontend/delivery/leftSidebar.php';  ?>
			</div>
			<div class="col-lg-9 col-12">
				<div class="serviceRightSide delivery-guy">
					<div class="profleForm">
						<ul class="orderMenu">
							<li><a href="<?= base_url('staff/new_order_list/new'); ?>" class="<?= isset($page_title) && $page_title=="New OrderList"?"active":"";?>"><i class="fa fa-bell"></i> <?= lang('new_order'); ?></a></li>
							<li><a href="<?= base_url('staff/new_order_list/accepted'); ?>" class="<?= isset($page_title) && $page_title=="Accepted OrderList"?"active":"";?>"><i class="icofont-tick-boxed"></i> <?= lang('accepted'); ?></a></li>
							<li><a href="<?= base_url('staff/new_order_list/picked'); ?>" class="<?= isset($page_title) && $page_title=="Picked OrderList"?"active":"";?>"><i class="icofont-concrete5"></i> <?= !empty(lang('picked'))?lang('picked'):"Picked"; ?></a></li>

							<li><a href="<?= base_url('staff/account'); ?>" class="<?= isset($page_title) && $page_title=="Delivery Account"?"active":"";?>"><i class="icofont-users-alt-4"></i> <?= !empty(lang('account'))?lang('account'):"Account"; ?></a></li>
							
						</ul>
						<div class="orderLists">
							<div class="row" id="showOrder">
								<?php include 'order_thumb.php'; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<a href="<?php echo base_url() ?>" id="base_url"></a>
<a href="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_value"></a>
<script src="<?= base_url();?>public/frontend/js/customer-notify.js" ></script>