<?php if($this->my_info['account_type']!=0 ): ?>
<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 pr-5 pl-5">
  <!-- Widget: user widget style 1 -->
  <div class="box box-widget widget-user-2">
  <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header profile profile_flex" style="background-color:#<?= trim($this->my_info['colors']) ;?>">
      <div class="widget-user-image profile-img-2">
        <img class="img-circle" src="<?= base_url(!empty(restaurant()->thumb)?restaurant()->thumb:'assets/frontend/images/avatar.png') ;?>" alt="User Avatar">
      </div>
        <div class="right_details dash_left">
          <h3 class="widget-user-usernames"><?= isset(restaurant()->name) && !empty(restaurant()->name)?restaurant()->name:$this->my_info['username'];?></h3>
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
                  <p><?= user()->hit ;?></p>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
          <?php 
              $item_limit = limit(auth('id'),1) == 0? '<i class="fas fa-infinity"></i>':limit(auth('id'),1); 

              $order_limit = limit(auth('id'),0) == 0? '<i class="fas fa-infinity"></i>':limit(auth('id'),0);
           ?>
          <?php if(is_feature(auth('id'),'menu')==1): ?>
            <li><a href="<?= base_url('admin/menu/item') ;?>"><?= get_features_name('menu');?> <span class="pull-right badge bg-blue"><?= $this->admin_m->check_limit_by_table('items') ;?> / <?= $item_limit ;?></span></a> </li>
          <?php endif;?>

          <?php if(is_feature(auth('id'),'packages')==1): ?>
            <li><a href="<?= base_url('admin/menu/packages') ;?>"><?= get_features_name('packages');?> <span class="pull-right badge bg-aqua"><?= $this->admin_m->count_packages_user_id('item_packages',$is_special=0) ;?> / <?= $item_limit ;?> </span></a> </li>
          <?php endif;?>

          <?php if(is_feature(auth('id'),'specialities')==1): ?>
            <li><a href="<?= base_url('admin/menu/specialties') ;?>"><?= get_features_name('specialities');?><span class="pull-right badge bg-green"><?= $this->admin_m->count_packages_user_id('item_packages',$is_special=1) ;?> / <?= $item_limit ;?> </span></a> </li>
          <?php endif;?>

          <?php if(is_feature(auth('id'),'order')==1): ?>
            <li><a href="<?= base_url('admin/restaurant/order_list') ;?>"><?= get_features_name('order');?> <span class="pull-right badge bg-red"><?= $this->admin_m->count_total_shop_id('order_user_list');?> / <?= $order_limit ;?></span>  </a></li>
          <?php endif;?>

        </ul>
    </div>
  </div>
</div>
<!-- /.widget-user -->
<?php endif;?>