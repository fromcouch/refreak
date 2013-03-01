
(function( $ ){
    
    

    $.boxes = function (options) {                          

            var me = this;
            
            var defaults = {
                message: 'Message',
                onInit: null,
                onShow: null
            };
            
            me.settings = {};
            
            me.init = function( options ) {

                options = ((typeof options) == "string" ? {message: options} : options);

                me.settings = $.extend({}, defaults, options);

                //me._executeCallBack('onInit', null);
                me._createBox();
                
            };
                       
            me._executeCallBack = function(callbackName, args){
			if($.isFunction(me.settings[callbackName]))
				me.settings[callbackName].apply(null, args);
            };
            
            me._createBox = function() {
                $(".content").prepend(
                    $("<div/>")
                        .addClass("infoMessage")
                        .html(me.settings.message)
                        .show(100)
                        .delay(10000)
                        .hide(500, function() {
                            $(this).remove();
                        })
                );
            };
            
            me.init( options );
    }
    
       
})( jQuery );