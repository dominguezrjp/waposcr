
<?php if(!empty($paymentId)): ?>
<!DOCTYPE html>
<html>
 <head><title>Netseasy</title></head>
 <body>
   <div id="checkout-container-div">
     <!-- checkout iframe will be embedded here -->
   </div>
  	<?php $netseasy = isJson($settings['netseasy_config'])?json_decode($settings['netseasy_config']):''; ?>

	<script src="<?= netseasyUrl($netseasy->is_netseasy_live)->checkout;?>/v1/checkout.js?v=1"></script>
	<script>
		
		let checkout_key = `<?= $netseasy->netseasy_checkout_key;?>`;
		var returnUrl = `<?= base_url("payment/netseasy_verify/{$slug}/{$account_slug}?paymentId={$paymentId}");?>`
		document.addEventListener('DOMContentLoaded', function () {
			const paymentId = `<?= $paymentId;?>`;
			if (paymentId) {
				const checkoutOptions = {
		      checkoutKey: checkout_key, // Replace!
		      paymentId: paymentId,
		      containerId: "checkout-container-div",
		      language: "en-GB",
		      theme: {
		      	buttonRadius: "5px"
		      }
		  };
		  const checkout = new Dibs.Checkout(checkoutOptions);
		  checkout.on('payment-completed', function (response) {
		  	window.location = `${returnUrl}`;
		  });
		} else {
		    console.log("Expected a paymentId");   // No paymentId provided, 
		    console.log('paymentId not found');
		}
	});


</script>
 </body>
</html>
<?php else: ?>
	<?php //redirect($_SERVER['HTTP_REFERER']); ?>
<?php endif; ?>