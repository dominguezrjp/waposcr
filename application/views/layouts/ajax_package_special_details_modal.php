
<div class="modal-content">

  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= html_escape($item['package_name']) ;?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body item_modal">
    <div class="single_item">
      <div class="single_items_img">
        <img src="<?= base_url($item['images']) ;?>" alt="itemImg">
      </div>
      <div class="single_item_details">
        <h4><?= html_escape($item['package_name']) ;?></h4>

        <?php if(shop($item['shop_id'])->stock_status == 1): ?>

          <?php if(shop($item['shop_id'])->is_stock_count == 1): ?>
            <?php $remaining = $item['in_stock'] - $item['remaining']; ?>

           <p class="fz-12"><?= lang('availability'); ?> : <?= $item['in_stock'] > $item['remaining']?'<span class="in_stock">'.lang('in_stock').'</span>'.' ('.$remaining.')':'<span class="out_of_stock">'.lang('out_of_stock').'</span>'; ?></p>
          <?php else: ?>
            <p class="fz-12"><?= lang('availability'); ?> : <?= $item['in_stock'] > $item['remaining']?'<span class="in_stock">'.lang('in_stock').'</span>':'<span class="out_of_stock">'.lang('out_of_stock').'</span>' ?></p>
          <?php endif;?>

        <?php endif;?>

           <p><b><?= currency_position($item['price'],$item['shop_id']); ?> </b></p>
      </div>
      <div class="item_extra_details">
          <?php if(isset($item['details']) && !empty($item['details'])): ?>
            <p><?= $item['details'] ;?></p>
            <?php else: ?>
            <p><?= $item['overview'] ;?></p>
          <?php endif;?>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>
      <?php if(shop($item['shop_id'])->is_cart == 1): ?>
         <?php if(shop($item['shop_id'])->stock_status == 1): ?>
           <?php if($item['in_stock'] > $item['remaining']): ?>
              <button type="button" class="btn btn-primary add_to_cart"  data-id="<?=  html_escape($item['id']);?>" data-type="package"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
            <?php endif;?>
        <?php else: ?>
             <button type="button" class="btn btn-primary add_to_cart"  data-id="<?=  html_escape($item['id']);?>" data-type="package"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
        <?php endif;?>
      <?php endif;?>
  </div>
</div>