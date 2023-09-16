
<ul>
	<?php if(isset($is_search) && $is_search==TRUE): ?>
		<li class="searchLi">
			<form action="<?= base_url('profile/ajax_pagination/'.$slug.'/'.$cat_id) ;?>" method="get" class="itemSearch" autocomplete="off">
				<div class="searchBar">
		            <div class="search-box">
		              <input type="text" class="search-txt" name="item" placeholder="<?= lang('search'); ?>" autocomplete="off">
		              <button type="submit" class="search-btn">
		                <i class="icofont-search"></i>
		              </button>
		            </div>
		          </div>
			</form>
		</li>
	<?php endif;?>
	<?php foreach ($cat_list as $key => $cat): ?>
		<?php if(isset($cat['total_item']) && $cat['total_item'] > 0 ): ?>
			<li><a href="<?= base_url('item-types/'.$slug.'/'.md5(multi_lang($id,$cat))) ;?>"><span><?=  $cat['name'];?></span> <span><?= $cat['total_item'] ;?></span></a></li>
		<?php endif;?>
	<?php endforeach ?>

</ul>