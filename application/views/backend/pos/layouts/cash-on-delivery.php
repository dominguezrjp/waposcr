<div class="cod">
	<?php if($shop_info->is_area_delivery==1 && $shop_info->is_radius==0): ?>
		<div class="row">
			<div class="col-md-12">
				<div class="slots_area mb-20">
					<?php foreach (delivery_area($shop_id) as $key => $area): ?>
						<label class="singleSlots"> 
							<input type="radio" name="shipping_area" data-cost="<?= $area['cost'] ;?>" data-id="<?= $area['id'] ;?>" value="<?= $area['id'] ;?>" class="activeSlot"><?= $area['area'].' - '.currency_position($area['cost'],$shop_id) ;?>
						</label>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="form-group col-md-12">
			<textarea name="shipping_address" id="address" cols="5" rows="5" class="form-control shippingAddress" placeholder="<?= !empty(lang('shipping_address'))?lang('shipping_address'):'shipping address' ;?> *"><?= !empty(customer()->address)?customer()->address:'';?></textarea>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<input type="text" name="delivery_area" class="form-control" value="<?= !empty(auth('gmap_link'))?auth('gmap_link'):"" ;?>" placeholder="<?= !empty(lang('google_map_link'))?lang('google_map_link'):'Google map link' ;?>">
			</div>
		</div>
	</div>

	<div class="row nextbtnArea <?= !empty(customer()->customer_name)?"":"dis_none";?>">
		<div class="col-md-12 text-right">
			<a href="javascript:;" class="btn btn-secondary nextBtn"><?= lang('submit');?> <i class="icofont-thin-double-right"></i></a>
		</div>
	</div>
</div>

