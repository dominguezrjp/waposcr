<div class="row">	
	<div class="col-md-12 mt-10">
		<div class="productareas row">	
			<?php foreach ($all_items as $key => $item): ?>
				<?php $extra = $this->pos_m->get_item_extras($item['id']); ?>
				<div class="col-md-4 col-xs-6 col-lg-3 p-sm-5 p-0">
					<div class="singleProduct <?= (isset($extra->is_extra) && $extra->is_extra==1) || $item['is_size']==1?"showModal":"add_to_cart" ;?> " data-id="<?= $item['id'] ;?>">	
						<div class="topImg">	
							<?php if($item['img_type']==1): ?>
								<img src="<?= base_url(!empty($item['thumb'])?$item['thumb']:EMPTY_IMG);?>" alt="">
							<?php else: ?>
								<img src="<?= !empty($item['img_url'])?$item['img_url']:base_url(EMPTY_IMG);?>" alt="">
							<?php endif; ?>
						</div>	
						<div class="itemDetails">
							<h4><?= character_limiter($item['title'],10) ;?></h4>
							<p><?= @$item['uid'] ;?></p>
							<?php if($item['is_size']==0): ?>
								<label class="label btn-success-light-active"> <?= currency_position($item['price'],restaurant()->id);?></label>
							<?php else: ?>
								<label class="label info-light-active"><?= lang('variants');?></label>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach ?>

		</div>
	</div>
</div>	
<div class="row text-center">
	<div class="ci-paginationArea">
		<div class="ci-pagination-link">
			<div id="pagination"><?= $this->pagination->create_links();?></div>
		</div>
	</div>
</div>





<!-- Modal -->
<div id="itemModal" class="modal fade" role="dialog">
 <div class="modal-dialog" role="document" id="item_details">

    
  </div>
</div>


