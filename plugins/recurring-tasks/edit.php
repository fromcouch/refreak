<fieldset>
	<legend><?php echo $this->lang->line('recurring_general_title'); ?></legend>
	<h3><?php echo $this->lang->line('recurring_general_config'); ?></h3>
	<div> 
		<p>
                    <label><?php echo $this->lang->line('recurring_general_many'); ?></label>
                    <?php echo form_input('recurring_many_numbers', $config->recurring_many_numbers); ?>
		</p>		
	</div>
</fieldset>