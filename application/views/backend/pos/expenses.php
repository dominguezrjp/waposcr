<?php if(isset($is_edit) && $is_edit==1): ?>
	<div class="row">
		<div class="col-md-6">
			<form action="<?= base_url("admin/pos/add_expense");?>" method="post" class="validForm" enctype= "multipart/form-data">
				<?= csrf();?>
				<div class="card">
					<div class="card-header"> <h5 class="m-0 mr-5"> <?= lang('edit');?> </h5></div>
					<div class="card-body">
						<div class="card-content">
							<div class="form-group">
								<label><?= lang('category_name');?> <span class="error">*</span></label>
								<select name="category_id" class="form-control" required>
									<option value=""><?= lang('select');?></option>
									<?php foreach ($category_list as $key => $category): ?>
										<option value="<?= $category['id'];?>" <?= !empty($data['category_id']) && $data['category_id']==$category['id']?"selected":"";?>> <?= $category['category_name'];?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label><?= lang('title');?></label>
								<input type="text" name="title" class="form-control" value="<?= !empty($data['title'])?$data['title']:"";?>">
							</div>

							<div class="form-group">
								<label><?= lang('date');?> <span class="error">*</span></label>
								<div class="input-group">
									<input type="text" name="date" class="form-control datepicker pl-10" placeholder="yyyy-mm-dd" value="<?= !empty($data['created_at'])?$data['created_at']:'' ;?>">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>

							<div class="form-group">
								<label><?= lang('amount');?> <span class="error">*</span></label>
								<input type="number" name="amount" class="form-control" required value="<?= !empty($data['amount'])?$data['amount']:"";?>">
							</div>

							<div class="form-group">
								<?php if(!empty($data['images'])): ?>
									<div class="logoImg hideImg">
										<a href="<?= base_url("admin/auth/delete_img/{$data['id']}/expense_list");?>" id="deleteImg" class="delteIcon" data-msg="<?=lang('want_to_delete');?>"><i class="fa fa-trash"></i></a>
										<img src="<?= base_url($data['images']);?>" alt="logoImg">
									</div>
								<?php endif ?>
								<label><?= lang('expense_bill');?></label>
								<input type="file" name="images">
							</div>
							<div class="form-gorup">
								<label > <?= lang('notes');?></label>
								<textarea class="form-control textarea" name="notes"><?= !empty($data['notes'])?$data['notes']:"";?></textarea>
							</div>
						</div><!-- card-content -->
					</div><!-- card-body -->
					<div class="card-footer text-right justify-content-between flex"> 
						<input type="hidden" name="id" value="<?= !empty($data['id'])?$data['id']:0;?>">
						<a href="<?= base_url("admin/pos/expenses");?>" class="btn btn-default"><?= lang('back');?></a>
						<button type="submit" class="btn btn-secondary"><?= lang('submit');?></button>
					</div>
				</div><!-- card -->
			</form>
		</div>
	</div>
<?php else: ?>
<div class="row">
	<div class="col-md-8">
		<?php $expense_month = $this->pos_m->get_expense_month_year(); ?>
		<form action="<?= base_url("admin/pos/expenses");?>" method="get">
			<div class="filterArea">
				<select name="date" class="form-control">
					<?php foreach ($expense_month as $key => $month): ?>
						<option value="<?= year_month($month->created_at);?>" <?= isset($_GET['date']) && $_GET['date']==year_month($month->created_at)?"selected":"";?>><?= month_year_name($month->created_at);?></option>
					<?php endforeach ?>
				</select>

				<select name="category" class="form-control">
					<option value=""><?= lang('all');?></option>
					<?php foreach ($category_list as $key => $cat): ?>
						<option value="<?= $cat['id'];?>" <?= isset($_GET['category']) && $_GET['category']==$cat['id']?"selected":"";?>><?= $cat['category_name'];?></option>
					<?php endforeach ?>
				</select>
				<button type="submit" class="btn btn-secondary btn-sm btn-flat"><i class="fa fa-filter"></i></button>
			</div>
		</form>
		<div class="card">
			<div class="card-header justify-content-between"> <h5 class="m-0 mr-5"> <?= lang('expenses');?> </h5> <a href="#addExpense" data-toggle="modal" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> <?= lang('add_new');?></a></div>
			<div class="card-body">
				<div class="card-content">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th><?= lang('category_name');?></th>
									<th><?= lang('title');?></th>
									<th><?= lang('amount');?></th>
									<th><?= lang('date');?></th>
									<th><?= lang('notes');?></th>
									<th><?= lang('action');?></th>
								</tr>
							</thead>
							<tbody>
								<?php $total=0; ?>
								<?php foreach ($expense_list as $key => $row): ?>
									<tr>
										<td><?= $key+1;?></td>
										<td><?= $row->category_name;?></td>
										<td><?= $row->title;?></td>
										<td><?= currency_position($row->amount,restaurant()->id);?></td>
										<td><?= full_date($row->created_at);?></td>
										<td>
												<?= $row->notes;?>
										</td>
										<td>
											<?php if(!empty($row->notes) || !empty($row->images)): ?>
												<a href="javascript:;" class="btn btn-primary btn-flat btn-sm" onclick="showImg(`<?= $row->images??'';?>`,`<?= $row->notes;?>`)"><i class="fa fa-eye"></i></a>
											<?php endif; ?>
											<a href="<?= base_url("admin/pos/edit_expense/{$row->expense_id}");?>" class="btn btn-info btn-sm btn-flat"><i class="fa fa-edit"></i></a>
											<a href="<?= base_url("delete-item/{$row->id}/expense_list");?>" data-msg="<?= lang('want_to_delete');?>" class="btn btn-danger btn-flat btn-sm action_btn"><i class="fa fa-trash"></i></a>
										</td>
									</tr>
									<?php $total += $row->amount; ?>
								<?php endforeach ?>
								<tr style="background: #eee;font-weight: bold;">
									<td colspan="3"><?= lang('total');?></td>
									<td><?= currency_position($total,restaurant()->id);?></td>
									<td colspan="3"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div><!-- card-content -->
			</div><!-- card-body -->
		</div><!-- card -->
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header justify-content-between"> <h5 class="m-0 mr-5"> <?= lang('categories');?></h5> <a href="#addCategory" data-toggle="modal" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> <?= lang('add_new');?></a></div>
			<div class="card-body">
				<div class="card-content">
					<div class="table-responsive">
						<table class="table table-striped data_tables">
							<thead>
								<tr>
									<th>#</th>
									<th><?= lang('category_name');?></th>
									<th><?= lang('action');?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($category_list as $key => $category): ?>
									<tr>
										<td><?= $key+1;?></td>
										<td><?= $category['category_name'];?></td>
										<td>
											<a href="#editCategoryModal_<?= $category['id'];?>" data-toggle="modal" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-edit"></i></a>
											<a href="<?= base_url("delete-item/{$category['id']}/expense_category_list");?>" data-msg="<?= lang('want_to_delete');?>" class="btn btn-danger btn-flat btn-sm action_btn"><i class="fa fa-trash"></i></a>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div><!-- card-content -->
			</div><!-- card-body -->
		</div><!-- card -->
	</div>
</div>
<?php endif; ?>
<!-- add expenses -->

<div class="modal fade" id="addExpense">
	<div class="modal-dialog">
		<form action="<?= base_url("admin/pos/add_expense");?>" method="post" class="validForm" enctype= "multipart/form-data">
			<?= csrf();?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?= lang('add_new');?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label><?= lang('category_name');?> <span class="error">*</span></label>
						<select name="category_id" class="form-control" required>
							<option value=""><?= lang('select');?></option>
							<?php foreach ($category_list as $key => $category): ?>
								<option value="<?= $category['id'];?>"> <?= $category['category_name'];?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label><?= lang('title');?></label>
						<input type="text" name="title" class="form-control">
					</div>

					<div class="form-group">
						<label><?= lang('date');?> <span class="error">*</span></label>
						<div class="input-group">
							<input type="text" name="date" class="form-control datepicker pl-10" placeholder="yyyy-mm-dd" required value="<?= today();?>">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>	
						</div>
					</div>

					<div class="form-group">
						<label><?= lang('amount');?> <span class="error">*</span></label>
						<input type="number" name="amount" class="form-control" required>
					</div>

					<div class="form-group">
						<label><?= lang('expense_bill');?></label>
						<input type="file" name="images">
					</div>
					<div class="form-gorup">
						<label > <?= lang('notes');?></label>
						<textarea class="form-control textarea" name="notes"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-secondary"><?= lang('submit');?></button>
				</div>
			</div>
		</form>
	</div>
</div>



<!-- Add expense Category Modal-->

<div class="modal fade" id="addCategory">
	<div class="modal-dialog">
		<form action="<?= base_url("admin/pos/add_expense_category");?>" method="post">
			<?= csrf();?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?= lang('add_new');?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label><?= lang('category_name');?></label>
						<input type="text" name="category_name" class="form-control" placeholder="<?= lang('category_name');?>">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-secondary"><?= lang('submit');?></button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php foreach ($category_list as $key => $category): ?>
	<div class="modal fade" id="editCategoryModal_<?= $category['id'];?>">
		<div class="modal-dialog">
			<form action="<?= base_url("admin/pos/add_expense_category");?>" method="post">
				<?= csrf();?>
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"><?= lang('add_new');?></h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label><?= lang('category_name');?></label>
							<input type="text" name="category_name" class="form-control" placeholder="<?= lang('category_name');?>" value="<?= $category['category_name'];?>">
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="id" value="<?= $category['id'];?>">
						<button type="submit" class="btn btn-secondary"><?= lang('submit');?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php endforeach; ?>


<div class="modal fade" id="notesModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?= lang('notes');?></h4>
			</div>
			<div class="modal-body">
				<div class="description"></div>
				<div class="notesImg">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	let base_urls = `<?= base_url();?>`;
	function showImg(url,text){
		$('.notesImg').html('');
		$('.description').html(text);
		if(url.length > 1){
			$('.notesImg').html(`<img src="${base_urls}${url}" alt="notesImg">`);
		}
		$('#notesModal').modal('show');
	}
</script>
