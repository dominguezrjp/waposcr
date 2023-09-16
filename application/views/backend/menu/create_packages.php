<div class="row">
	<div class="col-md-6">
		<?php 
			$total = $this->admin_m->count_packages_user_id('item_packages',$is_special=0);
		    $limit = limit(auth('id'),1);
		 ?>
		<?php if($limit ==0): ?>
			<div class="single_alert alert alert-info alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <div class="d_flex_alert ">
	                <h4><i class="fas fa-exclamation-triangle"></i> <?= lang('info'); ?></h4>
	                <div class="double_text">
	                    <div class="text-left">
	                        <h5><?= lang('you_can_add'); ?> <b class="underline"> <?= lang('unlimited'); ?> </b> <?= lang('packages'); ?></h5>
	                    </div>
	                    	
	                </div>
	            </div>
	        </div>
	        <?php $active=1; ?>
		<?php elseif($total > $limit): ?>
			<div class="single_alert alert alert-danger alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <div class="d_flex_alert ">
	                <h4> <i class="fas fa-exclamation-triangle"></i> <?= lang('alert'); ?></h4>
	                <div class="double_text">
	                    <div class="text-left">
	                        <h5> <b><?= lang('sorry'); ?></b></h5>
	                        <p><?= lang('you_reached_max_limit'); ?>: <?= $limit ;?></p>
	                    </div>
	                    	
	                </div>
	            </div>
	        </div>
	        <?php $active=0; ?>
        <?php else: ?>
        	<div class="single_alert alert alert-info alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <div class="d_flex_alert ">
	                <h4><i class="fas fa-exclamation-triangle"></i> <?= lang('info'); ?></h4>
	                <div class="double_text">
	                    <div class="text-left">
	                        <h5><?= lang('you_have_remaining'); ?>  <b class="underline"> &nbsp; <?=  ($limit-$total);?> &nbsp;</b> <?= lang('out_of'); ?> <b class="underline"> &nbsp; <?=  ($limit);?> &nbsp;</b></h5>
	                    </div>
	                    	
	                </div>
	            </div>
	        </div>
	        <?php $active=1; ?>
        <?php endif;?>
	</div>
</div>


<div class="row">
	<div class="col-lg-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('add_packages'))?lang('add_packages'):"Add Package";?> </h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/menu/add_packages') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body">


					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<div class="row">
						<?php restaurant()->stock_status==1?$is_stock =1:$is_stock=0; ?>
						<div class="form-group <?= $is_stock==1?"col-md-6":"col-md-12" ;?>">
					      	<label for="type_name"><?= !empty(lang('package_name'))?lang('package_name'):"package name";?>*</label>
					        <input type="text" name="package_name" id="package_name" class="form-control" placeholder="<?= !empty(lang('package_name'))?lang('package_name'):"Package Name";?>" value="<?= !empty($data['package_name'])?html_escape($data['package_name']):set_value('package_name'); ?>"required>
					    </div>

					    <?php if( $is_stock==1): ?>
					    	<div class="form-group <?= $is_stock==1?"col-md-6":"col-md-12" ;?>">
						      	<label><?= !empty(lang('set_stock'))?lang('set_stock'):"Set stock";?> <span class="error">*</span></label>

						        <input type="text" name="in_stock"  class="form-control" placeholder="<?= !empty(lang('in_stock'))?lang('in_stock'):"in stock";?>" value="<?= !empty($data['in_stock'])?html_escape($data['in_stock']):0; ?>">
						    </div>
					    <?php endif;?>



					    <div class="form-group col-md-12 hidden">
					      	<label for="type_name"><?= !empty(lang('slug'))?lang('slug'):"slug";?> <span class="alert_text">*Slug name must be in English without space & Unique</span></label>
					        <input type="text" name="slug" id="slug" class="form-control" placeholder="<?= !empty(lang('slug'))?lang('slug'):"Slug";?>" value="<?= !empty($data['slug'])?html_escape($data['slug']):set_value('slug'); ?>">
					        
					    </div>
					</div>

					<div class="row">
						<div class="form-group col-md-12">
					      	<label><?= !empty(lang('items'))?lang('items'):"items";?> *</label>
					        <select name="items[]" class="form-control multiselct" multiple="" id="">
					        	<option value=""><?= lang('select'); ?></option>
					        	<?php foreach ($items as $key => $item): ?>
					        		<option  <?= isset($data['item_id']) && is_array(json_decode($data['item_id'])) && in_array($item['id'],json_decode($data['item_id']))==$item['id']?"selected":"";?> value="<?=  $item['id'];?>" <?= isset($data['package_type']) && html_escape($data['package_type'])==$item['id']?'selected':'';?>><?= $item['title'] ;?> / <?=  restaurant()->icon;?><?= $item['price'] ;?></option>
					        	<?php endforeach ?>
					        </select>
					    </div>
					</div>

					

					<div class="row">
						<div class="form-gorup col-md-12 mb-5">
							<label for="price"><?= !empty(lang('price'))?lang('price'):"Price";?>
					      	 	<label data-toggle="tooltip" data-placement="top" title="If you want to set custom Price" class="pointer p-5 btn label-info discount_label label_input mr-15"><input type="checkbox" name="is_price" class="is_price" value="1" <?= isset($data['is_price']) && $data['is_price']==1?'checked':''; ;?>> &nbsp; <?= lang('is_price');?></label> 

					      	 	<label data-toggle="tooltip" data-placement="top" title="If you set discount" class="pointer p-5 btn label-primary discount_label label_input"><input type="checkbox" name="is_discount" class="is_discount" value="1" <?= isset($data['is_discount']) && $data['is_discount']==1?'checked':''; ;?>> &nbsp;<?= lang('is_discount'); ?></label> 

					      	</label>
						</div>
						<div class="form-group col-md-6 price_field <?= isset($data['is_price']) && $data['is_price']== 1?'':'dis_none'; ;?>">
							<label for="price" class="p-5"><?= !empty(lang('custom_price'))?lang('custom_price'):"Custom Price";?></label>
						      	<div class="input-group ">
						        	<input type="text" name="price" id="price" class="form-control number" placeholder="<?= !empty(lang('price'))?lang('price'):"Price";?>" value="<?= !empty($data['price'])?html_escape($data['price']):set_value('price'); ?>">
						        	<span class="input-group-addon"><?=  restaurant()->icon;?></span>
						    	</div>
					    </div>

					    <div class="form-group col-md-6 discount_field <?= isset($data['is_discount']) && $data['is_discount']==1?'':'dis_none'; ;?> ">

					      	<label for="price" class="p-5"><?= !empty(lang('discount'))?lang('discount'):"discount";?></label>
					      	<div class="input-group">
				                <input type="text" name="discount" class="form-control only_number" value="<?= !empty($data['discount'])?html_escape($data['discount']):set_value('discount'); ?>">
				                <span class="input-group-addon">%</span>
				             </div>
					    </div> 
					</div>

					<div class="row hidden">
						 <div class="form-group col-md-6">
					      	<label><?= !empty(lang('duration'))?lang('duration'):"duration";?>* &nbsp;
					      		<label data-toggle="tooltip" data-placement="top" title="If you want to show later" class="pointer p-5 label label-info upcoming_label label_input hidden"><input type="checkbox" name="is_upcoming" class="is_upcoming" value="1" <?= isset($data['is_discount']) && $data['is_upcoming']==1?'checked':''; ;?>> &nbsp; <?= lang('is_upcoming'); ?></label>
					      	</label>
					        <select name="duration" class="form-control select2" id="">
					        	<option value=""><?= lang('select'); ?></option>
					        	<?php for($i=1;$i<=30;$i++): ?>
					        		<option <?= isset($data['duration']) && $data['duration']==$i?'selected':'' ;?> value="<?=  $i;?>" ><?=  $i;?> <?= !empty(lang('days'))?lang('days'):"days";?></option >
					        	<?php endfor; ?>
					        </select>
					    </div>
					    <div class="form-group col-md-6 upcoming_field <?= isset($data['is_discount']) && $data['is_upcoming']==1?'':'dis_none'; ?>">
					      	<label for="price" class="p-5"><?= !empty(lang('live_date'))?lang('live_date'):"live date";?></label>
					      	<div class="input-group">
				                <input type="text" name="live_date" class="form-control datepicker" value="<?= !empty($data['live_date'])?html_escape($data['live_date']):set_value('live_date'); ?>">
				                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				             </div>
					    </div> 
					</div>


					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="price"><?= !empty(lang('details'))?lang('details'):"details";?></label>
					      	<textarea name="details" id="" class="textarea form-control" cols="30" rows="10"><?= !empty($data['details'])?html_escape($data['details']):set_value('details'); ?></textarea>
					    </div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label class="label label-info pointer label_input custom-checkbox"><input type="checkbox"  name="is_home" <?= isset($data['is_home']) && $data['is_home']==1?'checked':"" ;?> value="1"> <?= lang('show_in_homepage'); ?></label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label class="defaultImg">
								<img src="<?= isset($data['thumb']) && !empty($data['thumb'])?base_url($data['thumb']):""?>" alt="" id="preview_load_image" class="<?= isset($data['thumb']) && !empty($data['thumb'])?"":"opacity_0"?>">
							    <div class="view_img <?= isset($data['thumb']) && !empty($data['thumb'])?"opacity_0":""?>">
									<i class="fa fa-upload"></i>
									<h4><?= lang('upload_image'); ?></h4>
								</div>
								<input type="file" name="file[]" class="opacity_0" id="load_image">
							</label>
						</div>
					</div>

				    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?$data['id']:0 ?>">
				   
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="pull-left">
		          		<a href="<?= base_url('admin/menu/packages'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
		          	</div>
		          	<?php if(isset($active) && $active==1): ?>
			          	<div class="pull-right">
			          		<button type="submit" name="register" class="btn btn-primary btn-block btn-lg btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
			          	</div>
		          	<?php endif;?>
				</div>
			</form>
		</div>
	</div>
	
	<div class="col-lg-6">
		<div class="row">
			<?php if(isset($items) && count($items)==0): ?>
				<div class="col-md-12">
					<div class="single_alert alert alert-info alert-dismissible">
			            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			            <div class="d_flex_alert">
			                <h4><i class="fas fa-exclamation-triangle"></i> <?= lang('info'); ?></h4>
			                <div class="double_text">
			                    <div class="text-left">
			                        <h5><?= lang('empty_item_package'); ?>!</h5>
			                        <p><?= lang('empty_item_package_msg'); ?> </p>
			                    </div>
			                    <a href="<?= base_url('admin/menu/item') ;?>" class="re_url"><?= lang('click_here'); ?></a>
			                </div>
			            </div>
			        </div>
				</div>
			<?php endif;?>

			<div class="col-md-12">
				<div class="single_alert alert alert-info alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<div class="d_flex_alert">
						<h4><i class="fas fa-exclamation-triangle"></i> <?= lang('info'); ?></h4>
						<div class="double_text">
							<div class="text-left">
								<h5><?= lang('is_price'); ?></h5>
								<p><?= lang('is_price_msg_1'); ?> </p>
								<p><?= lang('is_price_msg_2'); ?> </p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="single_alert alert alert-info alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<div class="d_flex_alert">
						<h4><i class="fas fa-exclamation-triangle"></i> <?= lang('info'); ?></h4>
						<div class="double_text">
							<div class="text-left">
								<h5><?= lang('is_discount'); ?></h5>
								<p><?= lang('discount_msg'); ?> </p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>