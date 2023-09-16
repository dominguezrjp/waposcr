 <?php $my_info = get_user_info(); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php if(extension_loaded('curl')==false) { ?>
             <div class="single_alert alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div class="d_flex_alert">
                    <h4><i class="icon fas fa-warning"></i><?=  lang('alert');?></h4>
                    <div class="double_text">
                        <div class="text-left">
                         <h4>CURL is not available on your web server</h4>
                         <p>Please allow "CURL" configure in your server otherwise you can't active this script </p>
                        </div>
                       
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>


   <?php include "admin_inc/alert_info.php"; ?>
</div>



<!-- 
    Start Admin dashboard
 -->
<?php if($this->auth['user_role']==1): ?>
  <?php include "admin_dashboard.php"; ?>
<?php endif ?>
<!-- 
    End Admin dashboard
 -->



<!-- 
    User dashboard
 -->

<?php if($this->auth['user_role']==0): ?>
 <?php include "user_dashboard.php"; ?>
<?php endif; ?><!-- user_type ==0 -->
<!-- 
    User dashboard
 -->








<?php if($this->my_info['user_role']==1): ?>
<script>
window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  title: {
    text: ""
  },
  data: [{
    type: "pie",
    startAngle: 240,
    yValueFormatString: "##0.00\"%\"",
    indexLabel: "{label} {y}",
    dataPoints: [
    <?php foreach ($user_type as $key => $pie):?>
       {y: <?= $pie['total_user'];?>, label: "<?= $pie['package_name'];?>"},
    <?php endforeach; ?>
     
    ]
  }]
});
chart.render();

}




</script>
<?php endif;?>