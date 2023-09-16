<div class="row">
	<div class="form-group col-md-12">
		<div class="room_service mb-10">
			<?php $hotel_list =$this->common_m->get_my_hotel($shop_id); ?>
			<div class="row">
				<div class="col-md-6">
					<div class="hotelName">
						<label for=""><?= lang('select'); ?></label>
						<select name="hotel_id" class="form-control hotel_name" id="hotel_name">
							<option value=""><?= lang('select'); ?></option>
							<?php foreach ($hotel_list as $key => $hotel): ?>
								<option value="<?= $hotel['id'];?>"><?=  $hotel['hotel_name'];?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="col-md-12">
					<div class="roomNumbers">

					</div>
				</div>

			</div> 
		</div>
	</div>
</div>