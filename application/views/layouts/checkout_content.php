<div class="row">
	<div class="col-md-12 col-sm-12 col-lg-6">
		<div class="step_1">
			<div class="singlePage style_2">
				<ul>
					<?php include APPPATH.'views/layouts/ajax_cart_item.php'; ?>
				</ul>
			</div>
		</div>
		<div class="cartItemDetails">
			<?php if(shop($shop_id)->is_customer_login==1): ?>
		 		<div class="order_page">
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
		 					<div class="singlePageLogin">
		 						<?php include APPPATH."views/layouts/inc/userLogin.php"; ?>
		 					</div>
		 				</div>
		 			</div><!-- LoginSection -->
		 			<div id="loadCustomer"></div>
		 		</div><!-- order_page -->
		 	<?php endif;?>

	 		<form action="<?= base_url('profile/add_order/2') ;?>" method="post" class="order_form" autocomplete="off">			
	 			<!-- csrf token -->
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
	</div><!-- col-6 -->



	<div class="col-md-12 col-sm-12 col-lg-6 singlePage style_2">
		<div class="row">
			
			<div class="col-md-12 total_sum_area">
				<div class="total_sum showCheckoutTotal">
					<?php  include 'inc/checkout_total_area.php';?>
				</div>
			</div>
		
		</div>
	</div><!--  -->
</div>
<script type="text/javascript"  src="<?= base_url();?>assets/frontend/plugins/datetime_picker/datetime.js" ></script>
 <script>
 	 $('[data-toggle="tooltip"]').tooltip();
 </script>



 <!-- Modal -->
 <div class="modal fade customerpopup" id="customereditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 	<div class="modal-dialog modal-dialog-centered" role="document">
 		<div class="modal-content" id="customerData">
 			<?php include APPPATH.'views/layouts/inc/customer_info_modal.php'; ?>
 		</div>
 	</div>
 </div>

<?php if(shop($shop_id)->is_customer_login==1): ?>
 <script>
 	$(document).on('change','[name="is_guest_login"]',function() {
 		if ($(this).is(':checked')){
 			$('.tabArea, .or').slideUp();
 			$('.orderInfoArea').slideDown();
 		}else{
 			$('.tabArea, .or').slideDown();
 			$('.orderInfoArea').slideUp();
 		}
 	});
 </script>
 <?php else: ?>
 	<script>
 	$(document).on('change','[name="is_guest_login"]',function() {
 		if ($(this).is(':checked')){
 			$('.customerInfo, .or').slideUp();
 		}else{
 			$('.customerInfo, .or').slideDown();
 		}
 	});
 </script>
 
 <?php endif; ?>

