<?php
include_once('./_common.php');

$code=$_REQUEST["code"];
$list=$_REQUEST["list"];
$mb_id=$_REQUEST["mb_id"];
$fromcbt=$_REQUEST["fromcbt"];

if($is_admin){
  $sql="delete from tb_answerlog where code='$code' and list='$list' and mb_id='$mb_id' and fromcbt='$fromcbt'";
  echo($sql);
  sql_query($sql);
}
goto_url("a_list_cbt.php");
?>
