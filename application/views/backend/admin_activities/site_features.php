<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('home_features'))?lang('home_features'):"Home Features";?>  <a href="#addModal" data-toggle="modal" class="btn btn-success btn-flat ml-10"><i class="fa fa-plus"></i> <?= !empty(lang('add_new'))?lang('add_new'):"Add New";?></a></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<div class="box-body">
			<div class="table-responsive">
				<div class="row">
					<div class="col-md-4 col-lg-4">
						<div class="left_features">
							<?php foreach ($left_features as $key => $row): ?>
								<div class="features_warp_content">
					                <div class="features-wrap left_wrap">
					                    <div class="features-content">
					                        <h4><?=  html_escape($row['title']);?></h4>
					                        <p><?=  html_escape($row['details']);?> </p>
					                    </div>
					                    <!--features-content-->
					                    <?php if(!empty($row['icon'])): ?>
					                    	<?= $row['icon'] ;?>
					                    <?php else: ?>
					                    	 <img src="<?= base_url($row['thumb']) ;?>" alt="">
					                    <?php endif;?>
					                   
					                </div>
					                <div class="features_btn text-right">
					                	<a href="<?= base_url('admin/home/item_delete/'.$row['id'].'/site_features') ;?>" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>" class="btn btn-flat btn-sm btn-danger action_btn "><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"delete";?></a> &nbsp; &nbsp;

					                	<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="site_features" class="btn btn-flat btn-sm <?= $row['status']==1?'btn-success':'btn-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp;  <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a> &nbsp; &nbsp;

					                	<a href="#editModal_<?= $row['id'] ;?>" data-toggle="modal" class="btn btn-flat btn-sm btn-info "><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>
					                	
					                </div>
					            </div>
							<?php endforeach ?>
						</div>
					</div>
					<div class="col-md-3 col-lg-3">
						<div class="image_area">
							<form action="<?= base_url('admin/home/add_features_banner') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
								<?php $img = isset($banner['images']) && !empty($banner['images'])?$banner['images']:''; ?>
								 <label>
								 	<div class="features_img" title="click here to select image">
								 		<img src="<?= base_url($img) ;?>" alt="" id="preview_load_image">
								 		<?php  if($img==''): ?>
									 		<div class="img_text"><i class="fa fa-plus"></i> </div>
									 	<?php endif;?>
								 	</div>
								 	<input type="file" name="file[]" id="load_image" style="display: none;">
								</label>

								 <div class="text-center mt-5">
								 	<input type="hidden" name="id" value="<?= isset($banner['id']) && $banner['id'] !=0?html_escape($banner['id']):0 ?>">
					          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><i class="fa fa-upload"></i> &nbsp; <?= !empty(lang('upload'))?lang('upload'):"Upload";?></button>
					          	</div>

							</form>
						</div>
					</div>
					<div class="col-md-4 col-lg-4">
						<div class="left_features">
							<?php foreach ($right_features as $key => $row): ?>
								<div class="features_warp_content">
					                <div class="features-wrap right_wrap">
					                	<?php if(!empty($row['icon'])): ?>
					                    	<?=  $row['icon'];?>
					                    <?php else: ?>
					                    	 <img src="<?= base_url($row['thumb']) ;?>" alt="">
					                    <?php endif;?>
					                    <div class="features-content">
					                        <h4><?=  html_escape($row['title']);?></h4>
					                        <p><?=  html_escape($row['details']);?> </p>
					                    </div>
					                    <!--features-content-->
					                    
					                   
					                </div>
					                <div class="features_btn text-left">
					                	<a href="<?= base_url('admin/home/item_delete/'.$row['id'].'/site_features') ;?>"data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"  class="btn btn-flat btn-sm btn-danger action_btn"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"delete";?></a> &nbsp; &nbsp;

					                	<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="site_features" class="btn btn-flat btn-sm <?= $row['status']==1?'btn-success':'btn-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp;  <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a> &nbsp; &nbsp;

					                	
					                	<a href="#editModal_<?= $row['id'] ;?>" data-toggle="modal" class="btn btn-flat btn-sm btn-info "><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>
					                	
					                </div>
					            </div>
							<?php endforeach ?>
						</div>
					</div>
				</div><!-- row -->
			</div>
			  
			</div><!-- /.box-body -->
			<div class="box-footer">
		          	
			</div>
		</div>
	</div>
</div>



<!-- Modal -->
<div id="addModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?= !empty(lang('home_features'))?lang('home_features'):"Home Features";?></h4>
      </div>
      <form action="<?= base_url('admin/home/add_site_features') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
	      <div class="modal-body">
	        <div class="add_area_features">
	        	<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="title"><?= !empty(lang('title'))?lang('title'):"title";?></label>
					        <input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"Title";?> " value="">
					    </div>

					    <div class="form-group col-md-12">
					      	<label for="title"><?= !empty(lang('direction'))?lang('direction'):"direction";?></label>
					        <select name="dir" id="" class="form-control" required="">
					        	<option value=""><?= lang('select_direction'); ?></option>
					        	<option value="left"><?= lang('left_side'); ?></option>
					        	<option value="right"><?= lang('right_side'); ?></option>
					        </select>
					    </div>
					    <div class="col-md-12">
							<label><?= !empty(lang('details'))?lang('details'):"details";?> &nbsp;<span class="label label-default"><?= lang('max_character'); ?> <span class="characters">0/120</span></span></label>
							<textarea name="details"  data-max="120" cols="5" rows="5" class="form-control count_text" placeholder=""></textarea>
						</div>
					</div>
					<div class="row mt-15">
						<div class="form-group col-md-12">
							<div class="serviceImg" style="display: none;">
								<img src="" class="service_icon_preview" alt="">
							</div>
							<ul class="nav nav-tabs">
							  <li class="active"><a data-toggle="tab" href="#icon"><?= !empty(lang('icon'))?lang('icon'):"icon";?></a></li>
							  <li><a data-toggle="tab" href="#image"><?= !empty(lang('image'))?lang('image'):"image";?></a></li>
							</ul>
							<div class="tab-content">
							  <div id="icon" class="tab-pane fade in active <?= !empty($data['icon'])?'active':''; ?> mt-15">
							   		<input type="text" name="icon" id="icon" class="form-control" placeholder="Font awsome icon" value=''>
							  </div>
							  <div id="image" class="tab-pane fade <?= !empty($data['images'])?'active':''; ?> mt-15">
							    <input type="file" name="file[]" class="service_img" data-height="600" data-width="600">
							    <span class="img_error"></span>
							  </div>
							</div><!-- tab-content -->
						</div>
					</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <div class="btn_area">
		        <button type="button" class="btn btn-default" data-dismiss="modal"><?= !empty(lang('close'))?lang('close'):"close";?></button>
		        <button type="submit" name="register" class="btn btn-primary  btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		    </div>
	      </div>
	  </form>
    </div>

  </div>
</div>

<?php foreach ($all_features as $key => $data): ?>
<!-- Modal -->
<div id="editModal_<?=  $data['id'];?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?= !empty(lang('home_features'))?lang('home_features'):"Home Features";?></h4>
      </div>
      <form action="<?= base_url('admin/home/add_site_features') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
	      <div class="modal-body">
	        <div class="add_area_features">
	        	<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="title"><?= !empty(lang('title'))?lang('title'):"title";?></label>
					        <input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"Title";?> " value="<?= !empty($data['title'])?html_escape($data['title']):set_value('title'); ?>">
					    </div>

					    <div class="form-group col-md-12">
					      	<label for="title"><?= !empty(lang('direction'))?lang('direction'):"direction";?></label>
					        <select name="dir" id="" class="form-control" required="">
					        	<option value=""><?= lang('select_direction'); ?></option>
					        	<option value="left" <?= isset($data['dir']) &&  $data['dir']=="left"?"selected":"" ;?>><?= lang('left_side'); ?></option>
					        	<option value="right" <?= isset($data['dir']) &&  $data['dir']=="right"?"selected":"" ;?>><?= lang('right_side'); ?></option>
					        </select>
					    </div>
					    <div class="col-md-12">
							<label><?= !empty(lang('details'))?lang('details'):"details";?> &nbsp;<span class="label label-default"><?= lang('max_character'); ?> <span class="characters">0/120</span></span></label>
							<textarea name="details" data-max="120"  cols="5" rows="5" class="form-control count_text"><?= !empty($data['details'])?html_escape($data['details']):set_value('details'); ?></textarea>
							<span class="error"><?= form_error('details'); ?></span>
						</div>
					</div>
					<div class="row mt-15">
						<div class="form-group col-md-12">
							<div class="serviceImg" style="display:<?= !empty($data['images'])?'block':'none'; ?>;">
								<img src="<?= !empty($data['images'])?base_url($data['images']):''; ?>" class="service_icon_preview" alt="">
							</div>
							<div id="exTab2">
								<ul class="nav nav-tabs">
								  <li class="<?= !empty($data['icon'])?'active':''; ?>"><a data-toggle="tab" href="#icon_<?=  $data['id'];?>"><?= !empty(lang('icon'))?lang('icon'):"icon";?></a></li>

								  <li class="<?= !empty($data['images'])?'active':''; ?>"><a data-toggle="tab" href="#image_<?=  $data['id'];?>"><?= !empty(lang('image'))?lang('image'):"image";?></a></li>

								</ul>
								<div class="tab-content">
								  <div id="icon_<?=  $data['id'];?>" class="tab-pane fade in <?= !empty($data['icon'])?'active':''; ?> mt-15">
								   		<input type="text" name="icon" id="icon" class="form-control" placeholder="Font awsome icon" value='<?= !empty($data['icon'])?$data['icon']:set_value('icon'); ?>'>
						        		<span class="error"><?= form_error('icon'); ?></span>
								  </div>
								  <div id="image_<?=  $data['id'];?>" class="tab-pane fade in <?= !empty($data['images'])?'active':''; ?> mt-15">
								    <input type="file" name="file[]" class="service_img" data-height="600" data-width="600">
								    <span class="img_error"></span>
								  </div>
								</div><!-- tab-content -->
							</div>
						</div>
					</div>
				    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
	        </div>
	      </div>
	      <div class="modal-footer">
	        <div class="btn_area">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" name="register" class="btn btn-primary  btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		    </div>
	      </div>
	  </form>
    </div>

  </div>
</div>
<?php endforeach;?>