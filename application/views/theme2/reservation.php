<?php if(is_feature($id,'reservation')==1 && is_active($id,'reservation')): ?>
<section class="sectionDefault">
	<?php include "include/banner.php"; ?>
	<div class="section_items">
		<div class="container">
			<div class="contact_content">
				<div class="sction_title">
                  <h4 class="section_heading"><?= get_title($id,'reservation',1) ;?></h4>
                  <?php if(!empty(get_title($id,'reservation',2))): ?>
                    <p><?= get_title($id,'reservation',2) ;?></p>
                  <?php endif;?>
                </div>
				<div class="row"><div class="col-md-8">
					<span class="reg_msg"></span>
						<form action="<?= base_url('profile/add_reservation') ;?>" method="post" autocomplete="off" class="defaultForm form-submit">
							 <!-- csrf token -->
							   <?= csrf(); ?>
							<div class="reservation_form">
								<div class="row">
									<div class="form-group col-md-12">
										<label for=""><?= lang('name'); ?> <span class="error">*</span></label>
										<input type="text" name="name" class="form-control">
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6 pr-5">
										<label for=""><?= lang('email'); ?></label>
										<input type="text" name="email" class="form-control">
									</div>

									<div class="form-group col-md-6 pl-5">
										<label for=""><?= lang('phone'); ?> <span class="error">*</span></label>
										<input type="text" name="phone" class="form-control">
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6 pr-5">
										<label for=""><?= lang('number_of_guest'); ?> <span class="error">*</span></label>
										<input type="number" name="total_guest" class="form-control">
									</div>

									<div class="form-group col-md-6 pl-5">
										<label for=""><?= lang('table_reservation'); ?> <span class="error">*</span></label>
										<select name="is_table" id="is_table" class="form-control">
											<option value=""><?= lang('select'); ?></option>
											<option value="1"><?= lang('yes'); ?></option>
											<option value="0"><?= lang('no'); ?></option>
										</select>
									</div>

									
								</div>
								<div class="row">
									<div class="form-group col-md-6 pr-5">
										<label for=""><?= lang('reservation_date'); ?> <span class="error">*</span></label>
										<div class="input-group date flatpickr" id="datetimepicker1" data-target-input="nearest">
											<input type="text" name="reservation_date" class="form-control datetimepicker" data-target="#datetimepicker1" data-input/>
											<div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>
									<div class="form-group col-md-6 pl-5">
										<label for=""><?= lang('reservation_type'); ?> <span class="error">*</span></label>
										<select name="reservation_type" class="form-control">
											<option value="">Select</option>
											<?php foreach ($reservation_types as $key => $row): ?>
												<option value="<?= $row['id'] ;?>"><?= html_escape($row['name']) ;?></option>
											<?php endforeach ?>
										</select>
									</div>

									<div class="form-group col-md-12">
										<label for=""><?= lang('any_special_request'); ?></label>
										<textarea name="comments" id="comments" class="form-control" cols="5" rows="5"></textarea>
									</div>
								</div>

								<div class="row">

									<div class="form-group col-md-12">
											<?php if(isset($this->settings['is_recaptcha']) && $this->settings['is_recaptcha']==1): ?>
												<?php if(isset($this->settings['recaptcha']->site_key) && !empty($this->settings['recaptcha']->site_key)): ?>
												<div class="g-recaptcha" data-sitekey="<?= $this->settings['recaptcha']->site_key;?>"></div>
											<?php endif;?>
										<?php endif;?>
									</div>

									
									<div class="form-group col-md-12 text-right">
										<input type="hidden" name="shop_id" value="<?= base64_encode($shop['id']) ;?>">
										<button type="submit" class="btn btn-primary custom_btn"><?= lang('submit'); ?></button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-4">
						<div class="available_days">
							<div class="appointment_schedule_area mt-10">
								<p class="ap_info"><i class="fa fa-info-circle"></i> <?= lang('booking_availabiti_text'); ?></p>
								<?php $days = get_days(); ?>
								<ul class="appointment_dates">
									<?php foreach ($days as $key=>$day): ?>
										<?php $my_days = $this->common_m->get_single_appoinment($key,restaurant($id)->id); ?>

										<li class="<?= isset($my_days['days']) && html_escape($my_days['days'])==$key?'available':'not_available';?>">
											<?= isset($my_days['days']) && html_escape($my_days['days'])==$key?'<i class="fa fa-check"></i>':'<i class="fa fa-close"></i>';?> 
											<span><?= !empty(lang($day))?lang($day):$day;?></span> 
											<b><?= isset($my_days['days']) && html_escape($my_days['days'])==$key?'( '.time_format($my_days['start_time'],restaurant($id)->id).' - '.time_format($my_days['end_time'],restaurant($id)->id).' )':'';?></b>
									</li>

									<?php endforeach ?>
								</ul>
								
							</div>
						</div>	
					</div>
					
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif;?>

