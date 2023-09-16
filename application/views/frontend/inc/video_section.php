<section class="hero-banner home_section home_banner video_banner" style="background: url(<?= base_url(!empty($user['cover_photo'])?$user['cover_photo']:'assets/frontend/images/home_banner.jpg') ;?>);">
	<div class="container">
		<div class="hero_baner_content">
			<div class="hero_details">
				<h4><?= lang('lets_work_together'); ?></h4>
				<p><?= lang('join_our_team_text'); ?></p>
			</div>
			<?php if(isset($about[0]['video_link']) && !empty($about[0]['video_link'])): ?>
           		<div class="video_play_btn">
           			<a href="<?=  $about[0]['video_link'];?>" class="play-btn venobox" data-autoplay="true" data-vbtype="video"><i class="icofont-play"></i></a>
           		</div>
        	<?php endif;?>
			
		</div>
	</div>
</section>