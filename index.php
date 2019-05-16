<?php 
	/*Get Data From POST Http Request*/
	$datas = file_get_contents('php://input');
	/*Decode Json From LINE Data Body*/
	$deCode = json_decode($datas,true);

	file_put_contents('log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

	$replyToken = $deCode['events'][0]['replyToken'];

	$messages = [];
	$messages['replyToken'] = $replyToken;
	$messages['messages'][0] = getFormatTextMessage("สวัสดี");

	$encodeJson = json_encode($messages);

	$LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
  	$LINEDatas['token'] = "q9EwAMLiNHd6qdeVCKe2kWJoflo3kxWPRXi7XGhivIg2YLA156SYWM0ULAYf13QkbaoNnMVpuDswiBaNgDr+hCcr0FmBgl9JnDMbYi5pGvR0WF75BXsulz7uSijD4yQ28J57kRUpzDMpR3r3RgOWzgdB04t89/1O/w1cDnyilFU=";
  	$results = sentMessage($encodeJson,$LINEDatas);

	/*Return HTTP Request 200*/
	http_response_code(200);

    function getDB()
    {
        $conn_string = "host=96.30.79.11 port=5432 dbname=LIV user=odoo password=odoo";
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
        return $json_array;
    }

	function getFormatTextMessage($text)
	{
		$datas = [];
		$datas['type'] = 'text';
		$datas['text'] = $text;

		return $datas;
	}

	function sentMessage($encodeJson,$datas)
	{
		$datasReturn = [];
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $datas['url'],
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $encodeJson,
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Bearer ".$datas['token'],
		    "cache-control: no-cache",
		    "content-type: application/json; charset=UTF-8",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		    $datasReturn['result'] = 'E';
		    $datasReturn['message'] = $err;
		} else {
		    if($response == "{}"){
			$datasReturn['result'] = 'S';
			$datasReturn['message'] = 'Success';
		    }else{
			$datasReturn['result'] = 'E';
			$datasReturn['message'] = $response;
		    }
		}

		return $datasReturn;
	}
?>