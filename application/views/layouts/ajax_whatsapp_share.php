<?php 
	$order_list = $this->common_m->get_order_item($last_id,$shop_info['shop_id']);
	$data = '';
	$i=1; 
	$data .= lang('order_type')."\t : ".order_type($order_type)."\n";
	foreach ($order_list as $key => $row): 
		if($row['is_package']==1):
			$data .= $i.". {$row['package_name']} \t {$row['qty']} x ".wh_currency_position($row['item_price'],$shop_info['shop_id'])."\n";
			$data .= "---------------------------------------\n";
		
		else: 
 
			$data .= $i.". {$row['name']} \t {$row['qty']} x ".wh_currency_position($row['item_price'],$shop_info['shop_id'])."\n";
			$data .= "----------------------------------------\n";
			
		endif;

		
		$i++; 
	endforeach;
	$data.= lang('sub_total')."\t : ".wh_currency_position($sub_total,$shop_info['shop_id'])."\n";
	$data.= lang('tax')."\t : ".wh_currency_position($tax_fee,$shop_info['shop_id'])."\n";

	if($tips !=0):
		$data.= lang('tips')."\t : ".wh_currency_position($tips,$shop_info['shop_id'])."\n";
	endif;

	if($order_type !=4):
	$data.= lang('shipping')."\t : ".wh_currency_position($delivery_charge,$shop_info['shop_id'])."\n";
	endif;
	if($discount !=0):
		$data.= lang('discount')."\t : ".wh_currency_position($discount,$shop_info['shop_id'])."\n";
	endif;
	if($coupon_percent !=0):
		$data.= lang('coupon_discount')."\t : ".wh_currency_position($coupon_percent,$shop_info['shop_id'])."\n";
	endif;

	$data.= "\n- - - - - - - - - - - - - - - - - - - -\n";
	$data.= "".lang('total')." : \t " . "" .wh_currency_position($net_price,$shop_info['shop_id']). " ";
	$data.= "\n- - - - - - - - - - - - - - - - - - - -\n\n";
	
	if(isset($pickup_time) || isset($pickup_point)):
		$data .= "---------------------------------------\n";
		$data .= "\t".lang('order_details')."\n";

		if(isset($pickup_time) && !empty($pickup_time)):
			$data .= "---------------------------------------\n";
			if(isset($pickup_date)):
				$data.= lang('pickup_date')."\t : ".cl_format($pickup_date)."\n";
			endif;
			$data.= lang('pickup_time')."\t : ".$pickup_time."\n";
		endif;

		if(isset($pickup_point) && !empty($pickup_point)):
			$data.= lang('pickup_point')."\t : ".$pickup_point."\n\n";
			$data .= "---------------------------------------\n";
		endif;
	endif;

	$data .= "---------------------------------------\n";
	$data .= "\t".lang('customer_details')."\n";
	$data .= "---------------------------------------\n";

	$data.= lang('phone')."\t : ".$phone."\n";

	if(isset($delivery_area) && !empty($delivery_area)):

	
		$coordinates = getCoordinatesAttribute($delivery_area,$shop_info['shop_id']);
		$lat = isset($coordinates['latitude'])?$coordinates['latitude']:'';
		$lng = isset($coordinates['longitude'])?$coordinates['longitude']:'';
		$data.= lang('gmap_link')."\t : https://maps.google.com?q=".$lat.",".$lng."\n";
	endif;

	if(!empty($address)):
		$data.= lang('delivery_address')."\t : ".$address."\n";
		$data.= "---------------------------------------\n\n";
	endif;

	$track_url = base_url('my-orders/'.$shop_info['username'].'?phone='.$phone.'&orderId='.$order_id);


	$replace_data = array(
		'{CUSTOMER_NAME}' => $name,
		'{ORDER_ID}' => $order_id,
		'{ITEM_LIST}' => $data,
		'{SHOP_NAME}' => $shop_info['shop_name'],
		'{SHOP_ADDRESS}' => $shop_info['address'],
		'{TRACK_URL}' => $track_url,
	);

	$accept_message = json_decode($shop_info['whatsapp_msg']);
	$msg = create_msg($replace_data,$accept_message);

	?>

<div class="whatsapp_share">
	<a href='javascript:;' data-url='https://api.whatsapp.com/send?phone=<?= $shop_info['dial_code'].$shop_info['whatsapp_number'] ;?>&text=<?= urlencode($msg) ;?>' style="text-decoration:none" data-action="share/whatsapp/share" class="redirect_whatsapp">
		<div>
			<i class="fa fa-whatsapp"></i>&nbsp;&nbsp;<?= lang('order_on_whatsapp'); ?>
		</div>
	</a>
</div>