<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('new_users'))?lang('new_users'):"New Users";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body" >
				<div class="text-right hidden">
					<a href="<?= base_url('admin/dashboard/add_user') ?>" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> <?= lang('add_user'); ?></a>
				</div>
				<br>
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped">
	                <thead>
	                <tr>
	                  <th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
	                  <th><?= !empty(lang('username'))?lang('username'):"username";?></th>
	                  <th><?= !empty(lang('email'))?lang('email'):"email";?></th>
	                  <th><?= !empty(lang('active_date'))?lang('active_date'):"Active Date";?></th>
	                  <th><?= !empty(lang('account_type'))?lang('account_type'):"Account type";?></th>
	                  <th><?= !empty(lang('action'))?lang('action'):"action";?></th>
	                </tr>
	                </thead>
	                <tbody>
	                <?php $i=1; foreach ($all_user as $key => $row): ?>
		                <tr>
		                  <td><?= $i; ?></td>
		                  <td><?= html_escape($row['username']); ?> </td>
		                  <td><?= html_escape($row['email']); ?></td>
		                  <td> <?= $row['start_date']!='0000-00-00 00:00:00'?full_time(html_escape($row['created_at'])):'Not Verify yet'; ?></td>
						  <td>
						  	<?php if($row['is_expired'] == 0): ?>
							  	<span class="label label-default mr-5" data-toggle="tooltip" data-placement="top" title="<?= 'Expired Date: '.$row['end_date'];?>" >
							  		<?php if($row['is_payment']==1 && $row['end_date'] !='0000-00-00 00:00:00'): ?>
							  			<?= day_left(d_time(),$row['end_date'])['day_left']; ?>
							  		<?php else: ?>
							  			<?= !empty(lang('not_verified'))?lang('not_verified'):"Not Verify yet";?>
							  		<?php endif ?>
							  	</span>
						  	<?php else: ?>
						  		<span class="label label-danger mr-5"  data-toggle="tooltip" data-placement="top" title="<?= 'Expired on: '.day_left(d_time(),$row['end_date'])['day_left'];?>" ><?= !empty(lang('expired'))?lang('expired'):"Expired";?></span>
						  	<?php endif ?>

		                  	<a href="javascript:;"  class="label label-primary"><?= html_escape($row['package_name']);?></a>
		                  </td>

		                  <td>
		                  	<a href="<?= base_url(html_escape($row['username'])); ?>" title="View Profile" class="btn btn-info" target="blank"> <i class="fa fa-eye"></i> </a>
		                  	
		                  </td>
		                </tr>
	            	<?php $i++; endforeach ?>
	                </tbody>
	              </table>
				</div>
			</div><!-- /.box-body -->
			<div class="box-footer" >
			
			</div>
		</div>
	</div>
</div>