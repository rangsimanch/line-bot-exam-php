<?php

$conn_string = "host=96.30.79.11 port=5432 dbname=LIV user=odoo password=odoo";

function OpenCon()
 {

 $conn = pg_connect($conn_string) or die 'Connect Failed';
 
 return $conn;
 }
 
function CloseCon($conn)
 {
    pg_close($conn);
 }
   

?>