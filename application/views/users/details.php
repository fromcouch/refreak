<div class="center">
    <div class="horiz">
        <?php 
            echo form_open();
            
            echo user_helper::detail_user_personal_info($user, 
                                                        $groups, 
                                                        $user_groups[0]->id,
                                                        $author,
                                                        base_url() . $theme, 
                                                        site_url() . 'users/edit_user/', 
                                                        $this->ion_auth->is_admin(), 
                                                        $actual_user->id, 
                                                        $this->lang->line('usersdetails_personalinfo'), 
                                                        $this->lang->line('usersdetails_createdon'), 
                                                        $this->lang->line('usersdetails_createdonby'), 
                                                        $this->lang->line('usersdetails_name'),
                                                        $this->lang->line('usersdetails_level'),
                                                        $this->lang->line('usersdetails_disabled'));
            
             echo user_helper::detail_user_projects($user_projects, 
                                                    $this->lang->line('project_position'), 
                                                    $this->lang->line('usersdetails_listproject'), 
                                                    $this->lang->line('usersdetails_projects'), 
                                                    $this->lang->line('usersdetails_listposition'), 
                                                    site_url() . 'projects/edit/');
                                            
            echo form_close(); 
            ?>
        
    </div>
</div>