<?php if(isset($shop['is_coupon']) && $shop['is_coupon']==1): ?>

  <?php $coupon_list = $this->common_m->get_my_coupons($id) ?>
  <?php if(count($coupon_list)>0): ?>
   <div class="container">
     <div class="couponArea">
      <div class="row">
        <?php foreach ($coupon_list as $key => $coupon): ?>
          <div class="col-md-6">
            <div class="couponList">
              <h4><?=  $coupon['title'] ;?></h4>
              <p><?= lang('use_coupon_code'); ?>: <span class="couponCode"><?= $coupon['coupon_code'] ;?></span></p>
            </div>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
  <?php endif;?>
<?php endif;?>