
<div class="row">
	<?php $lang = isset($_GET['lang'])?$_GET['lang']:site_lang(); ?>
	<?php $multilang = isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang==1?1:0; ?>
	<?php if($multilang==0): ?>
		<div class="col-md-8">
			<div class="card">
				<div class="card-body flex_between">
					<h4><?= lang('enable_multi_lang_category_items');?></h4> <a href="<?= base_url("admin/auth/enable_category");?>" class="btn btn-secondary action_btn"><?= lang('enable');?></a>
				</div>
			</div>
		</div>
		<?php $lang = 'english'; ?>
		<?php $add_new_url = base_url("admin/menu/create_category"); ?>
	<?php else: ?>
		<?php 
		$controller = $this->uri->rsegment(1); // The Controller
		$function = $this->uri->rsegment(2);
		$params = $this->uri->rsegment(3);
		
		?>
		<?php if(isset($is_create) && $is_create==0): ?>
				<?php include 'language_dropdown.php'; ?>
		<?php endif; ?>
		
		<?php $add_new_url = base_url("admin/menu/create_category/?lang={$lang}"); ?>
	<?php endif; ?>
</div>
<div class="row">
	<div class="col-md-6">
		<?php 
			$total = $this->admin_m->check_limit_by_table('items');
		    $limit = limit(auth('id'),1);
		 ?>
		<?php if($limit ==0): ?>
			<div class="single_alert alert alert-info alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <div class="d_flex_alert ">
	                <h4><i class="fas fa-exclamation-triangle"></i> <?= lang('info'); ?></h4>
	                <div class="double_text">
	                    <div class="text-left">
	                        <h5><?= lang('you_can_add'); ?> <b class="underline"> <?= lang('unlimited'); ?> </b>  <?= lang('items'); ?></h5>
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
	                <h4><i class="fas fa-exclamation-triangle"></i>  <?= lang('info'); ?></h4>
	                <div class="double_text">
	                    <div class="text-left">
	                        <h5><?= lang('you_have_remaining'); ?> <b class="underline"> &nbsp; <?=  ($limit-$total);?> &nbsp;</b> <?= lang('out_of'); ?> <b class="underline"> &nbsp; <?=  ($limit);?> &nbsp;</b></h5>
	                    </div>
	                    	
	                </div>
	            </div>
	        </div>
	        <?php $active=1; ?>
        <?php endif;?>
	</div>
	<div class="col-md-10">
		<?php $i=1; foreach ($all_items as $key => $value): ?>
		<?php 
			if($multilang==0): 
				$add_item_url = base_url("admin/menu/create_item?cat=".md5(multi_lang(auth('id'),$value))); 
			else:
				$add_item_url = base_url("admin/menu/create_item?cat=".md5(multi_lang(auth('id'),$value))."&lang={$lang}"); 
			endif;

			$category_name = $value['name'];
			$category_id = multi_lang(auth('id'),$value);
		?>

		<div class="card">
			<div class="card-header justify-content-between">
				<div class="left <?= multi_lang(auth('id'),$value);?>">
					<a href="<?= base_url("admin/menu/item"); ?>" class="pull-left d_color mr-15"><h3><i class="icofont-double-left"></i> <?= html_escape($value['name']); ?> - <?= lang('id');?> : <?= multi_lang(auth('id'),$value);?></h3></a>
					<?php if(isset($active) && $active==1): ?>
						<?php if(is_access('add')==1): ?>
								<a href="<?= $add_item_url; ?>" class="btn btn-secondary pull-right"><i class="fa fa-plus"></i> <?= lang('add_new'); ?></a>
						<?php endif;?>
					<?php endif;?>
				</div>
				<div class="right">

					<a href="#lnModal_<?= $lang;?>" data-toggle="modal" class="btn btn-success btn-sm"><i class="icofont-upload"></i> <?= lang('import');?> </a>
					<a href="<?= base_url("admin/menu/exportcvs/{$lang}");?>" class="btn btn-secondary btn-sm"> <i class="icofont-download"></i> <?= lang('export');?></a>
				</div>
			</div>
			<div class="card-body">
				<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th><?= !empty(lang('images'))?lang('images'):"images";?> </th>
							<th width="20%"><?= !empty(lang('title'))?lang('title'):"title";?></th>
							<th width="35%"><?= !empty(lang('price'))?lang('price'):"price";?> </th>
							<th ><?= !empty(lang('extra'))?lang('extra'):"extra";?></th>
							<?php if(restaurant()->stock_status==1): ?>
								<th ><?= !empty(lang('stock_status'))?lang('stock_status'):"stock status";?></th>
							<?php endif;?>
							<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
							<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
						</tr>
					</thead>
					<tbody id="sortable" class="sortable sorting">
						<?php $j=1; foreach ($value['items'] as $row): ?>

			
							   <tr style="background: #fff;" id='<?= $row['id']; ?>' >
							      <td class="handle"><?= $j;?></td>
							      <td class="handle">
							         <div class="serviceImgs">
							         	<?php if($row['img_type']==1): ?>
								            <img src="<?= base_url(!empty($row['thumb'])?$row['thumb']:EMPTY_IMG);?>" alt="">
								        <?php else: ?>
								        	 <img src="<?= !empty($row['img_url'])?$row['img_url']:base_url(EMPTY_IMG);?>" alt="">
								        <?php endif; ?>
							         </div>
							      </td>
							      <td class="handle">
							         <?= html_escape($row['title']); ?>
							         <?php if($row['veg_type']==1): ?>
							         <label class="label" data-toggle="tooltip" title="<?= !empty(lang('veg'))?lang('veg'):"veg";?>"><i class="fa fa-circle veg_type c_green"></i></label>
							         <?php elseif($row['veg_type']==2): ?>
							         <label class="label" data-toggle="tooltip" title="<?= !empty(lang('non_veg'))?lang('non_veg'):"Non veg";?>"><i class="fa fa-circle veg_type c_red"></i></label>
							         <?php endif;?>
							      </td>
							      <td>
							         <?php if($row['is_size']==0): ?>
							         <?= currency_position($row['price'],restaurant()->id);?>
							         <?php else: ?>
							         <?php  
							            $price = json_decode($row['price'],TRUE); ?>
							           <div class="sizeTags">
									         <?php
									            foreach ($price as $key => $value) :
									            if(!empty($value)):
									            ?>
									         		<label class="label default-light-soft-active mb-3"><?= $this->admin_m->get_size_by_slug($key,auth('id'));?> : <?= currency_position($value,restaurant()->id);?></label>
									         <?php 
									            endif;
									            endforeach;
							            	 ?>
							         	</div>
							         <?php endif;?>
							      </td>
							      <td>
							         <?php if(isJson($row['allergen_id'])): ?>
							        	 <label class="label bg-primary-soft"><?= lang('allergens');?> :  <?= is_array(json_decode($row['allergen_id']))?allergens(json_decode($row['allergen_id'])):'';?></label>
							         <?php endif;?>
							       
							        	<div class="mt-5">
							        		 <?php if($row['is_features']==1): ?>
							        		<label class="label bg-success-soft" title="show in home page"><i class="fa fa-home"></i></label>
							        		<?php endif;?>
							        	</div>
							      </td>
							       <?php if(restaurant()->stock_status==1): ?>
							       	<td>
							       		<span class="label default-light-active"><?= lang('in_stock'); ?> <?= $row['in_stock'] ;?></span>
							       		<div class="mt-5">
							       			<span class="label bg-success-soft"><?= lang('remaining'); ?> <?= $row['in_stock'] - $row['remaining'] ;?></span>
							       		</div>
							       	</td>
							       <?php endif;?>

							      <td>
							      	<?php if(is_access('change-status')==1): ?>
							         <a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="items" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
							     	<?php endif; ?>
								     
							      </td>
							      <td class="text-center">
							         <div class="btn-group">
							            <a href="javascript:;" class="dropdown-btn dropdown-toggle fz-18 text-dark" data-toggle="dropdown" aria-expanded="false">
							            <i class="fas fa-ellipsis-h"></i>
							            </a>
							            <ul class="dropdown-menu dropdown-ul" role="menu">
							            	<?php if(is_access('update')==1): ?>
						            		<?php if($multilang==0): 
						            			$edit = base_url("admin/menu/edit_item/{$row['id']}"); 
						            		else:
						            			$edit = base_url("admin/menu/edit_item/{$row['id']}?lang={$lang}"); 
						            		endif; ?>

							               	<li class="cl-info-soft"><a href="<?= $edit; ?>" ><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a></li>
							           		<?php endif; ?>

							              <?php if(restaurant()->stock_status==1): ?>
							              		<?php if(is_access('update')==1): ?>
							              	 	<li class="cl-danger-soft"><a href="<?= base_url('admin/menu/reset_count/'.$row['id'].'/items') ;?>" class=" action_btn" data-msg="<?= lang('reset_stock_count'); ?>"><i class="icofont-refresh"></i> <?= !empty(lang('reset_count'))?lang('reset_count'):"Reset Count";?></a></li>
							              		<?php endif; ?>
										  <?php endif;?>
										  <?php if(is_access('delete')==1): ?>
							               	<li class="cl-danger-soft"><a href="<?= base_url('delete-item/'.html_escape($row['id']).'/items'); ?>" class=" action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a></li>
							          	 	<?php endif; ?>
							          	 	<?php if(is_access('update')==1): ?>
							          	 		<?php if($multilang==0): 
													$clone_url = base_url("admin/menu/edit_item/{$row['id']}?action=copy"); 
												else:
													$clone_url = base_url("admin/menu/edit_item/{$row['id']}?action=copy&lang={$lang}"); 
												endif; ?>
							               		<li class="cl-warning-soft"><a href="<?= $clone_url; ?>" ><i class="fa fa-clone"></i> <?= lang('clone_item');?></a></li>
							           		<?php endif; ?>
							            </ul>
							         </div>
							         <!-- button group -->
							      </td>
							   </tr>
							   <?php $j++; endforeach ?>
					
					</tbody>
				</table>
			</div><!-- card-body -->
			<div class="card-footer makeChanges text-right" style="display:none;">
				<a href="javascript:;" class="btn btn-secondary reload"><?= lang('save'); ?></a>
			</div>
		</div><!-- card -->
		<?php $i++; endforeach ?>
		<a href="javascript:;" data-id="items" id="tables"></a>
	</div>
</div>


<div id="lnModal_<?= $lang;?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?= $category_name??'';?> - <?= $lang;?></h4>
      </div>
      	<form action="<?= base_url("admin/menu/import/{$category_id}");?>" enctype= "multipart/form-data" method="post">
			<?= csrf();?>
	      <div class="modal-body">
	        <input type="file" name="file" required accept=".csv,vnd.ms-excel">
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-success"><?= lang('submit');?></button>
	      </div>
	    </div>
	</form>

  </div>
</div>