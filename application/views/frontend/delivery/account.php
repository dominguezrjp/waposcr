<div class="topCustomerProfile">
	<h4><?= !empty(lang('delivery_staff_panel'))?lang('delivery_staff_panel'):"Delivery Staff panel"; ?></h4>
</div>
<div class="customer_profile">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?php include APPPATH.'views/frontend/delivery/leftSidebar.php';  ?>
			</div>
			<div class="col-md-9">
				<div class="serviceRightSide delivery-guy">
					<div class="profleForm">
						<h4 class="header"><?= !empty(lang('account'))?lang('account'):"Account" ;?></h4>
						<div class="accountArea">
							<div class="row">
								<div class="col-md-4 pnt-8">
									<div class="singleTab bg-danger-soft">
										<div class="leftTab">
											<h4><?=  $this->admin_m->count_all_delivery_list(auth('staff_id'),1);?></h4>
											<p><?= !empty(lang('ongoing'))?lang('ongoing'):"On Going" ;?></p>
										</div>
										<i class="icofont-rounded-double-right"></i>
									</div>
								</div>
								<div class="col-md-4 pnt-8">
									<div class="singleTab success-light">
										<div class="leftTab">
											<h4><?=  $this->admin_m->count_all_delivery_list(auth('staff_id'),2);?></h4>
											<p><?= lang('completed'); ?></p>
										</div>
										<i class="icofont-check-circled"></i>
									</div>
								</div>
								<div class="col-md-4 pnt-8">
									<div class="singleTab default-light">
										<div class="leftTab">
											<h4><?= number_format($this->admin_m->get_total_earning(auth('staff_id'),3),2);?> <?= restaurant($info['user_id'])->icon ;?></h4>
											<p><?= !empty(lang('earning'))?lang('earning'):"Earning" ;?></p>
										</div>
										<i class="icofont-money-bag"></i>
									</div>
								</div>
							</div>
							<div class="row">
								<?php foreach ($order_list as $key => $row): ?>
									<div class="col-md-4 pnt-8">
										<div class="singleOrder">
											<p class="timeAgo"><?= get_time_ago($row['accept_time']) ;?></p>
											<a href="<?= base_url("staff/order_details/".shop($row['shop_id'])->username."/{$row['uid']}"); ?>">
												<div class="single_orderTop">
													<h4><?= $row['name'] ;?></h4>
													<h4>#<?= $row['uid'] ;?></h4>
												</div>
											</a>
											<div class="orderDetailsBody">
												<div class="single_orderDetails">
													<p><?= $row['total_item'] ;?> item - <?= $row['total'].''.shop($row['shop_id'])->icon ;?></p>
													<p><i class="fa fa-map-marker"></i> <?= $row['address'] ;?></p>
												</div>
												<div class="singleOrdrebtn">
													<?php if($row['dboy_status']==1): ?>
														<a href="<?= base_url("staff/order_details/".shop($row['shop_id'])->username."/{$row['uid']}"); ?>" class="ongoing"><i class="icofont-spinner-alt-6"></i> Ongoing</a>
													<?php endif;?>

													<?php if($row['is_db_completed']==1): ?>
														<a href="javascript:;"><i class="icofont-check"></i> <?= lang('completed'); ?></a>
														<a href="javascript:;"><?= !empty(lang('cod'))?lang('cod'):"COD" ;?>  <?= $row['total'].''.shop($row['shop_id'])->icon ;?></a>
													<?php endif;?>

													<?php if($row['is_picked']==1 && $row['dboy_status']==2): ?>
														<a href="javascript:;"><i class="icofont-concrete5"></i> <?= lang('picked'); ?></a>
														
													<?php endif;?>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>