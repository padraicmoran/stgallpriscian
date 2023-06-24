<?php
include ("connection.php");
include ("utils.php");
include ("custom.php");
include ("template.php");

$tablePrefix = '';
$cmsTable = '';
$cmsTableField = '';

// error handling
$errReported = false;
set_error_handler("handleError", E_ALL);
function handleError($errno, $errstr, $filename, $linenum) {
   global $errReported, $devServer;
   if (! $errReported) {
      print '<div class="error">A technical error has occurred on this page. This has been logged and will be investigated.</div>';
      $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
      $ip = $_SERVER['REMOTE_ADDR'];
      $err = "URL: $url 
Error no: $errno
Error str: $errstr
Filename: $filename
Line: $linenum
IP address: $ip 
   ";
      $errReported = true;
      
      // temporarily disabled
      if ($devServer) print '<div class="error">' . str_replace("\r", '<br/>', $err) . '</div>';
      else {
//         mail("padraic@pmoran.net", "Error on EIGP", $err, 'From: pm394@cam.ac.uk'); // mail function not available on server
         mysql_query("Insert Into errors (url, errno, errstr, filename, linenum, ip) Values ('$url', $errno, '$errstr', '$filename', $linenum, '$ip')");
      }
   }
}

$cmsTable = $tablePrefix . 'cmstable';
$cmsTableField = $tablePrefix . 'cmstablefield';

?>