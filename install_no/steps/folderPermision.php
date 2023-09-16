<div class="card">
	<div class="card-header">
		<h4 class="card-title">Folder Permissions</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-sm-10">
				<p><i class="fa fa-folder-open"></i> application/session</p>
				<p><i class="fa fa-folder-open"></i> application/config</p>

				<?php $rootDir = ['big','files','orders_qr','pwa','qr_image','site_banners','site_images','thumb']; ?>
				<?php foreach ($rootDir as $key => $value): ?>
					<p><i class="fa fa-folder-open"></i> uploads/<?= $value;?></p>
				<?php endforeach ?>

			</div>
			<div class="col-sm-2 text-right">
				<p><?php if (is_writable(BASE_URL.'application/session')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
				<p><?php if (is_writable(BASE_URL.'application/config')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
				<?php foreach ($rootDir as $key => $value): ?>
					<p><?php if (is_writable(BASE_URL.'uploads/'.$value)) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>