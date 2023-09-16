<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header"> <?= lang('shop_reviews');?> <h4 class="m-0 mr-5"> </h4></div>
			<div class="card-body p-5">
				<div class="card-content">
					<div class="shopReviews">
						<ul>
							<?php foreach ($review_list as $row): ?>
								<li>
									<div class="ratingArea">
										<div  class="ratingInfo">
											<a href="<?= url($row['username']);?>" target="blank">
												<h5><?= !empty($row['name'])?$row['name']:$row['username'];?></h5>
												<p><?= lang('by');?> : <?= $row['customer_name'];?></p>
											</a>

											<div class="ratings">
												<span class="ratings"><?= $row['customer_rating'];?></span> 
												<div class="star_area">
													<?php for ($i=1; $i <=5 ; $i++) { ?>
														<?php if($i > $row['customer_rating']): ?>
															<i class="fa fa-star-o"></i>
														<?php else: ?>
															<i class="fa fa-star"></i>
														<?php endif;?>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="comments">
											<p><?= $row['customer_review'];?></p>
										</div>
									</div>
									<div class="ratingBtn">
										<?php if($row['is_rating_approved']==0): ?>
											<a href="<?= base_url("admin/dashboard/review_status/{$row['order_id']}/1");?>" class="btn btn-success mr-5 action_btn"><i class="fa fa-check"></i> <?= lang('approve')?></a>
										    <a href="<?= base_url("admin/dashboard/review_status/{$row['order_id']}/2");?>" class="btn btn-danger action_btn"><i class="fa fa-close"></i> <?= lang('reject')?></a>
									<?php else: ?>
										 <a href="javascript:;" class="btn btn-danger"><i class="fa fa-close"></i> <?= lang('rejected')?></a>
										 
										 <a href="<?= base_url("admin/dashboard/review_status/{$row['order_id']}/delete");?>" class="btn btn-danger"><i class="fa fa-trash"></i> <?= lang('delete')?></a>
									<?php endif ?>
									</div>
								</li>	
							<?php endforeach ?>
						</ul>
					</div>
				</div><!-- card-content -->
			</div><!-- card-body -->
			<div class="card-footer text-right"> 

			</div>
		</div><!-- card -->
	</div>
</div>