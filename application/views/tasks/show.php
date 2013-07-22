<?php 
        
        echo task_helper::show_buttons($this->lang->line('task_show_close'), 
                                             $this->lang->line('task_show_edit'), 
                                             $this->lang->line('task_show_delete'), 
                                             $tf['position'],
                                             base_url() . $theme,
                                             $this->ion_auth->in_group(array(1,2))); 

        echo task_helper::show_task_info($tf, 
                                         $this->lang->line('task_show_priority'), 
                                         $this->lang->line('task_show_deadline'), 
                                         $this->lang->line('task_show_context'), 
                                         $context_letter, 
                                         $context, 
                                         $this->lang->line('task_show_project'), 
                                         $project_name, 
                                         $this->lang->line('task_show_title'), 
                                         $this->lang->line('task_show_user'), 
                                         $username, 
                                         $this->lang->line('task_show_visibility'), 
                                         $visibility, 
                                         base_url() . $theme);
        
        echo task_helper::show_tabs($this->lang->line('task_show_tab_description'), 
                                    $this->lang->line('task_show_tab_comment'), 
                                    $this->lang->line('task_show_tab_history'), 
                                    $this->lang->line('task_show_tab_save'), 
                                    $this->lang->line('task_show_tab_cancel'), 
                                    $tf['description']);
        
        $st = $tf['status'];
        if (empty($st)) $st = 0; //i have problems passing zero values to views :/
        
        echo task_helper::show_status($this->lang->line('task_show_status'), 
                                      $status[$st]);
