<section class="sectionDefault categorySection">
	<?php include "include/banner.php"; ?>
	<div class="section_items">
    <div class="container restaurant-container style_2 theme_1">
      <div class="row">
        <div class="col-md-12">
          <div class="defaultHeading single__cat__header">
            <div class="btn-group">
              <button type="button" class="btn btn-default cat__btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= !empty($cat_info['name'])?$cat_info['name']:lang('all') ;?>
              </button>
                <div class="dropdown-menu">
                  <?php foreach ($cat_list as $key => $cat): ?>
                    <?php if(md5(multi_lang($id,$cat))!=$cat_id): ?>
                      <a class="dropdown-item" href="<?= base_url("item-types/{$slug}/".md5(multi_lang($id,$cat))) ;?>"><?= $cat['name'] ;?></a>
                    <?php endif;?>
                  <?php endforeach ?>
              </div>
            </div>
            <div class="searchSection">
              <form action="<?= base_url('profile/ajax_pagination/'.$slug.'/'.$cat_id) ;?>" method="get" class="itemSearch-2" autocomplete="off">
                <div class="searchBar-2">
                  <div class="search-box-2">
                    <input type="text" class="search-txt-2" name="item" placeholder="<?= lang('search'); ?>" autocomplete="off">
                    <button type="submit" class="search-btn">
                      <i class="icofont-search"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="container restaurant-container style_2 theme_1">
    <div class="row">
      <div class="col-md-12">
        <div id="showCatItem">
          <?php include "include/ajax_single_item_list.php"; ?>
        </div>
        
      </div>
      
    </div>
  </div>
</div>
</section>