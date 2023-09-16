<section class="sectionDefault categorySection theme_2">
	<?php include "include/banner.php"; ?>
	<div class="section_items">
    <div class="defaultHeading text-center">
      <h1 class="mb-6"><?= @$cat_info['name'] ;?></h1>
    </div>
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div id="showCatItem">
          <?php include "include/ajax_single_item_list.php"; ?>
        </div>
        
      </div>
      <div class="col-md-3">
        <div class="singleMenuItem">
          <?php include 'include/rightbar.php' ?>
        </div>
      </div>
    </div>
  </div>
</div>
</section>