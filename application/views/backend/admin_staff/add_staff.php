<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 col-lg-8">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('add_straff'))?lang('add_straff'):"Add straff";?> </h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/adminstaff/add_staff') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body">


					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group col-md-12">
						      	<label for="type_name"><?= !empty(lang('name'))?lang('name'):"package name";?></label>
						        <input type="text" name="name" id="name" class="form-control" placeholder="<?= !empty(lang('name'))?lang('name'):"Name";?>" value="<?= !empty($data['name'])?html_escape($data['name']):set_value('name'); ?>">
						    </div>
							<div class="form-group col-md-12">
								<?php if(isset($data['email']) && !empty($data['email'])): ?>
								   	<input type="text" name="email" id="email" class="form-control" placeholder="<?= !empty(lang('email'))?lang('email'):"email";?>" value="<?= !empty($data['email'])?html_escape($data['email']):set_value('slug'); ?>" readonly>
									<?php else: ?>
								      	<label for="type_name"><?= !empty(lang('email'))?lang('email'):"email";?></label>
								        <input type="text" name="email" id="email" class="form-control" placeholder="<?= !empty(lang('email'))?lang('email'):"email";?>" value="<?= !empty($data['email'])?html_escape($data['email']):set_value('slug'); ?>">
							        <?php endif;?>
							    </div>
							
						    
						       
						</div> <!-- col-md-6 -->


						<div class="col-md-6">
							<div class="form-group col-md-12">
						      	<label for="price"><?= !empty(lang('features'))?lang('features'):"Features";?></label>
						        <div class="features">
						        	<?php $i=1; foreach($permission_list as $row): ?>
						        		<?php if(isset($data['id'])): ?>
						        			<?php $p_id = json_decode($data['permission'],true); ?>
						        		<?php endif; ?>	
						        		<label class="custom-checkbox"><span><?= $i;?></span><input type="checkbox"  <?= isset($p_id) && is_array($p_id) && in_array($row['id'],$p_id)?"checked":'' ;?>  name="permission_id[]" value="<?= $row['id']?>"> &nbsp; &nbsp; <?= html_escape($row['title']); ?> </label>
						

						        	<?php $i++;  endforeach ?>
						        	
						        </div>
						    </div>
						</div>

					</div>

				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="pull-left">
						<input type="hidden" name="uid" value="<?= isset($data['uid']) && $data['uid'] !=0?$data['uid']:0 ?>">
						<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?$data['id']:0 ?>">
		          		<a href="<?= base_url('admin/restaurant/staff_list'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
		          	</div>
		          	<div class="pull-right">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-lg btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php $lang =  $this->config->load('messages_config')?>
<div class="row">
	<div class="col-md-6">
		<div class="single_alert alert alert-info alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<div class="d_flex_alert">
				<h4><i class="icon fas fa-question-circle"></i> <?= lang('info'); ?>!</h4>
				<div class="double_text">
					<div class="text-left">
						<p><?= $this->config->item('staff_password_msg');?></p>
						<p><?= $this->config->item('staff_password_change_msg');?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>