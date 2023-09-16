<!-- Modal -->
<div id="SetTimeModal" class="modal fade setTimeModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?= lang('set_prepared_time'); ?></h4>
			</div>
			<form action="<?= base_url('admin/restaurant/order_status_by_ajax/1/1') ;?>" method="post" autocomplete="off" id="ajaxAccept">
				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

				<div class="modal-body">
					<div class="setTime">
						<div class="row">
							<div class="col-md-5 pr-5">
								<input type="number" name="es_time" class="form-control" placeholder="<?= lang('set_time'); ?>" value="<?= !empty(restaurant()->es_time)? restaurant()->es_time: 0 ;?>" required>
							</div>
							<div class="col-md-7 pl-5">
								<select name="time_slot" class="form-control" id="" required>
									<option value=""><?= lang('select'); ?></option>
									<option value="minutes" <?= restaurant()->time_slot=="minutes"?"selected":"" ;?>><?= lang('minutes'); ?></option>
									<option value="hours" <?= restaurant()->time_slot=="hours"?"selected":"" ;?>><?= lang('hours'); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="uid" class="uid" value="">
					<div class="text-right">
						<button type="submit" class="btn btn-info"><?= lang('submit'); ?></button>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>
