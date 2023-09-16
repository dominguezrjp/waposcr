<div class="row">
	<?php include APPPATH.'views/backend/common/inc/leftsidebar.php'; ?>
	<form class="email_setting_form" action="<?= base_url('admin/restaurant/add_reservation/') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header space-between">
					<h3 class="card-title"><?= lang('room_services');?></h3>
					<div class="">
						<a href="<?= base_url("admin/room_services/add_new_hotel");?>" class="btn btn-secondary"><i class="fa fa-plus"></i> <?= lang('add_new');?></a>
					</div>
						
				</div>
				<div class="card-body">
					
					<table class="table table-responsive table-striped">
						<thead>
							<tr>
								<th><?= lang('sl');?></th>
								<th width="30%"><?= lang('hotel_name');?></th>
								<th><?= lang('room_numbers');?></th>
								<th><?= lang('status');?></th>
								<th width="10%"><?= lang('action');?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($hotel_list as $key => $row): ?>
								<tr>
								    <td><?= $key+1;?></td>
								    <td><?= $row['hotel_name'];?></td>
								    <td>
								    	<div class="roomNumbers">
								    		<?php foreach (json_decode($row['room_numbers'],true) as $key2 => $room): ?>
								    			<label class="label label-default mb-10"><?= $room;?> <a href="<?= base_url("admin/room_services/delete_room_number/{$row['id']}?key={$key2}");?>" class="badge btn-danger"><i class="fa fa-trash-o"></i></a></label>
								    		<?php endforeach ?>
								    	</div>

								    </td>
								    <td>
								    	<?php if(is_access('change-status')==1): ?>
								    		<a href="javascript:;" data-id="<?= html_escape($row['id']);?>" data-status="<?= html_escape($row['status']);?>" data-table="hotel_list" class="label <?= $row['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $row['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $row['status']==1?(!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a>
								    	<?php endif; ?>
								    </td>
								    <td>
								    	<a href="<?= base_url("admin/room_services/edit_hotel/{$row['id']}");?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
								    	<a href="<?= base_url('delete-item/'.html_escape($row['id']).'/hotel_list'); ?>" class=" action_btn btn btn-danger btn-sm" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> </a>
								    </td>
							    </tr>
							<?php endforeach ?>
							
						</tbody>

					</table>
						
				</div><!-- card-body -->
				
			</div><!-- card -->
		</div><!-- col-9 -->
	</form>	
</div>

