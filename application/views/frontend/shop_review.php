<?php include APPPATH.'views/theme1/include/banner.php';?>
<section class=" default review_section">
    <div class="container">
      	<div class="contact_content">
          <div class="col-md-8 offset-md-2">
          	<div class="sction_title">
            	<h4 class="section_heading"><?= !empty(lang('reviews'))?html_escape(lang('reviews')):'Reviews';?></h4>
          	</div>
          </div>
          	<div class="row sm_row_reverse">
          		<div class="col-md-8">
          			<div class="rating_button">
	      				<div class="select_rating">
	      					<select name="rating" class="form-control" id="" onchange="location=this.value;">
		      					<option <?= isset($_GET['sort']) && $_GET['sort']== 'newest'?"selected":"";?>  value="<?= base_url("profile/review/{$slug}?sort=newest"); ?>" ><?= lang('sort_by_newest');?></option>

		      					<option <?= isset($_GET['sort']) && $_GET['sort']== 'highest'?"selected":"";?>  value="<?= base_url("profile/review/{$slug}?sort=highest"); ?>"><?=  lang('sort_by_highest_rating');?> </option>

		      					<option <?= isset($_GET['sort']) && $_GET['sort']== 'lowest'?"selected":"";?>  value="<?= base_url("profile/review/{$slug}?sort=lowest"); ?>"><?=  lang('sort_by_lowest_rating');?></option>
		      				</select>
	      				</div>
	      			</div>
          			<div class="single_rating">
          				<?php foreach ($reviews as $key => $row): ?>
	          				<div class="rating_content">
	          					<div class="rating_header">
	          						<div class="star_area">
	          							<?php for ($i=1; $i <=5 ; $i++) { ?>
	          								<?php if($i > $row['customer_rating']): ?>
		          								<i class="fa fa-star-o"></i>
		          							<?php else: ?>
		          								<i class="fa fa-star"></i>
		          							<?php endif;?>
		          						<?php }; ?>
	          						</div>
	          						<div class="rating_by">
	          							<a href="javascript:;"><?= !empty($row['customer_name'])?$row['customer_name']:html_escape($row['customer_name']);?> </a><span class="time_ago"><i class="fa fa-clock"></i> <?= !empty($row['rating_time'])?get_time_ago($row['rating_time']):'';?></span>
	          						</div>
	          					</div>
	          					<?php if(!empty($row['customer_review'])): ?>
		          					<div class="comments_area">
		          						<p><?= html_escape($row['customer_review']);?></p>
		          					</div>
		          				<?php endif;?>
	          				</div>
          				<?php endforeach; ?>
          			</div>
          		</div>
          		<div class="col-md-4">
          			<div class="author_rating">
          				<?php $avg = $total_rating!=0 ?number_format($total_rating/$total_review,1):0; ?>
          				<h4><?= !empty(lang('rating'))?lang('rating'):'Rating' ;?> <span class="jstars" data-value="<?= $avg ;?>" data-total-stars="5" data-color="#FF912C" data-empty-color="#ddd" data-size="25px"></span></h4>
          				<p><?= $avg ;?> <?= !empty(lang('average_based_on'))?lang('average_based_on'):'average based on' ;?>  <?=  $total_review;?> <?= !empty(lang('rating'))?lang('rating'):'Rating' ;?>.</p>
          			</div>
          		</div>
          	</div>
        </div>
    </div>
  </section>