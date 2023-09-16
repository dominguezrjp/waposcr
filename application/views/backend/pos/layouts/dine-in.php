<?php $dinein =$this->common_m->get_table_list($shop_info->id); ?>
<?php foreach($dinein as $key => $dine): ?>
	<?php $check = $this->pos_m->check_booked_table($dine['id'],$shop_info->id); ?>
	<?php $checkTable = $this->pos_m->check_total_booked_table($dine['id'],$shop_info->id); ?>
	<?php $availablePerson = $dine['size']-$check; ?>
	<?php if(temp('is_dine_in')==TRUE && $dine['id']==temp('dine-in')->temp_table_no): ?>
	<div class="singleDine-in active">
		<i class="icofont-dining-table"></i>
		<div class="tableDeatils">
			<h4><?=  $dine['name'];?> - <?= $dine['area_name'];?> </h4>
			<p><?= lang('remaining_person');?> <?= $dine['size'] - temp('dine-in')->total_person;?> / <?= $dine['size'];?></p>
			<div class="orderExists">
				<?php foreach ($checkTable as $key => $check_table): ?>
					<p><span>#<?= $check_table->uid;?> - <?= $check_table->all_person;?> <?= lang('person');?></span></p>
				<?php endforeach ?>
				<p><span>#<?= temp('dine-in')->temp_id;?> - <?= temp('dine-in')->temp_person;?> <?= lang('person');?></span></p>
				<div class="addPersonUser mt-10">
					
				</div>
			</div>
		</div><!-- tableDeatils -->

	</div><!-- singleDine-in -->
	<?php else: ?>
		<div class="singleDine-in">
			<i class="icofont-dining-table"></i>
			<div class="tableDeatils">
				<h4><?=  $dine['name'];?> - <?= $dine['area_name'];?> </h4>
				<p><?= lang('remaining_person');?> <?= $availablePerson;?> / <?= $dine['size'];?></p>
				<div class="orderExists">
					<?php foreach ($checkTable as $key => $check_table): ?>
						<p><span>#<?= $check_table->uid;?> - <?= $check_table->all_person;?> <?= lang('person');?></span></p>
					<?php endforeach ?>
				</div>
				<?php if($check < $dine['size']): ?>
					<form action="" method="post" class="tempForm hidden">
						<?= csrf();?>
					</form>
					<!-- form -->
					<form action="<?= base_url("admin/pos/add_table");?>" method="post" class="tempForm<?= $dine['id'];?>">
						<?= csrf();?>
						<!-- form -->
						<div class="addtableOptin">
							<div class="addtbl">
								<select name="temp_person" id="add_table" class="form-control">
									<?php for($i=1; $i<= $availablePerson;$i++): ?>
										<option value="<?= $i;?>"><?= $i;?></option>
									<?php endfor; ?>
								</select>
								<input type="hidden" name="shop_id" value="<?= base64_encode(restaurant()->id);?>">
								<input type="hidden" name="temp_table_no" value="<?= $dine['id'];?>">
								<button class="btn btn-sm btn-secondary addTableBtn" data-id="<?= $dine['id'];?>" data-table="<?= $dine['id'];?>" type="button"><?= lang('add');?> </button>
							</div>
						</div>
					</form>
				<?php else: ?>
					<div class="addPersonUser">
						<sapn class="bg-warning-soft label"><?= lang('booked');?></span>
						</div>
					<?php endif; ?>
				</div><!-- tableDeatils -->

			</div><!-- singleDine-in -->
	<?php endif ?>
<?php endforeach; ?>

<input type="hidden" name="table_no" value="<?= !empty(temp('dine-in')->temp_table_no)?temp('dine-in')->temp_table_no:0;?>">
<input type="hidden" name="person" value="<?= !empty(temp('dine-in')->temp_person)?temp('dine-in')->temp_person:0;?>">

