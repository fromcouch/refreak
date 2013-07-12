<?php if (!empty($message)) : ?>
<div class="error_box"><?php echo $message;?></div>
<?php endif; ?>
<table cellspacing="1" cellpadding="2" border="0" width="100%" class="sheet">
        <thead>            
            <tr align="left">
                    <?php 
                        echo project_helper::table_project_head_fields($this->lang->line('projectstable_project'), 
                                                                       $this->lang->line('projectstable_position'), 
                                                                       $this->lang->line('projectstable_members'), 
                                                                       $this->lang->line('projectstable_status'), 
                                                                       $this->lang->line('projectstable_tasks'), 
                                                                       $this->lang->line('projectstable_new'), 
                                                                       $this->ion_auth->in_group(array(1,2)), 
                                                                       site_url() . 'projects/create/', 
                                                                       base_url() . $theme,
                                                                       $this->lang->line('projectstable_action'));
                    ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (count($projects)>0) :         
                echo project_helper::table_project_body_fields($projects, 
                                                               $this->lang->line('project_position'), 
                                                               $this->lang->line('project_status'), 
                                                               site_url() . 'projects/edit/', 
                                                               base_url() . $theme, 
                                                               site_url() . 'projects/delete/', 
                                                               $this->ion_auth->in_group(array(1,2)), 
                                                               $this->ion_auth->is_admin(), 
                                                               $this->lang->line('projectstable_confirmdelete'));
            
                
            else : ?>
                <tr>
                    <td colspan="6" align="center">
                        <p></p>
                        <p><?php echo $this->lang->line('projectstable_nofound'); ?></p>
                        <p></p>
                    </td>
                </tr>
            <?php endif;?>
        </tbody>
</table>        