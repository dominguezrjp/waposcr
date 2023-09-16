<div class="row">
	<div class="col-md-3">
		<?php if(!empty($restaurant)): ?>
			<div class="single_profile_thumb">
				<div class="profile_thumb_header">
					<img src="<?= base_url($auth_info['thumb']);?>" alt="">
				</div>
				<div class="profile_thumb_body">
					<h4>Username</h4>
					<p>created at</p>
				</div>
			</div>
		<?php else: ?>
			<div class="single_profile_thumb">
				<div class="profile_thumb_header">
					<img src="<?= base_url($auth_info['thumb']);?>" alt="">
				</div>
				<div class="profile_thumb_body">
					<h4>Username</h4>
					<p>created at</p>
				</div>
			</div>
		<?php endif;?>
	</div>
</div>