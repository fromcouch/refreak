refreak
=======

taskfreak fork

Hi, I'm using Taskfreak from two or three years ago. I made many changes to the original code but is a poor Hell modify this code and finally I decide to make my own Taskfreak.

Actually I'm in development stage.


What is Refreak?
----------------

Refreak is a simple but efficient web based task manager written in PHP and Code Igniter.
Originally created in September 2005 and maintained by Stan Ozier and Tirzen with their Tirzen Framework.


###Features

 - easy to use task manager
 - order tasks by deadline, project, etc ..
 - user management for tasks and system
 - easy project management
 - import from Taskfreak! when install.

###Future Features
 - Plugin Ready


TODO
----

### Stage 2
+ ~~Import on Install tasks from TF~~
+ ~~Pluginize project~~
    + ~~Pluginize Controlers and models~~
    + ~~Decorators for views~~
    + ~~Pluginize JS~~
    + ~~Plugin Installer~~
    + ~~Plugin Configuration~~
+ Printing Version
+ Own dialog and alerts messages

### Stage 3
+ GTD Plugin
+ Subtasks plugin
+ E-Mail Notification Plugin
+ File Attachment Plugin
+ Google Docs Plugin
+ Time Tracking Plugin


Please, feel free to add issue or comment.

INSTALL
=======
Parameters for database configuration are in:

    application/config/database.php

You only need configure hostname, username, password and database parameters inside database.php. Save it and 
then access to www.yourdomain.com/install and click Install button.

Also need to modify config variable $config['base_url'] value with your new url in:

    application/config/config.php

Additionaly you can configure some parameters in:

    application/config/refreak.php


PLUGINS
=======
You can easy create plugin. I have this part of project in a very beginning stage, but actually anyone can write a plugin.
A little example can be found in:

    application/plugin/example

Then, go to menu config/Plugin and install.

You can attach the next events. (The parentesis word references the refreak section that plugin fires, every plugin needs to be limited to one section or always section )

EVENTS
------
+ Base Controller
    + base_pre_init:            first event fired before init base Refreak system. (always)
    + base_set_theme:           set theme directory. (always)
    + base_user_loaded:         loaded actual user. (always)
    + base_create_left_menu:    create array with left menu items. (always)
    + base_create_right_menu:   create array with right menu items. (always)
    + base_set_js_vars:         Set base javascript variables and messages. (always)
    + base_post_init:           last event fired after init base Refreak system. (always)
    + layout_view_header:       Render header part. (always)

+ Projects 
    + projects_pre_init:                    first event fired before init project Refreak controller. (projects)
    + projects_post_init:                   last event fired after init project Refreak controller. (projects)
    + projects_list:                        Get list of projects. (projects)
    + projects_create_validation_form:      Validate data form for create project. (in revision, needs form_validation parameter by ref?) (projects)
    + projects_create_pre_prepare_data:     Create project form, event previous setting data for form. (projects)
    + projects_create_post_prepare_data:    Create project form, event post setting data for form. (projects)
    + projects_edit_validation_form:        Validate data form for edit project. (in revision, needs form_validation parameter by ref?) (projects)
    + projects_edit_get_project:            Get project by id. (projects)
    + projects_edit_get_project_users:      Get users from project. (projects)
    + projects_edit_saved:                  Just after update project. (Move from controller to model??) (projects)
    + projects_edit_pre_prepare_data:       Edit project form, event previous setting data for form. (projects)
    + projects_edit_post_prepare_data:      Edit project form, event post setting data for form. (projects)
    + projects_edit_deleted:                After delete project. (projects)
    + projects_ajax_added_user_project:     After user added to project. (projects)
    + projects_ajax_remove_user_project:    After user is removed from project. (projects)
    + projects_ajax_change_user_position:   After user is changed their position in project. (projects)
    + projects_model_init:                  Initializing model. (projects)
    + projects_model_projects_list:         Selecting projects list. (projects)
    + projects_model_insert_data:           Inserting project. (projects)
    + projects_model_insert_status_data:    Inserting status project. (projects)
    + projects_model_update_data:           Updating projects. (projects)
    + projects_model_get_project:           Get Project. (projects)
    + projects_model_get_users_project:     Get Users of Project. (projects)
    + projects_model_get_user_project_position:     Get Users position of Project. (projects)
    + projects_model_set_user_project:      Set User of Project. (projects)
    + projects_model_remove_user_project:   Remove User of Project. (projects)
    + projects_model_update_user_position:  Change User Position in Project. (projects)
    + projects_view_list_head_table:        Project list table head columns. (projects) 
    + projects_view_list_content_table_column: Fires every project row with columns (projects)
    + projects_view_list_content_table_row: Project list rows for table (projects)
    + projects_view_create_project_form:    Create project form view (projects)
    + projects_view_edit_project_info:      Fires after construct upper part for project edit (projects)
    + projects_view_edit_add_user_to_project: Show add user tot project selectors (projects)
    + projects_view_edit_user_columns:      Fires every project row with columns (projects)
    + projects_view_edit_user_rows:         Assigned users to project (projects)
    + projects_view_edit_select_user:       All user table for project (projects)
    + projects_view_edit_project_user:      Before render all edit screen (projects)


+ Tasks
    + tasks_pre_init:                       first event fired before init task Refreak controller. (tasks)
    + tasks_post_init:                      lost event fired after init task Refreak controller. (tasks)
    + tasks_list:                           Get list of tasks. (tasks)
    + tasks_search_result_list:             Get list of tasks after search. (need to send parameters?) (tasks)
    + tasks_list_from_project:              Get list of tasks from project.  (tasks)
    + tasks_list_from_user:                 Get list of tasks from user.  (tasks)
    + tasks_show_edit_task:                 When load task for edit popup.  (tasks)
    + tasks_save_task_validation:           Validation form on save task.  (tasks)
    + tasks_save_task_data:                 Fires before save data.  (tasks)
    + tasks_save_task_saved:                Fires after save task.  (tasks)
    + tasks_list_projects_from_user:        Gets projects of especified user.  (tasks)
    + tasks_show_task:                      Popup show task layer.  (tasks)
    + tasks_change_status:                  Fires when user change status.  (tasks)
    + tasks_model_init:                     Init model. (tasks)
    + tasks_model_get_tasks:                Get task list.  (tasks)
    + tasks_model_get_users:                Get Users.  (tasks)
    + tasks_model_get_project_users:        Get users from project.  (tasks)
    + tasks_model_insert_task:              Insert task.  (tasks)
    + tasks_model_update_task:              Update task.  (tasks)
    + tasks_model_get_task:                 Get a single task.  (tasks)
    + tasks_model_get_task_description:     Get task description.  (tasks)
    + tasks_model_get_task_comment:         Get task comments.  (tasks)
    + tasks_model_get_task_history:         Get task history.  (tasks)
    + tasks_model_insert_comment_data:      Insert comment.  (tasks)
    + tasks_model_update_comment_data:      Update comment.  (tasks)
    + tasks_model_delete_comment:           Delete comment.  (tasks)
    + tasks_model_set_status:               Change task status.  (tasks)
    + tasks_model_close_task:               Close task.  (tasks)
    + tasks_model_delete_task:              Delete task.  (tasks)
    + tasks_model_delete_task_status:       Delete task Status.  (tasks)
    + tasks_model_delete_task_comments:     Delete task Comments.  (tasks)
    + tasks_model_get_user_project_position:Get Users position of Task. (tasks)
    + tasks_model_is_owner:                 Know if user is owner of task. (tasks)
    + tasks_view_list_head_table:           Tasks list table head columns. (tasks)
    + tasks_view_list_content_table_column: Fires every task row with columns (tasks)
    + tasks_view_list_content_table_row:    Tasks list rows for table (tasks)
    + tasks_view_table_no_tasks:            No task table part (tasks)
    + tasks_view_show_task_buttons:         Close, edit, delete task buttons (tasks)
    + tasks_view_show_task_info:            Show task info part (tasks)
    + tasks_view_show_task_tabs:            Show task tabs part (tasks)
    + tasks_view_show_task_status:          Show task status part (tasks)
    + tasks_view_edit_task_pr_dead:         Edit task, first line with priority and deadline date (tasks)
    + tasks_view_edit_task_project:         Edit task, project selector (tasks)
    + tasks_view_edit_title_description:    Edit task, title description (tasks)
    + tasks_view_edit_user_status:          Edit task, user status (tasks)


+ Users
    + users_pre_init:                       first event fired before init users Refreak controller. (users)
    + users_post_init:                      lost event fired after init users Refreak controller. (users)
    + users_list:                           Get list of Users. (users)
    + users_create_validation_form:         Validate data form for create users. (in revision, needs form_validation parameter by ref?) (users)
    + users_pre_register:                   Before Register User. (users)
    + users_registered:                     After Register User. (users)
    + users_create_post_prepare_data:       Create user form, event previous setting data for form. (users)
    + users_edit_validation_form:           Validate data form for edit users. (in revision, needs form_validation parameter by ref?) (users)
    + users_edit_update:                    Validate user data for update users. (users)
    + users_edit_group_updated:             Group changed. (users)
    + users_edit_updated:                   User Updated. (users)
    + users_edit_post_prepare_data:         Edit user form, event previous setting data for form. (users)
    + users_details_post_prepare_data:      Details/Show user form, event previous setting data for form. (users)
    + users_edit_deleted:                   User deleted. (users)
    + users_edit_activated:                 User activated. (users)
    + users_edit_deactivated:               User deactivated. (users)
    + users_model_init:                     Init model. (users)
    + users_model_projects_user:            Get projects of user. (users)
    + users_model_users_with_group:         Get users with group. (users)
    + users_model_country:                  Get countries. (users)
    + users_view_list_head_table:           Users list table head columns. (users)
    + users_view_list_content_table_column: Fires every user row with columns (users)
    + users_view_list_content_table_row:    User list rows for table (users)
    + users_view_detail_user_info:          User detail page user info part (users)
    + users_view_detail_user_projects:      User detail page user projects part (users)
    + users_view_edit_user_info:            Edit user personal info (users)
    + users_view_edit_user_account:         Edit user account (users)
    

+ Auth
    + auth_logged_in:                       When users logged (auth)
    + auth_login_error:                     When error login (auth)
    + auth_logged_out:                      Logged out user (auth)
    + auth_password_changed:                Password Changed (auth)
    + auth_password_forgot:                 Password Forgot (auth)
    + auth_user_activated:                  User Activated (auth)
    + auth_user_deactivated:                User Deactivated (auth)

+ Javascript General events
    + Boxes: 
	* refreak.boxes.init:		    Fires when message box initialize
	+ refreak.boxes.show:		    When message box shows message
	+ refreak.boxes.destroy:	    When message box hides.

    + Tasks:
	+ refreak.task_new.init:	    Initialize new task window
	+ refreak.task_new.render:	    Render new task window, fired after ajax call.
	+ refreak.task_new.bind:	    When buttons and other events binded after show window
	+ refreak.task_new.load_users:	    Load users to populate select box.
	+ refreak.task_new.render_input_project: Shows input box for new project
	+ refreak.task_new.render_list_project: Shows select box for projects
	+ refreak.task_new.pre_send_data:   Before send data to server with new task.
	+ refreak.task_new.send_data_done:  After send data to server.
	+ refreak.task_new.close:	    Window close and object destroy.
	+ refreak.task_show.init:	    Initialize show window
	+ refreak.task_show.render:	    Render show window
	+ refreak.task_show.bind:	    Bind other events.
	+ refreak.task_show.to_edit:	    Jump to edit.
	+ refreak.task_show.pre_delete:	    Pre delete task
	+ refreak.task_show.deleted:	    Task deleted
	+ refreak.task_show.show_description: Show tab description 
	+ refreak.task_show.show_comments:  Show comments tab
	+ refreak.task_show.show_history:   Show comments history
	+ refreak.task_show.get_description: After ajax call for get task description
	+ refreak.task_show.get_comments:   After ajax call for get task comments
	+ refreak.task_show.get_history:    After ajax call for get task history
	+ refreak.task_show.edit_comment:   When edit comment
	+ refreak.task_show.pre_delete_comment: Before delete comment
	+ refreak.task_show.deleted_comment: Comment Deleted
	+ refreak.task_show.send_comment:   Send comment
	+ refreak.task_show.close:	    Close and destroy show task window.
	+ refreak.task_list.init:	    Initializing task list
	+ refreak.task_list.showtask:	    Click on show task trigger
	+ refreak.task_list.edittask:	    Edit task button
	+ refreak.task_list.pre_delete:	    Pre deleting task
	+ refreak.task_list.deleted:	    Deleted Task
	+ refreak.task_list.status_changing: Change status
	+ refreak.task_list.status_changed: Status Changed
	+ refreak.task_list.close:	    Closing object

    + Projects:
	+ refreak.project_edit.invite_user: Inviting user to project in edit page
	+ refreak.project_edit.nouser:	    No user was selected.
	+ refreak.project_edit.user_invited:	User was invited
	+ refreak.project_edit.user_added:  User added to table in edit project page
	+ refreak.project_edit_member.init: Edit member in project initializing
	+ refreak.project_edit_member.edit: Pre-edit member
	+ refreak.project_edit_member.edited: Member edited
	+ refreak.project_edit_member.delete:	Delete member from project
	+ refreak.project_edit_member.deleted:	Member deleted
	+ refreak.project_edit_member.change_position:	Change position in project
	+ refreak.project_edit_member.changed_position:	Changed position in project