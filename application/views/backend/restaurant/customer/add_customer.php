<div class="row">
	<div class="col-md-5">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('add_customer'))?lang('add_customer'):"Add Customer";?> </h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/restaurant/add_customer') ?>" method="post" class="skill_form" enctype= "multipart/form-data" autocomplete="off">
				<div class="box-body">


					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group col-md-12">
						      	<label for="type_name"><?= !empty(lang('name'))?lang('name'):"package name";?></label>
						        <input type="text" name="name" id="name" class="form-control" placeholder="<?= !empty(lang('name'))?lang('name'):"Name";?>" value="<?= !empty($data['name'])?html_escape($data['name']):set_value('name'); ?>">
						    </div>
						    <div class="form-group col-md-12">
						    	<label for="type_name"><?= !empty(lang('phone'))?lang('phone'):"phone";?></label>
						    	<input type="text" name="phone" id="phone" class="form-control" placeholder="<?= !empty(lang('phone'))?lang('phone'):"phone";?>" value="<?= !empty($data['phone'])?html_escape($data['phone']):""; ?>">
							</div>

							<div class="form-group col-md-12">
								<label for="type_name"><?= !empty(lang('email'))?lang('email'):"email";?></label>
								<input type="text" name="email" id="email" class="form-control" placeholder="<?= !empty(lang('email'))?lang('email'):"email";?>" value="<?= !empty($data['email'])?html_escape($data['email']):""; ?>">
							</div>
						    
						       
						</div> <!-- col-md-6 -->
					</div>

				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="pull-left">
						<input type="hidden" name="data_phone" value="<?= isset($data['phone']) && $data['phone'] !=0?$data['phone']:0 ?>">
						<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?$data['id']:0 ?>">
		          		<a href="<?= base_url('admin/restaurant/customer_list'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
		          	</div>
		          	<div class="pull-right">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-lg btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="single_alert alert alert-info alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<div class="d_flex_alert">
				<h4><i class="icon fas fa-question-circle"></i> <?= lang('info'); ?>!</h4>
				<div class="double_text">
					<div class="text-left">
						<p><?= lang('customer_password_msg');?></p>
						<p><?= lang('customer_password_change_msg');?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>