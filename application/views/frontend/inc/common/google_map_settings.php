<?php $gmap_settings = !empty(settings()['gmap_config'])?json_decode(settings()['gmap_config']):'' ?>
<?php 
	if((isset($shop->is_admin_gmap) && $shop->is_admin_gmap==1) && (!empty($gmap_settings->is_gmap_key) && $gmap_settings->is_gmap_key==1) && isset($shop->is_gmap) && $shop->is_gmap ==0):
		$gmap = !empty(settings()['gmap_config'])?json_decode(settings()['gmap_config']):'';
		$gmap_key = $gmap->gmap_key;
	elseif(isset($shop->is_gmap) && $shop->is_gmap ==1 && !empty($shop->gmap_key)):
		$gmap_key = $shop->gmap_key;
	else:
		$gmap_key = '';
	endif;
?>

<!-- pickup point map -->
<?php if(isset($gmap_key) && !empty($gmap_key)): ?>
	   
		<a href="<?= $gmap_key;?>" id="gmapKey" ></a>
		<script src="https://maps.googleapis.com/maps/api/js?key=<?=$gmap_key ;?>&libraries=places"></script>
		
		<script src="<?= base_url("assets/frontend/plugins/gmap.js");?>"></script>

		<?php $this->load->view('layouts/pickup_point_map',['id' => $shop->id,'key' =>$gmap_key]); ?>

<?php endif; ?>
<!-- pickup point map -->