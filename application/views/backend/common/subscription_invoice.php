<style>
	.subscribeInvoice img{
		width: auto;
		max-height: 120px;
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
</style>
<?php 
	$tax = get_percent($package['price'],$tax_percent);
	$price = $package['price'];
	$total_price = $package['price']+$tax;
	$id = random_string('numeric');
 ?>
<script src="<?= base_url(); ?>assets/frontend/html2pdf/html2pdf.bundle.main.js"> </script>
<div class="subscriptionInvoiceArea">
	<div class="container">
		<div class="exportBtn">
			<a href="javascript:;" onclick="makepdf(<?= $id;?>)" class="btn btn-secondary"><i class="fa fa-file-pdf-o"></i> <?= lang('download');?></a>
		</div>
		<div class="subscribeInvoice bg_white" id="makePdf">
			<div class="invoiceHeader headerTop">
				<div class="invoiceCompany invoiceLeft">
					<p><?= lang('order_no');?> : <?= rand();?></p>
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
					<h4><?= $admin->company_name;?></h4>
					<p><?= $admin->address;?></p>
					<p><?= $admin->email;?></p>
					<p><?= lang("organization_number")?> : <?= $admin->organization_number;?></p>
				</div>
				<div class="invoiceCompany invoiceRight">
					<h4><?= $u->company_name;?></h4>
					<p><?= $u->address;?></p>
					<p><?= $u->email;?></p>
					<p><?= lang("organization_number")?> : <?= $u->organization_number;?></p>
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
								<td><?= $package['package_name'];?></td>
								<td>1</td>
								<td><?= admin_currency_position($price);?></td>
								<td><?= admin_currency_position($price);?></td>
							</tr>
							<tr>
								<td colspan="4"></td>
								<td class="invoiceTotal">
									<p><b><?= lang('sub_total');?> : </b> <b><?= admin_currency_position($price);?></b></p>
									<p><span><?= lang('tax');?> (<?= $tax_percent;?>%): </span> <span><?= admin_currency_position($tax);?></span></p>
									<p><b><?= lang('total');?> : </b> <b><?= admin_currency_position($total_price);?></b></p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div><!-- subscribeInvoice -->

	</div>
</div>

<script>
	function makepdf(ID) {
		var section = document.getElementById('makePdf');
		var options = {
			filename: `invoice_${ID}.pdf`,
			image: { type: 'jpeg', quality: 0.98 },
			html2canvas: { scale: 2 },
			jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
		};

		html2pdf().set(options).from(section).save();
	}
</script>