<div class="row">
	<div class="col-md-8">
		<div class="card mt-4">
			<div class="card-header border-0">
				<h3 class="card-title">App Info</h3>
			</div>
			<div class="card-body p-0">

				<div class="d-flex justify-content-between align-items-center border-bottom  single_app_info">
					<p class="text-md font-weight-bold">
						<i class="icofont-code-alt fz-20 mr-5 c-primary"></i> <?= lang('version');?>
					</p>
					<p class="d-flex flex-column text-right">
						<span class="badge bg-primary-soft text-md badge-pill"><?= $settings['version'];?></span>
					</p>
				</div>

				<div class="d-flex justify-content-between align-items-center border-bottom  single_app_info">
					<p class="text-md font-weight-bold">
						<i class="icofont-book-alt fz-20 mr-5 c-primary"></i> <?= lang('documentation');?>
					</p>
					<p class="d-flex flex-column text-right fz-16">
						<a target="_blank" href="https://phplime-envato.gitbook.io/qrexorder/">QrexOrder <?= lang('documentation');?></a>
					</p>
				</div>

				<?php if(is_demo()==0): ?>
					<?php if(!auth('is_staff')): ?>
						<div class="d-flex justify-content-between align-items-center border-bottom  single_app_info">
							<p class="text-md font-weight-bold">
								<i class="icofont-key fz-20 mr-5 c-primary"></i> Purchase Code
							</p>
							<p class="d-flex flex-column text-right">
								<span class="label label-default fz-16"><?= $settings['purchase_code'];?></span>
							</p>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<div class="d-flex justify-content-between align-items-center border-bottom single_app_info">
					<p class="text-md font-weight-bold">
						<i class="icofont-live-support fz-20 mr-5 c-primary"></i> Support
					</p>
					<p class="d-flex flex-column text-right">
						<span class="text-primary">phplime.envato@gmail.com</span>
						<span class="text-muted">Please mention purchase code with your support mail.</span>
					</p>
				</div>


			</div>
			<div class="card-footer">
				<a href="<?= base_url('admin/dashboard/backup_db') ?>" class="btn btn-lg btn-block btn-secondary action_btn" data-msg="">
			 		<i class="fa fa-upload"></i> <span><?= !empty(lang('backup_database'))?lang('backup_database'):"Backup Database";?></span>
			 	</a>
							
			</div>
		</div>
	</div>
</div>