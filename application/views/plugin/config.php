
<div class="center">
    <div class="horiz">
<?php
        echo validation_errors(); 
        
        echo form_open();
        echo form_fieldset($plg->name);
        
		include $form;
        
?>
<p>
        <?php echo form_submit('submit', $this->lang->line('pluginsform_submit')); ?>
</p>      
<?php
        echo form_fieldset_close();
        echo form_close();
?>
    </div>
</div>