<div class="row">
	<div class="col-md-9">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> <?= !empty(lang('manage_features'))?lang('manage_features'):'Manage Features';?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/auth/add_features_info'); ?>" method="post"> 
				<div class="box-body" >
					<div class="upcoming_events">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

						<div class="row">
							<div class="">
								<?php foreach ($pricing as $key => $row): ?>
									<?php foreach ($features as $key => $feature): ?>
										<?php $feature_id = get_price_feature_id($feature['feature_id'],$row['id']); ?>
											<?php if(isset($feature_id['feature_id']) && $feature_id['feature_id']==$feature['feature_id']): ?>
												<div class="col-sm-6">
													<div class="box box-info">
														<div class="box-header with-border">
															<h3 class="box-title"><?= html_escape($feature['name']);?></h3>
															<div class="box-tools pull-right">
																<div class="gap">
																	<input type="checkbox" id="toggle_<?= html_escape($feature['id']) ;?>" name="set-name" class="switch-input toggle_feature" data-value="<?= html_escape($feature['status']) ;?>" data-id="<?= html_escape($feature['feature_id']) ;?>" <?= isset($feature['status']) && html_escape($feature['status'])==1?'checked':'';?>>

																	<label for="toggle_<?= html_escape($feature['id']) ;?>" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>
																</div>
															</div>
														</div>
														<!-- /.box-header -->
														<div class="box-body" >
															<div class="form-group">
																<label for=""><?= !empty(lang('heading'))?lang('heading'):"heading";?></label>
																<input type="text" name="heading[]" class="form-control" placeholder="Heading / title" value="<?= html_escape(get_heading($feature['feature_id'],auth('id'),1));?>">
															</div>
															<div class="form-group">
																<label for=""><?= !empty(lang('sub_heading'))?lang('sub_heading'):"Sub Heading";?></label>
																<input type="text" name="sub_heading[]" class="form-control" placeholder="sub Heading" value="<?= html_escape(get_heading($feature['feature_id'],auth('id'),2));?>">
															</div>
															<input type="hidden" name="feature_id[]" value="<?=  $feature['feature_id'];?>">
														</div><!-- /.box-body -->
													</div>
												</div>
											<?php endif;?>
									<?php endforeach; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>	
				</div><!-- /.box-body -->
				<div class="box-footer">
		          	<div class="pull-right">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat c_btn"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
	</div>
	
</div>
