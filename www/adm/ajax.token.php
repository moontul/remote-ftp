<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/json.lib.php');

set_session('ss_admin_token', '');

$error = admin_referer_check(true);

//$referer = isset($_SERVER['HTTP_REFERER']) ? trim($_SERVER['HTTP_REFERER']) : '';
//echo("HTTP_REFERER:".$_SERVER['HTTP_REFERER']."<br>");

if($error)
    die(json_encode(array('error'=>$error, 'url'=>G5_URL)));

$token = get_admin_token();

die(json_encode(array('error'=>'', 'token'=>$token, 'url'=>'')));
