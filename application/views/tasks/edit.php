
        <table cellpadding="2" cellspacing="0" border="0">
                <tr>
                        <th><?php echo $this->lang->line('task_edit_priority'); ?>:</th>
                        <td><?php echo form_dropdown('task_priority', $this->lang->line('task_priority'), $priority, 'class="task_priority"'); ?></td>
                        <th style="text-align:right"><?php echo $this->lang->line('task_edit_context'); ?>:</td>
                        <td><?php echo form_dropdown('task_context', $this->lang->line('task_context'), $context, 'class="task_context"'); ?></td>		
                </tr>
                <tr>
                        <th><?php echo $this->lang->line('task_edit_deadline'); ?>:</th>
                        <td colspan="3">
                            <?php echo form_input('deadline','', 'class="task_dead"');
                            //aqui va el calendario?>              
                        </td>
                </tr>
                <tr>
                        <th><?php echo $this->lang->line('task_edit_project'); ?>:</th>
                        <td colspan="3">
                            <span class="project_sel">
                                <?php echo form_dropdown('task_projects', $user_p, array(), 'class="task_projects"'); ?>                                				
                                <?php //if ($objUser->checkLevel(7)) { ?>
                                <a href="#" class="small">&gt; <?php echo $this->lang->line('task_edit_project_new'); ?></a>
                            </span>
                            <span class="project_txt">
                                <?php echo form_input('task_project_name'); ?>
                                <a href="#" class="small">&lt; <?php echo $this->lang->line('task_edit_project_list'); ?></a>
                            </span>
                        </td>
                </tr>
                <tr>
                        <th><?php echo $this->lang->line('task_edit_title'); ?>:</th>
                        <td colspan="3"><?php echo form_input('task_title', '', 'class="task_full"'); ?></td>
                </tr>
                <tr valign="top">
                        <th><?php echo $this->lang->line('task_edit_description'); ?>:</th>
                        <td colspan="3"><?php echo form_textarea('task_description', '', 'class="task_full"'); ?></td>
                </tr>        
                <tr>
                        <th><?php echo $this->lang->line('task_edit_user'); ?>:</th>
                        <td colspan="3">
                                <?php echo form_dropdown_users('task_users','-',$actual_user->id); ?>
                                <span>
                                    <?php echo form_radio('showPrivate', '0') ?><label><?php echo $this->lang->line('task_edit_public'); ?></label>
                                </span>
                                <span><?php //if ($objUser->checkLevel(12)) { ?>
                                    <?php echo form_radio('showPrivate', '1') ?><label><?php echo $this->lang->line('task_edit_internal'); ?></label>
                                </span>
                                <span>
                                    <?php echo form_radio('showPrivate', '2') ?><label><?php echo $this->lang->line('task_edit_private'); ?></label>
                                </span>
                        </td>
                </tr>
                <tr>
                        <th><?php echo $this->lang->line('task_edit_status'); ?>:</th>
                        <td colspan="3"><?php echo form_dropdown('task_status', $this->lang->line('task_status'), array(),'class="task_status"'); ?></td>
                </tr>
        </table>
        <p class="ctr">
                <?php echo form_submit('submit', $this->lang->line('task_edit_save'));?> 
                &nbsp; &nbsp;    
                <?php echo form_button('btn_cancel', $this->lang->line('task_edit_cancel'));?> 
        </p>
        
        <script type="text/javascript">
                (function($) {
                        
                        $.ajaxSetup({
                            data: {<?php echo $this->security->get_csrf_token_name()?>: "<?php echo $this->security->get_csrf_hash() ?>"},
                            dataType: "json"
                        });
                        $(".task_dead").datepicker({
                              showOn: "button",
                              buttonImage: "<?php echo base_url();?>theme/default/images/cal.gif",
                              buttonImageOnly: true,
                              dateFormat:   "dd/mm/yy"
                        });
                        
                        $(".task_projects").on('change', function() {
                                $.ajax({
                                    type:       "POST",
                                    url:        "<?php echo site_url(); ?>/tasks/get_users_from_project/",
                                    data:       {
                                                    project_id: $(this).val()
                                                }
                                }).done(function(res) {
                                        if (res.response === "rfk_ok") {
                                            var $select_users = $('.task_users').empty();
                                            
                                            $.each(res.data, function(i,item) {
                                                $select_users.append( '<option value="'
                                                                     + item.id
                                                                     + '">'
                                                                     + item.first_name + " " + item.last_name
                                                                     + '</option>' ); 
                                            });
                                        }

                                }).fail(function(res) {
                                        alert("<?php echo $this->lang->line('projectsmessage_ajax_error_server'); ?>");
                                });
                        });
                })(jQuery);
        </script>