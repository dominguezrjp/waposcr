<?php include "inc/pos_menu.php";?>
<div class="row">
	<div class="col-md-6">
		<form action="<?= base_url("admin/pos/pos_settings");?>" method="post">
			<?= csrf();?>
			<div class="card">
				<div class="card-header"><h4><?= lang('settings');?></h4></div>
				<div class="card-body">
					<div class="form-group">
						<label><?= lang('order_types');?></label>
						<div class="PosOrderType">
							<?php $jsonTypes = !empty($orderJson->order_types)?json_decode($orderJson->order_types,true):''; ?>
							<?php $arr = ['pay-in-cash','booking']; ?>
							<?php foreach ($order_types as $types): ?>
								<?php if(!in_array($types['slug'],$arr)): ?>
									<li><label class="custom-checkbox"><input type="checkbox" name="is_pos[<?= $types['slug'];?>]" value="1" <?= isset($jsonTypes[$types['slug']]) && $jsonTypes[$types['slug']]==1?"checked":"";?>> <?= !empty($types['type_name'])?$types['type_name']:'' ;?></label></li>
									<input type="hidden" name="ids[]" value="<?= $types['id'];?>">
								<?php endif ?>
							<?php endforeach ?>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label><?= lang('enable_buttons');?></label>
						<div class="form-group ">
							<h5><u><?= lang('enable_live_order_buttons');?></u></h5>
							<div class="PosOrderType">
								<li><label class="custom-radio-2"><input type="radio" name="is_live_order" value="1" <?= !empty(pos_config(restaurant()->id)->is_live_order) && pos_config(restaurant()->id)->is_live_order==1?"checked":"";?>> <?= lang('set_as_default');?></label></li>
								<li><label class="custom-radio-2"><input type="radio" name="is_live_order" value="2" <?= !empty(pos_config(restaurant()->id)->is_live_order) && pos_config(restaurant()->id)->is_live_order==2?"checked":"";?>> <?= lang('show_live_order_button');?></label></li>
							</div>
						</div>
						<div class="PosOrderType">
							<li><label class="custom-checkbox"><input type="checkbox" name="is_completed" value="1" <?= !empty(pos_config(restaurant()->id)->is_completed) && pos_config(restaurant()->id)->is_completed==1?"checked":"";?>><?= lang('mark_as_completed');?></label></li>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="form-group col-md-6">
							<label ><?= lang('pos_print_size');?></label>
							<div class="input-group">

								<input type="number" name="print_size" class="form-control" value="<?= !empty(pos_config(restaurant()->id)->print_size)? pos_config(restaurant()->id)->print_size:"79";?>">
								<span class="input-group-addon">mm</span>
							</div>
						</div>

						<div class="form-group col-md-6">
							<label ><?= lang('pos_print_size');?></label>
							<div class="input-group">
								
								<input type="number" name="font_size" class="form-control" value="<?= !empty(pos_config(restaurant()->id)->font_size)? pos_config(restaurant()->id)->font_size:"14";?>">
								<span class="input-group-addon">px</span>
							</div>
						</div>

						<div class="form-group col-md-12">
							<label ><?= lang('welcome_message');?></label>
							<textarea name="welcome_message" class="form-control" id="welcome_message"><?= !empty(pos_config(restaurant()->id)->welcome_message)? pos_config(restaurant()->id)->welcome_message:"";?></textarea>
						</div>
					</div>
				</div><!-- card-body -->
				<div class="card-footer text-right">
					<div class="pull-left">
						<a href="<?= base_url("dashboard");?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> <?= lang('back');?></a>
					</div>
					<input type="hidden" name="id" value="<?= isset($u_settings['id'])?$u_settings['id']:0;?>">
					<button class="btn btn-secondary"><?= lang('submit');?></button>
				</div>
			</div><!-- card -->
		</form>
	</div>
</div>