<?php include_once('./_common.php');
$list=$_POST["list"];

$qlists=$_POST["qlists"];

$a_qlists=explode(",",$qlists);
for($i=0;$i<count($a_qlists);$i++){

  //이미 있으면 인서트하지 않음
  $sql="select count(*) cnt from tb_elist where list='$list' and exam_list='$a_qlists[$i]'";
  $result=sql_fetch($sql);
  if($result["cnt"]==0){
    $sql="insert into tb_elist(list, exam_list) values('$list', '$a_qlists[$i]')";
    sql_query($sql);
  }
}
?>
