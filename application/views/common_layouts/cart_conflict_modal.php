
    <div class="modal-content">
      <!-- Modal body -->
      <div class="modal-body">
       <div class="conflictArea">
         <h4><?= lang('start_new_cart');?></h4>
         <p><?= lang('your_cart_alreay_contains_items_from');?> <b><?= $shop_name??'';?></b></p>
         <p><?= lang('would_you_like_to_clear_the_cart');?></p>
       </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer space-between">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close');?></button>
        <a type="button" class="btn btn-default f-color" href="<?= base_url("profile/clear_cart");?>"><?= lang('new_cart');?></a>
      </div>

    </div>
  
