<?php

//SensorFlare PHP Script
//This script is used at Patras' Hackerspace in order to get data (such as temperature, humidity, etc) 
//from sensors that are connected to a NinjaBlock and connect to SensorFlare

header('Content-type: application/json');

//function to check if a key exists and return its value
function check_get_value($key_name, $array_obj)
{
	$val="";

	if(array_key_exists($key_name, $array_obj))
		$val=$array_obj[$key_name];

	return $val;
}
		
$type="";

if(isset($_GET["type"]))
	$type=$_GET["type"];

$response = array();
$success="true";

//used for Jarvis
$door="http://192.168.1.41/report/?limit=1&json&nobutton";
//used for Logitech Media Center
$music="http://192.168.1.5:9000/jsonrpc.js";
$music_req_data = '{"id":1,"method":"slim.request","params":["b8:27:eb:d3:92:62",["status","-",1,"tags:uB"]]}';
//used for sensorflare.com
$temperatureSensorId=""; //temperature sensor id, as appeared on sensorflare's dashboard, e.g. 0112AA000635/0301/0/31
$humiditySensorId=""; //humidity sensor id, as appeared on sensorflare's dashboard
$authUsername=""; //enter your username here
$authPassword=""; //enter your password here
$sensorsApiURLpart1="http://www.sensorflare.com/api/resource/"; //api URL
$sensorsApiURLpart2="/report/latest"; //get the latest values.
$octoprintApiURLpart1="http://localhost/api/job"; //api URL
$octoprintApiKey=""; //api URL
$octoprintApiURLpart2="?apiKey=".$octoprintApiKey; //api URL

$ch = curl_init();

if($type=="music")
{
	$url=$music;
	$ispost=1;
	curl_setopt($ch,CURLOPT_POSTFIELDS, $music_req_data);
}
elseif($type=="door")
{
	$url=$door;
	$ispost=0;
}
elseif($type=="temperature")
{
	$url=$sensorsApiURLpart1.$temperatureSensorId.$sensorsApiURLpart2;
	$ispost=0;
	//cURL parameters for authentication
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$authUsername:$authPassword");
}
elseif($type=="humidity")
{
	$url=$sensorsApiURLpart1.$humiditySensorId.$sensorsApiURLpart2;
	$ispost=0;
	//cURL parameters for authentication
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$authUsername:$authPassword");
}
elseif($type=="printer")
{
	$url=$octoprintApiURLpart1.$octoprintApiURLpart2;
	$ispost=0;
}

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, $ispost);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//execute post
$result = curl_exec($ch);

$error_no = curl_errno($ch);


//close connection
curl_close($ch);

if ($error_no==0)
{
	$resp_obj=json_decode($result, true);
}
else
{
	$success="false";
}

if($type=="door" && $error_no==0)
{
	$response['user']=$resp_obj['events'][0]['name'];
	$response['time']=$resp_obj['events'][0]['t'];
}
elseif($type=="music" && $error_no==0)
{
	$response['song']=(isset($resp_obj['result']['current_title'])?$resp_obj['result']['current_title'].', ':' ').$resp_obj['result']['playlist_loop'][0]['title'];
}
elseif($type=="temperature" || $type=="humidity" && $error_no==0)
{
	$response['value']=check_get_value('latest', $resp_obj);
	$response['time']=check_get_value('latestTime', $resp_obj);
}
elseif($type=="printer" && $error_no==0)
{
	$response['printTimeLeft']=check_get_value('printTimeLeft', check_get_value('progress', $resp_obj));
	$response['estimatedPrintTime']=check_get_value('estimatedPrintTime', check_get_value('job', $resp_obj));
	$response['file']=check_get_value('name', check_get_value('file', check_get_value('job', $resp_obj)));
	$response['state']=check_get_value('state', $resp_obj);
	$response['url']=$url;
}

echo json_encode(array("data"=>$response, "success"=>$success, "error"=>$error_no));

?>