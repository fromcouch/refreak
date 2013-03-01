<div class="center">
    <div class="horiz">
        <div id="infoMessage"><?php echo $message;?></div>
        <?php echo form_open("users/edit_user");
            echo form_fieldset($this->lang->line('userscrud_personalinfo'));?>
            <p>
                    <label><?php echo $this->lang->line('userscrud_firstname'); ?> </label>
                    <?php echo form_input($first_name);?>
            </p>

            <p>
                    <label><?php echo $this->lang->line('userscrud_lastname'); ?> </label>
                    <?php echo form_input($last_name);?>
            </p>

            <p>
                    <label><?php echo $this->lang->line('userscrud_company'); ?> </label>
                    <?php echo form_input($company);?>
            </p>

            <p>
                    <label><?php echo $this->lang->line('userscrud_email'); ?></label>
                    <?php echo form_input($email);?>
            </p>     

            <?php echo form_fieldset_close(); 
                    echo form_fieldset($this->lang->line('userscrud_account'));?>
            <p>
                    <label class="password"><?php echo $this->lang->line('userscrud_passwordchanging'); ?> </label>
                    <?php echo form_input($password);?>
            </p>

            <p>
                    <label class="password"><?php echo $this->lang->line('userscrud_confirmpasschanging'); ?> </label>
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