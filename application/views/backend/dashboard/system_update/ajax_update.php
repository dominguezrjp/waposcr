<?php if(isset($st)): ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">New Version Available v<?= NEW_VERSION;?></h4>
	</div>
	<div class="modal-body text-center">
		<div class="modalBody">
			<?php if($st==3): ?>
				<div class="updatingAreas">
					<h4 class="text-danger"><i class="fa fa-frown-o fa-2x"></i></h4>
					<h4 class="mt-5 mb-5 text-danger"><?= $msg;?></h4>
				</div>
			<?php endif; ?>
			<?php if($st==2): ?>
				<div class="updatingAreas">
					<h4 class="text-success"><i class="fa fa-smile-o fa-2x"></i></h4>
					<h4>Please Click the start button for starting update ...</h4>
					<p class="mt-5 mb-5 text-muted"><?= $msg;?></p>
				</div>
			<?php endif; ?>

			

			<?php if($st==1): ?>
				<?php if($version == NEW_VERSION): ?>
					<div class="updatingAreas">
						<h4 class="finishUpdate"><i class="icofont-check-alt"></i></h4>
						<h4>Your script is Updated Succefully</h4>
						<p>You are using the latest version v<?= $version;?></p>
					</div>
				<?php else: ?>
					<div class="showOnprocess">
						<h4 class="text-success"><i class="fa fa-smile-o fa-3x"></i></h4>
						<h4>Please wailt unill the update Completed ...</h4>
						<img src="<?= base_url('assets/frontend/images/update_loader.gif');?>" alt="">
					</div>
					<div class="finishedArea" style="display:none;">
						<h4 class="text-success"><i class="fa fa-smile-o fa-3x"></i></h4>
						<h4><?= $msg;?></h4>
						<p>Currently Your are using v<?= $version;?></p>
					</div>
				<?php endif ?>

			<?php elseif($st==0): ?>
				<div class="updateErrorMsg text-danger">
					<h4><i class="fa fa-frown fa-3x"></i></h4>
					<h4>Sorry Update Failed.</h4>
					<p><?= $msg;?></p>
				</div>
			<?php endif ?>

		</div>
	</div>

	<div class="modal-footer <?= $version;?>" style="display:none;" >
		<?php if(isset($version) && $version == NEW_VERSION): ?>
		<button type="button" class="btn btn-primary" onclick="window.location.reload()">Click to Finish</button>
		<?php else: ?>
			<?php if($st==3 || $st==0): ?>
				<button type="button" class="btn btn-primary startUpdate" data-update="1">Try again</button>
			<?php else: ?>
				<div class="showAfterSuccess">
					<button type="button" class="btn btn-primary startUpdate" data-update="<?= isset($update)?$update:1;?>">Click to Install The Next version</button>
				</div>
			<?php endif ?>
		<?php endif ?>
</div>
<?php endif; ?>