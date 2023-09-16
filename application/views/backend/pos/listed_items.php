<?php 
	$total_qty=0; $total_sub_price=0;$grand_total=0;
 ?>
<?php //echo "<pre>";print_r($this->cart->contents());exit();?>
<?php $i=1; foreach ($this->cart->contents() as $key => $row): ?>
	<tr class="single_cart_item_details">
		<td><?= $i;?> </td>
		<td><p class="fw_bold"><?= $row['uid'];?></p></td>
		<td><?= html_escape($row['name']) ;?> <b><?= $row['category_name'];?></b></td>
		<td ><span class="item_price"><?= isset($row['options']['is_update']) && $row['options']['is_update']==1? number_format($row['old_price'],0): number_format($row['price'],0);?></span></td>
		<td>
			<div class="incress_area">
				<span class="value-button minus" data-price="<?= isset($row['options']['is_update']) && $row['options']['is_update']==1?$row['old_price']:$row['price'];?>" data-id="<?= $row['rowid'] ;?>" value="Decrease Value"><i class="icofont-minus"></i></span>

				<span class="cart_qty_field"><input readonly type="number" id="qty_<?= $row['rowid'];?>" class="qty" value="<?= $row['qty'];?>" min-value='1' /></span>

				<span class="value-button add" data-price="<?= isset($row['options']['is_update']) && $row['options']['is_update']==1?$row['old_price']:$row['price'];?>" data-id="<?= $row['rowid'] ;?>"  value="Increase Value"><i class="icofont-plus"></i></span>
			</div>  
		</td>
		<td class="sold_price_<?= $row['rowid'] ;?>">

				<div class="input-group mb-3 priceGroup">
					<input type="number" name="sold_price" class="soldPrice" value="<?= $row['price'];?>" style="width: 80px;">
					<div class="input-group-prepend">
						<button type="button" class="cartUpdate" data-price="<?= isset($row['options']['is_update']) && $row['options']['is_update']==1?$row['old_price']:$row['price'];?>" data-id="<?= $row['rowid'];?>" data-qty="<?= $row['qty'];?>"><span class="input-group-text"><i class="fa fa-check"></i></span></button>
					</div>
				</div>

			<div class="percentPriceTags">
				<span>5% = &#2547;<?= $row['price'] - get_percent($row['price'],5);?></span> &nbsp;
				<span>10% = &#2547;<?= $row['price'] - get_percent($row['price'],10);?></span> &nbsp;
				<span>15% = &#2547;<?= $row['price'] - get_percent($row['price'],15);?></span>
			</div>
			
		</td>

		<td >  <span class="total_qty_price"><?=$this->cart->format_number($row['subtotal'],0) ;?></span></td>
		<td><a href="javascript:;" data-id="<?= $row['rowid'] ;?>" class="remove_item"><i class="icofont-close-line-circled fa-2x text-danger"></i></a></td>
	</tr>

<?php 
	$total_qty += $row['qty'];
	$total_sub_price += $row['subtotal'];
	$grand_total = $total_sub_price;
 ?>
<?php $i++; endforeach; ?>
<tr>
	<td colspan="4">
	</td>
	<td colspan="6" class="text-right">
		<ul class="grandTotal">
			<li><span>Qty:</span>  <b><?= $total_qty;?></b></li>
			<li><span>Total: </span> <b>&#2547; <?= number_format($total_sub_price,0);?> /=</b></li>
			<li><b>Grand Total</b> <b>&#2547; <?= number_format($grand_total,0);?> /=</b> </li>
		</ul>
	</td>
</tr>

