<?php if(isset(restaurant()->is_multi_lang)): ?>
<div class="row">
	<?php $multilang = isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang==1?1:0; ?>
	<?php if($multilang==0): ?>
		<div class="col-md-8">
			<div class="card">
				<div class="card-body flex_between">
					<h4><?= lang('enable_multi_lang_category_items');?></h4> <a href="<?= base_url("admin/auth/enable_category");?>" class="btn btn-secondary action_btn"><?= lang('enable');?></a>
				</div>
			</div>
		</div>
		<?php $add_new_url = base_url("admin/menu/create_item"); ?>
		<?php $lang = isset($_GET['lang'])?$_GET['lang']:"english"; ?>
	<?php else: ?>
		<?php 
		$controller = $this->uri->rsegment(1); // The Controller
		$function = $this->uri->rsegment(2);
		$lang = isset($_GET['lang'])?$_GET['lang']:site_lang();
		?>
		<?php if(isset($is_create) && $is_create==0): ?>
			<?php include 'language_dropdown.php'; ?>
		<?php endif; ?>
		
		<?php $add_new_url = base_url("admin/menu/create_item/?lang={$lang}"); ?>
	<?php endif; ?>
</div>
<?php else: ?>
	<?php $lang = isset($_GET['lang'])?$_GET['lang']:site_lang(); ?>
<?php endif; ?>

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
<div class="col-md-12">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title"><?= !empty(lang('items'))?lang('items'):"items";?> &nbsp; &nbsp; 
				
			</h3>
			<div class="box-tools pull-right">
				<?php if(isset($active) && $active==1): ?>
					<?php if(is_access('add')==1): ?>
						<a href="<?= $add_new_url??'' ;?>" class="btn btn-secondary btn-flat"><i class="fa fa-plus"></i> &nbsp;<?= !empty(lang('add_new_item'))?lang('add_new_item'):"Add New Item";?> </a>
					<?php endif;?>
				<?php endif;?>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body bg_gray">
			<div class="table-responsives">
				<div class="row">
					<?php foreach ($menu_type as $key => $cat): ?>
						<div class="col-md-3 <?= multi_lang(auth('id'),$cat);?>">
							<a href="<?= base_url("admin/menu/item_list/".multi_lang(auth('id'),$cat)."?lang={$lang}"); ?>">
								<div class="single_cat">
									<img src="<?= get_img($cat['thumb'],'',1) ;?>" alt="">
									<div class="catDetails">
										<h4><?= $cat['name'] ;?></h4>
										
										<div class="mt-10">
											<label class="label default-light-soft-active fz-14">
												<?php if(isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang==1): ?>
													<?= $this->admin_m->get_total_item_by_cat_id_ln(multi_lang(auth('id'),$cat),$lang) ;?>
												<?php else: ?>
													<?= $this->admin_m->get_total_item_by_cat_id($cat['id']) ;?>
												<?php endif; ?>

												 <i class="icofont-cherry"></i></label>
										</div>
									</div>
								</div>
							</a>
						</div>
					<?php endforeach ?>
				</div>

			</div>
		</div><!-- /.box-body -->
	</div>
</div>
</div>