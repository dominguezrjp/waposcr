 <div class="modal-header">
 	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
 	<h4 class="modal-title">Confirm Order</h4>
 </div>
 <div class="modal-body">
 	<div class="orderType">
        <?php $jsonTypes = !empty($orderJson->order_types)?json_decode($orderJson->order_types,true):''; ?>
        <?php $orderType = array_keys($jsonTypes) ?>
 		<select name="order_type" id="order_type" class="form-control order_type" data-id="<?= $shopId;?>" onfocus="this.removeAttribute('readonly');">
            <option value=""><?= lang('select');?></option>
 			<?php foreach ($order_types as $key => $order_type): ?>
 				<?php if(in_array($order_type['slug'],$orderType)): ?>
                    <option value="<?= $order_type['type_id'];?>" data-slug="<?= $order_type['slug'];?>"><?= $order_type['type_name'];?></option>
                <?php endif; ?>
 			<?php endforeach; ?>
 		</select>
 	</div>
 	<div class="showOrderdetails">
 		<!-- order type details -->
 	</div>

 	<div class="orderDetailsModal custom-fields">
 		<!-- show order details modal -->
 	</div>
 </div>
 <div class="modal-footer dis_none payModalBtn">
 	<button type="submit" class="btn btn-primary"><?= lang('process_to_complete');?></button>
 </div>