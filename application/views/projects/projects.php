<div class="infoMessage"><?php echo $message;?></div>
<table cellspacing="1" cellpadding="2" border="0" width="100%" class="sheet">
        <thead>            
            <tr align="left">
                    <th width="50%"><?php echo $this->lang->line('projectstable_project'); ?></th>                
                    <th width="12%"><?php echo $this->lang->line('projectstable_position'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('projectstable_members'); ?></th>
                    <th width="12%"><?php echo $this->lang->line('projectstable_status'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('projectstable_tasks'); ?></th>                                                            
                    <th width="10%"  style="text-align:center">
                        <?php if ($this->ion_auth->in_group(array(1,2))) : ?>
                    <a href="<?php echo site_url();?>/projects/create/">
                        <img src="<?php echo base_url();?>theme/default/images/new.png" width="39" height="16" border="0" hspace="3" alt="<?php echo $this->lang->line('projectstable_new'); ?>" />                        
                    </a>
                <?php else : 
                        echo $this->lang->line('projectstable_action'); 
                    endif; ?>
                        
                    </th>              
            </tr>
        </thead>
        <tbody>
            <?php 
            if (count($projects)>0) :                           
                $position = $this->lang->line('project_position');
                $status = $this->lang->line('project_status');
                foreach ($projects as $table_project) : ?>
                <tr>
                    <td><a href="<?php echo site_url();?>/projects/edit/<?php echo $table_project->project_id;?>"><?php echo $table_project->name; ?></a></td>
                    <td><?php echo $position[$table_project->position]; ?></td>
                    <td><?php echo $table_project->users; ?></td>
                    <td><?php echo $status[$table_project->status_id]; ?></td>
                    <td><?php echo $table_project->tasks; ?></td>
                    <td align="center">
                            <?php 
                            if ($this->ion_auth->in_group(array(1,2))) : 
                            ?>
                                <a href="<?php echo site_url();?>/projects/edit/<?php echo $table_project->project_id;?>"><img src="<?php echo base_url();?>theme/default/images/b_edit.png" width="20" height="16" border="0" /></a>
                            <?php else : ?>
                                <img src="<?php echo base_url();?>theme/default/images/b_edin.png" width="20" height="16" border="0" />
                            <?php endif; ?>

                            <?php if (($table_project->position == 5) || ($this->ion_auth->is_admin())) : //falta mirar si el usuario tiene permisos para editar el proyecto ?>
                                <a href="<?php echo site_url();?>/projects/delete/<?php echo $table_project->project_id;?>" onclick="return confirm(<?php echo $this->lang->line('projectstable_confirmdelete'); ?>);"><img src="<?php echo base_url();?>theme/default/images/b_dele.png" width="20" height="16" border="0" /></a>
                            <?php else : ?>
                                <img src="<?php echo base_url();?>theme/default/images/b_deln.png" width="20" height="16" border="0" />
                            <?php endif; ?>                            
                    </td>
                </tr>
                <?php endforeach; 
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