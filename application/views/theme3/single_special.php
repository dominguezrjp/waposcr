<section class="sectionDefaults">
	<?php include "include/banner.php"; ?>
	<div class="section_items">
	  <div class="container">
	  	<div class="defaultHeading text-center">
	          <h1 class="mb-6"><?= get_title($id,'specialities',1) ;?></h1>
	          <?php if(!empty(get_title($id,'specialities',2))): ?>
	              <p><?= get_title($id,'specialities',2) ;?></p>
	          <?php endif;?>
	    </div>
	    <div class="single_special pb-50">
	    	 <?php include APPPATH.'views/layouts/special_thumb.php'; ?> 
	    </div>
	  </div>
	</div>
</section>