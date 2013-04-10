<div class="center">
    <div class="horiz">
        <div id="infoMessage"><?php echo $message;?></div>
        <?php echo form_open();
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
                    <label class="compulsory"><?php echo $this->lang->line('userscrud_firstname'); ?> </label>
                    <?php echo form_input($first_name);?>
            </p>

            <p>
                    <label class="compulsory"><?php echo $this->lang->line('userscrud_lastname'); ?> </label>
                    <?php echo form_input($last_name);?>
            </p>

            <p>
                    <label><?php echo $this->lang->line('userscrud_company'); ?> </label>
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
                    <label class="password compulsory"><?php echo $this->lang->line('userscrud_passwordchanging'); ?> </label>
                    <?php echo form_input($password);?>
            </p>

            <p>
                    <label class="password compulsory"><?php echo $this->lang->line('userscrud_confirmpasschanging'); ?> </label>
                    <?php echo form_input($password_confirm);?>
            </p>

            <?php if ($this->ion_auth->is_admin()) : ?>


            <p>
                    <label class="password"><?php echo $this->lang->line('userscrud_group'); ?> </label>
                    <?php echo form_dropdown('group', $groups, $user->id);?>
            </p>

            <?php 
                    endif;
                    echo form_fieldset_close(); 
                    echo form_hidden('id', $user->id);?>

            <p><?php echo form_submit('submit', $this->lang->line('userscrud_saveuser'));?></p>

        <?php echo form_close();?>
    </div>
</div>