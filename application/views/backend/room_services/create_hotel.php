<div class="row">
	<div class="col-md-6">
		<form class="email_setting_form" action="<?= base_url('admin/room_services/create_new_hotel/') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
				<div class="card">
					<div class="card-header space-between">
						<h3 class="card-title"><?= lang('add_new');?></h3>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label for=""><?= lang('hotel_name');?></label>
							<input type="text" name="hotel_name"  class="form-control" placeholder="<?= lang('hotel_name');?>" value=
							'<?= !empty($data['hotel_name'])?$data['hotel_name']:"";?>'>
						</div>

						<div class="form-group">
							<label for=""><?= lang('room_numbers');?> </label>

							<?php if(isset($data['room_numbers']) && !empty($data['room_numbers'])): ?>
								<div class="roomNumbers mb-10 mt-10">
									<?php foreach (json_decode($data['room_numbers'],true) as $key2 => $room): ?>
										<label class="label label-default mb-10"><?= $room;?> <a href="<?= base_url("admin/room_services/delete_room_number/{$data['id']}?key={$key2}");?>" class="badge btn-danger"><i class="fa fa-trash-o"></i></a> </label>
										<input type="hidden" name="room_numbers[]" value="<?= $room;?>">
									<?php endforeach ?>
								</div>
							<?php endif ?>



							<div class="row mb-15">
								<div class="col-md-2">
									<input type="text" name="room_numbers[]" id="" class="form-control">
								</div>
								<div class="col-md-2">
									<input type="text" name="room_numbers[]" id="" class="form-control">
								</div>
								<div class="col-md-2">
									<input type="text" name="room_numbers[]" id="" class="form-control">
								</div><div class="col-md-2">
									<input type="text" name="room_numbers[]" id="" class="form-control">
								</div>
								<div class="col-md-2">
									<input type="text" name="room_numbers[]" id="" class="form-control">
								</div>
								<div class="col-md-2">
									<input type="text" name="room_numbers[]" id="" class="form-control">
								</div>
							</div>

							<div class="input_fields_wrap"></div>
							<div class="text-right">
								<a href="javascript:;" class="btn btn-secondary btn-sm add_field_buttons"><i class="fa fa-plus"></i> <?= lang('add_new');?></a>
							</div>
						</div>
						
					</div><!-- card-body -->
					<div class="card-footer">
						<input type="hidden" name="id" value="<?= isset($data['id'])?html_escape($data['id']):0; ?>">
						<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
					</div>
				</div><!-- card -->
		</form>
	</div>
</div>