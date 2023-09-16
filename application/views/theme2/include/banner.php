<?php include APPPATH.'views/common_layouts/topMenu.php' ?>
<?php $user_settings = u_settings($id); ?>
<?php if(isset($user_settings['is_banner']) && $user_settings['is_banner']==0): ?>
   <section class="user_home_banner img bg_loader" data-src="<?= base_url(!empty(restaurant($id)->cover_photo)?restaurant($id)->cover_photo:'assets/frontend/images/bg/bg_1.jpg') ;?>" style="background: url(<?=bg_loader() ;?>);">
  <div class="container">
    <div class="single_banner">
      <img src="<?=  html_escape(!empty($shop['thumb'])?base_url($shop['thumb']):'');?>" alt="">
      <div class="userbanner_right">
        <div class="userbanner_top">
          <h4><?=  html_escape(!empty($shop['name'])?$shop['name']:$shop['username']);?></h4>
          <p><?=  html_escape(!empty($user['full_name'])?$user['full_name']:$user['username']);?></p>
        </div>
        <div class="userbanner_bottpm">
           <?php if(!empty($shop['location'])): ?>
            <p class="address"><i class="icofont-google-map"></i> <a href="<?= redirect_url($shop['location'],'google') ;?>"><?= $shop['address'] ;?></a></p>
            <?php endif;?>
          <div class="social_icon_section">
             <div class="home_social list style_1">
               <ul>

                <?php if(!empty($shop['phone'])): ?>
                 <li><a href="<?= redirect_url($shop['phone'],'phone',$shop['dial_code']) ;?>"><i class="fas fa-phone fa-flip-horizontal phone"></i> <?= html_escape($shop['phone']) ;?> </a></li>
                <?php endif;?>

                <?php if(!empty($social['whatsapp'])): ?>
                  <li><a href="<?= redirect_url($social['whatsapp'],'whatsapp',$shop['dial_code']) ;?>"><i class="fab fa-whatsapp whatsapp"></i> <?= html_escape($social['whatsapp']) ;?></a></li>
                <?php endif;?>

                <?php if(!empty($shop['email'])): ?>
                 <li><a href="<?= redirect_url(strtolower(!empty(u_settings($id)['smtp_mail'])?u_settings($id)['smtp_mail']:html_escape($shop['email'])),'email'); ?>"><i class="fas fa-envelope email"></i> <?= strtolower(!empty(u_settings($id)['smtp_mail'])?u_settings($id)['smtp_mail']:html_escape($shop['email'])); ?></a></li>
                <?php endif;?>
               </ul>
             </div>
           </div><!--social_icon_section-->
        </div>
      </div>
    </div>
  </div>
</section>

<?php endif; ?>

