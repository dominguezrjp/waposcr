<div class="">
  <!-- Widget: user widget style 1 -->
  <div class="box box-widget widget-user-2">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header profile profile_flex" style="background-color: #<?= trim($this->my_info['colors']) ;?>">
      <div class="widget-user-image profile-img-2">
        <img class="img-circle" src="<?= base_url(!empty($this->my_info['thumb'])?$this->my_info['thumb']:'assets/admin/dist/img/user2-160x160.jpg') ;?>" alt="User Avatar">
      </div>
        <div class="right_details">
          <div class="right_left">
            <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?= isset(restaurant()->name) && !empty(restaurant()->name)?restaurant()->name:$this->my_info['username'];?></h3>
              <h5 class="widget-user-desc"><?= isset($this->my_info['name'])?$this->my_info['name']:$this->my_info['username'];?></h5>
              <h5 class="widget-user-desc"><?= cl_format($this->my_info['created_at']) ;?></h5>
          </div>
          <div class="right_right">
            
          </div>
        </div>
    </div>
    <div class="box-footer no-padding">
        <div class="text-center subscrip_option">
          <h4><?= lang('using_trail_package'); ?></h4>
          <p><?= lang('trail_package_expired'); ?></p>
          <div class="">
            <a href="<?= base_url('admin/auth/subscriptions') ;?>" class="btn btn-info c_btn"><i class="fa fa-exchange"></i> &nbsp; <?= lang('change_package'); ?></a>
          </div>
        </div>
    </div>
  </div>
  <!-- /.widget-user -->
</div>