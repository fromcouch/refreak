<div class="center">
    <div class="horiz">
        <?php if (!empty($message)) : ?>
        <div id="infoMessage" class="error_box"><?php echo $message;?></div>
        <?php endif; 
        
            echo validation_errors(); 
            echo form_open("users/create_user");
            echo form_fieldset($this->lang->line('userscrud_personalinfo'));?>
            <p>
                    <?php echo $this->lang->line('userscrud_compulsory'); ?>
            </p>
            <p>
                    <label><?php echo $this->lang->line('userscrud_title'); ?> </label>
                    <?php echo form_input($title, '', 'class ="shortest"');?>
                    <small><?php echo $this->lang->line('userscrud_titleexample'); ?></small>
            </p>            
            <p>
                    <label class="compulsory"><?php echo $this->lang->line('userscrud_firstname'); ?></label>
                    <?php echo form_input($first_name);?>
            </p>

            <p>
                    <label class="compulsory"><?php echo $this->lang->line('userscrud_lastname'); ?></label>
                    <?php echo form_input($last_name);?>
            </p>

            <p>
                    <label><?php echo $this->lang->line('userscrud_company'); ?></label>
                    <?php echo form_input($company);?>
            </p>

            <p>
                    <label class="compulsory"><?php echo $this->lang->line('userscrud_email'); ?></label>
                    <?php echo form_input($email);?>
            </p>     
             <p>
                    <label><?php echo $this->lang->line('userscrud_city'); ?></label>
                    <?php echo form_input($city);?>
            </p>     
            
            <p>
                    <label><?php echo $this->lang->line('userscrud_country'); ?></label>
                    <?php echo form_dropdown($country['name'], $country['data'], $country['value']); ?>
            </p>     


            <?php echo form_fieldset_close(); 
                    echo form_fieldset($this->lang->line('userscrud_account'));?>
            <p>
                    <label class="password compulsory"><?php echo $this->lang->line('userscrud_username'); ?></label>
                    <?php echo form_input($username);?>
            </p>
            
            <p>
                    <label class="password compulsory"><?php echo $this->lang->line('userscrud_password'); ?></label>
                    <?php echo form_input($password);?>
            </p>

            <p>
                    <label class="password compulsory"><?php echo $this->lang->line('userscrud_confirmpass'); ?></label>
                    <?php echo form_input($password_confirm);?>
            </p>

            <p>
                    <?php echo form_checkbox($active_user); ?>
                    <span><?php echo $this->lang->line('userscrud_enabled'); ?></span>
                    <?php echo form_dropdown('group', $groups, null, 'class="group" style="display:none"');?>
            </p>

            <?php echo form_fieldset_close(); ?>
            <p><?php echo form_submit('submit', $this->lang->line('userscrud_createuser'));?></p>

        <?php echo form_close();?>
    </div>
</div>
<script type="text/javascript">

    $(".active_user").on("click", function() {
       
            $(".group").toggle();
       
    });
    
</script>