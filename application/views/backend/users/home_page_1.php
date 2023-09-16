<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('profile'))?lang('profile'):"Profile";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/auth/add_home') ?>" method="post" enctype= "multipart/form-data">
				<div class="box-body" >

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-12">
							<label><?= !empty(lang('title'))?lang('title'):"Title";?></label>
							<input type="text" name="title" class="form-control" placeholder="Your name / Title" value="<?= !empty($data['title'])?html_escape($data['title']):""; ?>">
						</div>
						<div class="rows">
							<div class="form-group col-md-6">
								<div class="left_label">
									<label><?= !empty(lang('institution'))?lang('institution'):"institution";?></label>
								</div>
								<input type="text" name="institution"  class="form-control" placeholder="Institution Name" value="<?= !empty($data['institution'])?html_escape($data['institution']):""; ?>">
							</div>
							<div class="form-group col-md-6">
								<div class="left_label">
									<label><?= !empty(lang('designation'))?lang('designation'):"Designation";?></label>
								</div>
								<input type="text" name="designation"  class="form-control" placeholder="Your designation" value="<?= !empty($data['designation'])?html_escape($data['designation']):""; ?>">
							</div>
						</div><!-- row -->
						<div class="rows">
							<div class="form-group col-md-6">
								<label><?= !empty(lang('whatsapp'))?lang('whatsapp'):"Whatsapp Number";?></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
									<input type="text" name="whatsapp"  class="form-control" placeholder="Whatsapp Number for share" value="<?= !empty($data['whatsapp'])?html_escape($data['whatsapp']):""; ?>">
								</div>
								
							</div>
							<div class="form-group col-md-6">
								<label><?= !empty(lang('email'))?lang('email'):"Email";?></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-envelope"></i></span>
								
									<input type="email" name="email"  class="form-control" placeholder="Email" value="<?= !empty($data['email'])?html_escape($data['email']):""; ?>">
								</div>
							</div>
						</div>

						<div class="rows">
							<div class="form-group col-md-6">
								<label><?= !empty(lang('phone'))?lang('phone'):"Phone";?></label>
								<div class="input-group">
					                <span class="input-group-addon"><i class="fas fa-phone"></i></span>
					               <input type="text" name="phone"  class="form-control" placeholder="Your Phone Number" value="<?= !empty($data['phone'])?html_escape($data['phone']):""; ?>">
					             </div>
								
							</div>
							<div class="form-group col-md-6">
								<label><?= !empty(lang('website'))?lang('website'):"website";?></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-globe"></i></span>
									<input type="text" name="website"  class="form-control" placeholder="Whatsapp Number for share" value="<?= !empty($data['website'])?html_escape($data['website']):""; ?>">
								</div>
								
							</div>
						</div>

						<div class="rows">
							<div class="form-group col-md-6">
								<label><?= !empty(lang('address'))?lang('address'):"address";?></label>
								<div class="input-group">
					                <span class="input-group-addon"><i class="far fa-address-card"></i></span>
					               <input type="text" name="address"  class="form-control" placeholder="Your address" value="<?= !empty($data['address'])?html_escape($data['address']):""; ?>">
					             </div>
								
							</div>
							<div class="form-group col-md-6">
								<label><?= !empty(lang('google_map_link'))?lang('google_map_link'):"google map link";?></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-map-marker-alt"></i></span>
									<input type="text" name="google_map"  class="form-control" placeholder="google map link" value="<?= !empty($data['google_map'])?html_escape($data['google_map']):""; ?>">
								</div>
								
							</div>
						</div>
					</div>

					<input type="hidden" name="id" value="<?= isset($data['id'])?$data['id']:0;?>">
				</div><!-- /.box-body -->
				<div class="box-footer" >
					<?php if(isset($data['id']) && $data['id'] !=0){ ?>
						<div class="pull-left">
							<a href="<?= base_url('admin/auth/home_profile'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
						</div>
					<?php } ?>
					<?php if(count($home) !=1 || (isset($data['id']) &&$data['id'] != 0)): ?>
					<div class="pull-right">
						<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
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
										<P class="c_black">[ <b>* Need add more social sites ]</b> <a href="" class="re_url">Click here</a></P>	
			                        </div>
			                        	
			                    </div>
			                </div>
			            </div>
						
					<?php endif ?>
				</div>
			</form>
		</div>
	</div>
	<div class="col-lg-6 col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('profile'))?lang('profile'):"Profile";?></h3>
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
									<th><?= !empty(lang('title'))?lang('title'):"title";?></th>
									<th><?= !empty(lang('institution'))?lang('institution'):"Institution";?></th>
									<th><?= !empty(lang('designation'))?lang('designation'):"designations";?></th>
									<th width="20%"><?= !empty(lang('social_sites'))?lang('social_sites'):"social sites";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($home as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td><?= html_escape($row['title']); ?></td>
										<td><?= html_escape($row['institution']); ?></td>
										<td><?= html_escape($row['designation']); ?></td>
										<td>
											<table class="table table-bordered">
												<?php if(!empty($row['email'])): ?>
													<tr>
														<td><i class="fa fa-envelope"></i></td>
														<td><?= $row['email'] ;?></td>
													</tr>
												<?php endif ?>

												<?php if(!empty($row['whatsapp'])): ?>
													<tr>
														<td><i class="fa fa-whatsapp"></i></td>
														<td><?= $row['whatsapp'] ;?></td>
													</tr>
												<?php endif ?>

												<?php if(!empty($row['phone'])): ?>
													<tr>
														<td><i class="fa fa-phone"></i></td>
														<td><?= $row['phone'] ;?></td>
													</tr>
												<?php endif ?>

												<?php if(!empty($row['website'])): ?>
													<tr>
														<td><i class="fa fa-globe"></i></td>
														<td><?= $row['website'] ;?></td>
													</tr>
												<?php endif ?>

												<?php if(!empty($row['address'])): ?>
													<tr>
														<td><i class="far fa-address-card"></i></td>
														<td><?= $row['address'] ;?></td>
													</tr>
												<?php endif ?>
												
											</table>
											
										</td>
										<td><a href="<?= base_url('admin/auth/edit_home/'.html_escape($row['id'])); ?>" class="btn btn-info"><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a></td>
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
