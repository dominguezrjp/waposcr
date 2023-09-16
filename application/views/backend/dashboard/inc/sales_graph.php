<div class="col-lg-12 pl-5 pr-5">
	<div class="box box-solid ">
		<div class="box-header">
			<i class="fa fa-th"></i>

			<h3 class="box-title"><?= lang('sales_graph'); ?></h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn bg-white btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
				</button>
				<button type="button" class="btn bg-white btn-sm" data-widget="remove"><i class="fa fa-times"></i>
				</button>
			</div>
		</div>
		<div class="box-body border-radius-none p-r">
			<div id="chartContainers" style="height: 370px; width: 100%;"></div>
			<span class="removeText"></span>
		</div>
		<!-- /.box-body -->
		<div class="box-footer no-border">
			<div class="row">
				<div class="col-xs-4 text-center revenue_text">
					<h4><?= $this->admin_m->user_total_income_in_year(0);?> <?= restaurant()->icon;?></h4>
					<p><?= lang('total_revenue'); ?></p>
				</div>

				<div class="col-xs-4 text-center revenue_text">
					<h4><?= $this->admin_m->user_total_income_in_year('year');?> <?= restaurant()->icon;?></h4>
					<p><?= lang('total_revenue'); ?> (<?= date('Y');?>)</p>
				</div>

				<div class="col-xs-4 text-center revenue_text">
					<h4><?= $this->admin_m->user_total_income_in_year('month');?> <?= restaurant()->icon;?></h4>
					<p><?= lang('total_revenue'); ?> (<?= date('M');?>)</p>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.box-footer -->
	</div>  
	<!-- sales graph -->

</div>
<?php 
	$pending = order_st($_ENV['ID'],$order_type=0,$status=0,$is_deliveried=0)->count;
	$success = order_st($_ENV['ID'],$order_type=0,$status=2,$is_deliveried=0)->count;
	$deliveried = order_st($_ENV['ID'],$order_type=0,$status=2,$is_deliveried=1)->count;
	$cancled = order_st($_ENV['ID'],$order_type=0,$status=3,$is_deliveried=0)->count;
 ?>

 <div class="col-md-12 pl-5 pr-5">
 	<div class="card ">
 		<div class="card-header"><h3 class="card-title"><?= lang('order_status');?></h3></div>
 		<div class="card-body p-10">
 			<div class="OrderStatistics">
 				<div class="singleOrderStatistics orderPending <?= $pending > 0?"active":"";?>">
 					<h4><?= $pending;?></h4>
 					<p><?= lang('pending');?></p>
 				</div>

 				<div class="singleOrderStatistics orderSuccess <?= $success > 0?"active":"";?>">
 					<h4><?= $success;?></h4>
 					<p><?= lang('completed');?></p>
 				</div>

 				<div class="singleOrderStatistics orderDeliveried <?= $deliveried > 0?"active":"";?>">
 					<h4><?= $deliveried; ?></h4>
 					<p><?= lang('delivered');?></p>
 				</div>

 				<div class="singleOrderStatistics orderCancled <?= $cancled > 0?"active":"";?>">
 					<h4><?= $cancled;?></h4>
 					<p><?= lang('cancled');?></p>
 				</div>
 			</div><!-- OrderStatistics -->
 		</div><!-- card-body -->
 	</div>
 </div>
