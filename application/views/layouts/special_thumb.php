<?php if(count($specialties)>0): ?>
	<?php 
	    $item_array = get_indexing(count($specialties));
	 ?>
	<div class="row no-gutters">
		<?php foreach ($specialties as $key1=> $row): ?>
		  <div class="col-lg-6 col-sm-6 q-sm">
		    <div class="homeSinglePackage w-50">
		        <div class="special_img img order-last <?= in_array($key1+1, $item_array)?"order-first":"order-last" ;?>" style="background-image: url(<?= base_url($row['thumb'])?>);"></div>
		        <div class="text <?= in_array($key1+1, $item_array)?"order-last":"order-first" ;?>">
		          <h2 class="package_heading"><?= html_escape($row['package_name']) ;?></h2>
		          <p><?= html_escape(character_limiter($row['overview'],120)) ;?></p>
		          <div class="price_section <?= isset($row['is_discount']) && $row['is_discount']==1?"text-center":"text-left";?> mt-5">
		            <h4 class="package_price">
		              <span class="ml-0"><?= currency_position($row['final_price'],$row['shop_id']); ?></span>
		              <?php if($row['is_discount']==1): ?>
		                <span class="price_discount"><?= currency_position($row['price'],$row['shop_id']); ?></span>
		              <?php endif; ?>
		            </h4>
		          </div>
		          <div class="port_d_flex home_view mt-10">
		            <a href="javascript:;" class="quick_view" data-type='specialties'  data-id="<?=  html_escape($row['id']);?>" data-placement="top" data-toggle=""  title="Quick View"><i class="icofont-eye-open"></i> <?= lang('details'); ?></a>
		            <?php if(shop($row['shop_id'])->is_cart == 1): ?>

			            <?php if(shop($row['shop_id'])->stock_status == 1): ?>
			            	<?php if($row['in_stock'] > $row['remaining']): ?>
					            <a href="javascript:;" class="btn custom-btn add_to_cart"  data-id="<?=  html_escape($row['id']);?>" data-type="package" data-placement="top" data-toggle="tooltip" title="Add to Cart"><i class="icofont-ui-cart"></i> <?= lang('order_now'); ?></a>
					        <?php endif;?>
					    <?php else: ?>
			            	<a href="javascript:;" class="btn custom-btn add_to_cart"  data-id="<?=  html_escape($row['id']);?>" data-type="package" data-placement="top" data-toggle="tooltip" title="Add to Cart"><i class="icofont-ui-cart"></i> <?= lang('order_now'); ?></a>
			        	<?php endif;?>

		        	<?php endif;?>


		        </div>
		        </div><!-- text -->
		    </div><!-- singlepackage -->
		  </div> <!-- col-6 --> 
		<?php endforeach; ?>
	</div>
<?php endif;?>