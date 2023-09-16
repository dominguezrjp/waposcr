<?php include "topMenu.php"; ?>
<?php $user_settings = u_settings($id); ?>
<?php if(isset($user_settings['is_banner']) && $user_settings['is_banner']==0): ?>
<section class="user_home_banner img bg_loader" data-src="<?= base_url(!empty(restaurant($id)->cover_photo)?restaurant($id)->cover_photo:'assets/frontend/images/bg/bg_1.jpg') ;?>" style="background: url(<?=bg_loader() ;?>);">
  <div class="userHomebanner_wrapper">
  <div class="row">
    <div class="col-lg-12">
      <div class="homeBanner_left">
        <div class="shopLogo">
        		<img src="<?=  !empty(restaurant($id)->thumb)? base_url(restaurant($id)->thumb):base_url("assets/frontend/images/logo-example.png") ?>" alt="shopLogo" class="">
        </div>		
        <div class="homeBanner_btn">
          <?php if(is_feature($id,'reservation')==1 && is_active($id,'reservation')): ?>
            <a href="<?= base_url('reservation/'.$slug) ;?>" class="btn  home-book-btn btn-shadow"><?= lang('book_now'); ?></a>
          <?php endif;?>

          <?php if(!empty($social['youtube'])): ?>
            <a href="<?=  $social['youtube'];?>" class="btn  watch_video venobox" data-autoplay="true" data-vbtype="video"><i class="icofont-play watch_video_i"></i> <?= lang('watch_video'); ?></a>
          <?php endif;?>
        </div>
        <?php $u_settngs = $this->common_m->get_user_settings($id); ?>
        <div class="homeBanner_Service">
          <ul>
          	<?php if(!empty($u_settngs['icon_settings']) && count(json_decode($u_settngs['icon_settings'])) > 0): ?>
	          	<?php foreach (json_decode($u_settngs['icon_settings']) as $key => $us): ?>
		          	<li>
		              <div class="homeBanner_singleService">
		                <div class="homeBanner_serviceImg">
		                  <?php if($us->is_img==1): ?>
		                  	<img src="<?= $us->img_url ;?>" alt="IconImg">
		                  <?php else: ?>
		                  	<?= $us->icon ;?>
		                  <?php endif;?>
		                </div>
		                <p><?= $us->title; ?></p>
		              </div>
		            </li>
	          	<?php endforeach; ?>
          	<?php else: ?>
	            <li>
	              <div class="homeBanner_singleService">
	                <div class="homeBanner_serviceImg">
	                  <i class="icofont-fast-delivery"></i>
	                </div>
	                <p><?= lang('fast_service'); ?></p>
	              </div>
	            </li>
	            <li>
	              <div class="homeBanner_singleService">
	                <div class="homeBanner_serviceImg">
	                  <i class="icofont-fast-food"></i>
	                </div>
	                <p><?= lang('fresh_food'); ?></p>
	              </div>
	            </li>
	            <li>
	              <div class="homeBanner_singleService">
	                <div class="homeBanner_serviceImg img">
	                  <i class="icofont-live-support"></i>
	                </div>
	                <p><?= lang('24_support'); ?></p>
	              </div>
	            </li>
       		 <?php endif;?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="userHome_social">
    <ul>
      <?php if(!empty($social['facebook'])): ?>
        <li><a href="<?= redirect_url($social['facebook'],'facebook');?>"><i class="icofont-facebook facebook"></i></a></li>
      <?php endif; ?>

      <?php if(!empty($social['twitter'])): ?>
      <li><a href="<?= redirect_url($social['twitter'],'twitter');?>"><i class="icofont-twitter twitter"></i></a></li>
      <?php endif; ?>

      <?php if(!empty($social['instagram'])): ?>
      <li><a href="<?= redirect_url($social['instagram'],'instagram');?>"><i class="icofont-instagram instagram"></i></a></li>
      <?php endif; ?>
      
      <?php if(!empty($social['whatsapp'])): ?>
      <li><a href="<?= redirect_url($social['whatsapp'],'whatsapp',$shop['dial_code'],base_url($shop['username']));?>"><i class="icofont-whatsapp whatsapp"></i></a></li>
      <?php endif; ?>
    </ul>
  </div>
</div>
</section>
<?php endif; ?>