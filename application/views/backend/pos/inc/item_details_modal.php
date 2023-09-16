<form action="<?= base_url("admin/pos/add_to_cart_form");?>" method="post" class="addToCart">
	<?= csrf();?>
	<input type="hidden" name="main_price" class="mainPrice" value="<?= $item->is_size==0?$item->price:0;?>">
	<input type="hidden" name="item_price" class="item_price" value="0">
	<div class="ModalItemDetails">
		<div class="modal-body">
			<div class="itemIntro">
				<h4><?= $item->title;?> <?php if(isset($item->veg_type) && $item->veg_type!=0): ?> <i class="fa fa-circle veg_type <?= $item->veg_type==1?'c_green':'c_red';?>" data-placement="top" data-toggle="tooltip" title="<?= veg_type($item->veg_type);?>"></i><?php endif;?></h4>
				<div class="stockStatus">
					<?php if(shop($item->shop_id)->stock_status == 1): ?>
						<?php if(shop($item->shop_id)->is_stock_count == 1): ?>
							<?php $remaining = $item->in_stock - $item->remaining; ?>
							<p class="fz-12 stock_counter"><?= lang('availability'); ?> : <?= $item->in_stock > $item->remaining?'<span class="in_stock">'.lang('in_stock').'</span>'.' ('.$remaining.')':'<span class="out_of_stock">'.lang('out_of_stock').'</span>'; ?></p>
						<?php else: ?>
							<p class="fz-12 stock_counter"><?= lang('availability'); ?> : <?= $item->in_stock > $item->remaining?'<span class="in_stock">'.lang('in_stock').'</span>':'<span class="out_of_stock">'.lang('out_of_stock').'</span>' ?></p>
						<?php endif;?>

					<?php endif;?>
				</div>
				<div class="itemPrice">
					<?php if($item->is_size==0): ?>
						<?php if(shop($item->shop_id)->currency_position == 1): ?>
							<p><b> <span class="show_price"><?= html_escape(number_formats($item->price,shop($item->shop_id)->number_formats)) ;?></span> <?= shop($item->shop_id)->icon; ?> </b></p>
						<?php else: ?>
							<p><b><?= shop($item->shop_id)->icon; ?> <span class="show_price"><?= html_escape(number_formats($item->price,shop($item->shop_id)->number_formats)) ;?></span> </b></p>
						<?php endif;?>
					<?php endif;?>
				</div><!-- itemPrice -->

				 <!-- price with sizes -->
				 <?php if(isset($item->is_size) && $item->is_size==1): ?>

				 	<?php if(shop($item->shop_id)->currency_position == 1): ?>
				 		<h5 class="priceTag hidden"><?= lang('price'); ?>: <span class="show_price"> </span> <?= shop($item->shop_id)->icon ;?></h5>
				 	<?php else: ?>  
				 		<h5 class="priceTag hidden"><?= lang('price'); ?>: <?= shop($item->shop_id)->icon ;?> <span class="show_price"> </span> </h5>
				 	<?php endif;?>


			 		<div class="mt-10 slots_area details_price">
			 			<?php $price = json_decode($item->price,TRUE); ?>
			 			<?php 
				 			foreach ($price as $key => $value):
				 			if(!empty($value)):
				 				?>
				 				<label class="single_slots getPrice" data-price="<?= $value;?>">
				 					<?= $this->admin_m->get_size_by_slug($key,$item->user_id);?>
				 					 <input type="radio" name="size_price" class="checked_values" value="<?= $value;?>">
				 					 <input type="radio" name="size_slug" class="checked_values" value="<?= $key;?>">

				 					</label>
				 					<?php
				 				endif; 
				 			endforeach; 
			 			?>
			 		</div>
				<?php endif;?>
           <!-- price with sizes -->


			</div><!-- itemIntro -->
			<div class="itemDetails">
				<p><?= @$item->overview ;?> </p>
				<?php if(isset($item->extras['is_extra']) && $item->extras['is_extra']==1 && sizeof($item->extras['result']) > 0): ?>
				<div class="item_extra_list <?= isset($item->is_size) && $item->is_size==1?"hidden":"" ;?>">
					<h5 class="extrasHeading"><?= !empty(lang('extras'))?lang('extras'):'Extras'; ?></h5>
					<ul class="extraUl">
						<?php foreach ($item->extras['result'] as $key => $extra): ?>
							<?php if(!empty($extra)): ?>
								<li>
									<label class="custom-checkbox">
										<p><input type="checkbox" name="extras" class="extras" data-name="<?=  html_escape($extra['ex_name']);?>" data-id="<?= $extra['id'] ;?>" data-item="<?= $extra['item_id'] ;?>" value="<?= $extra['ex_price'] ;?>">  <span class="mr-30"><?=  html_escape($extra['ex_name']);?></span> &nbsp; </p>
										<?php if($extra['ex_price'] !=0): ?>
											<span class="left_bold"> <?= currency_position($extra['ex_price'],$extra['shop_id']);?></span>
										<?php endif ?>
									</label>
								</li>
							<?php endif;?>
						<?php endforeach ?>
					</ul>
				</div>
			<?php endif;?>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-default" data-dismiss="modal"><?= lang('cancel');?></button>
			<?php if(isset($item->extras['is_extra']) && $item->extras['is_extra']==1): ?>
				<input type="hidden" name="extra_id" class="extra_id">
				<input type="hidden" name="extra_name" class="extra_name">
			<?php endif; ?>

			<input type="hidden" name="item_id" class="item_id" value="<?= base64_encode($item->id);?>">

			<?php if(shop($item->shop_id)->stock_status == 1): ?>

				<?php if($item->in_stock > $item->remaining): ?>
					<?php if(isset($item->is_size) && $item->is_size==1): ?>
						<button type="submit" class="btn btn-primary add_to_cart_form hidden"> <i class="icofont-ui-cart"></i> <?= lang('add_to_cart');?></button>
					<?php else: ?>
						<button type="submit" class="btn btn-primary"> <i class="icofont-ui-cart"></i> <?= lang('add_to_cart');?></button>
						<?php endif; ?><!-- is_size -->
				<?php endif; ?> <!-- in_stock / remaining -->

			<?php else: ?> <!-- stock_status -->

				<?php if(isset($item->is_size) && $item->is_size==1): ?>
					<button type="submit" class="btn btn-primary add_to_cart_form hidden"> <i class="icofont-ui-cart"></i> <?= lang('add_to_cart');?></button>
				<?php else: ?><!-- item->is_size -->
					<button type="submit" class="btn btn-primary"> <i class="icofont-ui-cart"></i> <?= lang('add_to_cart');?></button>
				<?php endif ?><!-- item->is_size -->

			<?php endif ?><!-- end stock_status -->
		</div>
	</div><!-- ModalItemDetails -->
</form>
