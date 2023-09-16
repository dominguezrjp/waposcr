 <div class="modal-header">
 	<h5 class="modal-title" id="exampleModalLongTitle"><?= !empty(lang('order_form'))?lang('order_form'):'Order Form' ;?></h5>
 	
 </div>
 <form action="<?= base_url('profile/add_order/') ;?>" method="post" class="order_form" autocomplete="off">
 	<!-- csrf token -->
 	   <?= csrf(); ?>
 	<div class="modal-body">
 		<div class="cartItemDetails">
	 		<div class="order_page">
	 			<div class="row">
	 				<?php $shop_id = 0; ?>
	 				<?php $i=1; foreach ($this->cart->contents() as $key => $row): ?>
	 				<?php $shop_id = $row['shop_id']; ?>
	 				<div class="col-md-6" id="hide_item_<?= $row['rowid'] ;?>">
	 					<div class="single_item_cart order_list">
	 						<div class="left_cart">
	 							<img src="<?= get_img($row['thumb'],$row['img_url'],$row['img_type']) ;?>" alt="">
	 							<div class="single_cart_item_details">
	 								<h4><?= html_escape($row['name']) ;?> <span class="extrasTitleCard"><?= isset($row['is_extras']) && $row['is_extras']==1?'+ '. rtrim(str_replace(',', ' + ', $row['extra_name']),'+'):"" ;?></span></h4>
	 								<div class="order_qty"><span><?= !empty(lang('qty'))?lang('qty'):'Qty' ;?>:</span>  
	 									<div class="incress_area">
	 										<span class="value-button minus" data-id="<?= $row['rowid'] ;?>" value="Decrease Value"><i class="icofont-minus"></i></span>

	 										<span class="cart_qty_field"><input readonly type="number" id="qty_<?= $row['rowid'] ;?>" class="qty" value="<?= $row['qty'] ;?>" min-value='1' /></span>

	 										<span class="value-button add" data-id="<?= $row['rowid'] ;?>"  value="Increase Value"><i class="icofont-plus"></i></span>
	 									</div>  
	 									&nbsp; <span class="sizeTitle"><?= isset($row['sizes']['title']) && !empty($row['sizes']['title'])?lang('size').' : '.get_size($row['sizes']['size_slug'],$row['shop_id']):"" ;?></span>
	 								</div>
	 								<p class="price_qty_area"><?= shop($shop_id)->icon ;?><?=  '<span class="item_price">'.$this->cart->format_number($row['price']).' </span> x <span class="total_qty"> '.html_escape($row['qty']).'</span>' ;?> = <?= shop($shop_id)->icon ;?> <span class="total_qty_price"> <?=$this->cart->format_number($row['subtotal']) ;?></span></p>
	 							</div>
	 						</div>
	 						<div class="right_cart">
	 							<a href="javascript:;" data-id="<?= $row['rowid'] ;?>" class="remove_item"><i class="icofont-close-line"></i></a>
	 						</div>
	 					</div>
	 				</div>
	 				
	 				<?php $i++; endforeach; ?>
	 				<div class="col-md-12 total_sum_area">
	 					<?php $shop_info = $this->common_m->shop_info($shop_id); ?>
	 					<div class="total_sum">
	 						<div class="upperSum">
	 							<p><?=  !empty(lang('qty'))?lang('qty'):'Qty';?> : <span class="cart_count"><?= $this->cart->total_items() ;?></span></p>
	 							<p><?= !empty(lang('price'))?lang('price'):'price' ;?> : <span class="total_price"><?= number_format($this->cart->total(),2) ;?> </span> <?= shop($shop_id)->icon;?></p>

	 							<div class="dis_none show_address">
			 						<?php if($shop_info['delivery_charge_in']!=0): ?>
			 							<p><?= !empty(lang('delivery_charge'))?lang('delivery_charge'):'delivery charge' ;?> : <span class="d_charge"><?= $shop_info['delivery_charge_in'];?> <?= shop($shop_id)->icon;?></span></p>
			 						<?php else: ?>
			 							<p><?= !empty(lang('delivery_charge'))?lang('delivery_charge'):'delivery_charge' ;?> : <span class="d_charge"><?= !empty(lang('Free'))?lang('Free'):'Free' ;?></span></p>
			 						<?php endif; ?>
		 						</div>
	 						</div>
	 						<h4 class="dis_none show_address"><?= !empty(lang('total'))?lang('total'):'total' ;?> :  <span class=""> <?= number_format($this->cart->total()+$shop_info['delivery_charge_in'],2);?> </span> <?= shop($shop_id)->icon;?></h4>

	 						<h4 class="show_price"><?= !empty(lang('total'))?lang('total'):'total' ;?> :  <span class=""> <?= number_format($this->cart->total(),2);?> </span> <?= shop($shop_id)->icon;?></h4>
	 						
	 					</div>
	 				</div>
	 			</div>
	 			<div class="order_input_area">
	 				<span class="reg_msg"></span>
	 				<div class="row">
	 					<div class="form-group col-md-6">
	 						<label ><?= !empty(lang('full_name'))?lang('full_name'):'full name' ;?> <span class="error">*</span></label>
	 						<input type="text" name="name" class="form-control" placeholder="<?= !empty(lang('full_name'))?lang('full_name'):'full name' ;?>">
	 					</div>
	 					<div class="form-group col-md-6">
	 						<label ><?= !empty(lang('email'))?lang('email'):'email' ;?></label>
	 						<input type="email" name="email" class="form-control" placeholder="<?= !empty(lang('email'))?lang('email'):'email' ;?>">
	 					</div>
	 				</div>
	 				<div class="row">

	 					<div class="form-group col-md-6">
	 						<label><?= !empty(lang('phone'))?lang('phone'):'phone' ;?> <span class="error">*</span></label>
	 						<input type="tel" name="phone" class="form-control" placeholder="<?= !empty(lang('phone'))?lang('phone'):'phone' ;?>">
	 					</div>

	 					<div class="form-group col-md-6">
	 						<label><?= !empty(lang('order_type'))?lang('order_type'):'order type' ;?> <span class="error">*</span></label>

	 						<?php $order_type =  $this->admin_m->get_users_order_types_by_shop_id($shop_id); ?>

	 						<select name="order_type" class="form-control order_type">
	 							<option value=""><?= !empty(lang('select_order_type'))?lang('select_order_type'):'select order type' ;?></option>

	 							<?php foreach ($order_type as $key => $types): ?>
	 								<?php if(LICENSE != MY_LICENSE && $types['slug']=='pay-in-cash'): ?>
		 								
		 							<?php else: ?>
		 								<option value="<?=  $types['type_id'];?>" data-slug="<?=  $types['slug'];?>"><?=  $types['type_name'];?></option>
		 							<?php endif; ?>
	 							<?php endforeach ?>
	 						</select>
	 					</div>
	 				</div>
	 				<div class="order_type_body dis_none">
	 					<div class="row">
	 						<div class="form-group col-md-6 booking dis_none">
	 							<label ><?= !empty(lang('person'))?lang('person'):'Person' ;?> <span class="error">*</span></label>
	 							<select name="total_person" class="form-control" id="">
	 								<option value=""><?= !empty(lang('select_person'))?lang('select_person'):'select person' ;?></option>
	 								<?php for ($i=1; $i < 10 ; $i++) { ?>
	 									<option value="<?=  $i;?>"><?=  $i;?></option>
	 								<?php } ?>
	 							</select>
	 						</div>
	 						<div class="form-group col-md-6 col-6">
	 							<label><?= !empty(lang('booking_date'))?lang('booking_date'):'Booking date' ;?> <span class="error">*</span></label>
	 							<div class="input-group date flatpickr" id="datetimepicker1" data-target-input="nearest">
									<input type="text" name="reservation_date" class="form-control datetimepicker" data-target="#datetimepicker1" data-input/>
									<div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
	 						</div>
	 					</div> 
	 				</div>


	 				<div class="pickup dis_none">
	 					<?php $time =$this->common_m->get_single_appoinment(date('w'),$shop_id); ?>
	 					<?php $pickup_area =$this->common_m->get_pickup_area($shop_id); ?>
	 					<div class="row">
	 						<div class="col-md-12">
	 							<label class=""><?= lang('select_pickup_area'); ?>
	 							<?php if(shop($shop_id)->is_gmap == 1): ?>
	 								 <a href="javascript:;" class="checkmap"><?= lang('show_map'); ?></a>
	 							<?php endif;?>
	 							</label>
	 							<div class="pickup_area_list">
	 								<?php foreach ($pickup_area as $key => $area): ?>
		 								<label class="single_pickup_area" id="active_point_<?= $area['id'] ;?>" data-id="<?=  $area['id'];?>" data-toggle="tooltip" title="<?= $area['address'] ;?>"><?= $area['name'] ;?></label>
		 							<?php endforeach ?>
		 							<input type="hidden" name="pickup_point_id" class="add_pickpoint_value" value="">
	 							</div>
	 						</div>
	 						<?php if(isset($time) && !empty($time)): ?>
		 						<div class="form-group col-md-6 col-12 mt-10">
		 							<label><?= !empty(lang('pickup_time'))?lang('pickup_time'):'pickup time' ;?> <span class="error">*</span></label>
		 							<div class="input-group date flatpickr" id="datetimepicker2" data-target-input="nearest">
										<input type="text" name="pickup_time" class="form-control timepicker" data-target="#datetimepicker2" data-input/>
										<div class="input-group-append" data-target="#datetimepicker2" data-toggle="timepicker">
											<div class="input-group-text"><i class="fa fa-clock-o"></i></div>
										</div>
									</div>
		 						</div>
	 						<?php else: ?>
	 							<div class="form-group col-md-6 col-12 mt-10">
	 								<label><?= !empty(lang('pickup_time'))?lang('pickup_time'):'pickup time' ;?> <span class="error">*</span></label>
	 								<div class="pickup_up" >
	 									<h4><?= lang('pickup_time_alert'); ?></h4>
	 								</div>
	 							</div>
	 						<?php endif; ?>
	 					</div> 
	 				</div>

	 				<!-- dine in -->
	 				<div class="dineInsection">
	 					<div class="dinein mb-10 dis_none">
	 						<?php $dinein =$this->common_m->get_table_list($shop_id); ?>
	 						<div class="row">
	 							<div class="col-md-6">
	 								<div class="dineInList">
	 									<label for=""><?= lang('select_table'); ?></label>
	 									<select name="table_no" class="form-control" id="table_no">
	 										<option value=""><?= lang('select'); ?></option>
	 										<?php foreach ($dinein as $key => $dine): ?>
	 											<option value="<?= $dine['id'];?>" data-size="<?=  $dine['size'];?>"><?=  $dine['name'];?> - <?= $dine['area_name'];?></option>
	 										<?php endforeach ?>
	 									</select>
	 								</div>
	 							</div>

	 							<div class="col-md-6">
	 								<div class="table_person dis_none">
	 									<label for=""><?= lang('select_person'); ?></label>
	 									<select name="person" class="form-control" id="table_person">

	 									</select>
	 								</div>
	 							</div>

	 						</div> 
	 					</div>
	 				</div>
	 				<!-- dine in -->

	 				<div class="dis_none show_address">
	 					<div class="row">
	 						<div class="form-group col-md-12">
		 						<textarea name="address" id="" cols="5" rows="5" class="form-control" placeholder="<?= !empty(lang('address'))?lang('address'):'address' ;?> *"></textarea>
		 					</div>
	 					</div>
	 				</div>
	 			</div>
	 		</div>

	 		<div class="modal-footer">
	 			<input type="hidden" name="is_payment" class="is_payment" value="0">
	 			<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= !empty(lang('close'))?lang('close'):'close' ;?></button>
	 			<button type="submit" class="btn btn-primary confirm_btn"><?= !empty(lang('confirm_oder'))?lang('confirm_oder'):'confirm oder' ;?></button>
	 		</div>
	 	</div>
	 	<div class="successMsgArea dis_none">
		 	<div class="successMsg">
		 		<div class="confirmMsgArea">
		 			<i class="fa fa-smile fa-2x"></i>
		 			<h4><?= !empty(lang('order_confirmed'))?lang('order_confirmed'):'order confirmed' ;?>.</h4>
		 			<h5> <?= !empty(lang('your_order_id'))?lang('your_order_id'):'your order id' ;?>: #<span class="order_id"></span></h5>
		 			<p><?= !empty(lang('track_your_order_using_phone'))?lang('track_your_order_using_phone'):'You can track you order using your phone number' ;?></p>
		 			<div class="qr_link">
		 				<img src="#" alt="" id="qr_link">
		 				<a href="javascript:;" download target="blank" data-link="" class="qrDownloadBtn" id="downloadLink" data-placement="top" data-toggle="tooltip" title="Download Qr for Quick access your order"><i class="fa fa-download"></i> <?= !empty(lang('download'))?lang('download'):'download' ;?></a>
		 				
		 			</div>

			 		<div class="whatsapp_share_data">
			 				
			 		</div>
			 		
		 		</div>
		 		<div class="">
		 			<a href="javascript:;" class="btn btn-success custom_btn ok_btn"><?= !empty(lang('ok'))?lang('ok'):'ok' ;?></a>
		 		</div>
		 	</div>
		</div>
 	</div>
 </form>
 <script type="text/javascript"  src="<?= base_url();?>assets/frontend/plugins/datetime_picker/datetime.js" ></script>
 <script>
 	 $('[data-toggle="tooltip"]').tooltip();
 </script>
 



 <div class="showGmap"></div>