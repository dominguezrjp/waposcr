<ul>
	<?php foreach ($sizes as $key => $size): ?>
		<?php if(!empty($size['title'])): ?>
			<li>
				<div class="input-group">
					<span class="input-group-addon"><?= html_escape($size['title']);?></span>
					<input type="number" name="is_price[]" class="form-control" placeholder="<?= lang('price'); ?>" autocomplete="off" step="any">
					<input type="hidden" name="slug[]" value="<?= html_escape($size['slug']);?>"	>
				</div>
			</li>
		<?php endif;?>
	<?php endforeach ?>
	
</ul>
