<section class="hero-banner home_section home_banner video_banner bg_loader" data-src="<?=!empty($home['images'])?base_url(html_escape($home['images'])):base_url('assets/frontend/images/banner.png');?>"  style="background: url(<?= bg_loader();?>)">
	<div class="container">
		<div class="hero_baner_content">
			<div class="heroWrapper row">
				<div class="col-md-4">
					<div class="leftHero">
						<div class="pb-10">
							<h5><?= lang('choose_restaurant_name'); ?></h5>
							<p><?= lang('create_the_first_impression'); ?></p>
						</div>
						<div class="form-group resturant_name">
							<input type="text" name="username" class="form-control checkUsername" id="username" placeholder="<?= lang('write_you_name_here'); ?>" autocomplete="off">
							<button class="btn btn-info reg_btn create_btn createBtn" disabled><?= lang('create'); ?></button>
						</div>
						<div class="alert_msg heroSearch"></div>
						<div class="register_loader" style="display:none ;">
							<div class="searching heroSearch"></div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="rightHero">
						<h4><?= lang('try_with_qr_code'); ?></h4>
						<div class="qrImg">
							<img src="<?= base_url(html_escape(settings()['site_qr_link']))?>" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>