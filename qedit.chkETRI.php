<?php
$openApiURL = "http://aiopen.etri.re.kr:8000/WiseWWN/WordRel";
$accessKey = "3ab4aae1-a2da-40e4-a2bf-ef675abbcc3e";
$firstWord = "창조";
$firstSenseId = ""; //FIRST_SENSE_ID
$secondWord = "제작";
$secondSenseId = ""; //SECOND_SECSE_ID

$request = array(
    "access_key" => $accessKey,
    "argument" => array (
        "first_word" => $firstWord, //"first_sense_id" => $firstSenseId,
        "second_word" => $secondWord, //"second_sense_id" => $secondSenseId
    )
);

try {
    $server_output = "";
    $ch = curl_init();
    $header = array(
        "Content-Type:application/json; charset=UTF-8",
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_URL, $openApiURL);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode ( $request) );

    $server_output = curl_exec ($ch);
    if($server_output === false) {
        echo "Error Number:".curl_errno($ch)."\n";
        echo "Error String:".curl_error($ch)."\n";
    }

    curl_close ($ch);
} catch ( Exception $e ) {
    echo $e->getMessage ();
}

echo "result = " . var_dump($server_output);
?>
