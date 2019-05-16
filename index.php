<?php
   $accessToken = "q9EwAMLiNHd6qdeVCKe2kWJoflo3kxWPRXi7XGhivIg2YLA156SYWM0ULAYf13QkbaoNnMVpuDswiBaNgDr+hCcr0FmBgl9JnDMbYi5pGvR0WF75BXsulz7uSijD4yQ28J57kRUpzDMpR3r3RgOWzgdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า

   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);

   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";

   //รับข้อความจากผู้ใช้
   $message = $arrayJson['events'][0]['message']['text'];

   //รับ id ของผู้ใช้
   $id = $arrayJson['events'][0]['source']['userId'];

   if($message == "ขอยอดขาย"){

          pushMsg($arrayHeader,getDB());
    }

    function getDB()
    {
        $conn_string = "host=96.30.79.11 port=5432 dbname=LIV us)er=odoo password=odoo";
        $conn = pg_connect($conn_string);
        //connect to a database named "test" on the host "sheep" with a username and password

        $to_date = "CURRENT_DATE - INTEGER '1'";
        $str_query = "SELECT CAST(\"public\".pos_session.stop_at AS DATE), \"public\".pos_config.\"name\", Sum(ceiling((\"public\".pos_order_line.qty * \"public\".pos_order_line.price_unit) - floor(\"public\".pos_order_line.qty * \"public\".pos_order_line.price_unit * (\"public\".pos_order_line.discount / 100::numeric)))) AS grantotalsum, CASE WHEN \"public\".pos_config.\"name\" LIKE '%วัดบูรพ์%' OR \"public\".pos_config.\"name\" LIKE '%เดอะมอล%' OR \"public\".pos_config.\"name\" LIKE '%เซฟวัน%' OR \"public\".pos_config.\"name\" LIKE '%มหาราช%' OR \"public\".pos_config.\"name\" LIKE '%ราชสีมา%' OR \"public\".pos_config.\"name\" LIKE '%คลัง%' OR \"public\".pos_config.\"name\" LIKE '%มทส%' OR \"public\".pos_config.\"name\" LIKE '%จอม%' OR \"public\".pos_config.\"name\" LIKE '%เซ็น%' THEN 'NMA' WHEN \"public\".pos_config.\"name\" LIKE '%ขอนแก่น%' THEN 'KKN' WHEN \"public\".pos_config.\"name\" LIKE '%บุรี%' THEN 'BRM' WHEN \"public\".pos_config.\"name\" LIKE '%อุดร%' THEN 'UDN' WHEN \"public\".pos_config.\"name\" LIKE '%MSIG%' OR \"public\".pos_config.\"name\" LIKE '%XT%' OR \"public\".pos_config.\"name\" LIKE '%Siam%' OR \"public\".pos_config.\"name\" LIKE '%Kasetsart%' OR \"public\".pos_config.\"name\" LIKE '%Pracha%' OR \"public\".pos_config.\"name\" LIKE '%East%' THEN 'BKK' ELSE 'null' END AS name_province FROM \"public\".pos_session INNER JOIN \"public\".pos_order ON \"public\".pos_order.session_id = \"public\".pos_session.\"id\" INNER JOIN \"public\".pos_order_line ON \"public\".pos_order_line.order_id = \"public\".pos_order.\"id\" INNER JOIN \"public\".pos_config ON \"public\".pos_session.config_id = \"public\".pos_config.\"id\" WHERE CAST(\"public\".pos_session.stop_at AS DATE) =" .$to_date. " GROUP BY \"public\".pos_session.\"id\", CAST(\"public\".pos_session.stop_at AS DATE), \"public\".pos_config.\"name\" ORDER BY CAST(\"public\".pos_session.stop_at AS DATE) ASC, \"public\".pos_config.\"name\" ASC ";
        $json_array[] = $row;

        if (!$conn) {
                echo "An error occurred.\n";
                exit;
        }
        $result = pg_query($conn,$str_query);
                if (!$result) {
                        echo "An error Query.\n";
                        exit;   
                }

  while ($row = pg_fetch_row($result)) {
      $json_array[] = $row;
  }
  return $json_array[];
    }
    
   function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/v2/bot/message/push";

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($ch);
      curl_close ($ch);
   }
   exit;
?>