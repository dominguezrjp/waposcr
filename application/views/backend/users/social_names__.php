<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('social_sites'))?lang('social_sites'):"social sites";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<form action="<?= base_url('admin/auth/add_social_sites') ?>" method="post" >
				<div class="box-body" >

					<!-- csrf token -->
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

					<div class="row">
						<div class="form-group col-md-6">
					      	<label><?= !empty(lang('name'))?lang('name'):"name";?></label>
					        <input type="text" name="name" class="form-control" placeholder="<?= !empty(lang('name'))?lang('name'):"Name";?>" value="<?= isset($data['name'])?html_escape($data['name']):""; ?>">
					    </div>
					    <div class="form-group col-md-6">
					      	<label><?= !empty(lang('type'))?lang('type'):"type";?></label>
					        <select name="type" class="form-control">
					        	<option value="">Select Type</option>
					        	<option value="email" <?= !empty($data['type']) && $data['type']=="email"?"selected":""; ?>>Email</option>
					        	<option value="phone" <?= !empty($data['type']) && $data['type']=="phone"?"selected":""; ?>>Phone</option>
					        	<option value="whatsapp" <?= !empty($data['type']) && $data['type']=="whatsapp"?"selected":""; ?>>Whatsapp</option>
					        	<option value="others" <?= !empty($data['type']) && $data['type']=="others"?"selected":""; ?>>Others</option>
					        </select>
					    </div>

					    <div class="rows">
					    	<div class="form-group col-md-6">
						      	<label><?= !empty(lang('icon'))?lang('icon'):"icon";?></label>
						        <input type="text" name="icon" class="form-control" placeholder='<i class"fa fa-icon"></i>' value='<?= isset($data['icon'])?$data['icon']:""; ?>'>
						    </div>
						    <div class="form-group col-md-6">
						      	<label><?= !empty(lang('link'))?lang('link'):"link";?></label>
						        <input type="text" name="link" class="form-control" placeholder='Site link' value='<?= isset($data['link'])?$data['link']:""; ?>'>
						    </div>
					    </div>
					   
					</div>

				    <input type="hidden" name="id" value="<?= isset($data['id']) && $data['id']!=0? $data['id']:0; ?>">
				</div><!-- /.box-body -->
				<div class="box-footer" >
					<?php if(isset($data['id']) && $data['id']!=0): ?>
						<div class="pull-left">
			          			<a href="<?= base_url('admin/auth/social_sites'); ?>" class="btn btn-default btn-block btn-flat"><?= !empty(lang('cancel'))?lang('cancel'):"cancel";?></a>
			          	</div>
		          	<?php endif;?>
		          	<div class="pull-right">
		          		<button type="submit" class="btn btn-primary btn-block btn-flat c_btn"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
		          	</div>
				</div>
			</form>
		</div>
		<?php $limit = 10; ?>
		<?php if(count($social_sites) > $limit): ?>
			<div class="single_alert alert alert-danger alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <div class="d_flex_alert ">
	                <h4> <i class="fas fa-exclamation-triangle"></i> Alert!</h4>
	                <div class="double_text">
	                    <div class="text-left">
	                        <h5><i class="fas fa-frown"></i> Sorry!</h5>
	                        <p>You reached the maximum limit <?= $limit ;?></p>
	                    </div>
	                    	
	                </div>
	            </div>
	        </div>
        <?php else: ?>
        	<div class="single_alert alert alert-info alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <div class="d_flex_alert ">
	                <h4><i class="fas fa-exclamation-triangle"></i> Info!</h4>
	                <div class="double_text">
	                    <div class="text-left">
	                        <h5>You can add <b class="underline"> <?=  count($social_sites);?>/<?=  $limit;?> </b> sites</h5>
	                    </div>
	                    	
	                </div>
	            </div>
	        </div>
        <?php endif;?>
	</div>
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('social_sites'))?lang('social_sites'):"Social sites";?></h3>
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
									<th><?= !empty(lang('type'))?lang('type'):"type";?></th>
									<th><?= !empty(lang('icon'))?lang('icon'):"icon";?></th>
									<th><?= !empty(lang('link'))?lang('link'):"link";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"status";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"action";?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; foreach ($social_sites as $row): ?>
									<tr>
										<td><?= $i;?></td>
										<td><?= html_escape($row['name']) ?></td>
										<td><?= html_escape($row['type']) ?></td>
										<td><?= $row['icon'] ?></td>
										<td><?= character_limiter($row['link'],20) ?></td>
										<td>
											<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="social_sites" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
										</td>
										<td><a href="<?= base_url('admin/auth/edit_social/'.html_escape($row['id'])); ?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>
											<a href="<?= base_url('admin/dashboard/item_delete/'.html_escape($row['id']).'/social_sites '); ?>" class="btn btn-danger"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>
										</td>
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
