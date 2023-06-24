<?php
// rename to connection.php


// Apache settings
header("Content-type: text/html; charset=utf-8");
ini_set('mbstring.internal_encoding', 'utf-8');

if ($_SERVER['SERVER_NAME'] == 'localhost') {
   // development server
   $devServer = true;
   error_reporting(E_ALL);
   $link = mysql_connect("localhost", "local_user", "local_pwd") or die('<p><b>The website is temporarily offline. Please try again shortly.</b></p><!-- Error: ' . mysql_error() . ' -->');
   mysql_select_db("local_db_name", $link);
   mysql_query("SET NAMES 'utf8'", $link);
}
else {
   // live server
   $devServer = false;
   error_reporting(0);
   $link = mysql_connect("remote.host.com", "remote_user", "remote_pwd") or die('<p><b>The website is temporarily offline. Please try again shortly.</b></p><!-- Error: ' . mysql_error() . ' -->');
   mysql_select_db("remote_db_name", $link);
   mysql_query("SET NAMES 'utf8'", $link);
}

function db_query($sql) {
   return mysql_query($sql);
}

function db_fetch_array($sql) {
   return mysql_fetch_array($sql);
}

function db_disconnect() {
   mysql_close();
}
?>
