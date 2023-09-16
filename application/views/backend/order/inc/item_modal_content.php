<div class="modal-header">
	<button type="button" class="close closeModal" >&times;</button>
	<h4 class="modal-title"><?= lang('items'); ?></h4>
</div>
<div class="modal-body item-modal p-0">
	<div class="table-responsive">
		<div class="searchArea text-right col-md-12">
			<form action="<?= base_url("admin/restaurant/ajax_pagination/{$order_details['uid']}");?>" method="POST" class="col-md-4 mb-10 pl-0 mt-5 ajaxSearch">
				<?= csrf();?>
				<div class="input-group">
					<input type="text" name="q" class="form-control h-i" placeholder="<?= lang('search');?>" value="<?= isset($_REQUEST['q']) && !empty($_REQUEST['q'])?$_REQUEST['q']:'';?>">
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit">
							<i class="glyphicon glyphicon-search"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
		<div class="ajaxItemForm">
			<ul class="firstUl ">
				<li class="5%">#</li>
				<li class="10%"><?= lang('image'); ?></li>
				<li class="20%"><?= lang('name'); ?></li>
				<li class="30%"><?= lang('price'); ?></li>
				<li  class="10%"><?= lang('qty'); ?></li>
				<li class="10% text-right"><?= lang('action'); ?></li>
			</ul>
			<?php foreach ($all_items as $key2 => $items): ?>
					<form action="<?= base_url('admin/restaurant/add_order_item/'.$order_details['uid'].'/'.$items['id']) ;?>" method="post" autocomplete="off" class="addToCart_From">
						<?= csrf();?>
						<ul>
							<li class="5%"><?= $key2+1;?></li>
							<li class="10%"><img src="<?= get_img($items['item_thumb'],$items['img_url'],$items['img_type']) ;?>" alt="" class="order-img"></li>
							<li class="15%"><?=  $items['title'];?></li>
							<li class="40%">
								<?php if($items['is_size']==1): ?>
									<div class="singleSize">
										<?php $price = json_decode($items['price'],TRUE); ?>
										<?php $p=1; foreach ($price as $key => $value):
										if(!empty($value)):
											?>
											<label class="label bg-light-purple-soft custom-radio-2"><input type="radio" class="size_price" onclick="add_price(<?= $value;?>,<?= $key2;?>)" name="size_slug" value="<?= $key ;?>" required>
												<?= $this->admin_m->get_size_info_by_slug($key,$items['shop_id'])['title'];?> : <?= currency_position(html_escape($value),restaurant()->id);?>

											</label>

											<?php
										endif; $p++;
									endforeach; 
									?>
									<input type="hidden" name="item_price" class="item_price_<?= $key2;?>" value="0">
								</div>
								<input type="hidden" name="is_size" value="1">
							<?php else: ?>
								<input type="hidden" name="is_size" value="0">
								<input type="hidden" name="item_price" value="<?= $items['price'];?>">
								<?=  $items['price'];?>
							<?php endif;?>
						</li>
						<li class="10%"><input type="number" name="qty" value="1" min="1" class="form-control"></li>
						<li class="10% text-right"><button type="submit" class="addtocartBtn btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i></button></li>
					</ul>
				</form>
			<?php endforeach;?>
		</div>

	</div>

</div>
<div class="modal-footer">
	<span class="reg_msg text-left"></span>
	<div class="text-right">
		<div id="pagination">
			<?= $this->pagination->create_links(); ;?>
		</div>

		<button type="button" class="btn btn-info closeModal"><?= lang('close'); ?></button>
	</div>
</div>



<script>
	$(document).on('click','.closeModal',function(){
		window.location.reload();
	});
</script>