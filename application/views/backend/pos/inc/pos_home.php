<div class="card-body">
    <div class="card-content">
        <div class="cartItemsArea">
            <?php include 'ajax_cart_item.php'; ?>
        </div>
    </div><!-- card-content -->
</div><!-- card-body -->

<div class="card-footer text-right cartFooter <?= $this->cart->total_items() >0?"":"hidden";?>"> 
    <div class="pull-left">
        <a href="<?= base_url("admin/pos/reset");?>" class="btn danger-light action_btn"> <i class="icofont-refresh"></i> <?= lang('reset');?></a>
    </div>
    <?php if(!empty(auth('is_order_edit')) && auth('is_order_edit')==1): ?>

        <button type="button"  class="btn bg-info-light-active  showOrderModalBtn" data-id='<?= base64_encode(restaurant()->id);?>'><i class="icofont-ui-edit"></i> <?= lang('edit_order_details');?></button>

        <button type="submit"  class="btn btn-success-light" data-id='<?= base64_encode(restaurant()->id);?>' ><i class="icofont-check"></i> <?= lang('confirm_order');?></button>

    <?php else: ?>
        <button type="button"  class="btn btn-success-light showOrderModalBtn" data-id='<?= base64_encode(restaurant()->id);?>'><?= lang('confirm_order');?> <i class="icofont-thin-double-right"></i></button>
    <?php endif; ?>
</div>


<div class="modal fade" id="orderConfirmModal"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="showOrderConfirmModal">
           
        </div>
    </div>
</div>