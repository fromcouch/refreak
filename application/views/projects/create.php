
<div class="center">
    <div class="horiz">
        <?php
              echo validation_errors(); 
              echo form_open("projects/create");
              echo form_fieldset($this->lang->line('projectscrud_info'));?>
              <p><?php echo $this->lang->line('projectscrud_compulsory'); ?></p>
              <p>
                    <label class="compulsory"><?php echo $this->lang->line('projectscrud_name'); ?></label>
                    <?php echo form_input($name);?>
              </p>

              <p>
                    <label><?php echo $this->lang->line('projectscrud_description'); ?></label>
                    <?php echo form_textarea($description);?>
              </p>

              <p>
                    <label><?php echo $this->lang->line('projectscrud_status'); ?></label>
                    <?php echo form_dropdown('status', $status);?>
              </p>
              
              <p><?php echo form_submit('submit', $this->lang->line('projectscrud_create'));?></p>
              <?php echo form_fieldset_close(); 
              
              echo form_close();?>
    </div>
</div>