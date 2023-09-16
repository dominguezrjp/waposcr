<?php if(isset($cat_id)): ?>
<?php 
	if(isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang==1):
		 $type = $this->admin_m->get_type_by_md5id_ln($cat_id);
	else:
		 $type = $this->admin_m->get_type_by_md5id($cat_id);
	endif;
 ?>
<?php $sizes = $this->admin_m->get_cat_info_by_type($type); ?>
<ul>
	<?php $i=1; foreach ($sizes as $key => $size): ?>
		<?php if(!empty($size['title'])): ?>
			<li>
				<div class="input-group">
					<span class="input-group-addon"><?= html_escape($size['title']);?></span>
					<input type="number" name="is_price[]" class="form-control" value="" step="any" placeholder="<?= lang('price'); ?>" autocomplete="off">
					<input type="hidden" name="slug[]" value="<?= html_escape($size['slug']);?>"	>
				</div>
			</li>
		<?php endif;?>
	<?php  $i++; endforeach ?>
	
</ul>
<?php else: ?>
<?php $type = $this->admin_m->get_type_by_id($data['cat_id']); ?>
<?php $sizes = $this->admin_m->get_cat_info_by_type($type); ?>
<?php $up_prices = json_decode($data['price'],true); ?>
<ul>
	<?php $i=1; foreach ($sizes as $key => $size): ?>
		<?php if(!empty($size['title'])): ?>
			<li>
				<div class="input-group">
					<span class="input-group-addon"><?= html_escape($size['title']);?></span>
					<input type="number" name="is_price[]" class="form-control" value="<?= isset($up_prices[$size['slug']])?$up_prices[$size['slug']]:'' ;?>" step="any" placeholder="<?= lang('price'); ?>" autocomplete="off">
					<input type="hidden" name="slug[]" value="<?= html_escape($size['slug']);?>"	>
				</div>
			</li>
		<?php endif;?>
	<?php  $i++; endforeach ?>
	
</ul>
<?php endif;?>