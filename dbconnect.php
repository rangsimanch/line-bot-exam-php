<?php

$conn_string = "host=96.30.79.11 port=5432 dbname=LIV user=odoo password=odoo";

//connect to a database named "test" on the host "sheep" with a username and password

$str_output ="";

function OpenCon()
 {
 $dbhost = "96.30.79.11";
 $dbuser = "odoo";
 $dbpass = "odoo";
 $db = "LIV";
 $conn = new pg_connect($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   

?>
