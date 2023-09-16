<?php $shop_id = 0; ?>

<div class="col-md-12">
	<div class="paymentOrder">
		<ul class="paymentUl">
			<?php $i=1; foreach ($this->cart->contents() as $key => $row): ?>
			<?php $shop_id = $row['shop_id']; ?>
			<li>
				<div class="">
					<span><?= html_escape($row['qty']);?></span> x <span><?= html_escape($row['name']) ;?> <?= isset($row['sizes']['size_slug']) && !empty($row['sizes']['size_slug'])?lang('size').' : '.get_size($row['sizes']['size_slug'],$row['shop_id']):"" ;?>
				</span>
			</div>
			<div class="sizes">
				<span class="extrasTitleCard">
					<?php if(isset($row['is_extras']) && $row['is_extras']==1 && !empty($row['extra_id'])): ?>
						<?php foreach (json_decode($row['extra_id'],true) as $ex):?>
							<?php echo $extras_name =  rtrim('+'.$this->common_m->get_extras_name($ex,$row['item_id']).'+','+'); ?>
						<?php endforeach ?>
					<?php endif; ?>
				</span>
			</div>
			<div class="">
				<span><?=$this->cart->format_number($row['subtotal']) ;?> <?= shop($shop_id)->icon ;?></span>
			</div>
		</li>
		<?php $i++; endforeach; ?>
		<?php $shop_info = $this->common_m->shop_info($shop_id); ?>

	</ul>
	<ul class="paymentSummary">
		<li>
			<div class="pleft">
				<?= lang('sub_total'); ?>
			</div>
			<div class="pright">
				<?= number_format($this->cart->total(),2) ;?> </span> <?= shop($shop_id)->icon;?>
			</div>
		</li>

		<li>
			<div class="pleft">
				<?= lang('shipping'); ?>
			</div>
			<div class="pright">
				<?php if($shop_info['delivery_charge_in']!=0): ?>

					<p> <span class="d_charge"><?= $shop_info['delivery_charge_in'];?> <?= shop($shop_id)->icon;?></span></p>
				<?php else: ?>
					<p> <span class="d_charge"><?= !empty(lang('Free'))?lang('Free'):'Free' ;?></span></p>
				<?php endif; ?>
			</div>
		</li>

		<li>
			<div class="pleft">
				<?= lang('tax'); ?>
			</div>
			<div class="pright">
				<p> <span class="d_charge"><?= get_percent($this->cart->total(),$payment['tax_fee']);?> <?= shop($shop_id)->icon;?></span></p>
			</div>
		</li>

		<li>
			<div class="pleft">
				<?= lang('discount'); ?>
			</div>
			<div class="pright">
				<p> <span class="d_charge"><?= get_percent($this->cart->total(),$payment['discount']);?> <?= shop($shop_id)->icon;?></span></p>
			</div>
		</li>
		<li class="pt-7 bb-top">
			<div class="pleft">
				<strong><?= lang('total'); ?></strong>
			</div>
			<div class="pright">
				<?= $total_amount;?> </span> <?= shop($shop_id)->icon;?>
			</div>
		</li>
	</ul>

	</div>
</div>