<a href="javascript:;" class="quick_view"  data-id="<?=  html_escape($row['item_id']);?>">
	<div class="homeSingle_item <?= is_image($row['shop_id']);?>">
		<?php if(is_image($row['shop_id'])==0): ?>
			<div class="item_images ">
				<div class="homeSingleImg menu-img img bg_loader" data-src="<?= get_img($row['thumb'],$row['img_url'],$row['img_type']) ;?>" style="background: url(<?= img_loader();?>);"></div>
			</div>
		<?php endif; ?>

		<div class="item__details">
			<div class="itemDetailsLeft">
				<div class="topTitle itemDetailsInfo">
					<h4><?= html_escape($row['title']) ;?> <?php if(isset($row['veg_type']) && $row['veg_type'] !=0): ?> <i class="fa fa-circle veg_type <?= $row['veg_type']==1?'c_green':'c_red';?>" data-placement="top" data-toggle="tooltip" title="<?= veg_type($row['veg_type']);?>"></i><?php endif;?></h4>
					<?php if($row['is_size']==0): ?>
						<div class="homeItem_right">
							<p><?= currency_position($row['price'],$row['shop_id']); ?> </p>
						</div>
					<?php endif;?>
					<div class="price_section">
						<p class="details">
							<?= character_limiter(html_escape($row['overview']),70) ;?>
						</p>
					</div>
				</div>
			</div>
			<div class="addIcon color-soft">
				<i>&#43;</i>
			</div>
		</div>
	</div>
</a>