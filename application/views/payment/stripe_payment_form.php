
<style>
    .hide{
        display: none;
    }
</style>
<div class="row">
  <div class="col-md-12">
          <a href="javascript:;" class="back payment_back"><i class="fa fa-arrow-left"></i> <?= !empty(lang('back'))?lang('back'):"Back"?></a>
      </div>
</div>
<div class="container">
  <div class="row">
      <div class="col-md-6 <?= direction()=='rtl'?"mr-25":"offset-md-3"?>  mt-50">
          <div class="card  payment_card_stripe">
              <div class="card-header">
                  <h4><?= !empty(lang('stripe'))?lang('stripe'):"stripe payment gateway"?></h4>
              </div>
              <form role="form" action="<?= base_url('payment-post');?>" method="post" class="require-validation" data-cc-on-file="false" id="paymentFrm">
                  <!-- csrf -->
                   <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <!-- csrf -->
                  <div class="card-body">
                      <?php $this->load->view('admin/inc/success_msg'); ?>
                      <div class='col-md-12 error form-group payment-errors'>
                          
                      </div>

                      <div class="row">
                          <div class="card_img">
                              <div class="payment_card_img">
                                  <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                              </div>
                          </div>
                      </div>
                     <div class="row">
                             <div class='col-md-12 form-group required'>
                              <label class='control-label'>Name On Card</label>
                              <input class='form-control' name="stripe_name" id="stripe-name" size='4' type='text' placeholder="Your name on card">
                          </div>
                     </div>
                     <div class="row">
                         <div class='col-md-12 form-group required'>
                              <label class='control-label'>Card Number</label>
                              <input autocomplete='off' name="stripe_cart_no" class='form-control card-number' size='20' type='text' placeholder="xxxx xxxx xxxx xxxx"  id="stripe-card-number" maxlength="19">
                          </div>
                     </div>
                     <div class="row">
                         <div class='col-xs-12 col-md-4 form-group expiration required p-r-5'>
                              <label class='control-label'>Month</label>
                              <input class='form-control' name="stripe_month" id="stripe-card-expiry-month" placeholder='MM' size='2' type='text' maxlength="2">
                          </div>

                          <div class='col-xs-12 col-md-4 form-group expiration required p-l-5'>
                              <label class='control-label'>Year</label>
                              <input class='form-control' name="stripe_year" id="stripe-card-expiry-year" placeholder='YYYY' size='4' type='text' maxlength="4">
                          </div>

                          <div class='col-xs-12 col-md-4 form-group cvc required'>
                              <label class='control-label'>CVC</label>
                               <input autocomplete='off'  name="cvc" class='form-control' id="stripe-card-cvc" placeholder='ex. 311' size='4' type='text'>
                          </div>
                     </div>


                  </div><!-- card-body -->
                  <div class="card-footer">
                    <input type="hidden" name="amount" value="<?= isset($package['price'])? number_format($package['price']):0;?>">
                    <input type="hidden" name="username" value="<?= isset($slug)?$slug:"";?>">
                    <input type="hidden" name="package_id" value="<?= isset($package['id'])?$package['id']:0;?>">
                                
                      <button class="btn btn-primary btn-lg btn-block" id="payBtn" type="submit" data-publish-key="<?php echo $this->config->item('stripe_key') ?>"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now "?>(<?= get_currency('icon') ;?><?= isset($package['price'])?$package['price']:''; ?>)</button>
                  </div>
              </form>
          </div>
      </div>

  </div>

</div>

     
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">

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

$('a.back').on("click",function(){
    parent.history.back();
});

// function addHyphen (element) {
//     let ele = document.getElementById(element.id);
//     ele = ele.value.split('-').join('');    // Remove dash (-) if mistakenly entered.

//     let finalVal = ele.match(/.{1,4}/g).join('-');
//     document.getElementById(element.id).value = finalVal;
// }
</script>
