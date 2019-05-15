
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
  
  $Query = "SELECT
  CAST(\"public\".pos_session.stop_at AS DATE),
  \"public\".pos_config.\"name\",
  Sum(ceiling((\"public\".pos_order_line.qty * \"public\".pos_order_line.price_unit) - floor(\"public\".pos_order_line.qty * \"public\".pos_order_line.price_unit * (\"public\".pos_order_line.discount / 100::numeric)))) AS grantotalsum,
  CASE WHEN \"public\".pos_config.\"name\" LIKE '%วัดบูรพ์%' OR 
                      \"public\".pos_config.\"name\" LIKE '%เดอะมอล%' OR
                      \"public\".pos_config.\"name\" LIKE '%เซฟวัน%' OR
                      \"public\".pos_config.\"name\" LIKE '%มหาราช%' OR
                      \"public\".pos_config.\"name\" LIKE '%ราชสีมา%' OR
                      \"public\".pos_config.\"name\" LIKE '%คลัง%' OR
                      \"public\".pos_config.\"name\" LIKE '%มทส%' OR
                      \"public\".pos_config.\"name\" LIKE '%จอม%' OR
                      \"public\".pos_config.\"name\" LIKE '%เซ็น%' 
              THEN 'NMA'
              
              WHEN \"public\".pos_config.\"name\" LIKE '%ขอนแก่น%'
              THEN 'KKN'
              
              WHEN \"public\".pos_config.\"name\" LIKE '%บุรี%'
              THEN 'BRM'
              
              WHEN \"public\".pos_config.\"name\" LIKE '%อุดร%'
              THEN 'UDN'
              
              WHEN \"public\".pos_config.\"name\" LIKE '%MSIG%' OR
              \"public\".pos_config.\"name\" LIKE '%XT%' OR
              \"public\".pos_config.\"name\" LIKE '%Siam%' OR
              \"public\".pos_config.\"name\" LIKE '%East%'
              THEN 'BKK'
              
           ELSE 'null' END AS name_province
  FROM
  \"public\".pos_session
  INNER JOIN \"public\".pos_order ON \"public\".pos_order.session_id = \"public\".pos_session.\"id\"
  INNER JOIN \"public\".pos_order_line ON \"public\".pos_order_line.order_id = \"public\".pos_order.\"id\"
  INNER JOIN \"public\".pos_config ON \"public\".pos_session.config_id = \"public\".pos_config.\"id\"
  WHERE
  CAST(\"public\".pos_session.stop_at AS DATE) >= '2019-01-01'::date
  GROUP BY
  \"public\".pos_session."id",
  CAST(\"public\".pos_session.stop_at AS DATE),
  \"public\".pos_config."name"
  ORDER BY
  CAST(\"public\".pos_session.stop_at AS DATE) ASC
  ";

  $result = pg_query($conn, $Query);
  if (!$result) {
    echo "An error Query.\n";
    exit;
  }
  
  while ($row = pg_fetch_row($result)) {
    echo "Date: $row[0]  Branch: $row[1] Total: $row[2] Province: $row[3]";
    echo "<br />\n";
  }

?>
