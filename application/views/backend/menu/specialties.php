<div class="row">
	<div class="col-md-6">
		<?php 
			$total = $this->admin_m->count_packages_user_id('item_packages',$is_special=1);;
		    $limit = limit(auth('id'),1);
		 ?>
		<?php if($limit ==0):?>
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
		<?php elseif($total >= $limit): ?>
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
	<div class="col-md-5">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"> <?= lang('specialties'); ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/menu/add_specialties') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<?php restaurant()->stock_status==1?$is_stock =1:$is_stock=0; ?>
						<div class="form-group <?= $is_stock==1?"col-md-6":"col-md-12" ;?>">
					      	<label for="title"><?= !empty(lang('name'))?lang('name'):"name";?></label>
					        <input type="text" name="package_name" id="name" class="form-control" placeholder="<?= !empty(lang('name'))?lang('name'):"Name";?>" value="<?= !empty($data['package_name'])?html_escape($data['package_name']):set_value('package_name'); ?>">
					    </div>
					    <?php if( $is_stock==1): ?>
					    	<div class="form-group <?= $is_stock==1?"col-md-6":"col-md-12" ;?>">
						      	<label><?= !empty(lang('set_stock'))?lang('set_stock'):"Set stock";?> <span class="error">*</span></label>

						        <input type="text" name="in_stock"  class="form-control" placeholder="<?= !empty(lang('in_stock'))?lang('in_stock'):"in stock";?>" value="<?= !empty($data['in_stock'])?html_escape($data['in_stock']):0; ?>">
						    </div>
					    <?php endif;?>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
					      	<label for="price"><?= !empty(lang('price'))?lang('price'):"Price";?> *&nbsp; &nbsp;
					      	 	<label data-toggle="tooltip" data-placement="top" title="If you set discount" class="pointer p-5 label label-info discount_label label_input"><input type="checkbox" name="is_discount" class="is_discount" value="1" <?= isset($data['is_discount']) && $data['is_discount']==1?'checked':''; ;?>> &nbsp; <?= lang('is_discount');?></label> 
					      	</label>
					      	<div class="input-group">
					        	<input type="text" name="price" id="price" class="form-control number" placeholder="<?= !empty(lang('price'))?lang('price'):"Price";?>" value="<?= !empty($data['price'])?html_escape($data['price']):set_value('price'); ?>" required>
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

					<div class="row">
						
					    <div class=" form-group col-md-12">
							<label><?= !empty(lang('overview'))?lang('overview'):"overview";?></label>
							<textarea name="overview" id="" cols="5" rows="5" class="form-control" placeholder=" <?= !empty(lang('overview'))?lang('overview'):"Overview";?>"><?= !empty($data['overview'])?html_escape($data['overview']):set_value('overview'); ?></textarea>
						</div>

						<div class=" form-group col-md-12">
							<label><?= !empty(lang('details'))?lang('details'):"details";?></label>
							<textarea name="details" id="" cols="5" rows="5" class="form-control textarea" placeholder=" <?= !empty(lang('details'))?lang('details'):"Details";?>"><?= !empty($data['details'])?html_escape($data['details']):set_value('details'); ?></textarea>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-12">
							<label class="label label-info pointer label_input custom-checkbox"><input type="checkbox" class="" name="is_home" <?= isset($data['is_home']) && $data['is_home']==1?'checked':"" ;?> value="1"> <?= lang('show_in_homepage'); ?></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
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
					
				    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
				</div><!-- /.box-body -->
				<div class="box-footer">
					<?php if(isset($data['id']) && $data['id'] !=0){ ?>
						<div class="pull-left">
			          		<a href="<?= base_url('admin/menu/specialties'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
			          	</div>
		          <?php } ?>
		            <?php if(isset($active) && $active==1): ?>
		            		<div class="pull-right">
				          		<?php if(is_access('update')==1 && isset($data['id']) && $data['id'] !=0): ?>
					          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>

					          	<?php elseif(is_access('add')==1): ?>
				          			<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
				          		<?php endif; ?>
				          	</div>
			        <?php endif;?>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-7">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= lang('specialties'); ?></h3>
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
									<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
									<th><?= lang('images'); ?></th>
									<th><?= lang('name'); ?></th>
									<th><?= lang('price'); ?></th>
									<th ><?= lang('username'); ?></th>
									<?php if(restaurant()->stock_status==1): ?>
								      <th ><?= !empty(lang('stock_status'))?lang('stock_status'):"stock status";?></th>
								  	<?php endif;?>
									<th><?= lang('status'); ?></th>
									<th><?= lang('action'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($specialties as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td>
											<div class="serviceImgs">
												<img src="<?= base_url($row['thumb']);?>" alt="">
											</div>
										</td>
										<td><?= html_escape($row['package_name']); ?>
											<?php if($row['is_home']==1): ?>
										 	&nbsp; <label class="label label-success" title="show in home page"><i class="fa fa-home"></i></label>
										 <?php endif;?>
										</td>
										<td>
											<?=currency_position($row['final_price'],restaurant()->id); ?>
											<?php if($row['is_discount']==1): ?>
												<span class="price_discount">
													<?= currency_position($row['price'],restaurant()->id); ?>
												</span> &nbsp;
												<label class="label default-light-active"><?= html_escape($row['discount']) ;?> %</label>
											<?php endif; ?>
										</td>
										<td><?= html_escape(get_user_info_by_id($row['user_id'])['username']); ?></td>

										<?php if(restaurant()->stock_status==1): ?>
									       	<td>
									       		<span class="label default-light"><?= lang('in_stock'); ?> <?= $row['in_stock'] ;?></span>
									       		<span class="label default-light"><?= lang('remaining'); ?> <?= $row['in_stock'] - $row['remaining'] ;?></span>
									       	</td>
							      		 <?php endif;?>

										<td>
											<?php if(is_access('change-status')==1): ?>
												<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="item_packages" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
											<?php endif; ?>
										
										</td>

										<td>
											<div class="btn-group">
												<a href="javascript:;" class="dropdown-btn dropdown-toggle btn btn-danger btn-sm btn-flat" data-toggle="dropdown" aria-expanded="false">
													<span class="drop_text"><?= lang('action'); ?> </span> <span class="caret"></span>
												</a>

												<ul class="dropdown-menu dropdown-ul" role="menu">
													<?php if(is_access('update')==1): ?>
														<li class="cl-info-soft"><a href="<?= base_url('admin/menu/edit_specialties/'.html_escape($row['id'])); ?>" ><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a></li>
													<?php endif; ?>

													<?php if(restaurant()->stock_status==1): ?>
														<?php if(is_access('update')==1): ?>
														<li class="cl-danger-soft"><a href="<?= base_url('admin/menu/reset_count/'.$row['id'].'/item_packages') ;?>" class=" action_btn" data-msg="<?= lang('reset_stock_count'); ?>"> <i class="icofont-refresh"></i> <?= !empty(lang('reset_count'))?lang('reset_count'):"Reset Count";?></a></li>
														<?php endif; ?>
													<?php endif;?>
													<?php if(is_access('delete')==1): ?>
														<li class="cl-danger-soft"><a href="<?= base_url('delete-item/'.html_escape($row['id']).'/item_packages'); ?>" class=" action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a></li>
													<?php endif; ?>
												</ul>
											</div><!-- button group -->

										</td>
									</tr>
								<?php $i++; endforeach ?>
							</tbody>
						</table>
					</div>
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>



</div>
	<!-- end menu type -->
	