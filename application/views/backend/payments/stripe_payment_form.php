
<style>
    .hide{
        display: none;
    }
</style>
<div class="row">
  <div class="col-md-6 <?= direction()=='rtl'?"mr-25":"offset-md-3"?> col-md-offset-3">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= !empty(lang('stripe_payment_gateway'))?lang('stripe_payment_gateway'):"Stripe Payment Gateway";?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <div class="card_img">
            <div class="payment_card_img stripe">
                  <img src="<?php echo base_url('assets/frontend/images/payment.png'); ?>" alt="">
            </div>
        </div>
      <!-- /.box-header -->
      <form action="<?= base_url('stripe-payment-post');?>" method="post" id="paymentFrm">
        <div class="box-body">
          
          <span id="success-msg" class="payment-errors"></span>  
          <!-- csrf token -->
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

          <div class="row">
              <div class="form-group col-md-12">
                  <label><?= !empty(lang('name_on_card'))?lang('name_on_card'):"name on card";?></label>
                  <input type="text" name="stripe_name" id="stripe-name" class="form-control" placeholder="<?= !empty(lang('name_on_card'))?lang('name_on_card'):"name on card";?>">
              </div>
              <div class="form-group col-md-12">
                  <label><?= !empty(lang('email'))?lang('email'):"Email";?></label>
                  <input type="text" name="stripe_email" id="stripe_email" class="form-control" placeholder="<?= !empty(lang('email'))?lang('email'):"Email";?>">
              </div>
              <div class='col-md-12 form-group required'>
                  <label class='control-label'><?= !empty(lang('card_number'))?lang('card_number'):"card number";?></label>
                  <input autocomplete='off' name="stripe_cart_no" class='form-control card-number' size='20' type='text' placeholder="xxxx xxxx xxxx xxxx"  id="stripe-card-number" maxlength="19">
              </div>
              <div class="row col-md-12">
                 <div class='col-xs-12 col-md-4 form-group expiration required p-r-5'>
                      <label class='control-label'><?= lang('month'); ?></label>
                      <input class='form-control' name="stripe_month" id="stripe-card-expiry-month" placeholder='MM' size='2' type='text' maxlength="2">
                  </div>

                  <div class='col-xs-12 col-md-4 form-group expiration required p-l-5'>
                      <label class='control-label'><?= lang('year'); ?></label>
                      <input class='form-control' name="stripe_year" id="stripe-card-expiry-year" placeholder='YYYY' size='4' type='text' maxlength="4">
                  </div>

                  <div class='col-xs-12 col-md-4 form-group cvc required'>
                      <label class='control-label'><?= lang('cvc'); ?></label>
                      <input autocomplete='off'  name="cvc" class='form-control' id="stripe-card-cvc" placeholder='ex. 311' size='4' type='text'>
                  </div>
              </div>

              
          </div>
          
            <input type="hidden" name="id" value="">
        </div><!-- /.box-body -->
        <div class="box-footer">

          <input type="hidden" name="amount" value="<?= isset($total_amount)? number_format($total_amount):0;?>">
          <input type="hidden" name="username" value="<?= $this->my_info['username'];?>">
          <input type="hidden" name="package_id" value="<?= isset($package['id'])?$package['id']:0;?>">

            <div class="pull-left">
              <a href="<?= base_url('payment-method/'.$this->my_info['username'].'/'.$this->my_info['slug']); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"Cancel";?></a>
            </div>
            <div class="pull-right">
              <button type="submit" id="payBtn" data-publish-key="<?= $this->config->item('public_key'); ?>" name="register" class="btn btn-primary btn-block btn-flat payBtn"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now "?>(<?= get_currency('icon');?><?= isset($total_amount)?$total_amount:''; ?>)</button>
            </div>
        </div>
      </form>
    </div>  
  </div>
</div>


