
<div class="center">
    <div class="horiz">
        <?php
              echo validation_errors(); 
              echo form_open("projects/create");
              
              echo project_helper::create_project($this->lang->line('projectscrud_info'), 
                                                  $this->lang->line('projectscrud_compulsory'), 
                                                  $this->lang->line('projectscrud_name'), 
                                                  $this->lang->line('projectscrud_description'), 
                                                  $this->lang->line('projectscrud_status'), 
                                                  $this->lang->line('projectscrud_create'), 
                                                  $name, 
                                                  $description, 
                                                  $status);
              
              echo form_close();?>
    </div>
</div>