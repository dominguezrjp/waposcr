<?php if(auth('user_role')==0): ?>
<div class="waiter_notificaiton">
	<ul>
		<?php include 'ajax_waiter_notify.php' ?>
	</ul>
</div>
<?php endif;?>