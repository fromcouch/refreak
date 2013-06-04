<?php
/***
 * @todo faltan los permisos para mostrat los botones
 */
?>
<div id="infoMessage"><?php echo $message;?></div>
<table cellspacing="1" cellpadding="2" border="0" width="100%" class="sheet">
        <thead>            
            <tr align="left">
                <th width="25%"><?php echo $this->lang->line('userstable_user'); ?></th>                
                <th width="10%"><?php echo $this->lang->line('userstable_level'); ?></th>
                <th width="20%"><?php echo $this->lang->line('userstable_lastlogin'); ?></th>
                <th width="10%" style="text-align:center">
                <?php if ($this->ion_auth->is_admin()) : ?>
                    <a href="<?php echo site_url();?>/users/create_user/">
                        <img src="<?php echo base_url() . $theme;?>/images/new.png" width="39" height="16" border="0" hspace="3" alt="<?php echo $this->lang->line('userstable_new'); ?>" />                        
                    </a>
                <?php else : 
                        echo $this->lang->line('userstable_action'); 
                    endif; ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $table_user) : 
                        $user_status    = $table_user->active ? 'ena' : 'dis';
                        $user_status   .= ($actual_user->id != $table_user->id && $this->ion_auth->is_admin()) ? 'y' : 'n';
                        $url_active     = $table_user->active ? 'deactivate' : 'activate';
                        $tr_class       = $table_user->active ? '' : 'class = "disabled"';
            ?>
            <tr <?php echo $tr_class; ?>>
                <td><a href="<?php echo site_url();?>/users/details/<?php echo $table_user->id;?>"><?php echo $table_user->first_name.' '.$table_user->last_name ?></a></td>
                <td><?php echo $table_user->group_desc; ?></td>
                <td><?php echo date('D d/m/Y G:i', $table_user->last_login); ?></td>
                <td align="center">
                        <?php 
                        if ($actual_user->id != $table_user->id && $this->ion_auth->is_admin()) : ?>
                            <a href="<?php echo site_url();?>users/<?php echo $url_active;?>/<?php echo $table_user->id;?>">
                                <img src="<?php echo base_url() . $theme;?>/images/b_<?php echo $user_status; ?>.png" />
                            </a>
                        <?php else : ?>
                                <img src="<?php echo base_url() . $theme;?>/images/b_<?php echo $user_status; ?>.png" />
                        <?php endif; 
                        
                        if ($actual_user->id == $table_user->id || $this->ion_auth->is_admin()) :                                                    
                        ?>
                            <a href="<?php echo site_url();?>/users/edit_user/<?php echo $table_user->id;?>"><img src="<?php echo base_url() . $theme;?>/images/b_edit.png" width="20" height="16" border="0" /></a>
                        <?php else : ?>
                            <img src="<?php echo base_url() . $theme;?>/images/b_edin.png" width="20" height="16" border="0" />
                        <?php endif; ?>

                        <?php if ($actual_user->id != $table_user->id && $this->ion_auth->is_admin()) : ?>
                            <a href="<?php echo site_url();?>/users/delete_user/<?php echo $table_user->id;?>" onclick="return confirm(<?php echo $this->lang->line('userstable_confirmdelete'); ?>);"><img src="<?php echo base_url() . $theme;?>/images/b_dele.png" width="20" height="16" border="0" /></a>
                        <?php else : ?>
                            <img src="<?php echo base_url() . $theme;?>/images/b_deln.png" width="20" height="16" border="0" />
                        <?php endif; ?>
                            
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>        