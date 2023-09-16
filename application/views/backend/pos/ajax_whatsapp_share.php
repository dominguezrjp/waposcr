<?php 
	$order_list = $this->common_m->get_order_item($last_id,$shop_info['shop_id']);
	$sum = 0;
	$data = '';
	$data .= 'Order From  '.urlencode($name).' %0A ';
	$data .= 'Order %20 ID: %20 '.$order_id.' %0A ------------------------%0A%0A';
	$i=1; foreach ($order_list as $key => $row): 
	
	
	if($row['is_package']==1):
		$data.= $i."%20 Product Name:%20".html_escape(urlencode($row['package_name']))."%20 Qty:%20".html_escape($row['qty'])." %20".lang('price').":%20".number_format($row['item_price'],2)."%20".shop($shop_info['shop_id'])->icon.", %0A %0A";
	else:
		$data.= $i."%20 Product Name:%20".html_escape(urlencode($row['name']))."%20 Qty:%20".html_escape($row['qty'])." %20".lang('price').":%20".number_format($row['item_price'],2)."%20".shop($shop_info['shop_id'])->icon.", %0A %0A";
	endif;
	$i++; endforeach;

	$data.= '%0A------------%0A';
	$data.= lang('shipping').' %20: %20'.$delivery_charge.'%0A';
	$data.= '%0A------------%0A';

	$data.= lang('total').': %20'.$net_price.' '.shop($shop_info['shop_id'])->icon.'%0A';
	$data.= '%0A --------------------------%0A';
	$data.= lang('delivery_address').' %20: %20'.urlencode($address).'%0A';
	$data.= '%0A --------------------------%0A';
	$data.= lang('shop_name').': %20'.urlencode($shop_info['shop_name']).'%0A';
	$data.='-------------------------------%0A';
	$data.= lang('shop_address').': %0A';
	$data.= isset($shop_info['address']) && !empty($shop_info['address'])?urlencode($shop_info['address']):''.'%0A';
	$data.='-------------------------------%0A';
	$data.= lang('track_order').'%0A';
	$data.= urlencode(base_url('my-orders/'.$shop_info['username'].'?phone='.$phone.'&orderId='.$order_id)).'%0A';
	$data.= '%0A --------------------------%0A';
	$data.= urlencode($shop_info['whatsapp_msg']);

	?>

<div class="whatsapp_share">
	<?php $social = json_decode($shop_info['social_list'],true); ?>
	<a href='https://api.whatsapp.com/send?phone=<?= $shop_info['dial_code'].$phone ;?>&text=<?= $data ;?>'  style="text-decoration:none" data-action="share/whatsapp/share" class="redirect_whatsapp" target="_blank">
		<div>
			<i class="fa fa-whatsapp"></i>&nbsp;&nbsp;<?= lang('order_on_whatsapp'); ?>
		</div>
	</a>
</div>