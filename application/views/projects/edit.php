<div class="center">
    <div class="horiz">
        <?php echo validation_errors(); 
              echo form_open("projects/edit/".$pid);
              
              echo project_helper::edit_project_info($this->lang->line('projectscrud_info'), 
                                                  $this->lang->line('projectscrud_compulsory'), 
                                                  $this->lang->line('projectscrud_name'), 
                                                  $this->lang->line('projectscrud_description'), 
                                                  $this->lang->line('projectscrud_status'), 
                                                  $this->lang->line('projectscrud_save'), 
                                                  $name, 
                                                  $description, 
                                                  $this->lang->line('project_status'),
                                                  $actual_user->project_position,
                                                  $status);
              
              echo project_helper::edit_bottom_part(base_url() . $theme, 
                                                    $this->lang->line('projectscrud_add_members'), 
                                                    $this->lang->line('projectscrud_user'), 
                                                    $this->lang->line('projectscrud_position'), 
                                                    $this->lang->line('projectscrud_action'), 
                                                    $this->lang->line('projectscrud_members'), 
                                                    $this->lang->line('project_position'), 
                                                    $project_users, 
                                                    $actual_user,
                                                    $dropdown_users);
              
              
              echo form_hidden('id', $pid);

              echo form_close();

if ($actual_user->project_position >= 4) :
    
        // hidden select and button for position 
        echo form_dropdown('project_hidden_position', $this->lang->line('project_position'), array(), 'class="project_hidden_position"');
        echo form_button(array(
                'class'     => 'project_hidden_change',
                'content'   => $this->lang->line('projectscrud_hidden_change')
            ));
?> 
    </div>
</div>   
<script type="text/javascript" charset="utf-8">
    
    
    (function( $ ){

          $(".project_members").on("click", function() {
              $(".invitation").toggle("slow");
              return false;
          });

          $(".project_invite").on("click", function() {

		var me = $(this);
                var pid = $("input[name=id]").val();
                var uid = $(".dropdown_users").val();
                var pos = $(".project_position").val();
		
		if (uid > 0 ) {
		
			$(this).trigger("refreak.project_edit.invite_user", [ uid, pid, pos ]);

			$.call_ajax({
				type:       "POST",
				url:        "<?php echo site_url(); ?>projects/add_user_project/",
				data:       {  
						project_id: pid, 
						user_id: uid,
						position: pos
					    },
				onDone:     function(res) {

						me.trigger("refreak.project_edit.user_invited", [ res, uid, pid, pos ]);

						var $tr = $("<tr></tr>").attr("data-id", uid).addClass("project_data");
						$tr.append(
							    $("<td></td>").html($(".dropdown_users option:selected").html())
							).append(
							    $("<td></td>").html($(".project_position option:selected").html())
							).append(
							    $("<td></td>").append(
								    $("<a></a>").addClass("project_members_edit").attr("href","")
									    .append(
										$("<img/>")
											.attr("src","<?php echo base_url() . $theme; ?>/images/b_edit.png")  
											.attr("width","20")  
											.attr("height","16")  
											.attr("border","0")
									    )
								).append(
								    $("<a></a>").addClass("project_members_delete").attr("href","")
									    .append(
										$("<img/>")
											.attr("src","<?php echo base_url() . $theme; ?>/images/b_dele.png")  
											.attr("width","20")  
											.attr("height","16")  
											.attr("border","0")
									    )
							       )                              
							);
						
						me.trigger("refreak.project_edit.user_added", [ res, uid, pid, pos, $tr ]);

						$("tbody",".data")
							.append($tr);                                                                

						$tr.manageProject();

						$(".dropdown_users option:selected").remove();

						$.boxes("<?php echo $this->lang->line('projectsmessage_useradded'); ?>");
					    }
			});
		}
		else
		{
			//no user selected
			$(this).trigger("refreak.project_edit.nouser");
			$.boxes("<?php echo $this->lang->line('projectsmessage_nouser'); ?>");
		}

          });
          
          var prj = function(element, options){
		this.element = $(element);			
		this.init();
          };
          
          prj.prototype = {                          
             
             options: null,
             element: null,
             
             init : function( options ) {
               
                    var me = this;
                    
		    this.element.trigger("refreak.project_edit_member.init", this.options );
		    
                    if (options !== undefined)
                        this.options = options;
                    
                    this._(".project_members_edit").on("click", function(e) { me.members_edit(e); });

                    this._(".project_members_delete").on("click", function(e) { me.members_delete(e); });

             },
             
             _: function(selector) {
                
                    return $(selector, this.element);
                
             }, 
             
             members_edit: function(event) {
                            
                event.preventDefault();
                
                var me = this;
                var position_cell   = this.element.children("td").eq(1);
                var position        = position_cell.text();                        

		this.element.trigger("refreak.project_edit_member.edit", position );

                position_cell.html("");            
                position_cell.append($(".project_hidden_position").clone()
                                                                    .show()
                                                                    .attr("class", "project_show_position")                                                                             
                );
                    
                this.element.children("td:last").hide();

                this.element.append($("<td></td>").append(                    
                            $(".project_hidden_change").clone()
                                                       .show()
                                                       .attr("class", "project_show_change")
                                                       .bind("click", function (e) { me.project_change(e); })
                        )
                );


                this._(".project_show_position option:contains(" + position + ")").attr('selected', 'selected'); 
		
		this.element.trigger("refreak.project_edit_member.edited", position );

                return false; 
            },
                 
            members_delete: function(event) {

                event.preventDefault();
                
                if (confirm("<?php echo $this->lang->line('projectsmessage_remove_user'); ?>")) {
                    
			var me      = this.element;
			var pid     = $("input[name=id]").val();
			var uid     = me.attr("data-id");
			var uname   = me.children(":first").html()
                    
			this.element.trigger("refreak.project_edit_member.delete", [ pid, uid, uname ] );
		    
			$.call_ajax({
			    type:       "POST",
			    url:        "<?php echo site_url(); ?>projects/remove_user_project/",
			    data:       {  
					    project_id: pid, 
					    user_id: uid                                    
					},
			    onDone:     function(res) {

						me.trigger("refreak.project_edit_member.deleted", [ res, pid, uid, uname ] );
						
						me.remove();

						$(".dropdown_users").append(new Option(uname, uid));

						$.boxes("<?php echo $this->lang->line('projectsmessage_userremoved'); ?>");
					}

			});

                }

                return false; 
            },                            
                
            project_change: function (event) {
                
		var me		= this.element;
                var pid         = $("input[name=id]").val();
                var uid         = this.element.attr("data-id");
                var $psp        = this.element.find(".project_show_position");
                var position    = $psp.val();

		this.element.trigger("refreak.project_edit_member.change_position", [ pid, uid, position ] );

                $.call_ajax({
                    type:       "POST",
                    url:        "<?php echo site_url(); ?>projects/change_user_position/",
                    data:       {  
                                    project_id: pid, 
                                    user_id: uid,
                                    position: position
                                },
                    onDone:     function(res) {
					
					var new_position = $psp.find(":selected").html();
					var $td = $psp.parents("td");
					$psp.remove();
					$td.html(new_position);

					this.element.trigger("refreak.project_edit_member.changed_position", [ pid, uid, new_position ] );

					$td.next().show().next().remove();

					$.boxes("<?php echo $this->lang->line('projectsmessage_userchanged'); ?>");
                                }
                        
                });

             },
             
             _executeCallBack: function(callbackName, args){
			if($.isFunction(this.options[callbackName]))
				this.options[callbackName].apply(null, args);
             }
          };

          $.fn.manageProject = function( ) {
              
              $(this).each(function(){ 
                  $(this).data('manageProject', new prj(this, null)); 
              });

              return this;
              
          };


          $(".project_data").manageProject();
          
    })( jQuery );
    
</script>
<?php endif; ?>