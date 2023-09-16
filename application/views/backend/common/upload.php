<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= ucfirst(lnng('upload_images'));?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class=" box-body mt-15">
				<form action="<?= base_url('admin/profile/add_portfolio') ?>" method="post" enctype="multipart/form-data" id="">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="col-md-12">
						<input type="file" accept="image/*" class="info_file image_upload" name="file[]" multiple  />
					</div>

					<div class="col-md-4 mt-15">
						<select name="type_id" id="" class="form-control" required="">
							<option value=""><?= !empty(lang('select'))?lang('select'):"select";?></option>
							<?php foreach ($portfolio_type as $value): ?>
								<option value="<?= $value['id'];?>"><?= html_escape($value['name']);?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-md-12 ">
				    	<div class="img_progress">
					        <div class="show_progress"style="display: none;">
					            <div class="progress">
					               <div class="progress-bar progress-bar-success progress-bar-striped myprogress" role="progressbar" style="width:0%">0%</div>
					        	</div>
					        </div>
					    </div>
				    </div>

					<div class="col-md-12">
						<div class="post_btn">
							<button type="submit" name="submit" class="btn btn-default custom_btn"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div id="grid_view" class="grid_4">
			<?php foreach ($portfolio as $img): ?>
				<div class="item" id="hide_image_<?= html_escape($img['id']);?>">
					<div class="single_image ">
						<img src="<?= base_url(html_escape($img['thumb'])); ?>" alt="">
						<a href="javascript:;" class="img_delete" data-id="<?= html_escape($img['id']);?>"><i class="fa fa-trash"></i></a>
					</div>
				</div>	
			<?php endforeach ?>
		</div>
	</div>
</div>