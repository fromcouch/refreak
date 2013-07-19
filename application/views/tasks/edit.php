<?php echo form_open("tasks/edit/".$task_id, 'class = "task_edit_form'); 
      echo form_hidden('task_id', $task_id); ?>
        <table cellpadding="2" cellspacing="0" border="0">
                <?php
                    echo task_helper::edit_priority_dead($this->lang->line('task_edit_priority'), 
                                                         $this->lang->line('task_priority'), 
                                                         $priority, 
                                                         $this->lang->line('task_edit_context'), 
                                                         $this->lang->line('task_context'), 
                                                         $context, 
                                                         $this->lang->line('task_edit_deadline'), 
                                                         $deadline_date);
                    
                    echo task_helper::edit_project($this->lang->line('task_edit_project'), 
                                                   $user_p, 
                                                   $project_id, 
                                                   $this->lang->line('task_edit_project_new'), 
                                                   $this->lang->line('task_edit_project_list'));
                    
                    echo task_helper::edit_title_desc($this->lang->line('task_edit_title'), 
                                                      $title, 
                                                      $this->lang->line('task_edit_description'), 
                                                      $description);
                    
                    echo task_helper::edit_user_status($this->lang->line('task_edit_user'), 
                                                       $actual_user->id, 
                                                       $private, 
                                                       $this->lang->line('task_edit_public'), 
                                                       $this->lang->line('task_edit_internal'), 
                                                       $this->lang->line('task_edit_private'), 
                                                       $this->lang->line('task_edit_status'), 
                                                       $this->lang->line('task_status'), 
                                                       $status,
                                                       $max_status);
                ?>
        </table>
        <p class="ctr">
                <?php echo form_button('btn_submit', $this->lang->line('task_edit_save'), 'class = "task_edit_save"');?> 
                &nbsp; &nbsp;    
                <?php echo form_button('btn_cancel', $this->lang->line('task_edit_cancel'), 'class = "task_edit_cancel"');?> 
        </p>
<?php echo form_close(); ?>