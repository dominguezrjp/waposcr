<div class="row">
	<?php include 'inc/leftsidebar.php'; ?>
	<form class="email_setting_form validForm" action="<?= base_url('admin/restaurant/create_restaurant') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<?php $social = json_decode($restaurant['social_list'],TRUE); ?>
		<div class="col-md-5">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="form-group col-sm-12">
							<label  class="control-label"><?= !empty(lang('restaurant_username'))?lang('restaurant_username'):"restaurant username";?> <span class="alert_text">* <?= lang('must_unique_english'); ?></span></label>

							<div class="">
								<input type="text" name="username" class="form-control"  placeholder="<?= !empty(lang('restaurant_name'))?lang('restaurant_name'):"Restaurant name";?>" value="<?= auth('username') ;?>" readonly>
							</div>
						</div>

						<div class="form-group col-sm-12">
							<label  class="control-label"><?= !empty(lang('restaurant_full_name'))?lang('restaurant_full_name'):"restaurant full name";?> <span class="alert_text">* </span></label>

							<div class="">
								<input type="text" name="name" class="form-control"  placeholder="<?= !empty(lang('restaurant_name'))?lang('restaurant_name'):"restaurant name";?>" value="<?= !empty($restaurant['name'])?$restaurant['name']:''; ?>" required>
							</div>
						</div>
						
					</div><!-- row -->


					<div class="row">

						<div class="col-md-12 hidden">
							<div class="form-group">
								<label for="inputName"><?= !empty(lang('time_zone'))?lang('time_zone'):"Time Zone";?> <span class="error">*</span></label>
								<select name="time_zone" id="time_zone" class="form-control select2" required>
									<option value=""><?= lang('select');?></option>
									<?php foreach (timezone_identifiers_list() as $key => $time): ?>
										<option value="<?= $time;?>" <?= !empty($restaurant['time_zone']) &&  $restaurant['time_zone']==$time?"selected":"";  ?>><?= $time;?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						
						<div class="form-group col-sm-12">
							<label class="control-label"><?= !empty(lang('location'))?lang('location'):"location";?> <span class="alert_text">* </span></label>

							<div class="">
								<input type="text" class="form-control"  name="location" placeholder="<?= !empty(lang('gmap_link'))?lang('gmap_link'):"Google Map link";?>" value="<?= !empty($restaurant['location'])?$restaurant['location']:''; ?>" required>

							</div>
						</div>

						<div class="form-group col-sm-12">
							<label class="control-label"><?= !empty(lang('slogan'))?lang('slogan'):"slogan";?> <span class="alert_text">* </span></label>

							<div class="">
								<input type="text" class="form-control"  name="slogan" placeholder="<?= !empty(lang('slogan'))?lang('slogan'):"Slogan";?>" value="<?= !empty($restaurant['slogan'])?$restaurant['slogan']:''; ?>" required>

							</div>
						</div>

						
					</div>

					<div class="row">
						<div class="form-group col-sm-12">
							<label  class="control-label"><?= !empty(lang('address'))?lang('address'):"address";?> <span class="alert_text">* </span></label>

							<div class="">
								<textarea class="form-control"  placeholder="address" name="address" required><?= !empty($restaurant['address'])?$restaurant['address']:''; ?></textarea>
							</div>
						</div>
					</div><!-- row -->	
					<div class="row">
						<div class="form-group col-sm-12">
							<label  class="control-label"><?= !empty(lang('about_short'))?lang('about_short'):"about Short text";?> (<?= lang('max'); ?> 120) <span class="alert_text">* </span></label>

							<div class="">
								<textarea class="form-control"  placeholder="<?= !empty(lang('about_short'))?lang('about_short'):"about Short text";?>" name="about_short" required><?= !empty($restaurant['about_short'])?$restaurant['about_short']:''; ?></textarea>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-12">
							<label  class="control-label"><?= !empty(lang('about'))?lang('about'):"about";?></label>

							<div class="">
								<textarea class="form-control textarea"  placeholder="about" name="about"><?= !empty($restaurant['about'])?$restaurant['about']:''; ?></textarea>
							</div>
						</div>
					</div>

						
				</div><!-- card-body -->
				<div class="card-footer">
					<input type="hidden" name="id" value="<?= isset($restaurant['id'])?html_escape($restaurant['id']):0; ?>">
					<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</div><!-- col-9 -->
	</form>
	<?php if(isset($restaurant['id']) && !empty($restaurant['id'])): ?>
		<div class="col-md-4">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('logo'))?lang('logo'):"logo";?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body" >
					<div class="user_profile_img logo">
						<form action="<?= base_url('admin/auth/upload_restaurant_logo'); ?>" class="upload_img" method="post" enctype= "multipart/form-data"> 
							<!-- csrf token -->
							   <?= csrf(); ?>

							<label title="Upload Profile Picture">
								<?php if(empty($restaurant['thumb'])): ?>
									<div class="upload_msg">
										<i class="fa fa-upload"></i>
										<p><?= !empty(lang('logo'))?lang('logo'):"Upload logo";?></p>
									</div>
								<?php endif ?>
								<img src="<?= !empty($restaurant['thumb'])?base_url($restaurant['thumb']):''; ?>" class="uploaded_img" alt="">
								<input type="file" name="file[]" style="display: none;" accept="image/*">
							</label>

						</form>
						<div class="img_progress">
							<div class="upload_progress" style="display: none;">
								<div class="progress">
									<div class="progress-bar progress-bar-success progress-bar-striped myprogress" role="progressbar" style="width:0%">0%</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div>

			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('cover_photo'))?lang('cover_photo'):"Cover Photo";?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<form action="<?= base_url('admin/restaurant/add_cover') ?>" method="post" class="" enctype= "multipart/form-data">
					<div class="box-body">

						<!-- csrf token -->
						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

						<div class="row">
							<div class="col-md-12">
							<label class="defaultImg rest_cover">
								<img src="<?= isset($restaurant['cover_photo_thumb']) && !empty($restaurant['cover_photo_thumb'])?base_url($restaurant['cover_photo_thumb']):""?>" alt="" id="preview_load_image" class="<?= isset($restaurant['cover_photo_thumb']) && !empty($restaurant['cover_photo_thumb'])?"":"opacity_0"?>">
							    <div class="view_img <?= isset($restaurant['cover_photo_thumb']) && !empty($restaurant['cover_photo_thumb'])?"opacity_0":""?>">
									<i class="fa fa-upload"></i>
									<h4><?= lang('upload_cover_photo'); ?></h4>
								</div>
								<input type="file" name="file[]" class="opacity_0" id="load_image">
							</label>
						</div>

						</div>
					   
					</div><!-- /.box-body -->
					<div class="box-footer">
						 <input type="hidden" name="id" value="<?= isset($restaurant['id']) && $restaurant['id'] !=0?$restaurant['id']:0 ?>">
			          	<div class="pull-right">
			          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat c_btn"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
			          	</div>
					</div>
				</form>
			</div>
			
		</div>
	<?php endif;?>
</div>
