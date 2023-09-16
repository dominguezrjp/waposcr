<div class="row">
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('order_types'))?lang('order_types'):"Order Types";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/dashboard/add_order_types') ?>" method="post" class="skill_form" >
				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
				<div class="box-body">
					<div class="upcoming_events">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th width=""><?= !empty(lang('sl'))?lang('sl'):"Sl";?></th>
										<th width=""><?= !empty(lang('type_name'))?lang('type_name'):"Type Name";?></th>
										<th width=""><?= !empty(lang('slug'))?lang('slug'):"Slug";?></th>
										<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; foreach ($order_types as $row): ?>
										<?php if(check()==0 && $row['slug']=='pay-in-cash'): ?>
											<tr>
												<td><?= $i;?></td>
												<td><input type="text" class="form-control" name="name[]" value="<?= html_escape($row['name']); ?>"></td>
												<td><?= html_escape($row['slug']); ?></td>
												<td>
													<a href="javascript:;"  class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= !empty(lang('not_available'))?lang('not_available'):"No available";?></a>
												</td>
												<input type="hidden" name="id[]" value="<?= isset($row['id']) && $row['id'] !=0?$row['id']:0 ?>">
											</tr>
										<?php else: ?>
											<tr>
												<td><?= $i;?></td>
												<td><input type="text" class="form-control" name="name[]" value="<?= html_escape($row['name']); ?>"></td>
												<td><?= html_escape($row['slug']); ?></td>
												<td>
													<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="order_types" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1? (!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
												</td>
												<input type="hidden" name="id[]" value="<?= isset($row['id']) && $row['id'] !=0?$row['id']:0 ?>">
											</tr>
										<?php endif; ?>
									<?php $i++; endforeach ?>
								</tbody>
							</table>
						</div>
					</div>	
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="pull-right">
						<button type="submit" name="register" class="btn btn-primary btn-block btn-flat c_btn"><i class="fa fa-save"></i> &nbsp; <?= !empty(lang('save_change'))?lang('save_change'):"save change";?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php if(check()==0): ?>
<div class="row">
	<div class="col-md-6">
		<div class="callout callout-default">
			<h4 class="mb-3"><i class="icon fa fa-question-circle"></i> Info!</h4>

			<p>Pay in cash only available in <b>Extended license</b>.</p>
			<p>Please read  about the envato license rules&nbsp; <u><a href="https://codecanyon.net/licenses/standard" class="c_black" target="blank">Click Here</a></u></p>

			<p class="font-italic">*[ Upgrade you account in extended license ]</p>
		</div>
	</div>
</div>
<?php endif; ?>