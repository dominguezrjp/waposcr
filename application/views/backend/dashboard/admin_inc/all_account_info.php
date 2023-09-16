
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 pr-5">
<!-- Widget: user widget style 1 -->
<div class="box box-widget widget-user-2">
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header profile profile_flex" style="background-color:#<?= trim($this->my_info['colors']) ;?>">
    <div class="widget-user-image profile-img-2">
      <img class="img-circle" src="<?= base_url(!empty(html_escape($my_info['thumb']))?html_escape($my_info['thumb']):'assets/admin/dist/img/user2-160x160.jpg')?>" alt="User Avatar">
    </div>
      <div class="right_details dash_left">
        <h3 class="widget-user-usernames"><?= isset($this->my_info['name']) && !empty($this->my_info['name'])?$this->my_info['name']:$this->my_info['username'];?></h3>
          <div class="logo_text">
            <div class="right_left">
                <h5 class="widget-user-descs"><?= isset($this->my_info['name'])?$this->my_info['name']:$this->my_info['username'];?></h5>
                <h5 class="widget-user-descs"><?= cl_format($this->my_info['created_at']) ;?></h5>
            </div>
            <div class="right_right">
              <div class="text-center mr-20" data-toggle="tooltip" title="Share profile">
                <i class="fa fa-floppy-o "></i>
                <p><?= isset($this->my_info['share_link'])?$this->my_info['share_link']:0 ;?></p>
              </div>
              <div class="text-center" data-toggle="tooltip" title="Total Visit">
                <i class="fa fa-eye fa-1.5x"></i>
                <p><?= isset($u_info->hit) ?$u_info->hit:0 ;?></p>
              </div>
            </div>
          </div>
      </div>
  </div>
  <div class="box-footer no-padding">
      <ul class="nav nav-stacked">
        <li><a href="<?= base_url('admin/dashboard/total_users') ;?>"><?= lang('total_user') ;?> <span class="pull-right badge bg-blue"><?= total_type('total'); ?></span></a> </li>
          <li><a href="<?= base_url('admin/dashboard/packages') ;?>"><?= lang('total_package'); ?> <span class="pull-right badge bg-aqua"><?= $this->admin_m->count_table_by_status(1,'packages'); ?> </span></a> </li>

          <li><a href="<?= base_url('admin/dashboard/pages') ;?>"><?= lang('total_pages'); ?><span class="pull-right badge bg-green"><?=  $this->admin_m->count_table_by_status(1,'pages');?> </span></a> </li>

          <li><a href="<?= base_url('admin/dashboard/offline_payments') ;?>"><?= !empty(lang('new_payment_request'))?lang('new_payment_request'):"New payment request ";?><span class="pull-right badge bg-red"><?= $this->admin_m->count_table_by_status(0,'offline_payment'); ?> </span></a> </li>

          <?php if(total_type('is_verify') > 0): ?>
          <li><a href="<?= base_url('admin/dashboard/total_users') ;?>"><?= !empty(lang('not_verified'))?lang('not_verified'):"Not Verified ";?><span class="pull-right badge bg-red"><?= total_type('is_verify'); ?> </span></a> </li>
        <?php endif;?>
          <?php if(total_type('is_expired') > 0): ?>
            <li><a href="<?= base_url('admin/dashboard/total_users') ;?>"><?= !empty(lang('expired_account'))?lang('expired_account'):"Expired account";?><span class="pull-right badge bg-red"><?= total_type('is_expired'); ?> </span></a> </li>
          <?php endif;?>

      </ul>
  </div>
</div>
</div>
<!-- /.widget-user -->