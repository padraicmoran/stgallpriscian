<?php
// rename to connection.php

// Apache settings
header("Content-type: text/html; charset=utf-8");
ini_set('mbstring.internal_encoding', 'utf-8');

if ($_SERVER['SERVER_NAME'] == 'localhost') {
   // development server
   $link = mysqli_connect($link, "localhost", "local_user", "local_pwd");
   mysqli_select_db($link, "local_db_name");
}
else {
   // live server
   $link = mysqli_connect($link, "remote.host.com", "remote_user", "remote_pwd");
   mysqli_select_db($link, "remote_db_name");
}
mysqli_query($link, "SET NAMES 'utf8'");

?>