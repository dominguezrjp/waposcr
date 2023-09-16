<?php if(!isset($hide)): ?>
<?php if(isset($is_filter) && $is_filter==TRUE): ?>
	<?php include APPPATH.'views/backend/reports/incomeBadge.php'; ?>
<div class="filterarea">
	<div class="filterContent">
		<div class="filtercontentBody">
			<form action="" method="get" class="filterForm">
				<div class="filterBody">
					<div class="form-group">
						<label for=""><?= lang('order_id'); ?></label>
						<input type="text" name="uid" class="form-control" value="<?=  isset($_GET['uid'])?$_GET['uid']:'';?>">
					</div>
					<div class="form-group">
						<label for=""><?= lang('customer_name'); ?></label>
						<input type="text" name="name" class="form-control" value="<?=  isset($_GET['name'])?$_GET['name']:'';?>" placeholder="<?= lang('customer_name'); ?> / <?= lang('phone'); ?>">
					</div>
					<div class="form-group">
						<label for=""><?= lang('order_type'); ?></label>
						<select name="order_type" id="" class="form-control">
							<?php $order_type = $this->admin_m->select('order_types'); ?>
							<option value=""><?= lang('select'); ?></option>
							<?php foreach ($order_type as $key => $type): ?>
								<option value="<?=  $type['id'];?>" <?= isset($_GET['order_type']) && $_GET['order_type']==$type['id']?"selected":'' ;?>><?= $type['name']; ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group">
						<label><?= lang('status'); ?></label>
						<select name="status" id="status" class="form-control">
							<option value='all' <?= isset($_GET['status']) && $_GET['status']=="all"?"selected":'' ;?>><?= lang('select'); ?></option>
						<option value="0" <?= isset($_GET['status']) && $_GET['status']=="0"?"selected":'' ;?>><?= lang('pending'); ?></option>
							<option value="1" <?= isset($_GET['status']) && $_GET['status']=="1"?"selected":'' ;?>><?= lang('accepted'); ?></option>
							<option value="2" <?= isset($_GET['status']) && $_GET['status']=="2"?"selected":'' ;?>><?= lang('completed'); ?></option>
							<option value="3" <?= isset($_GET['status']) && $_GET['status']=='3'?"selected":'' ;?>><?= lang('rejected'); ?></option>
						</select>
					</div>

					<?php $table_list = $this->common_m->get_table_list(restaurant()->id); ?>
					<div class="form-group">
						<label><?= lang('table_no'); ?></label>
						<select name="table_no" id="table_no" class="form-control">
							<option value='' <?= isset($_GET['table_no']) && $_GET['table_no']==''?"selected":'' ;?>><?= lang('select'); ?></option>
							<?php foreach ($table_list as $table_no): ?>
								<option value="<?= $table_no['id'];?>" <?= isset($_GET['table_no']) && $_GET['table_no']==$table_no['id']?"selected":'' ;?>><?=  $table_no['name'];?> / <?= $table_no['area_name'];?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group">
						<label><?= lang('date'); ?></label>
						<div class="input-group date">
							<input type="text" name="daterange" class="form-control dateranges" value="<?= isset($_GET['daterange'])?$_GET['daterange']:'';?>"> 
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
						</div>
					</div>

					<div class="form-group mt-15">
						<button type="submit" class="btn btn-primary filterBtn"><i class="icofont-filter"></i> <?= lang('filter'); ?></button>
					</div>
					<?php if(isset($_GET['order_type'])): ?>
						<div class="form-group mt-15">
							<a href="<?= base_url('admin/restaurant/all_order_list') ;?>" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-close"></i></a>
						</div>
					<?php endif; ?>
				</div>
			</form>
		</div>
	</div>
</div>

<?php endif; ?>


<?php if(isset($is_filter) && $is_filter==FALSE): ?>
		<?php include APPPATH.'views/backend/reports/incomeBadge.php'; ?>
	<div class="filterarea">
		<div class="filterContent">

			<div class="filtercontentBody liveOrder">
				<div class="filterIcon">
							<a href="javascript:;" class="btn btn-secondary">	<i class="fa fa-filter"></i></a>
				</div>	
				<form action="" method="get" class="filterForm">
					<div class="filterBody">
						<div class="form-group">
							<label for=""><?= lang('order_id'); ?></label>
							<input type="text" name="uid" class="form-control" value="<?=  isset($_GET['uid'])?$_GET['uid']:'';?>">
						</div>

						<div class="form-group">
							<label for=""><?= lang('customer_name'); ?></label>
							<input type="text" name="name" class="form-control" value="<?=  isset($_GET['name'])?$_GET['name']:'';?>" placeholder="<?= lang('customer_name'); ?> / <?= lang('phone'); ?>">
						</div>
						<div class="form-group">
							<label for=""><?= lang('order_type'); ?></label>
							<select name="order_type" id="" class="form-control">
								<?php $order_type = $this->admin_m->select('order_types'); ?>
								<option value=""><?= lang('all'); ?></option>
								<?php foreach ($order_type as $key => $type): ?>
									<option value="<?=  $type['id'];?>" <?= isset($_GET['order_type']) && $_GET['order_type']==$type['id']?"selected":'' ;?>><?= $type['name']; ?></option>
								<?php endforeach ?>
							</select>
						</div>

						<div class="form-group">
							<label><?= lang('status'); ?></label>
							<select name="status" id="status" class="form-control">
								<option value='all' <?= isset($_GET['status']) && $_GET['status']=='all'?"selected":'' ;?>><?= lang('all'); ?></option>
								<option value="0" <?= isset($_GET['status']) && $_GET['status']=='0'?"selected":'' ;?>><?= lang('pending'); ?></option>
								<option value="1" <?= isset($_GET['status']) && $_GET['status']=='1'?"selected":'' ;?>><?= lang('accepted'); ?></option>
								<option value="2" <?= isset($_GET['status']) && $_GET['status']=='2'?"selected":'' ;?>><?= lang('completed'); ?></option>
								<option value="3" <?= isset($_GET['status']) && $_GET['status']=='3'?"selected":'' ;?>><?= lang('rejected'); ?></option>
							</select>
						</div>

						<?php $table_list = $this->common_m->get_table_list(restaurant()->id); ?>
						<div class="form-group">
							<label><?= lang('table_no'); ?></label>
							<select name="table_no" id="table_no" class="form-control">
								<option value='' <?= isset($_GET['table_no']) && $_GET['table_no']==''?"selected":'' ;?>><?= lang('all'); ?></option>
								<?php foreach ($table_list as $table_no): ?>
									<option value="<?= $table_no['id'];?>" <?= isset($_GET['table_no']) && $_GET['table_no']==$table_no['id']?"selected":'' ;?>><?=  $table_no['name'];?> / <?= $table_no['area_name'];?></option>
								<?php endforeach ?>
							</select>
						</div>

				

						<div class="form-group mt-15">
							<button type="submit" class="btn btn-primary filterBtn"><i class="icofont-filter"></i> <?= lang('filter'); ?></button>
						</div>
						<?php if(isset($_GET['order_type'])): ?>
							<div class="form-group mt-15">
								<a href="<?= base_url('admin/restaurant/order_list') ;?>" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-close"></i></a>
							</div>
						<?php endif; ?>
					</div>
				</form>
			</div>
	</div>
</div>
<?php endif;?>
<?php endif;?>

<div id="list_load">
	
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title flex"><?= !empty(lang('order_list'))?lang('order_list'):"order list";?> &nbsp; &nbsp;
						<div class="orderAbtn mr-20">
							<?php if(isset($page_type) && $page_type=="restaurant"): ?>
								<a href="<?= base_url('admin/restaurant/order_list') ;?>" class="btn btn-success success-light btn-flat"><i class="fa fa-list"></i> &nbsp;<?= !empty(lang('live_orders'))?lang('live_orders'):"Live Orders";?> </a>
							<?php else: ?>
								<a href="<?= base_url('admin/restaurant/all_order_list') ;?>" class="btn btn-success success-light btn-flat"><i class="fa fa-list"></i> &nbsp;<?= !empty(lang('all_orders'))?lang('all_orders'):"All Orders";?> </a>
							<?php endif;?>
						</div>
						<div class="actionBtn">
								<form action="<?= base_url("admin/restaurant/order_action");?>" method="post">
										<?= csrf();?>
											<input type="hidden" name="actionIds" value="">
											<label class="btn btn-info info-light-active p-r" onclick="$(this).closest('form').submit();" > <i class="fa fa-exchange"></i> <input type="radio" name="merge" value="1" class="opacity_0"> <?= lang('merge');?></label>

											<label class="btn btn-danger danger-light-active p-r" onclick="$(this).closest('form').submit();" > <i class="fa fa-trash"></i>  <input type="radio" name="delete" value="1" class="opacity_0"> <?= lang('delete');?></label>
								</form>
						</div>
					</h3>
					<div class="box-tools pull-right orderList">
						<ul class="viewContent">
							<li class="showExtras"><a href="javascript:;"><i class="fa fa-cog" ></i></a></li>
						</ul>
					</div>
					<div class="customFilterContent">
						<ul>
							<li class="<?= restaurant()->order_view_style==1?"active":"";?>"><a href="<?= base_url("admin/auth/change_order_layouts/1");?>"><i class="fa fa-list-ul" ></i> <?= lang("list_view");?></a></li>
							<li class="<?= restaurant()->order_view_style==2?"active":"";?>"><a href="<?= base_url("admin/auth/change_order_layouts/2");?>"><i class="fa fa-th"></i> <?= lang("grid_view");?></a></li>

						</ul>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php if(restaurant()->order_view_style==1): ?>
						<?php include 'inc/orderList_thumb.php'; ?>
					<?php else: ?>
						<?php include 'inc/orderList_grid.php'; ?>
					<?php endif ?>
				
					<div class="row">
						<div class="col-md-12 text-center">
							<div class="pagination">
								<?= $this->pagination->create_links(); ;?>
							</div>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div>
		</div>
	</div>
</div><!-- #list_load -->
	<div class="view_orderList">
		
	</div>




<?php include 'estimate_time_modal.php' ?>



<script type="text/javascript">

  
  var text = '<?= lang('remaining') ;?>';
  $(".get_time").each(function(i,e){
    var id = $(this).data('id');
    var time = $(this).data('time');
    var countDownDate = new Date(time).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      if(days > 0){
        $('#show_time_'+id).html(text+': '+days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
         
      }else if(hours > 0){
        $('#show_time_'+id).html(text+': '+ hours + "h "+ minutes + "m " + seconds + "s ");
          
      }else if(minutes > 0){
        $('#show_time_'+id).html(text+': '+ minutes + "m " + seconds + "s ");
          
      }else if(seconds > 0){
        $('#show_time_'+id).html(text+': '+ seconds + "s ");
      }else{
         $('#show_time_'+id).html('');
      }

  
      if (distance < 0) {
        clearInterval(x);
        $('#show_time_'+id).html('');
      }
    }, 1000);
  });
</script>


<?php if(isset($is_filter) && $is_filter==FALSE): ?>
	<a href="javascript:;" class="isFilter" data-id="1"></a>
<?php endif;?>	

<style>
	.box{
		overflow: hidden;
	}
	.box-header{
		position: relative;
	}
	.customFilterContent.active{
		right: 0px;
	}
	.customFilterContent {
    position: absolute;
    right: -100%;
    background: #fff;
    min-height: 71px;
    width: 200px;
    border: 1px solid #ddd;
    display: flex;
    align-items: flex-start;
    z-index: 99;
    margin-top: 11px;
    transition: all .3s ease-in-out;
}

.customFilterContent ul {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
    gap: 5px;
}

.customFilterContent ul li a i{
    font-size: 19px;
}

.customFilterContent ul li a {
    padding: 9px;
    display: flex;
    width: 100%;
    color: #777;
    align-items: center;
    gap: 8px;
    transition: all .3s ease-in-out;
}
.customFilterContent ul li a:hover {
    background: #f8f8f8;
}
.customFilterContent ul li.active a{
	color: #000;
}

.customFilterContent ul li {
    width: 100%;
    display: block;
}
</style>
<script>
	$(document).on("click",".showExtras a",function(){
			$('.customFilterContent').toggleClass('active');
	});

	$(document).on("click",".filterIcon a",function(){
			$('.filterForm').slideToggle();
	});


		$(document).on("click","[name='order_ids']",function(){
			var numberNotChecked = $("[name='order_ids']").filter(':checked').length;

			var ids = [];
			$('[name="order_ids"]:checked').each(function(){
				var id = $(this).val();
				 ids.push($(this).val());
			});
			if(numberNotChecked > 1){
				$('[name="actionIds"]').val(JSON.stringify(ids));
				$('.actionBtn').addClass('active');
			}else{
				$('[name="actionIds"]').val('');
				$('.actionBtn').removeClass('active');
			}
	});



</script>