<?php  $review = get_by_section_name('reviews'); ?>
<section class=" default review_section homeSection">
    <div class="container">
    	<?php if(!empty($review['heading'])): ?>
	      	<div class="contact_content">
	          <div class="col-md-8 offset-md-2">
	          	<div class="sction_title">
	            	<h4 class="section_heading"><?= html_escape($review['heading']) ;?></h4>
	              	<p><?= html_escape($review['sub_heading']) ;?></p>
	          	</div>

	          </div>
	          	<div class="row sm_row_reverse">
	          		<div class="col-md-8">
	          			<div class="rating_button">
		      				<div class="">
		      					
		      				</div>
		      				<div class="select_rating">
		      					<select name="rating" class="form-control" id="" onchange="location=this.value;">
			      					<option <?= isset($_GET['sort']) && $_GET['sort']== 'newest'?"selected":"";?>  value="<?= base_url('home/reviews/?sort=newest'); ?>" ><?=  !empty(lang('sort_by'))?lang('sort_by'):"Sort by";?> <?=  !empty(lang('newest'))?lang('newest'):"Newest";?></option>

			      					<option <?= isset($_GET['sort']) && $_GET['sort']== 'highest'?"selected":"";?>  value="<?= base_url('home/reviews/?sort=highest'); ?>"><?=  !empty(lang('sort_by'))?lang('sort_by'):"Sort by";?> <?=  !empty(lang('highest_rating'))?lang('highest_rating'):"Highest Rating";?></option>

			      					<option <?= isset($_GET['sort']) && $_GET['sort']== 'lowest'?"selected":"";?>  value="<?= base_url('home/reviews/?sort=lowest'); ?>"><?=  !empty(lang('sort_by'))?lang('sort_by'):"Sort by";?> <?=  !empty(lang('lowest_rating'))?lang('lowest_rating'):"Lowest Rating";?></option>
			      				</select>
		      				</div>
		      			</div>
	          			<div class="single_rating">
	          				<?php foreach ($reviews as $key => $row): ?>
		          				<div class="rating_content">
		          					<div class="rating_header">
		          						<div class="star_area">
		          							<?php for ($i=1; $i <=5 ; $i++) { ?>
		          								<?php if($i > $row['rating']): ?>
			          								<i class="fa fa-star-o"></i>
			          							<?php else: ?>
			          								<i class="fa fa-star"></i>
			          							<?php endif;?>
			          						<?php } ?>
		          						</div>
		          						<div class="rating_by">
		          							<a href="<?= base_url(html_escape($row['username']));?>"><?= html_escape($row['username']);?> </a><span class="time_ago"><i class="fa fa-clock"></i> <?= get_time_ago($row['created_at']);?></span>
		          						</div>
		          					</div>
		          					<?php if(!empty($row['msg'])): ?>
			          					<div class="comments_area">
			          						<p><?= html_escape($row['msg']);?></p>
			          					</div>
			          				<?php endif;?>
		          				</div>
	          				<?php endforeach ?>
	          			</div>
	          		</div>
	          		<div class="col-md-4">
	          			<div class="author_rating">
	          				<?php $avg = number_format($total_rating/count($reviews),1); ?>
	          				<h4><?= !empty(lang('rating'))?lang('rating'):'Rating' ;?> <span class="jstars" data-value="<?= $avg ;?>" data-total-stars="5" data-color="#FF912C" data-empty-color="#ddd" data-size="30px"></span></h4>
	          				<p><?= $avg ;?> average based on <?=  count($reviews);?> ratings.</p>
	          			</div>
	          		</div>
	          	</div>
	        </div>
      	<?php else: ?>
	      	<div class="row">
				<div class="empty_area">
					<div class="empty_text">
						<i class="fa fa-frown fa-2x"></i>
						<h4>Sorry! Data Not found</h4>
						<code>Admin-> settings -> home/banner settings -> Add review section</code>
					</div>
				</div>
			</div>
      	<?php endif;?>
    </div>
  </section>