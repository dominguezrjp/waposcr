<div class="row">
	<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	<div class="col-md-6">
		<form class="email_setting_form" action="<?= base_url('admin/auth/add_tips_config') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<?= csrf() ;?>
			<div class="card">
				<div class="card-header">
					<h4><?= lang('tips'); ?></h4>
				</div>
				<div class="card-body">
					<?php $tips = isJson(restaurant()->tips_config)?json_decode(restaurant()->tips_config):''; ?>
					<?php $tips_config = isJson($tips->tips_fields)?json_decode($tips->tips_fields):''; ?>

					<div class="custom-control orderConfig custom-switch prefrence-item ml-10">
						<div class="gap">
							<input type="checkbox" id="is_tips" name="is_tips" class="switch-input "  <?= isset($tips->is_tips) && $tips->is_tips==1?"checked" : "" ;?>>

							<label for="is_tips" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

						</div>
						<div class="preText">
							<div class="">
								<label class="custom-control-label"><?= !empty(lang('tips'))?lang('tips'):'tip' ;?></label>
								<p class="text-muted"><small><?= !empty(lang('enable_to_allow'))?lang('enable_to_allow'):"Enable to allow "; ?></small></p>
							</div>
							<div class="float-right">
								<?= is_new('3.1.2');?>
							</div>
						</div>
					</div><!-- custom-control -->

					<br>

					<div class="row mt-10">
						<?php for ($i = 0; $i <=2 ; ++$i) { ?>
							<div class="col-md-4">
								<div class="form-group">
									<label><?= lang('set_tip_percent');?></label>
									<div class="input-group">
										<input type="text" name="tips[<?= $i;?>]" class="form-control only_number" value="<?= !empty($tips_config[$i]->tips)?$tips_config[$i]->tips:'';?>" placeholder="<?= lang('set_tip_percent');?>">
										<span class="input-group-addon">%</span>
									</div>
								</div>
							</div>
						<?php } ?>
						

					
					
						
				</div><!-- card-body -->
				<div class="card-footer">
					<input type="hidden" name="id" value="<?= !empty(restaurant()->id)?restaurant()->id :0;?>">
					<button type="submit" class="btn btn-secondary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</form>
	</div><!-- col-9 -->
	
</div>














