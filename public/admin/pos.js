(function ($) {
  "use strict"

var base_url = $('#base_url').attr('href');
var csrf_value = $('#csrf_value').attr('href');
var loader_green = `<div class="loadingio-spinner-rolling-bmobyy7r0gw loader_green"><div class="ldio-mp4zm9ojapo"><div></div></div></div>`;
var loader_gray = `<div class="loadingio-spinner-rolling-bmobyy7r0gw loader_gray"><div class="ldio-mp4zm9ojapo"><div></div></div></div>`;

var shopId = $('.data-token').attr('href');
if(shopId !==undefined || shopId !==''){
	shopId = shopId;
}else{
	shopId = 0;
}


$(function(){
	$(document).on('keyup','#search-box',function(){
		var val = $(this).val();
		$.ajax({
			type: "GET",
			dataType: 'json',
			url: `${base_url}admin/pos/get_item_name?q=${val}`,
			data:{'csrf_test_name': csrf_value},
			beforeSend: function(){
				$(".btn-loading").addClass('activeLoader');
				$("#suggesstion-box").hide();
			},
			success: function(json){
				$(".btn-loading").removeClass('activeLoader');
				$("#suggesstion-box").show();
				$(".itemListArea").html(json.result);
			}
		});
	});
});

/*----------------------------------------------
  		Add Customers		
----------------------------------------------*/
var cardLoader = 'activeLoader btn-loading';
$(function(){
	
  $(document).on('submit', '.addCustomer', function(e) {
  		$('.menu-card').addClass(cardLoader);
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){
            if (json.st == 1) {
                $(".reg_msg").slideDown().html(json.msg); 
                $("#customerList").html(json.result); 
                $(".addCustomer")[0].reset(); 
                $('.select2').select2({
						        placeholder: select,
						     });
                setTimeout( () => {
                	 $('#addCustomerModal').modal('hide');
                },100);
               
            }else{
                $(".reg_msg").slideDown().html(json.msg);
            }
            setTimeout( () => {
            	$('.menu-card').removeClass(cardLoader);
            },800);
            setTimeout(function(){ $('.reg_msg').fadeOut(); }, 2000);
        },'json');
        return false;
    });
 });



/*----------------------------------------------
  				DISCOUNT FOR POS
----------------------------------------------*/

$(document).on('submit','.setDiscount',function(){
	
  var url = $(this).attr('action');
  $.post(url, $(this).serialize(), function(json){

    if(json.st == 1){
    	$('.menu-card').addClass(cardLoader);
    	$('.discountModal').modal('hide');
    	 updateCart(json.result,true);
    	 $(".errorMsg").slideDown().addClass('success').html(json.msg); 
    }else{
    	$(".errorMsg").slideDown().html(json.msg); 
    }
    setTimeout(function(){ $('.errorMsg').fadeOut();}, 2000);
  },'json');
  return false;
});



/*----------------------------------------------
  				PLUS / MINUS)
----------------------------------------------*/
$(function(){
  $(document).on('click','.minus,.add',function(){
  		$('.cartPriceArea').addClass(cardLoader);
      var id = $(this).data('id');
      var $qty = $(this).closest('.incress_area').find('.qty'),
        currentVal = parseInt($qty.val()),
        isAdd = $(this).hasClass('add');
      if(currentVal !=0){
          !isNaN(currentVal) && $qty.val(
            isAdd ? ++currentVal : (currentVal > 1 ? --currentVal : currentVal)
          );

        var url = `${base_url}admin/pos/update_cart_item/${id}/${currentVal}`;
        $.post(url, {'csrf_test_name': csrf_value }, function(json){
          if(json.st == 1){
              updateCart(json.result,true);
          }

        },'json');

     }
       
  });
});




// $(function(){
// 	$(document).on('keyup','#search-box',function(){
// 		var val = $(this).val();
// 		if(val.length > 2){
// 			$.ajax({
// 				type: "GET",
// 				dataType: 'json',
// 				url: `${base_url}admin/pos/get_item_name?itemName=${val}`,
// 				data:{'csrf_test_name': csrf_value},
// 				beforeSend: function(){
// 					$(".btn-loading").addClass('activeLoader');
// 					$("#suggesstion-box").hide();
// 				},
// 				success: function(json){
// 					$(".btn-loading").removeClass('activeLoader');
// 					$("#suggesstion-box").show();
// 					$("#suggesstion-box").html(json.data);
// 				}
// 			});
// 		}
// 	});
// });


$(document).ready(function(){
  $(document).on('click','#searchResult li',function(){

    var val = $(this).data('name');
    $("#search-box").val(val);
    $("#suggesstion-box").hide();
  });
});


/*----------------------------------------------
  		SHOW ITEM DETAILS		
----------------------------------------------*/

$(document).on('click','.showModal',function(){
	var id = $(this).data('id');
	var dataType = $(this).data('type');
	var type;
	if(dataType=='' || dataType==undefined){
		type='item';
	}else{
		type = dataType;
	}
	var url = `${base_url}admin/pos/item_details/${id}/${type}`;
	$.post(url, {'csrf_test_name': csrf_value }, function(json){
		if(json.st == 1){
			$('#showDetails').html(json.result);
			$('#itemDetails').modal({backdrop: "static"});
			$('.priceTag').addClass('hidden');
		}
	},'json');
	return false;
});

/*----------------------------------------------
  		SHOW PRICE BY SIZE	
----------------------------------------------*/

$(function(){
    $(document).on('click','.getPrice',function(){

    	var price = $(this).find('input[name="size_price"]').val();

      $('.checked_values').prop("checked", false);
      $(this).find('.checked_values').prop("checked", true);

      $('.getPrice').addClass('active').not(this).removeClass('active');


      $('.add_to_cart_form, .priceTag, .item_extra_list').removeClass('hidden');
      $('.item_extra_list [type=checkbox]').prop("checked", false);


      $('.extra_id').val('');
      $('.extra_name').val('');



      showPrice(price);
    })
  });




/*----------------------------------------------
  				SELECT EXTRAS
----------------------------------------------*/
$(document).on('change','.extras',function(){




    var extrasSelected=[];
    var extrasName=[];
    var mainPrice = 0;

    var sizePrice = parseFloat($('input[name="size_price"]:checked').val());
    var itemPrice = parseFloat($('.mainPrice').val());

    var sizePrice = isNaN(sizePrice) ? 0 : sizePrice;
    var itemPrice = isNaN(sizePrice) ? 0 : itemPrice;

    if(sizePrice!=0){
    	mainPrice = sizePrice;
    }else{
    	mainPrice = itemPrice;
    }


    $('input:checkbox:checked').each(function(){
      extrasSelected.push(""+$(this).data('id')+"");
      extrasName.push($(this).data('name'));
      mainPrice += isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
    });  
    showPrice(mainPrice); 
    $('.extra_id').val(JSON.stringify(extrasSelected));
    $('.extra_name').val(extrasName);
});



/*----------------------------------------------
  				ADD TO CART
----------------------------------------------*/
$(document).on('click','.showOrderModalBtn',function(){
	$('.menu-card').addClass(cardLoader);
	var id = $(this).data('id');
	var url = `${base_url}admin/pos/order_confirm_modal?id=${id}`;
	$.get(url, {'csrf_test_name': csrf_value }, function(json){
		if(json.st == 1){
			$('#orderConfirmModal').modal('show');
			$('#showOrderConfirmModal').html(json.result);
		}
		setTimeout( () => {
				$('.menu-card').removeClass(cardLoader);
			},400);

	},'json');
	return false;
});




/*----------------------------------------------
  				ADD TO CART
----------------------------------------------*/
$(document).on('click','.add_to_cart',function(){
	$('.menu-card').addClass(cardLoader);
	var id = $(this).data('id');
	var url = `${base_url}admin/pos/add_to_cart/${id}`;
	$.post(url, {'csrf_test_name': csrf_value }, function(json){
		if(json.st == 1){
			 updateCart(json.result);
		}
		setTimeout( () => {
				$('.menu-card').removeClass(cardLoader);
			},400);

	},'json');
	return false;
});


/*----------------------------------------------
  				Remove Items
----------------------------------------------*/

$(document).on('click','.remove_item',function(){
	$('.cartPriceArea').addClass(cardLoader);
  var id = $(this).data('id');
  var url = `${base_url}admin/pos/remove_cart_item/${id}`;
  $.post(url, {'csrf_test_name': csrf_value }, function(json){
    if(json.st == 1){
    	updateCart(json.result,true);
    	if(json.count==0){
    		$('.cartFooter').addClass('hidden');
    	}
    }
  },'json');
  return false;
});




/*----------------------------------------------
  				ADD TO CART FORM
----------------------------------------------*/

$(document).on('submit','.addToCart',function(){
	$('.menu-card').addClass(cardLoader);
  var url = $(this).attr('action');
  $.post(url, $(this).serialize(), function(json){
    if(json.st == 1){
    	$('#itemDetails').modal('hide');
    	 updateCart(json.result,true);
    }else{
    	$(".errorMsg").slideDown().html(json.msg); 
    }
    setTimeout(function(){ $('.errorMsg').fadeOut();}, 2000);
  },'json');
  return false;
});


/*----------------------------------------------
  				Change Return function
----------------------------------------------*/
$(document).on('input','.receivedAmount',function(){
		var val = $(this).val();
		var paying_amount = $('.paying_amount').val();

		if(isEmpty(val)==false){
			var amount = parseFloat(val) - parseFloat(paying_amount);
			$('.changeReturn').text(parseFloat(amount).toFixed(2));
		}else{
			$('.changeReturn').text(0);
		}
});




/*----------------------------------------------
  				ADD ORDER FORM
----------------------------------------------*/

$(document).on('submit','.addOrderForm',function(){
	// $('.menu-card').addClass(cardLoader);
  var url = $(this).attr('action');
  $.post(url, $(this).serialize(), function(json){
    if(json.st == 1){
    	window.location = json.url;
    }else{
    	$(".errorMsg").slideDown().html(json.msg); 
    }
    setTimeout(function(){ $('.errorMsg').fadeOut();}, 2000);
  },'json');
  return false;
});



  /*----------------------------------------------
            Selected DINE-IN after scan QR code
  ----------------------------------------------*/
  // $(document).ready(function(){
  // 	if($('.order_type').find(':selected').data('slug')=="dine-in"){
  // 		$('.order_type_body, .show_price, .pickup, .show_address, .showShipping, .changeInfo').slideUp();
  // 		$('.is_payment, .shippingArea').val(0);
  // 		$('.dinein, .show_price, .couponArea').slideDown();
  // 	}

  // 	setTimeout(()=>{
  // 		get_table_person('.table_no');
  // 	},1000);



  // });


$(document).on('change', '.order_type', function(event) {
	var slug = $(this).find(':selected').data('slug');
	var customer_id = $('#customer_id').find(':selected').val();
	var val = $(this).val(); 
	var shopId = $(this).data('id');
	if(isEmpty(slug)==1){
		orderDetails(false);
		$('.showOrderdetails').slideUp();
	}

	var url = `${base_url}admin/pos/get_order_layouts/${shopId}/${slug}?cId=${customer_id}`;
	$.post(url, {'csrf_test_name': csrf_value }, function(json){
		if(json.st == 1){
			updateOrderType(json.result);
			orderDetails(false);
			if(slug=='pickup'){
				pickupTime();
				get_pickup_time(shopId,1)
			}

			if(slug=='pay-cash'){
				orderDetails(true,shopId);
			}

		}
		setTimeout( () => {
			$('.menu-card').removeClass(cardLoader);
		},400);

	},'json');
	return false;

});

/*----------------------------------------------
  				ADD PERSON WITH TABLE NO
----------------------------------------------*/
$(document).on('submit','.addTableForm',function(){
  var url = $(this).attr('action');
  $.post(url, $(this).serialize(), function(json){
    if(json.st == 1){
    	updateOrderType(json.result);
    }else{
    	$(".errorMsg").slideDown().html(json.msg); 
    }
    setTimeout(function(){ $('.errorMsg').fadeOut();}, 2000);
  },'json');
  return false;
});



/*----------------------------------------------
  				ADD TABLE & PERSON
----------------------------------------------*/

$(document).on('click','.addTableBtn',function(){
	var id = $(this).data('id');
	var form = $('.tempForm'+id);
	var table_no = $(this).data('table');
	var url = form.attr('action');
	var data = form.serialize();

	$.post(url, data, function(json){
		if(json.st == 1){
			updateOrderType(json.result);
			orderDetails(true,json.shopId);
		}else{
			$(".errorMsg").slideDown().html(json.msg); 
		}
		setTimeout(function(){ $('.errorMsg').fadeOut();}, 2000);
	},'json');
	return false;
});



/*----------------------------------------------
  *********		DEFAULT FUNCTIONS *******
----------------------------------------------*/

function orderDetails(type,shopId=''){
	if(type==true){

		var order_type = $('#order_type').find(':selected').val();
		if(isEmpty(order_type)==true){
			alert(`Sorry Order type can't find`);
		}else{
				var url = `${base_url}admin/pos/order_details_modal?id=${shopId}&order_type=${order_type}`;
				$.get(url, {'csrf_test_name': csrf_value }, function(json){
					if(json.st == 1){
						$('.orderDetailsModal').html(json.result);
					}
			
				},'json');

				$('.showOrderdetails').slideUp();
				$('.orderDetailsModal').slideDown();
				$('.payModalBtn').slideDown();
				$('.order_type').attr('readonly','readonly');
		}
	
	}else{
		$('.orderDetailsModal').html('');
		$('.showOrderdetails').slideDown();
		$('.orderDetailsModal').slideUp();
		$('.payModalBtn').slideUp();
		$('.order_type').attr('readonly','');
	}
	
}

/*----------------------------------------------
  				SHOW DATA AFTER SUCCESS
----------------------------------------------*/
function updateCart(result,isLoader){
	$('.cartItemsArea').html(result); 
	$('.cartFooter').removeClass('hidden');
	if(isLoader===true){
		setTimeout( () => {
			$('.cartPriceArea, .menu-card').removeClass(cardLoader);
		},500);
	}
}



/*----------------------------------------------
     UPDATE MODAL DETAILS BY ORDER ID
----------------------------------------------*/
function updateOrderType(result){
	$('.showOrderdetails').html(result);
}

/*----------------------------------------------
  				ShowPrice Functions
----------------------------------------------*/

function showPrice(price){
	$('.show_price').text(parseFloat(price).toFixed(2));
	$('.item_price').val(parseFloat(price).toFixed(2));
}

/*----------------------------------------------
  				Check Empty Fields
----------------------------------------------*/
function isEmpty(val) {
	if(val==undefined || val=='' || typeof val == "undefined" || val.length <= 0){
		return true;
	}else{
		return false;
	}
}


/*----------------------------------------------
  				Active Slots
----------------------------------------------*/

$(document).on('change', '.activeSlot', function(event) {
  $('.singleSlots').removeClass('active');
  
  $('.activeSlot').attr('checked',false).not($(this).attr('checked',true)); 
  if ($(this).is(':checked')){
     $(this).parent('.singleSlots').addClass('active');
     if($('div.pickupDetailsArea').length > 0){
     		$('.pickupDetailsArea').slideDown();
     }
   }
});









/*----------------------------------------------
  				PICKUP ORDER
----------------------------------------------*/



/*----------------------------------------------
  				SET PICKUP DETAILS Temp_data
----------------------------------------------*/
function setPickupDetails(){
	var pickupArea = $('.singleSlots.active').data('title');
	var pickupTime = $('input[name="pickup_time"]:checked').val();
	var pickupDate = $('input[name="pickup_date"]').val();
	var pickupId = $('input[name="pickup_point_id"]:checked').val();
	var today = $('input[name="today"]:checked').val();
	const arr = {'pickupArea':pickupArea, 'pickupTime':pickupTime, 'pickupDate':pickupDate, 'pickup_point_id':pickupId,'today':today};
	const jsonData = JSON.stringify(arr);


	var url = `${base_url}admin/pos/pickup_details/`;
		$.post(url, {'data':jsonData,'shop_id':shopId,'csrf_test_name': csrf_value }, function(json){
			if(json.st == 1){
				updateOrderType(json.result);
				orderDetails(true,json.shopId);
			}

		},'json');
	return false;
}






function pickupTime(){

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

};


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



function get_pickup_time(shopID,type){
	$('.pickupTimeSlots').addClass('null').html(loader_gray);
	var url = `${base_url}profile/get_pickup_available_time/${shopID}/${type}`;
	$.post(url, {'csrf_test_name': csrf_value }, function(json){
		if(json.st == 1){
			setTimeout(()=>{
				$('.pickupTimeSlots').removeClass('null');
				$('.pickupTimeSlots').html(json.load_data);
			},1000)

		}
	},'json');
}


// click the time slot for show order details
$(document).on('change', '.timeChecked', function(event) {
  $('.single_slots').removeClass('active');
  if ($(this).is(':checked')){
     $(this).parent('.single_slots').addClass('active');
     setPickupDetails();
   }
});


/*----------------------------------------------
  				ROOM SERVICES
----------------------------------------------*/
$(document).on('change', '.hotel_name', function(event) {
  var ID = $(this).val();
   if(ID != ''){
      get_room_numbers(ID);
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
      setRoomService();
   }
});




/*----------------------------------------------
  				SET ROOM_SERVICE DETAILS Temp_data
----------------------------------------------*/
function setRoomService(){
	var hotelId = $('select[name="hotel_id"]').val();
	var roomNumber = $('input[name="room_number"]:checked').val();
	const arr = {'hotel_id':hotelId, 'room_number':roomNumber};
	const jsonData = JSON.stringify(arr);


	var url = `${base_url}admin/pos/room_service_details/`;
		$.post(url, {'data':jsonData,'shop_id':shopId,'csrf_test_name': csrf_value }, function(json){
			if(json.st == 1){
				updateOrderType(json.result);
				orderDetails(true,json.shopId);
			}

		},'json');
	return false;
}


/*----------------------------------------------
  				SET PICKUP COD Temp_data
----------------------------------------------*/
$(document).on('keypress keyup', '.shippingAddress', function(event) {

	var length = $(this).val().length;
	if(length > 3){
  	$('.nextbtnArea').slideDown();
	}else{
		$('.nextbtnArea').slideUp();
	}
});


$(document).on('click', '.nextBtn', function(event) {
  	setCashonDelivery();
});


$(document).on('click', '.catIcon', function(event) {
  $('.categoryArea').toggleClass('active');
});


function setCashonDelivery(){
	var shippingArea = $('input[name="shipping_area"]:checked').val();
	var address = $('textarea[name="shipping_address"]').val();
	var deliveryAddress = $('input[name="delivery_area"]').val();
	const arr = {'shipping_area':shippingArea, 'address':address,'delivery_area':deliveryAddress};
	const jsonData = JSON.stringify(arr);


	var url = `${base_url}admin/pos/shipping_details/`;
		$.post(url, {'data':jsonData,'shop_id':shopId,'csrf_test_name': csrf_value }, function(json){
			if(json.st == 1){
				updateOrderType(json.result);
				orderDetails(true,json.shopId);
			}

		},'json');
	return false;
}


$(document).on('click', '.catId', function(e) {
		var url = $(this).attr('href');
  	get_item_by_cat(url);
  	e.preventDefault();
});


$(document).on('click','#pagination .ci-pagination li  a',function(){
	$('.itemListArea').addClass('null').html(loader_gray);
	var id = $('.ci-pagination-link').data('id');
	var url = $(this).attr("href");
	$.get(url, {'csrf_test_name': csrf_value }, function(json){
		if(json.st == 1){
			setTimeout(()=>{
          $('.itemListArea').removeClass('null');
          $('.itemListArea').html(json.result);
        },1000)
		}
	},'json');
	return false;
});

function get_item_by_cat(url){
    $('.itemListArea').addClass('null').html(loader_gray);
    $.get(url, {'csrf_test_name': csrf_value }, function(json){
      if(json.st == 1){
        setTimeout(()=>{
          $('.itemListArea').removeClass('null');
          $('.itemListArea').html(json.result);
        },1000)
       
      }
    },'json');
}


}(jQuery)); 