<?php

/**
 * detect database configuration
 * detect dev/production
 * detect connection to database
 * 
 * install!!!
 */
include 'Install.php';
print_r(new Install);
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
    <p align="center"><img src="../skins/redfreak/images/freak-logo.png" border="0" alt="TaskFreak!" /></p>
    <p align="center">
        <a href="?action=1">Check install</a> |
        <a href="?action=2">README!</a> |
        <a href="?action=5">Rights FAQ</a> |
        <a href="?action=3">Change history</a> |
        <a href="?action=4">Import data</a> |
        <a href="http://forum.taskfreak.com/" target="_blank">Support</a>
    </p>
</body>
<?php


?>
