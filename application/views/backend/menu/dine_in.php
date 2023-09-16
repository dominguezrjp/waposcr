<div class="row">
	<div class="col-md-6">
		<?php 
			$total = $this->admin_m->count_packages_user_id('item_packages',$is_special=2);
		    $limit = limit(auth('id'),1);
		 ?>
		<?php if($limit ==0): ?>
			<div class="single_alert alert alert-info alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <div class="d_flex_alert ">
	                <h4><i class="fas fa-exclamation-triangle"></i> <?= lang('info'); ?></h4>
	                <div class="double_text">
	                    <div class="text-left">
	                        <h5><?= lang('you_can_add'); ?> <b class="underline"> <?= lang('unlimited'); ?> </b> <?= lang('menu'); ?></h5>
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
	<div class="col-md-10 col-lg-10 col-sm-10">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('qr_builder'))?lang('qr_builder'):"QR builder";?> &nbsp; &nbsp; 
					<?php if(isset($active) && $active==1): ?>
						<?php if(is_access('add')==1): ?>
							<a href="<?= base_url('admin/menu/create_dine_in') ;?>" class="btn btn-info info-light btn-flat"><i class="fa fa-plus"></i> &nbsp;<?= !empty(lang('add_new'))?lang('add_new'):"Add New";?> </a>
						<?php endif; ?>
					<?php endif;?>
				</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="">
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<th width=""><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
								<th width=""><?= !empty(lang('image'))?lang('image'):"image";?></th>
								<th width=""><?= !empty(lang('menu_name'))?lang('menu_name'):"Menu name";?></th>
								<th width=""><?= !empty(lang('price'))?lang('price'):"price";?></th>
								<th width=""><?= !empty(lang('items'))?lang('items'):"items";?></th>
								<th width=""><?= !empty(lang('status'))?lang('status'):"status";?></th>
								<th width=""><?= !empty(lang('action'))?lang('action'):"action";?></th>


							</tr>
						</thead>
						<tbody>

							<?php $i=1; foreach ($packages as $key => $value): ?>
							<?php if(count($value['items'])>0): ?>
								<tr>
									<td><?= $i;?></td>
									<td>
										<div class="serviceImgs mb-10">
											<img src="<?= base_url($value['qr_link']);?>" alt="">
										</div>

										<div class="serviceImgs hidden">
											<img src="<?= base_url($value['thumb']);?>" alt="">
										</div>
									</td>
									<td><?= html_escape($value['package_name']); ?>
									 <?php if($value['is_home']==1): ?>
									 	&nbsp; <label class="label label-success" title="show in home page"><i class="fa fa-home"></i></label>
									 <?php endif;?>
									 	
									 </td>
									
									<td>
										
										<?php if($value['is_discount']==1): ?>
											<?= currency_position($value['final_price'],restaurant()->id);?>
											<span class="price_discount">
												<?= currency_position($value['price'],restaurant()->id); ?>
											</span> &nbsp;
											<label class="label default-light-active"><?= html_escape($value['discount']) ;?> %</label>

										<?php else: ?>
												<?= currency_position($value['price'],restaurant()->id); ?>
										<?php endif; ?>
									</td>
									<td class="bg_white">
										
										<table class="table table-bordered " > 

											<tr>
												<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
												<th><?= !empty(lang('images'))?lang('images'):"images";?> </th>
												<th><?= !empty(lang('title'))?lang('title'):"title";?></th>
												<th><?= !empty(lang('price'))?lang('price'):"price";?> </th>
											</tr>
											<?php $j=1; foreach ($value['items'] as $row): ?>
											<tr>
												<td><?= $j;?></td>
												<td>
													<div class="serviceImg">
														<img src="<?= base_url($row['item_thumb']);?>" alt="">
													</div>
												</td>
												<td><?= html_escape($row['title']); ?></td>
												<td><?= currency_position($row['item_price'],restaurant()->id); ?></td>
											</tr>
											<?php $j++; endforeach ?>
										</table>
										
									</td>
									
									<td>
										<?php if(is_access('change-status')==1): ?>
											<a href="javascript:;" data-id="<?= html_escape($value['id']);?>" data-status="<?= html_escape($value['status']);?>" data-table="item_packages" class="label <?= $value['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $value['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $value['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
										<?php endif; ?>
										<?php if($value['table_no'] !=0): ?>
											<div class="mt-5">
												<?php $table = single_select_by_id($value['table_no'],'table_list'); ?>
												<label class="label label-primary"><?= $table['name'] ;?></label>
											</div>
										<?php endif;?>
										
									</td>

									<td>
										<div class="dflex">
											<a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($value['id'])); ?>" target="_blank" class="btn btn-info btn-sm btn-flat mr-4"> <i class="fa fa-eye"></i>  <?= lang('details'); ?></a>
											<div class="btn-group w_100">
												<a href="javascript:;" class="dropdown-btn dropdown-toggle btn btn-danger btn-sm btn-flat w_100" data-toggle="dropdown" aria-expanded="false">
													<span class="drop_text"><?= lang('action'); ?> </span> <span class="caret"></span>
												</a>

												<ul class="dropdown-menu dropdown-ul" role="menu">
													<?php if(is_access('update')==1): ?>
														<li class="cl-info-soft"><a href="<?= base_url('admin/menu/edit_dine_in/'.html_escape($value['id'])); ?>" ><i class="fa fa-edit"></i> <?= lang('edit'); ?></a></li>
													<?php endif; ?>

													<?php if(is_access('delete')==1): ?>
														<li class="cl-danger-soft"><a href="<?= base_url('delete-item/'.html_escape($value['id']).'/item_packages'); ?>" class="action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a></li>
													<?php endif; ?>

												</ul>
											</div><!-- button group -->
										</div>
										<?php if(!empty($value['qr_link'])): ?>
											<div class="mt-5">
												<a href="<?= base_url($value['qr_link']) ;?>" download class="btn btn-primary btn-block btn-sm "><i class="fa fa-download"></i> &nbsp; <?= !empty(lang('download_qr'))?lang('download_qr'):"Download QR";?></a>
											</div>
										<?php endif;?>
									</td>
								</tr>
							<?php endif;?>
							<?php $i++; endforeach ?>
						</tbody>
					</table>
					
				</div>
			</div><!-- /.box-body -->
			<div class="box-footer">
				
			</div>
		</div>
	</div>
</div>

