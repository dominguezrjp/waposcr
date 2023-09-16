<!-- 
	Shipping Modal
 -->
 <div id="shippingModal" class="modal fade discountModal" role="dialog" data-backdrop="static" data-keyboard="false">
 	<div class="modal-dialog modal-sm">

 		<form action="<?= base_url('admin/pos/set_shipping'); ?>" method="post" class="setDiscount validForm">
 			<?= csrf();?>
 			<!-- Modal content-->
 			<div class="modal-content">
 				<div class="modal-header">
 					<button type="button" class="close" data-dismiss="modal">&times;</button>
 					<h4 class="modal-title"><?= lang('shipping_charge'); ?></h4>
 				</div>
 				<div class="modal-body custom-fields">
 					<div class="errorMsg"></div>
 					<div class="row">
 						<div class="form-group col-md-12">
 							<div class="input-group">
 								<input type="text" name="shipping" class="form-control" placeholder="<?= lang('shipping_charge');?>" value="<?= isset($shipping)?$shipping:"";?>" min-value="0" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' >
 									<span class="input-group-addon"><?= restaurant()->icon;?></span>
 								</div>
 							</div>
 						</div><!-- row -->


 					</div>
 					<div class="modal-footer">
 						<button type="submit" class="btn btn-success"><?= lang('submit'); ?> <i class="icofont-thin-double-right"></i></button>
 					</div>
 				</div>
 			</form>
 		</div>
 	</div>
 <!-- 
	Shipping Modal
 --> 


 <!-- 
	Discount Modal
 -->
 <div id="discountModal" class="modal fade discountModal" role="dialog" data-backdrop="static" data-keyboard="false">
 	<div class="modal-dialog modal-sm">

 		<form action="<?= base_url('admin/pos/set_discount'); ?>" method="post" class="setDiscount validForm">
 			<?= csrf();?>
 			<!-- Modal content-->
 			<div class="modal-content">
 				<div class="modal-header">
 					<button type="button" class="close" data-dismiss="modal">&times;</button>
 					<h4 class="modal-title"><?= lang('discount'); ?></h4>
 				</div>
 				<div class="modal-body custom-fields">
 					<div class="errorMsg"></div>
 					<div class="row">
 						<div class="form-group col-md-12">
 							<div class="input-group">
 								<input type="text" name="discount" class="form-control" placeholder="Discount" value="<?= isset($discount)?$discount:"";?>" min-value="0" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' >
 									<span class="input-group-addon"><?= restaurant()->icon;?></span>
 								</div>
 							</div>
 						</div><!-- row -->


 					</div>
 					<div class="modal-footer">
 						<button type="submit" class="btn btn-success"><?= lang('submit'); ?> <i class="icofont-thin-double-right"></i></button>
 					</div>
 				</div>
 			</form>
 		</div>
 	</div>
 <!-- 
	Discount Modal
 -->



 <!-- 
	Coupon Discount Modal
 -->

 <?php $coupon_list = $this->pos_m->get_my_coupon(restaurant()->id); ?>
 <div id="couponModal" class="modal fade discountModal" role="dialog" data-backdrop="static" data-keyboard="false">
 	<div class="modal-dialog modal-sm">

 		<form action="<?= base_url('admin/pos/check_coupon_code'); ?>" method="post" class="setDiscount validForm">
 			<?= csrf();?>
 			<!-- Modal content-->
 			<div class="modal-content">
 				<div class="modal-header">
 					<button type="button" class="close" data-dismiss="modal">&times;</button>
 					<h4 class="modal-title"><?= lang('check_coupon_code'); ?> </h4>
 				</div>
 				<div class="modal-body custom-fields">
 					<div class="errorMsg"></div>
 					<div class="row">
 						<div class="form-group col-md-12">
 							<div class="input-group">
                                <select name="coupon_code" class="form-control">
                                    <option value=""><?= lang('select');?></option>
                                   <?php foreach ($coupon_list as $coupon): ?>
                                         <option value="<?= $coupon['coupon_code'];?>" <?= isset($coupon_id) && $coupon_id==$coupon['id']?"selected":"";?> ><?= !empty($coupon['title'])?$coupon['title']:$coupon['coupon_code'];?> (<?= $coupon['discount'];?>%)</option>
                                    <?php endforeach ?>
                                </select>
 								<span class="input-group-addon"><i class="icofont-tag"></i></span>
 							</div>
 						</div>
 					</div><!-- row -->


 				</div>
 				<div class="modal-footer">
 					<button type="submit" class="btn btn-success"><?= lang('submit'); ?> <i class="icofont-thin-double-right"></i></button>
 				</div>
 			</div>
 		</form>
 	</div>
 </div>

 <!-- 
	Coupon Discount Modal
 -->


 <!-- 
	Customer  Modal
 -->
 <div id="addCustomerModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
 	<div class="modal-dialog">

 		<form action="<?= base_url('admin/pos/add_customer'); ?>" method="post" class="addCustomer validForm">
 			<?= csrf();?>
 			<!-- Modal content-->
 			<div class="modal-content">
 				<div class="modal-header">
 					<button type="button" class="close" data-dismiss="modal">&times;</button>
 					<h4 class="modal-title"><?= lang('add_new'); ?></h4>
 				</div>
 				<div class="modal-body custom-fields">
 					<div class="reg_msg"></div>
 					<div class="row">
 						<div class="form-group col-md-6">
 							<label><?= lang('customer_name'); ?> <span class="error">*</span></label>
 							<input type="text" name="customer_name" class="form-control" placeholder="<?= lang('customer_name'); ?>" required>
 						</div>
 						<div class="form-group col-md-6">
 							<label><?= lang('email'); ?></label>
 							<input type="text" name="email" class="form-control" placeholder="<?= lang('email'); ?>">
 						</div>
 					</div><!-- row -->

 					<div class="row">
 						<div class="form-group col-md-6">
 							<label><?= lang('phone'); ?></label>
 							<input type="text" name="phone" class="form-control" placeholder="<?= lang('phone'); ?>">
 						</div>
 						<div class="form-group col-md-6">
 							<label><?= lang('country'); ?></label>
 							<input type="text" name="country" class="form-control" placeholder="<?= lang('country'); ?>">
 						</div>
 					</div><!-- row -->

 					<div class="row">
 						<div class="form-group col-md-6">
 							<label><?= lang('city'); ?></label>
 							<input type="text" name="city" class="form-control" placeholder="<?= lang('city'); ?>">
 						</div>
 						<div class="form-group col-md-6">
 							<label><?= lang('tax_number'); ?></label>
 							<input type="text" name="tax_number" class="form-control" placeholder="<?= lang('tax_number'); ?>">
 						</div>
 					</div><!-- row -->
 					<div class="row">
 						<div class="form-group col-md-12">
 							<label><?= lang('address'); ?></label>
 							<textarea name="address" class="form-control" id="address" cols="5" rows="5" placeholder="<?= lang('address'); ?>"></textarea>
 						</div>
 						
 					</div><!-- row -->
 				</div>
 				<div class="modal-footer">
 					<button type="submit" class="btn btn-success"><?= lang('submit'); ?> <i class="icofont-thin-double-right"></i></button>
 				</div>
 			</div>
 		</form>
 	</div>
 </div>
 <!-- 
	Customer  Modal
 -->


  <!-- 
	Customer  Modal
 -->
 
 <!-- 
	Customer  Modal
 -->