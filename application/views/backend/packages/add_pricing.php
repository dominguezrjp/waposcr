<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 col-lg-8">
		<?php if(isset($this->is_package['trail']) && $this->is_package['trail']== 0): ?>
            <div class="single_alert alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div class="d_flex_alert">
                    <h4><i class="icon fas fa-question-circle"></i> <?= lang('info'); ?></h4>
                    <div class="double_text">
                        <div class="text-left">
                            <h5><?= lang('create_trail_package_msg'); ?></h5>
                            <p>* <?= lang('create_trail_package_msg_1'); ?></p>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        <?php endif;?>
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('add_packages'))?lang('add_packages'):"Add Package";?> </h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/dashboard/add_packages') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body">


					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group col-md-12">
						      	<label for="type_name"><?= !empty(lang('package_name'))?lang('package_name'):"package name";?></label>
						        <input type="text" name="package_name" id="package_name" class="form-control" placeholder="<?= !empty(lang('package_name'))?lang('package_name'):"Package Name";?>" value="<?= !empty($type_data['package_name'])?html_escape($type_data['package_name']):set_value('package_name'); ?>">
						    </div>

						    <div class="form-group col-md-12">
						      	<label for="type_name"><?= !empty(lang('slug'))?lang('slug'):"slug";?></label>
						        <input type="text" name="slug" id="slug" class="form-control remove_space" placeholder="<?= !empty(lang('slug'))?lang('slug'):"Slug";?>" value="<?= !empty($type_data['slug'])?html_escape($type_data['slug']):set_value('slug'); ?>">
						        <p><b class="text-danger"><?= lang('must_unique_english'); ?></b></p>
						    </div>
						    <div class="form-group col-md-12">
						      	<label><?= !empty(lang('package_type'))?lang('package_type'):"Package type";?> </label>
						        <select name="package_type" class="form-control account_duration" id="" required="">
						        	<option value=""><?= lang('select'); ?></option>

						        	<?php if(isset($this->check_trial) && $this->check_trial==0): ?>
						        		<option value="trial" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='trial'?'selected':'';?>><?= !empty(lang('trial_for_month'))?lang('trial_for_month'):"Trial for 1 Month";?></option>

						        		<option value="weekly" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='weekly'?'selected':'';?>><?= !empty(lang('trial_for_week'))?lang('trial_for_week'):"Trial for 1 week";?></option>

						        		<option value="fifteen" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='fifteen'?'selected':'';?>><?= !empty(lang('trial_for_fifteen'))?lang('trial_for_fifteen'):"Trial for 15 days";?></option>
						        	<?php else: ?>
						        		<?php if(isset($type_data['package_type']) && $type_data['package_type']!='monthly' && $type_data['package_type']!='yearly'  && $type_data['package_type']!='free'){ ?>
						        			<option value="trial" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='trial'?'selected':'';?>><?= !empty(lang('trial'))?lang('trial'):"Trial for 1 Month";?></option>

								        	<option value="weekly" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='weekly'?'selected':'';?>><?= !empty(lang('trial_for_week'))?lang('trial_for_week'):"Trial for 1 week";?></option>

								        	<option value="fifteen" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='fifteen'?'selected':'';?>><?= !empty(lang('trial_for_fifteen'))?lang('trial_for_fifteen'):"Trial for 15 days";?></option>
						        		<?php };?>
						        	<?php endif;?>

						        	<?php if(isset($this->check_trial) && $this->check_trial==1 && in_array($type_data['package_type'],$this->trial_type)==0): ?>

						        	<option value="free" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='free'?'selected':'';?>><?= !empty(lang('free'))?lang('free'):"Free";?></option>

						        	<option value="monthly" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='monthly'?'selected':'';?>><?= !empty(lang('monthly'))?lang('monthly'):"Monthly";?></option>

						        	<option value="half_yearly" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='half_yearly'?'selected':'';?>><?= !empty(lang('6_month'))?lang('6_month'):"6 Months";?></option>

						        	<option value="yearly" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='yearly'?'selected':'';?>><?= !empty(lang('yearly'))?lang('yearly'):"Yearly";?></option>

						        	<option value="custom" <?= isset($type_data['package_type']) && html_escape($type_data['package_type'])=='custom'?'selected':'';?>><?= !empty(lang('custom_days'))?lang('custom_days'):"Custom Days";?></option>
						        	<?php endif;?> 
						        </select>
						        <div class="trial_text pt-5" style="display: none;">
						        	<h4>* <?= lang('set_free_for_month'); ?>.</h4>
						        </div>
						    </div>

						    <div class="form-group mb-10 showdurationArea" style="display: <?= isset($type_data['package_type']) && $type_data['package_type']=="custom"?"block":"none";?>">
						    	<div class="col-md-12 mb-10">
						    		<label for=""><?= lang('set_duration');?></label>
						    		<div class="input-group input-group-sm customGroup">
						    			<input type="number" name="duration" id="" class="form-control" value="<?= isset($type_data['duration']) && !empty($type_data['duration'])?$type_data['duration']:1;?>" min="1">
						    			<span class="input-group">
						    				<select name="duration_period" class="form-control">
						    					<option value="days" <?= isset($type_data['duration_period']) && html_escape($type_data['duration_period'])=='days'?'selected':'';?>><?= lang('days');?></option>
						    					<option value="months" <?= isset($type_data['duration_period']) && html_escape($type_data['duration_period'])=='months'?'selected':'';?>><?= lang('months');?></option>
						    					<option value="years" <?= isset($type_data['duration_period']) && html_escape($type_data['duration_period'])=='years'?'selected':'';?>><?= lang('years');?></option>
						    				</select>
						    			</span>
						    		</div>

						    		
						    	</div>
						    	
						    </div>

						    <div class="form-group col-md-12 feature_price" style="display:<?= isset($type_data['package_type']) && $type_data['package_type'] =='free' || isset($type_data['package_type']) && $type_data['package_type'] =='trial'?"none":"block"?>">
						      	<label for="price"><?= !empty(lang('price'))?lang('price'):"Price";?></label>
						        <input type="text" name="price" id="price" class="form-control" placeholder="<?= !empty(lang('price'))?lang('price'):"Price";?>" value="<?= !empty($type_data['price'])?html_escape($type_data['price']):set_value('price'); ?>">
						        <span class="error"><?= form_error('price'); ?></span>
						    </div> 

						    <div class="form-group col-md-6 ">
						      	<label ><?= !empty(lang('order_limits'))?lang('order_limits'):"Order limits";?></label>
						      	<input type="number" name="order_limit" class="form-control" min='0' value="<?= isset($type_data['order_limit'])?$type_data['order_limit']:0;?>">
						    </div>


						     <div class="form-group col-md-6 ">
						      	<label ><?= !empty(lang('item_limit'))?lang('item_limit'):"Item limits";?></label>
						       	<input type="number" name="item_limit" class="form-control" min='0' value="<?= isset($type_data['item_limit'])?$type_data['item_limit']:0;?>">
						       	 
						    </div> 
						</div> <!-- col-md-6 -->

						<div class="col-md-6">
							<div class="form-group col-md-12">
						      	<label for="price"><?= !empty(lang('features'))?lang('features'):"Features";?></label>
						        <div class="features">
						        	<?php $i=1; foreach($features as $row): ?>
						        		<?php if(isset($type_data['id'])): ?>
						        			<?php $feature_id = get_price_feature_id($row['id'],$type_data['id']); ?>
						        		<?php endif; ?>	
						        		<?php if(LICENSE != MY_LICENSE && $row['slug'] == 'online-payment'): ?>
						        		<label class="custom-checkbox"><span><?= $i;?></span><input type="checkbox" <?= isset($feature_id['feature_id']) && $feature_id['feature_id']==$row['id']?"checked":'' ;?>  name="feature_id[]" value="<?= $row['id']?>" disabled> &nbsp; &nbsp; <?= html_escape($row['features']); ?> <p class="label label-default fz-11">* Extended license</p></label>
						        	<?php elseif(LICENSE != MY_LICENSE && $row['slug'] == 'pwa-push'): ?>
						        		<label class="custom-checkbox"><span><?= $i;?></span><input type="checkbox" <?= isset($feature_id['feature_id']) && $feature_id['feature_id']==$row['id']?"checked":'' ;?>  name="feature_id[]" value="<?= $row['id']?>" disabled> &nbsp; &nbsp; <?= html_escape($row['features']); ?> <p class="label label-default fz-11">* Extended license</p></label>
						        	<?php else: ?>
						        		<label class="custom-checkbox"><span><?= $i;?></span><input type="checkbox"  <?= isset($feature_id['feature_id']) && $feature_id['feature_id']==$row['id']?"checked":'' ;?>  name="feature_id[]" value="<?= $row['id']?>"> &nbsp; &nbsp; <?= html_escape($row['features']); ?> </label>
						        	<?php endif;?>

						        	<?php $i++;  endforeach ?>
						        	
						        </div>
						    </div>
						</div>

					</div><!-- row -->
					<hr>
					<?php $customFields = isset($type_data['custom_fields_config']) && !empty($type_data['custom_fields_config'])?json_decode($type_data['custom_fields_config'],true):[]; ?>

					<div class="row">
						<div class="col-md-10">
							<?php for ($i = 1; $i <= 6 ; $i++) {?>
								<div class="col-md-6 form-group">
									<label><?= lang('custom_fields');?></label>
									<input type="text" name="custom_fields[<?= $i ;?>]" class="form-control" placeholder="<?= lang('custom_fields');?>" value="<?= isset($customFields[$i])?$customFields[$i] :"";;?>">
								</div>
							<?php } ?>
						</div>
					</div> 

				   
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="pull-left">
		          		<a href="<?= base_url('admin/dashboard/packages'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
		          	</div>
		          	<div class="pull-right">
		          		 <input type="hidden" name="id" value="<?= isset($type_data['id']) && $type_data['id'] !=0?$type_data['id']:0 ?>">
				    	<input type="hidden" name="is_trial" value="<?= (isset($type_data['package_type']) && $type_data['package_type']=='trial') || (isset($type_data['package_type']) && $type_data['package_type']=='weekly') || (isset($type_data['package_type']) && $type_data['package_type']=='fifteen')?1:0;?>">
				    	
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-lg btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
		<div class="single_alert alert alert-info alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<div class="d_flex_alert">
				<h4><i class="icon fas fa-question-circle"></i> <?= lang('info'); ?>!</h4>
				<div class="double_text">
					<div class="text-left">
						<h5><?= lang('limit_text_msg_1'); ?>  </h5>
						<p> <?= lang('limit_text_msg_2'); ?><b> <u><?= lang('unlimited'); ?></u></b> </p>

					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>