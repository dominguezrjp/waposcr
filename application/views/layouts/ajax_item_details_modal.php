
<div class="modal-content">

  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= html_escape($item[0]['title']) ;?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body item_modal">
    <div class="single_item <?= is_image($item[0]['shop_id']);?>">
      <?php if(is_image($item[0]['shop_id'])==0): ?>
        <div class="single_items_img">
          <?php if(!empty($item[0]['extra_images'])): ?>
            <div class="itemSlider opacity_height_0">
              <?php foreach (json_decode($item[0]['extra_images'],TRUE) as $key=> $row): ?>
                  <div class="single_item_slider">
                    <div class="item__slider">
                      <img src="<?= base_url($row['image']);?>" alt="item_img">
                    </div>
                  </div>
              <?php endforeach ?>
            </div>
          <?php else: ?>
            <img src="<?= get_img($item[0]['images'],$item[0]['img_url'],$item[0]['img_type']) ;?>" alt="item_img"> 
          <?php endif; ?>
          
        </div>
      <?php endif; ?>
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
                <?php if(shop($item[0]['shop_id'])->currency_position == 1): ?>
                  <p><b> <span class="show_price"><?= html_escape(number_formats($item[0]['price'],shop($item[0]['shop_id'])->number_formats)) ;?></span> <?= shop($item[0]['shop_id'])->icon; ?> </b></p>
                <?php else: ?>
                  <p><b><?= shop($item[0]['shop_id'])->icon; ?> <span class="show_price"><?= html_escape(number_formats($item[0]['price'],shop($item[0]['shop_id'])->number_formats)) ;?></span> </b></p>
                <?php endif;?>
              <?php endif;?>
              <!-- price without sizes -->

              
              <!-- price with sizes -->
              <?php if(isset($item[0]['is_size']) && $item[0]['is_size']==1): ?>

                 <?php if(shop($item[0]['shop_id'])->currency_position == 1): ?>
                    <h5 class="priceTag hidden"><?= lang('price'); ?>: <span class="show_price"> </span> <?= shop($item[0]['shop_id'])->icon ;?></h5>
                  <?php else: ?>  
                      <h5 class="priceTag hidden"><?= lang('price'); ?>: <?= shop($item[0]['shop_id'])->icon ;?> <span class="show_price"> </span> </h5>
                  <?php endif;?>


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
                  
                  <?php if(isJson($item[0]['allergen_id'])): ?>
                    <span><b><?= lang('allergens');?></b>: <?= is_array(json_decode($item[0]['allergen_id']))?allergens(json_decode($item[0]['allergen_id'])):"";?>  </span>
                  <?php endif;?>
                </p>

                <?php if(isset($extras) && sizeof($extras) > 0): ?>
                  <div class="item_extra_list <?= isset($item[0]['is_size']) && $item[0]['is_size']==1?"hidden":"" ;?>">
                    <h5 class="extrasHeading"><?= !empty(lang('extras'))?lang('extras'):'Extras'; ?></h5>
                    <ul class="extraUl">
                        <?php foreach ($extras as $key => $extra): ?>
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
          <?php if(shop($item[0]['shop_id'])->is_cart == 1): ?>
            <div class="form-group col-md-12 p-10 itemComments">
              <label><?= lang('comments');?></label>
              <textarea name="item_comments" id="item_comments" class="form-control" cols="0" rows="2"></textarea>
            </div>
        <?php endif; ?>
      </div><!-- itemModalBody -->
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>

    
        <?php $is_extra = $this->admin_m->check_extra_by_item_id($item[0]['item_id']); ?>
        <?php if(shop($item[0]['shop_id'])->stock_status == 1): ?>

          <?php if($item[0]['in_stock'] > $item[0]['remaining']): ?>

              <?php if($item[0]['is_size']==1): ?>
                <form action="<?= base_url('profile/add_to_cart_form') ;?>" method="post" class="cart_form">
                  <?= csrf() ;?>
                  <input type="hidden" name="item_type" value="item">
                  <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
                  <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">

                  <input type="hidden" name="item_size" class="item_size" value="" required="">
                  <input type="hidden" name="size_title" class="size_title" value="" required="">

                  <input type="hidden" name="extra_id" class="extra_id" value="">

                  <input type="hidden" name="item_comments" class="item_comments" value="">

                  <!--check price for extra  -->
                  <?php if($is_extra['check'] ==1): ?> 
                    <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
                    <input type="hidden" name="extra_name" class="extra_name" value="">
                  <?php endif; ?>

                  <?php if(shop($item[0]['shop_id'])->is_cart == 1): ?>
                    <button type="submit" class="btn btn-primary add_to_cart_form <?=  isset($item[0]['is_size']) && $item[0]['is_size']==1?"hidden":"";?>"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
                  <?php endif ?>
                </form>
              <?php else:?>

                <form action="<?= base_url('profile/add_to_cart_item_form') ;?>" method="post" class="add_to_cart_form">
                  <?= csrf() ;?>
                    <input type="hidden" name="item_type" value="item">
                    <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
                    <input type="hidden" name="item_size" class="item_size" value="">
                    <input type="hidden" name="extra_id" class="extra_id" value="">
                    <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">
                    <input type="hidden" name="item_comments" class="item_comments" value="">
                    <!--check price for extra  -->
                    <?php if($is_extra['check'] ==1): ?> 
                      <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
                      <input type="hidden" name="extra_name" class="extra_name" value="">
                    <?php endif; ?>

                    <?php if(shop($item[0]['shop_id'])->is_cart == 1): ?>
                      <button type="submit" class="btn btn-primary add_to_cart_btn"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
                    <?php endif; ?>
                </form>
                
              <?php endif;?> <!--/ is sizes -->
          
          <?php endif;?>


        <?php else: ?><!-- check stock status -->

          <?php if($item[0]['is_size']==1): ?>
            <form action="<?= base_url('profile/add_to_cart_form') ;?>" method="post" class="cart_form">
              <?= csrf() ;?>
              <input type="hidden" name="item_type" value="item">
              <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
              <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">

              <input type="hidden" name="item_size" class="item_size" value="" required="">
              <input type="hidden" name="size_title" class="size_title" value="" required="">
              <input type="hidden" name="item_comments" class="item_comments" value="">
                <!--check price for extra  -->
                <?php if($is_extra['check'] ==1): ?> 
                  <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
                  <input type="hidden" name="extra_name" class="extra_name" value="">
                <?php endif; ?>

              <input type="hidden" name="extra_id" class="extra_id" value="">
              <?php if(shop($item[0]['shop_id'])->is_cart == 1): ?>
                <button type="submit" class="btn btn-primary add_to_cart_form <?=  isset($item[0]['is_size']) && $item[0]['is_size']==1?"hidden":"";?>"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
              <?php endif; ?>
            </form>
           <?php else:?>

             <form action="<?= base_url('profile/add_to_cart_item_form') ;?>" method="post" class="add_to_cart_form">
                  <?= csrf() ;?>
                    <input type="hidden" name="item_type" value="item">
                    <input type="hidden" name="item_id" value="<?=  html_escape($item[0]['item_id']);?>">
                    <input type="hidden" name="item_size" class="item_size" value="">

                    <input type="hidden" name="item_price" class="item_price" value="<?=  html_escape($item[0]['price']);?>">
                    <input type="hidden" name="item_comments" class="item_comments" value="">
                    <!--check price for extra  -->
                    <?php if($is_extra['check'] ==1): ?> 
                      <input type="hidden" name="extra_price" class="extra_price" value="<?=  html_escape($item[0]['price']);?>">
                      <input type="hidden" name="extra_name" class="extra_name" value="">
                    <?php endif; ?>
                    
                    <input type="hidden" name="extra_id" class="extra_id" value="">
                    
                    <?php if(shop($item[0]['shop_id'])->is_cart == 1): ?>
                      <button type="submit" class="btn btn-primary add_to_cart_btn"> <i class="icofont-ui-cart"></i> <?= !empty(lang('add_to_cart'))?lang('add_to_cart'):'Add Cart' ;?></button>
                    <?php endif; ?>
                </form>
          <?php endif;?>

        <?php endif;?><!-- //check stock status -->




  </div>
  
</div>



