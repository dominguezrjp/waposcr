<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('about_me'))?lang('about_me'):"About Me";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/auth/add_about') ?>" method="post" class="skill_form" enctype= "multipart/form-data">
				<div class="box-body" >

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
					<div class="mt-15">
						<div class="form-group about_me_group">
							<div class="left_label">
								<label><?= !empty(lang('full_name'))?lang('full_name'):"Full Name";?></label>
							</div>
							<input type="text" name="full_name" id="name" class="form-control" placeholder="<?= !empty(lang('full_name'))?lang('full_name'):"Full Name";?>" value="<?= isset($data[0]['full_name']) && !empty(html_escape($data[0]['full_name']))?html_escape($data[0]['full_name']):set_value('full_name'); ?>">
						</div>
						<div class="form-group about_me_group">
							<div class="left_label">
								<label><?= !empty(lang('nationality'))?lang('nationality'):"Nationality";?></label>
							</div>
							<input type="text" name="nationality" id="name" class="form-control" placeholder="<?= !empty(lang('nationality'))?lang('nationality'):"Nationality";?>" value="<?= isset($data[0]['nationality']) && !empty(html_escape($data[0]['nationality']))?html_escape($data[0]['nationality']):set_value('nationality'); ?>">
						</div>

						<div class="form-group about_me_group">
							<div class="left_label">
								<label><?= !empty(lang('video_link'))?lang('video_link'):"Video link";?></label>
							</div>
							<input type="text" name="video_link" class="form-control" placeholder="<?= !empty(lang('youtube_embeded_link'))?lang('youtube_embeded_link'):"Youtube embeded link";?>" value="<?= isset($data[0]['video_link']) && !empty(html_escape($data[0]['video_link']))?html_escape($data[0]['video_link']):set_value('video_link'); ?>">
						</div>
						<div class="form-group about_me_group">
							<div class="left_label">
								<label><?= !empty(lang('about_me'))?lang('about_me'):"About Me";?></label>
							</div>
							<textarea name="about_me" class="form-control textarea" cols="20" rows="20" placeholder="About yourself"><?= isset($data[0]['about_me']) && !empty($data[0]['about_me'])?$data[0]['about_me']:set_value('about_me'); ?></textarea>
						</div>

						<div class="form-group about_me_group">
							<div class="left_label">
								<label><?= !empty(lang('dob'))?lang('dob'):"Date of Birth";?></label>
							</div>
							<div class="input-group date">
			                   <input type="text" name="dob" id="dob" class="form-control datepicker" placeholder="yyyy-mm-dd" value="<?= isset($data[0]['dob']) && !empty(html_escape($data[0]['dob']))?html_escape($data[0]['dob']):set_value('dob'); ?>">
			                   <div class="input-group-addon">
			                    	<i class="fa fa-calendar"></i>
			                  	</div>
			                </div>

						</div>
						<?php if(isset($data[0]['id'])): ?>
							<?php foreach ($data[0]['about_content'] as $value): ?>
								<label>Add Your custom fields</label>
								<div class="form-group about_me_group">
									<input type="text" name="label_ex[]" id="name" class="form-control mr-10" value="<?= html_escape($value['label']);?>" placeholder="<?= !empty(lang('label'))?lang('label'):"label";?>">
									<input type="text" name="value_ex[]" id="value" class="form-control " value="<?= html_escape($value['value']);?>" placeholder="<?= !empty(lang('value'))?lang('value'):"value";?>">
								</div>
								<input type="hidden" name="ex_id[]" value="<?= $value['id']!=0?$value['id']:0; ?>">
							<?php endforeach ?>
						<?php else: ?>
							<label>Add Your custom fields</label>
							<div class="form-group about_me_group">
								<input type="text" name="label[]" id="name" class="form-control mr-10" placeholder="<?= !empty(lang('title'))?lang('title'):"title";?>">

								<input type="text" name="value[]" id="value" class="form-control " placeholder="<?= !empty(lang('value'))?lang('value'):"value";?>">
							</div>
						<?php endif ?>
							<div class="input_fields_wrap"></div>
							<div class="pull-right">
								<a href="javascript:;"  class="label label-info add_field_button"><i class="fa fa-plus"></i> &nbsp;<?= !empty(lang('add_new'))?lang('add_new'):"Add New";?></a>
							</div>
					</div>
				    <input type="hidden" name="id" value="<?= isset($data[0]['id'])?$data[0]['id']:0;?>">
				</div><!-- /.box-body -->
				<div class="box-footer" >
					<?php if(isset($data[0]['id']) && $data[0]['id'] !=0){ ?>
						<div class="pull-left">
			          			<a href="<?= base_url('admin/auth/about'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
			          	</div>
			          <?php } ?>

		          	<?php if(count($home) !=1 || (isset($data[0]['id']) && $data[0]['id'] != 0)): ?>
						<div class="pull-right">
							<button type="submit" name="register" class="btn btn-primary btn-block btn-flat c_btn"><?= !empty(lang('submit'))?lang('submit'):"submit";?> </button>
						</div>
					<?php else: ?>
						<div class="single_alert alert alert-info alert-dismissible">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			                <div class="d_flex_alert ">
			                    <h4><i class="fas fa-exclamation-triangle"></i> Info!</h4>
			                    <div class="double_text">
			                        <div class="text-left">
			                            <h5>You are already added your information</h5>
			                            <p >Now you can edit/update your information</p>
										<p><b>*Information can be added only one per user</b></p>
			                        </div>
			                        
			                    </div>
			                </div>
			            </div>
					<?php endif ?>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('upload_cv'))?lang('upload_cv'):"Upload Documents";?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body" >
					<div class="user_profile_pdf">
						<form action="<?= base_url('admin/auth/upload_cv'); ?>" class="upload_pdf" method="post" enctype= "multipart/form-data"> 
							<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

							<label title="upload_pdf" class="upload_label">
								<?php if(empty($this->my_info['documents'])): ?>
									<div class="up_pdf">
										<i class="fa fa-upload"></i>
										<p>Upload Pdf</p>
									</div>
									<?php else: ?>
										<div class="uploaded_pdf">
											<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
											<h4>Upload Pdf </h4>
											<h6>Pdf already Uploaded. Click upload again</h6>
										</div>
								<?php endif ?>
								<input type="file" name="file" style="display: none;" accept="application/pdf, application/msword">
							</label>

						</form>
						<div class="img_progress" style="width: 100%;">
							<div class="pdf_upload_progress" style="display: none;">
								<div class="progress">
									<div class="progress-bar progress-bar-success progress-bar-striped myprogress" role="progressbar" style="width:0%">0%</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div>
		</div>
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('about_me'))?lang('about_me'):"about me";?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body" >
					<div class="upcoming_events">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
										<th><?= !empty(lang('name'))?lang('name'):"name";?></th>
										<th><?= !empty(lang('nationality'))?lang('nationality'):"nationality";?></th>
										<th><?= !empty(lang('content'))?lang('content'):"content";?></th>
										<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; foreach ($home as $row): ?>
										<tr>
											<td><?= $i;?></td>
											<td><?= html_escape($row['full_name']); ?></td>
											<td><?= html_escape($row['nationality']); ?></td>
											<td>
												<?php if(isset($row['about_content']) && count($row['about_content']) > 0): ?>
													<table class="table table-bordered">
														<?php foreach ($row['about_content'] as $value): ?>
														<tr>
															<td><?= $value['label']?></td>
															<td><?= $value['value']?></td>
															<td><a href="javascript:;" data-id="<?= html_escape($value['id']);?>" data-status="<?= html_escape($value['status']);?>" data-table="about_content" class="label <?= $value['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $value['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $value['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a></td>
														</tr>
														<?php endforeach ?>
													</table>
												<?php else: ?>
													<p>Empty</p>
												<?php endif;?>
											</td>
											<td><a href="<?= base_url('admin/auth/edit_about/'.html_escape($row['id'])); ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a></td>
										</tr>
									<?php $i++; endforeach ?>
								</tbody>
							</table>
						</div>
					</div>	
				</div><!-- /.box-body -->
			</div>
		</div>
	</div>
</div>
