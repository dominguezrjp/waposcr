<?php if (USER_ROLE==0) : ?>
    <?php if (isset($page_title) && $page_title=="Dashboard") : ?>
        <?php $check = $this->admin_m->get_last_unseen_notification(restaurant()->id); ?>

        <?php if (isset($check['check']) && $check['check']==1) : ?>
      <div class="custom_notification">
        <div class="alert alert-danger alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <a href="<?= base_url("admin/notify/my_notifications");?>">
              <div class="customNotify">
                <strong><i class="fa fa-bell"></i></strong>
                <div class="notifyBody">
                  <h4><?= $check['result']->title;?></h4>
                  <p><?= full_date($check['result']->send_at);?></p>
                </div>
              </div>
            </a>
        </div>
      </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>


 <?php $setting = settings(); ?>
 <?php $auth_info = get_user_info(); ?>
 <header class="main-header">
    <!-- Logo -->
    <?php if ($auth_info['user_role']==1) : ?>
      <a href="<?php echo base_url() ?>" class="logo shopLogo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="mini-logo">
          <?php if (!empty($setting['favicon'])) : ?>
            <img src="<?= base_url($setting['favicon']) ;?>" alt="">
          <?php else : ?>
          <img src="<?= base_url("assets/frontend/images/logo-example.png"); ?>" alt=""></span>
          <?php endif;?>
      </a>
    <?php else : ?>
      <a href="<?= isset($page) && $page=="POS"?base_url('dashboard'):base_url(); ?>" class="logo shopLogo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="mini-logo">
          <?php if (!empty($setting['logo'])) : ?>
            <img src="<?= base_url($setting['logo']) ;?>" alt="">
          <?php else : ?>
             <img src="<?= base_url("assets/frontend/images/logo-example.png"); ?>" alt=""></span>
          <?php endif;?>

          
      </a>
    <?php endif;?>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <?php if (isset($page) && $page=="POS") :?>
      <a href="<?= base_url("dashboard");?>" class="sidebar-toggle">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <?php else :?>
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <?php endif; ?>

      <?php if ($auth_info['user_role']==0) : ?>
          <a href="<?= url(html_escape($this->my_info['username'])); ?>" class="navLink" target='blank'>
            <i class="fa fa-eye"></i> <span><?= !empty(lang('view_shop'))?lang('view_shop'):"View Shop";?></span>
          </a>
      <?php endif; ?>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <?php if(auth('user_role')==0): ?>
             <?php $glang = glang(auth('id')); ?>
           <?php endif; ?>
            <?php if (isset($glang['is_glang']) && $glang['is_glang']==1) : ?>
              <li class="gLanguage p-r">
                  <div class="gtranslate_wrapper"></div>
              </li>
            <?php endif; ?>
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="icofont-globe"></i>
                <?= !empty(auth('site_lang'))?auth('site_lang'):$settings['language'] ;?> &nbsp;<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <?php $languages = $this->common_m->select_with_status('languages'); ?>
                  <?php if (count($languages) > 1) : ?>
                        <?php foreach ($languages as $key => $language) : ?>
                      <li>
                       <a class="dropdown-item" href="<?= base_url('home/lang_switch/'.$language['slug']) ;?>"> <?= $language['lang_name'] ;?></a>
                     </li>
                        <?php endforeach ?>
                  <?php endif;?>
                </ul>
              </li>

          <?php if (USER_ROLE==0) : ?>
                <?php $pages = ['Dashboard','Auth Profile','Settings'] ?>
                <?php if (isset($page_title) && in_array($page_title, $pages)==1) : ?>
                    <?php $total_notify = $this->admin_m->get_last_total_unseen_notification(restaurant()->id); ?>
                    <li class="p-r">
                      <a href="<?= base_url("admin/notify/my_notifications");?>" class="fz-18"><i class="icofont-bell-alt"></i> 
                        <?php if ($total_notify > 0) : ?>
                          <span class="notifyBadge"><?= $total_notify;?></span>
                        <?php endif ?>
                      </a>
                      <!-- notification -->
                    </li>
                <?php endif; ?>
          <?php endif; ?>


            <?php if (auth('user_role')==0) : ?>
                <?php if (file_exists(APPPATH.'controllers/admin/Pos.php')) : ?>
                <li class="p-r table-ajax-notification">
                    <?php include "ajax_table_notification.php"; ?>
                  <!-- notification -->
                </li>
                <?php endif;?>
            <?php endif;?>    
           
          
          
         

          <?php if (auth('is_staff')==true) : ?>
          <li class="bg-success-soft">
            <a class="bg-success-soft"><i class="icofont-users-social fz-19"></i> &nbsp;<?= !empty(lang('staff_login'))?lang('staff_login'):"Staff Login"; ?></a>
          </li>

          <li class="">
            <a><?= staff_info()->name ;?></a>
          </li>
          <?php endif;?>

          <?php if (auth('user_role')==0) : ?>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu ajax-notification">
                <?php include "ajax_notification.php"; ?>
            <!-- notification -->
          </li>
          <?php endif;?>

          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url(!empty($auth_info['thumb'])?$auth_info['thumb']:'assets/frontend/images/avatar.png')?>" class="user-image uploaded_img" alt="User Image">
              <span class="hidden-xs"><?= isset($auth_info['name']) && !empty($auth_info['name'])?$auth_info['name']:$auth_info['username']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url(!empty($auth_info['thumb'])?$auth_info['thumb']:'assets/frontend/images/avatar.png')?>" class="img-circle uploaded_img" alt="User Image">

                <p>
                  <?= !empty($auth_info['name'])?$auth_info['name']:$auth_info['username']; ?>
                  <?php if (!empty($auth_info['designation'])) { ?>
                    <span><?= "- ".$auth_info['designation']; ?></span>
                  <?php } ?>
                  <small><?= lang('member_since'); ?> - <?= cl_format($auth_info['created_at']); ?></small>
                  
                  <!-- <small id="time"></small> -->
                </p>
              </li>
              <div class="text-center">
                <small><?= lang('last_login'); ?> - <?= cl_format($auth_info['last_login']); ?></small>
              </div>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <?php if (auth('user_staff')==true) : ?>
                    <a href="<?= base_url('admin/restaurant/staff_profile') ?>" class="btn btn-default btn-flat"><?= !empty(lang('profile'))?lang('profile'):"Profile";?></a>
                  <?php elseif (auth('admin_staff')==true) : ?>
                    <a href="<?= base_url('admin/adminstaff/staff_profile') ?>" class="btn btn-default btn-flat"><?= !empty(lang('profile'))?lang('profile'):"Profile";?></a>
                  <?php else : ?>
                    <a href="<?= base_url('admin/auth/') ?>" class="btn btn-default btn-flat"><?= !empty(lang('profile'))?lang('profile'):"Profile";?></a>
                  <?php endif;?>
                </div>
                <div class="pull-right">
                  <a href="<?= base_url('logout') ?>" class="btn btn-default btn-flat"><?= !empty(lang('logout'))?lang('logout'):"Logout";?></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>


  <?php if (LICENSE!=MY_LICENSE) : ?>
  <script>
    $(document).ready(function(){
      $(".card.stripe_fpx, .mercado, .flutterwave, .paystack, .paytm, .cDomain").html('')
    })
  </script>
  <?php endif ?>

