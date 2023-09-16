<style>
	.subscribeInvoice img{
		width: auto;
		max-height: 120px!important;
	}
	.subscribeInvoice p, .subscribeInvoice h4{
		padding: 0;
		margin: 0;
	}
	.subscribeInvoice{
		padding-top: 10px;
	}
	.invoiceHeader {
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin: 15px 19px;
	}

	.invoiceHeader.headerTop {
		border-bottom: 1px solid #eee;
		padding-bottom: 18px;
	}
	.invoiceImg{

		min-width: 187px;
		text-align: center;
	}
	td.invoiceTotal p b:first-child, td.invoiceTotal p span:first-child {
		min-width: 96px;
		display: inline-block;
	} 
	a.invoiceBtn {
		padding: 0;
		margin: 0;
		border: 0;
		color: tomato;
		margin-top: 7px;
		text-decoration: underline!important;
	}
	.subscriptionInvoiceArea{
		min-height: 100vh;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.subscriptionInvoiceArea{
		background: #eee;
	}
	.bg_white{
		background: #fff;
	}
	.exportBtn{
		margin-bottom: 20px;
	}
	pre{
		font-family: "-apple-system"," BlinkMacSystemFont", 
	    "Segoe UI", "Roboto", "Oxygen", 
	    "Ubuntu", "Cantarell", "Fira Sans", 
	    "Droid Sans", "Helvetica Neue", sans-serif;
    	font-size: 16px;
    	background: #fff;
    	border:0;
    	padding: 0;
    	margin: 0;
	}
	.table thead th {
	    vertical-align: bottom;
	    border-bottom: 0;
	    background: #eee;
	}
	p{
		padding: 0;
		margin: 0;
	}
	.invoiceCompany h4 {
		font-size: 1.2rem;
	}

</style>
<?php 
	$tax_percent = isset($tax->tax_percent) && !empty($tax->tax_percent)?$tax->tax_percent:0;
	$tax_fee = get_percent($invoice_info->price,$tax_percent);
	
	if(isset($invoice_info->is_payment) && $invoice_info->is_payment==1){
		$price = $invoice_info->price;
		$total_price = $invoice_info->price+$tax_fee;
	}else{
		$price = $invoice_info->package_price;
		$total_price = $invoice_info->price;
	}
	
	$id = $invoice_info->package_slug.'_'.random_string('numeric',4);
 ?>

<div class="invoiceHeader headerTop">
	<div class="invoiceCompany invoiceLeft">
		<p><?= lang('order_no');?> : <?= $id;?></p>
		<p><?= lang('date');?> : <?= full_time(d_time());?></p>
	</div>
	<div class="invoiceCompany invoiceRight">
		<div class="invoiceImg">
			<img src="<?= base_url($st->logo);?>" alt="">
		</div>
	</div>
</div>

<div class="invoiceHeader mt-20">
	<div class="invoiceCompany invoiceLeft">
		<?php if(isset($tax->company_details) && !empty($tax->company_details)): ?>
		<h4><?= $st->site_name;?></h4>
		<pre><?= $tax->company_details;?></pre>
	<?php else: ?>
		<h4><?= $st->site_name;?></h4>
	<?php endif; ?>

	<p><?= $admin->email;?></p>
	<?php if(isset($tax->tax_number) && !empty($tax->tax_number)): ?>
	<p><?= lang('tax_number');?> : <?= $tax->tax_number;?></p>
<?php endif; ?>
</div>
<div class="invoiceCompany invoiceRight">
	<h4><?= $u->username;?></h4>
	<p><?= $u->email;?></p>
	<p><?= $u->address;?></p>
</div>
</div>
<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<th>#</th>
				<th><?= lang('package_name');?></th>
				<th><?= lang('qty');?></th>
				<th><?= lang('price');?></th>
				<th><?= lang('total');?></th>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td><?= $invoice_info->package_name;?></td>
					<td>1</td>
					<td><?= admin_currency_position($price);?></td>
					<td><?= admin_currency_position($price);?></td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td class="invoiceTotal">
						<p><b><?= lang('sub_total');?> : </b> <b><?= admin_currency_position($price);?></b></p>
						<p><span><?= lang('tax');?> (<?= $tax_percent;?>%): </span> <span><?= admin_currency_position($tax_fee);?></span></p>
						<p><b><?= lang('total');?> : </b> <b><?= admin_currency_position($total_price);?></b></p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>