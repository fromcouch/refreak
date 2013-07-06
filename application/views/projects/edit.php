<div class="center">
    <div class="horiz">
        <?php echo validation_errors(); 
              echo form_open("projects/edit/".$pid);
              echo form_fieldset($this->lang->line('projectscrud_info'));?>
              <p><?php echo $this->lang->line('projectscrud_compulsory'); ?></p>
              <p>
                    <label class="compulsory"><?php echo $this->lang->line('projectscrud_name'); ?> </label>
                    <?php if($actual_user->project_position == 5) :
                                echo form_input($name);
                          else :
                                echo $name['value'];
                          endif;?>
              </p>

              <p>
                    <label><?php echo $this->lang->line('projectscrud_description'); ?> </label>
                    <?php if($actual_user->project_position == 5) :
                                echo form_textarea($description);
                          else :
                                echo empty($description['value']) ? '-' : $description['value'];
                          endif;?>            
              </p>

              <p>
                    <label><?php echo $this->lang->line('projectscrud_status'); ?> </label>
                    <?php echo form_dropdown('status', $this->lang->line('project_status'), $status);?>
              </p>
              <p>
                    <?php echo form_submit('submit', $this->lang->line('projectscrud_save'));?> 
              </p>
              <?php echo form_fieldset_close();
              echo form_fieldset($this->lang->line('projectscrud_members'));?>

              <?php if ($actual_user->project_position >= 4) : ?>                
              <p><img src="<?php echo base_url() . $theme;?>/images/bullet.png" /> <a href="" class="project_members"><?php echo $this->lang->line('projectscrud_add_members'); ?></a></p>
                <div class="invitation">
                    <?php echo form_fieldset();?>
                        <table cellspacing="0" cellpadding="3" border="0" class="form">
                            <tr>
                                <th><?php echo $this->lang->line('projectscrud_user'); ?>:</th>
                                <td><?php echo form_dropdown('dropdown_users', $dropdown_users, array(), 'class="dropdown_users"'); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('projectscrud_position'); ?>:</th>
                                <td><?php 
                                    echo form_dropdown('project_position', $this->lang->line('project_position'), array(), 'class="project_position"');
                                ?></td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td><?php
                                    echo form_input(array(
                                        'type'      => 'button',
                                        'class'     => 'project_invite',
                                        'value'     => $this->lang->line('projectscrud_add_members'),
                                        'name'      => 'project_invite'
                                    ));
                                ?></td>                            
                            </tr>
                        </table>
                    <?php echo form_fieldset_close(); ?>
                </div>      
              <?php endif; ?>
              <table cellspacing="0" cellpadding="3" border="0" width="100%" class="data">
                    <thead>
                            <tr align="left">
                                    <th width="45%"><?php echo $this->lang->line('projectscrud_user'); ?></th>
                                    <th width="15%"><?php echo $this->lang->line('projectscrud_position'); ?></th>                            
                                <?php if ($actual_user->project_position >= 4) : ?>
                                    <th width="10%"><?php echo $this->lang->line('projectscrud_action'); ?></th>
                                <?php endif; ?>
                            </tr>
                    </thead>
                    <tbody>
                        <?php   
                                $position = $this->lang->line('project_position');
                                foreach ($project_users as $pu) :  ?>
                            <tr data-id="<?php echo $pu->user_id; ?>" class="project_data">
                                <td><?php echo $pu->first_name . ' ' . $pu->last_name; ?></td>
                                <td><?php echo $position[$pu->position]; ?></td>
                                <?php if ($actual_user->project_position >= 4) : ?>
                                <td>
                                    <?php if($pu->position === 5 || $actual_user->id == $pu->user_id || $pu->position >= $actual_user->project_position) : 
                                                echo '-';
                                          else : ?>
                                              <a href="#" class="project_members_edit"><img src="<?php echo base_url() . $theme; ?>/images/b_edit.png" width="20" height="16" border="0" /></a>
                                              <a href="#" class="project_members_delete"><img src="<?php echo base_url() . $theme; ?>/images/b_dele.png" width="20" height="16" border="0" /></a> 
                                    <?php endif; ?>                           
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php   endforeach;   ?>
                    </tbody>
              </table>

              <?php echo form_fieldset_close(); 
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

                var pid = $("input[name=id]").val();
                var uid = $(".dropdown_users").val();
                var pos = $(".project_position").val();

                $.call_ajax({
                        type:       "POST",
                        url:        "<?php echo site_url(); ?>projects/add_user_project/",
                        data:       {  
                                        project_id: pid, 
                                        user_id: uid,
                                        position: pos
                                    },
                        onDone:     function(res) {

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

                                        $("tbody",".data")
                                                .append($tr);                                                                

                                        $tr.manageProject();

                                        $(".dropdown_users option:selected").remove();

                                        $.boxes("<?php echo $this->lang->line('projectsmessage_useradded'); ?>");
                                    }
                });

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


                $(".project_show_position option:contains(" + position + ")", this.element).attr('selected', 'selected'); 

                return false; 
            },
                 
            members_delete: function(event) {

                event.preventDefault();
                
                if (confirm("<?php echo $this->lang->line('projectsmessage_remove_user'); ?>")) {
                    
                    var me      = this.element;
                    var pid     = $("input[name=id]").val();
                    var uid     = me.attr("data-id");
                    var uname   = me.children(":first").html()
                    
                    $.call_ajax({
                        type:       "POST",
                        url:        "<?php echo site_url(); ?>projects/remove_user_project/",
                        data:       {  
                                        project_id: pid, 
                                        user_id: uid                                    
                                    },
                        onDone:     function(res) {

                                        me.remove();

                                        $(".dropdown_users").append(new Option(uname, uid));

                                        $.boxes("<?php echo $this->lang->line('projectsmessage_userremoved'); ?>");
                                    }
                            
                    });

                }

                return false; 
            },                            
                
            project_change: function (event) {
                
                var pid         = $("input[name=id]").val();
                var uid         = this.element.attr("data-id");
                var $psp        = this.element.find(".project_show_position");
                var position    = $psp.val();


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