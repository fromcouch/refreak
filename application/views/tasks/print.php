<h1 class="printheader">Tasks</h1>

<?php 
	if (count($tasks)>0) :
			echo task_helper::table_print($tasks,
							$this->lang->line('task_list_project'), 
							$this->lang->line('task_edit_priority'), 
							$this->lang->line('task_list_user'), 
							$this->lang->line('task_list_deadline'), 
							$this->lang->line('task_list_status'), 
							$this->lang->line('task_status')
);
                    
	endif;
?>