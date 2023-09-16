<?php $user_settings = u_settings($id); ?>
<?php if(isset($user_settings['is_footer']) && $user_settings['is_footer']==0): ?>
<div class="footer_area">
  <div class="top_footer">
    <div class="container">
      <div class="row">

        <div class=" col-lg-4 col-sm-4 col-xs-12">
          <div class="left_footer">
            <div class="qrCode">
              <img src="<?= base_url(!empty($user['qr_link'])?$user['qr_link']:'') ;?>" alt="">
            </div>
            <h4><?= html_escape(!empty(restaurant($id)->name)?restaurant($id)->name:restaurant($id)->username); ?></h4>

            <?php if(!empty(restaurant($id)->location)): ?>
            <p class="address"><i class="icofont-google-map"></i> <a href="<?= redirect_url(restaurant($id)->location,'google');?>"><?= restaurant($id)->address ;?></a></p>
            <?php endif;?>

            <p><a href="<?=  redirect_url(!empty(u_settings($id)['smtp_mail'])?u_settings($id)['smtp_mail']:html_escape($shop['email']),'email');?>"><i class="icofont-email"></i> &nbsp;<?= strtolower(!empty(u_settings($id)['smtp_mail'])?u_settings($id)['smtp_mail']:html_escape($shop['email'])); ?></a></p>
            <ul class="">

              <?php if(!empty($social['facebook'])): ?>
                <li><a href="<?= redirect_url($social['facebook'],'facebook');?>"><i class="fa fa-facebook facebook"></i></a></li>
              <?php endif;?>

              <?php if(!empty($social['instagram'])): ?>
                <li><a href="<?= redirect_url($social['instagram'],'instagram');?>"><i class="fa fa-instagram instagram"></i></a></li>
              <?php endif;?>

              <?php if(!empty($social['whatsapp'])): ?>
                <li><a href="<?= redirect_url($social['whatsapp'],'whatsapp',$shop['dial_code'],url(restaurant($id)->username));?>"><i class="fa fa-whatsapp whatsapp"></i></a></li>
              <?php endif;?>

              <?php if(!empty($social['twitter'])): ?>
                <li><a href="<?= redirect_url($social['twitter'],'twitter');?>"><i class="fa fa-twitter twitter"></i></a></li>
              <?php endif;?>

              <?php if(!empty($social['youtube'])): ?>
                <li><a href="<?=  $social['youtube'];?>" class="venobox" data-autoplay="true" data-vbtype="video"><i class="fa fa-youtube youtube"></i></a></li>
              <?php endif;?>
            </ul>
          </div>
        </div>




        <?php $days = get_days(); ?>
        <?php if(isset($days) && !empty($days)): ?>
          <div class="col-6 col-sm-4 col-lg-4 sm-p-5">
            <div class="left_footer">
              <h4><?=  !empty(lang('available_days'))?lang('available_days'):"available days";?></h4>
              <ul class="row_ul">
                <?php $i=0; foreach ($days as $key => $day): ?>
                  <?php $my_days = $this->common_m->get_single_appoinment($key,restaurant($id)->id); ?>
                  <?php if(isset($my_days['is_24']) && html_escape($my_days['is_24'])==1): ?>
                      <li><a href="javascript:;"><span><?= !empty(lang($day))?lang($day):$day;?></span>  &nbsp; <span class="timeFormat"><i class="icofont-wall-clock"></i> &nbsp;<?= lang('open_24_hours');?></span></a></li>
                    <?php else: ?>
                      <?php if(isset($my_days['days']) && html_escape($my_days['days'])==$key): ?>
                        <li><a href="javascript:;"><span><?= !empty(lang($day))?lang($day):$day;?></span>  &nbsp; <span class="timeFormat"><i class="icofont-wall-clock"></i> &nbsp;<?= time_format($my_days['start_time'],restaurant($id)->id);?> - <?= time_format($my_days['end_time'],restaurant($id)->id);?></span></a></li>
                      <?php else: ?>
                         <li><a href="javascript:;" class="c_red"><span><?= html_escape($day);?></span>  &nbsp; <i class="icofont-close-line c_red"></i> &nbsp; <?= lang('close'); ?></a></li>
                      <?php endif;?>
                    <?php endif ?>
                <?php $i++; endforeach ?>
              </ul>
            </div>
          </div>
        <?php endif;?>

        <div class=" col-6 col-sm-4 col-lg-4 sm-p-5">
          <div class="left_footer">
            <h4><?=  !empty(lang('quick_links'))?lang('quick_links'):"Quick Links";?></h4>
            <ul class="row_ul">
              <li><a href="<?= url($slug);?>"><i class="icofont-simple-right"></i> <?=  !empty(lang('home'))?lang('home'):"home";?></a></li>

              <?php if(is_feature($id,'reservation')==1 && is_active($id,'reservation')): ?>
                <li><a href="<?= url('reservation/'.$slug);?>"><i class="icofont-simple-right"></i> <?=  !empty(lang('reservation'))?lang('reservation'):"reservation";?></a></li>
              <?php endif;?>

              <li><a href="<?= url('about-us/'.$slug);?>"><i class="icofont-simple-right"></i> <?=  !empty(lang('about_us'))?lang('about_us'):"About Us";?></a></li>

              <li><a href="<?= url('track-order/'.$slug) ;?>" ><i class="icofont-simple-right"></i> <?=  !empty(lang('track_order'))?lang('track_order'):"track order";?></a></li>
              
              <?php if(is_feature($id,'contacts')==1 && is_active($id,'contacts')): ?>
                <li><a href="<?= url('shop-contacts/'.$slug);?>"><i class="icofont-simple-right"></i> <?=  !empty(lang('contacts'))?lang('contacts'):"contacts";?></a></li>
              <?php endif;?>

              <?php if(isset(restaurant($id)->is_review) && restaurant($id)->is_review==1): ?>
                <li><a href="<?= url('shop-reviews/'.$slug);?>"><i class="icofont-simple-right"></i> <?=  !empty(lang('reviews'))?lang('reviews'):"reviews";?></a></li>
              <?php endif;?>

              <li><a href="<?= base_url('staff-login/customer') ;?>"><i class="icofont-simple-right"></i> <?=  !empty(lang('login'))?lang('login'):"Login";?></a></li>

             
            </ul>
          </div>
        </div>
     

      </div>
    </div>
    
  </div>
  <div class="footer_bottom text-center">
    <p>©  <?= html_escape(!empty(restaurant($id)->name)?restaurant($id)->name:restaurant($id)->username); ?> </p>
  </div>
</div>



  <?php endif ?>
