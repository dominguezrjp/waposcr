<div class="col-md-7 col-lg-7 col-sm-6 col-xs-12 pr-5 pl-5">
      <!-- Widget: user widget style 1 -->
      <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header profile" style="background-color: #<?= trim($this->my_info['colors']) ;?>">
          <h3 class="widget-user-username"><?=  $this->my_info['username'];?></h3>
          	<h5><?php if(isset($active_package['package_type']) && $active_package['package_type']!="free"): ?>
          			<b><?= day_left(d_time(),$this->my_info['end_date'])['day_left'];?></b>
                  <p class="description-text mt-5"><?= lang('expired_date'); ?>: <b><?= full_date($this->my_info['end_date']);?></b></p>
                  <?php else: ?>
                  	<p class="description-text mt-5"><b><?= lang('free'); ?></b></p>
                <?php endif;?>
            </h5>
          
          
       
        </div>
        <div class="widget-user-image profile-img">
          <img class="img-circle" src="<?= base_url(!empty($this->my_info['thumb'])?$this->my_info['thumb']:'assets/admin/dist/img/user2-160x160.jpg') ;?>" alt="User Avatar">
        </div>

        <?php if($this->my_info['account_type']==0): ?>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header"><?= !empty(lang('trial'))?lang('trial'):"Trial"?></h5>
                <span class="description-text"><?= !empty(lang('package_type'))?lang('package_type'):"package type"?></span>
               
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header"> <?= $this->admin_m->total_features();?> / <?= $this->admin_m->total_features();?> </h5>
                <span class="description-text"><?= !empty(lang('features'))?lang('features'):"Features"?></span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header"><?= day_left(d_time(),$this->my_info['end_date'])['day_left'];?></h5>
                <span class="description-text"><?= !empty(lang('duration'))?lang('duration'):"duration"?> </span>

              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            
          </div>

          <!-- /.row -->
        </div>
        <?php else: ?>
          <div class="box-footer">
          <div class="row">
            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header">
                  <?php if($this->my_info['account_type']==0): ?>
                  <?= ucfirst(!empty(lang('trial'))?lang('trial'):"trial")?>
                <?php else: ?>
                  <?= isset($active_package['package_name'])? ucfirst(html_escape($active_package['package_name'])):"";?>
                <?php endif;?>
              </h5>
                <span class="description-text"><?= !empty(lang('package_name'))?lang('package_name'):"package name"?> </span>
              </div>
            </div>
            <!-- /.col -->

            
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <?php $total_features = $this->admin_m->count_my_active_packages(); ?>
                <h5 class="description-header"><?= isset($total_features)?html_escape($total_features).' / '.$this->admin_m->total_features():"";?> </h5>
                <span class="description-text"><?= !empty(lang('features'))?lang('features'):"Features"?></span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header"><?= ucfirst(isset($active_package['package_type'])?html_escape(!empty(lang($active_package['package_type']))?lang($active_package['package_type']):$active_package['package_type']):'');?></h5>
                <span class="description-text"><?= !empty(lang('package_type'))?lang('package_type'):"package type"?></span>
               
              </div>
            </div>
            <!-- /.col -->
            
          </div>

          <!-- /.row -->
        </div>
        <?php endif;?>
        <div class="profile_btn">
          <?php if(auth('is_staff')==TRUE): ?>
            <a href="<?= base_url('admin/restaurant/staff_profile') ;?>" class=""><?= !empty(lang('profile'))?lang('profile'):"Profile"?></a>
          <?php else: ?>
            <a href="<?= base_url('admin/auth/') ;?>" class=""><?= !empty(lang('profile'))?lang('profile'):"Profile"?></a>
          <?php endif;?>
        </div>
      </div>
      <!-- /.widget-user -->
    </div>