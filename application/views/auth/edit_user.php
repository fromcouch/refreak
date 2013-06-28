<div class="center">
    <div class="horiz">
        <?php 
        
            echo validation_errors(); 
            echo form_open();
            
            echo user_helper::edit_user_personal_info($this->lang->line('userscrud_compulsory'), 
                                                      $this->lang->line('userscrud_title'), 
                                                      $title, 
                                                      $this->lang->line('userscrud_titleexample'), 
                                                      $this->lang->line('userscrud_firstname'), 
                                                      $first_name, 
                                                      $this->lang->line('userscrud_lastname'), 
                                                      $last_name, 
                                                      $this->lang->line('userscrud_company'), 
                                                      $company, 
                                                      $this->lang->line('userscrud_email'), 
                                                      $email, 
                                                      $this->lang->line('userscrud_city'), 
                                                      $city, 
                                                      $this->lang->line('userscrud_country'), 
                                                      $country, 
                                                      $this->lang->line('userscrud_personalinfo'));
            
            echo user_helper::edit_user_account($this->lang->line('userscrud_username'), 
                                                $username, 
                                                $this->lang->line('userscrud_passwordchanging'), 
                                                $password, 
                                                $this->lang->line('userscrud_confirmpasschanging'), 
                                                $password_confirm, 
                                                $this->ion_auth->is_admin(), 
                                                $active_user, 
                                                $this->lang->line('userscrud_enabled'), 
                                                $groups, 
                                                $user->id, 
                                                $groups_show, 
                                                $this->lang->line('userscrud_account')); 
            ?>
            
            <p><?php echo form_submit('submit', $this->lang->line('userscrud_saveuser'));?></p>

        <?php echo form_close();?>
    </div>
</div>
<script type="text/javascript">

    $(".active_user").on("click", function() {
       
            $(".group").toggle();
       
    });
    
</script>