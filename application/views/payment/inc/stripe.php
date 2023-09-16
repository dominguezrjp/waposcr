<?php $stripe = json_decode($shop['stripe_config'],true); ?>
<?php if(!empty($stripe['public_key'])): ?>
<div class="payment_content text-center <?= $pay['slug'];?>">
	<div class="card_img">
		<div class="payment_card_img">
			<img src="<?php echo base_url('assets/frontend/images/payment.png'); ?>" alt="">
		</div>
	</div>

	<div class="payment_details">
		<div class="userInfo">
			<h4> <?= isset($payment['name'])?html_escape($payment['name']):'';?></h4>
			<p><?= lang('phone'); ?>: <?= isset($payment['phone'])?html_escape($payment['phone']):'';?></p>
		</div>
		<div class="">

			<h2> <?= isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> </h2>

		</div>
		<p class="payment_text">*<?= !empty(lang('payment_by'))?lang('payment_by'):"Payment via"?> <i class="fa fa-cc-stripe fa-2x"></i></p>
	</div>


	<div class="stripeForm">
		<form role="form" action="<?= base_url('user-stripe-payment');?>" method="post" class="require-validation" data-cc-on-file="false" id="paymentFrm">
			<!-- csrf -->
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
			<!-- csrf -->
			<div class="card-body">

				<div class='col-md-12 error form-group payment-errors'>

				</div>

				<div class="row">
					<div class='col-md-12 form-group required'>
						<label class='control-label'><?= lang('name_on_card'); ?></label>
						<input class='form-control' name="stripe_name" id="stripe-name" size='4' type='text' placeholder="Your name on card">
					</div>
				</div>
				<div class="row">
					<div class='col-md-12 form-group required'>
						<label class='control-label'><?= lang('card_number'); ?></label>
						<input autocomplete='off' name="stripe_cart_no" class='form-control card-number' size='20' type='text' placeholder="xxxx xxxx xxxx xxxx"  id="stripe-card-number" maxlength="19" >
					</div>
				</div>
				<div class="row">
					<div class='col-xs-12 col-md-4 form-group expiration required p-r-5'>
						<label class='control-label'><?= lang('month'); ?></label>
						<input class='form-control' name="stripe_month" id="stripe-card-expiry-month" placeholder='MM' size='2' type='text' maxlength="2" >
					</div>

					<div class='col-xs-12 col-md-4 form-group expiration required p-l-5'>
						<label class='control-label'><?= lang('year'); ?></label>
						<input class='form-control' name="stripe_year" id="stripe-card-expiry-year" placeholder='YYYY' size='4' type='text' maxlength="4">
					</div>

					<div class='col-xs-12 col-md-4 form-group cvc required'>
						<label class='control-label'><?= lang('cvc'); ?></label>
						<input autocomplete='off'  name="cvc" class='form-control' id="stripe-card-cvc" placeholder='ex. 311' size='4' type='text' >
					</div>
				</div>


			</div><!-- card-body -->
			<div class="card-footer">
				<input type="hidden" name="amount" value="<?= number_format((float)$total_amount, 2, '.', '');?>">
				<input type="hidden" name="username" value="<?= isset($slug)?$slug:"";?>">
				<input type="hidden" name="shop_id" value="<?= isset($shop['id'])?$shop['id']:0;?>">
				<?php if(is_demo()==0): ?>      
					<button class="btn btn-primary btn-lg btn-block" id="payBtn" type="submit" data-publish-key="<?= !empty($stripe['public_key'])?$stripe['public_key']:"";?>"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now "?> <?= currency_position($total_amount,$shop['id']); ?></button>
				<?php endif;?>
			</div>
		</form>
	</div>

</div><!-- payment_content -->




<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
	$(function(){
		var public_key = $('#payBtn').data('publish-key');
		if(public_key){
//set your publishable key
Stripe.setPublishableKey(public_key);
  //callback to handle the response from stripe
  function stripeResponseHandler(status, response) {
  	if (response.error) {
          //enable the submit button
          $('#payBtn').removeAttr("disabled");
          //display the errors on the form
          $(".payment-errors").html(`<div class="single_alert alert alert-danger alert-dismissible">
          	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          	<div class="d_flex_alert">
          	<h4><i class="icon fas fa-warning"></i> Warning!</h4>
          	<div class="double_text">
          	<p>${response.error.message}</p>
          	</div>
          	</div>
          	</div>`);
      } else {
      	var form$ = $("#paymentFrm");
          //get token id
          var token = response['id'];
          //insert the token into the form
          form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
          //submit form to the server
          form$.get(0).submit();
      }
  }
  $(document).ready(function() {

      //on form submit
      $("#paymentFrm").submit(function(event) {
          //disable the submit button to prevent repeated clicks
          $('#payBtn').attr("disabled", "disabled");
          
          //create single-use token to charge the user
          Stripe.createToken({
          	number: $('#stripe-card-number').val(),
          	cvc: $('#stripe-card-cvc').val(),
          	exp_month: $('#stripe-card-expiry-month').val(),
          	exp_year: $('#stripe-card-expiry-year').val()
          }, stripeResponseHandler);
          //submit from callback
          return false;
      });
  });  

}

});
</script>

<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>