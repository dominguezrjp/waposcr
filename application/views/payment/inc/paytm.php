<?php $paytm = json_decode($shop['paytm_config']); ?>
<?php  if(!empty($paytm->merchant_id)):?>
<div class="payment_content text-center <?= $pay['slug'];?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/paytm.png'); ?>" alt="">
	</div>
	<div class="payment_details">
		<div class="userInfo">
			<h4> <?= isset($payment['name'])?html_escape($payment['name']):'';?></h4>
			<p><?= lang('phone'); ?>: <?= isset($payment['phone'])?html_escape($payment['phone']):'';?></p>
		</div>
		<div class="">

			<h2> <?= isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> </h2>

		</div>
	</div>
	<?php if(is_demo()==0): ?>
		<button type="submit" id="blinkCheckoutPayment" name="submit" class="btn btn-success buy_now"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;(<?= isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> )</button>
	<?php endif;?>
</div><!-- payment_content -->


<?php $paytm_init = $this->user_payment_m->paytm_init($slug); ?>

<script type="application/javascript" crossorigin="anonymous" src="<?=  $paytm_init['url'];?>/merchantpgpui/checkoutjs/merchants/<?=  $paytm->merchant_id;?>.js"></script>
<script>
      	
	document.getElementById("blinkCheckoutPayment").addEventListener("click", function(){
		openBlinkCheckoutPopup('<?= $paytm_init['order_id'];?>','<?php echo $paytm_init['token']?>','<?php echo round($total_amount)?>');
		}
	);
         
        function openBlinkCheckoutPopup(orderId, txnToken, amount)
         {
         	// console.log(orderId, txnToken, amount);
         	var config = {
         		"root": "",
         		"flow": "DEFAULT",
         		"data": {
         			"orderId": orderId, 
         			"token": txnToken, 
         			"tokenType": "TXN_TOKEN",
         			"amount": amount 
				 },
         		"handler": {
         		"notifyMerchant": function(eventName,data){
         			console.log("notifyMerchant handler function called");
         			console.log("eventName => ",eventName);
         			console.log("data => ",data);
         			location.reload();
         		} 
         		}
         	};
         	 if(window.Paytm && window.Paytm.CheckoutJS){
         			// initialze configuration using init method 
         			window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
         				// after successfully updating configuration, invoke checkoutjs
         				window.Paytm.CheckoutJS.invoke();
         			}).catch(function onError(error){
         				console.log("error => ",error);
         			});
         	}
        }
      </script>
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>