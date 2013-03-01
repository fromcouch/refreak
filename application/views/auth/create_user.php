<div class="center">
    <div class="horiz">
        <div id="infoMessage"><?php echo $message;?></div>
        <?php echo form_open("users/create_user");
            echo form_fieldset($this->lang->line('userscrud_personalinfo'));?>
            <p>
                    <?php echo $this->lang->line('userscrud_firstname'); ?> <br />
                    <?php echo form_input($first_name);?>
            </p>

            <p>
                    <?php echo $this->lang->line('userscrud_lastname'); ?> <br />
                    <?php echo form_input($last_name);?>
            </p>

            <p>
                    <?php echo $this->lang->line('userscrud_company'); ?> <br />
                    <?php echo form_input($company);?>
            </p>

            <p>
                    <?php echo $this->lang->line('userscrud_email'); ?> <br />
                    <?php echo form_input($email);?>
            </p>     

            <?php echo form_fieldset_close(); 
                    echo form_fieldset($this->lang->line('userscrud_account'));?>
            <p>
                    <?php echo $this->lang->line('userscrud_password'); ?> <br />
                    <?php echo form_input($password);?>
            </p>

            <p>
                    <?php echo $this->lang->line('userscrud_confirmpass'); ?> <br />
                    <?php echo form_input($password_confirm);?>
            </p>

            <p>
                    <?php echo $this->lang->line('userscrud_group'); ?> <br />
                    <?php echo form_dropdown('group', $groups);?>
            </p>

            <?php echo form_fieldset_close(); ?>
            <p><?php echo form_submit('submit', $this->lang->line('userscrud_createuser'));?></p>

        <?php echo form_close();?>
    </div>
</div>