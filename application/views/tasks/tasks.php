<div class="task_panel">
    <img border="0" src="<?php echo base_url() . $theme;?>/images/load.gif" class="loader">    
</div>
    <table cellpadding="2" cellspacing="1" border="0" class="sheet task_sheet" width="100%">
            <thead>
                <tr>
                    
                    <?php echo task_helper::table_task_head_fields($this->lang->line('task_list_project'), 
                                                                   $this->lang->line('task_list_title'), 
                                                                   $this->lang->line('task_list_user'), 
                                                                   $this->lang->line('task_list_deadline'), 
                                                                   $this->lang->line('task_list_comments'), 
                                                                   $this->lang->line('task_list_status'), 
                                                                   $this->lang->line('task_list_new'), 
                                                                   $this->ion_auth->in_group(array(1,2)),
                                                                   base_url() . $theme,
                                                                   $max_status); ?>
                    
                </tr>
            </thead>
            <tbody class="taskSheetData">
                <?php 
                    if (count($tasks)>0) :
                        
                        echo task_helper::table_task_body_fields($this->lang->line('task_context'), 
                                                                 $tasks, 
                                                                 base_url() . $theme, 
                                                                 $this->ion_auth->in_group(array(1,2)),
                                                                 $actual_user->id,
                                                                 $max_status);
                        
                        
                    else : 
                    
                        echo task_helper::table_no_task($this->lang->line('task_list_no_task'), 
                                                        base_url() . $theme, 
                                                        $this->ion_auth->in_group(array(1,2)), 
                                                        $this->lang->line('task_list_new'));
                    
                    endif; ?>
            </tbody>
    </table>
<script type="text/javascript">

    (function($) {
        
            $(".task_sheet").listTask();
        
        
    })(jQuery);

</script>