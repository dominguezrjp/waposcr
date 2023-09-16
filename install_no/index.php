<?php 
    session_start();
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
    }


    if (!isset($_SESSION["purchase_code"]) && isset($_SESSION['step']) && $_SESSION['step'] !=0) {
       echo "<pre>";print_r("Invalid purchase code!");exit();
    }

    

 ?>

<?php require_once 'inc/header.php'; ?>
<?php require_once 'helper.php'; ?>

<?php 
  if(is_install()==1){
    header("Location:".getBaseUrl());die;
  }
 ?>


<?php 
error_reporting(0);
define('__R__', __DIR__);
$ROOTDIR = str_replace(['install'], [''], __DIR__);

  $serverReq = checkReq();
  foreach ($serverReq as $key => $value) {
    echo "<div class='alert alert-danger'>". $value ."</div>";
  }
?>

 <div class="container blue">
   <div class="row" style="margin-top: 150px; background:#eee; padding: 20px;">
     <div class="col-md-8">
       <div class="mainBody">
          <div id="msgSubmit"></div>
          <?php if(isset($_SESSION['step']) && $_SESSION['step']=='step_2'): ?>
            <?php include 'steps/step2.php'; ?>
          <?php else: ?>
            <?php include 'steps/step1.php'; ?>
          <?php endif ?>
       </div>
     </div>
     <div class="col-md-4">
           <?php if(isset($_SESSION['step']) && $_SESSION['step']=='step_2'): ?>
              <?php include 'steps/folderPermision.php'; ?>
           <?php else: ?>
            <?php include 'steps/serverDetails.php'; ?>
           <?php endif ?>
     </div>
   </div>
 </div>
<?php require_once 'inc/footer.php'; ?>


