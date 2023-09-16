 <div class="modal-header">
 	<h5 class="modal-title" id="exampleModalLongTitle"><?= !empty(lang('order_form'))?lang('order_form'):'Order Form' ;?></h5>
 	<a href="javascript"  class="text-danger" data-dismiss="modal"><i class="fa fa-close"></i></a>
 </div>
 	<div class="modal-body">
 		<div class="cartItemDetails">
	 		<div class="order_page">
	 			<!-- row -->
	 				<?php include "inc/checkout_item_list.php"; ?>
	 			<?php if(shop($shop_id)->is_customer_login==1): ?>
	 				<!-- row -->
	 				<div class="loginSection">
	 					<div class="ModalCustomerInfo <?= auth('is_customer')==TRUE?'':"dis_none" ;?>">
	 						<div class="flex flex-column w_100">
	 							<h4 class="bb_1_dashed w_100 pb-7"><?= lang('customer_info'); ?> <a href="javascript:;" class="customerRemove ml-20 text-danger"><i class="icofont-close-line "></i></a></h4>
	 							<div class="customerInfoModal">
	 								<h4 class="pb-7 pt-5 fz-14 pt-10"><i class="icofont-users-alt-4"></i>  &nbsp;<?= auth('customer_name'); ?></h4>
	 								<p class="fz-14"><i class="icofont-ui-call"></i> <?= auth('customer_phone') ;?></p>
	 							</div>
	 						</div>
	 						<div class="customerEdit">
	 							<a href="#customereditModal" data-toggle="modal"><i class="fa fa-edit"></i></a>
	 						</div>
	 					</div>
	 					<div class="showUserlogin <?= auth('is_customer')==TRUE?'dis_none':"" ;?>">
	 						<?php include "inc/userLogin.php"; ?>
	 					</div>
	 				</div><!-- LoginSection -->
	 				<div id="loadCustomer"></div>
	 			<?php endif;?>
	 		</div><!-- order_page -->
	 		<form action="<?= base_url('profile/add_order/') ;?>" method="post" class="order_form" autocomplete="off">			<!-- csrf token -->
			   <?= csrf(); ?>
			   <?php  if(shop($shop_id)->is_customer_login==1):?>
		 			<div class="order_page orderInfoArea <?= auth('is_customer')==TRUE ?"":"dis_none" ?>">
		 				<div class="order_input_area">
		 					<?php include APPPATH."views/layouts/inc/order_info_form.php"; ?>
		 				</div><!--  -->
		 			</div><!-- order_page -->
	 			<?php else: ?>
		 			<div class="order_page orderInfoArea">
		 				<div class="order_input_area">
		 					<?php include APPPATH."views/layouts/inc/order_info_form.php"; ?>
		 				</div><!--  -->
		 			</div><!-- order_page -->
	 			<?php endif;?>
		 	</form>
	 		
	 	</div><!-- cartItemDetails -->
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
		 		<div class="flex_btn">
		 			<a href="javascript:;" class="btn btn-success custom_btn ok_btn"><?= !empty(lang('ok'))?lang('ok'):'ok' ;?></a>
		 		</div>
		 		<div class="trackLink mt-12">
		 			<a href="javascript:;" id="track_order_btn" target="blank" class="fz-14"><?= lang('track_order') ;?></a>
		 		</div>
		 	</div>
		</div>
 	</div><!-- modal-body -->
 </form>
 <script type="text/javascript"  src="<?= base_url();?>assets/frontend/plugins/datetime_picker/datetime.js" ></script>
 <script>
 	 $('[data-toggle="tooltip"]').tooltip();
 </script>
 



 <div class="showGmap"></div>


 <!-- Modal -->
 <div class="modal fade customerpopup" id="customereditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 	<div class="modal-dialog modal-dialog-centered" role="document">
 		<div class="modal-content" id="customerData">
 			<?php include APPPATH.'views/layouts/inc/customer_info_modal.php'; ?>
 		</div>
 	</div>
 </div>