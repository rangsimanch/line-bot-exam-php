
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

  $result = pg_query($dbconn4,"SELECT * FROM "public".pos_config");
  if (!$result) {
    echo "An error Query.\n";
    exit;
  }

  while ($row = pg_fetch_row($result)) {
    echo "Date: $row[0]  Branch: $row[1] Total: $row[2] Province: $row[3]";
    echo "<br />\n";
  }

?>
