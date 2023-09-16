<div class="row">
	<div class="col-md-6">
		<?php $feedback = get_by_section_name('reviews'); ?>
		<?php if(isset($feedback) && $this->settings['is_rating']==0): ?>
			<div class="single_alert alert alert-info alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<div class="d_flex_alert">
					<h4><i class="icon fas fa-question-circle"></i> Info!</h4>
					<div class="double_text">
						<div class="text-left">
							<h5>Set your Feedback information.</h5>
							<p>Otherwise You are not able to get reviews</p>
							<p><b>Turn on reviews from settings.</b></p>
						</div>
						<a href="<?= base_url('admin/settings/settings');?>"  class="re_url"><?= lang('click_here'); ?></a>
					</div>
				</div>
			</div>
		<?php endif;?>


		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('add'))?lang('add'):"add";?> <?= !empty(lang('section_banner'))?lang('section_banner'):"section banners";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/settings/add_section_banner') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
					      	<label><?= !empty(lang('section_name'))?lang('section_name'):"section name";?></label>
					       	<select name="section_name" id="" class="form-control section_name">
					       		<option value="">Select Section</option>
					       		<option value="home" <?= isset($data['section_name']) && $data['section_name']=='home'?"selected":""; ?>>
					       			<?= !empty(lang('home_banner'))?lang('home_banner'):"Home section";?></option>
					       		<option value="faq" <?= isset($data['section_name']) && $data['section_name']=='faq'?"selected":""; ?>>
					       			<?= !empty(lang('faq'))?lang('faq'):"FAQ section";?>
					       				
					       			</option>
					       		<option value="features" <?= isset($data['section_name']) && $data['section_name']=='features'?"selected":""; ?>>
					       			<?= !empty(lang('features'))?lang('features'):"Features ";?> <?= lang('section'); ?>
					       				
					       			</option>
					       			<option value="services" <?= isset($data['section_name']) && $data['section_name']=='services'?"selected":""; ?>>
					       				<?= !empty(lang('services'))?lang('services'):"services";?>  <?= lang('section'); ?>
					       				
					       			</option>

					       			<option value="teams" <?= isset($data['section_name']) && $data['section_name']=='teams'?"selected":""; ?>>
					       				<?= !empty(lang('team'))?lang('team'):"Teams";?> <?= lang('section'); ?>
					       				
					       			</option>
					       			<option value="how_it_works" <?= isset($data['section_name']) && $data['section_name']=='how_it_works'?"selected":""; ?>>
					       				<?= !empty(lang('how_it_works'))?lang('how_it_works'):"How it works ";?> <?= lang('section'); ?>
					       				
					       			</option>

					       			<option value="pricing" <?= isset($data['section_name']) && $data['section_name']=='pricing'?"selected":""; ?>>
					       				<?= !empty(lang('pricing'))?lang('pricing'):"Pricing ";?> <?= lang('section'); ?>
					       				
					       			</option>

					       			<option value="reviews" <?= isset($data['section_name']) && $data['section_name']=='reviews'?"selected":""; ?>>
					       				<?= !empty(lang('reviews'))?lang('reviews'):"Review ";?> <?= lang('section'); ?>
					       				
					       			</option>

					       			<option value="contacts" <?= isset($data['section_name']) && $data['section_name']=='contacts'?"selected":""; ?>>
					       				<?= !empty(lang('contacts'))?lang('contacts'):"Contacts";?> <?= lang('section'); ?>
					       				
					       			</option>
					       	</select>
					    </div>

					    <div class="form-group col-md-12">
					      	<label><?= !empty(lang('heading'))?lang('heading'):"heading";?></label>
					        <input type="text" name="heading" id="heading" class="form-control" placeholder="<?= !empty(lang('heading'))?lang('heading'):"heading";?>" value="<?= isset($data['heading'])?html_escape($data['heading']):""; ?>">
					    </div>

					    <div class="form-group col-md-12">
					      	<label for="price"><?= !empty(lang('sub_heading'))?lang('sub_heading'):"sub heading";?></label>
					        <textarea name="sub_heading" id="" class="form-control " cols="10" rows="5"><?= !empty($data['sub_heading'])?$data['sub_heading']:""; ?></textarea>
					    </div>

					    <div class="form-group col-md-12 hide_banner" style="display: <?= isset($data['section_name']) && ($data['section_name']=="home" || $data['section_name']=='faq')?"block":"none"; ;?>;">
					      	<label><?= !empty(lang('banner'))?lang('banner'):"banner";?></label>
					        <div class="logo" style="height: 250px; width: 100%; border-radius: 0;">
								<img src="<?= !empty($data['images'])?base_url($data['images']):''; ?>" class="service_icon_preview" alt="">
							</div>
							 <input type="file" name="file[]" class="service_img" data-height="0" data-width="0">
					    </div>

					</div>
				    
				</div><!-- /.box-body -->
				<div class="box-footer">
					<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?$data['id']:0 ?>">
					<?php if(isset($data['id']) && $data['id'] !=0){ ?>
						<div class="pull-left">
			          		<a href="<?= base_url('admin/settings/home_settings'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
			          	</div>
		          <?php } ?>
		          	<div class="pull-right">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>


		
	</div>
	<div class="col-md-5">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('home_banner'))?lang('home_banner'):"Home Banner";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/settings/add_home_banner') ?>" method="post" class="" enctype= "multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					

					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="heading"><?= !empty(lang('home_small_banner'))?lang('home_small_banner'):"Home small banner";?></label>
					       	<label class="defaultImg home_small_banner">
								<?php if(isset($settings['id']) && !empty($settings['id'])): ?>
									<a href="<?= base_url('admin/home/delete_banner_img/'.$settings['id'].'/settings');?>" class="deleteImg <?= isset($settings['home_banner_thumb']) && !empty($settings['home_banner_thumb'])?"":"opacity_0"?>" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-close"></i></a>
								<?php endif;?>
								
								<img src="<?= isset($settings['home_banner_thumb']) && !empty($settings['home_banner_thumb'])?base_url($settings['home_banner_thumb']):""?>" alt=""  class="imgPreview <?= isset($settings['home_banner_thumb']) && !empty($settings['home_banner_thumb'])?"":"opacity_0"?>">

							    <div class="imgPreviewDiv <?= isset($settings['home_banner_thumb']) && !empty($settings['home_banner_thumb'])?"opacity_0":""?>">
									<i class="fa fa-upload"></i>
									<h4><?= lang('upload_image'); ?></h4>
									<p class="fw_normal mt-3"><?= lang('max'); ?>: 1200 x 1000 px</p>
								</div>

								<input type="file" name="file[]" class="imgFile opacity_0" data-height="1000" data-width="1200">
							</label>
							<span class="img_error"></span>
					    </div>
					   
					</div>
				    
				</div><!-- /.box-body -->
				<div class="box-footer">
					<input type="hidden" name="id" value="<?= isset($settings['id']) && $settings['id'] !=0?$settings['id']:0 ?>">
					
		          	<div class="pull-right">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-7">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('section_banner'))?lang('section_banner'):"section banners";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="upcoming_events">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= !empty(lang('sl'))?lang('sl'):"Sl";?></th>
									<th><?= !empty(lang('title'))?lang('title'):"title";?></th>
									<th><?= !empty(lang('heading'))?lang('heading'):"heading";?></th>
									<th><?= !empty(lang('sub_heading'))?lang('sub_heading'):"Sub heading";?></th>
									<th><?= !empty(lang('banner'))?lang('banner'):"Banner";?></th>
									<th width="25%"><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
									<?php foreach ($banners as $key => $row): ?>
										<tr>
											<td><?=  $key+1;?></td>
											<td><?= ucfirst(html_escape($row['section_name'])) ;?> <?= lang('section'); ?></td>
											<td><?= html_escape($row['heading']) ;?></td>
											<td><?= character_limiter(html_escape($row['sub_heading']),80) ;?></td>
											<td>
												<?php if(!empty($row['images'])): ?>
													<img src="<?= base_url(!empty($row['images'])?$row['images']:"") ;?>" alt="" class="hw_50">
												<?php endif;?>
											</td>
											 <td>
											 	<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="section_banners" class="btn  btn-sm <?= $row['status']==1?'btn-success':'btn-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp;  <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a> &nbsp; 

											 	<a href="<?= base_url('admin/settings/edit_section_banners/'.html_escape($row['id'])); ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>&nbsp;
											 <a href="<?= base_url('admin/dashboard/item_delete/'.html_escape($row['id']).'/section_banners'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>
											</td> 
										</tr>
									<?php endforeach;?>

									
							</tbody>
						</table>
					</div>
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>
</div>