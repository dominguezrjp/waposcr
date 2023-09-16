<div class="row">
	<div class="col-md-3">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"><?= lang('new_order'); ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body kds" >
				<div class="kds">
					<?php foreach ($order_list as $key => $row): ?>
						<?php if($row['status'] == 1 && $row['is_preparing'] == 0): ?>
							<div class="single_order new">
								<div class="order_header new">
									<h4><span>#<?= $row['uid'] ;?></span> 
										<?php if(!empty($row['table_no'])): ?>
											<span><?= lang('table_no'); ?>: <?= single_select_by_id($row['table_no'],'table_list')['name'] ;?></span>
										<?php endif;?>
									</h4>
								</div>
								<div class="customerDetails">
									<p><?= lang('name'); ?>: <b><?= $row['name'] ;?></b></p>
									<?php if(auth('is_login')==TRUE): ?>
										<p><?= lang('phone'); ?>: <b><?= $row['phone'] ;?></b></p>
									<?php endif ?>
									<p><?= lang('price'); ?>: <b> <?= currency_position($row['total'],$shop['id']) ;?></b> </p>
								</div>
								<?php if($row['estimate_time']!=0): ?>
									<div class="preparedTime">
										<i class="fa fa-clock"></i>
										<p class="showPTime get_time" id="show_time_<?= $row['id'] ;?>" data-time="<?= $row['estimate_time'] ;?>" data-id="<?= $row['id'];?>"></p>
									</div>
								<?php endif;?>
								<div class="orderBody">
									<?php foreach ($row['all_items'] as $key => $item): ?>
										<div class="singleItems">
											<?php if(isset($item['is_package']) && $item['is_package']==1): ?>
												<h4><?=  $item['qty'];?> x <?= $item['package_name'] ;?> 
											<?php else: ?>
												<h4><?=  $item['qty'];?> x <?= $item['title'] ;?> 
											<?php endif;?>

												<?php if(isset($item['is_size']) && $item['is_size']==1): ?>
													<label for=""><?= isset($item['size_slug']) && !empty($item['size_slug'])?lang('size').' : '.get_size($item['size_slug'],$item['shop_id']):"" ;?></label>
												<?php endif;?>
											 </h4>
											<div class="single_item_body">

												<?php if(isset($item['is_extras']) && $item['is_extras']==1): ?>
													<?php $extraId = json_decode($item['extra_id']); ?>
													<div class="extrasArea kds details_view mt-5">
														<ul>
															<?php foreach ($extraId as $key => $ex): ?>
																<li><span>1 x <?= extras($ex,$item['item_id'])->ex_name ;?></span></li>
															<?php endforeach ?>
														</ul>
													</div>
												<?php endif;?>
											</div>
										</div>
									<?php endforeach ?>
									</div>
									<?php if(!empty($row['comments'])): ?>
										<div class="kdsComments">
											<p><?= $row['comments'];?></p>
										</div>
									<?php endif; ?>

								</div>
								<?php if(auth('is_login')==TRUE): ?>
									<div class="orderfooter new text-center">
										<a href="<?= base_url('admin/kds/order_status_by_ajax/'.$row['id'].'/'.md5($row['shop_id']).'/1') ;?>" class="btn btn-info kdsOrder" data-shop="<?= $row['shop_id'] ;?>"><i class="fa fa-check"></i> &nbsp; <?= lang('start_preparing'); ?></a>
									</div>
								<?php endif; ?>
							
						<?php endif;?>
					<?php endforeach ?>

					<?php foreach ($dine_list as $key => $drow): ?>
						<?php if($drow['status'] == 1 && $drow['is_preparing'] == 0): ?>
							<div class="single_order new">
								<div class="order_header info-light-active">
									<h4><span><?= lang('order_id'); ?> : #<?= $drow['uid'] ;?></span> <span><?= lang('table_no'); ?>: <?= single_select_by_id($drow['table_no'],'table_list')['name'] ;?></span></h4>
								</div>
								<div class="dineorderDetails mt-5 text-center">
									<h4 class="mb-3"><?= lang('token_number'); ?>: <?= $drow['token_number'] ;?></h4>
									<p></p>
								</div>
								<div class="preparedTime">
									<i class="fa fa-clock"></i>
									<p class="showPTime get_time" id="show_time_<?= $drow['id'] ;?>" data-time="<?= $drow['estimate_time'] ;?>" data-id="<?= $drow['id'];?>"></p>
								</div>
								<div class="orderBody">
									<?php foreach ($drow['package_list'] as $key => $package): ?>
										<div class="singleItems">
											<h4><a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($package['id'])); ?>" target="_blank"><?= $package['package_name'] ;?></a></h4>
											<div class="single_item_body">
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($package['all_items'] as $key => $item): ?>
															<?php if(isset($item['is_package']) && $item['is_package']==1): ?>
																	<h4><?=  $item['qty'];?> x <?= $item['package_name'] ;?> 
																<?php else: ?>
																	<h4><?=  $item['qty'];?> x <?= $item['title'] ;?> 
																<?php endif;?>
														<?php endforeach ?>

													</ul>
												</div>
											</div>
											
											
										</div>
									<?php endforeach ?>

								</div>
									<?php if(auth('is_login')==TRUE): ?>
										<div class="orderfooter bg_white text-center">
											<div class="orderfooter new text-center">
												<a href="<?= base_url('admin/kds/order_status_by_ajax/'.$drow['id'].'/'.md5($drow['shop_id']).'/1') ;?>" class="btn btn-info kdsOrder" data-shop="<?= $drow['shop_id'] ;?>"><i class="fa fa-check"></i> &nbsp; <?= lang('start_preparing'); ?></a>
											</div>
										</div>
									<?php endif; ?>
							</div>
						<?php endif;?>
					<?php endforeach ?>
					
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= lang('accepted'); ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body kds" >
				<div class="kds">

					<?php foreach ($order_list as $key => $row): ?>
						<?php if($row['status'] == 1 && $row['is_preparing'] == 1): ?>
						<div class="single_order accepted">
							<div class="order_header new accepted">
								<h4><span>#<?= $row['uid'] ;?></span> 
									<?php if(!empty($row['table_no'])): ?>
										<span><?= lang('table_no'); ?>: <?= single_select_by_id($row['table_no'],'table_list')['name'] ;?></span>
									<?php endif;?>
								</h4>
							</div>
							<div class="customerDetails">
								<p><?= lang('name'); ?>: <b><?= $row['name'] ;?></b></p>
								<?php if(auth('is_login')==TRUE): ?>
										<p><?= lang('phone'); ?>: <b><?= $row['phone'] ;?></b></p>
									<?php endif ?>
								<p><?= lang('price'); ?>: <b> <?= currency_position($row['total'],$shop['id']) ;?></b> </p>
							</div>
							<div class="preparedTime">
								<i class="fa fa-clock"></i>
								<p class="showPTime get_time" id="show_time_<?= $row['id'] ;?>" data-time="<?= $row['estimate_time'] ;?>" data-id="<?= $row['id'];?>"></p>
							</div>
							<div class="orderBody">
								<?php foreach ($row['all_items'] as $key => $item): ?>
									<div class="singleItems">
										<?php if(isset($item['is_package']) && $item['is_package']==1): ?>
											<h4><?=  $item['qty'];?> x <?= $item['package_name'] ;?> 
										<?php else: ?>
											<h4><?=  $item['qty'];?> x <?= $item['title'] ;?> 
										<?php endif;?>
										<?php if(isset($item['is_size']) && $item['is_size']==1): ?>
											<label for=""><?= isset($item['size_slug']) && !empty($item['size_slug'])?lang('size').' : '.get_size($item['size_slug'],$item['shop_id']):"" ;?></label>
										<?php endif;?>
									</h4>
										<div class="single_item_body">
											<?php if(isset($item['is_extras']) && $item['is_extras']==1): ?>
												<?php $extraId = json_decode($item['extra_id']); ?>
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($extraId as $key => $ex): ?>
															<li><span>1 x <?= extras($ex,$item['item_id'])->ex_name ;?></span></li>
														<?php endforeach ?>

													</ul>
												</div>
											<?php endif;?>
										</div>
									</div>
								<?php endforeach ?>
								<?php if(!empty($row['comments'])): ?>
									<div class="kdsComments">
										<p><?= $row['comments'];?></p>
									</div>
								<?php endif; ?>
							</div>
							<?php if(auth('is_login')==TRUE): ?>
								<div class="orderfooter text-center">
									<a href="<?= base_url('admin/kds/order_status_by_ajax/'.$row['id'].'/'.md5($row['shop_id']).'/4') ;?>" class="btn btn-info kdsOrder" data-shop="<?= $row['shop_id'] ;?>"><i class="fa fa-check"></i> &nbsp; <?= lang('complete'); ?></a>
								</div>
							<?php endif; ?>
						</div>
						<?php endif;?>
					<?php endforeach ?>

					<?php foreach ($dine_list as $key => $drow): ?>
						<?php if($drow['status'] == 1 && $drow['is_preparing'] == 1): ?>
							<div class="single_order new">
								<div class="order_header info-light-active">
									<h4><span><?= lang('order_id'); ?> : #<?= $drow['uid'] ;?></span> <span><?= lang('table_no'); ?>: <?= single_select_by_id($drow['table_no'],'table_list')['name'] ;?></span></h4>
								</div>
								<div class="dineorderDetails mt-5 text-center">
									<h4 class="mb-3"><?= lang('token_number'); ?>: <?= $drow['token_number'] ;?></h4>
									<p class="fz-18"><b><?= lang('price'); ?></b> : <?= currency_position($drow['total'],restaurant()->id);?></p>
								</div>
								<div class="preparedTime">
									<i class="fa fa-clock"></i>
									<p class="showPTime get_time" id="show_time_<?= $drow['id'] ;?>" data-time="<?= $drow['estimate_time'] ;?>" data-id="<?= $drow['id'];?>"></p>
								</div>
								<div class="orderBody">
									<?php foreach ($drow['package_list'] as $key => $package): ?>
										<div class="singleItems">
											<h4><a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($package['id'])); ?>" target="_blank"><?= $package['package_name'] ;?></a></h4>
											<div class="single_item_body">
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($package['all_items'] as $key => $item): ?>
															<li><span>1 x <?= $item['title'] ;?></span></li>
														<?php endforeach ?>

													</ul>
												</div>
											</div>
											
											
										</div>
									<?php endforeach ?>
								</div>
								<?php if(auth('is_login')==TRUE): ?>
									<div class="orderfooter bg_white text-center">
										<div class="orderfooter new text-center">
											<a href="<?= base_url('admin/kds/order_status_by_ajax/'.$drow['id'].'/'.md5($drow['shop_id']).'/4') ;?>" class="btn btn-info kdsOrder" data-shop="<?= $drow['shop_id'] ;?>"><i class="fa fa-check"></i> &nbsp; <?= lang('complete'); ?></a>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php endif;?>
					<?php endforeach ?>
					
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title"><?= lang('completed'); ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body kds" >
				<div class="kds">

					<?php foreach ($order_list as $key => $row): ?>
						<?php if($row['status'] == 1  && $row['is_preparing'] == 2): ?>

						<div class="single_order completed">
							<div class="order_header new completed">
								<h4><span>#<?= $row['uid'] ;?></span> 
									<?php if(!empty($row['table_no'])): ?>
										<span><?= lang('table_no'); ?>: <?= single_select_by_id($row['table_no'],'table_list')['name'] ;?></span>
									<?php endif;?>
								</h4>
							</div>
							<div class="customerDetails">
								<p><?= lang('name'); ?>: <b><?= $row['name'] ;?></b></p>
								<?php if(auth('is_login')==TRUE): ?>
										<p><?= lang('phone'); ?>: <b><?= $row['phone'] ;?></b></p>
									<?php endif ?>
								<p><?= lang('price'); ?>: <b> <?= currency_position($row['total'],$shop['id']) ;?></b> </p>
							</div>
							<div class="orderBody">
								<?php foreach ($row['all_items'] as $key => $item): ?>
									<div class="singleItems">
										<?php if(isset($item['is_package']) && $item['is_package']==1): ?>
											<h4><?=  $item['qty'];?> x <?= $item['package_name'] ;?> 
										<?php else: ?>
											<h4><?=  $item['qty'];?> x <?= $item['title'] ;?> 
										<?php endif;?>
											
											<?php if(isset($item['is_size']) && $item['is_size']==1): ?>
													<label for=""><?= isset($item['size_slug']) && !empty($item['size_slug'])?lang('size').' : '.get_size($item['size_slug'],$item['shop_id']):"" ;?></label>
												<?php endif;?>
										</h4>
										<div class="single_item_body">
											<?php if(isset($item['is_extras']) && $item['is_extras']==1): ?>
												<?php $extraId = json_decode($item['extra_id']); ?>
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($extraId as $key => $ex): ?>
															<li><span>1 x <?= extras($ex,$item['item_id'])->ex_name ;?></span></li>
														<?php endforeach ?>

													</ul>
												</div>
											<?php endif;?>
										</div>
									</div>
								<?php endforeach ?>
								<?php if(!empty($row['comments'])): ?>
									<div class="kdsComments">
										<p><?= $row['comments'];?></p>
									</div>
								<?php endif; ?>
							</div>
							<?php if(auth('is_login')==TRUE): ?>
								<div class="orderfooter text-center">
									<a href="<?= base_url('admin/kds/order_status_by_ajax/'.$row['id'].'/'.md5($row['shop_id']).'/2') ;?>" class="btn btn-info kdsOrder" data-shop="<?= $row['shop_id'] ;?>"><i class="fa fa-check"></i> &nbsp;  <?= lang('serve'); ?></a>
								</div>
							<?php endif; ?>
						</div>
						<?php endif;?>
					<?php endforeach ?>




					<?php foreach ($dine_list as $key => $drow): ?>
						<?php if($drow['status'] == 1 && $drow['is_preparing'] == 2): ?>
							<div class="single_order new">
								<div class="order_header success-light-active">
									<h4><span><?= lang('order_id'); ?> : #<?= $drow['uid'] ;?></span> <span><?= lang('table_no'); ?>: <?= single_select_by_id($drow['table_no'],'table_list')['name'] ;?></span></h4>
								</div>
								<div class="dineorderDetails mt-5 text-center">
									<h4 class="mb-3"><?= lang('token_number'); ?>: <?= $drow['token_number'] ;?></h4>
									<p class="fz-18"><b><?= lang('price'); ?></b> : <?= currency_position($drow['total'],restaurant()->id);?></p>
								</div>
								
								<div class="orderBody">
									<?php foreach ($drow['package_list'] as $key => $package): ?>
										<div class="singleItems">
											<h4><a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($package['id'])); ?>" target="_blank"><?= $package['package_name'] ;?></a></h4>
											<div class="single_item_body">
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($package['all_items'] as $key => $item): ?>
															<li><span>1 x <?= $item['title'] ;?></span></li>
														<?php endforeach ?>

													</ul>
												</div>
											</div>
											
											
										</div>
									<?php endforeach ?>
								</div>
								<div class="orderfooter bg_white text-center">
									<?php if(auth('is_login')==TRUE): ?>
										<div class="orderfooter new text-center">
											<a href="<?= base_url('admin/kds/order_status_by_ajax/'.$drow['id'].'/'.md5($drow['shop_id']).'/2') ;?>" class="btn btn-info kdsOrder" data-shop="<?= $drow['shop_id'] ;?>"><i class="fa fa-check"></i> &nbsp;  <?= lang('serve'); ?></a>
										</div>
									<?php endif; ?>
								</div>

							</div>
						<?php endif;?>
					<?php endforeach ?>
					
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>

	<div class="col-md-3 ">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= lang('served'); ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body kds" >
				<div class="kds">

					<?php foreach ($order_list as $key => $row): ?>
						<?php if($row['status'] == 2): ?>
						<div class="single_order served">
							<div class="order_header new served">
								<h4><span>#<?= $row['uid'] ;?></span> 
									<?php if(!empty($row['table_no'])): ?>
										<span><?= lang('table_no'); ?>: <?= single_select_by_id($row['table_no'],'table_list')['name'] ;?></span>
									<?php endif;?>
								</h4>
							</div>
							<div class="customerDetails">
								<p><?= lang('name'); ?>: <b><?= $row['name'] ;?></b></p>
								<?php if(auth('is_login')==TRUE): ?>
										<p><?= lang('phone'); ?>: <b><?= $row['phone'] ;?></b></p>
									<?php endif ?>
								<p><?= lang('price'); ?>: <b> <?= currency_position($row['total'],$shop['id']) ;?></b> </p>
							</div>
							<div class="orderBody">
								<?php foreach ($row['all_items'] as $key => $item): ?>
									<div class="singleItems">
										<?php if(isset($item['is_package']) && $item['is_package']==1): ?>
											<h4><?=  $item['qty'];?> x <?= $item['package_name'] ;?> 
										<?php else: ?>
											<h4><?=  $item['qty'];?> x <?= $item['title'] ;?> </h4>
										<?php endif;?>

										<?php if(isset($item['is_size']) && $item['is_size']==1): ?>
											<label for=""><?= isset($item['size_slug']) && !empty($item['size_slug'])?lang('size').' : '.get_size($item['size_slug'],$item['shop_id']):"" ;?></label>
										<?php endif;?>
										<div class="single_item_body">
											<?php if(isset($item['is_extras']) && $item['is_extras']==1): ?>
												<?php $extraId = json_decode($item['extra_id']); ?>
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($extraId as $key => $ex): ?>
															<li><span>1 x <?= extras($ex,$item['item_id'])->ex_name ;?></span></li>
														<?php endforeach ?>

													</ul>
												</div>
											<?php endif;?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							<?php if(!empty($row['comments'])): ?>
								<div class="kdsComments">
									<p><?= $row['comments'];?></p>
								</div>
							<?php endif; ?>
						</div>
						<?php endif;?>
					<?php endforeach ?>

					<?php foreach ($dine_list as $key => $drow): ?>
						<?php if($drow['status'] == 2): ?>
							<div class="single_order new">
								<div class="order_header info-light-active">
									<h4><span><?= lang('order_id'); ?> : #<?= $drow['uid'] ;?></span> <span><?= lang('table_no'); ?>: <?= single_select_by_id($drow['table_no'],'table_list')['name'] ;?></span></h4>
								</div>
								<div class="dineorderDetails mt-5 text-center">
									<h4 class="mb-3"><?= lang('token_number'); ?>: <?= $drow['token_number'] ;?></h4>
									<p class="fz-18"><b><?= lang('price'); ?></b> : <?= currency_position($drow['total'],restaurant()->id) ;?></p>
								</div>
								
								<div class="orderBody">
									<?php foreach ($drow['package_list'] as $key => $package): ?>
										<div class="singleItems">
											<h4><a href="<?= base_url('qr-menu/'.html_escape(auth('username')).'/'.md5($package['id'])); ?>" target="_blank"><?= $package['package_name'] ;?></a></h4>
											<div class="single_item_body">
												<div class="extrasArea kds details_view mt-5">
													<ul>
														<?php foreach ($package['all_items'] as $key => $item): ?>
															<li><span>1 x <?= $item['title'] ;?></span></li>
														<?php endforeach ?>

													</ul>
												</div>
											</div>
											
											
										</div>
									<?php endforeach ?>
								</div>
								

							</div>
						<?php endif;?>
					<?php endforeach ?>
					
				</div>	
			</div><!-- /.box-body -->
		</div>
	</div>
	<!-- end dine-in -->

</div><!-- end row -->



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