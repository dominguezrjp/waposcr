<div class="form-group">
	<label><b><?= $question['title'];?></b></label>
	<input type="text" name="answer" id="" class="form-control" placeholder="<?= lang('write_your_answer_here');?>">

	<input type="hidden" name="customer_id" value="<?= $customer_data['id'];?>">
</div>

<div class="form-group">
	<label><?= lang('new_pass');?></label>
	<input type="text" name="password" class="form-control" placeholder="<?= lang('password');?>">
</div>

<div class="form-group">
	<label><?= lang('confirm_password');?></label>
	<input type="text" name="confirm_password" class="form-control" placeholder="<?= lang('confirm_password');?>">
</div>