<div class="row">
	<?php if(count($location_list) > 0): ?>
		<?php foreach ($location_list as $key => $row): ?>
			<?php include 'inc/shop_thumb.php'; ?>
		<?php endforeach ?>
	<?php else: ?>
		<div class="empty_area">
			<h4><?= lang('not_found');?></h4>
		</div>
<?php endif ?>
</div>
