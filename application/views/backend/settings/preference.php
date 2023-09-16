<div class="row">
	<?php include 'inc/leftsidebar.php'; ?>
	<div class="col-md-7">
		<div class="card">
			<div class="card-body">
				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="is_pwa" name="set-name" class="switch-input setting_option" data-type="is_pwa" data-value="<?= $settings['is_pwa'];?>" <?= isset($settings['is_pwa']) && $settings['is_pwa']==1?'checked':'';?>>
						<label for="is_pwa" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= lang('on'); ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= lang('off'); ?></span> </label>

					</div>
					<div class="preText">
						<label class="custom-control-label"><?= lang('pwa');?></label>
					    <p class="text-muted"><small><?=lang('enable_to_allow_for_all'); ?>.</small>  <span class="ab-position custom_badge danger-light-active"><?= lang('new') ;?></p>
					   </span>
					</div>
				</div>


				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="is_registration" name="set-name" class="switch-input setting_option" data-type="is_registration" data-value="<?= $settings['is_registration'];?>" <?= isset($settings['is_registration']) && $settings['is_registration']==1?'checked':'';?>>
						<label for="is_registration" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= lang('on'); ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= lang('off'); ?></span></label>

					</div>
					<div class="preText">
						<label class="custom-control-label"><?= !empty(lang('reg_system'))?lang('reg_system'):"Registration System";?></label>
					    <p class="text-muted"><small><?= !empty(lang('enable_to_allow_signup_system'))?lang('enable_to_allow_signup_system'):"Enable to allow sign up users to your system"; ?>.</small></p>
					</div>
				</div>

				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="auto_approval" name="set-name" class="switch-input setting_option" data-type="auto_approval" data-value="<?= $settings['auto_approval'];?>" <?= isset($settings['auto_approval']) && $settings['auto_approval']==1?'checked':'';?>>
						<label for="auto_approval" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= lang('on'); ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= lang('off'); ?></span></label>

					</div>
					<div class="preText">
						<label class="custom-control-label"><?= !empty(lang('auto_approval'))?lang('auto_approval'):"Auto Approve";?></label>
					    <p class="text-muted"><small><?= !empty(lang('enable_to_allow_auto_approve'))?lang('enable_to_allow_auto_approve'):"Enable to allow auto-approved when users sign up to your system"; ?>.</small></p>
					</div>
				</div> 
				<!-- custom control -->

				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="is_email_verification" name="set-name" class="switch-input setting_option" data-type="is_email_verification" data-value="<?= $settings['is_email_verification'];?>" <?= isset($settings['is_email_verification']) && $settings['is_email_verification']==1?'checked':'';?>>
						<label for="is_email_verification" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= lang('on'); ?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= lang('off'); ?></span></label>

					</div>
					<div class="preText">
						<label class="custom-control-label"><?= !empty(lang('email_verify'))?lang('email_verify'):"Email Verification";?></label>
					    <p class="text-muted"><small><?= !empty(lang('enable_to_allow_email_verification'))?lang('enable_to_allow_email_verification'):"Enable to allow email verification when users sign up to your system"; ?>.</small></p>
					</div>
				</div> 
				<!-- custom control -->

				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="is_email_verify_free" name="set-name" class="switch-input setting_option" data-type="is_email_verify_free" data-value="<?= $settings['is_email_verify_free'];?>" <?= isset($settings['is_email_verify_free']) && $settings['is_email_verify_free']==1?'checked':'';?>>
						<label for="is_email_verify_free" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>
					</div>
					<div class="preText">
						<label class="custom-control-label"><?= !empty(lang('free_verify'))?lang('free_verify'):"Email Free user verification";?></label>
					    <p class="text-muted"><small><?= !empty(lang('enable_to_allow_free_email_verification'))?lang('enable_to_allow_free_email_verification'):"Enable to allow email verification when users sign up with free package to your system"; ?>.</small></p>
					</div>
				</div> 
				<!-- custom control -->
				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="user_invoice" name="set-name" class="switch-input setting_option" data-type="user_invoice" data-value="<?= $settings['user_invoice'];?>" <?= isset($settings['user_invoice']) && $settings['user_invoice']==1?'checked':'';?>>
						<label for="user_invoice" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>
					</div>
					<div class="preText">
						<label class="custom-control-label"><?= !empty(lang('user_invoice'))?lang('user_invoice'):"User Invoice";?></label>
					    <p class="text-muted"><small><?= !empty(lang('user_get_an_invoice'))?lang('user_get_an_invoice'):"Users get an invoice when signing up to your system"; ?>.</small></p>
					</div>
				</div> 
				<!-- custom control -->

				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="is_rating" name="set-name" class="switch-input setting_option" data-type="is_rating" data-value="<?= $settings['is_rating'];?>" <?= isset($settings['is_rating']) && $settings['is_rating']==1?'checked':'';?>>
						<label for="is_rating" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= lang('on'); ?><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>
					</div>
					<div class="preText">
						<label class="custom-control-label"><?= !empty(lang('rating'))?lang('rating'):"Rating";?></label>
					    <p class="text-muted"><small><?= !empty(lang('rating_in_landing_page'))?lang('rating_in_landing_page'):"Show rating in landing page"; ?>.</small></p>
					</div>
				</div> 
				<!-- custom control -->
				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="is_signup" name="set-name" class="switch-input setting_option" data-type="is_signup" data-value="<?= $settings['is_signup'];?>" <?= isset($settings['is_signup']) && $settings['is_signup']==1?'checked':'';?>>
						<label for="is_signup" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= lang('on'); ?><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>
					</div>
					<div class="preText">
						<label class="custom-control-label"><?= !empty(lang('is_signup'))?lang('is_signup'):"Signup button";?></label>
					    <p class="text-muted"><small><?= !empty(lang('show_signup_button'))?lang('show_signup_button'):"Enable to Show signup button in menu"; ?>.</small></p>
					</div>
				</div> 
				<!-- custom control -->
				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="is_auto_verified" name="set-name" class="switch-input setting_option" data-type="is_auto_verified" data-value="<?= $settings['is_auto_verified'];?>" <?= isset($settings['is_auto_verified']) && $settings['is_auto_verified']==1?'checked':'';?>>
						<label for="is_auto_verified" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= lang('on'); ?><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

					</div>
					<div class="preText">
						<label class="custom-control-label"><?= !empty(lang('is_auto_verified'))?lang('is_auto_verified'):"Auto Approved Trail user";?></label>
					    <p class="text-muted"><small><?= !empty(lang('auto_approve_trial_user'))?lang('auto_approve_trial_user'):"Enable to Auto Approved trial users when registration in system"; ?>.</small></p>
					</div>
				</div> 
				<!-- custom control -->


				<!-- custom control -->
				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="is_lang_list" name="set-name" class="switch-input setting_option" data-type="is_lang_list" data-value="<?= $settings['is_lang_list'];?>" <?= isset($settings['is_lang_list']) && $settings['is_lang_list']==1?'checked':'';?>>
						<label for="is_lang_list" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= lang('on'); ?><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

					</div>
					<div class="preText">
						<label class="custom-control-label"><?= !empty(lang('language_list'))?lang('language_list'):"Languages List";?></label>
					    <p class="text-muted"><small><?= !empty(lang('show_language_dropdown_in_home'))?lang('show_language_dropdown_in_home'):"Show Languages Dropdown in landing page"; ?>.</small></p>
					</div>
				</div> 
				<!-- custom control -->

				<!-- custom control -->
				<div class="custom-control custom-switch prefrence-item ml-10">
					<div class="gap">
						<input type="checkbox" id="is_item_search" name="set-name" class="switch-input setting_option" data-type="is_item_search" data-value="<?= $settings['is_item_search'];?>" <?= isset($settings['is_item_search']) && $settings['is_item_search']==1?'checked':'';?>>
						<label for="is_item_search" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= lang('on'); ?><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

					</div>
					<div class="preText">
						<label class="custom-control-label"><?= !empty(lang('item_search'))?lang('item_search'):"Item Search";?></label>
					    <p class="text-muted"><small><?= !empty(lang('show_item_search_in_landing_page'))?lang('show_item_search_in_landing_page'):"Show Item search  in landing page"; ?>.</small></p>
					</div>
				</div> 
				<!-- custom control -->
			</div>
		</div>
	</div>
</div>