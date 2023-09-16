<div class="input-group input-group-sm customerInput">
	<select name="customer_id" class="form-control select2" id="customer_id">
		<option value="0"><?= !empty(lang('walk-in-customer'))? lang('walk-in-customer'):"Walk in customer";?></option>
		<?php foreach ($customer_list as $key => $cs): ?>
			<option value="<?= $cs['id'];?>"><?= $cs['customer_name'];?> (<b class="opacity_0"><?= $cs['phone'];?></b>)</option>
		<?php endforeach ?>
	</select>
	<span class="input-group-btn">
		<button type="button" href="#addCustomerModal" data-toggle="modal" class="btn btn-success-light btn-flat input-btn"><i class="fa fa-user-plus"></i></button>
		
	</span>
</div>

