<div class="row">
		<div class="col-md-6">
			<form class="email_setting_form" action="<?= base_url('admin/home/add_questions/') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
			<div class="">
				<div class="card">
					<div class="card-header">
						<h4><?= lang('signup_questions'); ?></h4>
						
					</div>
					<div class="card-body">
						<div class="row p-15">
							<div class="row">
								<div class="form-group col-md-12">
									<label for="title"><?= !empty(lang('title'))?lang('title'):" Title";?> *</label>
									<input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"Title";?>" value="<?= !empty($data['title'])?html_escape($data['title']):""; ?>">
								</div>
							</div>
						</div><!-- row -->
							
					</div><!-- card-body -->
					<div class="card-footer">
						<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
						<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
					</div>
				</div><!-- card -->
			</div><!-- col-9 -->
		</form>
			
		</div><!-- col-9 -->
	<div class="col-md-6 ">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4><?= lang('signup_questions'); ?></h4>
					</div>
					<div class="card-body">
						<div class="row p-15">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
											<th><?= lang('title'); ?></th>
											<th><?= lang('action'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1; foreach ($question_list as $row): ?>
										<tr>
											<td><?= $i;?></td>
											<td><?= html_escape($row['title']); ?></td>
											<td>
												
												<a href="<?= base_url('admin/home/edit_question/'.html_escape($row['id'])); ?>"  class="btn btn-sm btn-info"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>

												<a href="<?= base_url('delete-item/'.html_escape($row['id']).'/question_list'); ?>" class=" action_btn btn btn-sm btn-danger" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>" ><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>

											</td>
										</tr>
										<?php $i++; endforeach ?>
									</tbody>
								</table>
							</div>
						</div><!-- row -->
						
					</div><!-- card-body -->
				</div><!-- card -->
			</div>
		</div>
	</div>	
</div>

