<?php
;
// Projects
$sql_create_projects            = "CREATE TABLE {$db_new}.`bak_{$pre_new}projects` LIKE {$db_new}.`{$pre_new}projects`;";
$sql_create_insert_projects     = "INSERT INTO {$db_new}.`bak_{$pre_new}projects` SELECT * FROM {$db_new}.`{$pre_new}projects`;";
$sql_truncate_projects          = "TRUNCATE TABLE {$db_new}.`{$pre_new}projects`";
$sql_insert_projects            = "
    INSERT INTO {$db_new}.`{$pre_new}projects` (`project_id`, `name`, `description`) 
    SELECT projectId, name, description FROM {$db_old}.`{$pre_old}project`
;";

// Users
$sql_create_users               = "CREATE TABLE {$db_new}.`bak_{$pre_new}users` LIKE {$db_new}.`{$pre_new}users`;";
$sql_create_insert_users        = "INSERT INTO {$db_new}.`bak_{$pre_new}users` SELECT * FROM {$db_new}.`{$pre_new}users`;";
$sql_truncate_users             = "TRUNCATE TABLE {$db_new}.`{$pre_new}users`";
$sql_insert_users               = "
    INSERT INTO {$db_new}.`{$pre_new}users` (`id`, `username`, `password`, `salt`, `email`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `phone`, title, `country_id`, `author_id`, `city`)
    SELECT memberId, username, '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', salt, email, creationDate, lastLoginDate, enabled, firstName, lastName, phone, title, countryId, authorId, city FROM {$db_old}.`{$pre_old}member
;";

// Users Groups
$sql_create_users_groups        = "CREATE TABLE {$db_new}.`bak_{$pre_new}users_groups` LIKE {$db_new}.`{$pre_new}users_groups`;";
$sql_create_insert_users_groups = "INSERT INTO {$db_new}.`bak_{$pre_new}users_groups` SELECT * FROM {$db_new}.`{$pre_new}users_groups`;";
$sql_truncate_users_groups      = "TRUNCATE TABLE {$db_new}.`{$pre_new}users_groups`";
$sql_insert_users_groups        = "    
        INSERT INTO {$db_new}.`{$pre_new}users_groups` (`user_id`, `group_id`)
        SELECT memberId, CASE level 
                            WHEN 1 THEN 4
                            WHEN 2 THEN 3
                            WHEN 3 THEN 2
                            WHEN 4 THEN 1 
                         END FROM {$db_old}.`{$pre_old}member
;";
               
// Project Status
$sql_create_project_status      = "CREATE TABLE {$db_new}.`bak_{$pre_new}project_status` LIKE {$db_new}.`{$pre_new}project_status`;";
$sql_create_insert_project_status = "INSERT INTO {$db_new}.`bak_{$pre_new}project_status` SELECT * FROM {$db_new}.`{$pre_new}project_status`;";                         
$sql_truncate_project_status    = "TRUNCATE TABLE {$db_new}.`{$pre_new}project_status`";
$sql_insert_project_status      = "
    INSERT INTO {$db_new}.`{$pre_new}project_status` (`project_status_id`, `project_id`, `status_date`, `status_id`, `user_id`)
    SELECT projectStatusId, projectId, statusDate, CASE WHEN statusKey >0 THEN (statusKey /10) +1 ELSE 1 END, memberId FROM {$db_old}.{$pre_old}projectstatus
;";
    
// User Project
$sql_create_user_project        = "CREATE TABLE {$db_new}.`bak_{$pre_new}user_project` LIKE {$db_new}.`{$pre_new}user_project`;";
$sql_create_insert_user_project = "INSERT INTO {$db_new}.`bak_{$pre_new}user_project` SELECT * FROM {$db_new}.`{$pre_new}user_project`;";
$sql_truncate_user_project      = "TRUNCATE TABLE {$db_new}.`{$pre_new}user_project`";
$sql_insert_user_project        = "    
        INSERT INTO {$db_new}.`{$pre_new}user_project` (`user_id`, `project_id`, `position`)
        SELECT memberId, projectId, position FROM {$db_old}.`{$pre_old}memberproject`
;";

$sql_create_tasks               = "CREATE TABLE {$db_new}.`bak_{$pre_new}tasks` LIKE {$db_new}.`{$pre_new}tasks`;";
$sql_create_insert_tasks        = "INSERT INTO {$db_new}.`bak_{$pre_new}tasks` SELECT * FROM {$db_new}.`{$pre_new}tasks`;";
$sql_truncate_tasks             = "TRUNCATE TABLE {$db_new}.`{$pre_new}tasks`";
$sql_insert_tasks               = "
        INSERT INTO {$db_new}.`{$pre_new}tasks` (`task_id`, `project_id`, `task_parent_id`, `priority`, `context`, `title`, `description`, `deadline_date`, `expected_duration`, `private`, `user_id`,`author_id`) 
        SELECT itemId, projectId, itemParentId, priority, context, title, description, deadlineDate, expectedDuration, showPrivate, memberId, authorId FROM {$db_old}.`{$pre_old}item`
;";
        
$sql_create_tasks_status        = "CREATE TABLE {$db_new}.`bak_{$pre_new}task_status` LIKE {$db_new}.`{$pre_new}task_status`;";
$sql_create_insert_tasks_status = "INSERT INTO {$db_new}.`bak_{$pre_new}task_status` SELECT * FROM {$db_new}.`{$pre_new}task_status`;";
$sql_truncate_tasks_status      = "TRUNCATE TABLE {$db_new}.`{$pre_new}task_status`";
$sql_insert_tasks_status        = "
        INSERT INTO {$db_new}.`{$pre_new}task_status` (`task_status_id`, `task_id`, `status_date`, `status`, `user_id`) 
        SELECT itemStatusId, itemId, statusDate, statusKey, memberId FROM {$db_old}.`{$pre_old}itemstatus`
;";

$sql_create_tasks_comment       = "CREATE TABLE {$db_new}.`bak_{$pre_new}task_comment` LIKE {$db_new}.`{$pre_new}task_comment`;";
$sql_create_insert_tasks_comment = "INSERT INTO {$db_new}.`bak_{$pre_new}task_comment` SELECT * FROM {$db_new}.`{$pre_new}task_comment`;";
$sql_truncate_tasks_comment     = "TRUNCATE TABLE {$db_new}.`{$pre_new}task_comment`";
$sql_insert_tasks_comment       = "
        INSERT INTO {$db_new}.`{$pre_new}task_comment` (task_comment_id, task_id, user_id, post_date, comment, last_change_date) 
        SELECT `itemCommentId`, `itemId`, `memberId`, `postDate`, `body`, `lastChangeDate` FROM {$db_old}.`{$pre_old}itemcomment`
;";