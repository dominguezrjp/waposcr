<?php include 'incomeBadge.php'; ?>
<div class="filterarea">
	<div class="filterContent">
		<div class="filtercontentBody">
			<form action="" method="get" class="filterForm">
				<div class="filterBody">				
					<div class="form-group">
						<label for=""><?= lang('order_type'); ?></label>
						<select name="order_type" id="" class="form-control">
							<?php $order_type = $this->admin_m->select('order_types'); ?>
							<option value=""><?= lang('select'); ?></option>
							<?php foreach ($order_type as $key => $type): ?>
								<option value="<?=  $type['id'];?>" <?= isset($_GET['order_type']) && $_GET['order_type']==$type['id']?"selected":'' ;?>><?= $type['name']; ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group">
						<label><?= lang('status'); ?></label>
						<select name="status" id="status" class="form-control">
							<option value='all' <?= isset($_GET['status']) && $_GET['status']=='all'?"selected":'' ;?>><?= lang('select'); ?></option>
						<option value="0" <?= isset($_GET['status']) && $_GET['status']=='0'?"selected":'' ;?>><?= lang('pending'); ?></option>
							<option value="1" <?= isset($_GET['status']) && $_GET['status']=='1'?"selected":'' ;?>><?= lang('accepted'); ?></option>
							<option value="2" <?= isset($_GET['status']) && $_GET['status']=='2'?"selected":'' ;?>><?= lang('completed'); ?></option>
							<option value="3" <?= isset($_GET['status']) && $_GET['status']=='3'?"selected":'' ;?>><?= lang('rejected'); ?></option>
						</select>
					</div>

					<div class="form-group">
						<label><?= lang('date'); ?> <?= isset($_GET['daterange'])?" : ".$_GET['daterange']:'';?></label>
						<div class="input-group date">
							<input type="text" name="daterange" class="form-control dateranges" value="<?= isset($_GET['daterange'])?$_GET['daterange']:'';?>"> 
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
						</div>
					</div>

					<div class="form-group mt-15">
						<button type="submit" class="btn btn-primary filterBtn sm-block sm-w_100p"><i class="icofont-filter"></i> <?= lang('filter'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<figure class="highcharts-figure">
				  <div id="container"></div>
				  <div class="highcharts-description p-5">
					   <table class="table  data_tables">
						   	<thead>
						   		<tr>
						   			<th>#</th>
						   			<th><?= lang('name'); ?></th>
						   			<th><?= !empty(lang('total_sell'))?lang('total_sell'):"Total sells" ;?> (<?= lang('times')?>)</th>
						   		</tr>
						   	</thead>
					   		<?php foreach ($top_item as $key => $item): ?>
						   		<tr>
						   			<td><?= $key+1 ;?></td>
						   			<td><?= $item['is_package']==1?$item['package_name']:$item['item_name'] ;?></td>
						   			<td><?= $item['total_sell'] ;?></td>
						   		</tr>
						   	<?php endforeach; ?>	
					   </table>
				  </div>
				</figure>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<figure class="highcharts-figure">
				  <div id="top_sell_price"></div>
				  <div class="highcharts-description p-5">
					   <table class="table data_tables ">
						   	<thead>
						   		<tr>
						   			<th>#</th>
						   			<th><?= lang('name'); ?></th>
						   			<th><?= !empty(lang('qty'))?lang('qty'):"qty" ;?></th>
						   			<th><?= !empty(lang('amount'))?lang('amount'):"amount" ;?></th>
						   		</tr>
						   	</thead>
					   		<?php foreach ($top_sell_price as $key => $item): ?>
						   		<tr>
						   			<td><?= $key+1 ;?></td>
						   			<td><?= $item['is_package']==1?$item['package_name']:$item['item_name'] ;?></td>
						   			<td><?= $item['total_item'] ;?></td>
						   			<td><?= currency_position($item['total_price'],restaurant()->id) ;?></td>
						   		</tr>
						   	<?php endforeach; ?>	
					   </table>
				  </div>
				</figure>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<figure class="highcharts-figure">
				  <div id="popular_customer"></div>
				  <div class="highcharts-description p-5">
					   <table class="table  data_tables">
					   		<thead>
					   			<tr>
					   				<th>#</th>
					   				<th><?= lang('name'); ?></th>
					   				<th><?= !empty(lang('items'))?lang('items'):"items" ;?></th>
					   				<th><?= !empty(lang('amount'))?lang('amount'):"amount" ;?></th>
					   			</tr>
					   		</thead>
					   		<?php foreach ($top_popular_customer as $key => $customer): ?>
					   			<?php $sum = 0; $amounts = 0; foreach ($customer['customers'] as $key2 => $c): ?>
						   				<?php $sum =  $sum+$c['total_item'] ;?>
						   				<?php $amounts =  $amounts+$c['total_amount'] ;?>
						   			<?php endforeach; ?>
						   		<tr>
						   			<td><?= $key+1 ;?></td>
						   			<td><?= !empty($customer['customer_name'])?$customer['customer_name']:"Walk-in-customer";?></td>
						   			<td><?= $sum ;?></td>
						   			
						   			<td> <?=  currency_position($amounts,restaurant()->id);?></td>
						   		</tr>
						   	<?php endforeach; ?>	
					   </table>
				  </div>
				</figure>
			</div>
		</div>
	</div>
</div>
<script src="<?= base_url('assets/admin/plugins/highcharts.js') ;?>"></script>
<!-- Top  item -->
<script>
	Highcharts.chart('container', {
	
	exporting: {
        showTable: true,
    },
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },

    title: {
        text: '<?= lang('top_10_selling_item'); ?>'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        },
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
        <?php foreach ($top_item as $key => $item): ?>
        	<?php if($key == 0): ?>
	        {
	            name: `<?= $item['is_package']==1?$item['package_name']:$item['item_name'] ;?>`,
	            y: <?= $item['total_sell'] ;?>,
	            sliced: true,
	            selected: true
	        }, 
	    <?php else: ?>
	    	{
	            name: `<?= $item['is_package']==1?$item['package_name']:$item['item_name'] ;?>`,
	            y: <?= $item['total_sell'] ;?>
	        },
	    <?php endif;?>
    	<?php endforeach;?>
        
        ]
    }]
});
</script>



<script>
	Highcharts.chart('top_sell_price', {
		chart: {
			zoomType: 'xy'
		},
		title: {
			text: '<?= lang('top_10_most_earning_items'); ?>'
		},
		subtitle: {
			text: `<?= lang('total_qty') ;?> & <?= lang('total_amount') ;?>`
		},
		xAxis: [{
			categories: [],
			crosshair: true
		}],
    yAxis: [{ // Primary yAxis
    	labels: {
    		format: '{value} ',
    		style: {
    			color: Highcharts.getOptions().colors[1]
    		}
    	},
    	title: {
    		text: '<?= lang('qty'); ?>',
    		style: {
    			color: Highcharts.getOptions().colors[1]
    		}
    	}
    }, { // Secondary yAxis
    	title: {
    		text: '<?= lang('amount'); ?>',
    		style: {
    			color: Highcharts.getOptions().colors[0]
    		}
    	},
    	labels: {
    		format: '{value} <?=  restaurant()->icon;?>',
    		style: {
    			color: Highcharts.getOptions().colors[0]
    		}
    	},
    	opposite: true
    }],
    tooltip: {
    	shared: false
    },
    legend: {
    	layout: 'vertical',
    	align: 'left',
    	x: 120,
    	verticalAlign: 'top',
    	y: 100,
    	floating: true,
    	backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || // theme
            'rgba(255,255,255,0.25)'
        },
        series: [{
        	name: `<?= lang('amount'); ?>`,
        	type: 'column',
        	yAxis: 1,
        	data: [
        	<?php foreach ($top_sell_price as $key => $price): ?>
        		<?=  $price['total_price'];?>,
        	<?php endforeach; ?>
        	],
        	tooltip: {
        		valueSuffix: `<?= restaurant()->icon ;?>`
        	}

        }, {
        	name: `<?= lang('qty'); ?>`,
        	type: 'spline',
        	data: [
        		<?php foreach ($top_sell_price as $key => $price): ?>
	        		<?=  $price['total_item'];?>,
	        	<?php endforeach; ?>
        	],
        	tooltip: {
        		valueSuffix: ``
        	}
        }]
    });
</script>

<script>
	Highcharts.chart('popular_customer', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: 0,
			plotShadow: false
		},
		title: {
			text: `<?= lang('total_purchased_item') ;?>`,
			align: 'center',
			verticalAlign: 'base',
			y: 60
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
				dataLabels: {
					enabled: true,
					distance: -50,
					style: {
						fontWeight: 'bold',
						color: 'white'
					}
				},
				startAngle: -90,
				endAngle: 90,
				center: ['50%', '75%'],
				size: '110%'
			}
		},
		series: [{
			type: 'pie',
			name: 'Total Purchase Items',
			innerSize: '50%',
			data: [
			<?php foreach ($top_popular_customer as $key => $p): ?>
				<?php $sum = 0; $amounts = 0; foreach ($p['customers'] as $key2 => $c): ?>
					<?php $sum =  $sum+$c['total_item'] ;?>
					<?php $amounts =  $amounts+$c['total_amount'] ;?>
				<?php endforeach; ?>
				[`<?= !empty($p['customer_name'])?$p['customer_name']:"Walk-in-customer";?>`, <?= $sum;?>],
			<?php endforeach; ?>
			
			]
		}]
	});
</script>


