<section class="sectionDefault">
	<?php include "include/banner.php"; ?>
	<div class="section_items">
 		<div class="container">
 			<div class="single_items_area">
 				<?php foreach ($packages as $key1=> $row): ?>
 					<div class="defaultHeading text-center">
				      <h1 class="mb-6"><?= html_escape($row['package_name']);?></h1>
				      <p><?= $row['details'] ;?></p>
				    </div><!-- defaultHeading -->
		              <div class="singlePackage_wrapper">
		                <div class="row">
		                  <div class="col-md-12">
		                    <div class="package_title sinlgeOrder">
		                      <h4><?= lang('items');?> </h4>
		                      
		                    </div>
		                  </div>
		                </div>
		                <div class="homePackage_details">
		                  <div class="row">
		                    <?php foreach ($row['items'] as $key => $item): ?>
		                      <div class="col-md-6">
		                        <?php include APPPATH.'views/layouts/package_thumb.php'; ?> 
		                      </div>
		                    <?php endforeach; ?>
		                  </div>
		                </div>
		              </div>
		              <div class="bottomOrder text-center mb-10">
		              	<span class="home_package_price">
		              		<span class="bg-round ml-10 fw_bold"><?= currency_position($row['final_price'],$shop_id); ?></span>
		              		<?php if($row['is_discount']==1): ?>
		              			<span class="price_discount badge"><?= currency_position($row['price'],$shop_id); ?></span>
		              		<?php endif; ?>
		              	</span>
		              </div>
		              <div class="package_order_btns text-center mt-20">
		              	<a href="javascript:;" class="btn custom-btn add_to_order"  data-id="<?=  html_escape(md5($row['id']));?>"><i class="icofont-ui-cart"></i> <?= lang('confirm_order'); ?></a>

		              </div>
		              <div class="successMsg mt-15"></div>
		            <?php endforeach; ?>
 			</div>
 		</div>
	</div><!-- section_items -->
</section>
