<div class="row style_2">
	<?php foreach ($top_8_items as $key => $items): ?>
		<div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-delay="<?= $key+1 ;?>00">
			<?php 
				$total_rating = $this->common_m->total_shop_rating($items['shop_id']);
				$total_review = $this->common_m->total_shop_rating($items['shop_id'],'total');
				$time =$this->common_m->get_single_appoinment(date('w'),$items['shop_id']); 
				$total_order =$this->admin_m->get_total_completed_order_by_shop($items['shop_id']); 
				if($total_review==0){
					$avg = 0; 
				}else{
					$avg = @number_format($total_rating/$total_review,1); 
				}
				
			?>
			<a href="<?= url('menu/'.$items['shop_username']) ;?>" target="blank">
				<div class="singleShop singleShopItem mb-20">
					<div class="leftShopImg img" style="background:url(<?= get_img($items['item_img'],$items['img_url'],$items['img_type']) ;?>)">
					</div>
					<div class="righShopDetails">
						<div class="shopInfo">
							<h4 class="itemTitle"><?= html_escape($items['item_name']) ;?></h4>
							<div class="shop_info">
								<img src="<?= base_url(!empty($items['logo'])?$items['logo']:IMG_PATH.'empty.jpg') ;?>" alt="thumb">
								<div class="imgshop__details">
									<h4><?= $items['shop_name'] ;?></h4>
									<div class="shopBottom shopDeatils_thumb">
										<ul>
											<li title="<?= lang('shop_rating'); ?>" data-toggle="tooltip"><i class="fa fa-star" style="color: rgb(252, 128, 25);"></i> <?= $avg ;?></li>
											<li title="<?= lang('available_time'); ?>" data-toggle="tooltip"><i class="icofont-hour-glass"></i> <?= isset($time['start_time'])?$time['start_time']:'' ;?> - <?= isset($time['end_time'])?$time['end_time']:'' ;?></li>
											<li title="<?= lang('completed_orders'); ?>" data-toggle="tooltip"><i class="icofont-database-add"></i> <?= $total_order ;?></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="shopBottom">
							<ul>
								<li title="<?= lang('price'); ?>" data-toggle="tooltip"><i class="icofont-price" style="color: rgb(252, 128, 25);"></i> <?= $items['is_size']==0? currency_position($items['price'],$items['shop_id']):lang('variants');?></li>
								<li title="<?= lang('total_sell'); ?>" data-toggle="tooltip"><i class="icofont-database-add"></i> <?= $items['total_sell'] ;?></li>
							</ul>
						</div>
					</div>

				</div>
			</a>
		</div>
	<?php endforeach ?>
</div>
