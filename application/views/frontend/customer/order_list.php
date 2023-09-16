<div class="topCustomerProfile">
	<h4><?= !empty(lang('customer_panel'))?lang('customer_panel'):"Customer panel"; ?></h4>
</div>
<div class="customer_profile">
	<div class="container container-xll">
		<div class="row">
			<div class="col-lg-3 col-12">
				<?php include APPPATH.'views/frontend/customer/leftSidebar.php';  ?>
			</div>
			<div class="col-lg-9 col-12">
				<div class="serviceRightSide">
					<div class="profleForm">
						<h4 class="header mb-0"><?= !empty(lang('orders'))?lang('orders'):"Orders" ;?></h4>
						<div class="table-responsive">
							<table class="table customTable" id="example1">
								<thead>
									<tr>
										<th><?= lang('sl'); ?></th>
										<th><?= lang('order_id'); ?></th>
										<th><?= lang('shop_name'); ?></th>
										<th><?= lang('order_type'); ?></th>
										<th><?= lang('total_qty'); ?></th>
										<th><?= lang('total_price'); ?></th>
										<th><?= lang('date'); ?></th>
										<th><?= lang('status'); ?></th>
										<th><?= lang('action'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($order_list as $key => $row): ?>
										<tr>
											<td><?= $key+1;?></td>
											<td class="orderTag">#<?= $row['uid'];?></td>
											<td><?= shop($row['shop_id'])->name;?></td>
											<td>
												<?= ucfirst(order_type($row['order_type']));?>

											</td>
											<td><?= $row['total_item'];?></td>

											<td class="text-center">
												<p class="priceTag"><?= $row['total'];?> <?= shop($row['shop_id'])->icon;?></p>
												<?php if($row['order_type']==1 || $row['order_type']==5): ?>
													<p class="fz-13 badge"><?= lang('shipping'); ?> : <?= $row['delivery_charge']==0?lang('free'):$row['delivery_charge'].''.shop($row['shop_id'])->icon ;?></p>
												<?php endif; ?>
											</td>
											<td>
												<label class="badge badge-secondary"> <?= full_time($row['created_at'],$row['shop_id']);?></label>
												<?php if($row['order_type']==4): ?>
													<p class="badge"><?= lang('pickup_time'); ?>  <?=!empty($row['pickup_time'])?$row['pickup_time']: time_format_12($row['reservation_date']) ;?></p>
												<?php endif;?>
											</td>
										
											<td>
												<div class="">
													<?php if($row['status']==0): ?>
														<label class="badge badge-warning"><?= lang('pending'); ?></label>
													<?php elseif($row['status']==1): ?>
														<label class="badge badge-info"><?= lang('approved'); ?></label>
													<?php elseif($row['status']==2): ?>

														<?php if($row['order_type']==1 && $row['is_db_completed']==0): ?>
															<a href="javascript:;" class="badge badge-success"><i class="icofont-check-alt"></i></i> <?= lang('your_order_is_ready_to_delivery'); ?></a>
															<?php if($row['is_picked']==0):?>
																<p class="fz-12 text-muted"><?= lang('waiting_for_picked');?></p>
															<?php else:?>
																<p class="fz-12 text-muted"><?= lang('order_picked_by_dboy');?></p>
															<?php endif; ?>
														<?php else: ?>
															<a href="javascript:;" class="badge badge-success"><i class="icofont-check-alt"></i></i> <?= lang('completed'); ?></a>
														<?php endif; ?>


														<?php if(!empty($row['customer_rating']) && $row['is_rating_approved']==1): ?>
															<div class="startRating orderlistRating">
																<?php for ($i=1; $i <=5; $i++) { ?>

																	<span class="" title="<?=$row['customer_rating'].' '. lang('stars'); ?>"><i class="fa <?= $i<=$row['customer_rating']?"fa-star":"fa-star-o" ;?>"></i></span>
																		
																<?php  }?>
															</div>
														<?php endif;?>
													<?php elseif($row['status']==3): ?>
														<label class="badge badge-danger"><?= lang('rejected'); ?></label>
													<?php endif;?>
												</div>
											</td>
											<td>
												<div class="d-flex actionBtn">
													<a href="javascript:;" class="btn btn-success btn-sm showItemList" data-id="<?= $row['uid'];?>" data-shop-id="<?= $row['shop_id'];?>" title="<?= lang('order_item_list');?>" data-toggle="tooltip"><i class="fa fa-eye"></i></a>

													<a href="<?= base_url("staff/my_invoice/".shop($row['shop_id'])->username."/{$row['uid']}"); ?>" class="btn btn-primary btn-sm" target="_blank" title="<?= lang('invoice');?>" data-toggle="tooltip"><i class="fa fa-file-pdf-o"></i></a>

													<?php if($row['order_type']==1 || $row['order_type']==5): ?>
													    <a href="<?= base_url("staff/track_order/".shop($row['shop_id'])->username."/{$row['uid']}"); ?>" class="btn btn-secondary btn-sm" title="<?= lang('track_order');?>" data-toggle="tooltip"><i class="fa fa-truck flip-x" aria-hidden="true"></i></a>
													<?php endif;?>
													<?php if($row['status']==2): ?>

														<?php if(shop($row['shop_id'])->is_review==1): ?>
															<?php if(empty($row['customer_rating']) || $row['customer_rating']==0): ?>
																<a href="#ratingModal_<?=  $row['id'];?>" data-toggle="modal" class="btn btn-warning btn-sm" title="Add Rating"><i class="fa fa-star-o"></i></a>
															<?php endif;?>
														<?php endif;?>

													<?php endif;?>
												</div>
											</td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php foreach ($order_list as $key => $row): ?>
<div class="modal fade" id="ratingModal_<?=  $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">#<?=  $row['uid'];?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('customer/add_rating/') ;?>" method="post">
      	<?= csrf() ;?>
	      <div class="modal-body">
	      	<div class="row justify-content-center">
	      		<div class="form-group text-center ratingArea">
	      			<h5 class="text-center fz-16 mb-3"><?=  !empty(lang('give_your_feedback'))?lang('give_your_feedback'):"Please give your feedback";?></h5>
	      			<div class='rating-stars text-center mt-20'>
	      				<ul id='stars'>
	      					<li class='star' title='Poor' data-value='1'>
	      						<i class='fa fa-star fa-fw'></i>
	      					</li>
	      					<li class='star' title='Fair' data-value='2'>
	      						<i class='fa fa-star fa-fw'></i>
	      					</li>
	      					<li class='star' title='Good' data-value='3'>
	      						<i class='fa fa-star fa-fw'></i>
	      					</li>
	      					<li class='star' title='Excellent' data-value='4'>
	      						<i class='fa fa-star fa-fw'></i>
	      					</li>
	      					<li class='star' title='WOW!!!' data-value='5'>
	      						<i class='fa fa-star fa-fw'></i>
	      					</li>
	      				</ul>
	      			</div>
	      		</div>
	      		<div class="form-group col-md-12">
	      			<textarea name="customer_review" id="" class="form-control h-47" cols="5" rows="5" placeholder="<?=  !empty(lang('comments'))?lang('comments'):"Comments.";?>"></textarea>
	      		</div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="customer_rating" class="rating" value="">
	      	<input type="hidden" name="uid" class="" value="<?= $row['uid'] ;?>">
	        <button type="submit" class="btn btn-primary" ><?= lang('submit'); ?></button>
	      </div>
	  </form>
    </div>
  </div>
</div>
<?php endforeach;?>	





<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content bg-gray pp-5" id="showData">
			<!-- show details here -->
		</div>
	</div>
</div>
	<!-- end modal -->