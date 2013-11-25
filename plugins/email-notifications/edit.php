
<fieldset>
	<legend>Creating Task</legend>
	<p>
		<?php 
			echo form_label('Activated');
			echo form_checkbox('creating_task_activated');
		?>
	</p>
	<h3>User Groups that receive mail</h3>
	<div>
		<?php echo render_groups($groups,'creating_task_group_'); ?>
	</div>
	<br/>
	<h3>Who recieve mail</h3>
	<div>
		<div class="chk_box">
		<?php 
			echo form_label('Task creator');
			echo form_checkbox('creating_task_creator');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Assigned user');
			echo form_checkbox('creating_task_assigned');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Project Members');
			echo form_checkbox('creating_task_project_members');
		?>
		</div>
	</div>
	<br/>
	<h3>Mail</h3>
	<div> 
		<p>
                    <label>Subject</label>
                    <?php echo form_input('creating_task_email_subject'); ?>
		</p>
		<p>
                    <label>Body</label>
                    <?php echo form_textarea('creating_task_email_body_subject'); ?>
		</p>
	</div>
</fieldset>

<fieldset>
	<legend>Editing Task</legend>
	<p>
		<?php 
			echo form_label('Activated');
			echo form_checkbox('editing_task_activated');
		?>
	</p>
	<h3>User Groups that receive mail</h3>
	<div>
		<?php echo render_groups($groups,'editing_task_group_'); ?>
	</div>
	<br/>
	<h3>Who recieve mail</h3>
	<div>
		<div class="chk_box">
		<?php 
			echo form_label('Task Editor');
			echo form_checkbox('editing_task_editor');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Assigned user');
			echo form_checkbox('editing_task_assigned');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Project Members');
			echo form_checkbox('editing_task_project_members');
		?>
		</div>
	</div>
	<br/>
	<h3>Mail</h3>
	<div> 
		<p>
                    <label>Subject</label>
                    <?php echo form_input('editing_task_email_subject'); ?>
		</p>
		<p>
                    <label>Body</label>
                    <?php echo form_textarea('editing_task_email_body_subject'); ?>
		</p>
	</div>
</fieldset>
<fieldset>
	<legend>Comments</legend>
	<p>
		<?php 
			echo form_label('Activated');
			echo form_checkbox('commenting_activated');
		?>
	</p>
	<h3>Comment Actions</h3>
	<div>
		<div class="chk_box">
		<?php 
			echo form_label('New Comment');
			echo form_checkbox('commenting_new');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Edit Comment');
			echo form_checkbox('commenting_edit');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Delete Comment');
			echo form_checkbox('commenting_delete');
		?>
		</div>
	</div>
	<br/>
	<h3>Who recieve mail</h3>
	<div>
		<div class="chk_box">
		<?php 
			echo form_label('Comment Creator');
			echo form_checkbox('commenting_creator');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Assigned User');
			echo form_checkbox('commenting_assigned');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Project Members');
			echo form_checkbox('commenting_project_members');
		?>
		</div>
	</div>
	<br/>
	<h3>Mail</h3>
	<div> 
		<p>
                    <label>Subject</label>
                    <?php echo form_input('commenting_email_subject'); ?>
		</p>
		<p>
                    <label>Body</label>
                    <?php echo form_textarea('commenting_email_body_subject'); ?>
		</p>
	</div>
</fieldset>
<fieldset>
	<legend>Project User</legend>
	<p>
		<?php 
			echo form_label('Activated');
			echo form_checkbox('project_user_activated');
		?>
	</p>
	<h3>Project User Actions</h3>
	<div>
		<div class="chk_box">
		<?php 
			echo form_label('Assing User');
			echo form_checkbox('project_user_new');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Remove User');
			echo form_checkbox('project_user_edit');
		?>
		</div>
	</div>
	<br/>
	<h3>Who recieve mail</h3>
	<div>
		<div class="chk_box">
		<?php 
			echo form_label('Assigned User');
			echo form_checkbox('project_user_assigned');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Project Members');
			echo form_checkbox('project_user_project_members');
		?>
		</div>
	</div>
	<br/>
	<h3>Mail</h3>
	<div> 
		<p>
                    <label>Subject</label>
                    <?php echo form_input('project_user_email_subject'); ?>
		</p>
		<p>
                    <label>Body</label>
                    <?php echo form_textarea('project_user_email_body'); ?>
		</p>
	</div>
</fieldset>
<fieldset>
	<legend>User</legend>
	<p>
		<?php 
			echo form_label('Activated');
			echo form_checkbox('user_activated');
		?>
	</p>
	<h3>User Actions</h3>
	<div>
		<div class="chk_box">
		<?php 
			echo form_label('New User');
			echo form_checkbox('user_new');
		?>
		</div>
		<div class="chk_box">
		<?php 
			echo form_label('Delete User');
			echo form_checkbox('user_delete');
		?>
		</div>
	</div>
	<br/>
	<h3>Who recieve mail</h3>
	<div>
		<div class="chk_box">
		<?php 
			echo form_label('User Affected');
			echo form_checkbox('user_assigned');
		?>
		</div>
	</div>
	<br/>
	<h3>Mail</h3>
	<div> 
		<p>
                    <label>Subject</label>
                    <?php echo form_input('user_email_subject'); ?>
		</p>
		<p>
                    <label>Body</label>
                    <?php echo form_textarea('user_email_body'); ?>
		</p>
	</div>
</fieldset>

<?php 
function render_groups($groups, $prefix) {
	$ret = '';
	foreach ($groups as $value) {
		$ret .= '<div class="chk_box">';
                $ret .= form_label($value['description']);
		$ret .= form_checkbox($prefix . $value['name'], $value['id'], FALSE);
		$ret .= '</div>';
	}
	
	return $ret;
} 
?>