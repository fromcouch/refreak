
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
                url: null,
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
                        url:        me.settings.url,
                        dataType:   me.settings.dataType,
                        data:       me.settings.data
                    }).done(function(res) {
                        if (res.response === "rfk_ok") {
                            
                            me._executeCallBack('onDone', [res]);
                            
                        }
                        else {
                            
                            me._executeCallBack('onDoneKo', [res])
                            $.boxes(genmessage_ajax_error_security);
                            
                        }

                    }).fail(function(res) {
                        
                        me._executeCallBack('onFail', [res]),
                        $.boxes(genmessage_ajax_error_server);
                        
                    });
                
            };
            
            this.init( options );
    }
    
    $.clock = function( options ) {

            var me = this;
            
            var clk_date = new Date();
            var clk_start = 0;

            var defaults = {
                class: ".userdate"
            };
            
            this.settings = {};
            

            this.show_date = function ( opt ) {
                    clk_date = new Date();
                    if (clk_date.getSeconds() == 0) { // every minute
                            clk_intvl = clk_date.getTime() - clk_start;
                            if (frk_reload && (clk_intvl > (frk_reload * 60000))) {
                                    try {
                                            //reload
                                    } catch (e) {}
                            }
                    }
                    str = clk_date.toLocaleString();
                    $(opt.class).html(str);
                    
            };

            this.init = function ( options ) {
                
                    options = ((typeof options) == "string" ? {message: options} : options);

                    me.settings = $.extend({}, defaults, options);
                
                    clk_date = new Date();
                    clk_start = clk_date.getTime();
                    me.show_date( me.settings );
            };

            this.init( options );       
    };
    
    window.setInterval("$.clock( { class: '.userdate' } )",1000);
    
})( jQuery );