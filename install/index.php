<?php
use \Michelf\Markdown;

//error_reporting(0);

include 'Install.php';
include 'InstallDecorator.php';
include 'Markdown.php';

$inst = new Install();

$act = 0;
if (isset($_GET['act'])) $act = $_GET['act'];
?>
<!doctype html>
<html lang="en">
<head>
	<title>Refreak Setup</title>
<style>
div, p, li, td {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: small;
}
th {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: small;
    text-align: center;
}
big {
    font-weight: bold;
    font-size: x-large;
}
td input {
    width: 120px;
}
.preview {
    position: relative;
    left: 50%;
    width: 700px;
    margin-left: -350px;
    border: 2px solid #ccc;
    padding: 5px;
    background-color: #f3f3f3;
}
pre {
    font-family: monospace;
    font-size: normal;
}
.ok {
    font-weight: bold;
    color: #393;
}
.warning {
	color: #f90;
}
.error {
    font-weight: bold;
    color: #c00;
}
</style>
</head>
<body>
    <p align="center"><img src="../theme/default/images/freak-logo.png" border="0" alt="Refreak" /></p>
    <p align="center">
        <a href="index.php">Check install</a> |
        <a href="?act=2">README!</a> |
        <a href="?act=3">Import from Taskfreak!</a> |
        <a href="https://github.com/fromcouch/refreak/issues/" target="_blank">Support</a>
    </p>
    <div class="preview">
        
        <?php 
                
        switch ($act) {
            case 1: 
                $inst->check_database_parameters();
                $inst->check_connection();
                include_once 'sql.init.php'; ?>
        
                <p>Creating Tables</p>
                <ul>
                    <?php
                        echo InstallDecorator::show_li_element('Creating Country Table', $inst->install_table($sql_create_country));
                        echo InstallDecorator::show_li_element('Creating Groups Table', $inst->install_table($sql_create_groups));
                        echo InstallDecorator::show_li_element('Creating Login Attempts Table', $inst->install_table($sql_create_login_attempts));
                        echo InstallDecorator::show_li_element('Creating Projects Table', $inst->install_table($sql_create_projects));
                        echo InstallDecorator::show_li_element('Creating Users Table', $inst->install_table($sql_create_users));
                        echo InstallDecorator::show_li_element('Creating User Project Table', $inst->install_table($sql_create_user_project));
                        echo InstallDecorator::show_li_element('Creating Users Groups Table', $inst->install_table($sql_create_users_groups));
                        echo InstallDecorator::show_li_element('Creating Project Status Table', $inst->install_table($sql_create_project_status));
                        echo InstallDecorator::show_li_element('Creating Tasks Table', $inst->install_table($sql_create_tasks));
                        echo InstallDecorator::show_li_element('Creating Tasks Comments Table', $inst->install_table($sql_create_tasks_comment));
                        echo InstallDecorator::show_li_element('Creating Tasks Status Table', $inst->install_table($sql_create_tasks_status));
                        echo InstallDecorator::show_li_element('Creating Plugins Table', $inst->install_table($sql_create_plugins));
                        echo InstallDecorator::show_li_element('Creating Controllers Table', $inst->install_table($sql_create_controllers));
                        echo InstallDecorator::show_li_element('Creating Plugins Controllers Table', $inst->install_table($sql_create_plugins_controllers));
                    ?>
                </ul>
                <p>Importing Basic Data</p>
                <ul>
                    <?php
                        echo InstallDecorator::show_li_element('Import Country Data', $inst->install_table($sql_insert_country));
                        echo InstallDecorator::show_li_element('Import Groups Data', $inst->install_table($sql_insert_groups));                        
                        echo InstallDecorator::show_li_element('Import Projects Data', $inst->install_table($sql_insert_projects));                        
                        echo InstallDecorator::show_li_element('Import Users Data', $inst->install_table($sql_insert_users));
                        echo InstallDecorator::show_li_element('Import Tasks Data', $inst->install_table($sql_insert_tasks));
                        echo InstallDecorator::show_li_element('Import Tasks Status Data', $inst->install_table($sql_insert_tasks_status));
                        echo InstallDecorator::show_li_element('Import Users Project Data', $inst->install_table($sql_insert_user_project));
                        echo InstallDecorator::show_li_element('Import Users Groups Data', $inst->install_table($sql_insert_users_groups));
                        echo InstallDecorator::show_li_element('Import Project Status Data', $inst->install_table($sql_insert_project_status));                        
                        echo InstallDecorator::show_li_element('Import Controllers Data', $inst->install_table($sql_insert_controllers));                        
                    ?>
                </ul>
                <p align="center">
                    Remember, user are administrator with word password as password.<br>
                    <a href="../">Go to Refreak</a>
                </p>
            <?php
                break;
            
            case 2: 
                $text = file_get_contents('../README.md');
                $html = Markdown::defaultTransform($text);
                echo $html;
                break;
            
            case 3: ?>
                You can Import from Taskfreak! doing one of this two options:
                <ul>
                    <li>Install Refreak in same Taskfreak! database and click <i>Import from TF</i> button.<br/></li>
                    <li>Adding Taskfreak database configuration in <b>application/config/database.php</b>. 
                        Uncomment TF database configuration and fill empty config and click <i>Import from TF</i> button.</li>
                </ul>
                <p>&nbsp;</p>
                <ul>
                    <?php
                        echo InstallDecorator::show_li_element('Check Taskfreak! Tables in same database', $inst->check_tf_exists_tables());
                        echo InstallDecorator::show_li_element('Check Taskfreak! Database parameters', $inst->check_tf_exists_config());
                        echo InstallDecorator::show_li_element('Check Taskfreak! Connection', $inst->check_tf_exists_connection());
                    ?>
                </ul>
                <?php if ($inst->check_tf_exists_tables() && $inst->check_tf_exists_connection()) : ?>
                <ul>
                    <li>Detected existing tables in same database and Taskfreak! database. Existing tables will be used.</li>
                </ul>
                <?php endif; ?>
                
                <p>Import DELETE actual tables data!</p>
                <input type="button" value="Import" name="import_button" class="import_button" />
                <script type="text/javascript">
                        (function () {
                            var im = document.querySelector(".import_button");

                            im.addEventListener("click", function() {
                                window.location.href="?act=4";
                            }, false);
                        })();
                    </script>    
            <?php 
                break;
                
            case 4:
                $inst->check_database_parameters();
                $inst->check_connection();
                
                $db_new     = $inst->rfk_db['database'];
                $pre_new    = $inst->rfk_db['dbprefix'];
                
                $db_old     = $inst->frk_db['database'];
                $pre_old    = $inst->frk_db['dbprefix'];
                
                include_once 'sql.import.php'; ?>
        
                <p>Importing Data</p>
                <ul>
                    <?php
                        echo InstallDecorator::show_li_element('Import Projects Data', $inst->install_table($sql_create_projects) && 
                                                                                       $inst->install_table($sql_create_insert_projects) && 
                                                                                       $inst->install_table($sql_truncate_projects) &&                                                                                        
                                                                                       $inst->install_table($sql_insert_projects));
                        
                        echo InstallDecorator::show_li_element('Import Users Data', $inst->install_table($sql_create_users) && 
                                                                                    $inst->install_table($sql_create_insert_users) && 
                                                                                    $inst->install_table($sql_truncate_users) && 
                                                                                    $inst->install_table($sql_insert_users));
                        print_r($inst->mys->error);
                        echo InstallDecorator::show_li_element('Import Users Groups Data', $inst->install_table($sql_create_users_groups) && 
                                                                                           $inst->install_table($sql_create_insert_users_groups) && 
                                                                                           $inst->install_table($sql_truncate_users_groups) && 
                                                                                           $inst->install_table($sql_insert_users_groups));
                        print_r($inst->mys->error);
                        echo InstallDecorator::show_li_element('Import Project Status Data', $inst->install_table($sql_create_project_status) && 
                                                                                             $inst->install_table($sql_create_insert_project_status) && 
                                                                                             $inst->install_table($sql_truncate_project_status) && 
                                                                                             $inst->install_table($sql_insert_project_status)); 
                        
                        echo InstallDecorator::show_li_element('Import Users Project Data', $inst->install_table($sql_create_user_project) && 
                                                                                            $inst->install_table($sql_create_insert_user_project) && 
                                                                                            $inst->install_table($sql_truncate_user_project) && 
                                                                                            $inst->install_table($sql_insert_user_project));
                        
                        echo InstallDecorator::show_li_element('Import Tasks Data', $inst->install_table($sql_create_tasks) && 
                                                                                    $inst->install_table($sql_create_insert_tasks) && 
                                                                                    $inst->install_table($sql_truncate_tasks) && 
                                                                                    $inst->install_table($sql_insert_tasks));
                        
                        echo InstallDecorator::show_li_element('Import Tasks Status Data', $inst->install_table($sql_create_tasks_status) && 
                                                                                           $inst->install_table($sql_create_insert_tasks_status) && 
                                                                                           $inst->install_table($sql_truncate_tasks_status) && 
                                                                                           $inst->install_table($sql_insert_tasks_status));
                        
                        echo InstallDecorator::show_li_element('Import Tasks Comment Data', $inst->install_table($sql_create_tasks_comment) && 
                                                                                            $inst->install_table($sql_create_insert_tasks_comment) && 
                                                                                            $inst->install_table($sql_truncate_tasks_comment) && 
                                                                                            $inst->install_table($sql_insert_tasks_comment));
                    ?>
                </ul>
                <p align="center">
                    Remember, all users resets their password to password word.<br>
                    <a href="../">Go to Refreak</a>
                </p>
                
                
            <?php 
                break;
            case 0:
            default: ?>
                <p>Check configuration files</p>
                <ul>
                    <?php
                        echo InstallDecorator::show_li_element('Check Refreak Config File', $inst->check_refreak_file());
                        echo InstallDecorator::show_li_element('Check Layout Config File', $inst->check_layout_file());
                        echo InstallDecorator::show_li_element('Check Application Config File', $inst->check_config_file());
                        echo InstallDecorator::show_li_element('Check Database Config File', $inst->check_database_file());
                    ?>
                </ul>   

                <?php if ($inst->can_be_installed) : ?>
                    <p>Check database parameters</p>
                    <ul>
                        <?php
                            echo InstallDecorator::show_li_element('Check Config Parameters', $inst->check_config_parameters());
                            echo InstallDecorator::show_li_element('Check Database Parameters', $inst->check_database_parameters());
                        ?>
                    </ul>
                    <?php if ($inst->can_be_installed) : ?>
                        <p>Check database connection</p>
                        <ul>
                            <?php
                                echo InstallDecorator::show_connection_state('Check Connection', $inst->check_connection(), $inst->connection_error);
                            ?>
                        </ul>
                        <?php if ($inst->can_be_installed) : ?>                    
                            <input type="button" value="Install" name="install_button" class="install_button" />
                        <?php else : ?>
                            <p class="error">Can not continue without connecting to database</p>
                        <?php endif; ?>
                    <?php else : ?>
                        <p class="error">Can not continue tests without access to config or database parameters</p>
                    <?php endif; ?>
                <?php else : ?>
                    <p class="error">Can not continue tests without access to config or database file</p>
                <?php endif; ?>    
                    
                    <script type="text/javascript">
                        (function () {
                            var ib = document.querySelector(".install_button");

                            ib.addEventListener("click", function() {
                                window.location.href="?act=1";
                            }, false);
                        })();
                    </script>    
            <?php   
                break;
        } ?>     
        
    </div>
</body>
</html>