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
+ Pluginize project
    + ~~Pluginize Controlers and models~~
    + Decorators for views
    + Pluginize JS
+ Printing Version

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


EVENTS
======
+ Base Controller
    + base_pre_init:            first event fired before init base Refreak system. (always)
    + base_set_theme:           set theme directory. (always)
    + base_user_loaded:         loaded actual user. (always)
    + base_create_left_menu:    create array with left menu items. (always)
    + base_create_right_menu:   create array with right menu items. (always)
    + base_set_js_vars:         Set base javascript variables and messages. (always)
    + base_post_init:           last event fired after init base Refreak system. (always)

+ Projects 
    + projects_pre_init:                    first event fired before init project Refreak controller. (projects)
    + projects_post_init:                   last event fired after init project Refreak controller. (projects)
    + projects_list:                        Get list of projects. (projects)
    + projects_create_validation_form:      Validate data form for create project. (in revision, needs form_validation parameter by ref?) (project)
    + projects_create_pre_prepare_data:     Create project form, event previous setting data for form. (project)
    + projects_create_post_prepare_data:    Create project form, event post setting data for form. (project)
    + projects_edit_validation_form:        Validate data form for edit project. (in revision, needs form_validation parameter by ref?) (project)
    + projects_edit_get_project:            Get project by id. (project)
    + projects_edit_get_project_users:      Get users from project. (project)
    + projects_edit_saved:                  Just after update project. (Move from controller to model??) (project)
    + projects_edit_pre_prepare_data:       Edit project form, event previous setting data for form. (project)
    + projects_edit_post_prepare_data:      Edit project form, event post setting data for form. (project)
    + projects_edit_deleted:                After delete project. (project)
    + projects_ajax_added_user_project:     After user added to project. (project)
    + projects_ajax_remove_user_project:    After user is removed from project. (project)
    + projects_ajax_change_user_position:   After user is changed their position in project. (project)
    + projects_model_init:                  Initializing model. (project)
    + projects_model_projects_list:         Selecting projects list. (project)
    + projects_model_insert_data:           Inserting project. (project)
    + projects_model_insert_status_data:    Inserting status project. (project)
    + projects_model_update_data:           Updating projects. (project)
    + projects_model_get_project:           Get Project. (project)
    + projects_model_get_users_project:     Get Users of Project. (project)
    + projects_model_get_user_project_position:     Get Users position of Project. (project)
    + projects_model_set_user_project:      Set User of Project. (project)
    + projects_model_remove_user_project:   Remove User of Project. (project)
    + projects_model_update_user_position:  Change User Position in Project. (project)
    + projects_view_list_head_table:        Project list table head columns. (project) 
    + projects_view_list_content_table_column: Fires every project row with columns (project)
    + projects_view_list_content_table_row: Project list rows for table (project)
    + projects_view_create_project_form:    Create project form view (project)
    + projects_view_edit_project_info:      Fires after construct upper part for project edit (project)
    + projects_view_edit_add_user_to_project: Show add user tot project selectors (project)
    + projects_view_edit_user_columns:      Fires every project row with columns (project)
    + projects_view_edit_user_rows:         Assigned users to project (project)
    + projects_view_edit_select_user:       All user table for project (project)
    + projects_view_edit_project_user:      Before render all edit screen (project)

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
