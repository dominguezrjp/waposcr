<div class="row">
	<?php include APPPATH.'views/backend/common/inc/leftsidebar.php'; ?>
	<form class="email_setting_form validForm" action="<?= base_url('admin/restaurant/add_restaurant_config');?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<?php $social = json_decode($restaurant['social_list'],TRUE); ?>
		<div class="col-md-5">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="form-group col-sm-12">
							<label  class="control-label"><?= !empty(lang('county'))?lang('county'):"county";?><span class="alert_text">* </span></label>

							<div class="">
								<select name="country" id="" class="form-control country select2"> 
									<?php foreach ($countries as $key => $country): ?>
										<option <?= isset($restaurant['country_id']) && $restaurant['country_id']== $country['id']?"selected":"";  ;?> value="<?= $country['id'] ;?>" data-dial="<?=  $country['dial_code'];?>" ><?=  $country['name'];?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>


						<div class="form-group col-sm-6">
							<label  class="control-label"><?= !empty(lang('currency'))?lang('currency'):"currency";?><span class="alert_text">* </span></label>

							<div class="">
								<select name="currency" id="" class="form-control currency"> 
									<?php foreach ($countries as $key => $country): ?>
										<option <?= isset($restaurant['currency_code']) && $restaurant['currency_code']== $country['currency_code']?"selected":"";  ;?> value="<?= $country['id'] ;?>"><?=  $country['currency_name'].' ('.$country['currency_symbol'].' '.$country['currency_code'].')';?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>

						<div class="form-group col-sm-6">
							<label  class="control-label"><?= !empty(lang('dial_code'))?lang('dial_code'):"dial code";?><span class="alert_text">* </span></label>

							<div class="">
								<input type="text" name="dial_code" class="form-control dial_code" value="<?= !empty($restaurant['dial_code'])?$restaurant['dial_code']:''; ;?>" required>
							</div>
						</div>

						<div class="form-group col-sm-12">
							<label class="control-label"><?= !empty(lang('email'))?lang('email'):"email";?><span class="alert_text">* </span></label>

							<div class="">
								<input type="text" class="form-control"  name="email" placeholder="<?= !empty(lang('email'))?lang('email'):"Email";?>" value="<?= !empty($restaurant['email'])?$restaurant['email']:''; ?>" required>

							</div>
						</div>

						<div class="form-group col-sm-12">
							<label  class="control-label"><?= !empty(lang('phone'))?lang('phone'):"phone";?> <span class="alert_text">* <?= lang('must_unique_english'); ?></span></label>

							<div class="">
								<div class="input-group">
									<span class="input-group-addon"><?= restaurant()->dial_code ;?></span>
									<input type="text" name="phone" class="form-control"  placeholder="<?= !empty(lang('phone'))?lang('phone'):"Phone";?>" value="<?= !empty($restaurant['phone'])?$restaurant['phone']:''; ?>" required>
								</div>

							</div>
						</div>

						<div class="form-group col-sm-12">
							<label  class="control-label"><?= lang('currency_position');?></label>

							<select name="currency_position" class="form-control">
								<option value="1" <?= isset($restaurant['currency_position']) && $restaurant['currency_position']== 1?"selected":"";  ;?>>100 $</option>
								<option value="2" <?= isset($restaurant['currency_position']) && $restaurant['currency_position']== 2?"selected":"";  ;?>>$ 100</option>
							</select>
						</div>


						<div class="form-group col-sm-12">
							<label  class="control-label"><?= lang('number_format');?></label>

							<select name="number_formats" class="form-control">
								<option value="0" <?= isset($restaurant['number_formats']) && $restaurant['number_formats']== 0?"selected":"";  ;?>> 100</option>
								<option value="1" <?= isset($restaurant['number_formats']) && $restaurant['number_formats']== 1?"selected":"";  ;?>>1000.00</option>
								<option value="2" <?= isset($restaurant['number_formats']) && $restaurant['number_formats']== 2?"selected":"";  ;?>>1.000,00</option>
								<option value="3" <?= isset($restaurant['number_formats']) && $restaurant['number_formats']== 3?"selected":"";  ;?>>1,000.00</option>
								<option value="4" <?= isset($restaurant['number_formats']) && $restaurant['number_formats']== 4?"selected":"";  ;?>>1,000,000</option>
							</select>
						</div>

						<div class="form-group col-sm-6">
							<label  class="control-label"><?= lang('date_format');?></label>

							<select name="date_format" class="form-control">
								<option value="1" <?= isset($restaurant['date_format']) && $restaurant['date_format']== 1?"selected":"";  ;?>> d-m-Y</option>
								<option value="2" <?= isset($restaurant['date_format']) && $restaurant['date_format']== 2?"selected":"";  ;?>>Y-m-d</option>
								<option value="3" <?= isset($restaurant['date_format']) && $restaurant['date_format']== 3?"selected":"";  ;?>>d/m/Y</option>
								<option value="4" <?= isset($restaurant['date_format']) && $restaurant['date_format']== 4?"selected":"";  ;?>>Y/m/d</option>
								<option value="5" <?= isset($restaurant['date_format']) && $restaurant['date_format']== 5?"selected":"";  ;?>>d.m.Y</option>
								<option value="6" <?= isset($restaurant['date_format']) && $restaurant['date_format']== 6?"selected":"";  ;?>>Y.m.d</option>
								<option value="7" <?= isset($restaurant['date_format']) && $restaurant['date_format']== 7?"selected":"";  ;?>>d M, Y</option>
								<option value="7" <?= isset($restaurant['date_format']) && $restaurant['date_format']== 7?"selected":"";  ;?>>d M, Y</option>
								<option value="8" <?= isset($restaurant['date_format']) && $restaurant['date_format']== 8?"selected":"";  ;?>>d M Y</option>
							</select>
						</div>

						<div class="form-group col-sm-6">
							<label  class="control-label"><?= lang('time_format');?></label>

							<select name="time_format" class="form-control">
								<option value="1" <?= isset($restaurant['time_format']) && $restaurant['time_format']== 1?"selected":"";  ;?>> 12 <?= lang('format');?></option>
								<option value="2" <?= isset($restaurant['time_format']) && $restaurant['time_format']== 2?"selected":"";  ;?>>24 <?= lang('format');?></option>
								
							</select>
						</div>
						

						

					</div><!-- row -->

					<div class="row pt-10" style="background: #f9f9f9;">
						<div class="form-group col-md-12">
							<h3><?= lang('social_sites'); ?></h3>
						</div>
						<div class="form-group col-md-12">
							<label><?= !empty(lang('whatsapp_number'))?lang('whatsapp_number'):"Whatsapp Number";?></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
								<input type="text" name="whatsapp"  class="form-control" placeholder="<?= !empty(lang('whatsapp_number'))?lang('whatsapp_number'):"Whatsapp Number";?>" value="<?= !empty($social['whatsapp'])?html_escape($social['whatsapp']):""; ?>">
							</div>

						</div>

						<div class="form-group col-md-12">
							<label><?= !empty(lang('youtube'))?lang('youtube'):"youtube";?></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-youtube"></i></span>
								
								<input type="text" name="youtube"  class="form-control" placeholder="<?= !empty(lang('youtube'))?lang('youtube'):"youtube";?>" value="<?= !empty($social['youtube'])?html_escape($social['youtube']):""; ?>">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label><?= !empty(lang('facebook'))?lang('facebook'):"facebook";?></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-facebook"></i></span>
								<input type="text" name="facebook"  class="form-control" placeholder="<?= !empty(lang('facebook_link'))?lang('facebook_link'):"facebook link";?>" value="<?= !empty($social['facebook'])?html_escape($social['facebook']):""; ?>">
							</div>

						</div>
						<div class="form-group col-md-12">
							<label><?= !empty(lang('website'))?lang('website'):"website";?></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fas fa-globe"></i></span>
								<input type="text" name="website"  class="form-control" placeholder="Website" value="<?= !empty($social['website'])?html_escape($social['website']):""; ?>">
							</div>

						</div>
						<div class="rows">
							<div class="form-group col-md-12">
								<label><?= !empty(lang('twitter'))?lang('twitter'):"twitter";?></label>
								<div class="input-group">
					                <span class="input-group-addon"><i class="fab fa-twitter"></i></span>
					               <input type="text" name="twitter"  class="form-control" placeholder="<?= !empty(lang('twitter'))?lang('twitter'):"twitter";?>" value="<?= !empty($social['twitter'])?html_escape($social['twitter']):""; ?>">
					             </div>
								
							</div>
							<div class="form-group col-md-12">
								<label><?= !empty(lang('instagram'))?lang('instagram'):"instagram";?></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fab fa-instagram"></i></span>
									<input type="text" name="instagram"  class="form-control" placeholder="<?= !empty(lang('instagram'))?lang('instagram'):"instagram";?>" value="<?= !empty($social['instagram'])?html_escape($social['instagram']):""; ?>">
								</div>
								
							</div>
						</div>
					</div><!-- row -->
						
				</div><!-- card-body -->
				<div class="card-footer">
					<input type="hidden" name="id" value="<?= isset($restaurant['id'])?html_escape($restaurant['id']):0; ?>">
					<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</div><!-- col-9 -->
	</form>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('profile_qr'))?lang('profile_qr'):"Profile QR code";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<div class="box-body" >
				<?php $u_info = get_user_info(); ?>
				<!-- csrf token -->
				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
				<div class="row">
					<div class="form-group col-md-12">
						<div class="qrCode text-center">
							<img src="<?= base_url(!empty($u_info['qr_link'])?$u_info['qr_link']:'') ;?>" alt="">
							<?php if(!empty($u_info['qr_link'])): ?>
								<a href="<?= base_url(!empty($u_info['qr_link'])?$u_info['qr_link']:'') ;?>" class="label label-success mt-5" download><i class="fa fa-download"></i> <?= lang('download'); ?></a>

								<a href="<?= base_url('admin/auth/regenerate_qr') ;?>" class="label bg-default-soft mt-5"><i class="fa fa-refresh"></i> <?= lang('regenerate'); ?></a>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>

	
</div>








































































