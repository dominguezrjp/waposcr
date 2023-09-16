(function ($) {
	"use strict";


$(document).on('click','.submit-btn', function(){
	if(!check_empty_field())
	{
		submitMSG(false, "The form is not fill up properly. Please Check the RED marked field.");
		return false;
	}
	
})






// check all empty fields with required attribute
function check_empty_field(){
	var valid = true;
	$('input, select, textarea').each(function(){
	   if($(this).val()=="" && $(this).prop('required')){
	   		$(this).addClass('invalid');
	   		if($(this).attr('id')=="uploaded_img"){
	   			$('.up_user_img').addClass('invalid');
	   		}
	      	valid = false;
	    }
	});

	return valid;
}


//email validation function
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}

// default msg function
function submitMSG(valid, msg){
    if(valid){
        var alertClasses = "h3 text-center fadeInDown animated text-success easy_error_msg";
    } else {
        var alertClasses = "h3 text-center fadeInUp animated text-danger easy_error_msg";
    }
    $("#msgSubmit").removeClass().addClass(alertClasses).text(msg);

}



$.MSG = $.fn.MSG = function(valid, msg){
	if(valid){
        var alertClasses = "h3 text-center fadeInDown animated text-success easy_error_msg";
    } else {
        var alertClasses = "h3 text-center fadeInUp animated text-danger easy_error_msg";
    }

    $("#msgSubmit").removeClass().addClass(alertClasses).text(msg).slideDown();
}

setTimeout(() => {
	 $("#msgSubmit").removeClass().text('').slideUp();
},1000);



$.fn.btn = function (action) {
    var self = $(this);
    if (action == 'loading') {
        $(self).addClass("btn-loading");
    }
    if (action == 'reset') {
        $(self).removeClass("btn-loading");
    }

}



}(jQuery));	


 