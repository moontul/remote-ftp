<?php include_once('./_common.php');

$list=$_POST["list"];

$a_qcode=$_POST["qcode_a"];

foreach($a_qcode as $key => $val){

  $sql="insert into tb_pageq(list, qcode) value('$list', '$val')";
  sql_query($sql);
  echo($key. $val);

}

echo("<script>parent.location.reload();</script>");
?>
