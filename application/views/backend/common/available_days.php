<div class="row p-15">
	<div class="table-responsive">
		<table class="table table-condensed table-striped">
			<thead>
				<tr class="text-center">
					<th width="20%"><?= !empty(lang('days'))?lang('days'):"days";?></th>
					<th width="30%"><?= !empty(lang('start_time'))?lang('start_time'):"Start Time";?></th>
					<th width="30%"><?= !empty(lang('end_time'))?lang('end_time'):"End Time";?></th>
					<th width="30%"><?= !empty(lang('open_24_hours'))?lang('open_24_hours'):"Open 24 hours";?></th>
				</tr>
			</thead>
			<tbody>
				<?php $days = get_days(); ?>
				<?php foreach ($days as $key=>$day): ?>
					<?php  $my_days = $this->admin_m->single_appoinment($key); ?>
					<tr>
						<td class="flex-td">
							<div class="form-group">
								<label class="custom-checkbox"> <input type="checkbox"  name="days[]" <?= isset($my_days['days']) && html_escape($my_days['days'])==$key?"checked":'';?>  value="<?= $key;?>">&nbsp;&nbsp; <?= $day;?> </label>
							</div>	
						</td>
						<td>
							<div class="bootstrap-timepicker">
								<div class="form-group">
									<label><?= !empty(lang('time_picker'))?lang('time_picker'):"Time picker";?>:</label>
									<div class="input-group">
										<input type="text" name="start_time[<?= $key?>]" value="<?php if(!empty($my_days['start_time'])){echo html_escape($my_days['start_time']);}?>" class="form-control timepicker">
										<div class="input-group-addon">
											<i class="fa fa-clock-o"></i>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<!-- /.form group -->
							</div>
						</td>

						<td>
							<div class="bootstrap-timepicker">
								<div class="form-group">
									<label><?= !empty(lang('time_picker'))?lang('time_picker'):"Time picker";?>:</label>
									<div class="input-group">
										<input type="text" name="end_time[<?= $key?>]" class="form-control timepicker" value="<?php if(!empty($my_days['end_time'])){echo html_escape($my_days['end_time']);}?>">
										<div class="input-group-addon">
											<i class="fa fa-clock-o"></i>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<!-- /.form group -->
							</div>
						</td>

						<td class="flex-td text-center">
							<div class="form-group text-center">
								<label class="custom-checkbox"><input type="checkbox" name="is_24[<?= $key?>]" value="1" <?= isset($my_days['is_24']) && html_escape($my_days['is_24'])==1?"checked":'';?> /><?= lang('active');?></label>
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div><!-- row -->