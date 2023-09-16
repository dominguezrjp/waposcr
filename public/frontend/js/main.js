(function($) {
	"use strict"


var base_url = $('#base_url').attr('href');
var csrf_value = $('#csrf_value').attr('href');
var code = $('#code').attr('href');
var dial_code = $('#dial_code').attr('href');

var reg_code = $('#reg_code').attr('href');
var reg_dial_code = $('#reg_dial_code').attr('href');
var get_rtl = $('#rtl').data('id');
var is_xs = $('#is_xs').data('id');

if(get_rtl=='rtl'){
  var rtl = true;
}else{
  var rtl = false;
}
$('.country_code').val(code);
$('.dial_code').val(dial_code);

$('.country_code_1').val(reg_code);
$('.dial_code_1').val(reg_dial_code);

AOS.init({
  // Global settings:
  disable: 'phone', // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
  startEvent: 'DOMContentLoaded', 
  initClassName: 'aos-init', 
  animatedClassName: 'aos-animate', 
  useClassNames: false, 
  disableMutationObserver: false,
  debounceDelay: 50, 
  throttleDelay: 99, 
  delay: 800, 
  duration: 1000, 
  easing: 'ease',  
  once: false, 
  mirror: false, 
  anchorPlacement: 'top-bottom', 

});

 $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });


$('a.back').on("click",function(){
    parent.history.back();
});


$('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
  });

$(function(){
	$(document).on('click', '.navBtn', function(e) {
		e.preventDefault();
		$('.navArea').toggleClass('isVisible');

	});
})


$(function(){
  $('.display').hide();
  $(document).on('click', '.toggle_click', function(e) {
    e.preventDefault();
    $('.display').slideToggle();

  });
})



if(is_xs=='xs-container'){
  var is_xs = true;
}else{
  var is_xs = false;
}






$(function(){
  $('.team_slider').slick({
    slidesToShow:3,
    slidesToScroll: 1,
    rtl: rtl,
    autoplay: false,
    prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
    nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
    autoplaySpeed: 2000,
    dots: false,
    arrows: true,
    focusOnSelect:true,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    ]
  });
});


$(function(){
	var progressBar = $('.progress-bar');
	progressBar.appear(function() {
		progressBar.each(function(){
			var progressBarWidth = $(this).data('present');
			/*-- Skill Animation --*/
			$(this).css({'width': progressBarWidth+'%', 'opacity': '1' });
		});
	});
});




$(function(){
	$(document).on('click', '.create_profile', function() {
       $('html, body').animate({
		    scrollTop: $(".pricing_area").offset().top
		}, 1000);
    });
})



// home page contact mail
$(function(){
	$(document).on('submit', '#home_contact', function(event) {
    	send_btn_loader(true);
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(json){
            if (json.st == 1) {
                $(".reg_msg").html(json.msg).show(); 
                send_btn_loader(false);
                $("#home_contact")[0].reset(); 
            }else{
                $(".reg_msg").html(json.msg).show();
                send_btn_loader(false);
            }
        },'json');
        setTimeout(function(){$('.reg_msg').hide()}, 2000);
        return false;
    });
 });


function send_btn_loader(type){
	var $this = $('.mail_send_btn');
	if(type==true){
    	 $this.addClass('btn-spinner');
    	 $this.attr('disabled', true);
    }else{
    	$this.removeClass('btn-spinner');
        $this.prop('disabled', false);
    }
}


jQuery(document).ready(function($) {
	$('.scroll-line').css('width', '0%');
});


$(function(){
	$(window).on('scroll', function() {
		var wintop = $(this).scrollTop(), docheight = 
		$(document).height(), winheight = $(window).height();
		var scrolled = (wintop/(docheight-winheight))*100;
		$('.scroll-line').css('width', (scrolled + '%'));
	});
})




$(document).on('click','preview_pdf', function() {
		var url = $(this).attr('href');
      window.open(url, "windowName", windowOptions);
});





/**
  ** scroll
**/

$(function(){
  $(window).on('scroll', function() {
    var wintop = $(this).scrollTop(), docheight = 
    $(document).height(), winheight = $(window).height();
    var scrolled = (wintop/(docheight-winheight))*100;
    $('.left_height_line').css('height', (scrolled + '%'));

  });
});


/**
  ** layout 5 left menu
**/
$(function(){
  $(document).on('click', '.hideNav', function(event) {
    $('.leftMenu_bar').animate({"left": '-260px'});
  });


  $(document).on('click', '.topMenu_bar a', function(event) {
    $('.leftMenu_bar').animate({"left": '0'});
  });
})

 $(document).on('click', '.createBtn', function(event) {
    var  username = $('.checkUsername').val();
    window.location = `${base_url}sign-up?u=${username}`
  });

 $(document).on('click', '.checkmap', function(event) {
    $('.pickup_point_map').addClass('active');
    $('.single_pickup_area').removeClass('active');
    $('.add_pickpoint_value').val(0);
  });


  $(document).on('click', '.closeMap', function(event) {
    $('.pickup_point_map').removeClass('active');
    $('.add_pickpoint_value').val(0);
  });

 $(document).on('click', '.single_pickup_area', function(event) {
    var id = $(this).data('id');
    $('.single_pickup_area').removeClass('active');
    $(this).addClass('active');
    $('.add_pickpoint_value').val(id);
  });




$(function(){
  $('.scroll-top').fadeOut();
    $(window).scroll(function() {
        var scroll=$(window).scrollTop();
        if(scroll>=500) {
          $('.scroll-top').fadeIn();
        }
        else {
          $('.scroll-top').fadeOut();
        }
    });

  $('.scroll-top a').on('click', function(event) {
     $("html, body").animate({ scrollTop: 0 }, 1000);
  });
});


$(function(){
    $(".accordions").on("click", ".page_accordion_header", function() {
        $(this).toggleClass("active").next().slideToggle(300);
        $(this).toggleClass('arrow_up').toggleClass('arrow_down');
    });
});



//ISOTOPE PORTFOLIO WITH FILTER
$(window).on('load', function(){
 
      var $container = $('.grid');
      $container.isotope({
        filter: '*',
        layoutMode: 'fitRows',
        animationOptions: {
          duration: 750,
          easing: 'linear',
          queue: false
        }
      });
     
      $('.gallery_sort li button').click(function(){
        $('.gallery_sort li button.active').removeClass('active');
        $(this).addClass('active');
     
        var selector = $(this).attr('data-filter');
        $container.isotope({
          filter: selector,
          animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
          }
         });
         return false;
      }); 
  
  });


$('.copy').on('click', function(e) {
  e.preventDefault();

  var copyText = $(this).data('link');

  var textarea = document.createElement("textarea");
  textarea.textContent = copyText;
  textarea.style.position = "fixed"; // Prevent scrolling to bottom of page in MS Edge.
  document.body.appendChild(textarea);
  textarea.select();
  document.execCommand("copy"); 

  $(this).addClass('d_bg');
    document.body.removeChild(textarea);
  });



$(function(){
  var input = $("#phone");
  if(input.length > 0){
      var code = dial_code; // Assigning value from model.
      input.val(code);
      input.intlTelInput({
        autoHideDialCode: true,
        autoPlaceholder: "ON",
        formatOnDisplay: true,
        placeholderNumberType: "MOBILE",
        separateDialCode: true
      });
      jQuery(input).on('countrychange', function(e, countryData){
        $('.country_code').val(input.intlTelInput("getSelectedCountryData").iso2);
        $('.dial_code').val(input.intlTelInput("getSelectedCountryData").dialCode);
      });
  }
})


$(function(){
  var input = $("#reg_phone");
  if(input.length > 0){
      var code = reg_dial_code; // Assigning value from model.
      input.val(code);
      input.intlTelInput({
        autoHideDialCode: true,
        autoPlaceholder: "ON",
        formatOnDisplay: true,
        placeholderNumberType: "MOBILE",
        separateDialCode: true
      });
      jQuery(input).on('countrychange', function(e, countryData){
        $('.reg_country_code').val(input.intlTelInput("getSelectedCountryData").iso2);
        $('.reg_dial_code').val(input.intlTelInput("getSelectedCountryData").dialCode);
      });
  }
})

  $(function(){
      function load_image(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              $('#preview_load_image').attr('src', e.target.result);
              $('#preview_load_image').removeClass('opacity_0');
              $('.preview_load_image, .view_img').show();
              $('.preview_load_image').hide();
              $('.img_text, .view_img ').hide();
          }
          reader.readAsDataURL(input.files[0]);
        }
      }

      $(document).on('change','#load_image',function($){
        load_image(this);
      });
  });

  $(function(){
    $(document).on('click','#getLocation',function($){
      jQuery('#shopList').html('');
      jQuery('#shopList').addClass('load');
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
        var url = `${base_url}/home/get_near_shop/${lat}/${lon}`;
        jQuery.get(url, {'csrf_test_name': csrf_value }, function(json){
          if(json.st == 1){
         
           setTimeout(() => {
            jQuery('#shopList').removeClass('load');
            jQuery('#shopList').html(json.load_data);
            jQuery('[data-toggle="tooltip"]').tooltip();

          }, 2000);
           
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
    });
  });


  $(document).on('submit','.searchItemForm',function(){
    jQuery('#shopList').html('');
    jQuery('#shopList').addClass('load');
    var val = $('.sarchValue').val();
    var url = `${base_url}home/get_popular_items/${val}`;
    $.post(url, {'csrf_test_name': csrf_value }, function(json){
      if(json.st == 1){
        setTimeout(() => {
          jQuery('#shopList').removeClass('load');
          jQuery('#shopList').html(json.load_data);
          jQuery('[data-toggle="tooltip"]').tooltip();

        }, 2000);
      }
    },'json');
    return false;
  });

  $(document).on('click','.loginBTN',function(){
    var user = $(this).data('user');
    var pass = $(this).data('pas');
    $('.usermail').val(user);
    $('.pass').val(pass);
    $('#user_login_form').submit();
  });

$('#editable-select').editableSelect();

})(jQuery);

if (!localStorage.getItem("cookieBannerDisplayed")) {
  const cookieContainer = document.querySelector(".cookie-container");
  const cookieButton = document.querySelector(".cookie-btn");
  if(cookieButton){
      cookieButton.addEventListener("click", () => {
        cookieContainer.classList.remove("active");
        localStorage.setItem("cookieBannerDisplayed", "true");
      });
    

    setTimeout(() => {
      if (!localStorage.getItem("cookieBannerDisplayed")) {
        cookieContainer.classList.add("active");
      }
    }, 2000);
  }
}