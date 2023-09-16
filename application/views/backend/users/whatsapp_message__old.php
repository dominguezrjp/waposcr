<div class="row">
	<?php include 'inc/leftsidebar.php' ?>
	<form class="email_setting_form validForm" action="<?= base_url('admin/auth/add_whatsapp_message');?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<div class="col-md-5">
			<div class="card">
				<div class="card-header">
					<h4><?= lang('whatsapp_message'); ?></h4>
				</div>
				<div class="card-body">
					<div class="row">

						<div class="form-group col-md-12">
							<label><?= !empty(lang('accept_message'))?lang('accept_message'):"accept_message";?>  <span class="error">*</label>
								<div class="mb-5">
									<code>{ORDER_ID}</code>
								</div>
								<textarea name="accept_message" class="form-control" cols="5" rows="10" required><?= isset(restaurant()->accept_message) && !empty(restaurant()->accept_message)?json_decode(restaurant()->accept_message): "" ;?></textarea>
						</div>

						<div class="form-group col-md-12">
							<label><?= lang('completed_message');?>  <span class="error">*</label>
								<div class="mb-5">
									<code>{ORDER_ID}</code>
								</div>
								<textarea name="completed_message" class="form-control" cols="5" rows="10" required><?= isset(restaurant()->completed_message) && !empty(restaurant()->completed_message)?json_decode(restaurant()->completed_message): "" ;?></textarea>
						</div>
						<div class="form-group col-md-12">
							<label><?= lang('delivered_message');?>  <span class="error">*</label>
								<div class="mb-5">
									<code>{DELIVERY_COMPANY}, {TRACKING_NUMBER}, {ORDER_ID}</code>
								</div>
								<textarea name="delivered_message" class="form-control" cols="5" rows="10" required><?= isset(restaurant()->delivered_message) && !empty(restaurant()->delivered_message)?json_decode(restaurant()->delivered_message): "" ;?></textarea>
							</div>

					</div><!-- row -->
				</div><!-- card-body -->
				<div class="card-footer text-right">
					<input type="hidden" name="id" value="<?= isset(restaurant()->id)?html_escape(restaurant()->id):0; ?>">
					<button type="submit" class="btn btn-secondary"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</div><!-- col-9 -->
	</form>
		
</div>








































































