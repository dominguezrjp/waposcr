<?php  if(users()->user_role==1):?>
<?php if(empty(users()->phone) || empty($this->settings['site_name']) || empty($this->settings['smtp_mail'])): ?>
<div class="modal fade" id="alertModal">
  <div class="modal-dialog">
    <div class="modal-content"><div class="modal-header">
          <h4 class="modal-title text-danger"><?= lang('those_steps_are_most_important');?></h4>
        </div>
      <div class="modal-body">
        
        <div class="modalBoady">
        <?php  if(users()->user_role==1):?>
          <?php if(empty(users()->phone)): ?>
            <div class="singleAlert">
                <div class="single__">
                  <i class="icofont-megaphone-alt"></i>
                  <div class="single__left">
                    <div class="">
                      <h4><?= lang('phone_number_is_missing');?></h4>
                      <p><?= lang('Please_add_your_phone_number');?></p>
                    </div>
                    <a href="<?= base_url('admin/auth/edit_profile/'.md5($this->auth['auth_id'])) ;?>" class="btn danger-light-active"><i class="icofont-hand-drag1"></i> <?= lang('add_now'); ?></a>
                  </div>
                </div>
            </div>  
            <?php endif;?>  
              <?php if(empty($this->settings['site_name'])): ?>
                 <div class="singleAlert">
                  <div class="single__">
                    <i class="icofont-megaphone-alt"></i>
                    <div class="single__left">
                      <div class="">
                        <?php if(empty($this->settings['site_name'])): ?>
                          <h4><?= lang('site_name_is_missing');?></h4>
                        <?php endif;?>
                        <p><?= lang('please_config_your_site_settings');?></p>
                      </div>
                      <a href="<?= base_url('admin/settings/settings') ;?>" class="btn danger-light-active"><i class="icofont-hand-drag1"></i> <?= lang('add_now'); ?></a>
                    </div>
                  </div>
                </div>  
             <?php endif;?>

             <?php if(empty($this->settings['smtp_mail'])): ?>
                 <div class="singleAlert">
                  <div class="single__">
                    <i class="icofont-megaphone-alt"></i>
                    <div class="single__left">
                      <div class="">
                        <?php if(empty($this->settings['smtp_mail'])): ?>
                          <h4><?= lang('email_is_missing');?></h4>
                        <?php endif;?>
                        <p><?= lang('please_confing_the_email');?></p>
                      </div>
                      <a href="<?= base_url('admin/settings/email_settings') ;?>" class="btn danger-light-active"> <i class="icofont-hand-drag1"></i> <?= lang('add_now'); ?></a>
                    </div>
                  </div>
                </div>  
             <?php endif;?>
             <?php endif;?>
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?= lang('close');?></button>
      </div>
    </div>
  </div>
</div>
  <script>
    $('.alertModal').modal('show');
  </script>
<?php endif;?>
<?php endif;?>

<?php  if(users()->user_role==0):?>
<?php if(empty(restaurant()->name) || empty(restaurant()->phone) || isset(restaurant()->country_id) && restaurant()->country_id == 0): ?>
<div class="modal fade alertModal" id="alertModal">
  <div class="modal-dialog">
    <div class="modal-content"><div class="modal-header">
          <h4 class="modal-title text-danger"><?= lang('those_steps_are_most_important');?></h4>
        </div>
      <div class="modal-body">
        
        <div class="modalBoady">
           <?php if(empty(restaurant()->name)): ?>
                <div class="singleAlert">
                    <div class="single__">
                      <i class="icofont-megaphone-alt"></i>
                      <div class="single__left">
                        <div class="">
                          <h4><?= lang('restaurant_name_is_missing');?></h4>
                          <p><?= lang('please_config_the_shop_settings_configuration');?></p>
                        </div>
                        <a href="<?= base_url('admin/auth/edit_restaurant/'.md5($this->auth['auth_id'])) ;?>" class="btn danger-light-active"><i class="icofont-hand-drag1"></i> </a>
                      </div>
                    </div>
                </div>  

            <?php endif;?>

              <?php if(empty(restaurant()->phone) && isset(restaurant()->country_id) && restaurant()->country_id == 0 && auth('user_role')==0): ?>
              <?php if(empty(users()->phone)): ?>
                <div class="singleAlert">
                    <div class="single__">
                      <i class="icofont-megaphone-alt"></i>
                      <div class="single__left">
                        <div class="">
                           <h4><?= lang('phone_number_is_missing');?></h4>
                            <p><?= lang('Please_add_your_phone_number');?></p>
                        </div>
                        <a href="<?= base_url('admin/restaurant/profile') ;?>" class="btn danger-light-active"><i class="icofont-hand-drag1"></i>  </a>
                        
                      </div>
                    </div>
                </div>  
             <?php endif;?>  

              <?php $lang =  $this->config->load('messages_config');?>
                <div class="singleAlert">
                    <div class="single__">
                      <i class="icofont-megaphone-alt"></i>
                      <div class="single__left">
                        <div class="">
                          <h4><?= lang('restaurant_empty_alert_msg');?></h4>
                          <p><?= lang('restaurant_empty_alert_msg-2');?></p>
                          <p><?= lang('restaurant_empty_alert_msg-3');?></p>
                        </div>
                        <a href="<?= base_url('admin/auth/edit_restaurant/'.md5($this->auth['auth_id'])) ;?>" class="btn danger-light-active"><i class="icofont-hand-drag1"></i> <?= lang('add_now'); ?></a>
                      </div>
                    </div>
                  </div>  
              <?php endif;?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('.alertModal').modal('show');
</script>
<?php endif;?>
<?php endif;?>