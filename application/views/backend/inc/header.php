<!DOCTYPE html >
<?php $settings = settings(); ?>
<html lang="en" dir="<?= direction();?>">  
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= !empty($settings['site_name'])?$settings['site_name']:'Qr Restuarant';?> | <?= isset($page_title) && $page_title!=''?$page_title:''; ?></title>
  <link rel="icon" href="<?= base_url($settings['favicon']);?>" type="image/*" sizes="16x16">
  <!-- Tell the browser to be responsive to screen width -->
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <?php if(direction()=='rtl'): ?>
      <link rel="stylesheet" href="<?= base_url()?>assets/admin/bootstrap_rtl.css">
    <?php endif ?>


  <!-- fontawsome 5 -->
    <link href="<?php echo base_url(); ?>assets/frontend/css/font-awesome-5.8.1.main.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/css/icofont.css" rel="stylesheet">
  <!-- fontawsome 5 -->
  
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/iconpicker/bootstrap-iconpicker.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/dist/css/AdminLTE.min.css">

  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">


  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/dist/css/skins/_all-skins.min.css">
   <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


  
  <!-- select2 style -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/bower_components/select2/dist/css/select2.min.css">

  <!-- time picker-->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/bower_components/bootstrap-timepicker/css/timepicker.css">

  
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/bower_components/morris.js/morris.css">
  

  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/jqueryqr/pickr.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.css">


  <!-- chosen animation -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/chosen/chosen.css?v=<?= time();?>">
  <link rel="stylesheet" href="<?= base_url()?>assets/frontend/plugins/animate/animate.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/frontend/plugins/sweetalert/sweet-alert.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/frontend/plugins/loader.css">
  <!-- custom loader css -->

  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/tag_inputs/bootstrap-tagsinput.css">

  <!-- summernote - text editor -->

  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/summernote/summernote-bs4.css">




  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  
  

  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/datetime/datetimepicker.css">
  <!-- uploader -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/uploader/uploadify.css">

  <!-- flatpickr -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/plugins/datetime_picker/datetime.css">
  <!-- flatpickr -->
  
  <link rel="stylesheet" href="<?= base_url()?>public/admin/default.php?v=<?= $settings['version'];?>&time=<?= time();?>">

  <link rel="stylesheet" href="<?= base_url()?>public/admin/style.main.css?v=<?= $settings['version'];?>&time=<?= time();?>">
  <?php if(direction()=='rtl'): ?>
    <link rel="stylesheet" href="<?= base_url()?>public/frontend/css/custom_rtl.css?v=<?= $settings['version'];?>&time=<?= time();?>">
  <?php endif ?>

  <?php if(file_exists(APPPATH.'controllers/admin/Pos.php')): ?>
    <link rel="stylesheet" href="<?= base_url()?>public/admin/pos.css?v=<?= $settings['version'];?>&time=<?= time();?>">
  <?php endif;?>
  
  <link rel="stylesheet" href="<?= base_url()?>public/admin/default.css?v=<?= $settings['version'];?>&time=<?= time();?>">
   <?php if(direction()=='rtl'): ?>
    <link rel="stylesheet" href="<?= base_url()?>public/admin/admin_rtl.css">
  <?php endif ?>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
<?php if(isset($settings['system_fonts']) && !empty($settings['system_fonts'])): ?>
  <link href="https://fonts.googleapis.com/css2?family=<?= $settings['system_fonts'] ;?>:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url(); ?>public/frontend/css/fonts.php?name=<?= $settings['system_fonts'] ;?>">
<?php endif;?>


  
<!-- custom css -->
  <?php if(isset($settings['custom_css']) && !empty($settings['custom_css'])): ?>
    <style>
      <?=  $settings['custom_css'];?>
    </style>
  <?php endif;?>
  <!-- custom css -->

  <!-- google recaptcha -->
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <!-- jQuery 3 -->
<script src="<?php echo base_url()?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>


  <!-- admin onSignal Notification -->
  <?php $oneSignal = !empty($settings['notifications'])?json_decode($settings['notifications']):''; ?>
  <?php if(isset($oneSignal->is_active_onsignal) && $oneSignal->is_active_onsignal==1): ?>
    <?php $this->load->view('frontend/inc/admin_onesignal_header', ['adminAppID'=>$oneSignal->onsignal_app_id], true); ?>
    <!-- onSignal Notification -->
  <?php endif ?>



<!-- restaurant onesignal -->
  <?php if(auth('is_user')==1 && auth('user_role')==0 && restaurant()->user_id == auth('id')): ?>
    <?php $id = auth('id') ?>
  <?php $user_settings = $this->common_m->get_user_settings($id); ?>
  
    <?php if(is_feature($id,'pwa-push')==1 && is_active($id,'pwa-push') && check()==1): ?>
  <!-- user onSignal Notification -->
      <?php $oneSignal = !empty($user_settings['onesignal_config']) ? json_decode($user_settings['onesignal_config']) : ''; ?>
      <?php if (isset($oneSignal->is_active_onsignal) && $oneSignal->is_active_onsignal == 1) : ?>
      <?= $this->load->view('frontend/inc/onesignal_header', ['appID' => $oneSignal->onsignal_app_id], true); ?>
      <!-- user onSignal Notification -->
      <?php endif; ?>
    <?php endif; ?>

  <?php endif; ?>
</head>
<?php if(auth('user_role')==1): ?>
  <body class="hold-transition <?= isset($settings['site_theme']) && $settings['site_theme']==1?"skin-black-light":"skin-black";?> sidebar-mini  <?= direction()=="rtl"?"sidebar-open":"";?>">
<?php else: ?>
  <?php $user_settings = u_settings(auth('id')) ?>
  <body class="hold-transition <?= isset($user_settings['site_theme']) && $user_settings['site_theme']==1?"skin-black-light":"skin-black";?> sidebar-mini  <?= direction()=="rtl"?"sidebar-open":"";?> <?= isset($page) && $page=="POS"?"sidebar-collapse":'';?>">
<?php endif ?>


<?php if (isset($page_title) && $page_title =="Login" || $page_title =="Registration") {?>
<div class="wrapper" style="background: #d2d6de;">
<?php }else{ ?>
  <div class="wrapper">
<?php } ?>