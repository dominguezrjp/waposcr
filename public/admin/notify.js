(function ($) {
  "use strict"

var base_url = $('#base_url').attr('href');
var csrf_value = $('#csrf_value').attr('href');


/*----------------------------------------------
  Realtime notification
----------------------------------------------*/
function notification(){
  var url = `${base_url}admin/notification/get_ajax_notification/`;
  $.get(url, {'csrf_test_name': csrf_value }, function(json){
    if (json.st == 1) {
      $('.ajax-notification').html(json.load_data);
      audio_play(1);
    }else{
      audio_play(0);
      return true;
    }
  },'json');
}


function table_notification(){
  var url = `${base_url}admin/notification/table_notification/`;
  $.get(url, {'csrf_test_name': csrf_value }, function(json){
    if (json.st == 1) {
      $('.table-ajax-notification').html(json.load_data);
    }else{
      return true;
    }
  },'json');
}


function table_order(){
  var url = `${base_url}admin/notification/table_order/`;
  $.get(url, {'csrf_test_name': csrf_value }, function(json){
    if (json.st == 1) {
      $('#tableOrder').html(json.load_data);
    }else{
      return true;
    }
  },'json');
}

$(document).ready(function() {
    setInterval(function(){
      notification();
      waiter_notification();
      table_notification();
      
    }, 10000);

});


if ($(window).width() <= 991){
  $(".wow").removeClass("wow");
}


$(document).on('click','.notify_btn',function(){
    var url = `${base_url}admin/menu/notification_off`
      $.post(url, {'csrf_test_name': csrf_value }, function(json){
        if(json.st == 1){
          $('.notifications-menu').html(json.data);
          $('.is_notify').data('notify',0);
           audio_play(0);
        }
      },'json');
      return false;
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
/*----------------------------------------------
  Realtime notification
----------------------------------------------*/

function waiter_notification(){
  var url = `${base_url}admin/notification/get_waiter_notification/`;
  $.get(url, {'csrf_test_name': csrf_value }, function(json){
    if (json.st == 1) {
      $('.waiter_notificaiton > ul').html(json.load_data);
      audio_play(1);
    }else{
      audio_play(0);
      return true;
    }
  },'json');
}



function orderList(){
  var url = `${base_url}admin/restaurant/new_order`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if (json.st == 1) {
      $('#list_load').html(json.load_data);
    }
  },'json');
}

$(document).on('click','.closeMergeNotification',function(){
  let id = $(this).data('id');
  var url = `${base_url}admin/notification/close_merge/${id}`;
  $.get(url, {'csrf_test_name': csrf_value }, function(json){
    if (json.st == 1) {
      $(`.mergeLi_${id}`).fadeOut();
    }
  },'json');

});


  $(document).ready(function() {
    var isNewOrder = $('.isFilter');
    if(isNewOrder.length ==1){
      console.log('...');
      setInterval(function(){
        orderList();
      }, 15000);
    }else{
      console.log('..');
    }

  });
    

}(jQuery)); 