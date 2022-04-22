<?php  @include_once('./_common.php');

$qcode=$_REQUEST["qcode"];

$merrillx=$_REQUEST["merrillx"];
$merrilly=$_REQUEST["merrilly"];
$merrilljson=$_REQUEST["merrilljson"];

$sql="update tb_question set merrillx='$merrillx', merrilly='$merrilly', merrilljson='$merrilljson' where qcode='$qcode'";
echo($sql);
sql_query($sql);

?>
