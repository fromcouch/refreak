<?php

// Projects
$sql_truncate_projects = "TRUNCATE TABLE {$db_new}.`{$pre_new}projects`";
$sql_insert_projects = "
    INSERT INTO {$db_new}.`{$pre_new}projects` (`project_id`, `name`, `description`) VALUES
    SELECT projectId, name, description FROM {$db_old}.`{$pre_old}projects`
;";

// Users
$sql_truncate_users = "TRUNCATE TABLE {$db_new}.`{$pre_new}users`";
$sql_insert_users = "
    INSERT INTO {$db_new}.`{$pre_new}users` (`id`, `username`, `password`, `salt`, `email`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `phone`, title, `country_id`, `author_id`) VALUES
    SELECT memberId, username, password, salt, email, creationDate, lastLoginDate, enabled, firstName, lastName, phone, title, countryId, authorId, city FROM {$db_old}.`{$pre_old}members
;";

// Users Groups
$sql_truncate_users_groups = "TRUNCATE TABLE {$db_new}.`{$pre_new}users_groups`";
$sql_insert_users_groups = "    
        INSERT INTO {$db_new}.`{$pre_new}users_groups` (`user_id`, `group_id`) VALUES
        SELECT memberId, CASE level 
                            WHEN 1 THEN 4
                            WHEN 2 THEN 3
                            WHEN 3 THEN 2
                            WHEN 4 THEN 1 
                         END FROM {$db_old}.`{$pre_old}members
;";
               
// Project Status
$sql_truncate_project_status = "TRUNCATE TABLE {$db_new}.`{$pre_new}project_status`";
$sql_insert_project_status = "
    INSERT INTO {$db_new}.`{$pre_new}project_status` (`project_status_id`, `project_id`, `status_date`, `status_id`, `user_id`) VALUES
    SELECT projectStatusId, projectId, statusDate, statusKey, memberId FROM {$db_old}.{$pre_old}projectstatus
;";
    
// User Project
$sql_truncate_user_project = "TRUNCATE TABLE {$db_new}.`{$pre_new}user_project`";
$sql_insert_user_project = "    
        INSERT INTO `{$pre}user_project` (`user_id`, `project_id`, `position`) VALUES
        SELECT memberId, projectId, position FROM {$db_old}.`{$pre_old}memberproject`
;";

$sql_truncate_tasks = "TRUNCATE TABLE {$db_new}.`{$pre_new}tasks`";
$sql_insert_tasks = "
        INSERT INTO {$db_new}.`{$pre_new}tasks` (`task_id`, `project_id`, `task_parent_id`, `priority`, `context`, `title`, `description`, `deadline_date`, `expected_duration`, `private`, `user_id`,`author_id`) VALUES 
        SELECT itemId, projectId, itemParentId, priority, context, title, description, deadlineDate, expectedDuration, showPrivate, memberId, authorId FROM {$db_old}.`{$pre_old}item`
;";