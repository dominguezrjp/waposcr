<style>
body{
	background-color: #e9ecef
}
.card {
	position: relative;
	display: flex;
	flex-direction: column;
	min-width: 0;
	word-wrap: break-word;
	border: 1px solid rgba(0, 0, 0, .05);
	background-color: #fff;
	background-clip: border-box;
	border-radius: 20px;
	padding-top: 10px;
	padding: 30px;
}
.text-danger-m1 {
	color: #dd4949!important;
}
.text-primary-m1 {
	color: #4087d4!important;
}
.btn {
	font-size: .875rem;
	position: relative;
	transition: all .15s ease;
	letter-spacing: .025em;
	text-transform: none;
	will-change: transform;
}
table.customTable.invoiceTable th{
	background-color: #5e72e4!important;
	color: #fff!important;
}
td p{
	text-transform: capitalize;
}
</style>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="page-content">
				<div class="d_single_order_header track_back">
					<a href="javascript:;" class="back" ><i class="fa fa-angle-left"></i></a>
					<h4> <?= $order_info['name'];?></h4>
				</div>
				<div class="card track-card" id="print_area">
					
					<div class="row">
						<div class="col-12">
							<h4><?= lang('order_id'); ?> #<?= $order_info['uid'];?> </h4>
							<?php if($order_info['order_type']==5): ?>
								<span class="badge badge-success"><?= lang('paid'); ?></span>
							<?php endif;?>


							<small class="text-muted"><?= full_date($order_info['created_at'],$shop->id);?></small><br />
							<small class="text-muted"><?= lang('order_type'); ?>: <?= order_type($order_info['order_type']) ;?></small>
							<hr />
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">

							<div class="customerInfo">
								<h2><?= !empty($shop->name)?$shop->name:$shop->username;?></h2>
								<p>
									<?= lang('phone'); ?> : <?= !empty($shop->phone)?$shop->phone:"";?>
									<br />
									<?= lang('email'); ?> : <?= !empty($shop->email)?$shop->email:"";?>
									<br />
									<?= lang('address'); ?> : <?= !empty($shop->address)?$shop->address:"";?>
									<br />
								</p>

							</div>


						</div>
						<!-- /.col -->
					</div>

					<div class="mt-20">
						<div class="track_bullet">
							<ul>
								<li class="active">
									<i class="icofont-check"></i>
									<div class="single_track">
										<h4><?= !empty(lang('ordered_placed'))?lang('ordered_placed'):"Ordered placed" ;?></h4>
										<p><?= !empty(lang('we_have_received_your_order'))?lang('we_have_received_your_order'):"We have received your order" ;?></p>
										<p class="fz-13 text-muted pt-3"><i class="icofont-wall-clock"></i> <?= full_time($order_info['created_at'],$shop->id);?></p>
									</div>
								</li>
								<?php if($order_info['status']==3): ?>
									<li class="dactive">
										<i class="icofont-close-line"></i>
										<div class="single_track">
											<h4><?= lang('canceled') ;?></h4>
											<p class="fz-13 text-muted pt-3"><i class="icofont-wall-clock"></i> <?= full_time($order_info['cancel_time'],$shop->id);?></p>
										</div>
									</li>
								<?php else: ?>
									<li class="<?= $order_info['status']==1 || $order_info['status']==2?"active":"" ;?>">
										<i class="icofont-check"></i>
										<div class="single_track">
											<h4><?= !empty(lang('order_confirmed'))?lang('order_confirmed'):"Order confirmed" ;?> </h4>
											<p><?= !empty(lang('your_order_has_been_confirmed'))?lang('your_order_has_been_confirmed'):"Your order has beeb confirmed" ;?> </p>
											<p class="fz-13 text-muted pt-3"><i class="icofont-wall-clock"></i> <?= full_time($order_info['accept_time'],$shop->id);?></p>
										</div>
									</li>
									<li class="<?= $order_info['status']==1 || $order_info['status']==2?"active":"" ;?>">
										<i class="icofont-check"></i>
										<div class="single_track">
											<h4><?= !empty(lang('order_processed'))?lang('order_processed'):"Order Processed" ;?> </h4>
											<p><?= lang('we_are_preparing_your_order'); ?> </p>
											<p><?= lang('prepared_time'); ?> : <b><?= $order_info['es_time'].' '.lang($order_info['time_slot']);?></b></p>
											<p class="fz-13 text-muted pt-3"><i class="icofont-wall-clock"></i> <?= full_time($order_info['accept_time'],$shop->id);?></p>
										</div>
									</li>
									<li class="<?= $order_info['status']==2?"active":"" ;?>">
										<i class="icofont-check"></i>
										<div class="single_track">
											<h4><?= lang('ready_to_pickup'); ?> </h4>
											<p><?= lang('your_order_is_ready_to_pickup'); ?> </p>
											<p class="fz-13 text-muted pt-3"><i class="icofont-wall-clock"></i> <?= full_time($order_info['completed_time'],$shop->id);?></p>
										</div>
									</li>
									<li class="<?= $order_info['is_db_accept']==1?"active":"" ;?>">
										<i class="icofont-check"></i>
										<div class="single_track">
											<h4><?= lang('order_confirmed_by_dboy'); ?> </h4>
											<p><?= lang('order_accept_by_dboy'); ?></p>
											<p class="fz-13 text-muted pt-3"><i class="icofont-wall-clock"></i> <?= full_time($order_info['dboy_accept_time'],$shop->id);?></p>
										</div>
									</li>
									<li class="<?= $order_info['is_picked']==1?"active":"" ;?>">
										<i class="icofont-check"></i>
										<div class="single_track">
											<h4><?= lang('order_picked'); ?> </h4>
											<p><?= lang('order_picked_by_dboy'); ?></p>
											<p class="fz-13 text-muted pt-3"><i class="icofont-wall-clock"></i> <?= full_time($order_info['dboy_picked_time'],$shop->id);?></p>
										</div>
									</li>
									<li class="<?= $order_info['is_db_completed']==1?"active":"" ;?>">
										<i class="icofont-check"></i>
										<div class="single_track">
											<h4><?= lang('order_delivered'); ?> </h4>
											<p><?= lang('order_delivered_successfully'); ?></p>
											<p class="fz-13 text-muted pt-3"><i class="icofont-wall-clock"></i> <?= full_time($order_info['dboy_completed_time'],$shop->id);?></p>
										</div>
									</li>
								<?php endif;?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

