<?php $settings = settings(); ?>
<div class="left_login_page login_banner" style="background: url(<?= base_url('assets/frontend/images/login_banner.jpg') ;?>);">
	<div class="left_top_login">
		<h4 ><?= $settings['site_name']; ?></h4>
		<p><?= $settings['description']; ?></p>
		<?php  $home_setting = isJson($settings['social_sites'])?json_decode($settings['social_sites'],TRUE):''; ?>
		<div class="left_footer">
			<ul class="">
				<?php if(!empty($home_setting['facebook'])): ?>
					<li><a href="<?= redirect_url($home_setting['facebook'],'');?>"><i class="fa fa-facebook facebook"></i></a></li>
				<?php endif;?>

				<?php if(!empty($home_setting['instagram'])): ?>
					<li><a href="<?= redirect_url($home_setting['instagram'],'');?>"><i class="fa fa-instagram instagram"></i></a></li>
				<?php endif;?>

				<?php if(!empty($home_setting['whatsapp'])): ?>
					<li><a href="<?= redirect_url($home_setting['whatsapp'],'whatsapp',admin()->dial_code);?>"><i class="fa fa-whatsapp whatsapp"></i></a></li>
				<?php endif;?>

				<?php if(!empty($home_setting['linkedin'])): ?>
					<li><a href="<?= redirect_url($home_setting['linkedin'],'');?>"><i class="fa fa-linkedin linkedin"></i></a></li>
				<?php endif;?>
			</ul>
		</div>
	</div>
</div>