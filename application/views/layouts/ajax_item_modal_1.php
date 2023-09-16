
<div class="modal-content">

  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Order List</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body item_modal">
    <div class="single_item">
      <div class="single_items_img">
        <img src="<?= base_url($item[0]['images']) ;?>" alt="">
      </div>
      <div class="single_item_details">
        <h4><?= html_escape($item[0]['title']) ;?> <?php if(isset($item[0]['veg_type']) && $item[0]['veg_type']!=0): ?> <i class="fa fa-circle veg_type <?= $item[0]['veg_type']==1?'c_green':'c_red';?>" data-placement="top" data-toggle="tooltip" title="<?= veg_type($item[0]['veg_type']);?>"></i><?php endif;?></h4>
          <?php if($item[0]['is_size']==0): ?>
           <p><b><?= get_currency('icon').''.html_escape(number_format($item[0]['price'],2)); ?> </b></p>
         <?php endif;?>

          <p class="capital">
            <?php if(isset($item[0]['allergen']) && !empty($item[0]['allergen'])): ?>
              <span><?= !empty(lang('allergens'))?lang('allergens'):'allregens' ;?>: <?= html_escape($item[0]['allergen']) ;?></span>
            <?php endif;?>
          </p>
          <?php if($item[0]['is_size']==1): ?>
            <div class="mt-10">
              <?php $price = json_decode($item[0]['price'],TRUE); ?>
              <?php foreach ($price as $key => $value):
                if(!empty($value)):
                 ?>
                 <label class="btn btn-secondary fz-12 mb-3 d-inline-block"><?= $this->admin_m->get_size_by_slug($key);?> : <?= $value.' '.get_currency('icon');?></label>
                 <?php
               endif; 
             endforeach; 
             ?>
           </div>
         <?php endif;?>
      </div>
      <div class="item_extra_details">
          <?php if(isset($item[0]['details']) && !empty($item[0]['details'])): ?>
            <p><?= $item[0]['details'] ;?></p>
          <?php endif;?>
          <?php if(isset($item[0]['items']) && !empty($item[0]['items'])): ?>
          <div class="item_extra_list">
            <ul>
                <?php foreach ($item[0]['items'] as $key => $value): ?>
                  <?php if(!empty($value)): ?>
                    <li><span class="left_bold"><?=  html_escape($value['label']);?> :</span> <?=  html_escape($value['value']);?></li>
                  <?php endif;?>
                <?php endforeach ?>
            </ul>
          </div>
        <?php endif;?>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary add_to_cart" data-res-id="<?= $shop_id;?>" data-id="<?=  html_escape($item[0]['item_id']);?>" data-type="item" data-size=''> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
  </div>
</div>