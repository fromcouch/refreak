(function($) {
        
        var task_new = function(element, options){
		this.element = $(element);			
		this.init();
        };
        
        var task_show = function(element, options){
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
                       
                       this._(".task_edit_new_project").on('click', function() { me.show_input_project(this); });
                       this._(".task_edit_list_project").on('click', function() { me.show_list_project(this); });
                       
                       this._(".task_edit_save").on('click', function() { me.send_data(this); });
                       

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
                                else {
                                    alert(tasksmessage_ajax_error_security);
                                }

                        }).fail(function(res) {
                                alert(tasksmessage_ajax_error_server);
                        });
                },
                
                show_input_project: function () {
                    
                    this._(".project_sel").hide();
                    this._(".project_txt").show();
                    
                },
                
                show_list_project: function () {
                    
                    this._(".project_txt").hide();
                    this._(".project_sel").show();
                    
                },
                
                send_data: function(obj) {
                        
                        var me = this;
                        var $title_value = this._(".task_edit_title");
                        
                        if ($title_value.val() != "") {

                            $.ajax({
                                type:       "POST",
                                url:        s_url + "/tasks/save_task/",
                                data:       this._(".task_edit_form").serialize()

                            }).done(function(res) {
                                    if (res.response === "rfk_ok") {
                                        
                                        if (res.tid > 0) {
                                            $.boxes(tasksmessage_updated);
                                        }
                                        else {
                                            $.boxes(tasksmessage_created);
                                        } 
                                            
                                        me.close();
                                    }
                                    else {
                                        alert(tasksmessage_ajax_error_security);
                                    }

                            }).fail(function(res) {
                                    alert(tasksmessage_ajax_error_server);
                            });
                        }
                        else {
                            $title_value.css("border-color", "red");
                            $.boxes("title is required");
                        }
                    
                },
                
                close: function() {
                        
                        this._(".task_projects").off('change');
                       
                        this._(".task_edit_cancel").off('click');
                        
                        this._(".task_edit_new_project").off('click');
                        this._(".task_edit_list_project").off('click');
                       
                        this._(".task_edit_save").off('click');
                       
                        
                        $(this.element).html(
                                                $("<img>").attr("border","0")
                                                          .attr("src", s_url + "theme/default/images/load.gif")
                                                          .addClass("loader")
                        
                        ).hide();
                        
                },
                
                destroy: function() {
                        this.close();
                }
         }
 
        task_show.prototype = {
             
                options: null,
                element: null,

                init : function( options ) {

                       var me = this;

                       if (options !== undefined)
                           this.options = options;

                       this._(".task_show_close").on('click', function() { me.close(this); });
                       

                },

                _: function(selector) {

                        return $(selector, this.element);

                }, 
                                       
                close: function() {
                        
                        this._(".task_show_close").off('click');
                        
                        $(this.element).html(
                                                $("<img>").attr("border","0")
                                                          .attr("src", s_url + "theme/default/images/load.gif")
                                                          .addClass("loader")
                        
                        ).hide();
                        
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
        
         $.fn.showTask = function( ) {
              
              $(this).each(function(){ 
                  $(this).data('showTask', new task_show(this, null)); 
              });

              return this;
              
         };
        
})(jQuery);

