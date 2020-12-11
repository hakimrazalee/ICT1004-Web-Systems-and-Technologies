<?php
function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "sqldev";
 $dbpass = "abc123";
 $db = "Floured";
// $dbhost = "localhost";
// $dbuser = "root";
// $dbpass = "123";
// $db = "floured";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>