<div class="row no-print">
	<div class="col-md-8">
		<?php include APPPATH.'views/backend/reports/incomeBadge.php'; ?>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header no-print"> <h4 class="m-0 mr-5"> <?= lang('earnings');?> </h4></div>
			<div class="card-body pt-0">
				<div class="action-buttons exportPrintBtn mt-10">
					<a href="javascript:;" onclick="printDiv('printArea')" class="btn btn-success-light"  data-title="Print">
						<i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
						<?= !empty(lang('print'))?lang('print'):"Print" ;?>
					</a>
					<?php if(check()==1): ?>
						<a id="exportBtn" href="javascript:;" class="btn btn-gray-light"  data-title="PDF">
							<i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
							<?= !empty(lang('export'))?lang('export'):"Export" ;?>
						</a>
					<?php endif;?>
				</div>
				<div id="printArea">
					<div class="salesDropdownArea mb-5 mt-5">
						<ul>
							<li><a href="<?= base_url("admin/reports/earnings");?>"><span class="btn btn-gray-light"><?= lang('all_time');?></span></a></li>
							<li><a href="<?= base_url("admin/reports/earnings/".(!empty($year)? $year:0));?>"><?= !empty($year)? '<span>/</span>'. $year:"";;?></a></li>

							<li><a href="<?= base_url("admin/reports/earnings/".(!empty($year)? $year:0).'/'.(!empty($month)? $month:0));?>"><?= !empty($month)? '<span>/</span>'. date("F", mktime(0, 0, 0, $month, 10)):"";;?></a></li>
							<?php if(isset($_GET['d']) && !empty($_GET['d'])): ?>
							<li><a href="javascript:;"> <?= !empty($month)? '<span>/</span>'. date("l, d",strtotime($year.'-'.$month.'-'.$_GET['d'])):"";?> </a></li>
						<?php endif ?>
					</ul>
				</div>
				<div class="card-content">
					<div class="earningTables">
						<?php include 'inc/all_time_earnings.php'; ?>
					</div>
				</div><!-- card-content -->
			</div><!-- printArea -->

			</div><!-- card-body -->
			
		</div><!-- card -->
	</div>
</div>


 <!-- printThis -->
	<script type="text/javascript" src="<?= base_url();?>assets/frontend/html2pdf/html2pdf.bundle.js"></script>

	<script>

		var order="<?= random_string('numeric', 4);?>";
		// $('#printBtn').on("click", function () {
		// 	window.print();  
		// });


		function printDiv(divName) {
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;
		}


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


   