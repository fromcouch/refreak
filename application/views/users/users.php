<?php if (!empty($message)) : ?>
<div class="error_box"><?php echo $message;?></div>
<?php endif; ?>
<table cellspacing="1" cellpadding="2" border="0" width="100%" class="sheet">
        <thead>            
            <tr align="left">
                <?php 
                    echo user_helper::table_user_head_fields($this->lang->line('userstable_user'), 
                                                             $this->lang->line('userstable_level'), 
                                                             $this->lang->line('userstable_lastlogin'), 
                                                             $this->ion_auth->is_admin(), 
                                                             site_url() . '/users/create_user/', 
                                                             base_url() . $theme, 
                                                             $this->lang->line('userstable_new'),
                                                             $this->lang->line('userstable_action'));
                ?>                
            </tr>
        </thead>
        <tbody>
            <?php
                echo user_helper::table_user_body_fields($users, 
                                                         $this->ion_auth->is_admin(), 
                                                         base_url() . $theme, 
                                                         site_url() . '/users/details/', 
                                                         site_url() . 'users/delete_user/', 
                                                         site_url() . 'users/edit_user/', 
                                                         $actual_user->id, 
                                                         $this->lang->line('userstable_confirmdelete'));
            ?>            
        </tbody>
</table>        