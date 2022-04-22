<?php include_once('./_common.php');
$list=$_POST["list"];

$qnums=$_POST["qnums"];
$qcodes=$_POST["qcodes"];

$a_qnums=explode(",",$qnums);
$a_qcodes=explode(",",$qcodes);
for($i=0;$i<count($a_qcodes);$i++){
  $sql="insert into tb_pageq(pqnum, list, qcode) values('$a_qnums[$i]', '$list', '$a_qcodes[$i]')";
  sql_query($sql);
}

?>
