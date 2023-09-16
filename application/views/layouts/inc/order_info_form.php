	
	<?php $shop_info = $this->common_m->shop_info($shop_id); ?>
	<?php $guest = isJson($shop_info['guest_config'])?json_decode($shop_info['guest_config']):''; ?>
	<?php $extra_config = extra_settings($shop_info['user_id']); ?>

	 <div class="step_1">
	  	<span class="reg_msg"></span>

	  		<?php  if(shop($shop_id)->is_customer_login==0):?>
			  	<div class="customerInfo">
			  		<div class="row">
			  			<div class="form-group col-md-6">
			  				<label for=""><?= lang('name'); ?> <span class="error">*</span></label>
			  				<input type="text" name="name" class="form-control" placeholder="<?= lang('name'); ?>">
			  			</div>
			  			<div class="form-group col-md-6">
			  				<label for=""><?= lang('phone'); ?> <i class="fa fa-info-circle" data-title="<?= lang('phone_with_international_format')?>" data-toggle="tooltip"></i> <span class="error">*</span> </label>
			  				<input type="text" name="phone" class="form-control remove_char only_number" data-char="+" placeholder="e.g. 1408XXXXXXX">
			  			</div>
			  			<?php  if(isset($shop_info['is_checkout_mail'])&& $shop_info['is_checkout_mail']==1):?>
			  				<div class="form-group col-md-6">
			  					<label for=""><?= lang('email'); ?> <span class="error">*</span></label>
			  					<input type="email" name="email" class="form-control" placeholder="<?= lang('email'); ?>">
			  				</div>
			  			<?php endif; ?>	
			  		</div>
			  	</div>
		  

		  	<?php if(isset($guest->is_guest_login) && $guest->is_guest_login==1): ?>
			  	<?php if(isset($guest->is_dine_in) && $guest->is_dine_in==1 && !empty(auth('is_table'))): ?>
			  		<div class="or"><?= lang('or');?></div>
			  		<div class="guestLoginArea">
			  			<div class="row">
			  				<div class="col-md-12">
			  					<label class="custom-checkbox w_100"><input type="checkbox" name="is_guest_login" value="1"><?= lang('login_as_guest');?></label>
			  				</div>
			  			</div>
			  		</div><!-- guestLoginArea -->
			  	<?php endif ?>
			  	<?php if(empty(auth('is_table'))): ?>
				  	<div class="payincash_guest dis_none">
				  		<div class="or"><?= lang('or');?></div>
				  		<div class="guestLoginArea">
				  			<div class="row">
				  				<div class="col-md-12">
				  					<label class="custom-checkbox w_100"><input type="checkbox" name="is_guest_login" value="1"><?= lang('login_as_guest');?></label>
				  				</div>
				  			</div>
				  		</div><!-- guestLoginArea -->
				  	</div>
			  	<?php endif; ?>
	  		<?php endif; ?>

	  	<?php endif;?> <!-- check customer login -->

	  	<div class="row">
	  		<div class="form-group col-md-6">
	  			<label><?= !empty(lang('order_type'))?lang('order_type'):'order type' ;?> <span class="error">*</span></label>

	  			<?php $order_type =  $this->admin_m->get_users_order_types_by_shop_id($shop_id); ?>

	  			<select name="order_type" id="order_type_list" class="form-control order_type <?= !empty(auth('is_table'))?"pointerEvent":"";?>" data-id="<?=$shop_id ;?>">
	  				<option value=""><?= !empty(lang('select_order_type'))?lang('select_order_type'):'select order type' ;?></option>

	  				<?php foreach ($order_type as $key => $types): ?>
	  					<option value="<?=  $types['type_id'];?>" data-radius="<?= isset($shop_info['is_radius'])?$shop_info['is_radius']:0;?>" data-required="<?= $types['is_required'];?>"  data-pay="<?= $types['is_payment'];?>" data-slug="<?=  $types['slug'];?>" <?= !empty(auth('is_table'))&& $types['slug']=="dine-in"?"selected":"";?>><?= !empty(lang($types['slug']))?lang($types['slug']):$types['type_name'];?></option>
	  				<?php endforeach ?>
	  			</select>
	  		</div>
	  		<div class="notfound col-md-12 dis_none ">
	  			<div class="showNotfoundMsg"></div>
	  		</div>
	  		<div class="priceEmpty col-md-12 dis_none ">
	  			<div class="priceCheck ">
	  				<h4><?= lang('minimum_price_msg_for_cod'); ?></h4>
	  				<p><?= lang('minimum_price'); ?> : <b><?= $shop_info['min_order'] ;?> 	<?=  shop($shop_id)->icon;?></b></p>
	  			</div>
	  		</div>
	    </div><!-- row -->
	    <div class="order_type_body dis_none">
			<div class="row">
				<div class="form-group col-md-6 booking dis_none">
					<label ><?= !empty(lang('person'))?lang('person'):'Person' ;?> <span class="error">*</span></label>
					<input type="number" name="total_person" class="form-control only_number" min="1" value="1">
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
		</div><!-- order_type_body -->

		<div class="pickup dis_none">
			<?php $time =$this->common_m->get_single_appoinment(date('w'),$shop_id); ?>
			<?php $pickup_area =$this->common_m->get_pickup_area($shop_id); ?>
			<div class="row">
				<div class="col-md-12">
					<label class=""><?= lang('select_pickup_area'); ?>
					<?php if(shop($shop_id)->is_gmap == 1 || shop($shop_id)->is_admin_gmap==1): ?>
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
				
				<div class="form-group col-md-6 col-6 mt-20">
					<label><?= !empty(lang('pickup_date'))?lang('pickup_date'):'Pickup date' ;?> <span class="error">*</span></label>
					<div class="pickupCheckDate mt-5 mb-10">
						<label class="badge  custom-radio-2"><input type="radio" class="pickup_date_checker" name="today" data-id="<?= $shop_id;?>" value="1" checked><?= lang('today'); ?></label>
						<label class="badge ml-10 custom-radio-2"><input type="radio" class="pickup_date_checker" name="today" data-id="<?= $shop_id;?>" value="2"><?= lang('others'); ?></label>
					</div>
					<div class="pickupTime" style="display: none;">
						
						<div class="input-group date flatpickr" id="datepicker" data-target-input="nearest">
							<input type="text" name="pickup_date" class="form-control datepicker-1" data-target="#datepicker" data-input/>
							<div class="input-group-append" data-target="#datepicker" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>
				</div>

				<!-- pickup time slots -->
				<div class="form-group col-md-12 col-lg-12 col-12 mt-5">
					<div class="pickupTimeSlots null">
						<i class="fa fa-spinner fa-spin"></i>
					</div>
				</div>
				<!-- pickup time slots -->

				<?php else: ?>
				<div class="form-group col-md-6 col-12 mt-10">
					<label><?= !empty(lang('pickup_time'))?lang('pickup_time'):'pickup time' ;?> <span class="error">*</span></label>
					<div class="pickup_up" >
						<h4><?= lang('pickup_time_alert'); ?></h4>
					</div>
				</div>
				<?php endif; ?>
				
			</div> 
		</div><!-- order_type_body -->

	</div><!-- step_1 -->
	<div class="step_2">
		<!-- dine in -->
		<div class="dineInsection">
			<div class="dinein mb-10 dis_none">
				<?php $dinein =$this->common_m->get_table_list($shop_id); ?>
				<div class="row">
					<div class="col-md-6">
						<div class="dineInList">
							<label for=""><?= lang('select_table'); ?></label>
							<?php if(!empty(auth('table_no'))): ?>
								<select name="table_no" class="form-control table_no" id="table_no_1" data-id="<?= $shop_id;?>">
									<?php foreach ($dinein as $key => $dine): ?>
										<?php if(!empty(auth('table_no')) && auth('table_no')==$dine['id']): ?>
											<option value="<?= $dine['id'];?>" data-size="<?=  $dine['size'];?>" <?= !empty(auth('table_no')) && auth('table_no')==$dine['id']?"selected":"";?>><?=  $dine['name'];?> / <?= $dine['area_name'];?> - <?= $dine['size'].' '.lang('person');?> </option>
										<?php endif ?>
									<?php endforeach ?>
								</select>
							<?php else: ?>
								<select name="table_no" class="form-control table_no" id="table_no" data-id="<?= $shop_id;?>">
									<option value=""><?= lang('select'); ?></option>
									<?php foreach ($dinein as $key => $dine): ?>
										<option value="<?= $dine['id'];?>" data-size="<?=  $dine['size'];?>" <?= !empty(auth('table_no')) && auth('table_no')==$dine['id']?"selected":"";?>><?=  $dine['name'];?> / <?= $dine['area_name'];?> - <?= $dine['size'].' '.lang('person');?> </option>
									<?php endforeach ?>
								</select>
							<?php endif ?>
							
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
		<div class="dis_none hidePay-in-cash show_address">
			<?php if($shop_info['is_area_delivery']==1 && $shop_info['is_radius']==0): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="slots_area mb-20">
							<?php foreach (delivery_area($shop_id) as $key => $area): ?>
								<label class="single_slots"> 
									<input type="radio" name="shipping_area" data-cost="<?= $area['cost'] ;?>" data-id="<?= $area['id'] ;?>" value="<?= $area['id'] ;?>" class="shippingArea"><?= $area['area'].' - '.currency_position($area['cost'],$shop_id) ;?>
								</label>
							<?php endforeach ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<div class="row">
				<div class="form-group col-md-12">
					<input type="hidden" name="customer_phone" class="customer_phone" value="<?= !empty(auth('customer_phone'))?auth('customer_phone'):"" ;?>">
					<textarea name="address"  cols="5" rows="5" id="address_guest" class="form-control shippingAddress" placeholder="<?= !empty(lang('shipping_address'))?lang('shipping_address'):'shipping address' ;?> *"><?= !empty(auth('customer_address'))?auth('customer_address'):"" ;?></textarea>
				</div>

				<div class="form-group col-md-12">
					<?php if(shop($shop_id)->is_gmap == 1 || shop($shop_id)->is_admin_gmap==1): ?>
						<div class="gmapLink" id="locator-input-section">
							<select id="editable-select" name="delivery_area" id="delivery_area" class="form-control gmap_link autocomplete" placeholder="<?= !empty(lang('google_map_link'))?lang('google_map_link'):'Google map link' ;?>">
								<?php if(!empty(auth('gmap_link'))): ?>
									<option><?= !empty(auth('gmap_link'))?auth('gmap_link'):"" ;?></option>
								<?php endif ?>
								<option value=""></option>
							</select>
							<i class="fa fa-dot-circle" id="locator-button" data-toggle="tooltip" title="<?= lang('get_google_location');?>"></i>
						</div>
					<?php else: ?>
						<input type="text" name="delivery_area" class="form-control" value="<?= !empty(auth('gmap_link'))?auth('gmap_link'):"" ;?>" placeholder="<?= !empty(lang('google_map_link'))?lang('google_map_link'):'Google map link' ;?>">
					<?php endif ?>
				</div>
				
			</div><!-- row -->

		
			<div class="changeInfo dis_none">
				<div class="row mt-10">
					<div class="form-group col-md-6">
						<label class="custom-checkbox"><b><input type="checkbox" name="is_change" class="is_change"  value="1"> <?= lang('i_need_change');?></b></label>
						<div class="change_field mt-10 dis_none">
							<input type="text" name="change_amount" id="" class="form-control" placeholder="<?= lang('change');?>">
						</div>
					</div>
				</div>
			</div><!-- changeInfo -->

			

		</div><!-- show_address -->
		<div class="room_service dis_none">
			<div class="row">
				<div class="form-group col-md-12">
					<div class="room_services mb-10">
						<?php $hotel_list =$this->common_m->get_my_hotel($shop_id); ?>
						<div class="row">
							<div class="col-md-6">
								<div class="hotelName">
									<label for=""><?= lang('select'); ?></label>
									<select name="hotel_id" class="form-control hotel_name" id="hotel_name">
										<option value=""><?= lang('select'); ?></option>
										<?php foreach ($hotel_list as $key => $hotel): ?>
											<option value="<?= $hotel['id'];?>"><?=  $hotel['hotel_name'];?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>

							<div class="col-md-12">
								<div class="roomNumbers">
									
								</div>
							</div>

						</div> 
					</div>
				</div>
			</div>
		</div>

			<!-- room service -->

		

		<div class="couponArea" style="display:none;">
			<a href="javascript:;" class="couponBtn"><?= lang('do_you_have_coupon'); ?></a>
			<div class="couponField" style="display:none;">
				<div class="couponInput-group">
					<div class="couponFields">
						<input type="text" name="coupon_code" class="form-control coupon_code" placeholder="<?= lang('coupon_code');?>">
						<a href="javascript:;" class="text-danger couponClose"><i class="fa fa-close"></i></a>
					</div>
					<input type="hidden" name="shop_id"  class="shop_id" value="<?= $shop_id ;?>">
					<input type="hidden" name="all_price" class="all_price"  value="<?= $this->cart->total();?>">
					<input type="hidden" name="is_coupon" class="form-control is_coupon" value="0">
					<input type="hidden" name="coupon_percent" class="form-control coupon_percent" value="0">
					<input type="hidden" name="coupon_id" class="form-control coupon_id" value="0">
					<input type="hidden" name="shipping_cost" class="form-control shipping_cost" value="0">
					<input type="hidden" name="last_order_type" class="form-control last_order_type" value="0">
					<button type="button" class="btn btn-secondary couponFormBtn"><?= lang('apply'); ?></button>
				</div>
			</div>
		</div>

		<?php $tips_config = tips_config($shop_id); ?>
		<?php if(isset($tips_config->is_tips) && $tips_config->is_tips==1): ?>
			<div class="tipsSection">
				<div class="row mt-10">
					<div class="form-group col-md-12">
						<div class="tipsArea">
							<p><?= lang('tips');?></p>
							<div class="tipsHeader">
								<ul>
									<?php if(sizeof($tips_config->tips_field_config) > 0): ?>
										<?php foreach ($tips_config->tips_field_config as $tipsValue): ?>
											<?php if(!empty($tipsValue->tips)): ?>
												<li>
													<label class="tipsLabel">
														<span><?= $tipsValue->tips;?>%</span>
														<input type="radio" name="tips_btn" value="<?= get_percent($this->cart->total(),5);?>">
													</label>
												</li>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endif; ?>
									<li>
										<label class="tipsLabel">
											<span><?= lang('others');?></span>
											<input type="radio" name="tips_btn" value="0">
										</label>
									</li>
								</ul>
							</div>
							<div class="tipsFieldArea dis_none">
								<div class="tipsfields">
									<input type="text" name="tips" class="form-control number" value="">
									<button type="button" class="btn btn-secondary addTips"> <?= lang('add_tip');?> </button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- tipsSection -->
		<?php endif; ?>

		<?php if(is_feature($shop_info['user_id'],'online-payment')==1 && is_active($shop_info['user_id'],'online-payment') && overlay==1): ?>		
			<div class="makePayment <?= is_package;?>" style="display:none;">
				<div class="form-group">
					<div class="">
						<label class="custom-radio-2 f-color mr-5 pay_now"><input type="radio" name="use_payment" value="1"> <b><?= lang('pay_now');?></b></label> &nbsp;

						<label class="custom-radio-2 f-color pay_later"><input type="radio" name="use_payment" value="0" checked> <b><?= lang('pay_later');?></b></label>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
	<div class="row">
		<div class="col-md-12">
			<textarea name="comments" id="comments" class="form-control" cols="5" rows="5" placeholder="<?= lang('comments'); ?>"></textarea>
		</div>
	</div>
	<?php $order_merge_config = @!empty($shop_info['order_merge_config'])?json_decode($shop_info['order_merge_config']):''; ?>
	<?php if(isset($order_merge_config->is_order_merge) && $order_merge_config->is_order_merge==1): ?>
		<div class="mergeArea" style="display:none;">
			<div class="row">
				<div class="col-md-12 mt-10 mb-5">
					<div class="mergeArealist">
						<div class="mt-5 previousOrderDetails mb-5"></div>
						<?php if(isset($order_merge_config->is_system) && $order_merge_config->is_system==1): ?>
							<input type="checkbox" name="is_merge" value="1" checked>
						<?php else: ?>
							<label class="custom-checkbox f-color mr-10"> <input type="checkbox" name="is_merge" value="1"><?= lang('merge_with_previous_order');?></label>
							<label class="custom-checkbox f-color"> <input type="checkbox" name="is_merge" value="0"><?= lang('make_it_as_single_order');?></label>
						<?php endif ?>
						
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

<div class="modal-footer">


	<input type="hidden" name="get_price" class="getPrice" value="<?= $this->cart->total() ;?>">
	<input type="hidden" name="minPrice" class="minPrice" value="<?=  isset($shop_info['min_order'])?$shop_info['min_order']:0;?>">

	<input type="hidden" name="is_payment" class="is_payment" value="0">
	<div class="checkoutBtnList">
		<?php if(isset($extra_config['terms']) && !empty(json_decode($extra_config['terms']))): ?>
		<label class="pointer custom-checkbox"> <input type="checkbox" name="terms" value="1"> <?= lang('read_terms'); ?> <a href="#termsModal" data-toggle="modal">  <?= lang('terms_condition'); ?></a> <?= lang('accept_them'); ?></label>
	<?php endif; ?>
		<button type="submit" class="btn btn-primary confirm_btn" <?= isset($extra_config['terms']) && !empty(json_decode($extra_config['terms']))?"disabled":"";?>> <i class="icofont-check-circled checkIcon"></i> <?= !empty(lang('confirm_oder'))?lang('confirm_oder'):'confirm oder' ;?></button>
	</div>
</div><!-- modal-footer -->


<script>
	$(document).on('change','[name="terms"]',function(){
		if ($(this).is(':checked')) {
			$('.confirm_btn').prop('disabled',false);
			$('.checkIcon').css('visibility','visible');
		}else{
			$('.confirm_btn').prop('disabled',true);
			$('.checkIcon').css('visibility','hidden');
		}
	});
</script>


<?php if(isset($extra_config['terms']) && !empty($extra_config['terms'])): ?>
<div class="modal fade" id="termsModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class=""><?= lang('terms_condition');?></h3>
			</div>
			<div class="modal-body">
				<p><?= json_decode($extra_config['terms']);?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('ok');?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif ?>