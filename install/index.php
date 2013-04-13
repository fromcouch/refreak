<?php

/**
 * detect database configuration
 * detect dev/production
 * detect connection to database
 * 
 * install!!!
 */
include 'Install.php';
$inst = new Install();

$span_ok = '<span class="ok">OK</span>';
$span_fail = '<span class="error">FAIL!</span>';
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
            <li>Check Refreak Config File
                <?php 
                if ($inst->check_refreak_file()) :
                    echo $span_ok;
                else :
                    echo $span_fail;
                endif;
                ?>
            </li>
            
            <li>Check Layout Config File
                <?php 
                if ($inst->check_layout_file()) :
                    echo $span_ok;
                else :
                    echo $span_fail;
                    $install = false;
                endif;
                ?>
            </li>
            
            <li>Check Application Config File
                <?php 
                if ($inst->check_config_file()) :
                    echo $span_ok;
                else :
                    echo $span_fail;
                    $install = false;
                endif;
                ?>
            </li>
            
            <li>Check Database Config File
                <?php 
                if ($inst->check_database_file()) :
                    echo $span_ok;
                else :
                    echo $span_fail;
                    $install = false;
                endif;
                ?>
            </li>
        </ul>
        <?php
            //check continue
        ?>
        <p>Check configuration</p>
        <ul>
            <li>Check Refreak Config File
                <?php 
                if ($inst->check_refreak_file()) :
                    echo $span_ok;
                else :
                    echo $span_fail;
                endif;
                ?>
            </li>
            
            <li>Check Layout Config File
                <?php 
                if ($inst->check_layout_file()) :
                    echo $span_ok;
                else :
                    echo $span_fail;
                    $install = false;
                endif;
                ?>
            </li>
            
            <li>Check Application Config File
                <?php 
                if ($inst->check_config_file()) :
                    echo $span_ok;
                else :
                    echo $span_fail;
                    $install = false;
                endif;
                ?>
            </li>
        </ul>
        
    </div>
</body>
<?php


?>
