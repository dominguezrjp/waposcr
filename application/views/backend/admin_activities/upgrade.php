<div class="row justify-content-center">
	<div class="col-md-6 col-md-offset-3">
		<?php if(LICENSE==MY_LICENSE): ?>
			<div class="single_alert alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<div class="d_flex_alert">
					<h4><i class="far fa-smile"></i> Thank you!</h4>
					<div class="double_text">
						<div class="text-left">
							<h5>Welcome to <?= $this->settings['site_name'];?></h5>
							<p>You are using Extended license</b></p>	
						</div>
					</div>
				</div>
			</div>
		<?php else: ?>
		<div class="single_alert alert alert-info alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<div class="d_flex_alert">
				<h4><i class="far fa-smile"></i> Info!</h4>
				<div class="double_text">
					<div class="text-left">
						<h5>Welcome to <?= $this->settings['site_name'];?></h5>
						<p>If you want to upgrade from Regular license to <b>Extended license</b></p>
						<p>Set you extended license code here.</p>
					</div>
				</div>
			</div>
		</div>

		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('upgrade'))?lang('upgrade'):"Updrade";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/dashboard/apply_upgrade') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="heading"><?= !empty(lang('old_purchase_code'))?lang('old_purchase_code'):"old purchase code";?></label>
					        <input type="text" name="old_code" id="title" class="form-control" placeholder="<?= !empty(lang('old_purchase_code'))?lang('old_purchase_code'):"old purchase code";?>" value="<?= !empty($settings['purchase_code'])?html_escape($settings['purchase_code']):""; ?>" readonly>
					    </div>

					    <div class="form-group col-md-12">
					      	<label for="price"><?= !empty(lang('new_purchase_code'))?lang('new_purchase_code'):"New Purchase code";?></label>
					        <input type="text" name="purchase_code" id="title" class="form-control" placeholder="<?= !empty(lang('new_purchase_code'))?lang('new_purchase_code'):"New Purchase code";?>" value="">
					    </div>

					</div>
				    <input type="hidden" name="id" value="<?= isset($settings['id']) && $settings['id']!=0?$settings['id']:0 ?>">
				</div><!-- /.box-body -->
				<div class="box-footer">
					<?php if(isset($settings['id']) && $settings['id'] !=0){ ?>
						<div class="pull-left">
			          		<a href="<?= base_url('admin/dashboard/'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
			          	</div>
		          <?php } ?>
		          	<div class="pull-right">
		          		<input type="hidden" name="site_id" value="<?= $settings['site_id'] ;?>">
		          		<input type="hidden" name="site_url" value="<?= $settings['site_url'] ;?>">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
		<?php endif; ?>
	</div>

</div>


