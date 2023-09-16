<?php $shop = restaurant(auth('id')) ?>
<?php $gmap_settings = !empty(settings()['gmap_config'])?json_decode(settings()['gmap_config']):'' ?>
<?php 
	if((isset($shop->is_admin_gmap) && $shop->is_admin_gmap==1) && (!empty($gmap_settings->is_gmap_key) && $gmap_settings->is_gmap_key==1)):
		$gmap = !empty(settings()['gmap_config'])?json_decode(settings()['gmap_config']):'';
		$gmap_key = $gmap->gmap_key;
	elseif(isset($shop->is_gmap) && $shop->is_gmap ==1 && !empty($shop->gmap_key)):
		$gmap_key = $shop->gmap_key;
	else:
		$gmap_key = '';
	endif;
?>
<?php if(isset($gmap_key) && !empty($gmap_key)): ?>
 <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=  $gmap_key;?>" type="text/javascript"></script>
<?php endif;?>
<style>
	#map {
	  height: 300px;
	}
</style>
<div class="row">
	<?php include APPPATH.'views/backend/common/inc/leftsidebar.php'; ?>
	
		<div class="col-md-4">
			<form class="email_setting_form" action="<?= base_url('admin/restaurant/add_locations/'.$shop_id) ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4><?= lang('add_new_location'); ?></h4>
						<p><?= lang('customer_will_find_restaurant_with_location'); ?></p>
						
					</div>
					<div class="card-body">
						<div class="row p-15">
							<div class="row">
								<div class="form-group col-md-12">
									<label for="title"><?= !empty(lang('address'))?lang('address'):" address";?> *</label>
									<input type="text" name="address" id="address" class="form-control" placeholder="<?= !empty(lang('address'))?lang('address'):"address";?>" value="<?= !empty($data['address'])?html_escape($data['address']):""; ?>">
								</div>

								<div class="form-group col-md-12">
									<label for="title"><?= !empty(lang('latitude'))?lang('latitude'):"latitude";?></label>
									<input type="text" name="latitude" class="form-control latitude" value="<?= !empty($data['latitude'])?html_escape($data['latitude']):0; ?>">
								</div>

								<div class="form-group col-md-12">
									<label for="title"><?= !empty(lang('longitude'))?lang('longitude'):"longitude";?></label>
									<input type="text" name="longitude" class="form-control longitude" value="<?= !empty($data['longitude'])?html_escape($data['longitude']):0; ?>">
								</div>
								<div class="form-group col-md-12">
									<div id="map"></div>
								</div>
							</div>
						</div><!-- row -->
							
					</div><!-- card-body -->
					<div class="card-footer">
						<input type="hidden" name="id" value="<?= isset($data['id']) && $data['id'] !=0?html_escape($data['id']):0 ?>">
						<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
					</div>
				</div><!-- card -->
			</div><!-- col-9 -->
		</form>
			
		</div><!-- col-9 -->
	

	<div class="col-md-5">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4><?= lang('locations'); ?></h4>
					</div>
					<div class="card-body">
						<div class="row p-15">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
											<th><?= lang('address'); ?></th>
											<th><?= lang('latitude'); ?></th>
											<th><?= lang('longitude'); ?></th>
											<th><?= lang('action'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1; foreach ($location_list as $row): ?>
										<tr>
											<td><?= $i;?></td>
											<td><?= html_escape($row['address']); ?></td>
											<td><?= html_escape($row['latitude']); ?></td>
											<td><?= html_escape($row['longitude']); ?></td>
											<td>
												
												<div class="btn-group">
													<a href="javascript:;" class="dropdown-btn dropdown-toggle btn btn-danger btn-sm btn-flat" data-toggle="dropdown" aria-expanded="false">
														<span class="drop_text"><?= lang('action'); ?> </span> <span class="caret"></span>
													</a>

													<ul class="dropdown-menu dropdown-ul" role="menu">
														<li class="cl-info-soft"><a href="<?= base_url('admin/restaurant/edit_location/'.html_escape($row['id']).'/'.$shop_id); ?>" ><i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a></li>
														<li class="cl-danger-soft"><a href="<?= base_url('delete-item/'.html_escape($row['id']).'/shop_location_list'); ?>" class=" action_btn" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a></li>

													</ul>
												</div><!-- button group -->

											</td>
										</tr>
										<?php $i++; endforeach ?>
									</tbody>
								</table>
							</div>
						</div><!-- row -->
						
					</div><!-- card-body -->
				</div><!-- card -->
			</div>
		</div>
	</div>		
</div>

<script type="text/javascript">
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (p,showError) {
        var LatLng = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
        var mapOptions = {
            center: LatLng,
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);


        let infoWindow = new google.maps.InfoWindow({
		    content: '<?= lang('click_the_map_to_get_lan_ln') ;?>',
		    position: LatLng,

		  });

        infoWindow.open(map);

       console.log(`${p.coords.latitude} + ${p.coords.longitude}`);
        map.addListener("click", (mapsMouseEvent) => {
	    // Close the current InfoWindow.
	    infoWindow.close();
	    // Create a new InfoWindow.
	    infoWindow = new google.maps.InfoWindow({
	    	position: mapsMouseEvent.latLng,
	    });
	    infoWindow.setContent(
	    	JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
	    	);
	    var latlan = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
	    var obj = JSON.parse(latlan);
	    $('.latitude').val(obj.lat);
	    $('.longitude').val(obj.lng)
	    console.log(obj);
	    infoWindow.open(map);
	});

    });
    google.maps.event.addDomListener(window, 'load');
} else {
    alert('Geo Location feature is not supported in this browser.');
}


function showError(error)
  {
  switch(error.code) 
    {
    case error.PERMISSION_DENIED:
      x.innerHTML="User denied the request for Geolocation."
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML="Location information is unavailable."
      break;
    case error.TIMEOUT:
      x.innerHTML="The request to get user location timed out."
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML="An unknown error occurred."
      break;
    }
  }

</script>








