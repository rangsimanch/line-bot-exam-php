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
 $conn = pg_connect($dbhost, $dbuser, $dbpass,$db);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
    pg_close($conn);
 }
   

?>
