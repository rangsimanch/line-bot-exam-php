
<?php
$dbconn = pg_connect("dbname=LIV");
//connect to a database named "mary"

$dbconn2 = pg_connect("host=96.30.79.11 port=5432 dbname=LIV");
// connect to a database named "mary" on "localhost" at port "5432"

$dbconn3 = pg_connect("host=96.30.79.11 port=5432 dbname=LIV user=odoo password=odoo");
//connect to a database named "mary" on the host "sheep" with a username and password

$conn_string = "host=96.30.79.11 port=5432 dbname=LIV user=odoo password=odoo";
$dbconn4 = pg_connect($conn_string);
//connect to a database named "test" on the host "sheep" with a username and password

$dbconn5 = pg_connect("host=96.30.79.11 options='--client_encoding=UTF8'");
//connect to a database on "localhost" and set the command line parameter which tells the encoding is in UTF-8


if (!$dbconn4) {
    echo "An error occurred.\n";
    exit;
  }
  
  $result = pg_query($conn, "SELECT author, email FROM authors");
  if (!$result) {
    echo "An error Query.\n";
    exit;
  }
  
  while ($row = pg_fetch_row($result)) {
    echo "Author: $row[0]  E-mail: $row[1]";
    echo "<br />\n";
  }

?>
