<?php if($this->admin_m->count_table_user_id('menu_type') ==0): ?>
	<div class="row">
		<div class="col-md-6">
			<div class="single_alert alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div class="d_flex_alert">
                    <h4><i class="icon fas fa-warning"></i> <?= lang('warning'); ?></h4>
                    <div class="double_text">
                        <div class="text-left">
                            <h5><?= lang('insert_category'); ?></h5>
                        </div>
                        <a href="<?= base_url('admin/menu/category/') ;?>" class="re_url"><?= lang('click_here'); ?></a>
                    </div>
                </div>
            </div>
		</div>
	</div>
<?php endif;?>

<?php if($this->admin_m->count_table_user_id('item_sizes') ==0): ?>
	<div class="row">
		<div class="col-md-6">
			<div class="single_alert alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div class="d_flex_alert">
                    <h4><i class="icon fas fa-warning"></i> <?= lang('warning'); ?></h4>
                    <div class="double_text">
                        <div class="text-left">
                            <h5><?= lang('insert_item_size'); ?></h5>
                            <p><?= lang('insert_item_size_msg'); ?></p>
                        </div>
                        <a href="<?= base_url('admin/menu/category/') ;?>" class="re_url"><?= lang('click_here'); ?></a>
                    </div>
                </div>
            </div>
		</div>
	</div>
<?php endif;?>
<div class="row">
	<div class="col-md-6">
		<?php 
			if(isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang==1):
				$total = $this->admin_m->check_limit_by_table_ln('items');
			else:
				$total = $this->admin_m->check_limit_by_table('items');
			endif;
			
		    $limit = limit(auth('id'),1);
		 ?>
		<?php if($limit ==0): ?>
			<div class="single_alert alert alert-info alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <div class="d_flex_alert ">
	                <h4><i class="fas fa-exclamation-triangle"></i> <?= lang('info'); ?></h4>
	                <div class="double_text">
	                    <div class="text-left">
	                        <h5><?= lang('you_can_add'); ?> <b class="underline"> <?= lang('unlimited'); ?> </b> <?= lang('items'); ?></h5>
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
	                        <h5><i class="fas fa-frown"></i> <?= lang('sorry'); ?></h5>
	                        <p><?= lang('you_reached_max_limit'); ?> <?= $limit ;?></p>
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
	                        <h5><?= lang('you_have_remaining'); ?>  <b class="underline"> &nbsp; <?=  ($limit-$total);?> &nbsp;</b>  <?= lang('out_of'); ?> <b class="underline"> &nbsp; <?=  ($limit);?> &nbsp;</b></h5>
	                    </div>
	                    	
	                </div>
	            </div>
	        </div>
	        <?php $active=1; ?>
        <?php endif;?>
	</div>
</div>
<?php if(isset($_GET['action']) && $_GET['action']=='copy'): ?>
<div class="row">
	<?php $multilang = isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang==1?1:0; ?>
	<?php if($multilang==1): ?>
		<?php 
		$controller = $this->uri->rsegment(1); // The Controller
		$function = $this->uri->rsegment(2);
		$params = $this->uri->rsegment(3);
		$lang = isset($_GET['lang'])?$_GET['lang']:site_lang();
		?>
		
		<div class="col-md-3">
			<div class="card">
				<select name="lang" class="form-control" onchange="location=this.value">
					<?php foreach (shop_languages(auth('id')) as $key => $row): ?>
						<option value="<?= base_url("admin/{$controller}/{$function}/{$params}?action=copy&lang={$row->slug}");?>" <?= $lang==$row->slug?"selected":"";?>><?= $row->lang_name;?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php endif ?>
<div class="row">
	<div class="col-md-7">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('add_items'))?lang('add_items'):"add items";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/menu/add_items') ?>" method="post" class="validForm" enctype= "multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<?php 
						if(isset($_GET['cat']) && !empty($_GET['cat'])):
							$cat_id = $_GET['cat'];
						endif;
					 ?>
					<div class="row">
						<div class="form-group col-md-6">
							<label for=""><?= !empty(lang('categories'))?lang('categories'):"categories";?> <span class="error">*</span></label>
							<select name="cat_id" class="form-control" id="category" required>
								<option value=""><?= lang('select_type'); ?></option>
								<?php foreach ($menu_type as $key => $type): ?>
									<option data-type="<?= html_escape($type['type']) ;?>" <?= isset($data['cat_id']) && $data['cat_id']==$type['category_id']?"selected":"";?> <?= isset($cat_id) && $cat_id==md5($type['category_id'])?"selected":"";?> value="<?= $type['category_id'];?>"><?= $type['name'];?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label for=""><?= !empty(lang('allergens'))?lang('allergens'):"allergens";?></label>
							<select name="allergen_id[]" class="form-control select2" id="" multiple style="min-height: 47px;">
								<option value=""><?= lang('select'); ?></option>
								<?php foreach ($allergens as $key => $value): ?>
									<?php if(is_array(json_decode($data['allergen_id']))): ?>
										<option <?= isset($data['allergen_id']) && in_array($value['id'], json_decode($data['allergen_id'])) ==1?"selected":"";?> value="<?= $value['id'];?>"><?= $value['name'];?></option>
									<?php else: ?>
										<option <?= isset($data['allergen_id']) && $data['allergen_id']==$value['id']?"selected":"";?> value="<?= $value['id'];?>"><?= $value['name'];?></option>
										<?php endif; ?>
								<?php endforeach; ?>
							
							</select>
						</div>
					</div>

					<div class="row">
						<?php restaurant()->stock_status==1?$is_stock =1:$is_stock=0; ?>
						<div class="form-group <?= $is_stock==1?"col-md-6":"col-md-12" ;?>">
					      	<label for="title"><?= !empty(lang('title'))?lang('title'):"Title";?> <span class="error">*</span></label>
					        <input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('item_name'))?lang('item_name'):"item name";?>" value="<?= !empty($data['title'])?html_escape($data['title']):set_value('title'); ?>" required>
					    </div>
					    <?php if( $is_stock==1): ?>
					    	<div class="form-group <?= $is_stock==1?"col-md-6":"col-md-12" ;?>">
						      	<label><?= !empty(lang('in_stock'))?lang('in_stock'):"in stock";?> <span class="error">*</span></label>

						        <input type="text" name="in_stock"  class="form-control" placeholder="<?= !empty(lang('in_stock'))?lang('in_stock'):"in stock";?>" value="<?= !empty($data['in_stock'])?html_escape($data['in_stock']):0; ?>">
						    </div>
					    <?php endif;?>
					</div>
					<?php if(isset($cat_id)): ?>
					<div class="row">
						<div class="form-group col-md-12 size_tag">
							<div class="d_flex_center">
								<label class="pointer label label default-light vegs"><input <?= isset($data['is_size']) && $data['is_size']==1?'checked':'' ;?> type="checkbox" name="is_size" class="is_size"  value="1">&nbsp; <?= !empty(lang('is_variants'))?lang('is_variants'):"Is variants";?></label>
							</div>
						</div>

					    <div class="form-group col-md-6 show_price ">
					      	<label for="price"><?= !empty(lang('price'))?lang('price'):"price";?></label>
					        <input type="text" name="price" id="price" class="form-control" placeholder="<?= !empty(lang('price'))?lang('price'):"price";?>" value="<?= !empty($data['price'])?html_escape($data['price']):set_value('price'); ?>">
					    </div>
					    <div class="col-md-12 show_size_price hidden">
					    	<div class="show_ajax_sizes">
					    			<?php include APPPATH.'views/backend/menu/update_sizes.php' ?>
					    	</div>
					    </div>
						
					</div>
				<?php else: ?>
					<div class="row">
						<div class="form-group col-md-12 size_tag <?= isset($data['is_size']) && $data['is_size']==1?'':'hidden' ;?>">
							<div class="d_flex_center">
								<label class="pointer label label default-light vegs"><input <?= isset($data['is_size']) && $data['is_size']==1?'checked':'' ;?> type="checkbox" name="is_size" class="is_size"  value="1">&nbsp; <?= !empty(lang('is_variants'))?lang('is_variants'):"Is variants";?></label>
							</div>
						</div>

					    <div class="form-group col-md-6 show_price <?= !empty($data['price']) && $data['is_size']==0?"":"hidden";?>">
					      	<label for="price"><?= !empty(lang('price'))?lang('price'):"price";?></label>
					        <input type="text" name="price" id="price" class="form-control" placeholder="<?= !empty(lang('price'))?lang('price'):"price";?>" value="<?= !empty($data['price'])?html_escape($data['price']):set_value('price'); ?>">
					    </div>
					    <div class="col-md-12 show_size_price <?= isset($data['is_size']) && $data['is_size']==1?'':'hidden' ;?>">
					    	<div class="show_ajax_sizes">
					    		<?php if(isset($data['is_size']) && $data['is_size']==1): ?>
					    			<?php include APPPATH.'views/backend/menu/update_sizes.php' ?>
					    		<?php endif;?>
					    	</div>
					    </div>
						
					</div>
				<?php endif;?>

				<div class="row">
					<div class="form-group col-md-12 ml-0">
						<label><?= lang('tax_fee');?></label>
						<div class="row">
							
							<div class="col-md-6">
								<div class="input-group">
									<span class="input-group-addon">
										<select name="tax_status" class="" id="">
											<option value="+" <?= isset($data['tax_status']) && $data['tax_status']=='+'?"selected":"";?>>+</option>
											<option value="-" <?= isset($data['tax_status']) && $data['tax_status']=='-'?"selected":"";?>>-</option>
										</select>
									</span>
									<input type="number" name="tax_fee" id="tax_fee" class="form-control" placeholder="<?= !empty(lang('tax_fee'))?lang('tax_fee'):"tax_fee";?>" value="<?= !empty($data['tax_fee'])?html_escape($data['tax_fee']):0; ?>">
									<span class="input-group-addon">%</span>
								</div>      

							</div>
							<div class="col-md-12 ">
								<small><?= lang('price_tax_msg');?></small>
							</div>
						</div>
					</div>
				</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label for=""><?= !empty(lang('veg_type'))?lang('veg_type'):"Veg type";?></label>
							<div class="d_flex_center">
								<label class="pointer label success-light vegs"><input <?= isset($data['veg_type']) && $data['veg_type']==1?'checked':'' ;?> type="radio" name="veg_type"  value="1">&nbsp; <?= !empty(lang('veg'))?lang('veg'):"Veg";?></label>
								<label class="pointer label danger-light vegs"><input <?= isset($data['veg_type']) && $data['veg_type']==2?'checked':'' ;?> type="radio" name="veg_type" value="2">&nbsp; <?= !empty(lang('non_veg'))?lang('non_veg'):"Non veg";?></label>

								<label class="pointer label default-light vegs"><input <?= isset($data['veg_type']) && $data['veg_type']==0?'checked':'' ;?> type="radio" name="veg_type" value="0">&nbsp; <?= lang('none');?></label>
							</div>
						</div>
					</div>

					<div class="row">
					    <div class=" form-group col-md-12">
							<label><?= !empty(lang('small_description'))?lang('small_description'):"small description";?> <span class="error">*</span></label>
							<textarea name="overview" id="" cols="5" rows="5" class="form-control"><?= !empty($data['overview'])?html_escape($data['overview']):set_value('overview'); ?></textarea>
						</div>

						 <div class="col-md-12">
							<label><?= !empty(lang('details'))?lang('details'):"details";?></label>
							<textarea name="details" id="" cols="5" rows="5" class="form-control textarea"><?= !empty($data['details'])?html_escape($data['details']):set_value('details'); ?></textarea>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label class="label label-info pointer label_input custom-checkbox"><input type="checkbox"  name="is_features" <?= isset($data['is_features']) && $data['is_features']==1?'checked':"" ;?> value="1"> <?= lang('show_in_homepage'); ?></label>
							
							<?php if(isset($_GET['action'])): ?>
								<label class="label label-warning pointer label_input custom-checkbox ml-20"> <input type="checkbox" name="is_copy_extra" value="1"> <?= lang('add_those_extras_also'); ?></label>
							<?php endif;?>
						</div>
				
						
					</div>
					<div class="row">

						<div class="form-group col-md-6">
							<label><?= lang('orders');?></label>
							<input type="number" name="orders" id="orders" class="form-control" placeholder="<?= !empty(lang('orders'))?lang('orders'):"orders";?>" value="<?= !empty($data['orders'])?html_escape($data['orders']):0; ?>">
						</div>
					</div>
					<?php if(isset($_GET['lang'])): ?>
						<div class="row">
							<div class="form-group col-md-6">
								<label for="title"><?= lang('languages');?> <span class="error">*</span></label>
								<select name="language" class="form-control <?= isset($_GET['lang']) && !empty($_GET['lang'])?"pointerEvent":"";?>" required>
									<?php foreach (shop_languages(auth('id')) as $key => $language): ?>
										<option value="<?= $language->slug ;?>" <?= isset($_GET['lang']) && $_GET['lang']==$language->slug?"selected":"" ;?>><?= $language->lang_name ;?></option>
									<?php endforeach;?>

								</select>
							</div>
						</div>
					<?php else: ?>
						<input type="hidden" name="language" value="english">
					<?php endif; ?>

					<div class="row mt-15">
						<div class="col-md-6 col-lg-6 col-sm-6">

						<ul class="nav nav-tabs">
							<li class="<?=!empty($data)?"":"active" ;?> <?= isset($data['img_type']) && $data['img_type']==1?'active':''; ?>"><a data-toggle="tab" class="tab_li" href="#image_tab" data-value="img"><?= lang('image'); ?></a></li>
							<li class="<?= isset($data['img_type']) && $data['img_type']==2?'active':''; ?>"><a data-toggle="tab" href="#link_tab" class="tab_li" data-value="link"><?= !empty(lang('img_url'))?lang('img_url'):"Image URL"; ?></a></li>
						</ul>
						<div class="tab-content pt-10">
						  	<div id="image_tab" class="tab-pane <?=!empty($data)?"":"fade in active" ;?> <?= isset($data['img_type']) && $data['img_type']==1?'fade in active':''; ?>">
							  	<div class="imgTab">
							  		<label class="defaultImg">
							  			<?php if(!isset($_GET['action'])): ?>
								  			<?php if(isset($data['id']) && !empty($data['id'])): ?>
									  			<a href="<?= base_url('admin/restaurant/delete_img/'.$data['id'].'/items');?>" class="deleteImg <?= isset($data['thumb']) && !empty($data['thumb'])?"":"opacity_0"?>" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-close"></i></a>
									  		<?php endif;?>
								  		<?php endif;?>

								  		<img src="<?= isset($data['thumb']) && !empty($data['thumb'])?base_url($data['thumb']):""?>" alt=""  class="imgPreview <?= isset($data['thumb']) && !empty($data['thumb'])?"":"opacity_0"?>">

								  		<div class="imgPreviewDiv <?= isset($data['thumb']) && !empty($data['thumb'])?"opacity_0":""?>">
								  			<i class="fa fa-upload"></i>
								  			<h4><?= lang('upload_image'); ?></h4>
								  			<p class="fw_normal mt-3"><?= lang('max'); ?>: 1000 x 900 px</p>
								  		</div>

								  		<input type="file" name="file[]" class="imgFile opacity_0" data-width="1000" data-height="900" >
							  		</label>
							  		<span class="img_error"></span>
							 	 </div>
						  	</div>
						  <div id="link_tab" class="tab-pane fade <?= isset($data['img_type']) && $data['img_type']==2?'fade in active':''; ?>">
						  	<?php if(!empty($data['img_url'])): ?>
						  		<img src="<?= $data['img_url'];?>" alt="" class="urlimgPreview">
						  	<?php endif; ?>
						  	<div class="form-group">
						  		<label ><?= !empty(lang('img_url'))?lang('img_url'):"Image URL"; ?></label>
						  		<input type="text" name="img_url" class="form-control" value="<?= !empty($data['img_url'])?$data['img_url']:"";?>">
						  	</div>
						  </div>
						  <input type="hidden" name="img_type" class="img_type" value="<?= isset($data['img_type'])?$data['img_type']:1 ;?>">
						</div><!-- Tab content -->
						

						</div>
					</div>
				    
				</div><!-- /.box-body -->
				<div class="box-footer">
					<?php if(isset($_GET['action']) && $_GET['action']=="copy"): ?>
						<input type="hidden" name="is_copy" value="1">
						<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
						<input type="hidden" name="images" value="<?= isset($data['images']) && !empty($data['images'])?$data['images']:""?>">
						<input type="hidden" name="thumb" value="<?= isset($data['thumb']) && !empty($data['thumb'])?$data['thumb']:""?>">
						
					<?php else: ?>
						<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
					<?php endif;?>
					<div class="pull-left">
		          		<a href="<?= base_url('admin/menu/item'); ?>" class="btn btn-secondary btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
		          	</div>



		          	<?php if(isset($data['id']) && $data['id'] !=0): ?>
		          		<div class="pull-right">

		          			<button type="submit" name="register" class="btn btn-primary c_btn btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          		</div>
		          	<?php else: ?>
			          	<?php if(isset($active) && $active==1): ?>
				          	<div class="pull-right">
				          		<button type="submit" name="register" class="btn btn-primary c_btn btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
				          	</div>
				        <?php endif;?>
			        <?php endif;?>
				</div>
			</form>
		</div>
	</div>

	<?php if(isset($data['id']) && $data['id'] !=0): ?>
		<div class="col-md-5">
			<div class="box box-primary">
				<div class="box-header with-border dflex flexWarp">
					<h3 class="box-title w_100"><?= !empty(lang('extras'))?lang('extras'):"Extras";?></h3>
					<?php if(!isset($_GET['action'])): ?>
						<a href="#addExtraModal" data-toggle="modal" class="addnewBtn btn btn-secondary btn-flat"><i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_extras');?></a> &nbsp; &nbsp;

						<a href="#extraListModal" data-toggle="modal" class="addnewBtn btn btn-info btn-flat"><i class="icofont-library"></i> &nbsp;<?= !empty(lang('add_extras_from_library'))?lang('add_extras_from_library'):"Add Extras From Library";?></a>	
					<?php endif;?>
					
				</div>
				<!-- /.box-header -->
				<div class="box-body" >

					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
									<th><?= lang('name'); ?></th>
									<th><?= lang('price'); ?></th>
									<?php if(!isset($_GET['action'])): ?>
										<th><?= lang('action'); ?></th>
									<?php endif;?>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($extras as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td><?= html_escape($row['ex_name']); ?></td>
										<td><?= html_escape($row['ex_price']); ?> <?= restaurant()->icon ;?></td>
										<td>
											<?php if(!isset($_GET['action'])): ?>
											<a href="#extraEditModal_<?= $row['id'] ;?>" data-toggle="modal" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
											<a href="<?= base_url('admin/menu/delete_extra/'.$row['id']) ;?>" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>" class="btn btn-sm btn-danger action_btn"><i class="fa fa-trash"></i></a>
										<?php endif;?>
										</td>
									</tr>
								<?php $i++; endforeach ?>
							</tbody>
						</table>
					</div>

				</div><!-- /.box-body -->
			</div>
		</div>
		<?php if(!isset($_GET['action'])): ?>
			<div class="col-md-5">
				<div class="box box-success">
					<div class="box-header with-border dflex">
						<h3 class="box-title w_100"><?= !empty(lang('images'))?lang('images'):"images";?></h3>
						<a href="#addimgModal" data-toggle="modal" class="addnewBtn btn btn-success btn-flat"><i class="fa fa-plus"></i> &nbsp;<?= lang('add_more_image');?></a>	
						
					</div>
					<!-- /.box-header -->
					<div class="box-body" >
						<div class="extraImages">
							<?php if(!empty($data['extra_images'])): ?>
								<?php $i=1; foreach (json_decode($data['extra_images'],true) as $key =>$img): ?>
									<div class="singleEximg" id="hide_<?= $key; ;?>">
										<img src="<?= base_url($img['thumb']) ;?>" alt="">
										<a href="<?= base_url('admin/menu/delete_extra_img/'.$data['id'].'?img='.$key) ;?>" data-id="<?= $key ;?>" class="delete-img action_btn" data-msg="<?= lang('want_to_delete'); ?>"><i class="fa fa-trash"></i></a>
									</div>	
								<?php $i++; endforeach ?>
							<?php endif;?>
						</div>


					</div><!-- /.box-body -->
				</div>
			</div>
		<?php endif;?>
	<?php endif;?>


</div>


<?php if(isset($data['id']) && $data['id'] !=0): ?>

<!-- Modal -->
<div id="addExtraModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
  	<form action="<?= base_url('admin/menu/add_extras') ?>" method="post" enctype= "multipart/form-data">
  		<!-- csrf token -->
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title"><?= lang('add_new_extras'); ?></h4>
	      </div>
	      <div class="modal-body">
	        <div class="extrasBody">
	        	<div class="form-group">
	        		<label for=""><?= lang('name'); ?></label>
	        		<input type="text" name="ex_name" class="form-control" required>
	        	</div>

	        	<div class="form-group">
	        		<label for=""><?= lang('price'); ?></label>
	        		<input step=".01" type="number" name="ex_price" class="form-control" required placeholder="0.0">
	        	</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="ex_id" value="0">
	      	<input type="hidden" name="item_id" value="<?=  isset($data['id']) && $data['id'] !=0?$data['id']:0;?>">
	        <button type="submit" class="btn btn-default"><?= lang('save'); ?></button>
	      </div>
	    </div>
	</form>
  </div>
</div>




<div id="addimgModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
  	<form action="<?= base_url('admin/menu/add_images/'.$data['id']) ?>" method="post" enctype= "multipart/form-data">
  		<!-- csrf token -->
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title"><?= lang('add_new_images'); ?></h4>
	      </div>
	      <div class="modal-body">
	        <div class="extrasBody">
	        	<div class="form-group">
	        		<input type="file" accept="image/*" class="info_file image_upload" name="file[]" multiple  />
	        	</div>
	        </div>
	        <div class="img_progress">
	        	<div class="show_progress"style="display: none;">
	        		<div class="progress">
	        			<div class="progress-bar progress-bar-success progress-bar-striped myprogress" role="progressbar" style="width:0%">0%</div>
	        		</div>
	        	</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-default"><?= lang('save'); ?></button>
	      </div>
	    </div>
	</form>
  </div>
</div>





<?php foreach ($extras as $key => $row): ?>

<!-- Modal -->
<div id="extraEditModal_<?=  $row['id'];?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
  	<form action="<?= base_url('admin/menu/add_extras') ?>" method="post" enctype= "multipart/form-data">
  		<!-- csrf token -->
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title"><?= lang('add_new_extras'); ?></h4>
	      </div>
	      <div class="modal-body">
	        <div class="extrasBody">
	        	<div class="form-group">
	        		<label for=""><?= lang('name'); ?></label>
	        		<input type="text" name="ex_name" class="form-control" required value="<?= $row['ex_name'] ;?>">
	        	</div>

	        	<div class="form-group">
	        		<label for=""><?= lang('price'); ?></label>
	        		<input step=".01" type="number" name="ex_price" class="form-control" required value="<?= $row['ex_price'] ;?>">
	        	</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="ex_id" value="<?= !empty($row['id'])?$row['id']:0 ;?>">
	      	<input type="hidden" name="item_id" value="<?=  isset($data['id']) && $data['id'] == $row['item_id']?$row['item_id']:0;?>">
	        <button type="submit" class="btn btn-default"><?= lang('save'); ?></button>
	      </div>
	    </div>
	</form>
  </div>
</div>
<?php endforeach; ?>



<!-- Modal -->
<div id="extraListModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
  	<form action="<?= base_url('admin/menu/add_library_extras') ?>" method="post" enctype= "multipart/form-data">
  		<!-- csrf token -->
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title"><?= lang('add_new_extras'); ?> <a href="<?= base_url("admin/menu/extras");?>" class="btn btn-secondary"><i class="fa fa-plus"></i> <?= lang('add_new');?></a></h4>
	      </div>
	      <div class="modal-body">
	        <div class="extrasBody">
	        	<ul class="extra_list_inputs" >
	        		<?php foreach ($extras_libraries as $key => $ex): ?>
	        		<label class="custom-checkbox" ><span><input type="checkbox" name="ex_id[<?= $ex['id'];?>]" value="<?= $ex['id'];?>" > <?= $ex['name'] ;?></span> <span><?= currency_position($ex['price'],restaurant()->id);?></span></label>
	        		<input type="hidden" name="ex_name[<?= $ex['id'];?>]" value="<?= $ex['name'];?>">
	        		<input type="hidden" name="ex_price[<?= $ex['id'];?>]" value="<?= $ex['price'];?>">
	        		<?php endforeach; ?>	
	        	</ul>
	        </div>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="item_id" value="<?= !empty($data['id'])?$data['id']:0;?>">
	        <button type="submit" class="btn btn-default"><?= lang('save'); ?></button>
	      </div>
	    </div>
	</form>
  </div>
</div>


<?php endif;?>