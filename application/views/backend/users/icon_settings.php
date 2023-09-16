<div class="row">
	<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	<div class="col-md-6">
		<form class="email_setting_form" action="<?= base_url('admin/auth/add_icon_settings') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<?= csrf() ;?>
		<?php $icon = json_decode($settings['icon_settings']); ?>
			<div class="card">
				<div class="card-header">
					<h4><?= !empty(lang('icon_settings'))?lang('icon_settings'):"Icon Settings";?></h4>
				</div>
				<div class="card-body">
					<table class="table">
						<thead>
							<tr>
								<th><?= lang('sl'); ?></th>
								<th><?= lang('icon'); ?></th>
								<th><?= lang('title'); ?></th>
								<th><?= lang('image_url'); ?></th>
								<th><?= lang(''); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php for ($i=1; $i <=3 ; $i++) {  ?>
							<?php $j= $i-1; ?>
							<tr>
								<td><?= $i;?></td>
								<td>
									<div class="">
										<button class="btn btn-default picker" data-icon='<?= !empty($icon[$j]->icon)?get_icon($icon[$j]->icon):'';?>' data-id="<?= $i;?>"   role="iconpicker"></button>

										<input type="hidden" name="icon[]" class="icon_<?= $i;?>" value='<?= !empty($icon[$j]->icon)?$icon[$j]->icon:'';?>'>
									</div>
								</td>
								<td>
									<input type="text" name="title[]"  class="form-control" placeholder="<?= !empty(lang('title'))?lang('title'):"title";?>" value="<?= !empty($icon[$j]->title)?$icon[$j]->title:'';?>" required>
								</td>
								
								<td>
									 <input type="text" name="img_url[]" i class="form-control" placeholder="<?= !empty(lang('img_url'))?lang('img_url'):"img_url";?>" value="<?= !empty($icon[$j]->img_url)?$icon[$j]->img_url:'';?>" >
								</td>
								<td>
									<label class="pointer mr-10 bg-primary-soft label"><input type="checkbox" name="is_img_<?= $i ;?>"  class="" value="1" <?= isset($icon[$j]->is_img) && $icon[$j]->is_img==1?"checked":"" ;?>> <?= lang('active_image'); ?></label>
									
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					
						
				</div><!-- card-body -->
				<div class="card-footer">
					<input type="hidden" name="id" value="<?= isset($settings['id']) && $settings['id'] !=0?$settings['id']:0 ?>">
					<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</form>
	</div><!-- col-9 -->
	
</div>