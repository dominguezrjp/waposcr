<section class="sectionDefault theme_2">
	<?php include "include/banner.php"; ?>

  <?php include APPPATH.'views/common_layouts/coupon_list.php'; ?>
	<div class="section_items">
    <div class="defaultHeading text-center">
      <h1 class="mb-6"><?= get_title($id,'menu',1) ;?></h1>
      <?php if(!empty(get_title($id,'menu',2))): ?>
        <p><?= get_title($id,'menu',2) ;?></p>
      <?php endif;?>
    </div>
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="gallery_area">
          <div class="gallery_top_menu">
            <ul class="gallery_sort">
              <li><button  data-filter='*' class="active default-button"><?= lang('all'); ?></button></li>
              <?php foreach ($all_items as $key => $type): ?>
                  <?php if(count($type['items'])>0): ?>
                    <li><button  data-filter='.<?= html_escape($type['id']);?>' class="default-button"><?= html_escape($type['name']);?></button></li>
                  <?php endif;?>
              <?php endforeach ?>
            </ul>
          </div>
          <div class="grid" >
            <?php foreach ($all_items as $key => $type): ?> 
              <?php foreach ($type['items'] as $key => $row): ?>
                <div class ="grid-item <?= $row['cat_id']?> portfolio_single_img">
                  <div class="itemImages">
                    <?php include "include/item_thumbs.php"; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </div>
        </div><!-- gallery_area -->
      </div>
      <div class="col-md-3">
        <div class="singleMenuItem <?= isset($is_search) && $is_search==TRUE?"mt-0":"mt-85" ;?>">
           <?php include 'include/rightbar.php' ?>
        </div>
      </div>
    </div>
  </div>
</div>
</section>