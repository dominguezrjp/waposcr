<div class="col-md-3">
	<div class="card">
		<div class="card-body">
			<div class="leftSidebar">
				<ul class="flex-column">
					<li><a href="<?= base_url('admin/settings/settings'); ?>" class="<?= isset($page_title) && $page_title == "Settings"?"active":"" ;?>"><i class="fa fa-cog"></i> <?= !empty(lang('general'))?lang('general'):"general"; ?></a></li>

					<li><a href="<?= base_url('admin/settings/preferences'); ?>" class="<?= isset($page_title) && $page_title == "Preferences"?"active":"" ;?>"> <i class="icofont-badge"></i> <?= !empty(lang('preferences'))?lang('preferences'):"Preferences"; ?></a></li>

					<li><a href="<?= base_url('admin/settings/appearance'); ?>" class="<?= isset($page_title) && $page_title == "Appearance"?"active":"" ;?>"> <i class="fas fa-paint-brush"></i> <?= !empty(lang('appearance'))?lang('appearance'):"appearance"; ?></a> <span class="ab-position custom_badge danger-light-active"><?= lang('new') ;?></span></li>

					<li class="hidden"><a href="" class="<?= isset($page_title) && $page_title == "Settings"?"active":"" ;?>"> <i class="icofont-ui-text-chat"></i> <?= !empty(lang('twillo_sms_settings'))?lang('twillo_sms_settings'):"Twillo sms settings"; ?></a></li>

					<li><a href="<?= base_url('admin/settings/email_settings'); ?>" class="<?= isset($page_title) && $page_title == "Email Settings"?"active":"" ;?>"><i class="icofont-at"></i> <?= !empty(lang('email_settings'))?lang('email_settings'):"Email settings"; ?></a></li>


					<li><a href="<?= base_url('admin/settings/payment_settings'); ?>" class="<?= isset($page_title) && $page_title == "Payment Settings"?"active":"" ;?>"><i class="icofont-pay"></i> <?= !empty(lang('payment_settings'))?lang('payment_settings'):"Payment settings"; ?></a></li>

					<li><a href="<?= base_url('admin/settings/recaptcha_settings'); ?>" class="<?= isset($page_title) && $page_title == "Recaptcha Settings"?"active":"" ;?>" ><i class="icofont-key-hole"></i> <?= !empty(lang('recaptcha_settings'))?lang('recaptcha_settings'):"Recaptcha Settings"; ?></a></li>

					<li><a href="<?= base_url('admin/settings/seo_settings'); ?>" class="<?= isset($page_title) && $page_title == "Seo Settings"?"active":"" ;?>" ><i class="icofont-search-2"></i> <?= !empty(lang('seo_settings'))?lang('seo_settings'):"Seo Settings"; ?></a></li>
					<li><a href="<?= base_url('admin/settings/home_settings'); ?>" class="<?= isset($page_title) && $page_title == "Social Settings"?"active":"" ;?>" ><i class="icofont-ui-social-link"></i> <?= !empty(lang('social_sites'))?lang('social_sites'):"Social Sites";?></a></li>

					<li><a href="<?= base_url('admin/settings/landing_page'); ?>" class="<?= isset($page_title) && $page_title == "Landing Page Settings"?"active":"" ;?>" ><i class="icofont-laptop-alt"></i> <?= !empty(lang('custom_landing_page'))?lang('custom_landing_page'):"Custom Landing Page";?> </a></li>

					<li><a href="<?= base_url('admin/settings/extras'); ?>" class="<?= isset($page_title) && $page_title == "Extras"?"active":"" ;?>" ><i class="icofont-ui-next"></i> <?= !empty(lang('extras'))?lang('extras'):"Extras";?> </a></li>
					
					<?php if(check()==1): ?>
						<li><a href="<?= base_url('admin/settings/pwa_config') ?>" class="<?= isset($page_title) && $page_title == "PWA Config"?"active":"" ;?> <?= is_package;?>"><i class="icofont-share-alt"></i> <?= lang('pwa_config');?></a></li>
					<?php endif;?>
					<li><a href="<?= base_url('admin/settings/notification') ?>" class="<?= isset($page_title) && $page_title == "Notification"?"active":"" ;?> hidden"><i class="icofont-hand-drag1"></i> <?= lang('onsignal_api');?></a> </li>

					<li><a href="<?= base_url('admin/settings/pusher') ?>" class="<?= isset($page_title) && $page_title == "Pusher"?"active":"" ;?> hidden"><i class="fab fa-pushed"></i> <?= lang('pusher');?></a> </li>
				</ul>
			</div>
		</div>
	</div>
	</div><!-- col-md-3 -->