<div class="row">
	<div class="col-md-7">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Active Your Site</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/dashboard/active_site') ?>" method="post" class="" enctype= "multipart/form-data">
				<div class="box-body">
					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<?php $settings = settings();
					 ?>
						
					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="heading">Enter item purchases code</label>
					        <input type="text" name="code" class="form-control" placeholder="Enter item purchases code here.">
					    </div>
					   
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
		          	<div class="pull-right">
		          		<input type="hidden" name="site_id" value="<?= isset($settings['site_id'])?$settings['site_id']:0;?>">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
		          	<div class="w-100">
		          		<p>If you not find purchase code <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="blank"> <b>Click here</b></a></p>
		          	</div>
				</div>
			</form>
		</div>
		
	</div>
</div>


