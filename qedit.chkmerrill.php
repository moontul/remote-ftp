<?php  @include_once('./_common.php');
$sentence=$_POST['sentence'];

if($sentence==""){

}else{
  $sentence=str_replace("'","",$sentence);
  $sentence=str_replace('"','',$sentence);
  $sentence=str_replace('\\','',$sentence);

  $data = array(
      'accesskey' => 'pangpang.gabia.io',
      'sentence' => $sentence,
  );

  $url = "https://pang.gabia.io/result"; // . "?" , http_build_query($data, '', );

  $ch = curl_init();                                 //curl 초기화
  curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
  curl_setopt($ch, CURLOPT_POST, true);              //true시 post 전송
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);       //POST data

  $response = curl_exec($ch);
  curl_close($ch);

  ///////$response="{\"words\":\"단어들\",   \"xsum\":[{\"사실\":0.1}],   \"ysum\":\"단어들\",  \"x\":\"사실\",\"y\":\"발견\"}";

  echo($response);

}
/*
$data = array(
    'test' => 'test'
);

$url = "https://www.naver.com";

$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);       //POST data
curl_setopt($ch, CURLOPT_POST, true);              //true시 post 전송

$response = curl_exec($ch);
curl_close($ch);

return $response;
$response = curl_exec ($ch);

var_dump($response);        //결과 값 출력
print_r(curl_getinfo($ch)); //모든 정보 출력
echo curl_errno($ch);       //에러 정보 출력
echo curl_error($ch);       //에러 정보 출력

*/
