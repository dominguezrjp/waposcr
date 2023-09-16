<div class="row">
	<?php include APPPATH."views/backend/dashboard/admin_inc/alert_info.php"; ?>
</div>


<?php if(USER_ROLE ==1): ?>
	<?php include 'inc/admin_info.php'; ?>
<?php endif; ?>



<?php include "inc/users_info.php"; ?>


<div class="modal fade" id="notificationModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?= lang('send_notification'); ?></h4>
			</div>
			<form action="<?= base_url("admin/notify/send?action=admin"); ?>" method="POST">
				<?=  csrf();?>
				<div class="modal-body">
					<div class="form-group">
						<label>	<?= lang('notification_list'); ?></label>
						<select name="notification_id" id="notify_id" class="form-control">
							<option value=""><?= lang('select_notification');?></option>
							<?php foreach ($notification_list as $key => $notify): ?>
								<option value="<?= $notify['id'];?>"><?= $notify['title'];?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<input type="hidden" name="restaurant_id[]" value="<?=  $restaurant['id'];?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close');?></button>
					<button type="submit" class="btn btn-primary"><?= lang('send');?></button>
				</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="usernameModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?= lang('username'); ?></h4>
			</div>
			<form action="<?= base_url("admin/auth/change_username"); ?>" method="POST">
				<?=  csrf();?>
				<div class="modal-body">
					<div class="form-group">
						<label>	<?= lang('username'); ?></label>
						<input type="text" name="username" id="username" class="form-control" value="<?=  $auth_info['username'];?>">
						<span class="alert_msg mt-5"></span>
					</div>
					<input type="hidden" name="id" value="<?=  $auth_info['id'];?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close');?></button>
					<button type="submit" class="btn btn-primary reg_btn" disabled><?= lang('save_change');?></button>
				</div>
			</form>
		</div>
	</div>
</div>