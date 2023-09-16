<html>
    <head>
        <style>
        	.pos_page{
			  position: absolute;
			  top: 0;
			  right: 0;
			  width: 100%;
			  min-height: 100vh;
			}

			#invoice-POS h1, 
			#invoice-POS h2,  
			#invoice-POS h3, 
			#invoice-POS h4, 
			#invoice-POS h5, 
			#invoice-POS h6{
			  color: #05070b;
			  font-weight: bolder;
			}
			#pos .pos-detail{
			  height: 42vh!important;
			}
			#pos .pos-detail .table-responsive{
			  max-height: 40vh!important;
			  height: 40vh!important;
			  border-bottom: none!important;
			}

			#pos .pos-detail .table-responsive tr{
			  font-size: 14px
			}

			#pos .card-order{
			  min-height: 100%;
			}

			#pos .card-order .main-header{
			  position: relative;
			}

			#pos .grandtotal{
			  text-align: center;
			  height: 40px;
			  background-color: #7ec8ca;
			  margin-bottom: 20px;
			  font-size: 1.2rem;
			  font-weight: 800;
			  padding: 5px;
			}
			#pos .list-grid .list-item .list-thumb img {
			  width: 100%!important;
			  height: 100px!important;
			  max-height: 100px!important;
			  object-fit: cover;
			}

			#pos .list-grid{
			  height: 100%;
			  min-height: 100%;
			  overflow: scroll;
			}

			#pos .brand-Active{
			border: 2px solid;
			}

			.centred{
			text-align: center;
			align-content: center;
			}

			.extars ul li span{
				font-size: 12px;
			}
			.extars ul{
				margin-left: 0;
				padding-left: 0;
			}

			@media (min-width: 1024px){
			  #pos .list-grid{
			    height: 100vh;
			    min-height: 100vh;
			    overflow: scroll;
			  };

			}

			#pos .card.o-hidden {
			  width: 19%;;
			  max-width: 19%;;
			  min-width: 130px;
			}
			#pos .input-customer{
			  position: relative;
			  display: flex;
			  flex-wrap: unset;
			  align-items: stretch;
			  width: 100%;
			}

			#pos .card.o-hidden:hover {
			  cursor: pointer;
			  border: 1px solid;
			}

			* {
			  font-size: 14px;
			  line-height: 20px;
			  font-family: 'Ubuntu', sans-serif;
			  text-transform: capitalize;

			}

			td,
			th,
			tr,
			table {
			    border-collapse: collapse;
			}
			tr {border-bottom: 2px dotted #ddd;}

			table {width: 100%;}
			tfoot tr th:first-child {text-align: left;}

			/* .table-bordered th, .table-bordered td {
			  border: 1px solid #D1D5DB;
			} */
			.total{
			  font-weight: bold;
			  font-size: 12px;
			  /* text-transform: uppercase; */
			  /* height: 36px; */
			}


			.change{
			  font-size: 10px;
			  margin-top: 25px;
			}
			.centered {
			    text-align: center;
			    align-content: center;
			}

			#invoice-POS{
			  max-width:79mm;
			  margin:0px auto;
			}

			@media print { 

			  .change{
			    font-size: 10px!important;
			  }

			  * {
			    font-size: 12px;
			    line-height: 18px;   
			  }

			  body{
			    margin: 0.5cm;
			    margin-bottom:1.6cm;
			  }

			  td,th {padding: 1px 0;}

			  /* .table_data tr{
			    border-bottom: 2px dotted #05070b;
			  } */

			  #invoice-POS table tr{
			    border-bottom: 2px dotted #05070b;
			  }
			 

			  @page {
			    margin: 0;
			    }
			   
			  tbody::after {
			    content: '';
			    display: block;
			    page-break-after: always;
			    page-break-inside: always;
			    page-break-before: avoid; 

			  }
			}
			  

			#top .logo{
			    height: 100px;
			    width: 100px;
			    background-size: 100px 100px;
			}

			.info{
			  margin-bottom: 20px;
			}

			.info>h2{
			  text-align: center;
			  font-size: 1.5rem;

			}
			.title{
			  float: right;
			}
			.title p{text-align: right;} 
			table{
			  width: 100%;
			  border-collapse: collapse;
			}
			#invoice-POS table tr{
			  border-bottom: 2px dotted #05070b;
			}

			.tabletitle{
			  font-size: .5em;
			  background: #EEE;
			}
			#legalcopy{
			  margin-top: 5mm;
			}
			#legalcopy p{
			text-align: center;
			}
			#bar{
			  text-align: center;
			}

			.quantity {
			  max-width: 95px;
			  width: 95px;
			}  

			.quantity input {
			  text-align: center;
			      border: none;
			}

			.quantity .form-control:focus {
			    color: #374151;
			    background-color:unset;
			    border-color: #e1d5fd;
			    outline: 0;
			    box-shadow: unset;
			}

			.quantity span {
			  padding: 8px;
			}
			tr.spacer {
			    padding: 10px!important;
			    border-collapse: separate!important;
			    border-spacing: 0 1em!important;
			    border: 6px solid #fff;
			    border-top: 2px dotted;
			}
			.sizeTag {
			    background-color: rgba(106,116,123,.15);
			    padding: 3px 7px;
			    font-size: 11px;
			    border-radius: 4px;
			    color: #000;
			    margin-left: 4px;
			}
			.pos-container *{
				font-size: <?= !empty(pos_config($shop->id)->font_size)? pos_config($shop->id)->font_size:"14";?>px!important;
			}

        </style>
    </head>
    <body style="min-height: 50vh;background: #fff;">
        <div style="width: <?= !empty(pos_config($shop->id)->print_size)? pos_config($shop->id)->print_size:"70";?>mm; margin: 0px auto;" class="pos-container">
            <div class="info">

       
                <h2 class="text-center"><?= !empty($shop->name)?$shop->name:$shop->username;?></h2>
                <p>
                	<?= lang('order_id');?>: <b>#<?= $order_info['uid'];?></b> <br>
                	<?= lang('order_type');?>: <b> <?= order_type($order_info['order_type'],$order_info['table_no']);?></b> <br>
                    <?= lang('date'); ?> : <?= full_time($order_info['created_at']);?>
                    <br />
                    <?php if($order_info['is_guest_login']==1): ?>
                    	<?= lang('walk_in_customer');?>
                    <?php else: ?>


                    <?php if(!empty($shop->address)): ?>
	                    <?= lang('address'); ?> : <?= !empty($shop->address)?$shop->address:"";?>
	                    <br />
	                <?php endif;?>
	                
                    <?= lang('email'); ?> : <?= !empty($shop->email)?$shop->email:"";?>
                    <br />
                    <?= lang('phone'); ?> : <?= !empty($shop->phone)?$shop->phone:"";?>
                    <p style="padding: 0;margin: 0;">---------------------------</p>
	                    <?php if($order_info['order_type']==7 && $order_info['table_no'] !=0): ?>
	                    	<?= lang('customer_details');?> : <?= lang('package_restaurant_dine_in');?> <br>
	                    <?php else: ?>
	                    	<?= lang('customer_details');?> : <?= $order_info['name'];?> <br>
	                    	<?php if(!empty($order_info['phone'])): ?>
	                    		<?= lang('phone'); ?> : <?= !empty($order_info['phone'])?$order_info['phone']:"";?><br>
	                    	<?php endif;?>

	                    	<?php if(!empty($order_info['address'])): ?>
	                    		<?= lang('address'); ?> : <?= !empty($order_info['address'])?$order_info['address']:"";?><br>
	                    	<?php endif;?>
	                    	<?php if($order_info['order_type']==1): ?>
	                    		<?php $shpping_info = $this->common_m->delivery_area_by_shop_id($order_info['shipping_id'],$shop_id); ?>
		                    		<?php if(isset($shpping_info['area']) && !empty($shpping_info['area'])): ?>
		                    		<?= lang('delivery_area');?> : <?= $shpping_info['area'];?></p>
		                    	<?php endif;?>
		                    	<?php if(!empty($order_info['delivery_area'])): ?>
	                    			<?= lang('shipping_address'); ?> : <?= $order_info['delivery_area'];?>
	                    		<?php endif;?>
	                    	<?php endif;?>
	                    <?php endif; ?>


                <?php endif ?>
                </p>
            </div>
           
            <table class="table_data">
                <tbody>

                <?php if($order_info['order_type']==7 && $order_info['table_no'] ==0): ?>
                		<?php $get_dinein_items = $this->admin_m->get_dinin_items($order_info['dine_id']); ?>
                		<?php foreach ($get_dinein_items as $key => $package): ?>
                			<tr style="margin-bottom: 5px;">
                				<td colspan="3">
                					<span><?= $package['package_name']; ?></span>
                					<div class="extars">
                						<ul>
                							<?php foreach ($package['all_items'] as $key => $item): ?>
                								<li class="space-between"><span>1 x <?= $item['title'] ;?>   </span> <span><?= currency_position($item['item_price'],restaurant($id)->id);?></span></li>
                							<?php endforeach; ?>
                						</ul>
                					</div>
                				</td>
                			</tr>
                			<?php $grand_total = $order_info['total']; ?>
                		<?php endforeach; ?>
                <?php else: ?>


                	<?php $qty=0;$sub_total=0;$total_price = 0;$net_total=0; ?>
                	<?php foreach ($item_list as $key => $row): ?>
	                    <tr style="margin-bottom: 5px;">
	                        <td colspan="3">
	                            <span>
	                            	<?php if($row['is_package']==1): ?>
	                            		<?= $row['package_name'];?>
	                            	<?php else: ?>
	                                <?= $row['name'];?>
		                                <?php if($row['is_size']==1): ?>
		                                	<span class="badge sizeTag"> <?= lang('size'); ?> : <?= get_size($row['size_slug'],$row['shop_id']) ?></span>
		                                <?php endif;?>
		                            <?php endif;?>
	                                <br />
	                                <?= $row['qty'];?> x <?= currency_position($row['item_price'],restaurant($id)->id);?>
	                            </span>
	                            <?php if(isset($row['is_extras']) && $row['is_extras']==1): ?>
	                            	<?php $extraId = json_decode($row['extra_id']); ?>
	                            	<div class="extars">
	                            		<ul>
	                            			<?php foreach ($extraId as $key => $ex): ?>
	                            				<li><span>1 x <?= extras($ex,$row['item_id'])->ex_name ;?></span> = <span><?= currency_position(extras($ex,$row['item_id'])->ex_price,$shop_id) ;?> </span></li>
	                            			<?php endforeach ?>
	                            		</ul>
	                            	</div>
	                            <?php endif;?>
	                        </td>
	                        <td style="text-align: right; vertical-align: bottom;"><?= currency_position(html_escape($row['sub_total']),restaurant($id)->id) ;?></td>
	                   
	                    </tr>
	                    <tr class="spacer"><td></td><td></td></tr>
	                    <?php 
	                    $qty = $qty+ $row['qty'];
	                    $sub_total = $sub_total+ $row['sub_total'];
	                    $net_total = $net_total+ $row['sub_total'];
	                    $pre_total = $net_total+$order_info['delivery_charge'];
	                    $discount = get_percent($net_total,$order_info['discount'],$order_info['is_pos'])??0;
	                    $tax_fee = get_percent($net_total,$order_info['tax_fee'])??0;
	                    $coupon_percent = get_percent($net_total,$order_info['coupon_percent'])??0;
	                    $tips = $order_info['tips']??0;

	                    $grand_total = grand_total($net_total,$order_info['delivery_charge'],$order_info['discount'],$order_info['tax_fee'],$order_info['coupon_percent'],$order_info['tips'],$order_info['order_type'],shop($order_info['shop_id'])->tax_status,$order_info['is_pos']);

	                    
	                    ?>
                	<?php endforeach; ?>
                    <tr class="spacer"><td></td><td></td></tr>
                    <tr style="margin-top: 10px;">
                        <td colspan="3" class=""><?= lang('sub_total'); ?></td>
                        <td class="total" style="text-align: right;"><?= currency_position($sub_total,restaurant($id)->id) ;?></td>
                    </tr>
                    <?php if($order_info['delivery_charge']!=0):?>
	                    <tr style="margin-top: 10px;">
	                        <td colspan="3" class=""><?= lang('shipping'); ?></td>
	                        <td class="total" style="text-align: right;"><?= currency_position($order_info['delivery_charge'],restaurant($id)->id);?> </td>
	                    </tr>
	                <?php endif;?>
                    <?php if(restaurant($id)->is_tax==1 && $tax_fee!=0): ?>
                    <tr style="margin-top: 10px;">
                        <td colspan="3" class=""><?= lang('tax'); ?></td>
                        <td class="total" style="text-align: right;"><?= currency_position($tax_fee,restaurant($id)->id);?> </td>
                    </tr>
                    <?php endif; ?>	
                    <?php if($tips !=0): ?>
	                     <tr style="margin-top: 10px;">
	                        <td colspan="3" class=""><?= lang('tips'); ?></td>
	                        <td class="total" style="text-align: right;"><?= currency_position($tips,restaurant($id)->id);?> </td>
	                    </tr>
	                <?php endif;?> 


	                 <?php if($discount!='0'): ?>
	                     <tr style="margin-top: 10px;">
	                        <td colspan="3" class=""><?= lang('discount'); ?></td>
	                        <td class="total" style="text-align: right;"><?= currency_position($discount,restaurant($id)->id);?> </td>
	                    </tr>
	                <?php endif;?> 

	                <?php if($coupon_percent !=0): ?>
	                     <tr style="margin-top: 10px;">
	                        <td colspan="3" class=""><?= lang('coupon_discount'); ?></td>
	                        <td class="total" style="text-align: right;"><?= currency_position($coupon_percent,restaurant($id)->id);?> </td>
	                    </tr>
	                <?php endif;?>

                    <tr style="margin-top: 10px; border-color: #05070b;">
                        <td colspan="3" class="total"><?= lang('grand_total'); ?></td>
                        <td class="total" style="text-align: right;"><?= currency_position($grand_total,restaurant($id)->id) ;?> </td>
                    </tr>
                <?php endif; ?>
                    <tr>
                    	<td colspan="1" style="text-align: left;">
                    		<p style="margin: 0;"><?= lang('payment_by'); ?></p>
                    		<?php if($order_info['order_type']==5 || $order_info['is_payment']==1): ?>
                    			<?=  ucfirst($order_info['payment_by']);?>
                    		<?php else: ?>
                    			<?= lang('cash'); ?>
                    		<?php endif;?>
                    	</td>
                    	<td colspan="2" style="text-align: left;">
                    		<p style="margin: 0;"><?= lang('amount'); ?></p>
                    		<?= currency_position($grand_total,restaurant($id)->id);?>
                    	</td>
                    	<td colspan="1" style="text-align: right;">
                    		<p style="margin: 0;"><?= lang('status'); ?></p>
                    		<?php if($order_info['is_payment']==1): ?>
                    			<?= lang('paid'); ?>
                    		<?php else: ?>
                    			<?= lang('unpaid')?>
                    		<?php endif ?>

                    	</td>
                    </tr>


                    <?php if(isset($order_info['staff_id']) && !empty($order_info['staff_id'])): ?>
	                    <tr>
	                    	<td colspan="2"><?= lang('staff');?></td>
	                    </tr>
	                <?php endif; ?>
            
                </tbody>
            </table>

            
            <?php if(!empty(pos_config($shop->id)->welcome_message)): ?>
	            <div id="legalcopy" class="ml-2">
	                <p class="legal"><strong><?= pos_config($shop->id)->welcome_message;?></strong></p>
	            </div>
        	<?php endif; ?>
        </div>
        <script>
        	window.print();
        </script>
    </body>
</html>
