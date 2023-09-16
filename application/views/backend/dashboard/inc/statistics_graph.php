<div class="row">
	<?php 
	$order_type_list =  $this->admin_m->get_users_order_types_by_shop_id($_ENV['ID']);
 ?>
 	
	<div class="col-md-12 pl-5 pr-5">
		<div class="card  customTab">
			<div class="card-header justify-content-between p-5">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#total_sales"><?= lang('total_sell');?></a></li>
					<?php foreach ($order_type_list as $key => $orderType): ?>
						<li class="hidden"><a data-toggle="tab" href="#<?= $orderType['slug'];?>"><?= $orderType['type_name'];?></a></li>
					<?php endforeach ?>
				</ul>

				<div class="rightButton hidden">
					<div class="dropdown customDropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							<?= lang('today');?>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li><a href="#">Today</a></li>
							<li><a href="#">Yesterday</a></li>
							<li><a href="#">Last 7 Days</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Month</a></li>
						</ul>
					</div>
				</div>	
			</div>
			<div class="card-body">
				

				<div class="tab-content">
					<div id="total_sales" class="tab-pane fade in active">
						<div class="allOrderStatistics">
							<ul>
								<li>
									<h3><?= currency_position($daily_statistics->amount,$_ENV['ID']);?></h3>
									<p><?= lang('total_sell');?> - <?= $daily_statistics->count;?> <?= lang('orders');?></p>
								</li>
								<?php foreach ($order_type_list as $key=> $order): ?>
									<li class="hColor_<?= $key+1;?>">
										<h3><?= currency_position($this->statistics_m->get_daily_statistics($_ENV['ID'],$order['order_type_id'])->amount,$_ENV['ID']);?></h3>
										<p> <?= $order['type_name'];?> (<?= $this->statistics_m->get_daily_statistics($_ENV['ID'],$order['order_type_id'])->count;?>)</p>
									</li>
								<?php endforeach ?>
							</ul>
						</div>
						<div id="salescontainer"></div>
					</div>
					<?php foreach ($order_type_list as $key => $orderType): ?>
						<div id="<?= $orderType['slug'];?>" class="tab-pane fade in ">
							<h3><?= $orderType['slug'];?></h3>
							<p>Some content.</p>
						</div>
					<?php endforeach; ?>
					
				</div>
			</div>
		</div>
	</div>

</div>





<script src="<?php echo base_url()?>assets/admin/plugins/chart/highchart.js"></script>
<script>
	Highcharts.chart('salescontainer', {
    chart: {
        type: 'column'
    },
    title: {
        align: 'left',
        text: ''
    },
    subtitle: {
        align: 'left',
        text: ''
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: ''
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: `<?= currency_format('{point.y:.1f}',$_ENV['ID']);?>`
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> <br/>'
    },

    series: [
        {
            name: `<?= lang('orders')?>`,
            colorByPoint: true,
            data: [
            	<?php foreach ($order_type_list as  $order_type):?>
            		{
            			name: "<?= $order_type['type_name'];?>",
	            		y: <?= $this->statistics_m->get_daily_statistics($_ENV['ID'],$order_type['order_type_id'])->amount;?>,
	            		drilldown: null  
            		},
            	<?php endforeach;?>	

            ]
        }
    ],
    drilldown: {
        breadcrumbs: {
            position: {
                align: 'right'
            }
        },
        series: [
           
            
        ]
    }
});
</script>