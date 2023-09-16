
<div class="row">
	<div class="col-md-7">
		<div class="orderDetailsInfo">
			<div class="form-group order-info-type">
				<h4 class="capital"><?= lang('order_type');?> : <span><?= $order_info->name;?></span></h4>
			</div>
			<?php if($order_info->slug=='cash-on-delivery'): ?>
			<div class="form-group dine-in-info">
				<label class="label bg-default-soft"><?= lang('shipping');?> : <?= !empty(temp('cod')->shipping_area)?single(temp('cod')->shipping_area,'delivery_area_list')->area:0;?> - <?= currency_position(@single(temp('cod')->shipping_area,'delivery_area_list')->cost,temp('shop_id'));?></label> 
				<label class="label bg-light-purple-soft mt-5"><?= lang('shipping_address');?> : <?= !empty(temp('cod')->address)?temp('cod')->address:0;?></label>
			</div>
			<?php endif; ?>


			<?php if($order_info->slug=='dine-in'): ?>
			<div class="form-group dine-in-info">
				<label class="label bg-default-soft mr-5"><?= lang('table_no');?> : <?= !empty(temp('dine-in')->temp_table_no)?single(temp('dine-in')->temp_table_no,'table_list')->name:0;?></label> 
				<label class="label bg-light-purple-soft"><?= lang('total_person');?> : <?= !empty(temp('dine-in')->temp_person)?temp('dine-in')->temp_person:0;?></label>
			</div>
			<?php endif; ?>

			<?php if($order_info->slug=='pickup'): ?>
				<div class="form-group dine-in-info">
					<label class="label bg-default-soft"><?= lang('pickup_area');?> : <?= !empty(temp('pickup')->pickup_area)?temp('pickup')->pickup_area:'';?></label>
					<div class="mt-5">
						<label class="label bg-default-soft mr-5"><?= lang('pickup_date');?> : <?= !empty(temp('pickup')->pickup_date)?full_date(temp('pickup')->pickup_date):'';?></label>
						<label class="label bg-light-purple-soft"><?= lang('pickup_time');?> : <?= !empty(temp('pickup')->pickup_time)?slot_time_format(temp('pickup')->pickup_time,temp('shop_id')):'';?></label>
					</div>
				</div>
			<?php endif; ?>

			<?php if($order_info->slug=='room-service'): ?>
				<div class="form-group dine-in-info">
					<label class="label bg-default-soft"><?= lang('hotel_name');?> : <?= !empty(temp('room')->hotel_id)?single(temp('room')->hotel_id,'hotel_list')->hotel_name:'';?></label>
					<div class="mt-5">
						<label class="label bg-light-purple-soft"><?= lang('room_number');?> : <?= !empty(temp('room')->room_number)?temp('room')->room_number:'';?></label> 
					</div>
				</div>
			<?php endif; ?>

		</div>
		<div class="orderDetailsLeftModal">
			<div class="form-group">
				<label for=""><?= lang('received_amount');?></label>
				<div class="input-group">
					<input type="text" name="received_amount" class="form-control receivedAmount number" value="">
					<span class="input-group-addon"><?= $shop_info->icon ;?></span>
				</div>
			</div>

			<div class="form-group">
				<label for=""><?= lang('paying_amount');?></label>
				<div class="input-group">
					<input type="text" name="paying_amount" class="form-control paying_amount" value="<?=isset($p->grand_total)?$p->grand_total:0;?>"  onblur="this.setAttribute('readonly','readonly');" required readonly>
					<span class="input-group-addon"><?= $shop_info->icon ;?></span>
				</div>
			</div>

			<div class="form-group">
				<label ><?= lang('change_return');?></label>
				<h4><span class="changeReturn">0</span></h4>
			</div>

			<div class="form-group">
				<label for=""><?= lang('payment_type');?></label>
				<select name="payment_type" class="form-control">
					<option value="cash"><?= lang('cash');?></option>
					<option value="cheques"><?= lang('cheques');?></option>
					<option value="bank_transfer"><?= lang('bank_transfer');?></option>
					<option value="pos"><?= lang('pos');?></option>
					<option value="others"><?= lang('others');?></option>
				</select>
			</div>


			<div class="form-group">
				<label for=""><?= lang('payment_notes');?></label>
				<textarea name="payment_notes" id="payment_note" class="form-control" cols="5" rows="5"></textarea>
			</div>

			<div class="form-group">
				<label for=""><?= lang('sell_notes');?></label>
				<textarea name="sell_notes" id="sell_notes" class="form-control" cols="5" rows="5"></textarea>
			</div>
			
		</div>
	</div><!-- col-6 -->
	<div class="col-md-5">
		<div class="orderDetailsRightModal">
			<ul>
				<li><span><?= lang('total_items');?></span> <span><?= $this->cart->total_items();?></span></li>
				<li><span><?= lang('sub_total');?></span> <span><?= isset($p->subtotal)?currency_position($p->subtotal,$shopId):0;?></span></li>
				<li><span><?= lang('tax');?></span> <span><?= isset($p->tax)?currency_position($p->tax,$shopId):0;?></span></li>
				<li><span><?= lang('discount');?></span> <span><?= isset($p->discount)?currency_position($p->discount,$shopId):0;?></span></li>
				<li><span><?= lang('coupon_discount');?></span> <span><?= isset($p->coupon_discount)?currency_position($p->coupon_discount,$shopId):0;?></span></li>
				<?php if(temp('is_cod')==TRUE): ?>
					<li><span><?= lang('shipping');?></span> <span><?= !empty(temp('cod')->shipping_area)?currency_position(@single(temp('cod')->shipping_area,'delivery_area_list')->cost,$shopId):$p->shipping;?></span></li>
				<?php else: ?>
					<li><span><?= lang('shipping');?></span> <span><?= isset($p->shipping)?currency_position($p->shipping,$shopId):0;?></span></li>
				<?php endif ?>
				
				<li><span><?= lang('paying_amount');?></span> <span><?= isset($p->grand_total)?currency_position($p->grand_total,$shopId):0;?></span></li>
			</ul>
		</div>
	</div>
</div>
<div class="row mt-20">
	<div class="col-md-6">
		<label class="custom-checkbox <?= !empty(pos_config($shopId)->is_live_order) && pos_config($shopId)->is_live_order==1?"text-mute":"";?>"><input type="checkbox" name="is_live_order" value="1" <?= !empty(pos_config($shopId)->is_live_order) && pos_config($shopId)->is_live_order==1?"checked onclick='return false'":"";?> > Goes To live Order</label>
	</div>
	<?php if(!empty(pos_config($shopId)->is_completed) && pos_config($shopId)->is_completed==1): ?>
		<div class="col-md-6">
			<label class="custom-checkbox "><input type="checkbox" name="is_completed" value="1"> <?= lang('mark_as_completed');?></label>
		</div>
	<?php endif ?>

</div>
