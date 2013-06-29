<div class="center">
    <div class="horiz">
        <?php if (!empty($message)) : ?>
        <div id="infoMessage" class="error_box"><?php echo $message;?></div>
        <?php endif; 
        
            echo validation_errors(); 
            echo form_open("users/create_user");
            
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
            
            $groups_show = $active_user ? 'style = "display:none"' : '';
            
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
                                                0, 
                                                $groups_show, 
                                                $this->lang->line('userscrud_account')); 
            
           ?>
        
            <p><?php echo form_submit('submit', $this->lang->line('userscrud_createuser'));?></p>

        <?php echo form_close();?>
    </div>
</div>
<script type="text/javascript">

    $(".active_user").on("click", function() {
       
            $(".group").toggle();
       
    });
    
</script>