
<?php foreach ($this->cart->contents() as $key => $row): ?>
	<?php $shop_id = $row['shop_id']; ?>
	<?php if(!isset($row['is_pos'])): ?>
	<li>
		<div class="single_item_cart">
			<div class="incress_area">
				<span class="value-button minus" data-id="<?= $row['rowid'] ;?>" value="Decrease Value"><i class="icofont-minus"></i></span>

				<span class="cart_qty_field"><input readonly type="number" id="qty_<?= $row['rowid'] ;?>" class="qty" value="<?= $row['qty'] ;?>" min-value='1' /></span>

				<span class="value-button add" data-id="<?= $row['rowid'] ;?>"  value="Increase Value"><i class="icofont-plus"></i></span>
			</div>
			<div class="left_cart <?= is_image($shop_id);?>">
				<?php if(is_image($shop_id)==0): ?>
					<img src="<?= get_img($row['thumb'],$row['img_url'],$row['img_type']) ;?>" alt="item_img">
				<?php endif; ?>
				<div class="single_cart_item_details">
					<h4><?= html_escape($row['name']) ;?> <span class="extrasTitleCard">
						<?php if(isset($row['is_extras']) && $row['is_extras']==1 && !empty($row['extra_id'])): ?>
							<?php foreach (json_decode($row['extra_id'],true) as $ex):?>
								<?php echo $extras_name =  rtrim('+'.$this->common_m->get_extras_name($ex,$row['item_id']).'+','+'); ?>
							<?php endforeach ?>
						<?php endif ?>
					</span></h4>
					<p><?= lang('qty'); ?>: <?= html_escape($row['qty']) ;?> &nbsp; <?= isset($row['sizes']['size_slug']) && !empty($row['sizes']['size_slug'])?lang('size').' : '.get_size($row['sizes']['size_slug'],$row['shop_id']):"" ;?></p>
					<p><?=  currency_position($row['price'],$row['shop_id']).' x '.html_escape($row['qty']) ;?> = <?=currency_position(($row['price']*$row['qty']),$row['shop_id']);?></p>

					<?php if(shop($shop_id)->is_tax==1 && $row['tax_fee']!=0): ?>
						<p class="tax_status"><?= tax($row['tax_fee'],$row['tax_status']);?></p>
					<?php endif ?>
				</div>

			</div>
			<div class="right_cart">
				<a href="javascript:;" data-id="<?= $row['rowid'] ;?>" class="remove_item"><i class="icofont-close-line"></i></a>
			</div>
		</div>
	</li>
<?php endif ?>
<?php endforeach ?>
