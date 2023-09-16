  <?php $my_info = get_user_info(); ?>
<?php if(isset($page) && $page !='POS'):?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url(!empty(html_escape($my_info['thumb']))?html_escape($my_info['thumb']):'assets/frontend/images/avatar.png')?>" class="img-circle uploaded_img" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= !empty(html_escape($my_info['name']))?html_escape($my_info['name']):$my_info['username'] ; ?></p>
          <span id="time"></span>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">


        <li class="nav-drawer-header"><?= lang('general'); ?></li>
        <!-- <li class="header">MAIN NAVIGATION</li> -->
        <li class="<?= isset($page_title) && $page_title =="Dashboard"?"active":""; ?>">
          <a href="<?= base_url('admin/dashboard') ?>">
            <i class="icofont-dashboard fz-20"></i> <span><?= !empty(lang('dashboard'))?lang('dashboard'):"Dashboard";?></span>
          </a>
        </li>



        <?php if($this->settings['is_update']==0): ?>
          <?php if(isset($this->auth['user_role']) && $this->auth['user_role']==1): ?>
              <?php if($this->is_redirect==0){ ?>
                      
                <?php include 'admin_sidebar.php'; ?> 

              <?php };?> <!-- is redirect -->
           <?php endif;?> <!-- end user role 1 -->
        <?php endif; ?><!-- is_update -->

        <!-- User section -->
        <?php if(isset($this->auth['user_role']) && $this->auth['user_role']==0): ?>
          <?php if($this->auth['is_verify']==1): ?>
            <?php if($this->my_info['is_deactived']==0): ?>
                <?php if(!empty(restaurant()->name) || !empty(restaurant()->phone) || @restaurant()->country_id != 0): ?>
                      <?php include 'user_sidebar.php'; ?>
                <?php endif ?>
              <?php endif; ?><!--user_role==0  -->
          <?php endif; ?><!-- is_verify==1 -->


            
        <?php endif; ?><!-- user role==0 -->
        <!-- User section -->





      </ul>

    </section>
    <!-- /.sidebar -->
</aside>
<?php endif;?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <script>$(document).ready(function(){ <?= isset(db_connect['connected'])?db_connect['connected']:"";?>});</script>
    <!-- Main content -->
    <section class="content">
    <?php include 'waiter_notification.php'; ?>
    <?php include 'order_merge_notification.php'; ?>

     