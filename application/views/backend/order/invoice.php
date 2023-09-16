
<style>
body{
	background-color: #e9ecef
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    border: 1px solid rgba(0, 0, 0, .05);
    background-color: #fff;
    background-clip: border-box;
    border-radius: 20px;
    padding-top: 10px;
    padding: 30px;
}
.text-danger-m1 {
    color: #dd4949!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

table.customTable.invoiceTable th{
	background-color: #5e72e4!important;
	color: #fff!important;
}
td p{
	text-transform: capitalize;
}
body{
	background-color: #e9ecef
}
.card {
	position: relative;
	display: flex;
	flex-direction: column;
	min-width: 0;
	word-wrap: break-word;
	border: 1px solid rgba(0, 0, 0, .05);
	background-color: #fff;
	background-clip: border-box;
	border-radius: 20px;
	padding-top: 10px;
	padding: 30px;
}
.text-danger-m1 {
	color: #dd4949!important;
}
.text-primary-m1 {
	color: #4087d4!important;
}

table.customTable.invoiceTable th{
	background-color: #5e72e4!important;
	color: #fff!important;
}
td p{
	text-transform: capitalize;
}
.page-tools {
	display: flex;
	align-items: center;
	justify-content: flex-end;
}

.action-buttons a {
	padding: 10px 21px;
	box-shadow: 0 0 5px #ddd;
}

.customerInfo h3 {
	font-size: 18px;
}

.customerInfo h2 {
	text-align: left;
	font-size: 19px;
}
.extars ul {
	list-style: inside;
	color: #777;
}
.extars ul li{
	font-size: 13px;
}
.sizeTag {
	background: rgba(22, 199, 154, .1);
	color: rgba(22, 199, 154, 1);
	border-radius: 4px;
	padding: 5px 6px;
	font-size: 13px;
	font-weight: normal;
}
.b-top{
	border-top: 1px dashed #777;
	padding: 2px;
	margin-top: 2px;
}
tr th{
	text-transform: capitalize;
}
table.customTable {
	font-size: 14px;
}

table.customTable th {
	font-size: 14px;
}

table.customTable tr {
	vertical-align: middle;
}

table.customTable tr td {
	vertical-align: middle;
}
.badge {
	text-transform: capitalize;
	padding: 5px 6px;
	border-radius: 4px;
}
.orderTag{
	font-weight: 600;
	color: tomato;
}
.action-buttons a {
	padding: 10px 21px;
	box-shadow: 0 0 5px #ddd;
}
.bg-white {
	background-color: #fff!important;
}
.text-danger-m1 {
	color: #dd4949!important;
}
.text-primary-m1 {
	color: #4087d4!important;
}
.text-green {
	color: rgba(22, 199, 154, 1);
	font-weight: normal;
	padding: 5px 6px;
	font-size: 13px;
}
.page-content * {
	text-transform: capitalize!important;
}
@media  print
{    
	.no-print, .no-print *
	{
		display: none !important;
	}
	.badge.sizeTag {
		color: rgba(22, 199, 154, 1);
		font-weight: normal;
		padding: 5px 6px;
		font-size: 13px;
		background: transparent;
		border: 0;
	}
}
</style>
<div class="container">
	<div class="page-content">
		<div class="card" id="print_area">
			<div class="row mt-4">
				<div class="col-12 col-lg-12">

					<div class="row">
						<div class="col-12">
							<h4><?= lang('order_id'); ?> #<?= $order['uid'];?> </h4>
							<?php if($order['order_type']==5): ?>
								<span class="badge badge-success"><?= lang('paid'); ?></span>
							<?php endif;?>

							<small class="text-muted"><?= full_date($order['created_at']);?></small><br />
							<small class="text-muted"><?= lang('order_type'); ?>: <?= order_type($order['order_type']) ;?></small>
							<hr />
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="customerInfo">
								<h3><?= !empty(lang('customer_name'))?lang('customer_name'):"Customer Name" ;?> : <?= $order['name'];?></h3>
								<p><?= lang('phone'); ?> : <?= $order['phone'];?></p>
								<p><?= lang('address'); ?> : <?= $order['address'];?></p>
							</div>
						</div>
						<!-- /.col -->

						<div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">

							<div class="customerInfo">
								<h2><?= !empty($shop->name)?$shop->name:$shop->username;?></h2>
								<p>
									<?= lang('phone'); ?> : <?= !empty($shop->phone)?$shop->phone:"";?>
									<br />
									<?= lang('email'); ?> : <?= !empty($shop->email)?$shop->email:"";?>
									<br />
									<?= lang('address'); ?> : <?= !empty($shop->address)?$shop->address:"";?>
									<br />
								</p>
							</div>


						</div>
						<!-- /.col -->
					</div>

					<div class="mt-4">
						<div class="table-responsive">
							<table class="table customTable invoiceTable">
								<thead >
									<tr class="text-600 text-white bgc-default-tp1 py-25">
										<th>#</th>
										<th><?= lang('name'); ?></th>
										<th><?= lang('qty'); ?></th>
										<th><?= !empty(lang('unit_price'))?lang('unit_price'):"Unit Price"; ?></th>
										<th><?= !empty(lang('amount'))?lang('amount'):"Amount"; ?></th>
									</tr>
								</thead>
								<tbody>
									<?php $icon = shop($order['shop_id'])->icon; ?>
									<?php $tax_status = shop($order['shop_id'])->tax_status; ?>
									<?php $qty=0;$sub_total=0;$total_price = 0;$net_total=0; ?>
									<?php foreach ($all_item_list as $key => $row): ?>
										<?php 
										 $qty = $qty+ $row['qty'];
										 $sub_total = $sub_total+ $row['sub_total'];
							             $net_total = $net_total+ $row['sub_total'];
							             $pre_total = $net_total+$order['delivery_charge'];
							             $discount = get_percent($row['discount']);
							             $tax_fee = get_percent($row['tax_fee']);
							             $coupon_percent = get_percent($row['coupon_percent']);
							             $tips =$row['tips'];
							             $grand_total = grand_total($net_total,$row['delivery_charge'],$row['discount'],$row['tax_fee'],$row['coupon_percent'],$row['tips'],$row['order_type'],$tax_status,$row['is_pos']);


										?>
										<tr>
											<td><?= $key+1;?></td>
											<td>
												<p><?= $row['is_package']==1?$row['package_name']:$row['name'];?> 
												<?php if($row['is_size']==1): ?>
													<span class="badge sizeTag"><?= lang('size'); ?> : <?= get_size($row['size_slug'],$row['shop_id']) ?></span>
												<?php endif;?>
												</p>
												<?php if(isset($row['is_extras']) && $row['is_extras']==1): ?>
												<?php $extraId = json_decode($row['extra_id']); ?>
													<div class="extars">
														<ul>
															<?php foreach ($extraId as $key => $ex): ?>
																<li><span>1 x <?= extras($ex,$row['item_id'])->ex_name ;?></span> = <span><?= currency_position(extras($ex,$row['item_id'])->ex_price,$order['shop_id']);?></span></li>
															<?php endforeach ?>
														</ul>
													</div>
												<?php endif;?>

											</td>
											<td><?= $row['qty'];?></td>
											<td><?= currency_position($row['item_price'],$order['shop_id']);?></td>
											<td><?= currency_position($row['item_price']*$row['qty'],$order['shop_id']);?></td>
										</tr>
									<?php endforeach ?>
									<tr >
										<td colspan="3"></td>
										<td>
											<p><?= lang('sub_total'); ?></p>
											<p><?= lang('shipping'); ?></p>

											<?php if($tips !=0): ?>
												<p><?= lang('tips'); ?></p>
											<?php endif;?>

											<?php if($discount !=0): ?>
												<p><?= lang('discount'); ?></p>
											<?php endif;?>

											<?php if($coupon_percent !=0): ?>
												<p><?= lang('coupon_discount'); ?></p>
											<?php endif;?>

											<p><?= lang('tax'); ?></p>
											<p><b><?= lang('total'); ?></b></p>
										</td>
										<td>
											<p><b><?= currency_position($net_total,$order['shop_id']) ;?></b></p>
											<p><?= $order['delivery_charge']==0?0:currency_position($order['delivery_charge'],$order['shop_id']) ;?> </p>
											<p><?= currency_position($tax,$order['shop_id']);?> </p>
											<?php if($tips !=0): ?>
												<p><?= currency_position($tips,$order['shop_id']);?> </p>
											<?php endif;?>

											<?php if($discount !=0): ?>
												<p><?= currency_position($discount,$order['shop_id']);?> </p>
											<?php endif;?>

											<?php if($coupon_percent !=0): ?>
												<p><?= currency_position($coupon_percent,$order['shop_id']);?> </p>
											<?php endif;?>

											<p><b><?= currency_position($grand_total,$order['shop_id']);?></b></p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?= base_url();?>assets/frontend/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/frontend/html2pdf/html2pdf.bundle.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/admin/plugins/printThis.js"></script>

<a href="<?php echo base_url() ?>" id="base_url"></a>
<a href="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_value"></a>

<script>
	var order="<?= $order['uid'];?>";
	$('#printBtn').on('click',function(){

       	var base_url = $('#base_url').attr('href');
        $('#print_area').printThis({
	    importCSS: true,
	    loadCSS: `${base_url}public/frontend/css/print.css`,
	    header: ""
	});
    })

	$('#exportBtn').on("click", function () {
		var element = document.getElementById('print_area');
		var opt = {
                   // margin:       1,
                   filename:     'order_'+order+'.pdf',
                   image:        { type: 'jpeg', quality: 0.98 },
                   html2canvas:  { scale: 2 },
                   jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
               };

               html2pdf().set(opt).from(element).save();
           });
       </script>


       <script type="text/javascript">
       	var base_url = $('#base_url').attr('href');
       	var csrf_value = $('#csrf_value').attr('href');
       	var username = '<?= auth('username');?>';
       	var uid = <?= $order['uid'];?>;
       	$(document).on('click','#pos-print',function(){
       		var url = `${base_url}staff/pos_invoice/${username}/${uid}`;
       		$.post(url, {'csrf_test_name': csrf_value }, function(json){
       			if(json.st == 1){
       				var newWin=window.open('','Print-Window');

					  newWin.document.open();

					  newWin.document.write('<html><body onload="window.print()">'+json.result+'</body></html>');

					  newWin.document.close();
			          // myWindow.close(); 
			      }

			  },'json');

       		return false;

       	});

       </script>
<!-- 
       <script type="text/javascript">
       	var base_url = $('#base_url').attr('href');
       	var csrf_value = $('#csrf_value').attr('href');
       	var username = '<?= auth('username');?>';
       	var uid = <?= $order['uid'];?>;
       	$(document).on('click','#printBtn',function(){
       		var url = `${base_url}staff/print_invoice/${username}/${uid}`;
       		$.post(url, {'csrf_test_name': csrf_value }, function(json){
       			if(json.st == 1){
       				var myWindow=window.open('','','min-width=400px,min-height=500px');
       				myWindow.document.write(json.result);
       				myWindow.document.close();
       				myWindow.focus();
       				myWindow.print(); 
			          // myWindow.close(); 
			      }

			  },'json');

       		return false;

       	});

       </script>
 -->