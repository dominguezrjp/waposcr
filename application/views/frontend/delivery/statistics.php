<div class="topCustomerProfile">
	<h4><?= !empty(lang('reports'))?lang('reports'):"reports"; ?></h4>
</div>
<div class="customer_profile">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?php include APPPATH.'views/frontend/delivery/leftSidebar.php';  ?>
			</div>
			<div class="col-md-9">
				<div class="serviceRightSide delivery-guy">
					<div class="searchArea">
						<form action="<?= base_url("staff/report");?>" method="get">
							<div class="custom_fields">
								<select name="m" class="form-control" onchange="this.form.submit()">
									<?php foreach ($dboy_date['month'] as $month): ?>
									<?php if(isset($_GET['m'])): ?>
										<option value="<?= $month;?>" <?= isset($_GET['m']) && $_GET['m']==$month?"selected":"";?> ><?= $month;?></option>
									<?php else: ?>
										<option value="<?= $month;?>" <?=  date('m')==$month?"selected":"";?> ><?= $month;?></option>
									<?php endif ?>

									<?php endforeach ?>
								</select>
								<select name="y" class="form-control" onchange="this.form.submit()">
									<?php foreach ($dboy_date['year'] as $year): ?>
										<?php if(isset($_GET['y'])): ?>
											<option value="<?= $year;?>" <?= isset($_GET['y']) && $_GET['y']==$year?"selected":"";?> ><?= !isset($_GET['y'])?date('Y'):$year;?></option>
										<?php else: ?>
											<option value="<?= $year;?>" <?= date('Y')==$year?"selected":"";?> ><?= $year;?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</form>
					</div>
					<?php if(sizeof($order_list)>0): ?>
						<div class="table-responsive">
							<table class="table table-striped table-condensed">
								<thead>
									<tr>
										<th>#</th>
										<th><?= lang('order_id');?></th>
										<th><?= lang('shipping');?></th>
										<th><?= lang('total');?></th>
										<th><?= lang('date');?></th>
									</tr>
								</thead>
								<tbody>
									<?php $total=$delivery=0 ?>
									<?php foreach ($order_list as $key => $row): ?>
										<tr>
											<td><?= $key+1;?></td>
											<td>#<?= $row['uid'];?></td>
											<td><?= currency_position($row['delivery_charge'],$row['shop_id']);?></td>
											<td><?= currency_position($row['sub_total'],$row['shop_id']);?></td>
											<td><?= full_date($row['completed_time']);?></td>
										</tr>
										<?php 
											$shop_id = $row['shop_id'];
											$total += $row['sub_total'];
											$delivery += $row['delivery_charge'];
										 ?>
									<?php endforeach; ?>
									<tr class="bg-green fw_bold">
										<td></td>
										<td colspan="1">Total</td>
										<td><?= currency_position($delivery??0,$shop_id);?></td>
										<td><?= currency_position($total??0,$shop_id);?></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					<?php else: ?>
						<div class="empty_area">
							<h4><?= lang('not_found');?></h4>
						</div>
					<?php endif; ?>
				</div>
			</div><!-- col-md9 -->
		</div><!-- row -->
	</div>
</div>
