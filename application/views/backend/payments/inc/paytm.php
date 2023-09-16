<?php if(check()==1): ?>
<?php $paytm = json_decode($setting['paytm_config']); ?>
<?php  if(!empty($paytm->merchant_id)):?>
<div class="payment_content text-center <?= is_package;?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/paytm.png'); ?>" alt="">
	</div>
	<div class="payment_details">
		<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
		<div class="">
			<h2><?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> / <?= !empty(lang($package['package_type']))?lang($package['package_type']):$package['package_type']?></h2>
			<p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']);?></p>
		</div>
	</div>
	<?php if(is_demo()==0): ?>
		
		<button type="submit" id="blinkCheckoutPayment" name="submit" class="btn btn-success buy_now"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;( <?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> )</button>
	<?php endif;?>
</div><!-- payment_content -->


<script type="application/javascript" crossorigin="anonymous" src="<?=  $paytm_init['url'];?>/merchantpgpui/checkoutjs/merchants/<?=  $paytm->merchant_id;?>.js"></script>
<script>
      	
	document.getElementById("blinkCheckoutPayment").addEventListener("click", function(){
		openBlinkCheckoutPopup('<?= $paytm_init['order_id'];?>','<?php echo $paytm_init['token']?>','<?php echo $total_price?>');
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

<?php endif;?>