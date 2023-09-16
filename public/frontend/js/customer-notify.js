(function ($) {
	"use strict"

	var base_url = $('#base_url').attr('href');
	var csrf_value = $('#csrf_value').attr('href');
	
	function notification(){
		var url = `${base_url}staff/get_order_list/`;
		$.get(url, {'csrf_test_name': csrf_value }, function(json){
			if (json.st == 1) {
				$('#showOrder').html(json.load_data);
				audio_play(1);
			}else{
				audio_play(0);
				return true;
			}
		},'json');
	}

	$(document).ready(function() {
		setInterval(function(){
			notification();
			console.log('allow');
		}, 10000);

	});


  function audio_play(type){
    var audio = new Audio(`${base_url}assets/frontend/mp3/ring_2.mp3`); 
    
    if(type==1){
      var count = 1
      audio.addEventListener('ended', function(){
        
           if(count <= 2){
             this.currentTime = 0;
              this.play();
              count++;
           }
      
         
      }, false);

      audio.play();
    }else{
      audio.pause();
    }
     
  }

}(jQuery)); 