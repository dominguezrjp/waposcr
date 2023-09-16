(function($) {

  $.fn.easyNotify = function(options) {
  
    var settings = $.extend({
      title: "Notification",
      options: {
        body: "",
        icon: "",
        lang: 'pt-BR',
        onClose: "",
        onClick: "",
        onError: ""
      }
    }, options);

    this.init = function() {
        var notify = this;
      if (!("Notification" in window)) {
        console.log("This browser does not support desktop notification");
      } else if (Notification.permission === "granted") {

      	 console.log('custom notify allowed');
        var notification = new Notification(settings.title, settings.options);
        
        notification.onclose = function() {
            if (typeof settings.options.onClose == 'function') { 
                settings.options.onClose();
            }
        };

        notification.onclick = function(){
            if (typeof settings.options.onClick == 'function') { 
                settings.options.onClick();
            }
        };

        notification.onerror  = function(){
            if (typeof settings.options.onError  == 'function') { 
                settings.options.onError();
            }
        };

      } else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function(permission) {
          if (permission === "granted") {
            notify.init();
            console.log('custom notify allowed');
          }

        });
      }

    };

    this.init();
    return this;
  };

}(jQuery));