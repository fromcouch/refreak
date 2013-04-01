
(function( $ ){
    
    

    $.boxes = function (options) {                          

            var me = this;
            
            var defaults = {
                message: 'Message',
                onInit: null,
                onShow: null
            };
            
            this.settings = {};
            
            this.init = function( options ) {

                options = ((typeof options) == "string" ? {message: options} : options);

                me.settings = $.extend({}, defaults, options);

                //me._executeCallBack('onInit', null);
                me._createBox();
                
            };
                       
            this._executeCallBack = function(callbackName, args){
			if($.isFunction(me.settings[callbackName]))
				me.settings[callbackName].apply(null, args);
            };
            
            this._createBox = function() {
                $(".content").prepend(
                    $("<div/>")
                        .addClass("infoMessage")
                        .html(me.settings.message)
                        .show(100)
                        .delay(5000)
                        .hide(500, function() {
                            $(this).remove();
                        })
                );
            };
            
            this.init( options );
    };
    
    
    $.call_ajax = function (options) {                          

            var me = this;
            
            var defaults = {
                type: "POST",
                dataType: "json",
                data: {},
                onDone: null,
                onDoneKo: null,
                onFail: null
            };
            
            this.settings = {};
            
            this.init = function( options ) {

                options = ((typeof options) == "string" ? {message: options} : options);

                me.settings = $.extend({}, defaults, options);

                //me._executeCallBack('onInit', null);
                me._callAjax();
                
            };
                       
            this._executeCallBack = function(callbackName, args){
			if($.isFunction(me.settings[callbackName]))
				me.settings[callbackName].apply(null, args);
            };
            
            this._callAjax = function() {
                
                    $.ajax({
                        type:       me.settings.type,
                        url:        s_url + "/tasks/get_users_from_project/",
                        dataType:   me.settings.dataType,
                        data:       me.settings.data
                    }).done(function(res) {
                        if (res.response === "rfk_ok") {
                            
                            me._executeCallBack('onDone', res);
                            
                        }
                        else {
                            
                            me._executeCallBack('onDoneKo', res)
                            alert(tasksmessage_ajax_error_security);
                            
                        }

                    }).fail(function(res) {
                        
                        me._executeCallBack('onFail', res),
                        alert(tasksmessage_ajax_error_server);
                        
                    });
                
            };
            
            this.init( options );
    }
    
    
       
})( jQuery );