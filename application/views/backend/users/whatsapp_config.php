<div class="row">
	<div class="col-md-5">
		<form class="email_setting_form validForm" action="<?= base_url('admin/auth/add_whatsapp_config');?>" method="post" enctype= "multipart/form-data" autocomplete="off">
			<?= csrf();?>
			<div class="card">
				<div class="card-header">
					<h4><?= lang('whatsapp_config'); ?></h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 mb-20">
							<div class="custom-control custom-switch prefrence-item ml-10">
								<div class="gap">
									<input type="checkbox" id="whatsapp_order" name="is_whatsapp" class="switch-input "  <?= isset(restaurant()->is_whatsapp) && restaurant()->is_whatsapp==1?"checked" : "" ;?>>

									<label for="whatsapp_order" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

								</div>
								<div class="preText">
									<div class="">
										<label class="custom-control-label"><?= !empty(lang('whatsapp_order'))?lang('whatsapp_order'):'Whatsapp Order' ;?></label>
										<p class="text-muted"><small><?= !empty(lang('enable_to_allow_in_your_system'))?lang('enable_to_allow_in_your_system'):"Enable to allow in your system"; ?>.</small></p>
									</div>
								</div>
							</div><!-- custom-control -->
						</div>

						<div class="form-group col-md-12">
							<label><?= !empty(lang('whatsapp_number'))?lang('whatsapp_number'):"Whatsapp Number";?>  <span class="error">*</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-whatsapp"></i> <?= restaurant()->dial_code ;?></span>
								<input type="text" name="whatsapp_number"  class="form-control" placeholder="<?= !empty(lang('whatsapp_number'))?lang('whatsapp_number'):"Whatsapp Number";?>" value="<?= isset(restaurant()->whatsapp_number) && !empty(restaurant()->whatsapp_number)?restaurant()->whatsapp_number : "" ;?>" required>
							</div>

						</div>


						<div class="form-group col-md-12">
							
							<label><?= !empty(lang('whatsapp_message'))?lang('whatsapp_message'):"Whatsapp message";?>  <span class="error">*</label>
								<div class="mb-5">
									<code>{CUSTOMER_NAME}, {ORDER_ID}, {ITEM_LIST}, {SHOP_NAME}, {SHOP_ADDRESS}, {TRACK_URL}</code>
								</div>
								<textarea name="whatsapp_msg" class="form-control" cols="5" rows="15" required><?= isset(restaurant()->whatsapp_msg) && !empty(restaurant()->whatsapp_msg)?json_decode(restaurant()->whatsapp_msg): "" ;?></textarea>

						</div>

						<div class="form-group col-md-12">
							<label><?= lang('enable_whatsapp_for_order');?></label>
							<div class="orderTypes mt-10">
								<?php $enable_for = !empty(restaurant()->whatsapp_enable_for)?json_decode(restaurant()->whatsapp_enable_for,true):'' ?>
								<?php foreach ($order_types as $value): ?>
									<label class="custom-checkbox"><input type="checkbox" name="whatsapp_for[<?= $value['slug'];?>]" value="1" <?= isset($enable_for[$value['slug']]) && $enable_for[$value['slug']]==1?"checked":"";?>> <?= $value['type_name'];?></label>
								<?php endforeach; ?>
							</div>
						</div>

					</div><!-- row -->
				</div><!-- card-body -->
				<div class="card-footer text-right">
					<input type="hidden" name="id" value="<?= isset(restaurant()->id)?html_escape(restaurant()->id):0; ?>">
					<button type="submit" class="btn btn-secondary"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</form>
	</div><!-- col-9 -->
	
		
</div>


































































