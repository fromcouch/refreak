<div class="center">
    <div class="horiz">
        <?php 
            $edit_button = '';
            if ($actual_user->id == $user->id || $this->ion_auth->is_admin()) : 
                $edit_button = '<a href="' . site_url() . 'users/edit_user/' . $user->id . '"><img src="' . base_url() . $theme . '/images/b_edit.png" width="20" height="16" border="0" /></a>';
            endif; 
        
            echo form_open();
            echo form_fieldset($this->lang->line('usersdetails_personalinfo') . ' (' . $user->username . ') ' . $edit_button);?>
        
            <div align="right">
                <small><?php echo $this->lang->line('usersdetails_createdon') . ' ' . 
                                  date('j M y', $user->created_on) . $this->lang->line('usersdetails_createdonby') . 
                                  ' ' . $author; ?></small>
            </div>
        
            <p>
                    <label><?php echo $this->lang->line('usersdetails_name'); ?> </label>
                    <?php echo $user->title . ' ' . $user->first_name . ' ' . $user->last_name;?>
            </p>

            <p>
                    <label><?php echo $this->lang->line('usersdetails_level'); ?></label>
                    <?php
                    
                        if ($user->active) :
                                $reverse_groups = array_reverse($groups, true);                        
                                foreach ($reverse_groups as $gr_id => $gr) :
                                    $class = 'level_pad level_0';
                                    if ($gr_id == $user_groups[0]->id)
                                        $class = 'level_high level_'.$gr_id;

                                    echo '<span class="' . $class . '">' . $gr . '</span>';

                                endforeach;
                        else:
                        
                                echo $this->lang->line('usersdetails_disabled');
                                                
                        endif;                        
                        
                    ?>
            </p>
            <?php echo form_fieldset_close(); 
                  echo form_fieldset($this->lang->line('usersdetails_projects'));
                  $position = $this->lang->line('project_position');
                  ?>
                    
                    <table class="data" width="100%">
                        <tr>
                            <th width="80%"><?php echo $this->lang->line('usersdetails_listproject'); ?></th>
                            <th><?php echo $this->lang->line('usersdetails_listposition'); ?></th>
                        </tr>
                        <?php foreach ($user_projects as $prj) : ?>
                        <tr>
                            <td>
                                <a href="<?php echo site_url() . 'projects/edit/' . $prj->project_id; ?>">
                                    <?php echo $prj->name; ?>
                                </a>
                            </td>
                            <td><?php echo $position[$prj->position]; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
            <?php                     
                    echo form_fieldset_close(); 
            echo form_close(); 
            ?>
        
    </div>
</div>