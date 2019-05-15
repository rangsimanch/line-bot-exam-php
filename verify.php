<?php
$access_token = 'q9EwAMLiNHd6qdeVCKe2kWJoflo3kxWPRXi7XGhivIg2YLA156SYWM0ULAYf13QkbaoNnMVpuDswiBaNgDr+hCcr0FmBgl9JnDMbYi5pGvR0WF75BXsulz7uSijD4yQ28J57kRUpzDMpR3r3RgOWzgdB04t89/1O/w1cDnyilFU=';


$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;