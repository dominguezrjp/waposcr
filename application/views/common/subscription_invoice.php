<?php $id = $invoice_info->package_slug.'_'.random_string('numeric',4); ?>
<script src="<?= base_url(); ?>assets/frontend/html2pdf/pdf.main.js"> </script>
<div class="subscriptionInvoiceArea">
	<div class="container">
		<div class="exportBtn">
			<a href="javascript:;" onclick="makepdf(`<?= $id;?>`)" class="btn btn-secondary"><i class="fa fa-file-pdf-o"></i> <?= lang('download');?></a>
		</div>
		<div class="subscribeInvoice bg_white" id="makePdf">
			<?php include "subscription_invoice_thumb.php"; ?>
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