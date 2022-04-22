<?php
define('G5_IS_ADMIN', true);
include_once ('../../common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');

//$conn = new mysqli("localhost", "pangpangolive", "pangpang@1212", "pangpangolive", "3306");
//mysqli_query($conn, "set names utf8");


$sv = isset($_REQUEST['sv']) ? get_search_string($_REQUEST['sv']) : '';
$st = (isset($_REQUEST['st']) && $st) ? substr(get_search_string($_REQUEST['st']), 0, 12) : '';

if( isset($token) ){
    $token = @htmlspecialchars(strip_tags($token), ENT_QUOTES);
}

add_stylesheet('<link rel="stylesheet" href="'.G5_SMS5_ADMIN_URL.'/css/sms5.css">', 0);
