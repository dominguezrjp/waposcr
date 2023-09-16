<div class="row">
	<div class="col-md-7">
		<div class="card box-primary">
			<div class="card-header">
				<h5 class="card-title">All Products</h5>
				<div class="card-tools">
					
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/products/add_products') ?>" method="post" class="form-submit" enctype= "multipart/form-data">
				<div class="card-body">
					<?= csrf();?>
					<!-- csrf token -->
					
					<?php 
						if(isset($_GET['cat']) && !empty($_GET['cat'])):
							$cat_id = $_GET['cat'];
						endif;
					 ?>
					 <div class="row">
						<div class="form-group col-md-12">
							<label>Title</label>
							<input type="text" name="title"  class="form-control" placeholder="Title" value="<?=isset($data['title'])?$data['title']:'' ;?>">
						</div>
					</div>


					<div class="row">
						<div class="form-group col-md-6">
							<label for=""><?= !empty(lang('category'))?lang('category'):"category";?> <span class="error">*</span></label>
							<select name="category_id" class="form-control" id="category">
								<option value="">Select Category</option>
								<?php foreach ($category_list as $key => $category): ?>
									<option value="<?= $category['id'];?>" <?= isset($data['category_id']) && $data['category_id']==$category['id']?"selected":"";?>><?= $category['category_name'];?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label for=""><?= !empty(lang('allergens'))?lang('allergens'):"allergens";?></label>
							<select name="allergen_id" class="form-control" id="">
								<option value=""><?= lang('select'); ?></option>
								<?php foreach ($allergens as $key => $value): ?>
									<option <?= isset($data['allergen_id']) && $data['allergen_id']==$value['id']?"selected":"";?> value="<?= $value['id'];?>"><?= $value['name'];?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label for="">Uid</label>
							<input type="number" name="uid" id="" class="form-control" placeholder="Uid" value="<?=isset($data['uid'])?$data['uid']:'' ;?>">
						</div>
						<div class="form-group col-md-6">
							<label><?= !empty(lang('in_stock'))?lang('in_stock'):"in stock";?> <span class="error">*</span></label>

							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><?= !empty($data['in_stock'])?html_escape($data['in_stock']):0; ?></span>
								</div>
								<input type="number" name="in_stock"  class="form-control" placeholder="<?= !empty(lang('in_stock'))?lang('in_stock'):"in stock";?>" value="<?= !empty($data['in_stock'])?html_escape($data['in_stock']):0; ?>">
							</div>

							
						</div>
					</div>

				
					<div class="row">
						
						<div class="form-group col-md-6 show_price ">
					      	<label for="price"><?= !empty(lang('purchase_price'))?lang('purchase_price'):"purchase price";?></label>
					        <input type="number" name="purchase_price" id="purchase_price" class="form-control" placeholder="<?= !empty(lang('purchase_price'))?lang('purchase_price'):"Purchase price";?>" value="<?= !empty($data['purchase_price'])?html_escape($data['purchase_price']):set_value('purchase_price'); ?>">
					    </div>

					    <div class="form-group col-md-6 show_price ">
					      	<label for="price"><?= !empty(lang('price'))?lang('price'):"price";?></label>
					        <input type="text" name="price" id="price" class="form-control" placeholder="<?= !empty(lang('price'))?lang('price'):"price";?>" value="<?= !empty($data['price'])?html_escape($data['price']):set_value('price'); ?>">
					    </div>


					    <div class="form-group col-md-6">
					    	<label for="percent">Percent</label>
					    	<div class="input-group mb-3">
					    		<input type="number" name="percent"  class="form-control" placeholder="<?= !empty(lang('percent'))?lang('percent'):"in stock";?>" value="<?= !empty($data['percent'])?html_escape($data['percent']):0; ?>">
					    		<div class="input-group-prepend">
					    			<span class="input-group-text"><?= !empty($data['percent'])?html_escape($data['percent']):0; ?></span>
					    		</div>
					    	</div>
					    </div>
					   
						
					</div>
					<?php if(vendor()->category_id != 'e-shop'): ?>
						<div class="row">
							<div class="form-group col-md-6">
								<label for=""><?= !empty(lang('veg_type'))?lang('veg_type'):"Veg type";?></label>
								<div class="d_flex_center">
									<label class="pointer label success-light vegs custom-radio"><input <?= isset($data['veg_type']) && $data['veg_type']==1?'checked':'' ;?> type="radio" name="veg_type"  value="1">&nbsp; <?= !empty(lang('veg'))?lang('veg'):"Veg";?></label>
									<label class="pointer label danger-light vegs custom-radio"><input <?= isset($data['veg_type']) && $data['veg_type']==2?'checked':'' ;?> type="radio" name="veg_type" value="2">&nbsp; <?= !empty(lang('non_veg'))?lang('non_veg'):"Non veg";?></label>

									<label class="pointer label default-light vegs custom-radio"><input <?= isset($data['veg_type']) && $data['veg_type']==0?'checked':'' ;?> type="radio" name="veg_type" value="0">&nbsp; none</label>
								</div>
							</div>
						</div>
					<?php endif ?>

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
					<div class="row mt-10">
						<div class="form-group col-md-4 size_tag mt-10">
							<div class="d_flex_center">
								<label class="pointer label label bg-light vegs custom-checkbox"><input <?= isset($data['is_variants']) && $data['is_variants']==1?'checked':'' ;?> type="checkbox" name="is_variants" class="is_variants"  value="1">&nbsp; <?= !empty(lang('is_variants'))?lang('is_variants'):"Is variants";?></label>
							</div>
						</div>

						<div class="form-group col-md-4 mt-10">
							<label class="label bg-info pointer label_input custom-checkbox"><input type="checkbox"  name="is_home" <?= isset($data['is_home']) && $data['is_home']==1?'checked':"" ;?> value="1"> Show in home page</label>
							<?php if(isset($_GET['action'])): ?>
								<label class="label label-warning pointer label_input custom-checkbox ml-20"> <input type="checkbox" name="is_copy_extra" value="1"> <?= lang('add_those_extras_also'); ?></label>
							<?php endif;?>
						</div>
				
						
					</div>
					<div class="row">
						



						<div class="form-group col-md-6">
							<label>orders</label>
							<input type="number" name="orders" id="orders" class="form-control" placeholder="<?= !empty(lang('orders'))?lang('orders'):"orders";?>" value="<?= !empty($data['orders'])?html_escape($data['orders']):0; ?>">
						</div>
					</div>
				

					<div class="row">
						<div class="col-md-6">
							<ul class="nav nav-tabs" role="tablist">

								<li class="nav-item "> <a data-toggle="tab" class="tab_li nav-link <?=!empty($data)?"":"active" ;?> <?= isset($data['img_type']) && $data['img_type']==1?'active':''; ?>" href="#image_tab" data-value="img">Image</a></li>

								<li class="nav-item"><a data-toggle="tab" href="#link_tab" class="tab_li nav-link <?= isset($data['img_type']) && $data['img_type']==2?'active':''; ?>" data-value="link"><?= !empty(lang('img_url'))?lang('img_url'):"Image URL"; ?></a></li>

							</ul>
							<div class="tab-content pt-10">
								<div id="image_tab" class="mt-10 tab-pane fade in<?=!empty($data)?"":" active show" ;?> <?= isset($data['img_type']) && $data['img_type']==1?'active show':''; ?>">
									<div class="imgTab">
										<label class="defaultImg">
											<?php if(isset($data['id']) && !empty($data['id'])): ?>
											<a href="<?= base_url('admin/restaurant/delete_img/'.$data['id'].'/items');?>" class="deleteImg <?= isset($data['thumb']) && !empty($data['thumb'])?"":"opacity_0"?>" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-close"></i></a>
										<?php endif;?>

										<img src="<?= isset($data['thumb']) && !empty($data['thumb'])?base_url($data['thumb']):""?>" alt=""  class="imgPreview <?= isset($data['thumb']) && !empty($data['thumb'])?"":"opacity_0"?>">

										<div class="imgPreviewDiv <?= isset($data['thumb']) && !empty($data['thumb'])?"opacity_0":""?>">
											<i class="fa fa-upload"></i>
											<h4><?= lang('upload_image'); ?></h4>
											<p class="fw_normal mt-3">Max: 1000 x 900 px</p>
										</div>

										<input type="file" name="file[]" class="imgFile opacity_0" data-width="1000" data-height="900" >
									</label>
									<span class="img_error"></span>
								</div>
							</div>
							<div id="link_tab" class="mt-10 tab-pane fade in<?= isset($data['img_type']) && $data['img_type']==2?' active show':''; ?>">
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
				<div class="card-footer text-right">
					<?php if(isset($_GET['action']) && $_GET['action']=="copy"): ?>
						<input type="hidden" name="is_copy" value="1">
						<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
						<input type="hidden" name="images" value="<?= isset($data['images']) && !empty($data['images'])?$data['images']:""?>">
						<input type="hidden" name="thumb" value="<?= isset($data['thumb']) && !empty($data['thumb'])?$data['thumb']:""?>">
						
					<?php else: ?>
						<!-- <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>"> -->
					<?php endif;?>



					<?= hidden('id', isset($data['id'])?$data['id']:0);?>
					<?= hidden('product_id', isset($data['product_id'])?$data['product_id']:0);?>
		          	<a href="<?= base_url('admin/products/products'); ?>" class="btn btn-default btn-flat float-left"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
		          
		          	<button type="submit" name="register" class="btn btn-secondary c_btn btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>



<!-- 
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
			        <?php endif;?> -->
				</div>
			</form>
		</div>
	</div>