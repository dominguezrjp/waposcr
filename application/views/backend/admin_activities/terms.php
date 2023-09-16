<div class="row">
	<div class="col-md-7">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('terms_condition'))?lang('terms_condition'):"terms & condition	";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/dashboard/add_terms') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body">

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
					      	<label for="heading"><?= !empty(lang('title'))?lang('title'):"title";?></label>
					        <input type="text" name="title" id="title" class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"package / pricing";?>" value="<?= !empty($data['title'])?html_escape($data['title']):set_value('title'); ?>">
					    </div>

					    <div class="form-group col-md-12">
					      	<label for="price"><?= !empty(lang('details'))?lang('details'):"details";?></label>
					        <textarea name="details" id="" class="form-control textarea" cols="30" rows="10"><?= !empty($data['details'])?$data['details']:set_value('details'); ?></textarea>
					    </div>

					   <div class="form-group col-md-12">
				      	<label><?= !empty(lang('status'))?lang('status'):"status";?></label>
			      		<div class="">
				      		<label class="text_direction custom-radio"><input type="radio" class="" name="status" value="1" <?=  isset($data['status']) && html_escape($data['status'])=="1"?"checked":''; ?> checked> &nbsp;<?= !empty(lang('live'))?lang('live'):"live";?></label> &nbsp;&nbsp;
				      		<label class="text_direction custom-radio"><input type="radio" class="" name="status" value="0" <?= isset($data['status']) &&  html_escape($data['status'])=="0"?"checked":''; ?>> &nbsp;<?= !empty(lang('hide'))?lang('hide'):"hide";?></label>
				      		&nbsp;&nbsp;
				      		
			      		</div>
			     	 </div>


					</div>
				    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id']!=0?$data['id']:0 ?>">
				</div><!-- /.box-body -->
				<div class="box-footer">
					<?php if(isset($data['id']) && $data['id'] !=0){ ?>
						<div class="pull-left">
			          		<a href="<?= base_url('admin/dashboard/faq'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
			          	</div>
		          <?php } ?>
		          	<div class="pull-right">
		          		<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
		
	</div>

</div>


