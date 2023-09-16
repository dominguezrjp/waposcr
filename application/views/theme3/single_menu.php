<section class="sectionDefault">
	<?php include "include/banner.php"; ?>
	<div class="section_items">
  
  <?php include APPPATH.'views/common_layouts/coupon_list.php'; ?>


    <div class="defaultHeading text-center">
      <h1 class="mb-6"><?= get_title($id,'menu',1) ;?></h1>
      <?php if(!empty(get_title($id,'menu',2))): ?>
        <p><?= get_title($id,'menu',2) ;?></p>
      <?php endif;?>
    </div>
  <div class="restaurant-container style_2 theme_3">
    <div class="row">
      <div class="col-md-12">
        <div class="gallery_area">
          <div class="gallery_top_menu">
            <ul class="gallery_sort category_shot">
              <li><button  id='0' class="active default-button"><?= lang('all'); ?></button></li>
              <?php foreach ($all_items as $key => $type): ?>
                  <?php if(count($type['items'])>0): ?>
                    <li><button  id="<?= $type['id'] ;?>"><?= html_escape($type['name']);?></button></li>
                  <?php endif;?>
              <?php endforeach ?>
            </ul>
          </div>
          <div class="all_categories" >
            <?php $ids = []; ?>
           <?php foreach ($all_items as $key => $type): ?>
            <?php $ids[] = $type['id'] ?>
            <?php if(sizeof($type['items'])>0): ?>
              <div class="homeView category_<?= $type['id'] ;?>" id="category_<?= $type['id'] ;?>">
                <div class="row">
                  <div class="col-md-12">
                    <div class="singleCategoryHeader">
                      <h4><?= html_escape($type['name']);?></h4>
                      <?php if(count($type['items'])>= 4): ?>
                        <a href="<?= base_url('item-types/'.$slug.'/'.md5(multi_lang($id,$type))) ;?>" class="seeMore_link"><?= lang('see_more'); ?> &nbsp;<i class="icofont-thin-double-right fw_bold"></i></a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <?php foreach ($type['items'] as $key => $row): ?>
                    <div class="col-xl-4 col-lg-34 col-md-6 col-sm-6 q-sm ">
                     <?php include 'include/item_thumbs.php'; ?>
                   </div>
                 <?php endforeach ?>
               </div> 
             </div>
           <?php endif;?>
         <?php endforeach; ?> 
          </div>
        </div><!-- gallery_area -->
      </div>
    </div>
  </div>
</div>
</section>
<script>
  var categories = <?= json_encode($ids) ;?>;
</script>