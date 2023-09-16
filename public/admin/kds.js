(function ($) {
  "use strict";


	var base_url = $('#base_url').attr('href');
	var csrf_value = $('#csrf_value').attr('href');
	var shop_id = $('#id').attr('href');


	$(document).ready(function() {
	    setInterval(function(){
	     	order_notification();
	    }, 20000);

	});

function order_notification(){
  var url = `${base_url}/admin/kds/get_new_order/${shop_id}`;
  $.get(url, {'csrf_test_name': csrf_value }, function(json){
    if (json.st == 1) {
    	$('.view_kds').html(json.load_data);
    }else{
      return true;
    }
  },'json');
}


/*----------------------------------------------
  kds order status
----------------------------------------------*/

$(document).on('click','.kdsOrder',function(){
    var id = $(this).data('id');
    var shop_id = $(this).data('shop');
    var url = $(this).attr('href');
    $.post(url, {'csrf_test_name': csrf_value }, function(json){
      if(json.st == 1){
        $('.view_kds').html(json.load_data);       
      }
    },'json');
    return false;
  });


$(function(){
    $(document).on('submit','.form-submit',function(){
      $('.submit_btn').prop('disabled', true);
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){
            if (json.st == 1) {
                $(".reg_msg").html(json.msg).slideDown(); 
                $(".form-submit")[0].reset(); 
                $('.customModal').modal('hide');
                window.location.reload();
            }else{
                $(".reg_msg").html(json.msg).slideDown();
                $('.submit_btn').prop('disabled', false);
            }
            setTimeout(function(){ $('.reg_msg').fadeOut();}, 2000);
        },'json');
        return false;
    });
 });





}(jQuery)); 