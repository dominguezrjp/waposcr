
<div class="modal-content">

  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= html_escape($item[0]['title']) ;?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body item_modal">
    <div class="single_item">
      <div class="single_items_img">
        <img src="<?= base_url($item[0]['images']) ;?>" alt="">
      </div>
      <div class="itemModalBody">

          <div class="single_item_details">
          <h4 class="itemTitle"><?= html_escape($item[0]['title']) ;?> <?php if(isset($item[0]['veg_type']) && $item[0]['veg_type']!=0): ?> <i class="fa fa-circle veg_type <?= $item[0]['veg_type']==1?'c_green':'c_red';?>" data-placement="top" data-toggle="tooltip" title="<?= veg_type($item[0]['veg_type']);?>"></i><?php endif;?></h4>


          <?php if(shop($item[0]['shop_id'])->stock_status == 1): ?>

            <?php if(shop($item[0]['shop_id'])->is_stock_count == 1): ?>
              <?php $remaining = $item[0]['in_stock'] - $item[0]['remaining']; ?>

             <p class="fz-12 stock_counter"><?= lang('availability'); ?> : <?= $item[0]['in_stock'] > $item[0]['remaining']?'<span class="in_stock">'.lang('in_stock').'</span>'.' ('.$remaining.')':'<span class="out_of_stock">'.lang('out_of_stock').'</span>'; ?></p>
            <?php else: ?>
              <p class="fz-12 stock_counter"><?= lang('availability'); ?> : <?= $item[0]['in_stock'] > $item[0]['remaining']?'<span class="in_stock">'.lang('in_stock').'</span>':'<span class="out_of_stock">'.lang('out_of_stock').'</span>' ?></p>
            <?php endif;?>

          <?php endif;?>

            <!-- Price without size -->
            <?php if($item[0]['is_size']==0): ?>
             <p><b><?= shop($item[0]['shop_id'])->icon; ?> <span class="show_price"><?= html_escape(number_format($item[0]['price'],2)) ;?></span> </b></p>
            <?php endif;?>
            <!-- price without sizes -->

            
            <!-- price with sizes -->
            <?php if(isset($item[0]['is_size']) && $item[0]['is_size']==1): ?>
              <h5 class="priceTag hidden"><?= lang('price'); ?>: <span class="show_price"> </span> <?= shop($item[0]['shop_id'])->icon ;?></h5>
              <div class="mt-10 details_price">
                <?php $price = json_decode($item[0]['price'],TRUE); ?>
                <?php foreach ($price as $key => $value):
                  if(!empty($value)):
                   ?>
                   <label class="btn btn-sizes getPrice" data-price="<?= $value;?>" data-size="<?= $this->admin_m->get_size_info_by_slug($key,$item[0]['shop_id'])['slug'];?>" data-size-title="<?= $this->admin_m->get_size_info_by_slug($key,$item[0]['shop_id'])['title'];?>">
                    <?= $this->admin_m->get_size_by_slug($key,$item[0]['user_id']);?></label>
                   <?php
                 endif; 
               endforeach; 
               ?>
             </div>
           <?php endif;?>
           <!-- price with sizes -->
          </div>
          <div class="item_extra_details">
              <?php if(isset($item[0]['details']) && !empty($item[0]['details'])): ?>
                <p><?= $item[0]['details'] ;?></p>
                <?php else: ?>
                <p><?= $item[0]['overview'] ;?></p>
              <?php endif;?>
              <p class="capital allergen pt-5">
                <?php if(isset($item[0]['allergen_id']) || isJson($item[0]['allergen_id'])): ?>
                  <span><b><?= !empty(lang('allergens'))?lang('allergens'):'allregens' ;?></b>: <?= is_array(json_decode($item[0]['allergen_id']))?allergens(json_decode($item[0]['allergen_id'])):'';?> </span>
                <?php endif;?>
              </p>
              <?php if(isset($extras) && count($extras) > 0): ?>
                <div class="item_extra_list <?= isset($item[0]['is_size']) && $item[0]['is_size']==1?"hidden":"" ;?>">
                  <h5 class="extrasHeading"><?= !empty(lang('extras'))?lang('extras'):'Extras'; ?></h5>
                  <ul class="extraUl">
                      <?php foreach ($extras as $key => $extra): ?>
                        <?php if(!empty($extra)): ?>
                          <li>
                            <label>
                              <p><input type="checkbox" name="extras" class="extras" data-name="<?=  html_escape($extra['ex_name']);?>" data-id="<?= $extra['id'] ;?>" data-item="<?= $extra['item_id'] ;?>" value="<?= $extra['ex_price'] ;?>">  <span class="mr-30"><?=  html_escape($extra['ex_name']);?></span> &nbsp; </p>
                              <span class="left_bold"> <?=  html_escape($extra['ex_price']);?> <?= shop($extra['shop_id'])->icon ;?></span>
                            </label>
                          </li>
                        <?php endif;?>
                      <?php endforeach ?>
                  </ul>
                </div>
              <?php endif;?>
          </div>
      </div><!-- itemModalBody -->
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>
    <?php $is_extra = $this->admin_m->check_extra_by_item_id($item[0]['item_id']); ?>
    <?php if(shop($item[0]['shop_id'])->stock_status == 1): ?>

      <?php if($item[0]['in_stock'] > $item[0]['remaining']): ?>

          <?php if($item[0]['is_size']==1): ?>
            <form action="<?= base_url('admin/pos/add_to_cart_form') ;?>" method="post" class="add_to_cart_form">
              <?= csrf() ;?>
              <input type="hidden" name="item_type" value="item">
              <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
              <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">

              <input type="hidden" name="item_size" class="item_size" value="" required="">
              <input type="hidden" name="size_title" class="size_title" value="" required="">

              <input type="hidden" name="extra_id" class="extra_id" value="">

              <!--check price for extra  -->
              <?php if($is_extra['check'] ==1): ?> 
                <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
                <input type="hidden" name="extra_name" class="extra_name" value="">
              <?php endif; ?>


              <button type="submit" class="btn btn-primary add_to_cart_btn <?=  isset($item[0]['is_size']) && $item[0]['is_size']==1?"hidden":"";?>"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
            </form>
          <?php else:?>

            <form action="<?= base_url('dmin/pos/add_to_cart_form') ;?>" method="post" class="add_to_cart_form">
              <?= csrf() ;?>
                <input type="hidden" name="item_type" value="item">
                <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
                <input type="hidden" name="item_size" class="item_size" value="">
                <input type="hidden" name="extra_id" class="extra_id" value="">
                <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">

                <!--check price for extra  -->
                <?php if($is_extra['check'] ==1): ?> 
                  <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
                  <input type="hidden" name="extra_name" class="extra_name" value="">
                <?php endif; ?>

                <button type="submit" class="btn btn-primary add_to_cart_btn"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
            </form>
            
          <?php endif;?> <!--/ is sizes -->
      
      <?php endif;?>


    <?php else: ?><!-- check stock status -->

      <?php if($item[0]['is_size']==1): ?>
        <form action="<?= base_url('dmin/pos/add_to_cart_form') ;?>" method="post" class="add_to_cart_form">
          <?= csrf() ;?>
          <input type="hidden" name="item_type" value="item">
          <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
          <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">

          <input type="hidden" name="item_size" class="item_size" value="" required="">
          <input type="hidden" name="size_title" class="size_title" value="" required="">

            <!--check price for extra  -->
            <?php if($is_extra['check'] ==1): ?> 
              <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
              <input type="hidden" name="extra_name" class="extra_name" value="">
            <?php endif; ?>

          <input type="hidden" name="extra_id" class="extra_id" value="">

          <button type="submit" class="btn btn-primary add_to_cart_btn <?=  isset($item[0]['is_size']) && $item[0]['is_size']==1?"hidden":"";?>"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
        </form>
       <?php else:?>

         <form action="<?= base_url('dmin/pos/add_to_cart_form') ;?>" method="post" class="add_to_cart_form">
              <?= csrf() ;?>
                <input type="hidden" name="item_type" value="item">
                <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
                <input type="hidden" name="item_size" class="item_size" value="">

                <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">

                <!--check price for extra  -->
                <?php if($is_extra['check'] ==1): ?> 
                  <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
                  <input type="hidden" name="extra_name" class="extra_name" value="">
                <?php endif; ?>
                
                <input type="hidden" name="extra_id" class="extra_id" value="">
                <button type="submit" class="btn btn-primary add_to_cart_btn"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
            </form>
      <?php endif;?>

    <?php endif;?><!-- //check stock status -->

      



  </div>
  
</div>



