<!DOCTYPE html>
<html>
 <head><title>Checkout</title></head>
 <body>
  <h1>Checkout</h1>
   <div id="checkout-container-div">
     <!-- checkout iframe will be embedded here -->
   </div>
   <script src="https://test.checkout.dibspayment.eu/v1/checkout.js?v=1"></script>
   <script>
   	let base_url = `<?= base_url();?>`
   	// let paymentId = `<?= $paymentId;?>`;
   	let checkout_key = 'test-checkout-key-0866b0e0dd0b41b4baa21058cd855ad2';
   	document.addEventListener('DOMContentLoaded', function () {
   		const urlParams = new URLSearchParams(window.location.search);
   		// const paymentId = urlParams.get('paymentId');
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

		  	window.location = `${base_url}profile/get_payment_details/?paymentId=${paymentId}`;
		  });
		} else {
		    console.log("Expected a paymentId");   // No paymentId provided, 
		    // window.location = `${base_url}profile/test`;         // go back to cart.html
		    console.log('paymentId not found');
		}
	});

	
   </script>
 </body>
</html>