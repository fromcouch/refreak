(function($) {
        
        var task_new = function(element, options){
		this.element = $(element);			
		this.init();
        };
          
        task_new.prototype = {                          
             
                options: null,
                element: null,

                init : function( options ) {

                       var me = this;

                       if (options !== undefined)
                           this.options = options;

                       this._(".task_dead").datepicker({
                                showOn: "button",
                                buttonImage: s_url + "/theme/default/images/cal.gif",
                                buttonImageOnly: true,
                                dateFormat:   "dd/mm/yy"
                       });

                       this._(".task_projects").on('change', function() { me.load_users(this); });
                       
                       this._(".task_edit_cancel").on('click', function() { me.close(this); });

                },

                _: function(selector) {

                        return $(selector, this.element);

                }, 
                       
                load_users: function(obj) {
                        
                        var me = this;
            
                        $.ajax({
                            type:       "POST",
                            url:        s_url + "/tasks/get_users_from_project/",
                            data:       {
                                            project_id: $(obj).val()
                                        }
                        }).done(function(res) {
                                if (res.response === "rfk_ok") {
                                    var $select_users = me._('.task_users').empty();

                                    $.each(res.data, function(i,item) {
                                        $select_users.append( '<option value="'
                                                             + item.id
                                                             + '">'
                                                             + item.first_name + " " + item.last_name
                                                             + '</option>' ); 
                                    });
                                }

                        }).fail(function(res) {
                                alert("");
                        });
                },
                
                close: function() {
                        
                        this._(".task_projects").off('change');
                       
                        this._(".task_edit_cancel").off('click');
                        
                        $(this.element).html("").hide();
                        
                },
                
                destroy: function() {
                        this.close();
                }
         }
 
         $.fn.newTask = function( ) {
              
              $(this).each(function(){ 
                  $(this).data('newTask', new task_new(this, null)); 
              });

              return this;
              
         };
        
})(jQuery);

