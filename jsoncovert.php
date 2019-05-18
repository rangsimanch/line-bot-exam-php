<?php
require_once("dbconnect.php");

function DecodeArrJSONtoArrList($jsonArray){
    $ArrData = json_decode($jsonArray,true);
    return $ArrData;
}