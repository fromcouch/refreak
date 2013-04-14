<?php

/**
 * detect database configuration
 * detect dev/production
 * detect connection to database
 * 
 * install!!!
 */
include 'Install.php';
include 'InstallDecorator.php';
$inst = new Install();

$install = true;
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
#preview {
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
        <a href="?action=2">README!</a> |
        <a href="https://github.com/fromcouch/refreak/issues/" target="_blank">Support</a>
    </p>
    <div id="preview">
        
        <p>Check configuration files</p>
        <ul>
            <?php
                echo InstallDecorator::show_li_element('Check Refreak Config File', $inst->check_refreak_file());
                echo InstallDecorator::show_li_element('Check Layout Config File', $inst->check_layout_file());
                echo InstallDecorator::show_li_element('Check Application Config File', $inst->check_config_file());
                echo InstallDecorator::show_li_element('Check Database Config File', $inst->check_database_file());
            ?>
        </ul>        
    </div>
</body>
<?php


?>
