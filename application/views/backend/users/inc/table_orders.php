<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="card tableCard">
			<div class="card-header"> 
				<h4><?= lang('tables');?></h4>
				<?php 
					$emptyIcon = '<i class="fa fa-minus"></i>';
					$emptyText = lang('the_table_is_empty');
					$customerIcon = '<i class="icofont-fork-and-knife"></i>';
					$customerText = lang('there_are_customers');
					$newIcon = '<i class="fa fa-bell-o"></i>';
					$newText = lang('have_a_new_order');
					$waiterIcon = '<i class="icofont-bell"></i>';
					$waiterText = lang('waiter_calling');
				?>
				<ul>

					<li><?= $emptyIcon;?> <span><?= $emptyText;?></span></li>
					<li><?= $customerIcon;?> <span><?= $customerText;?></span></li>
					<li><?= $newIcon;?> <span><?= $newText;?></span></li>
					<li><?= $waiterIcon;?> <span><?= $waiterText;?></span></li>
				</ul>
			</div>
			<div class="card-body">
				<div class="card-content">
					<div class="row TableNotifyArea">
						<?php foreach ($table_list as $key => $row): ?>
							<?php $check_new_order = $this->admin_m->new_dine_in_order(restaurant()->id,$row['id']); ;?>
							<?php $is_customer = $this->admin_m->customer_availabity(restaurant()->id,$row['id']); ;?>
							<?php $is_waiter = $this->admin_m->call_waiter_notify(restaurant()->id,$row['id']); ;?>
							<?php 
								if(isset($check_new_order) && $check_new_order>0):
									$orderType = "newOrder";
									$icon = $newIcon;
									$text = $newText;
									$isEmpty = FALSE;
								elseif(isset($is_customer) && $is_customer > 0):
									$orderType = "isCustomer";
									$icon = $customerIcon;
									$text = $customerText;
									$isEmpty = FALSE;
								else:
									$orderType = "empty";
									$icon = $emptyIcon;
									$text = $emptyText;
									$isEmpty = TRUE;
								endif;


							?>
							<div class="col-md-3">
								<div class="singleTables <?= isset($orderType)?$orderType:'';?> <?= isset($is_waiter) && $is_waiter > 0 ?"newWaiter":"";;?>">
									<div class="tableIcon">
										<?php if($isEmpty==TRUE && isset($is_waiter) && $is_waiter > 0): ?>
											<?= isset($is_waiter) && $is_waiter > 0 ?'<i class="icofont-bell"></i>':"";;?>
										<?php else:?>
											<?= isset($icon)?$icon:'';?>
											<?= isset($is_waiter) && $is_waiter > 0 ?'<i class="icofont-bell"></i>':"";;?>
										<?php endif;?>			
										
										
									</div>
									<div class="singleTableDetails">
										<?php if($isEmpty==TRUE && isset($is_waiter) && $is_waiter > 0): ?>
											<p><?= isset($waiterText)?$waiterText:'';?></p>
										<?php else:?>
											<p><?= isset($text)?$text:'';?></p>
											<?php if(isset($is_waiter) && $is_waiter > 0): ?>
												<?= $waiterText;?>
											<?php endif;?>	
										<?php endif; ?>
										<h4><?= $row['name'];?></h4>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				</div><!-- card-content -->
			</div><!-- card-body -->
		</div><!-- card -->
	</div>
</div>
