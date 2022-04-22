<?php

///// 사용자 코드 계산

$userl=$_POST["userl"];
$usercode=$_POST["usercode"];

/*
https://github.com/Jaagrav/CodeX
C++	cpp
C	c
C#	cs
Java	java
Python	py
Ruby	rb
Kotlin	kt
Swift	swift
*/
//$usercode="print('100')";
//echo("언어:".$userl);
//echo("코드:".$usercode);

$data = json_encode(array("clientId"=>"5e810c70be5dc4a54f1202dd7c330368"
,"clientSecret"=>"746d5245090cca90922364b6fababa41cc21ca4453629b846645dcdd37a404d0"
,"code"=> $usercode
,"stdin"=>""
,"language"=>$userl)
);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://codexweb.netlify.app/.netlify/functions/enforceCode",
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
} else {
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
