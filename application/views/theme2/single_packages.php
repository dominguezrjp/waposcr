<section class="sectionDefault">
	<?php include "include/banner.php"; ?>
	<div class="defaultHeading text-center">
          <h1 class="mb-6"><?= get_title($id,'packages',1) ;?></h1>
          <?php if(!empty(get_title($id,'packages',2))): ?>
              <p><?= get_title($id,'packages',2) ;?></p>
          <?php endif;?>
    </div>
	<div class="packageSection mt-20">
		<div class="container">
			<?php if(count($packages)>0): ?>
				<div class="row">
					<div class="col-md-12" >
						<div class="accordion_area">
							<div class="accordions">
								<?php foreach ($packages as $key1=> $row): ?>
									<div class="single_accordion" dir="<?= direction();?>">
										<div class="page_accordion_header <?=  $key1==0?"active arrow_down":"arrow_up";?> ">
											<div class="package_header_left">
												<?= html_escape($row['package_name']);?>
												<h4 class="package_price">
												<span class="bg-round ml-10"><?= currency_position($row['final_price'],$shop_id);; ?></span>
												<?php if($row['is_discount']==1): ?>
													<span class="price_discount"><?= currency_position($row['price'],$shop_id); ?></span>
												<?php endif; ?>
												</h4>
											</div>
										</div>
										<div class="accordion_content item <?=  $key1==0?"block":"";?>">
											<div class="row">
													<?php if(is_image($shop_id)==0): ?>
														<div class="col-md-12">
															<div class="packgeImages venobox" href="<?= base_url($row['images']);?>" data-vbtype="image">
																	<img src="<?= base_url($row['thumb']);?>" alt="">
															</div>
														</div>
													<?php endif; ?>
												<div class="col-md-12">
													<div class="package_overview">
														<p><?= $row['details'] ;?></p>
													</div>
												</div>
												<?php foreach ($row['items'] as $key => $item): ?>
													<div class="col-md-6">
														<?php include APPPATH.'views/layouts/package_thumb.php'; ?> 
													</div>
												<?php endforeach ?>
												<?php if(shop($row['shop_id'])->is_cart == 1): ?>
													<div class="col-md-12">
														<div class="package_header_right text-center">
															<?php if(shop($row['shop_id'])->stock_status == 1): ?>

																<?php if($row['in_stock'] > $row['remaining']): ?>
																	<a href="javascript:;" class="btn custom-btn add_to_cart" data-res-id="<?= $shop['id'];?>" data-id="<?=  html_escape($row['id']);?>" data-type="package" data-placement="top" data-toggle="tooltip" title="Add to Cart"><i class="icofont-ui-cart"></i> <?= lang('add_to_cart'); ?></a>
																<?php else: ?>
																	<span class="out_of_stock"><?= lang('out_of_stock'); ?></span>
																<?php endif;?>

															<?php else: ?>
																<a href="javascript:;" class="btn custom-btn add_to_cart" data-res-id="<?= $shop['id'];?>" data-id="<?=  html_escape($row['id']);?>" data-type="package" data-placement="top" data-toggle="tooltip" title="Add to Cart"><i class="icofont-ui-cart"></i> <?= lang('add_to_cart'); ?></a>
															<?php endif;?>

															
														</div>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>   
						</div>
					</div>
				</div>
			<?php endif;?> 
		</div>
	</div>
</section>
