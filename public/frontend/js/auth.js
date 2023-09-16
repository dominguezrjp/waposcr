(function ($) {
  "use strict";

var base_url = $('#base_url').attr('href');
var csrf_value = $('#csrf_value').attr('href');
var yes = $('#yes').attr('href');
var no = $('#no').attr('href');
var are_you_sure = $('#are_you_sure').attr('href');
var cancel = $('#cancel').attr('href');
var success_alert = $('#success').attr('href');
var success_msg = $('#success_msg').attr('href');
var error_alert = $('#error').attr('href');
var error_msg = $('#error_msg').attr('href');
var item_deactive = $('#item_deactive').attr('href');
var item_active = $('#item_active').attr('href');
var want_to_reset_password = $('#want_to_reset_password').attr('href');

var loader_green = `<div class="loadingio-spinner-rolling-bmobyy7r0gw loader_green"><div class="ldio-mp4zm9ojapo"><div></div></div></div>`;
var loader_gray = `<div class="loadingio-spinner-rolling-bmobyy7r0gw loader_gray"><div class="ldio-mp4zm9ojapo"><div></div></div></div>`;
// Admin login
$(function(){
  $('#user_login_form').on('submit',function(e) {
    $(this).addClass('submit_form').append('<span class="ajax_submit"></span>');
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){
            if (json.st == 1) {
                  $("#user_login_form")[0].reset();
                 setTimeout(function(){window.location = json.url;}, 2000);
                 ajax_msg(json.msg);
            }else{
                ajax_msg(json.msg);
            }
        },'json');
        return false;
    });
 });

$(function(){
  $('#recovery_password').on('submit',function(e) {
    $(this).addClass('submit_form').append('<span class="ajax_submit"></span>');
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){
            if (json.st == 1) {
              $('#showField').html(json.data);
              $('#questionModal').modal('show');

                 $('#checkAnswer').on('submit',function(e) {
                        var url = $(this).attr('action');
                        $.post(url, $(this).serialize(), function(json){
                            if (json.st == 1) {
                              $('#showField').html(json.data);
                              $('#questionModal').modal('show');
                              setTimeout(function(){window.location = json.url;}, 2000);
                               ajax_msg(json.msg);
                            }else{
                                ajax_msg(json.msg);
                            }
                        },'json');
                        return false;
                    });



            }else{
                ajax_msg(json.msg);
            }
        },'json');
        return false;
    });
 });

function MSG(valid,msg){
  if(valid==0){
    $.notify({
        icon: 'fa fa-close',
        title: error_alert,
        message:msg
      },{
        type: 'danger'
      },{
          animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
          }
      });
     
  }else if(valid==1){
     $.notify({
        icon: 'fa fa-check',
        title: success_alert,
        message:msg
      },{
        type: 'success'
      },{
          animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
          }
      });
      
  }else if(valid==2){
      $.notify({
        icon: 'fa fa-exclamation-triangle',
        title: 'Warning!',
        message:msg
      },{
        type: 'warning'
      },{
          animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
          }
      });
  }
}

/**
  ***  default ajax form submit
**/ 
$(function(){
    $(document).on('submit','.form-submit',function(){
      $(this).addClass('submit_form').append('<span class="ajax_submit"></span>');
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){
           if (json.st == 1) {
                $(".form-submit")[0].reset(); 
                ajax_msg(json.msg);
                if(json.url =='' || json.url == null || json.url == undefined){
                  return false;
                }else{
                  setTimeout(function(){window.location = json.url;}, 3500);
                }

            }else{
                ajax_msg(json.msg);
            }
        },'json');
        return false;
    });
 });



//Rating submit form
$(function(){
    $(document).on('submit','.rating-submit',function(){
      $(this).addClass('submit_form').append('<span class="ajax_submit"></span>');
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){
           if (json.st == 1) {
                $(".rating-submit")[0].reset(); 
                ajax_msg(json.msg);
                 setTimeout(function(){$('.contacts_area').slideUp();}, 200); 

            }else{
                ajax_msg(json.msg);
            }
        },'json');
        return false;
    });
 });


// all ajax massege

function ajax_msg(data) {
  setTimeout(function(){ $('form').removeClass('submit_form'); jQuery(".ajax_submit").fadeOut()}, 1000);
  setTimeout(function(){ $(".reg_msg").fadeIn().html(data);}, 1000);
  setTimeout(function(){ $('.reg_msg').fadeOut();}, 5000);
}



//check username with ajax keyup
$(function(){
  $(document).on('keyup','#username',function(){
      var val = $(this).val();
      if(val==''){
        return;
      }
      if(val.match(/\s/g)){
        $(".alert_msg").html('No space allowed').addClass('error');
         var newName = val.replace(/\s/g,'');
        $(this).val(newName);
      }

      $('.register_loader').slideDown();
      $('.alert_msg').slideUp();
      var value = encodeURIComponent(val);
        var url =`${base_url}login/check_username/${value}`;
         $.get(url, {'csrf_test_name': csrf_value }, function(json){
          if(json.st == 1){
            setTimeout(function(){ 
              $('.register_loader').slideUp();
              $('.alert_msg').html(json.msg).slideDown().removeClass('error').addClass('success');
              $('.reg_btn').prop('disabled', false);
            }, 2000);
          }else{
            setTimeout(function(){ 
              $('.register_loader').slideUp();
              $('.alert_msg').html(json.msg).slideDown().removeClass('succes').addClass('error');
              $('.reg_btn').prop('disabled', true);
            }, 2000);
          }
       },'json');

      return false;
  });
});

// Items quick view
$(document).on('click','.quick_view',function(){
  var id = $(this).data('id');
  var dataType = $(this).data('type');
  var type;
  if(dataType=='' || dataType==undefined){
    type='item';
  }else{
    type = dataType;
  }
 
  var url = `${base_url}profile/item_details/${id}/${type}`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
      $('#itemModal').modal({backdrop: "static"});
       $(`#item_details`).addClass('load');
      $('.priceTag').addClass('hidden');
      $('#item_details').html(json.load_data);
      setTimeout(function () {
          $('.itemSlider').removeClass('opacity_height_0');
           $('.itemSlider').slick(getSliderSettings());
           $(`#item_details`).removeClass('load');
        }, 500);
     // $(`#itemModal`).removeClass('load');
    }
  },'json');
  return false;
});


function getSliderSettings(){
  return {
     slidesToShow:1,
     slidesToScroll: 1,
     rtl: false,
     autoplay: true,
     autoplaySpeed: 2000,
     dots: true,
     arrows: false,
     focusOnSelect:true,
     infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear'
  }
}

/*----------------------------------------------
  
----------------------------------------------*/

var is_open = $('.open_time').data('status');

function close_shop(){
   $('.itemPopupModal').modal('hide');
    $('#closeModal').modal('show');
}
/*----------------------------------------------
  
----------------------------------------------*/
// // Items add to cart with button
$(document).on('click','.add_to_cart',function(){
 if(is_open==0 || is_open==undefined){
    close_shop();
    return false;
 }

  var id = $(this).data('id');
  var type = $(this).data('type');
  var url = `${base_url}profile/add_to_cart/${id}/${type}`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){

    open_cart(json);

    if(json.st == 1){
        $('.cartItems').html(json.load_data);
        $('.cartNotify_wrapper').html(json.notify);
        $('.cartFloatingIcon').html(json.total_item);
        $('.total_price').html(json.total_price);

        if(json.total_item > 0){
          $('.CartIcon').animate({"bottom": '200'});
        }
        $('.cartNotify_wrapper').animate({"bottom": '50px'});
        $('#itemModal').modal('hide');
        setTimeout(function(){ $('.cartNotify_wrapper').animate({"bottom": '-200px'})}, 9000);
    }
  },'json');
  return false;
});


// add to cart using form data
$(function(){
    $(document).on('submit','.add_to_cart_form',function(){
       
       if(is_open=0 || is_open==undefined){
          close_shop();
          return false;
       }

        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){
          
          open_cart(json);

          if(json.st == 1){
            $('.cartItems').html(json.load_data);
            $('.cartNotify_wrapper').html(json.notify);
            $('.cartFloatingIcon').html(json.total_item);
            $('.total_price').html(json.total_price);
            if(json.total_item > 0){
              $('.CartIcon').animate({"bottom": '200'});
            }
            $('.cartNotify_wrapper').animate({"bottom": '50px'});
            $('#itemModal').modal('hide');
            setTimeout(function(){ $('.cartNotify_wrapper').animate({"bottom": '-200px'})}, 9000);
          }
        },'json');
        return false;
    });
 });




// add to cart using form data with size
$(function(){
    $(document).on('submit','.cart_form',function(){
        if(is_open==0 || is_open==undefined){
          close_shop();
          return false;
        }

        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){

          open_cart(json);

          if(json.st == 1){
            $('.cartItems').html(json.load_data);
            $('.cartNotify_wrapper').html(json.notify);
            $('.cartFloatingIcon').html(json.total_item);
            $('.total_price').html(json.total_price);
            if(json.total_item > 0){
              $('.CartIcon').animate({"bottom": '200'});
            }
            $('.cartNotify_wrapper').animate({"bottom": '50px'});
            $('#itemModal').modal('hide');
            setTimeout(function(){ $('.cartNotify_wrapper').animate({"bottom": '-200px'})}, 9000);
          }
        },'json');
        return false;
    });
 });


function open_cart(json){
  if(json.st==0 && json.is_conflict==1){
      $('.itemPopupModal').modal('hide');
      $('#conflictModal').modal('show');
      $('#showModaldata').html(json.load_data);
      return false;
    }
}

$(document).on('click','.clearCartModal',function(){
  let shop_id = $(this).data('slug');
  var url = `${base_url}profile/check_existing_shop/{$shop_id}`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
      $('#conflictModal').modal('show'); 
    }
  },'json');
  return false;


});

$(document).on('change','.extras',function(){
    var extrasSelected=[];
    var extrasName=[];
    var mainPrice = parseFloat($('.extra_price').val());
    $('input:checkbox:checked').each(function(){
      extrasSelected.push(""+$(this).data('id')+"");
      extrasName.push($(this).data('name'));
      mainPrice += isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
    });   
    $('.item_price').val(mainPrice.toFixed(2));
    $('.show_price').text(mainPrice.toFixed(2));
    $('.extra_id').val(JSON.stringify(extrasSelected));
    $('.extra_name').val(extrasName);
});



// show order button
$(document).on('click','.show_order_btn',function(){
  var type = $(this).data('type');
  var url = `${base_url}profile/show_order_modal`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
        if(json.total_item > 0){
          $('#showOrderModal').html(json.load_data);
          $('.cartFloatingIcon').html(json.total_item);
          $('.total_price').html(json.total_price);
          $('.shopping_cart').animate({"right": '-100%'});
          $('#orderModal').modal('show');
          show_date_details();
        }
        
    }
  },'json');
  return false;
});

$(function(){

    var day = $('.off_days').data('day');

    $(".datepicker-1").flatpickr({
      enableTime: false,
      dateFormat: "Y-m-d",
      minDate: new Date().fp_incr(1),
      defaultDate:  new Date().fp_incr(1),
      "disable": [
        function(date){
            var events=''; //{}
            var d =date.getDay();
            $.each(day,function(i,v){
              if(v==d){
                events = true;
              }
            })
            return events;
        },
      ],

    });

    $(document).on('click','.pickup_date_checker',function(){
        var val = $(this).val();
        var shopID = $(this).data('id');
        if(val==1){
           get_pickup_time(shopID,1);
           $('.pickupTime').slideUp();
        }else{
          get_pickup_time(shopID,2);
          $('.pickupTime').slideDown();
        }
    });
})

function show_date_details(){
  var day = $('.off_days').data('day');
  var start_time = $('.off_time').data('start');
  var end_time = $('.off_time').data('end');

  $(".datetimepicker").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    minDate: "today",
    time_24hr: true,
    "disable": [
    function(date){
      var events=''; //{}
      var d =date.getDay();
      $.each(day,function(i,v){
        if(v==d){
          events = true;
        }
      })
      return events;
    },
    ],
    "onChange": [function(selectedDates, dateStr, instance){
      var currentDate = new Date(dateStr);
      var dayId= currentDate.getDay();
      var shopID = $('.off_days').data('id');
      var url =`${base_url}profile/get_time_by_date/${dayId}/${shopID}`;
      $.get(url, {'csrf_test_name': csrf_value }, function(json){
        instance.set('maxTime',json.end_time);
        instance.set('minTime', json.start_time);
      },'json');

      return false;

    }],

    }); //datatime picker

    // check time for pickup
    $(".timepicker").flatpickr({
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
      time_24hr: true,
      minTime: start_time,
      maxTime: end_time,
    });
  }









// remove item from cart
$(document).on('click','.add_to_order',function(){
  var id = $(this).data('id');
  var url = `${base_url}profile/add_qr_order/${id}`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
      $('.successMsg').html(json.msg).slideDown('slow'); 
    }else{
       $('.successMsg').html(json.msg).slideDown('slow'); 
    }
  },'json');
  return false;
});



$(document).on('click','#pagination .ci-pagination li  a',function(){
  var id = $('.ci-pagination-link').data('id');
  var user_id = $('.ci-pagination-link').data('slug'); 
  var url = $(this).attr("href");
  $('#showCatItem').html('');
  $('#showCatItem').addClass('load');
  $.get(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
       
      setTimeout(() => {
        jQuery('#showCatItem').removeClass('load');
        $('#showCatItem').html(json.result);
        lazyLoad_bg();
        lazyLoad_img();
      }, 2000);
      
      
    }
  },'json');
  return false;
});


$(document).on('submit','.itemSearch',function(){
  $('#showCatItem').html('');
  $('#showCatItem').addClass('load');
  var url = $(this).attr("action");
  var val = $('.search-txt').val();
  var  url =`${url}?item=${val}`
  $.get(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){

      setTimeout(() => {
          jQuery('#showCatItem').removeClass('load');
          $('#showCatItem').html(json.result);
          lazyLoad_bg();
          lazyLoad_img();
        }, 2000);
       
    }
  },'json');
  return false;
});

$(document).on('submit','.itemSearch-2',function(){
  $('#showCatItem').html('');
  $('#showCatItem').addClass('load');
  var url = $(this).attr("action");
  var val = $('.search-txt-2').val();
  var  url =`${url}?item=${val}`
  $.get(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
      setTimeout(() => {
        jQuery('#showCatItem').removeClass('load');
        $('#showCatItem').html(json.result);
        lazyLoad_bg();
        lazyLoad_img();
      }, 2000);
       
    }
  },'json');
  return false;
});





$(function(){
  $(document).on('click','.minus,.add',function(){
      var id = $(this).data('id');
      var $qty = $(this).closest('.incress_area').find('.qty'),
        currentVal = parseInt($qty.val()),
        isAdd = $(this).hasClass('add');
      if(currentVal !=0){
          !isNaN(currentVal) && $qty.val(
            isAdd ? ++currentVal : (currentVal > 1 ? --currentVal : currentVal)
          );

        var $itemPrice = $(this).closest('.single_cart_item_details').find('.item_price');
        var $totalQty = $(this).closest('.single_cart_item_details').find('.total_qty');
        var $total_price = $(this).closest('.single_cart_item_details').find('.total_qty_price');

        $totalQty.text(currentVal);

        var price = $itemPrice.text();
        var finalPrice = parseFloat(currentVal*price).toFixed(2);
        $total_price.text(finalPrice);

        console.log(finalPrice);

       
        var url = `${base_url}profile/update_cart_item/${id}/${currentVal}`;
        $.post(url, {'csrf_test_name': csrf_value }, function(json){
          if(json.st == 1){
              $('.cartItems').html(json.load_data);
              $('.cartFloatingIcon').html(json.total_item);
              $('.total_price').html(json.total_price);
              $('#showOrderModal').html(json.order_item); 
              $('#showCheckoutData').html(json.checkout_items); 
              show_date_details();
          }
        },'json');
     }
       
  });
})




// remove item from cart
$(document).on('click','.remove_item',function(){
  var id = $(this).data('id');
  var url = `${base_url}profile/remove_cart_item/${id}`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
        $('.cartItems').html(json.load_data);
        $('.cartFloatingIcon').html(json.total_item);
        $('.total_price').html(json.total_price);
        $('.navCart').addClass('active');
        $('#showOrderModal').html(json.order_item);
        $('#showCheckoutData').html(json.checkout_items); 
        show_date_details();
        if(Number.isInteger(json.total_item)==true &&  json.total_item== 0){
          $('.CartIcon').animate({"bottom": '-200'});
          $('.shopping_cart').animate({"right": '-100%'});
          $('#orderModal').modal('hide');
          $('.navCart').removeClass('active');
          $('.cartFloatingIcon.menuStyle1').html('');
        }
    }
  },'json');
  return false;
});





$(function(){
  $(document).on('click', '.closeNotify', function(event) {
    $('.cartNotify_wrapper').animate({"bottom": '-200px'});
  });


  $(document).on('click', '.navCart', function(event) {
    let slug = $(this).data('slug');
    var url = `${base_url}profile/update_cart_sidebar/${slug}`;
    $.post(url, {'csrf_test_name': csrf_value }, function(json){
      if(json.st == 1){
        $('.shopping_cart_content').html(json.load_data);
        $('.shopping_cart').animate({"right": '0'});
      }
    },'json');
    return false;

  }); 

  //  $(document).on('click', '.navCart', function(event) {
  //   $('.shopping_cart').animate({"right": '0'});
  // });


  $(document).on('click', '.cartActive', function(event) {
    $('.shopping_cart').animate({"right": '-100%'});  
  });



  /*----------------------------------------------
            Selected DINE-IN after scan QR code
  ----------------------------------------------*/
  $(document).ready(function(){
    if($('.order_type').find(':selected').data('slug')=="dine-in"){
        $('.order_type_body, .show_price, .pickup, .show_address, .showShipping, .changeInfo').slideUp();
        $('.is_payment, .shippingArea').val(0);
        $('.dinein, .show_price, .couponArea').slideDown();
      }

      setTimeout(()=>{
        get_table_person('.table_no');
      },1000);
      


  });



   function get_table_person(table){

     var size = $(`${table}`).find(':selected').data('size');
     $('.table_person').slideUp();
     if(size =='' || size == undefined){
        $('#table_person').html('');
        $('.table_person').slideUp();

      }else{

        $('#table_person').html('');
        var shopId = $(`${table}`).data('id');
        var tableId = $(`${table}`).val();
        var url = `${base_url}profile/get_person/${shopId}/${tableId}`;
        $.get(url, {'csrf_test_name': csrf_value }, function(data){
           $('#table_person').html(data);
        });

        $('.table_person').slideDown();
       
      }
     
  }

  $(function(){

     $(document).on('change', '#table_no', function(event) {
        get_table_person('.table_no');
     })
  });




})//function



$(document).on('change', '.order_type', function(event) {


  var myOrderDiv = ['.order_type_body','.pickup','.dinein','.showShipping','.show_price.defaultshipping','.show_address','.couponArea','.changeInfo','.booking','.room_service'];
  var cash = ['.show_address','.couponArea','.changeInfo']; //slideDown
  var booking = ['.order_type_body','.booking','.show_price','.couponArea']; //slideDown
  var pickup = ['.show_price','.pickup','.couponArea']; //slideDown
  var payINcash = ['.couponArea','.show_price']; //slideDown
  var dineIn = ['.dinein','.show_price','.couponArea']; //slideDown
  var roomService = ['.room_service','.show_price','.couponArea']; //slideDown




    var price = $('.getPrice').val();
    var minPrice = $('.minPrice').val();
    var val = $(this).find(':selected').data('slug');
    var payment = $(this).find(':selected').data('pay');
    var is_required = $(this).find(':selected').data('required');
    var radius = $(this).find(':selected').data('radius');
    var shopID = $(this).data('id');

    $('.priceEmpty').slideUp();
    $('.last_order_type').val(val);


      reset();

     if(payment==1){
       $('.makePayment').slideDown();
     }else{
        $('.makePayment').slideUp();
     }
     $('.mergeArea').slideUp();
     if(is_required==1){
        $('.pay_now input').attr('required',true);
        $('.pay_now input').prop('checked',true);
        $(".pay_later").css("visibility", "hidden");
        $('.pay_later input').prop('checked',false);
        $('.changeInfo').slideUp();
     }else{
        $('.pay_now input').attr('required',false);
        $('.pay_now input').prop('checked',false);
        $('.pay_later input').prop('checked',true);
        $(".pay_later").css("visibility", "visible");
        $('.changeInfo').show();
     }

      myOrderDiv.forEach(function(e,l) {
           $(`${e}`).slideUp();
      });

    
      $('.is_payment, .shippingArea').val(0);

     if(val=='cash-on-delivery'){

        if(radius==1){
          nearby(shopID);
        }

        $('.single_slots').removeClass('active');
    
        cash.forEach((e,l) => {
          $(`${e}`).slideDown();
        });


    }else if(val=='booking'){

       booking.forEach(function(e,l) {
           $(`${e}`).slideDown();
        });

    }else if(val=='pickup'){

       pickup.forEach(function(e,l) {
           $(`${e}`).slideDown();
        });

        get_pickup_time(shopID,1);

    }else if(val=='pay-in-cash'){

       payINcash.forEach(function(e,l) {
           $(`${e}`).slideDown();
        });

        $('.is_payment').val(1);
        $('.shippingArea').val(0);
        $('.single_slots').removeClass('active');

    }else if(val=='dine-in'){

       dineIn.forEach(function(e,l) {
           $(`${e}`).slideDown();
        });

    }else if(val=='room-service'){

       roomService.forEach(function(e,l) {
           $(`${e}`).slideDown();
        });

    }else if(val=='pay-cash'){

       payINcash.forEach(function(e,l) {
           $(`${e}`).slideDown();
        });

    }else{
      myOrderDiv.forEach((e,l) => {
          $(`${e}`).slideUp();
        });
       $('.is_payment, .shippingArea').val(0);
    }



});



function reset(){
  var url = `${base_url}profile/reset/`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
      tips_reset();
    }
  },'json');
}

$(document).on('change', '.hotel_name', function(event) {
  var ID = $(this).val();
   if(ID != ''){
      get_room_numbers(ID);
   }
});

$(document).on('click', '[name="use_payment"]', function(event) {
  var ID = $(this).val();
   if(ID == 1){
     $('.changeInfo, .change_field').slideUp();
     $("[name='is_change']").prop('checked',false);
   }else{
      $('.changeInfo').show();
   }
});


function get_room_numbers(hotelID){
    $('.roomNumbers').addClass('null').html(loader_gray);
    var url = `${base_url}profile/get_room_numbers/${hotelID}`;
    $.post(url, {'csrf_test_name': csrf_value }, function(json){
      if(json.st == 1){
        
        setTimeout(()=>{
          $('.roomNumbers').removeClass('null');
          $('.roomNumbers').html(json.load_data);
        },1000)
       
      }
    },'json');
}


$(document).on('click', '.singleSlot', function(event) {
  $('.single_slots').removeClass('active');
  if ($(this).is(':checked')){
      $(this).attr("checked",'checked');
      $(this).parent('.single_slots').addClass('active');
   }
});






function get_pickup_time(shopID,type){
    $('.pickupTimeSlots').addClass('null').html(loader_gray);
    var url = `${base_url}profile/get_pickup_available_time/${shopID}/${type}`;
    $.post(url, {'csrf_test_name': csrf_value }, function(json){
      if(json.st == 1){
        
        setTimeout(()=>{
          $('.pickupTimeSlots').removeClass('null');
          $('.pickupTimeSlots').html(json.load_data);
        },1000)
       
        console.log(json.times);
      }
    },'json');
}




$(document).on('click', '.is_change', function(event) {
  if ($(this).is(':checked')){
     $('.change_field').slideDown();
   }else{
    $('.change_field').slideUp();
   }
});





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
                $('#downloadLink').attr('href',`${base_url}${json.qrlink}`);
                $('#track_order_btn').attr('href',`${json.track_link}`);
                $('.whatsapp_share_data').html(json.load_data);
                if(json.link !=''){
                  window.location.href = `${json.link}`;
                }
                $('.mergeArea').slideUp();
            }else if(json.st == 2){
                window.location.href = `${json.url}`;

            }else if(json.st == 3){
                ajax_msg(json.msg);
                $('.mergeArea').slideDown();
                $('.previousOrderDetails').html(json.details);
            }else{
                ajax_msg(json.msg);
                $('.mergeArea').slideUp();
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

    // download orderQr
    $(document).on('click','.qrDownloadBtn',function(e){
      $('.qrDownloadBtn').html(`<span class="downloadMsg"><i class="icofont-check-alt"></i> Downloaded</span>`);
        
    });

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





 $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (var i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (var i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = ratingValue;
    }
    else {
        msg = ratingValue;
    }
    responseMessage(msg);
    
  });
  
  function responseMessage(msg) {
    $('.rating').val(msg);
  }

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


  $(function(){
    $(document).on('click','.getPrice',function(){
      var price = $(this).data('price');
      var size = $(this).data('size');
      var size_title = $(this).data('size-title');
      ;
      $('.item_price, .extra_price').val(price);
      $('.item_size').val(size);
      $('.size_title').val(size_title);
      $('.getPrice').removeClass('active');
      $('.add_to_cart_form, .priceTag, .item_extra_list').removeClass('hidden');
      $('.show_price').text(price);
      $('.item_extra_list [type=checkbox]').prop("checked", false);

      $(this).addClass('active')
    })
  });

  $(document).ready(function() {
      $('.venobox').venobox({
        framewidth : '',                            // default: ''
        frameheight: '',                            // default: ''
        border     : '',                             // default: '0'
        bgcolor    : '',                          // default: '#fff'
        titleattr  : 'data-title',                       // default: 'title'
        numeratio  : true,                               // default: false
        infinigall : true,                               // default: false
        share      : false, // default: [['facebook', 'twitter', 'download']]
        closeBackground:'red',
        closeColor:'#fff',
        spinColor: '#29c7ac',
        spinner:'double-bounce'
      });
    });

// show available day
$(function(){
  var day = $('.off_days').data('day');
  $(".datetimepicker").flatpickr({
      enableTime: true,
      dateFormat: "Y-m-d H:i",
      minDate: "today",
      time_24hr: true,
       "disable": [
          function(date){
            var events=''; //{}
            var d =date.getDay();
              $.each(day,function(i,v){
              if(v==d){
                events = true;
              }
            })
            return events;
          },
      ],
      "onChange": [function(selectedDates, dateStr, instance){
        var currentDate = new Date(dateStr);
        var dayId= currentDate.getDay();
        var shopID = $('.off_days').data('id');
          var url =`${base_url}profile/get_time_by_date/${dayId}/${shopID}`;
           $.get(url, {'csrf_test_name': csrf_value }, function(json){
            instance.set('maxTime',json.end_time);
            instance.set('minTime', json.start_time);
         },'json');

        return false;
      }],
    

  });

  
});



$(function () {

  $(document).on('submit', '.serviceRegistration', function (e) {
    e.preventDefault();
    var $form = $(this);
    var url = $form.attr('action');
    var data = $form.serialize();
    $.ajax({
      type: 'post',
      url: url,
      dataType: "json",
      processData: true,
      data: data,
      beforeSend: function() {
        $form.addClass('submit_form').append('<span class="ajax_submit"></span>');
      },
      success: function (json) {
        if(json.st ==1){
          $('.serviceRegistration')[0].reset(); 
          setTimeout(function(){ 
            $('.loginSection').slideUp();
            $('.orderInfoArea').slideDown(); 
           $('#loadCustomer').html(json.info).addClass('ModalCustomerInfo').slideDown();
            $('.shippingAddress').text(json.address);
            $('#customerData').html(json.customer_data);
          }, 1000);
           ajax_msg(json.msg);
        }else{
          ajax_msg(json.msg);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('.alertMsg').html(`<div class="alert alert-danger alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Sorry ! </strong> ${textStatus, errorThrown}
          </div>`);
        console.log(textStatus, errorThrown);
         
      }
    });

  });

});  

$(document).on('submit', '.serviceLogin', function (e) {
    e.preventDefault();
    var $form = $(this);
    var url = $form.attr('action');
    var data = $form.serialize();
    $.ajax({
      type: 'post',
      url: url,
      dataType: "json",
      processData: true,
      data: data,
      beforeSend: function() {
        $form.addClass('submit_form').append('<span class="ajax_submit"></span>');
      },
      success: function (json) {
        if(json.st ==1){
          $('.serviceLogin')[0].reset(); 
          setTimeout(function(){ 
            $('.loginSection').slideUp();
            $('.orderInfoArea').slideDown(); 
            $('#loadCustomer').html(json.info).addClass('ModalCustomerInfo').slideDown();
            $('.shippingAddress').text(json.address);
            $('#customerData').html(json.customer_data);
            $('.customerpopup').modal('hide');
            $('.customer_phone').val(json.phone);
            $('.gmap_link').val(json.gmap_link);
          }, 1000);
           ajax_msg(json.msg);
        }else{
           ajax_msg(json.msg);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('.alertMsg').html(`<div class="alert alert-danger alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Sorry ! </strong> ${textStatus, errorThrown}
          </div>`);
        console.log(textStatus, errorThrown);
        //send_btn_loader(false);
      }
    });

  });


$(document).on('click','.customerRemove',function(){
  var url = `${base_url}profile/remove_customer_login/`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
        $('#loadCustomer, .ModalCustomerInfo').html('').slideUp();
        $('.showUserlogin, .loginSection').slideDown();
         $('.orderInfoArea').slideUp();
    }
  },'json');
  return false;
});







$(document).on('click','.showItemList',function(){
  var uid = $(this).data('id');
  var shopID = $(this).data('shop-id');
  var url = `${base_url}staff/order_item_list/${uid}/${shopID}`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
       $('#showData').html(json.load_data);
       $('#orderDetailsModal').modal('show');
    }
  },'json');
  return false;
});


$(".category_shot li button").on('click', function() {
  $('.gallery_sort li button.active').removeClass('active');
  $(this).addClass('active');


  var id = $(this).attr("id");
  $.each(categories, function( index, value ) {
    $(`.category_${value}`).show();
  });

 
  if(id!=0){
    $.each(categories, function( index, value ) {
      if(value != id){
        $(`.category_${value}`).hide();
      }
    });
  }
  
});


$(document).on('change', '.shippingArea', function(event) {
  $('.single_slots').removeClass('active');
  var cost = $(this).data('cost');
  var id = $(this).data('id');
  var $this = $(this);
  if ($(this).is(':checked')){
     var url = `${base_url}profile/shipping_address/${id}`;
      $.post(url, {'csrf_test_name': csrf_value }, function(json){
        if(json.st == 1){
           $('.total_sum_area').html(json.load_data);
            $($this).parent('.single_slots').addClass('active');
             $('.show_price').slideUp();
             $('.showShipping').slideDown();
             $('.shippingArea').val(id);
             $('.shipping_cost').val(cost);
              coupon_discard();
        }
      },'json');

   }
});


$(document).on('change', '[name="tips_btn"]', function(event) {
    tips_reset();
    var cost = $(this).val();

      if(cost==0){
        $('.tipsFieldArea').slideDown();
      }else{
        $('.tipsFieldArea').slideUp();
      }

      $('.tipsLabel').removeClass('active');
      $('.addTips').prop('disabled',false);

      $('[name="tips"]').val(cost);
        

      var $this = $(this);
      if ($(this).is(':checked')){
       var url = `${base_url}profile/tips/${shop_id}/${cost}`;
       $.post(url, {'csrf_test_name': csrf_value }, function(json){
          if(json.st == 1){
             $this.parents('label').addClass('active');
             $('.total_sum_area').html(json.load_data);
             if(json.shipping!=0){
              $('.show_price').slideUp();
              $('.showShipping').slideDown();
              $('.shipping_cost').val(json.shipping);
            }
          }
        },'json');

     }
});

$(document).on('click', '.addTips', function(event) {
      
      var cost = $('[name="tips"]').val();
      var $this = $(this);
       var url = `${base_url}profile/tips/${shop_id}/${cost}`;
       $.post(url, {'csrf_test_name': csrf_value }, function(json){
        if(json.st == 1){
         $('.total_sum_area').html(json.load_data);
         $this.html(`<i class="fa fa-check"></i>`).addClass('btn-success');
         $this.prop('disabled',true);
         $('[name="tips"]').prop('readonly',true);
         $('[name="tips"]').addClass('pointerEvent');
           if(json.shipping!=0){
            $('.show_price').slideUp();
            $('.showShipping').slideDown();
            $('.shipping_cost').val(json.shipping);
          }
       }
     },'json');
});


function tips_reset(){
  $('.tipsLabel').removeClass('active');
  $('.addTips').prop('disabled',false);
  $('[name="tips"]').val(0);
  $('[name="tips"]').prop('readonly',false);
  $('[name="tips"]').removeClass('pointerEvent');
}



$(document).on('change', '.timeChecked', function(event) {
  $('.single_slots').removeClass('active');
  if ($(this).is(':checked')){
     $(this).parent('.single_slots').addClass('active');
   }
});







function lazyLoad_img(){
    jQuery('.img_loader').each(function() {
      var lazy = $(this);
      var src = lazy.data('src');
      lazy.attr('src', src);
      $('.img_loader').removeClass('.bg_loader');

    });
  }

  function lazyLoad_bg(){
    jQuery('.bg_loader').each(function() {
      var lazy = $(this);
      var src = lazy.data('src');
      lazy.css("background-image", "url(" + src + ")");
      $('.bg_loader').removeClass('bg_loader');
    });
  }

  $(function(){
    $('.itemSlider').slick({
      dots: true,
      infinite: true,
      speed: 500,
      fade: true,
      cssEase: 'linear'
    }); 
  })

$(function(){
  $('.callWaiterForm').on('submit',function(e) {
    $(this).addClass('submit_form').append('<span class="ajax_submit"></span>');
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){
            if (json.st == 1) {
                  $(".callWaiterForm")[0].reset();
                 ajax_msg(json.msg);
            }else{
                ajax_msg(json.msg);
            }
        },'json');
        return false;
    });
 });


$('.userMenu, .show_menu_details').on('click','.dropdownMenu', function(e) {
  e.stopPropagation();
  $('.dropdownMenu').not(this).removeClass('active');
  $(this).children('.dropdownArea').slideToggle();
  $(".dropdownArea").not($(this).children('.dropdownArea')).hide();
  $(this).toggleClass('active');
});

$(document).on('click', function(e) {
  e.stopPropagation();
 $('.dropdownArea').hide();
});


$(function(){
  $(document).on('click','.action_btn',function(){
    var link = $(this).attr('href');
    var msg = $(this).data('msg');
    swal({
        title: are_you_sure,
        text: msg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: yes,
        cancelButtonText: no,
        closeOnConfirm: false,
      }, function(){                      
          window.location.href =link;
      });
    return false;
  });
});


  $(document).on('click','.couponBtn',function(){
      $('.couponBtn').hide();
      $('.couponField').slideDown();
  });

  $(document).on('click','.couponClose',function(){
      $('.couponBtn').fadeIn();
      $('.couponField').slideUp();
  });


$(document).on('click', '.couponFormBtn', function(event) {
  let coupon_code = $('.coupon_code').val();
  let all_price = $('.all_price').val();
  let shop_id = $('.shop_id').val();
  let last_order_type = $('.order_type').find(':selected').data('slug');
  let shipping_cost = $('.shipping_cost').val();
  let url = `${base_url}profile/check_coupon_code/?coupon_code=${coupon_code}&shop_id=${shop_id}&price=${all_price}&shipping_cost=${shipping_cost}&last_order_type=${last_order_type}`;
      $.post(url, {'csrf_test_name': csrf_value }, function(json){
         if (json.st == 1) {
          $('.total_sum_area').html(json.load_data);
          $('.couponBtn, .couponArea').hide();
          $('.couponPricearea').slideDown();
          $('.is_coupon').val(1);
          $('.coupon_percent').val(json.coupon_percent);
          $('.coupon_id').val(json.coupon_id);
          if(json.is_shipping == 1){
            $('.show_price').hide();
            $('.showShipping').slideDown();
          }else{
              $('.show_price').slideDown();
              $('.showShipping').hide();
          }
        }else{
          ajax_msg(json.msg);
        }
      },'json');

});

function coupon_discard(){
   $('.couponBtn, .couponArea').slideDown();
   $('.couponPricearea, .couponField').hide();
}

$(function(){
  $(document).on('keyup','.remove_char',function(){
      var val = $(this).val();
      var char = $(this).data('char');
 
      if(val==''){
        return;
      }

      var newName =  val.replace(`${char}`, '').replace(/[^\w]/g, "");
      $(this).val(newName);

   
  });
});


$(function(){
  $(document).on('click','.question',function(){
      var val = $(this).val();
     if(val > 0){
        $('.questionAnswer').slideDown();
     }else{
        $('.questionAnswer').slideUp();
     }
   
  });
});

$(function(){
  $(document).on('keypress keyup input','#item_comments',function(){
    var val = $(this).val().length;
     if(val >= 0){
        $('.item_comments').val($(this).val());
     }
  });
});



function nearby(shopID) {
      var x=document.getElementById("errorMsg");
      function getLocation()
      {
        if (navigator.geolocation)
        {
          navigator.geolocation.getCurrentPosition(showPosition,showError);
        }
        else{x.innerHTML="Geolocation is not supported by this browser.";}
      }

      function showPosition(position)
      {
        var lat=position.coords.latitude;
        var lon=position.coords.longitude;
        var url = `${base_url}/profile/check_delivery_area/${shopID}/${lat}/${lon}`;
        jQuery.get(url, {'csrf_test_name': csrf_value }, function(json){
          if(json.st == 1){
            return 1;

           }else{

            $('.order_type_body, .pickup, .dinein, .showShipping, .makePayment, .show_price.defaultshipping, .show_address, .couponArea, .changeInfo').slideUp();
             $('.notfound').slideDown();
            $('.showNotfoundMsg').html(json.msg);
           
            return false;
           }
       },'json');
        return false;
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

       getLocation();

      
  }



$(function(){




    // $(document).on('click','#nearby',function($){
    //   jQuery('#shopList').html('');
    //   jQuery('#shopList').addClass('load');
    //   var x=document.getElementById("errorMsg");
    //   function getLocation()
    //   {
    //     if (navigator.geolocation)
    //     {
    //       navigator.geolocation.getCurrentPosition(showPosition,showError);
    //     }
    //     else{x.innerHTML="Geolocation is not supported by this browser.";}
    //   }

    //   function showPosition(position)
    //   {
    //     var lat=position.coords.latitude;
    //     var lon=position.coords.longitude;
    //     var url = `${base_url}/home/get_near_shop/${lat}/${lon}`;
    //     jQuery.get(url, {'csrf_test_name': csrf_value }, function(json){
    //       if(json.st == 1){
         
    //        setTimeout(() => {
    //         jQuery('#shopList').removeClass('load');
    //         jQuery('#shopList').html(json.load_data);
    //         jQuery('[data-toggle="tooltip"]').tooltip();

    //       }, 2000);
           
    //       }
    //     },'json');
    //     return false;
    //   }

    //   function showError(error)
    //   {
    //     switch(error.code) 
    //     {
    //       case error.PERMISSION_DENIED:
    //       x.innerHTML="User denied the request for Geolocation."
    //       break;
    //       case error.POSITION_UNAVAILABLE:
    //       x.innerHTML="Location information is unavailable."
    //       break;
    //       case error.TIMEOUT:
    //       x.innerHTML="The request to get user location timed out."
    //       break;
    //       case error.UNKNOWN_ERROR:
    //       x.innerHTML="An unknown error occurred."
    //       break;
    //     }
    //   }
    //   getLocation();
    // });
  });


 $(document).on("keypress keyup blur", ".only_number",function (event) {    
   $(this).val($(this).val().replace(/[^\d].+./, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});

$(document).on("keypress keyup blur",".number",function (event) {
  $(this).val($(this).val().replace(/[^0-9\.]/g,''));
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});

}(jQuery)); 