<?php if($this->auth['user_role']==1): ?>
     <div class="col-md-6 ">
        <?php if(empty($this->settings['smtp_mail']) || empty($this->settings['site_name'])): ?>
      
        <div class="single_alert  default-light-soft-active mb-20 p-5 alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div class="d_flex_alert">
                    <div class="double_text" style="display:flex; flex-direction: column; align-items: flex-start; justify-content: left;">
                        <h4 class="mb-5">Those Steps are most important to configure first</h4>
                        <?php if($this->is_empty['country']==0): ?>
                            <h4 class="mb-5">* <b>Configure your profile</b> <a href="<?= base_url('admin/auth/edit_profile/'.md5($this->auth['auth_id'])) ;?>" class="re_url c_white"><?= lang('click_here'); ?></a> </h4>
                        <?php endif;?>


                        <?php if(isset($this->settings['site_name']) && empty($this->settings['site_name'])): ?>
                        <h4 class="mb-5">** <b>Configure Settings</b> <a href="<?= base_url('admin/settings/settings/') ;?>" class="re_url">click here!</a></h4>
                        <div class="ml-20">
                           <p>1. <b>Site name</b>, <b>Country</b>, <b>Currency</b>, <b>Timezone</b> is important</p>
                       </div>    
                   <?php endif;?>
                   <?php if(isset($this->settings['smtp_mail']) && empty($this->settings['smtp_mail'])): ?>
                   <h4 class="mb-5">*** <b>Configure Email</b> <a href="<?= base_url('admin/settings/email_settings') ;?>" class="re_url">click here!</a></h4>
               <?php endif;?>

           </div>
            </div>
        </div>
        <?php endif;?>
        <?php if($this->admin_m->count_home_user()==0 && !empty($this->settings['site_name']) && $this->auth['user_role']==1 && !empty($this->settings['smtp_mail']) && $this->is_package['package']!= 0): ?>
                <div class="single_alert alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <div class="d_flex_alert">
                        <h4><i class="far fa-smile"></i> Success!</h4>
                        <div class="double_text">
                            <div class="text-left">
                                <h5>Welcome to <?= $this->settings['site_name'];?></h5>
                                <p>Your site is now ready to Production.</p>
                            </div>
                        </div>
                    </div>
                </div>
        <?php endif;?>
    </div>


<?php endif;?>