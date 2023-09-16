<?php $areas = $this->common_m->get_all_by_shop_id_no_status($id,'pickup_points_area'); ?>
<?php if(count($areas) >0): ?>
<html>
    <head>

<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0; padding: 0 }
  #map_canvas { height: 100% }
</style>

<script>
	var locations = [
			<?php  foreach ($areas as $key => $area): ?>
				['<?= $area['name'] ;?>', <?= $area['latitude'] ;?>, <?= $area['longitude'] ;?>, '<?= $area['address'] ;?>',<?= $area['id'] ;?>],
			<?php endforeach ?>
		];
</script>

<script type="text/javascript">


	function initialize() {

		var myOptions = {
			center: new google.maps.LatLng(23.755330681515762, 90.4197692380329),
			zoom: 12,
			mapTypeId: google.maps.MapTypeId.ROADMAP

		};
		var map = new google.maps.Map(document.getElementById("default"),
			myOptions);

		setMarkers(map,locations)

	}



	function setMarkers(map,locations){

		var marker, i

		for (i = 0; i < locations.length; i++)
		{  

			var loan = locations[i][0]
			var lat = locations[i][1]
			var long = locations[i][2]
			var add =  locations[i][3]
			var id =  locations[i][4]

			latlngset = new google.maps.LatLng(lat, long);

			var marker = new google.maps.Marker({  
				map: map, title: loan , position: latlngset, id:id  
			});
			map.setCenter(marker.getPosition())


			var content = `Pickup Point: ${loan} </h3> Address: ${add} <br> <a href="javascript:;" data-id="${id}" class="selectPoint">Select point</a>`  

			var infowindow = new google.maps.InfoWindow()

			google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
				return function() {
					infowindow.setContent(content);
					infowindow.open(map,marker);
					$(document).on('click','.selectPoint',function(){
						var onId = $(this).data('id');
						$('.single_pickup_area').removeClass('active');
						$('#active_point_'+onId).addClass('active');
						$('.add_pickpoint_value').val(onId);
						$('.pickup_point_map').removeClass('active');
					})
					
				};
			})(marker,content,infowindow)); 

		}
	}



</script>

	<body onload="initialize()">
		<div class="pickup_point_map">
			<div id="default" style="width:100%; height:100%"></div>
			<a href="javascript:;" class="closeMap"><i class="icofont-close-line-squared fa-2x"></i></a>
		</div> 
	</body>
 </html>

<?php endif;?>