<?php

$version = '2.1';
$versionYear = '2023';

if ($_SERVER['SERVER_NAME'] == 'stgallpriscian') {
   $testing = true;
   ini_set('display_errors', '1');
   error_reporting(E_ALL);
}
else {
   $testing = false;
   ini_set('display_errors', '0');
   error_reporting(0);
}

// Apache settings

include ("connection.php");
include ("utils.php");
include ("custom.php");
include ("template.php");

?>