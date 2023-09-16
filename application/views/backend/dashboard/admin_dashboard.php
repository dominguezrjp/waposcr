<div class="row">
  <?php include "admin_inc/all_account_info.php"; ?>
  <?php include "admin_inc/account_info.php"; ?>
</div>


<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <i class="fa fa-bar-chart-o"></i>

        <h3 class="box-title"><?= !empty(lang('net_income'))?lang('net_income'):"Net Income";?> - <?= date('Y');?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div id="bar-chart" style="height: 300px;"></div>
      </div>
      <!-- /.box-body-->
    </div>
  </div>


  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <i class="fa fa-pie-chart-o"></i>

        <h3 class="box-title"><?= !empty(lang('package_by_user'))?lang('package_by_user'):"package by users";?> - <?= date('Y');?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
      </div>
      <!-- /.box-body-->
    </div>
  </div>
</div>
  <?php include 'staff_activities.php' ?>