 <?php if($this->my_info['is_deactived']==0 && $this->auth['is_verify'] == 1 && $this->auth['is_payment'] == 1 && $this->auth['is_expired'] == 0){ ?>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <?php if(shop_id()==0) { ?>
             <div class="single_alert alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div class="d_flex_alert">
                    <h4><i class="icon fas fa-warning"></i> Alert!</h4>
                    <div class="double_text">
                        <div class="text-left">
                         <h4>Please Configure your Shop</h4>
                         <p>Without  shop you can't make item, order, etc</p>
                         <a href="<?= base_url('admin/auth/edit_restaurant/'.md5(auth('id'))) ;?>" class="re_url"><?= lang('click_here'); ?></a>
                        </div>
                       
                    </div>
                </div>
            </div>
        <?php } ?>
      </div>
    </div><!-- row -->


    <div class="row mb-10">
      <div class="col-md-6 col-md-offset-3">
        <div class="share_able_link">
          <p><?= !empty(lang('profile_link'))?lang('profile_link'):"Profile Link"?>: <span><?= url(auth('username')) ;?></span> <a href="javascript:;" class="copy_btn btn-success copy" data-id="<?= auth('id') ;?>" data-link="<?= url($this->my_info['username']) ;?>"><?= !empty(lang('copy'))?lang('copy'):"Copy"?></a></p>
          <p class="copy_alert" style="display: none;"><i class="fa fa-check"></i> &nbsp;<?= !empty(lang('coppied'))?lang('coppied'):"coppied"?></p>
        </div>
      </div>
    </div><!-- row -->

  <div class="row">
      <div class="col-md-8">
        <div class="row">
          <?php include 'inc/resturant_info.php'; ?>
          <!-- middle -->
          <?php include 'inc/package_information.php'; ?>
        </div>


        <?php if(isset($active_package['package_type']) && in_array($active_package['package_type'],trial_type())==1 || $this->my_info['account_type']==0 ): ?>
      <?php else: ?>
        <?php include 'inc/statistics_graph.php'; ?>
      <?php endif; ?>


      </div><!-- col-8 -->
      <div class="col-md-4">
          
          <?php if(isset($active_package['package_type']) && in_array($active_package['package_type'],trial_type())==1 || $this->my_info['account_type']==0 ): ?>
              <?php include 'inc/account_type_info.php'; ?>
          <?php else: ?>
              <?php include 'inc/sales_graph.php'; ?>
          <?php endif;?>
      </div><!-- col-4 -->
    <!-- middle -->
     <!-- sales graph -->
  </div><!-- row -->

   
    
  <?php } ?><!-- is_deactived == 0 -->

  <?php if($this->my_info['is_deactived']==1): ?>
    <div class="row">
      <?php include "inc/active_msg.php"; ?>
    </div>
  <?php endif;?>

  <?php if($this->my_info['is_verify']==0): ?>
    <div class="row">
      <?php include "inc/verify_msg.php"; ?>
    </div>
  <?php elseif($this->auth['is_payment'] == 0): ?>
    <div class="row">
      <?php include "inc/payment_pending_msg.php"; ?>
    </div>

  <?php elseif($this->auth['is_expired'] == 1): ?>
    <div class="row">
      <?php include "inc/expired_msg.php"; ?>
    </div>
  <?php endif;?>