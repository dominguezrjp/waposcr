<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header"> <h5 class="card-title"> <?= lang('notifications');?> </h5></div>
			<div class="card-body p-0">
				<div class="card-content">
					<ul class="ul myNotifications">
						<?php foreach ($notification_list as $key => $row): ?>
							<?php $check = $this->admin_m->check_unseen_by_notify_id($row['notification_id']); ?>
							<a href="#notifyModal_<?= $row['send_notify_id'] ;?>" data-toggle="modal" class="<?= $row['seen_status']==0?"active":"";?>">
								<div class="singleNotification">
									<div class="singleTopNotification">
										<div class="notifyleftIcon">
											<i class="fa fa-bell"></i>
										</div>
										<div class="NotificationContent">
											<h4><?= $row['title'] ;?></h4>
											<p><?= $row['send_at'];?></p>
										</div>
									</div>
									<div class="notifyleftIcon">
										<i class="icofont-thin-right"></i>
									</div>
								</div>
							</a>
						<?php endforeach ?>
					</ul>
				</div><!-- card-content -->
			</div><!-- card-body -->
		</div><!-- card -->		
	</div>
</div>

<?php foreach ($notification_list as $key => $notify): ?>
<div class="modal fade" id="notifyModal_<?= $notify['send_notify_id'] ;?>">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?= $notify['title'];?></h4>
			</div>
			<div class="modal-body">
				<?= $notify['details'];?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close');?></button>
				<?php if($notify['seen_status']==0): ?>
					<a href="<?= base_url("admin/notify/seen_status/{$notify['send_notify_id']}/1");?>" class="btn btn-success"><?= lang('mark_as_read');?></a>
				<?php else: ?>
					<a href="<?= base_url("admin/notify/seen_status/{$notify['send_notify_id']}/0");?>" class="btn btn-success"><?= lang('mark_as_unread');?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>