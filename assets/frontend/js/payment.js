(function ($) {
  "use strict";

var base_url = $('#base_url').attr('href');
var csrf_value = $('#csrf_value').attr('href');





$(function(){
    $(document).on('submit','.order_form',function(){
      $(this).addClass('submit_form').append('<span class="ajax_submit"></span>');
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){
           if (json.st == 1) {
                ajax_msg(json.msg);
                $(".order_form")[0].reset(); 
                $('.cartItemDetails').slideUp();
                $('.successMsgArea').slideDown();
                $('.order_id').html(json.order_id);
                $('#qr_link').attr('src',`${base_url}${json.qrlink}`);
                $('#downloadLink').attr('href',`${json.qrlink}`);
                $('#track_order_btn').attr('href',`${json.track_link}`);
                $('.whatsapp_share_data').html(json.load_data);

            }else if(json.st == 2){
                window.location.href = `${json.url}`;

            }else{
                ajax_msg(json.msg);
            }
        },'json');
        return false;
    });


    // Reset Cart
    $(document).on('click','.ok_btn',function(){
      var url = `${base_url}profile/destroy_cart/`;
        $.post(url, {'csrf_test_name': csrf_value }, function(json){
        if(json.st == 1){
            location.reload();
        }
      },'json');
        
    });

     $(document).on('click','.redirect_btn',function(){
     	var redirect_url = $(this).attr('href');
      	var url = `${base_url}profile/destroy_cart/`;
        $.post(url, {'csrf_test_name': csrf_value }, function(json){
        if(json.st == 1){
           window.location.href = redirect_url;
        }
      },'json');
        
    });

    // download orderQr
    $(document).on('click','.qrDownloadBtn',function(e){
      $('.qrDownloadBtn').html(`<span class="downloadMsg"><i class="icofont-check-alt"></i> Downloaded</span>`);
        
    });

 });

//redirect whats app
$(document).on('click','.redirect_whatsapp',function(){
  var redirect = $(this).data('url');
  var url = `${base_url}profile/destroy_cart/`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
      window.open(redirect, '_blank');
    }
  },'json');

});


//track order using ajax
$(function(){
    $(document).on('submit','.track_form',function(){
      $(this).addClass('submit_form').append('<span class="ajax_submit"></span>');
      var url = $(this).attr('action');
      $.post(url, $(this).serialize(), function(json){
       if (json.st == 1) {
        ajax_msg(json.msg);
        $(".track_form")[0].reset(); 
        $('.track_form_area').slideUp();
        $('.track_list').slideDown();
        $('.track_list').html(json.load_data);
      }else{
        ajax_msg(json.msg);
      }
    },'json');
    return false;
  });

   $(document).on('click','.back_track_form',function(){
         $('.track_form_area').slideDown();
          $('.track_list').slideUp();
    });

   $(document).on('click','.base',function(){
         $('.show_menu_details').toggleClass('active');
    });

   $(document).on('click','.closeNavMenu',function(){
         $('.show_menu_details').removeClass('active');
    });

 });

$(function(){

  var key =  $('#rzp-button1').attr("data-key");
 
 if(key){
  var $this = $('#rzp-button1');
    var totalAmount = $this.attr("data-amount");
    var product_id =  $this.attr("data-id");
    var username =  $this.attr("data-name");
    var customer_name =  $this.attr("data-customer");
    var phone =  $this.attr("data-phone");
    var currency =  $this.attr("data-currency");
    var totalAmount =  parseFloat(totalAmount)*100;
    var options = {
          "key": `${key}`, // Enter the Key ID generated from the Dashboard
          "amount": `${totalAmount.toFixed(0)}`, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
          "currency": `${currency}`,
          "name": `${username}`,
          "description": "",
          "image": `${base_url}assets/frontend/images/razorpay.png`,
          "csrf_test_name": "csrf_value",
          //"order_id": "15", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
          "callback_url": `${base_url}service/razorpay_payment`,
          "prefill": {
            "name": `${customer_name}`,
            "email": "",
            "contact": ``
          },
          "notes": {
            "address": ""
          },
          "theme": {
            "color": "#3399cc"
          },
          "handler": function (response){
            $.ajax({
              url: `${base_url}user-razorpay-payment/`,
              type: 'post',
              dataType: 'json',
              data: {
               razorpay_payment_id: response.razorpay_payment_id , totalAmount : totalAmount ,product_id : product_id,csrf_test_name: csrf_value, username : username
             }, 
             success: function (json) {
              window.location.href = `${json.url}`;
            }
          });
          },
        };


      var rzp1 = new Razorpay(options);
      document.getElementById('rzp-button1').onclick = function(e){
        rzp1.open();
        e.preventDefault();
      }

  };
});











  $(function(){
    $(document).on('click','.whatsapp_btn',function(){
      var link = $(this).data('link');
      var phoneNo = $('#whatsapp_number').val().replace('+','');
      if(phoneNo ==''){
        return;
      }
     window.open('https://api.whatsapp.com/send?phone=' + phoneNo + '&text=Please check my digital visiting card '+link+'', '_blank');
    })
  });


  $(function(){
    $(document).on('click','.open_card',function(){
      $('.share_card_area').addClass('open');
      })
  });

  $(function(){
    $(document).on('click','.close_card',function(){
      $('.share_card_area').removeClass('open');
      })
  });





}(jQuery)); 