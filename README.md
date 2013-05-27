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
    + Pluginize Controlers and models
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
    + projects_model_update_user_position:  Change User Posintion in Project. (project)
