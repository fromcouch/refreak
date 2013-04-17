<?php
use \Michelf\Markdown;
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * detect database configuration
 * detect dev/production
 * detect connection to database
 * 
 * install!!!
 */
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
    <p align="center"><img src="../skins/redfreak/images/freak-logo.png" border="0" alt="Refreak" /></p>
    <p align="center">
        <a href="#">Check install</a> |
        <a href="?act=2">README!</a> |
        <a href="https://github.com/fromcouch/refreak/issues/" target="_blank">Support</a>
    </p>
    <div class="preview">
        
        <?php 
                
        switch ($act) {
            case 1:
                // install tables here
            
            case 2: 
                $text = file_get_contents('../README.md');
                $html = Markdown::defaultTransform($text);
                echo $html;
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
            <?php   
                break;
        } ?>     
        
    </div>
<script type="text/javascript">
    (function () {
        var ib = document.querySelector(".install_button");
        ib.addEventListener("click", function() {
            window.location.href="?act=1";
        }, false);
    })();
</script>    
</body>
</html>