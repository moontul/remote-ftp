<?php
//include_once('./_common.php');
//컴파일 수 얼마나 남았나 계산
/*
$data = json_encode(array("clientId"=>"5e810c70be5dc4a54f1202dd7c330368"
,"clientSecret"=>"746d5245090cca90922364b6fababa41cc21ca4453629b846645dcdd37a404d0"
,"script"=> "$usercode"
,"stdin"=>""
,"language"=>"$userl","versionIndex"=>"0"));

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.jdoodle.com/v1/credit-spent",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array("cache-control: no-cache","content-type: application/json"),
    CURLOPT_SSL_VERIFYPEER => false
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
}
else {
    $arr = json_decode($response, true);
    //print_r($arr);
    foreach($arr as  $key => $val){
      if($key=="used"){
      echo($key." : ".$val."<hr>");
      }
    }
}
*/

///// 사용자 코드 계산

$userl=$_POST["userl"];
$usercode=$_POST["usercode"];

//$usercode="print('100')";
//echo("언어:".$userl);
//echo("코드:".$usercode);

$data = json_encode(array("clientId"=>"5e810c70be5dc4a54f1202dd7c330368"
,"clientSecret"=>"746d5245090cca90922364b6fababa41cc21ca4453629b846645dcdd37a404d0"
,"script"=> $usercode
,"stdin"=>""
,"language"=>"python3","versionIndex"=>"0"));

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.jdoodle.com/v1/execute",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array("cache-control: no-cache","content-type: application/json"),
    CURLOPT_SSL_VERIFYPEER => false
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
}
else {
    $arr = json_decode($response, true);
    //print_r($arr);
    foreach($arr as  $key => $val){
      if($key=="output"){
        echo($val);
      }
    }
}


/* 아웃풋 예제
{
"output":"\nTraceback (most recent call last):\n File \"jdoodle.py\", line 1, in \n print(hello);\nNameError: name 'hello' is not defined\n"
,"statusCode":200
,"memory":"5340"
,"cpuTime":"0.01"
}
*/


?>
