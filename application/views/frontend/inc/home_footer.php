
<div class="footer_area">
  <div class="top_footer">
    <div class="container">
      <div class="row">

        <?php  $home_setting = json_decode($settings['social_sites'],TRUE); ?>
        <div class=" col-lg-4 col-sm-4 col-xs-12">
          <div class="left_footer">
            <div class="footerLogo">
              <img src="<?= base_url(!empty($settings['logo'])?$settings['logo']:"assets/frontend/images/logo-example.png"); ?>" alt="logo" >
            </div>
            <h4><?= html_escape($settings['site_name']); ?></h4>
            <p><a href="<?=  redirect_url(html_escape(!empty($home_setting['email'])?$home_setting['email']:$settings['smtp_mail']),'email');?>"><i class="icofont-email"></i> &nbsp;<?= strtolower(!empty($home_setting['email'])?$home_setting['email']:$settings['smtp_mail']); ?></a></p>
            <ul class="">
              <?php if(!empty($home_setting['facebook'])): ?>
                <li><a href="<?= redirect_url($home_setting['facebook'],'facebook');?>"><i class="fa fa-facebook facebook"></i></a></li>
              <?php endif;?>

              <?php if(!empty($home_setting['instagram'])): ?>
                <li><a href="<?= redirect_url($home_setting['instagram'],'instagram');?>"><i class="fa fa-instagram instagram"></i></a></li>
              <?php endif;?>

              <?php if(!empty($home_setting['whatsapp'])): ?>
                <li><a href="<?= redirect_url($home_setting['whatsapp'],'whatsapp',admin()->dial_code,base_url());?>"><i class="fa fa-whatsapp whatsapp"></i></a></li>
              <?php endif;?>

              <?php if(!empty($home_setting['linkedin'])): ?>
                <li><a href="<?= redirect_url($home_setting['linkedin'],'linkedin');?>"><i class="fa fa-linkedin linkedin"></i></a></li>
              <?php endif;?>


               <?php if(!empty($home_setting['phone'])): ?>
                <li><a href="<?= redirect_url($home_setting['phone'],'phone',admin()->dial_code);?>"><i class="fa fa-phone phone"></i></a></li>
              <?php endif;?>
            </ul>
          </div>
        </div>

        <div class=" col-6 col-sm-4 col-lg-4">
          <div class="left_footer">
            <h4><?=  !empty(lang('quick_links'))?lang('quick_links'):"Quick Links";?></h4>
            <ul class="row_ul">
              <li><a href="<?= base_url();?>"><i class="icofont-simple-right"></i> <?=  !empty(lang('home'))?lang('home'):"home";?></a></li>
              <?php if($settings['is_user']==1): ?>
                  <li><a href="<?= base_url('users');?>"><i class="icofont-simple-right"></i> <?=  !empty(lang('users'))?lang('users'):"users";?></a></li>
              <?php endif; ?>

               <?php if(!empty(section_name('contacts')) && section_name('contacts')['status']==1): ?>
                <li><a href="<?= base_url('contacts');?>"><i class="icofont-simple-right"></i> <?=  !empty(lang('contacts'))?lang('contacts'):"contacts";?></a></li>
              <?php endif;?>
              <?php $terms = $this->admin_m->single_select('terms'); ?>
              <?php $privacy = $this->admin_m->single_select('privacy'); ?>
              <?php if(isset($terms['status']) && $terms['status']==1): ?>
                <li><a href="<?= base_url('terms-conditions');?>" target="blank"><i class="icofont-simple-right"></i> <?=  !empty(lang('terms_condition'))?lang('terms_condition'):"Terms & Condition";?></a></li>
              <?php endif; ?>

              <?php if(isset($privacy['status']) && $privacy['status']==1): ?>
                <li><a href="<?= base_url('cookies-privacy');?>" target="blank"><i class="icofont-simple-right"></i> <?=  !empty(lang('cookies_privacy'))?lang('cookies_privacy'):"privacy & cookie";?> </a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>

        <?php $pages = $this->admin_m->select_active_all('pages'); ?>
        <?php if(isset($pages) && count($pages) >0): ?>
          <div class="col-6 col-sm-4 col-lg-4">
            <div class="left_footer">
              <h4><?=  !empty(lang('pages'))?lang('pages'):"pages";?></h4>
              <ul class="row_ul">
                <?php foreach ($pages as $key => $s_page): ?>
                  <li><a href="<?= base_url('pages/'.$s_page['slug']);?>" target="blank"><i class="icofont-simple-right"></i> <?= character_limiter($s_page['title'],50);?></a></li>
                <?php endforeach ?>
              </ul>
            </div>
          </div>
        <?php endif;?>
        


      </div>
    </div>
    
  </div>
  <div class="footer_bottom text-center">
    <p>©  <?= !empty($settings['copyright'])?$settings['copyright']:'All Rights reserved.';?> </p>
  </div>
</div>

<div class="cookie-container">
  <p>
   <?= lang('cookies_msg_1'); ?>
    <?= lang('cookies_msg_2'); ?>
    <a href="<?= base_url('cookies-privacy') ?>"><?= lang('cookies_privacy'); ?></a>
  </p>

  <button class="cookie-btn">
    <?= lang('ok'); ?>
  </button>
</div>

