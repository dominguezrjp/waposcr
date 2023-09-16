<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="single_alert alert alert-info alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<div class="d_flex_alert">
				<h4><i class="icon fas fa-question-circle"></i> Info!</h4>
				<div class="double_text">
					<div class="text-left">
						<h5>User account will create by author</h5>
						<p>If  you not select <b>Add password</b> password will set 1234</p>
					</div>
				</div>
			</div>
		</div>
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('add_new_user'))?lang('add_new_user'):"Add New User";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">

				<form action="<?php echo base_url('admin/dashboard/new_user') ?>" method="post">
					
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">


				      <div class="form-group">
				      	<label for="username"><?= !empty(lang('restaurant_username'))?lang('restaurant_username'):"Restaurant username";?></label>
				        <input type="text" name="username" id="username" class="form-control" id="username" placeholder="<?= !empty(lang('restaurant_username'))?lang('restaurant_username'):"Restaurant username";?>" value="<?= set_value('restaurant_name');?>">
				      </div>
				      <div class="form-group">
				      	<div class="mail_area">
				      		<label for="email"><?= !empty(lang('email'))?lang('email'):"email";?></label>
				      	</div>
				        <input type="email" name="email" id="email" class="form-control" placeholder="xxxx@email.com" value="<?= set_value('email');?>">
				      </div>

				      <div class="form-group">
				      	<label for="country"><?= !empty(lang('package_name'))?lang('package_name'):"Package name";?></label>
				        <select name="package" id="package" class="form-control select2">
				        	<option value=""><?= lang('select_package'); ?></option>
				        	<?php foreach ($features as $key => $row) { ?>
				        		<option value="<?= $row['id'] ?>"><?= $row['package_name']; ?> - <?= get_currency('icon').' '.$row['price'] ;?> / <?= $row['package_type'];?></option>
				        	<?php } ?>
				        </select>
				      </div>

				      <div class="form-group">
				      	<label class="pointer"><input type="checkbox" name="is_password" value="1" class="check_password"> &nbsp;<?= !empty(lang('add_password'))?lang('add_password'):"Add password";?></label>
				      </div>

				      <div class="form-group show_password" style="display: none;">
				      	<label for="password"><?= !empty(lang('password'))?lang('password'):"password";?></label>
				        <input type="password" name="password" id="password" class="form-control" placeholder="<?= !empty(lang('password'))?lang('password'):"password";?>" value="<?= set_value('password');?>">
				        <span class="error"><?php echo form_error('password'); ?></span>
				      </div>

				</div><!-- /.box-body -->
				<div class="box-footer">
					<span data-toggle="tooltip" data-placement="top" title="<?= lang('password_msg_add_user'); ?>"><i class="fa fa-question-circle fa-2x"></i> </span>
					<div class="pull-right">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          </div>
				</div>
			</form>
		</div>
	</div>
</div>
