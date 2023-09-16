<div class="row">
	<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	<div class="col-md-6">
		<?php $data = @json_decode($settings['twillo_sms_settings'],true); ?>
		<form class="email_setting_form" action="<?= base_url('admin/auth/add_twillo_sms_settings') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<?= csrf() ;?>
			<div class="card">
				<div class="card-header">
					<h4><?= lang('twilo_sms_settings'); ?></h4>
				</div>
				<div class="card-body">
					<div class="row">
					    <div class="form-group col-md-12">
					      	<label><?= !empty(lang('account_sid'))?lang('account_sid'):"Account SID";?></label>
					        <input type="text" name="account_sid" id="account_sid" class="form-control" placeholder="<?= !empty(lang('account_sid'))?lang('account_sid'):"account sid";?>" value="<?= isset($data['account_sid'])?html_escape($data['account_sid']):""; ?>">
					    </div>

					    <div class="form-group col-md-12">
					      	<label><?= !empty(lang('auth_token'))?lang('auth_token'):"Auth Token";?></label>
					        <input type="text" name="auth_token" id="auth_token" class="form-control" placeholder="<?= !empty(lang('auth_token'))?lang('auth_token'):"auth token";?>" value="<?= isset($data['auth_token'])?html_escape($data['auth_token']):""; ?>">
					    </div>

					    <div class="form-group col-md-12">
					      	<label for="price"><?= !empty(lang('twillo_virtual_number'))?lang('twillo_virtual_number'):"Twillo Virtual Number";?></label>
					        <input type="text" name="virtual_number" id="virtual_number" class="form-control" placeholder="<?= !empty(lang('virtual_number'))?lang('virtual_number'):"virtual number";?>" value="<?= isset($data['virtual_number'])?html_escape($data['virtual_number']):""; ?>">
					    </div>

					    <div class="form-group col-md-12">
					    	<label for="price"><?= !empty(lang('accept_message'))?lang('accept_message'):"Accept Message";?> <i class="fa fa-info-circle" data-target="#hintsModal" data-toggle="modal" title="How to set message"></i>
					    	</label>
					      	<div class="mb-5">
					      		<code>{SHOP_NAME}, {USER_NAME}, {ORDER_ID}</code>
					      	</div>
					        <textarea name="accept_msg" id="accept_msg" cols="5" rows="5" class="form-control"><?= isset($data['accept_msg'])?json_decode($data['accept_msg']):""; ?></textarea>
					    </div>

					    <div class="form-group col-md-12">
					      	<label for="price"><?= !empty(lang('completed_message'))?lang('completed_message'):"Completed Message";?> <i class="fa fa-info-circle" data-target="#hintsModal" data-toggle="modal" title="How to set message"></i></label>
					      	<div class="mb-5">
					      		<code>{SHOP_NAME}, {USER_NAME}, {ORDER_ID}</code>
					      	</div>
					        <textarea name="complete_msg" id="accept_msg" cols="5" rows="5" class="form-control"><?= isset($data['complete_msg'])?json_decode($data['complete_msg']):""; ?></textarea>
					    </div>


					     <div class="form-group col-md-6">
					      	<label for="price"><?= !empty(lang('accept_sms'))?lang('accept_sms'):"Accept SMS";?></label>
					       <div class="">
					       	<select name="is_accept_sms" id="is_sms" class="form-control">
					       		<option value="1" <?= isset($data['is_accept_sms']) && $data['is_accept_sms'] ==1?"selected":""; ?>><?= lang('active'); ?></option>
					       		<option value="0" <?= isset($data['is_accept_sms']) && $data['is_accept_sms'] ==0?"selected":""; ?>><?= lang('inactive'); ?></option>
					       	</select>
					       </div>
					    </div>

					     <div class="form-group col-md-6">
					      	<label for="price"><?= !empty(lang('complete_sms'))?lang('complete_sms'):"Complete SMS";?></label>
					       <div class="">
					       	<select name="is_complete_sms" id="is_complete_sms" class="form-control">
					       		<option value="1" <?= isset($data['is_complete_sms']) && $data['is_complete_sms'] ==1?"selected":""; ?>><?= lang('active'); ?></option>
					       		<option value="0" <?= isset($data['is_complete_sms']) && $data['is_complete_sms'] ==0?"selected":""; ?>><?= lang('inactive'); ?></option>
					       	</select>
					       </div>
					    </div>
					    
					</div><!-- row -->
						
				</div><!-- card-body -->
				<div class="card-footer">
					<input type="hidden" name="id" value="<?= isset($settings['id']) && $settings['id'] !=0?$settings['id']:0 ?>">
					<button type="submit" class="btn btn-secondary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</form>
	</div><!-- col-9 -->
	
</div>














