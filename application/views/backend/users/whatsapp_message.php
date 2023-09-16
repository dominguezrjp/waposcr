<div class="row">
	<div class="col-md-5">
		<?php $msg = isJson($restaurant['whatsapp_message_config'])?json_decode($restaurant['whatsapp_message_config']):''; ?>
		<form action="<?= base_url("admin/auth/add_whatsapp_message_config");?>" method="post">
			<?= csrf();?>
			<div class="card">
				<div class="card-header"><h3 class="title"><?= lang('whatsapp_message_for_order_status');?></h3></div>
				<div class="card-body">
					<div class="form-group">
						<select name="msg_id_type" class="form-control">
							<option value="ultramsg" <?= isset($msg->msg_id_type) && !empty($msg->msg_id_type) && $msg->msg_id_type=="ultramsg"?"selected":'';?> >ultramsg</option>
							<option value="wasendo" <?= isset($msg->msg_id_type) && !empty($msg->msg_id_type) && $msg->msg_id_type=="wasendo"?"selected":'';?> >Wasendo</option>
						</select>
					</div>

					<div class="form-group">
						<label for=""><?= lang('instance_id');?></label>
						<input type="text" name="instance_id" class="form-control" value="<?= !empty($msg->instance_id)?$msg->instance_id:'';?>" placeholder="<?= lang('instance_id');?>">
					</div>
					<div class="form-group">
						<label for=""><?= lang('token');?></label>
						<input type="text" name="token" class="form-control" value="<?= !empty($msg->token)?$msg->token:'';?>" placeholder="<?= lang('token');?>">
					</div>
					<hr>
					<div class="whatsappMessageArea">
						<div class="form-group mt-10">
							<label class="custom-checkbox"><input type="checkbox" class="msgCheckbox" data-id="accept_msg" name="is_accept" value="1" <?= isset($msg->is_accept) && $msg->is_accept==1?"checked":'';?>><?= lang('accept_message');?></label>
							<div class="mb-5">
								<code>{CUSTOMER_NAME}, {ORDER_ID}, {SHOP_NAME}, {TRACK_URL}</code>
							</div>
							<div class="accept_msg <?= isset($msg->is_accept) && $msg->is_accept==1?"":'dis_none';?>">
								<textarea name="accept_msg" id="accept_msg" class="form-control" cols="5" rows="5"><?= !empty($msg->accept_msg)?json_decode($msg->accept_msg):'';?></textarea>
							</div>
						</div>

						<div class="form-group mt-10">
							<label class="custom-checkbox"><input type="checkbox" class="msgCheckbox" data-id="complete_msg" name="is_completed" value="1" <?= isset($msg->is_completed) && $msg->is_completed==1?"checked":'';?>><?= lang('completed_message');?></label>
							<div class="mb-5">
								<code>{CUSTOMER_NAME}, {ORDER_ID}, {SHOP_NAME}, {TRACK_URL}</code>
							</div>
							<div class="complete_msg <?= isset($msg->is_completed) && $msg->is_completed==1?"":'dis_none';?>">
								<textarea name="complete_msg" id="complete_msg" class="form-control" cols="5" rows="5"><?= !empty($msg->complete_msg)?json_decode($msg->complete_msg):'';?></textarea>
							</div>
						</div>

						<div class="form-group mt-10">
							<label class="custom-checkbox"><input type="checkbox" class="msgCheckbox" data-id="cancled_msg" name="is_cancled" value="1" <?= isset($msg->is_cancled) && $msg->is_cancled==1?"checked":'';?>><?= lang('canceled_message');?></label>
							<div class="mb-5">
								<code>{CUSTOMER_NAME}, {ORDER_ID}, {SHOP_NAME}, {TRACK_URL}</code>
							</div>
							<div class="cancled_msg <?= isset($msg->is_cancled) && $msg->is_cancled==1?"":'dis_none';?>">
								<textarea name="cancled_msg" id="cancled_msg" class="form-control" cols="5" rows="5"><?= !empty($msg->cancled_msg)?json_decode($msg->cancled_msg):'';?></textarea>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group ">
						<label><?= lang('enable_whatsapp_for_order');?></label>
						<div class="orderTypes mt-10">
							<?php $enable_for = !empty($msg->whatsapp_enable_for)?json_decode($msg->whatsapp_enable_for,true):'' ?>
							<?php foreach ($order_types as $value): ?>
								<label class="custom-checkbox"><input type="checkbox" name="whatsapp_for[<?= $value['slug'];?>]" value="1" <?= isset($enable_for[$value['slug']]) && $enable_for[$value['slug']]==1?"checked":"";?>> <?= $value['type_name'];?></label>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="form-group">
						<label >Status</label>
						<div class="mt-5">
							<label class="custom-radio mr-5">
								<input type="radio" name="status" value="1" <?= isset($msg->status) && $msg->status==1?"checked":'';?>> <?= lang("enable")?>
							</label>

							<label  class="custom-radio">
								<input type="radio" name="status" value="0" <?= isset($msg->status) && $msg->status==0?"checked":'';?>> <?= lang("disabled")?>
							</label>
						</div>
					</div>
				</div>
				<div class="card-footer text-right">
					<input type="hidden" name="id" value="<?= isset($restaurant['id'])?html_escape($restaurant['id']):0; ?>">
					<button type="submit" class="btn btn-secondary"><i class="fa fa-save"></i> <?= lang('save_change');?></button>
				</div>
			</div>
		</form>
	</div>
</div>



<script>
	$(document).on("click",".msgCheckbox",function(){
		let checkName = $(this).data('id');
		if($(this).is(':checked')){
			$(`.${checkName}`).slideDown();
			console.log(checkName);
		}else{
			$(`.${checkName}`).slideUp();
		}
	})
</script>



