<?php $u_info = get_user_info_by_slug($slug); ?>
<div class="modal fade popupModal" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= lang('warning'); ?></h5>
      </div>
      <div class="modal-body">
       <div class="user_content">
   		<div class="user_info">
   			<?php if(!empty($u_info)): ?>
       			<i class="fa fa-frown-o frown"></i>
       			<h4>Sorry <?= html_escape($u_info['username']);?></h4>
       			<?php if($u_info['is_active']==0): ?>
	       			<p>Your Account is not active</p>
	       		<?php elseif($u_info['is_verify']==0): ?>
	       			<p>Your Account is not verified</p>
	       			<p>Please verify your account by email</p>
            <?php elseif($u_info['is_expired']==1): ?>
              <p>Your account is Expired</p>
            <?php elseif($u_info['is_payment']==0): ?>
              <p>Your account is not active due to payment issue</p>
	       		<?php endif ?>
	       	<?php else: ?>
	       		<i class="fa fa-frown-o frown"></i>
       			<h4>Sorry invalid user</h4>
       		<?php endif ?>
       		<div class="contact_us_alert">
       			<a href="<?php echo base_url(); ?>" class="btn btn-primary"><i class="fa fa-angle-double-left"></i> <?= lang('back'); ?></a>
       			<a href="<?php echo base_url('contacts'); ?>" class="btn btn-primary"><?= lang('contact_us'); ?></a>
       		</div>
   		</div>
       </div>
      </div>
    </div>
  </div>
</div>