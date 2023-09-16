<?php 
		$today = $this->statistics_m->get_income('today');
		$yesterday = $this->statistics_m->get_income('nt');
		$last7 = $this->statistics_m->get_income('last7');
		$next7 = $this->statistics_m->get_income('nl7');
		$lastmonth = $this->statistics_m->get_income('lastmonth');
		$nextlastmonth = $this->statistics_m->get_income('nlm');

		$allTime = $this->statistics_m->get_income('allTime');


		function percent_diff($a, $b) {
			if($a <= $b && $b!=0){
				return @round(100+(1-($a/$b))*100);
			}

			if($a >= $b && $a!=0){
				return round(100+(($b/$a)-1)*100);
			}
		}
 ?>

<div class="row">

    <?php if(isset($page_title) && $page_title =="Earnings"): ?>
    <div class="col-md-4">
        <div class="info-box bg-gray">
            <span class="info-box-icon"><i class="icofont-clock-time"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('todays_earning');?></span>
                <span class="info-box-number"><?= currency_position($today->amount,restaurant()->id);?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: <?= percent_diff($yesterday->amount,$today->amount);?>%">
                    </div>
                </div>
                <div class="currencyDate">
                    <span class="progress-description">
                        <?= lang('yesterday');?> <?= currency_position($yesterday->amount,restaurant()->id);?>
                    </span>
                    <small><?= $yesterday->date;?></small>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="icofont-dashboard"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('monthly_earning');?></span>
                <span class="info-box-number"><?= currency_position($lastmonth->amount,restaurant()->id);?></span>
                <div class="progress">
                    <div class="progress-bar"
                        style="width: <?= percent_diff($nextlastmonth->amount,$lastmonth->amount);?>%"></div>
                </div>
                <div class="currencyDate">
                     <span class="progress-description">
                        <?= lang('previous_month_earning');?>
                        <?= currency_position($nextlastmonth->amount,restaurant()->id);?>
                    </span>
                    <small>
                        <?= $lastmonth->date;?>
                    </small>
                </div>
               
            </div>

        </div>
    </div>


    <div class="col-md-4">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="icofont-diamond"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('all_time');?></span>
                <span class="info-box-number"><?= currency_position($allTime->amount,restaurant()->id);?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    <?= lang('balance');?>
                </span>
            </div>

        </div>
    </div>
    <?php else: ?>
    <div class="col-md-4">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="icofont-clock-time"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('todays_earning');?></span>
                <span class="info-box-number"><?= currency_position($today->amount,restaurant()->id);?></span>
                <div class="progress">

                    <div class="progress-bar" style="width: <?= percent_diff($yesterday->amount,$today->amount);?>%">
                    </div>
                </div>
                <div class="currencyDate">
                    <span class="progress-description">
                        <?= lang('yesterday');?> <?= currency_position($yesterday->amount,restaurant()->id);?>
                    </span>
                    <small>
                        <?= $today->date;?>
                    </small>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="icofont-cubes"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('weekly_earning');?></span>
                <span class="info-box-number"><?= currency_position($last7->amount,restaurant()->id);?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: <?= percent_diff($next7->amount,$last7->amount);?>%"></div>
                </div>
                <div class="currencyDate">
                    <span class="progress-description">
                        <?= lang('previous_week_earning');?> <?= currency_position($next7->amount,restaurant()->id);?>
                    </span>
                    <small><?= $last7->date;?></small>
                </div>
                
            </div>

        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box bg-gray">
            <span class="info-box-icon"><i class="icofont-dashboard"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('monthly_earning');?></span>
                <span class="info-box-number"><?= currency_position($lastmonth->amount,restaurant()->id);?></span>
                <div class="progress">
                    <div class="progress-bar"
                        style="width: <?= percent_diff($nextlastmonth->amount,$lastmonth->amount);?>%"></div>
                </div>
                <div class="currencyDate">
                    <span class="progress-description">
                        <?= lang('previous_month_earning');?>
                        <?= currency_position($nextlastmonth->amount,restaurant()->id);?>
                    </span>
                    <small> 
                        <?= $lastmonth->date;?>
                    </small>
                </div>
                
            </div>

        </div>
    </div>

    <?php endif ?>





</div><!-- row -->